<?php
/**
 * SEO title & description for the seven pages. Defers to Yoast / Rank Math / AIOSEO when present.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

function sac_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/** SEO value for the current page: saved meta, else the original default. */
function sac_seo_value( $field ) {
	if ( ! is_front_page() && ! is_page() ) {
		return '';
	}
	$id    = get_queried_object_id();
	$value = $id ? (string) get_post_meta( $id, '_sac_' . $field, true ) : '';
	if ( '' === $value && function_exists( 'sac_default_pages' ) && function_exists( 'sac_current_slug' ) ) {
		$pages = sac_default_pages();
		$slug  = sac_current_slug();
		$value = isset( $pages[ $slug ][ $field ] ) ? $pages[ $slug ][ $field ] : '';
	}
	return $value;
}

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( sac_seo_plugin_active() ) {
			return $title;
		}
		$seo = sac_seo_value( 'seo_title' );
		return '' !== $seo ? $seo : $title;
	},
	20
);

add_action(
	'wp_head',
	function () {
		if ( sac_seo_plugin_active() ) {
			return;
		}
		$description = sac_seo_value( 'seo_description' );
		if ( '' === $description ) {
			return;
		}
		$title = wp_get_document_title();
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:type" content="website">' . "\n" );
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( is_front_page() ? home_url( '/' ) : get_permalink() ) );
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( is_front_page() ? home_url( '/' ) : get_permalink() ) );
	},
	2
);

/* WordPress prints its own canonical for singular pages; we output one above. */
add_action(
	'wp',
	function () {
		if ( ! sac_seo_plugin_active() && ( is_front_page() || is_page() ) ) {
			remove_action( 'wp_head', 'rel_canonical' );
		}
	}
);
