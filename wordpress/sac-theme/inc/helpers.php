<?php
/**
 * Template helpers: settings, images, icons, menus and content getters.
 *
 * Every getter reads from WordPress first (SAC Companion custom post types and
 * the SAC Settings screen) and falls back to the original content in
 * inc/defaults.php, so the site never renders empty sections.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

/** Saved settings merged over the defaults. */
function sac_settings() {
	static $settings = null;
	if ( null === $settings ) {
		$saved    = get_option( 'sac_settings', array() );
		$settings = array_merge( sac_default_settings(), is_array( $saved ) ? $saved : array() );
	}
	return $settings;
}

/** Raw setting value. Empty strings fall back to the default so a cleared field never blanks the design. */
function sac_opt( $key ) {
	$settings = sac_settings();
	$value    = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
	if ( '' === $value || array() === $value ) {
		$defaults = sac_default_settings();
		$value    = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}
	return $value;
}

/** Echo an escaped setting. */
function sac_e( $key ) {
	echo esc_html( sac_opt( $key ) );
}

/** URL of a bundled theme image (assets/images/...). */
function sac_asset_image( $relative ) {
	return get_theme_file_uri( 'assets/images/' . ltrim( $relative, '/' ) );
}

/**
 * Resolve an image reference to a URL.
 * Accepts an attachment ID, an "img:key" default reference, or a URL.
 */
function sac_image_url( $ref, $size = 'full' ) {
	if ( is_numeric( $ref ) && (int) $ref > 0 ) {
		$url = wp_get_attachment_image_url( (int) $ref, $size );
		if ( $url ) {
			return $url;
		}
	}
	if ( is_string( $ref ) && 0 === strpos( $ref, 'img:' ) ) {
		$images = sac_default_images();
		$key    = substr( $ref, 4 );
		if ( isset( $images[ $key ] ) ) {
			return sac_asset_image( $images[ $key ] );
		}
	}
	if ( is_string( $ref ) && preg_match( '#^(https?:)?//|^/#', $ref ) ) {
		return $ref;
	}
	return '';
}

/** Image URL for a setting, falling back to the default image if the attachment was deleted. */
function sac_opt_image( $key, $size = 'full' ) {
	$url = sac_image_url( sac_opt( $key ), $size );
	if ( ! $url ) {
		$defaults = sac_default_settings();
		$url      = isset( $defaults[ $key ] ) ? sac_image_url( $defaults[ $key ], $size ) : '';
	}
	return $url;
}

/** Turn "/contact" style paths into site URLs; leave absolute URLs, anchors, tel: and mailto: alone. */
function sac_link( $path ) {
	$path = trim( (string) $path );
	if ( '' === $path ) {
		return home_url( '/' );
	}
	if ( 0 === strpos( $path, '/' ) && 0 !== strpos( $path, '//' ) ) {
		return home_url( $path );
	}
	return $path;
}

/** Inline Lucide icon. */
function sac_icon( $name, $class = 'h-4 w-4' ) {
	static $library = null;
	if ( null === $library ) {
		$library = sac_icon_library();
	}
	if ( ! isset( $library[ $name ] ) ) {
		$name = 'check';
	}
	return sprintf(
		'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="%s" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $class ),
		$library[ $name ] // Static, trusted markup from inc/icon-library.php.
	);
}

/** Icon choices for admin dropdowns. */
function sac_icon_choices() {
	return array_keys( sac_icon_library() );
}

/** Split newline (or array) values into a clean list. */
function sac_lines( $value ) {
	if ( is_array( $value ) ) {
		return array_values( array_filter( array_map( 'trim', $value ), 'strlen' ) );
	}
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $value ) ), 'strlen' ) );
}

/** Split comma separated values. */
function sac_csv( $value ) {
	if ( is_array( $value ) ) {
		return $value;
	}
	return array_values( array_filter( array_map( 'trim', explode( ',', (string) $value ) ), 'strlen' ) );
}

