<?php
/**
 * SAC theme bootstrap.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

define( 'SAC_THEME_VERSION', '1.0.0' );

require_once get_theme_file_path( 'inc/icon-library.php' );
require_once get_theme_file_path( 'inc/defaults.php' );
require_once get_theme_file_path( 'inc/helpers.php' );

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'sac', get_theme_file_path( 'languages' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		register_nav_menus(
			array(
				'primary'         => __( 'Header navigation', 'sac' ),
				'footer_quick'    => __( 'Footer — Quick Links', 'sac' ),
				'footer_services' => __( 'Footer — Services', 'sac' ),
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'sac-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap',
			array(),
			null
		);
		$css = get_theme_file_path( 'assets/css/theme.css' );
		wp_enqueue_style( 'sac-theme', get_theme_file_uri( 'assets/css/theme.css' ), array(), SAC_THEME_VERSION . '.' . ( file_exists( $css ) ? filemtime( $css ) : 0 ) );

		wp_enqueue_script( 'sac-theme', get_theme_file_uri( 'assets/js/theme.js' ), array(), SAC_THEME_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );

		if ( is_front_page() && '1' === (string) sac_opt( 'hero_3d' ) && function_exists( 'wp_enqueue_script_module' ) ) {
			wp_enqueue_script_module( 'sac-hero-scene', get_theme_file_uri( 'assets/js/hero-scene.js' ), array(), SAC_THEME_VERSION );
		}
	}
);

add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);

/* Flag JS early so reveal animations never hide content when scripts are disabled. */
add_action(
	'wp_head',
	function () {
		echo "<script>document.documentElement.classList.add('sac-js')</script>\n";
		echo '<meta name="theme-color" content="#f3f8f2">' . "\n";
		if ( ! has_site_icon() ) {
			printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( sac_asset_image( 'icon.svg' ) ) );
			printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( sac_asset_image( 'apple-icon.png' ) ) );
		}
	},
	1
);

add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'antialiased';
		if ( is_front_page() ) {
			$classes[] = 'sac-home';
		}
		return $classes;
	}
);

/* Fallback document titles and descriptions when the companion plugin (which owns SEO fields) is inactive. */
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( function_exists( 'sac_companion_active' ) || $title ) {
			return $title;
		}
		$pages = sac_default_pages();
		$slug  = sac_current_slug();
		return isset( $pages[ $slug ] ) ? $pages[ $slug ]['seo_title'] : $title;
	}
);
