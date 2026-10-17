<?php
/**
 * One-click importer (SAC Website → Import & Setup).
 *
 * Seeds pages, menus, media, settings and every content type from the theme's
 * original-content defaults. Safe to run more than once (already-imported items
 * are skipped) and fully reversible: everything it creates is tagged and the
 * options it changes are backed up.
 *
 * Existing pages with the same slug (e.g. an old "about" page) are reused, never
 * modified — the SAC templates are applied automatically by slug.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_menu',
	function () {
		add_submenu_page( 'sac-dashboard', __( 'Import & Setup', 'sac' ), __( 'Import & Setup', 'sac' ), 'manage_options', 'sac-import', 'sac_render_import_page' );
	},
	20
);

/** Find an item created by a previous import run. */
function sac_find_seeded( $post_type, $seed ) {
	$found = get_posts(
		array(
			'post_type'        => $post_type,
			'post_status'      => 'any',
			'numberposts'      => 1,
			'fields'           => 'ids',
			'meta_key'         => '_sac_seed', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'       => $seed, // phpcs:ignore WordPress.DB.SlowDBQuery
			'suppress_filters' => true,
		)
	);
	return $found ? (int) $found[0] : 0;
}

function sac_insert_seeded( $seed, $postarr, $meta = array() ) {
	$existing = sac_find_seeded( $postarr['post_type'], $seed );
	if ( $existing ) {
		return array( $existing, false );
	}
	$id = wp_insert_post( wp_slash( array_merge( array( 'post_status' => 'publish' ), $postarr ) ), true );
	if ( is_wp_error( $id ) ) {
		return array( 0, false );
	}
	update_post_meta( $id, '_sac_seed', $seed );
	update_post_meta( $id, '_sac_imported', 1 );
	foreach ( $meta as $key => $value ) {
		update_post_meta( $id, '_sac_' . $key, wp_slash( $value ) );
	}
	return array( $id, true );
}

/** Copy a bundled theme image into the Media Library (once) and return its attachment ID. */
function sac_import_image( $key, &$log ) {
	$images = sac_default_images();
	if ( ! isset( $images[ $key ] ) ) {
		return 0;
	}
	$existing = sac_find_seeded( 'attachment', 'img:' . $key );
	if ( $existing ) {
		return $existing;
	}
	$source = get_theme_file_path( 'assets/images/' . $images[ $key ] );
	if ( ! is_readable( $source ) ) {
		$log[] = sprintf( 'Missing image file: %s', $images[ $key ] );
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// .jfif is JPEG data with an extension WordPress does not allow; keep the name, use .jpg.
	$name = preg_replace( '/\.jfif$/i', '.jpg', basename( $images[ $key ] ) );
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		$log[] = sprintf( 'Could not copy image: %s', $name );
		return 0;
	}
	$id = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), 0 );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		$log[] = sprintf( 'Image %1$s: %2$s', $name, $id->get_error_message() );
		return 0;
	}
	update_post_meta( $id, '_sac_seed', 'img:' . $key );
	update_post_meta( $id, '_sac_imported', 1 );
	return (int) $id;
}