/** URL of one of the seven pages by slug, even before the importer has run. */
function sac_page_url( $slug ) {
	if ( 'home' === $slug ) {
		return home_url( '/' );
	}
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/** Slug of the current page among the seven known pages. */
function sac_current_slug() {
	if ( is_front_page() ) {
		return 'home';
	}
	$post = get_queried_object();
	return ( $post instanceof WP_Post ) ? $post->post_name : '';
}

/** Page header values (eyebrow / heading / subtitle) for the current page. */
function sac_page_header_data() {
	$id       = get_queried_object_id();
	$slug     = sac_current_slug();
	$defaults = sac_default_pages();
	$fallback = isset( $defaults[ $slug ] ) ? $defaults[ $slug ] : array( 'eyebrow' => '', 'heading' => '', 'subtitle' => '' );
	$data     = array();
	foreach ( array( 'eyebrow', 'heading', 'subtitle' ) as $field ) {
		$value          = $id ? get_post_meta( $id, '_sac_' . $field, true ) : '';
		$data[ $field ] = '' !== $value ? $value : $fallback[ $field ];
	}
	if ( '' === $data['heading'] ) {
		$data['heading'] = get_the_title( $id );
	}
	return $data;
}

/**
 * Menu items for a location as [label, url, active] arrays.
 * Falls back to the original navigation when no menu is assigned.
 */
function sac_menu_items( $location ) {
	$items     = array();
	$locations = get_nav_menu_locations();
	$current   = untrailingslashit( strtok( home_url( add_query_arg( array() ) ), '?#' ) );

	if ( ! empty( $locations[ $location ] ) ) {
		$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $menu_items ) {
			foreach ( $menu_items as $item ) {
				if ( (int) $item->menu_item_parent ) {
					continue;
				}
				$url     = $item->url;
				$active  = ( 'post_type' === $item->type && (int) $item->object_id === get_queried_object_id() )
					|| ( untrailingslashit( strtok( $url, '?#' ) ) === $current && false === strpos( $url, '#' ) );
				$items[] = array(
					'label'  => $item->title,
					'url'    => $url,
					'active' => $active,
					'target' => $item->target,
				);
			}
			return $items;
		}
	}

	$menus = sac_default_menus();
	if ( empty( $menus[ $location ] ) ) {
		return $items;
	}
	foreach ( $menus[ $location ] as $entry ) {
		list( $label, $target ) = $entry;
		$is_path = 0 === strpos( $target, '/' );
		$url     = $is_path ? sac_link( $target ) : sac_page_url( $target );
		$items[] = array(
			'label'  => $label,
			'url'    => $url,
			'active' => ! $is_path && sac_current_slug() === $target,
			'target' => '',
		);
	}
	return $items;
}

/** Query a companion-plugin post type, or return null if unavailable/empty. */
function sac_query_posts( $post_type, $args = array() ) {
	if ( ! post_type_exists( $post_type ) ) {
		return null;
	}
	$posts = get_posts(
		array_merge(
			array(
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'numberposts'      => -1,
				'orderby'          => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
				'suppress_filters' => false,
			),
			$args
		)
	);
	return $posts ? $posts : null;
}

function sac_meta( $post_id, $key ) {
	return get_post_meta( $post_id, '_sac_' . $key, true );
}

function sac_thumb( $post_id, $fallback = '', $size = 'large' ) {
	$url = get_the_post_thumbnail_url( $post_id, $size );
	return $url ? $url : $fallback;
}

function sac_get_solutions() {
	$posts = sac_query_posts( 'sac_solution' );
	if ( $posts ) {
		return array_map(
			function ( $p ) {
				return array(
					'anchor'        => sac_meta( $p->ID, 'anchor' ) ? sac_meta( $p->ID, 'anchor' ) : $p->post_name,
					'icon'          => sac_meta( $p->ID, 'icon' ),
					'title'         => get_the_title( $p ),
					'short_label'   => sac_meta( $p->ID, 'short_label' ) ? sac_meta( $p->ID, 'short_label' ) : get_the_title( $p ),
					'summary'       => sac_meta( $p->ID, 'summary' ),
					'details_title' => sac_meta( $p->ID, 'details_title' ),
					'details'       => sac_lines( sac_meta( $p->ID, 'details' ) ),
				);
			},
			$posts
		);
	}
	return sac_default_solutions();
}

/** Industry filters as slug => name, in admin-defined order. */
function sac_get_industries() {
	if ( taxonomy_exists( 'sac_industry' ) ) {
		$terms = get_terms(
			array(
				'taxonomy'   => 'sac_industry',
				'hide_empty' => true,
				'meta_key'   => '_sac_order', // phpcs:ignore WordPress.DB.SlowDBQuery
				'orderby'    => 'meta_value_num',
				'order'      => 'ASC',
			)
		);
		if ( ! is_wp_error( $terms ) && $terms ) {
			$out = array();
			foreach ( $terms as $term ) {
				$out[ $term->slug ] = $term->name;
			}
			return $out;
		}
	}
	return sac_default_industries();
}

