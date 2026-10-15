<?php
/**
 * Custom post types and the project industry taxonomy.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

/** Content types: slug => [singular, plural, dashicon, supports]. */
function sac_content_types() {
	return array(
		'sac_solution' => array( __( 'Solution', 'sac' ), __( 'Solutions', 'sac' ), 'dashicons-shield', array( 'title', 'page-attributes' ) ),
		'sac_project'  => array( __( 'Project', 'sac' ), __( 'Projects', 'sac' ), 'dashicons-building', array( 'title', 'thumbnail', 'page-attributes' ) ),
		'sac_client'   => array( __( 'Client', 'sac' ), __( 'Clients (Marquee)', 'sac' ), 'dashicons-groups', array( 'title', 'thumbnail', 'page-attributes' ) ),
		'sac_leader'   => array( __( 'Leader', 'sac' ), __( 'Leadership', 'sac' ), 'dashicons-businessperson', array( 'title', 'editor', 'thumbnail', 'page-attributes' ) ),
		'sac_pillar'   => array( __( 'Why SAC Pillar', 'sac' ), __( 'Why SAC Pillars', 'sac' ), 'dashicons-awards', array( 'title', 'editor', 'page-attributes' ) ),
		'sac_job'      => array( __( 'Job Opening', 'sac' ), __( 'Job Openings', 'sac' ), 'dashicons-id', array( 'title', 'page-attributes' ) ),
	);
}

function sac_register_content_types() {
	foreach ( sac_content_types() as $type => $def ) {
		list( $singular, $plural, $icon, $supports ) = $def;
		register_post_type(
			$type,
			array(
				'labels'              => array(
					'name'          => $plural,
					'singular_name' => $singular,
					'add_new_item'  => sprintf( /* translators: %s: item type */ __( 'Add %s', 'sac' ), $singular ),
					'edit_item'     => sprintf( /* translators: %s: item type */ __( 'Edit %s', 'sac' ), $singular ),
					'all_items'     => $plural,
					'menu_name'     => $plural,
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => 'sac-dashboard',
				'show_in_rest'        => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'menu_icon'           => $icon,
				'supports'            => $supports,
				'rewrite'             => false,
			)
		);
	}

	register_post_type(
		'sac_submission',
		array(
			'labels'       => array(
				'name'          => __( 'Form Submissions', 'sac' ),
				'singular_name' => __( 'Submission', 'sac' ),
				'edit_item'     => __( 'View Submission', 'sac' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => 'sac-dashboard',
			'show_in_rest' => false,
			'supports'     => array( 'title' ),
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
			'rewrite'      => false,
		)
	);

	register_taxonomy(
		'sac_industry',
		'sac_project',
		array(
			'labels'            => array(
				'name'          => __( 'Industries (Project filters)', 'sac' ),
				'singular_name' => __( 'Industry', 'sac' ),
				'menu_name'     => __( 'Industries', 'sac' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => false,
		)
	);

	register_term_meta(
		'sac_industry',
		'_sac_order',
		array(
			'type'              => 'integer',
			'single'            => true,
			'sanitize_callback' => 'absint',
			'auth_callback'     => function () {
				return current_user_can( 'manage_categories' );
			},
		)
	);
}
add_action( 'init', 'sac_register_content_types' );

/* Top-level "SAC Website" menu grouping every editable area. */
add_action(
	'admin_menu',
	function () {
		add_menu_page( __( 'SAC Website', 'sac' ), __( 'SAC Website', 'sac' ), 'edit_posts', 'sac-dashboard', '', 'dashicons-admin-site-alt3', 3 );
		add_submenu_page( 'sac-dashboard', __( 'Industries', 'sac' ), __( 'Industries', 'sac' ), 'manage_categories', 'edit-tags.php?taxonomy=sac_industry&post_type=sac_project' );
	},
	9
);

/* Keep the parent menu highlighted on the taxonomy screen. */
add_filter(
	'parent_file',
	function ( $parent ) {
		$screen = get_current_screen();
		return ( $screen && 'sac_industry' === $screen->taxonomy ) ? 'sac-dashboard' : $parent;
	}
);

/* Industry display order (filter button order on the Projects page). */
function sac_industry_order_field( $term = null ) {
	$value = $term instanceof WP_Term ? (int) get_term_meta( $term->term_id, '_sac_order', true ) : 0;
	if ( $term instanceof WP_Term ) {
		printf(
			'<tr class="form-field"><th scope="row"><label for="sac-order">%1$s</label></th><td><input id="sac-order" type="number" name="sac_order" value="%2$d" min="0"><p class="description">%3$s</p></td></tr>',
			esc_html__( 'Filter order', 'sac' ),
			(int) $value,
			esc_html__( 'Lower numbers appear first in the Projects filter.', 'sac' )
		);
	} else {
		printf(
			'<div class="form-field"><label for="sac-order">%1$s</label><input id="sac-order" type="number" name="sac_order" value="0" min="0"><p>%2$s</p></div>',
			esc_html__( 'Filter order', 'sac' ),
			esc_html__( 'Lower numbers appear first in the Projects filter.', 'sac' )
		);
	}
	wp_nonce_field( 'sac_term_order', 'sac_term_nonce' );
}
add_action( 'sac_industry_add_form_fields', 'sac_industry_order_field' );
add_action( 'sac_industry_edit_form_fields', 'sac_industry_order_field' );

function sac_save_industry_order( $term_id ) {
	if ( ! isset( $_POST['sac_term_nonce'], $_POST['sac_order'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sac_term_nonce'] ) ), 'sac_term_order' ) || ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	update_term_meta( $term_id, '_sac_order', absint( wp_unslash( $_POST['sac_order'] ) ) );
}
add_action( 'created_sac_industry', 'sac_save_industry_order' );
add_action( 'edited_sac_industry', 'sac_save_industry_order' );

/* Ensure new industries without an order still appear (meta_key ordering skips missing meta). */
add_action(
	'created_sac_industry',
	function ( $term_id ) {
		if ( '' === get_term_meta( $term_id, '_sac_order', true ) ) {
			update_term_meta( $term_id, '_sac_order', 99 );
		}
	},
	20
);

/* Thumbnail column for image-driven lists. */
foreach ( array( 'sac_project', 'sac_client', 'sac_leader' ) as $sac_type ) {
	add_filter(
		"manage_{$sac_type}_posts_columns",
		function ( $cols ) {
			return array_merge( array_slice( $cols, 0, 1 ), array( 'sac_thumb' => __( 'Image', 'sac' ) ), array_slice( $cols, 1 ) );
		}
	);
	add_action(
		"manage_{$sac_type}_posts_custom_column",
		function ( $col, $post_id ) {
			if ( 'sac_thumb' === $col ) {
				echo get_the_post_thumbnail( $post_id, array( 60, 60 ), array( 'style' => 'width:60px;height:auto' ) );
			}
		},
		10,
		2
	);
}
unset( $sac_type );

/* Menu order = display order. Default the admin lists to it. */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || $query->get( 'orderby' ) ) {
			return;
		}
		if ( array_key_exists( (string) $query->get( 'post_type' ), sac_content_types() ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'ASC' ) );
		}
	}
);