function sac_run_import( $options ) {
	$log   = array();
	$state = get_option( 'sac_import_state', array() );
	$state = is_array( $state ) ? $state : array();

	if ( empty( $state['backup'] ) ) {
		$state['backup'] = array(
			'show_on_front'      => get_option( 'show_on_front' ),
			'page_on_front'      => get_option( 'page_on_front' ),
			'permalink_structure'=> get_option( 'permalink_structure' ),
			'sac_settings'       => get_option( 'sac_settings', array() ),
			'nav_menu_locations' => get_theme_mod( 'nav_menu_locations', array() ),
		);
	}
	$state += array( 'menus' => array(), 'terms' => array() );

	// Long imports on shared hosting.
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}

	// 1. Media.
	$media = array();
	foreach ( array_keys( sac_default_images() ) as $key ) {
		$media[ $key ] = sac_import_image( $key, $log );
	}
	$log[] = sprintf( 'Media Library: %d images ready.', count( array_filter( $media ) ) );

	// 2. Settings — fill only fields that are still empty, never overwrite edits.
	$saved = get_option( 'sac_settings', array() );
	$saved = is_array( $saved ) ? $saved : array();
	foreach ( sac_default_settings() as $key => $default ) {
		if ( isset( $saved[ $key ] ) && '' !== $saved[ $key ] && array() !== $saved[ $key ] ) {
			continue;
		}
		if ( is_string( $default ) && 0 === strpos( $default, 'img:' ) ) {
			$img           = substr( $default, 4 );
			$saved[ $key ] = ! empty( $media[ $img ] ) ? $media[ $img ] : '';
		} else {
			$saved[ $key ] = $default;
		}
	}
	update_option( 'sac_settings', $saved );
	$log[] = 'Site Settings filled with the original content.';

	// 3. Pages.
	$page_ids = array();
	foreach ( sac_default_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $existing && ! get_post_meta( $existing->ID, '_sac_imported', true ) ) {
			$page_ids[ $slug ] = $existing->ID;
			$log[]             = sprintf( 'Reused existing page "%s" (content left unchanged).', $slug );
			continue;
		}
		list( $id, $created ) = sac_insert_seeded(
			'page:' . $slug,
			array(
				'post_type'  => 'page',
				'post_title' => $page['title'],
				'post_name'  => $slug,
			),
			array(
				'eyebrow'         => $page['eyebrow'],
				'heading'         => $page['heading'],
				'subtitle'        => $page['subtitle'],
				'seo_title'       => $page['seo_title'],
				'seo_description' => $page['seo_description'],
			)
		);
		if ( $id && $created && $page['template'] ) {
			update_post_meta( $id, '_wp_page_template', $page['template'] );
		}
		$page_ids[ $slug ] = $id;
	}
	$log[] = sprintf( 'Pages ready: %s.', implode( ', ', array_keys( array_filter( $page_ids ) ) ) );

	if ( ! empty( $options['front'] ) && ! empty( $page_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
		$log[] = 'Homepage set to the "Home" page.';
	}
	if ( ! empty( $options['permalinks'] ) && '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		$log[] = 'Permalinks set to "Post name" so URLs like /solutions/ work.';
	}

	// 4. Industries.
	$order = 0;
	foreach ( sac_default_industries() as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'sac_industry' );
		if ( ! $term ) {
			$res = wp_insert_term( $name, 'sac_industry', array( 'slug' => $slug ) );
			if ( ! is_wp_error( $res ) ) {
				$state['terms'][] = (int) $res['term_id'];
				update_term_meta( $res['term_id'], '_sac_order', $order );
			}
		}
		++$order;
	}

	// 5. Content types.
	$counts = array();
	foreach ( sac_default_solutions() as $i => $s ) {
		list( , $created ) = sac_insert_seeded(
			'solution:' . $s['anchor'],
			array( 'post_type' => 'sac_solution', 'post_title' => $s['title'], 'menu_order' => $i ),
			array(
				'anchor'        => $s['anchor'],
				'icon'          => $s['icon'],
				'short_label'   => $s['short_label'],
				'summary'       => $s['summary'],
				'details_title' => $s['details_title'],
				'details'       => implode( "\n", $s['details'] ),
			)
		);
		$counts['solutions'] = ( isset( $counts['solutions'] ) ? $counts['solutions'] : 0 ) + ( $created ? 1 : 0 );
	}

	foreach ( sac_default_projects() as $i => $p ) {
		list( $id, $created ) = sac_insert_seeded(
			'project:' . sanitize_title( $p[0] . '-' . $p[1] ),
			array( 'post_type' => 'sac_project', 'post_title' => trim( $p[0] ), 'menu_order' => $i ),
			array( 'location' => $p[1], 'tags' => $p[4] )
		);
		if ( $id && $created ) {
			wp_set_object_terms( $id, $p[2], 'sac_industry' );
			if ( ! empty( $media[ $p[3] ] ) ) {
				set_post_thumbnail( $id, $media[ $p[3] ] );
			}
		}
		$counts['projects'] = ( isset( $counts['projects'] ) ? $counts['projects'] : 0 ) + ( $created ? 1 : 0 );
	}

	foreach ( sac_default_leaders() as $i => $l ) {
		list( $id, $created ) = sac_insert_seeded(
			'leader:' . sanitize_title( $l['name'] ),
			array( 'post_type' => 'sac_leader', 'post_title' => $l['name'], 'post_content' => $l['bio'], 'menu_order' => $i ),
			array( 'role' => $l['role'] )
		);
		if ( $id && $created && ! empty( $media[ $l['image'] ] ) ) {
			set_post_thumbnail( $id, $media[ $l['image'] ] );
		}
		$counts['leaders'] = ( isset( $counts['leaders'] ) ? $counts['leaders'] : 0 ) + ( $created ? 1 : 0 );
	}

	foreach ( sac_default_pillars() as $i => $pl ) {
		list( , $created ) = sac_insert_seeded(
			'pillar:' . sanitize_title( $pl['title'] ),
			array( 'post_type' => 'sac_pillar', 'post_title' => $pl['title'], 'post_content' => $pl['body'], 'menu_order' => $i ),
			array( 'icon' => $pl['icon'] )
		);
		$counts['pillars'] = ( isset( $counts['pillars'] ) ? $counts['pillars'] : 0 ) + ( $created ? 1 : 0 );
	}

	foreach ( sac_default_jobs() as $i => $j ) {
		list( , $created ) = sac_insert_seeded(
			'job:' . sanitize_title( $j['title'] ),
			array( 'post_type' => 'sac_job', 'post_title' => $j['title'], 'menu_order' => $i ),
			array(
				'badge'            => $j['badge'],
				'location'         => $j['location'],
				'experience'       => $j['experience'],
				'department'       => $j['department'],
				'employment'       => $j['employment'],
				'knowledge'        => $j['knowledge'],
				'skills'           => implode( ', ', $j['skills'] ),
				'responsibilities' => implode( "\n", $j['responsibilities'] ),
			)
		);
		$counts['jobs'] = ( isset( $counts['jobs'] ) ? $counts['jobs'] : 0 ) + ( $created ? 1 : 0 );
	}

	foreach ( sac_default_clients() as $i => $name ) {
		list( , $created ) = sac_insert_seeded(
			'client:' . sanitize_title( $name ),
			array( 'post_type' => 'sac_client', 'post_title' => $name, 'menu_order' => $i )
		);
		$counts['clients'] = ( isset( $counts['clients'] ) ? $counts['clients'] : 0 ) + ( $created ? 1 : 0 );
	}
	foreach ( $counts as $type => $n ) {
		$log[] = sprintf( '%1$s: %2$d new item(s) added.', ucfirst( $type ), $n );
	}

	// 6. Menus.
	if ( ! empty( $options['menus'] ) ) {
		$names     = array(
			'primary'         => 'SAC Header',
			'footer_quick'    => 'SAC Footer — Quick Links',
			'footer_services' => 'SAC Footer — Services',
		);
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		foreach ( sac_default_menus() as $location => $items ) {
			$menu = wp_get_nav_menu_object( $names[ $location ] );
			if ( ! $menu ) {
				$menu_id = wp_create_nav_menu( $names[ $location ] );
				if ( is_wp_error( $menu_id ) ) {
					continue;
				}
				$state['menus'][] = (int) $menu_id;
				foreach ( $items as $pos => $entry ) {
					list( $label, $target ) = $entry;
					$item = array(
						'menu-item-title'    => $label,
						'menu-item-status'   => 'publish',
						'menu-item-position' => $pos + 1,
					);
					if ( 0 === strpos( $target, '/' ) ) {
						$item['menu-item-type'] = 'custom';
						$item['menu-item-url']  = home_url( $target );
					} elseif ( 'home' === $target ) {
						$item['menu-item-type'] = 'custom';
						$item['menu-item-url']  = home_url( '/' );
					} elseif ( ! empty( $page_ids[ $target ] ) ) {
						$item['menu-item-type']      = 'post_type';
						$item['menu-item-object']    = 'page';
						$item['menu-item-object-id'] = $page_ids[ $target ];
					} else {
						continue;
					}
					wp_update_nav_menu_item( $menu_id, 0, $item );
				}
				$menu = wp_get_nav_menu_object( $menu_id );
			}
			if ( $menu && empty( $locations[ $location ] ) ) {
				$locations[ $location ] = (int) $menu->term_id;
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );
		$log[] = 'Menus created and assigned (Appearance → Menus).';
	}

	update_option( 'sac_import_state', $state, false );
	update_option( 'sac_import_done', time() );
	flush_rewrite_rules();
	return $log;
}

