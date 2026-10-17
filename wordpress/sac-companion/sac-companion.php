<?php
/**
 * Plugin Name:       SAC Companion
 * Description:       Content types, dashboard editing, secure contact & careers forms, SEO fields and the one-time content importer for the SAC theme.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            Secure Automation Consultants
 * License:           GPL-2.0-or-later
 * Text Domain:       sac
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

define( 'SAC_COMPANION_VERSION', '1.0.0' );
define( 'SAC_COMPANION_FILE', __FILE__ );
define( 'SAC_COMPANION_DIR', plugin_dir_path( __FILE__ ) );
define( 'SAC_COMPANION_URL', plugin_dir_url( __FILE__ ) );

/** Lets the theme know the plugin owns SEO, forms and content types. */
function sac_companion_active() {
	return true;
}

/** True when the SAC theme (which ships the original content defaults) is active. */
function sac_companion_theme_ready() {
	return function_exists( 'sac_default_settings' ) && function_exists( 'sac_default_images' );
}

require_once SAC_COMPANION_DIR . 'includes/post-types.php';
require_once SAC_COMPANION_DIR . 'includes/meta-boxes.php';
require_once SAC_COMPANION_DIR . 'includes/settings.php';
require_once SAC_COMPANION_DIR . 'includes/seo.php';
require_once SAC_COMPANION_DIR . 'includes/forms.php';
require_once SAC_COMPANION_DIR . 'includes/importer.php';

register_activation_hook(
	__FILE__,
	function () {
		sac_register_content_types();
		flush_rewrite_rules();
	}
);

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

add_action(
	'admin_notices',
	function () {
		if ( sac_companion_theme_ready() || ! current_user_can( 'switch_themes' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'SAC Companion works with the SAC theme. Please activate the SAC theme (Appearance → Themes) to edit settings and run the importer.', 'sac' ) . '</p></div>';
	}
);