function sac_get_projects() {
	$posts = sac_query_posts( 'sac_project' );
	if ( $posts ) {
		$out = array();
		foreach ( $posts as $p ) {
			$terms = get_the_terms( $p, 'sac_industry' );
			$term  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
			$out[] = array(
				'title'         => get_the_title( $p ),
				'location'      => sac_meta( $p->ID, 'location' ),
				'industry'      => $term ? $term->slug : '',
				'industry_name' => $term ? $term->name : '',
				'image'         => sac_thumb( $p->ID ),
				'image_alt'     => get_post_meta( get_post_thumbnail_id( $p ), '_wp_attachment_image_alt', true ),
				'tags'          => sac_csv( sac_meta( $p->ID, 'tags' ) ),
			);
		}
		return $out;
	}
	$industries = sac_default_industries();
	$images     = sac_default_images();
	return array_map(
		function ( $row ) use ( $industries, $images ) {
			return array(
				'title'         => $row[0],
				'location'      => $row[1],
				'industry'      => $row[2],
				'industry_name' => $industries[ $row[2] ],
				'image'         => sac_asset_image( $images[ $row[3] ] ),
				'image_alt'     => '',
				'tags'          => array( $row[4] ),
			);
		},
		sac_default_projects()
	);
}

function sac_get_leaders() {
	$posts = sac_query_posts( 'sac_leader' );
	if ( $posts ) {
		return array_map(
			function ( $p ) {
				return array(
					'name'  => get_the_title( $p ),
					'role'  => sac_meta( $p->ID, 'role' ),
					'image' => sac_thumb( $p->ID ),
					'bio'   => wp_kses_post( $p->post_content ),
				);
			},
			$posts
		);
	}
	$images = sac_default_images();
	return array_map(
		function ( $l ) use ( $images ) {
			return array(
				'name'  => $l['name'],
				'role'  => $l['role'],
				'image' => sac_asset_image( $images[ $l['image'] ] ),
				'bio'   => esc_html( $l['bio'] ),
			);
		},
		sac_default_leaders()
	);
}

function sac_get_pillars() {
	$posts = sac_query_posts( 'sac_pillar' );
	if ( $posts ) {
		return array_map(
			function ( $p ) {
				return array(
					'icon'  => sac_meta( $p->ID, 'icon' ),
					'title' => get_the_title( $p ),
					'body'  => wp_strip_all_tags( $p->post_content ),
				);
			},
			$posts
		);
	}
	return sac_default_pillars();
}

function sac_get_jobs() {
	$posts = sac_query_posts( 'sac_job' );
	if ( $posts ) {
		return array_map(
			function ( $p ) {
				return array(
					'title'            => get_the_title( $p ),
					'badge'            => sac_meta( $p->ID, 'badge' ),
					'location'         => sac_meta( $p->ID, 'location' ),
					'experience'       => sac_meta( $p->ID, 'experience' ),
					'department'       => sac_meta( $p->ID, 'department' ),
					'employment'       => sac_meta( $p->ID, 'employment' ),
					'knowledge'        => sac_meta( $p->ID, 'knowledge' ),
					'skills'           => sac_csv( sac_meta( $p->ID, 'skills' ) ),
					'responsibilities' => sac_lines( sac_meta( $p->ID, 'responsibilities' ) ),
				);
			},
			$posts
		);
	}
	// Once the plugin is active an empty list is a deliberate "no openings" state.
	return post_type_exists( 'sac_job' ) && get_option( 'sac_import_done' ) ? array() : sac_default_jobs();
}

function sac_get_clients() {
	$posts = sac_query_posts( 'sac_client' );
	if ( $posts ) {
		return array_map(
			function ( $p ) {
				return array(
					'name' => get_the_title( $p ),
					'logo' => sac_thumb( $p->ID, '', 'medium' ),
					'url'  => sac_meta( $p->ID, 'url' ),
				);
			},
			$posts
		);
	}
	return array_map(
		function ( $name ) {
			return array( 'name' => $name, 'logo' => '', 'url' => '' );
		},
		sac_default_clients()
	);
}

/** Shared section-heading eyebrow markup. */
function sac_eyebrow( $text, $class = 'text-sm font-semibold uppercase tracking-[0.2em] text-primary' ) {
	if ( '' === trim( (string) $text ) ) {
		return;
	}
	printf( '<p class="%s">%s</p>', esc_attr( $class ), esc_html( $text ) );
}

/** Opening tag for a scroll-reveal wrapper (replaces the framer-motion <Reveal>). */
function sac_reveal( $index = 0, $class = '', $tag = 'div' ) {
	printf(
		'<%1$s class="sac-reveal %2$s" style="--i:%3$d">',
		tag_escape( $tag ),
		esc_attr( $class ),
		(int) $index
	);
}