/** Remove everything the importer created and restore the backed-up options. */
function sac_run_rollback() {
	$log   = array();
	$state = get_option( 'sac_import_state', array() );
	$types = array_merge( array( 'page', 'attachment' ), array_keys( sac_content_types() ) );
	$ids   = get_posts(
		array(
			'post_type'        => $types,
			'post_status'      => 'any',
			'numberposts'      => -1,
			'fields'           => 'ids',
			'meta_key'         => '_sac_imported', // phpcs:ignore WordPress.DB.SlowDBQuery
			'suppress_filters' => true,
		)
	);
	foreach ( $ids as $id ) {
		if ( 'attachment' === get_post_type( $id ) ) {
			wp_delete_attachment( $id, true );
		} else {
			wp_delete_post( $id, true );
		}
	}
	$log[] = sprintf( 'Removed %d imported item(s).', count( $ids ) );

	if ( ! empty( $state['menus'] ) ) {
		foreach ( $state['menus'] as $menu_id ) {
			wp_delete_nav_menu( $menu_id );
		}
	}
	if ( ! empty( $state['terms'] ) ) {
		foreach ( $state['terms'] as $term_id ) {
			wp_delete_term( $term_id, 'sac_industry' );
		}
	}
	if ( ! empty( $state['backup'] ) ) {
		$b = $state['backup'];
		update_option( 'show_on_front', $b['show_on_front'] );
		update_option( 'page_on_front', $b['page_on_front'] );
		update_option( 'permalink_structure', $b['permalink_structure'] );
		update_option( 'sac_settings', is_array( $b['sac_settings'] ) ? $b['sac_settings'] : array() );
		set_theme_mod( 'nav_menu_locations', $b['nav_menu_locations'] );
		$log[] = 'Homepage, permalink, menu and settings options restored.';
	}
	delete_option( 'sac_import_state' );
	delete_option( 'sac_import_done' );
	flush_rewrite_rules();
	return $log;
}

function sac_render_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$log = array();
	if ( isset( $_POST['sac_import_action'] ) && check_admin_referer( 'sac_import' ) ) {
		if ( ! sac_companion_theme_ready() ) {
			$log[] = 'Activate the SAC theme first.';
		} elseif ( 'import' === $_POST['sac_import_action'] ) {
			$log = sac_run_import(
				array(
					'front'      => ! empty( $_POST['sac_front'] ),
					'menus'      => ! empty( $_POST['sac_menus'] ),
					'permalinks' => ! empty( $_POST['sac_permalinks'] ),
				)
			);
		} elseif ( 'rollback' === $_POST['sac_import_action'] && ! empty( $_POST['sac_confirm'] ) ) {
			$log = sac_run_rollback();
		}
	}
	$done = get_option( 'sac_import_done' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'SAC Website — Import & Setup', 'sac' ); ?></h1>
		<?php if ( $log ) : ?>
			<div class="notice notice-success"><ul style="list-style:disc;padding-left:20px">
				<?php foreach ( $log as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'Imports the original website: 7 pages, menus, all project & leadership images into the Media Library, solutions, projects, leadership, Why SAC pillars, job openings and every text in Site Settings.', 'sac' ); ?></p>
		<p><strong><?php esc_html_e( 'Status:', 'sac' ); ?></strong>
			<?php echo $done ? esc_html( sprintf( /* translators: %s: date */ __( 'Imported on %s. Running again only adds missing items — your edits are kept.', 'sac' ), wp_date( 'd M Y, H:i', (int) $done ) ) ) : esc_html__( 'Not imported yet.', 'sac' ); ?>
		</p>
		<form method="post">
			<?php wp_nonce_field( 'sac_import' ); ?>
			<p><label><input type="checkbox" name="sac_front" value="1" checked> <?php esc_html_e( 'Set "Home" as the homepage (Settings → Reading)', 'sac' ); ?></label></p>
			<p><label><input type="checkbox" name="sac_menus" value="1" checked> <?php esc_html_e( 'Create header & footer menus', 'sac' ); ?></label></p>
			<p><label><input type="checkbox" name="sac_permalinks" value="1" checked> <?php esc_html_e( 'Use "Post name" permalinks if currently set to Plain', 'sac' ); ?></label></p>
			<p><button class="button button-primary button-hero" name="sac_import_action" value="import"><?php esc_html_e( 'Run import', 'sac' ); ?></button></p>
		</form>
		<?php if ( $done ) : ?>
			<hr>
			<h2><?php esc_html_e( 'Undo import', 'sac' ); ?></h2>
			<p><?php esc_html_e( 'Deletes only items created by this importer (including edits made to them) and restores your previous homepage, permalink, menu and settings options. Existing pages and form submissions are never touched.', 'sac' ); ?></p>
			<form method="post">
				<?php wp_nonce_field( 'sac_import' ); ?>
				<p><label><input type="checkbox" name="sac_confirm" value="1" required> <?php esc_html_e( 'I understand this cannot be undone.', 'sac' ); ?></label></p>
				<p><button class="button button-secondary" name="sac_import_action" value="rollback"><?php esc_html_e( 'Remove imported content', 'sac' ); ?></button></p>
			</form>
		<?php endif; ?>
	</div>
	<?php
}
