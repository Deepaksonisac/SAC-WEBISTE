<?php
/**
 * "SAC Website → Site Settings" screen built on the Settings API.
 * Fields are generated from the theme defaults, so every original text is editable.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

/** Tabs: id => [label, keys]. Keys not listed land in "Other". */
function sac_settings_tabs() {
	return array(
		'general'  => array( __( 'Header, Footer & Contact', 'sac' ), array( 'logo', 'header_cta_label', 'header_cta_url', 'footer_tagline', 'footer_location', 'phone_1', 'phone_2', 'email_1', 'email_2', 'address', 'map_query', 'social_linkedin', 'social_x', 'social_facebook', 'form_recipient' ) ),
		'home'     => array( __( 'Homepage', 'sac' ), array( 'hero_badge', 'hero_title', 'hero_title_highlight', 'hero_text', 'hero_btn1_label', 'hero_btn1_url', 'hero_btn2_label', 'hero_btn2_url', 'hero_3d', 'home_about_eyebrow', 'home_about_title', 'home_about_text', 'home_about_link_label', 'home_about_image', 'home_solutions_eyebrow', 'home_solutions_title', 'home_solutions_link', 'marquee_enabled', 'marquee_title', 'stats', 'cta_title', 'cta_text', 'cta_btn_label', 'cta_btn_url' ) ),
		'pages'    => array( __( 'Solutions, About, Why SAC, Contact', 'sac' ), array( 'solutions_title', 'solutions_intro', 'about_eyebrow', 'about_title', 'about_p1', 'about_p2', 'about_image', 'leadership_eyebrow', 'leadership_title', 'leadership_quote', 'why_title', 'contact_success_title', 'contact_success_text' ) ),
		'careers'  => array( __( 'Careers', 'sac' ), array() ), // Every key starting with careers_/benefits/openings_/apply_.
		'other'    => array( __( 'Other', 'sac' ), array() ),
	);
}

/** Tab id for a settings key. */
function sac_settings_tab_for( $key ) {
	foreach ( sac_settings_tabs() as $tab => $def ) {
		if ( in_array( $key, $def[1], true ) ) {
			return $tab;
		}
	}
	return preg_match( '/^(careers_|benefits|openings_|apply_)/', $key ) ? 'careers' : 'other';
}

/** Repeatable group columns: key => [column => label]. */
function sac_settings_groups() {
	return array(
		'stats'              => array( 'value' => __( 'Number', 'sac' ), 'suffix' => __( 'Suffix (+)', 'sac' ), 'label' => __( 'Label', 'sac' ), 'display' => __( 'Text instead of number', 'sac' ) ),
		'careers_highlights' => array( 'value' => __( 'Big text', 'sac' ), 'label' => __( 'Small text', 'sac' ) ),
		'benefits'           => array( 'icon' => __( 'Icon', 'sac' ), 'title' => __( 'Title', 'sac' ), 'text' => __( 'Text', 'sac' ) ),
	);
}

/** Field type inferred from the key and its default value. */
function sac_setting_type( $key, $default ) {
	if ( is_array( $default ) ) {
		return 'group';
	}
	if ( 0 === strpos( (string) $default, 'img:' ) || preg_match( '/(^logo$|_image$)/', $key ) ) {
		return 'image';
	}
	if ( in_array( $key, array( 'hero_3d', 'marquee_enabled' ), true ) ) {
		return 'checkbox';
	}
	if ( 'form_recipient' === $key ) {
		return 'email';
	}
	if ( false !== strpos( (string) $default, "\n" ) || strlen( (string) $default ) > 90 ) {
		return 'textarea';
	}
	return 'text';
}

function sac_setting_label( $key ) {
	$labels = array(
		'form_recipient'  => __( 'Form notification email (empty = first email above)', 'sac' ),
		'hero_3d'         => __( 'Show animated 3D hero background', 'sac' ),
		'marquee_enabled' => __( 'Show client logo marquee on homepage', 'sac' ),
		'map_query'       => __( 'Google Maps search text', 'sac' ),
		'social_x'        => __( 'X (Twitter) URL', 'sac' ),
	);
	return isset( $labels[ $key ] ) ? $labels[ $key ] : ucfirst( str_replace( array( '_', ' url', 'btn' ), array( ' ', ' URL', 'button' ), $key ) );
}

add_action(
	'admin_menu',
	function () {
		add_submenu_page( 'sac-dashboard', __( 'Site Settings', 'sac' ), __( 'Site Settings', 'sac' ), 'manage_options', 'sac-settings', 'sac_render_settings_page', 0 );
	}
);

add_action(
	'admin_init',
	function () {
		register_setting(
			'sac_settings_group',
			'sac_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => 'sac_sanitize_settings',
				'default'           => array(),
			)
		);
	}
);

/** Only the submitted tab is replaced; other tabs keep their saved values. */
function sac_sanitize_settings( $input ) {
	$saved = get_option( 'sac_settings', array() );
	$saved = is_array( $saved ) ? $saved : array();
	if ( ! is_array( $input ) || ! sac_companion_theme_ready() ) {
		return $saved;
	}
	// Internal calls (importer) pass a complete, pre-sanitized array.
	if ( empty( $input['__tab'] ) ) {
		return $input;
	}
	$tab      = sanitize_key( $input['__tab'] );
	$defaults = sac_default_settings();
	$groups   = sac_settings_groups();

	foreach ( $defaults as $key => $default ) {
		if ( sac_settings_tab_for( $key ) !== $tab ) {
			continue;
		}
		$type = sac_setting_type( $key, $default );
		$raw  = isset( $input[ $key ] ) ? $input[ $key ] : '';
		switch ( $type ) {
			case 'group':
				$rows = array();
				foreach ( (array) $raw as $row ) {
					$clean = array();
					foreach ( array_keys( $groups[ $key ] ) as $col ) {
						$clean[ $col ] = isset( $row[ $col ] ) ? sanitize_text_field( $row[ $col ] ) : '';
					}
					if ( implode( '', $clean ) !== '' ) {
						$rows[] = $clean;
					}
				}
				$saved[ $key ] = $rows;
				break;
			case 'image':
				$saved[ $key ] = absint( $raw ) ? absint( $raw ) : '';
				break;
			case 'checkbox':
				$saved[ $key ] = $raw ? '1' : '0';
				break;
			case 'email':
				$saved[ $key ] = sanitize_email( $raw );
				break;
			case 'textarea':
				$saved[ $key ] = sanitize_textarea_field( $raw );
				break;
			default:
				$saved[ $key ] = sanitize_text_field( $raw );
		}
	}
	return $saved;
}

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( false === strpos( $hook, 'sac-settings' ) ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script( 'sac-admin', SAC_COMPANION_URL . 'assets/admin.js', array( 'jquery' ), SAC_COMPANION_VERSION, true );
		wp_add_inline_style( 'common', '.sac-img-preview img{max-width:220px;height:auto;display:block;margin-bottom:8px;background:#f0f0f1}.sac-group td{padding:4px}.sac-group input{width:100%}' );
	}
);

function sac_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! sac_companion_theme_ready() ) {
		echo '<div class="wrap"><h1>' . esc_html__( 'Site Settings', 'sac' ) . '</h1><p>' . esc_html__( 'Activate the SAC theme first.', 'sac' ) . '</p></div>';
		return;
	}
	$tabs = sac_settings_tabs();
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- tab navigation only.
	$tab      = isset( $_GET['tab'] ) && isset( $tabs[ sanitize_key( $_GET['tab'] ) ] ) ? sanitize_key( $_GET['tab'] ) : 'general';
	$defaults = sac_default_settings();
	$saved    = get_option( 'sac_settings', array() );
	$icons    = function_exists( 'sac_icon_choices' ) ? sac_icon_choices() : array();
	$groups   = sac_settings_groups();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'SAC Website — Site Settings', 'sac' ); ?></h1>
		<p><?php esc_html_e( 'Empty fields automatically show the original website text. Navigation menus are edited under Appearance → Menus; page headers & SEO on each page.', 'sac' ); ?></p>
		<nav class="nav-tab-wrapper">
			<?php foreach ( $tabs as $id => $def ) : ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'sac-settings', 'tab' => $id ), admin_url( 'admin.php' ) ) ); ?>" class="nav-tab<?php echo $id === $tab ? ' nav-tab-active' : ''; ?>"><?php echo esc_html( $def[0] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<form method="post" action="options.php">
			<?php settings_fields( 'sac_settings_group' ); ?>
			<input type="hidden" name="sac_settings[__tab]" value="<?php echo esc_attr( $tab ); ?>">
			<table class="form-table" role="presentation"><tbody>
			<?php
			foreach ( $defaults as $key => $default ) {
				if ( sac_settings_tab_for( $key ) !== $tab ) {
					continue;
				}
				$type  = sac_setting_type( $key, $default );
				$value = isset( $saved[ $key ] ) && '' !== $saved[ $key ] && array() !== $saved[ $key ] ? $saved[ $key ] : ( 'image' === $type ? '' : $default );
				$name  = 'sac_settings[' . $key . ']';
				$id    = 'sac-set-' . $key;
				echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( sac_setting_label( $key ) ) . '</label></th><td>';
				switch ( $type ) {
					case 'group':
						$rows   = array_values( (array) $value );
						$rows[] = array();
						echo '<table class="sac-group widefat striped"><thead><tr>';
						foreach ( $groups[ $key ] as $col_label ) {
							echo '<th>' . esc_html( $col_label ) . '</th>';
						}
						echo '</tr></thead><tbody>';
						foreach ( $rows as $i => $row ) {
							echo '<tr>';
							foreach ( array_keys( $groups[ $key ] ) as $col ) {
								$cell = isset( $row[ $col ] ) ? $row[ $col ] : '';
								$cn   = $name . '[' . $i . '][' . $col . ']';
								echo '<td>';
								if ( 'icon' === $col && $icons ) {
									echo '<select name="' . esc_attr( $cn ) . '"><option value=""></option>';
									foreach ( $icons as $icon ) {
										printf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $icon ), selected( $cell, $icon, false ) );
									}
									echo '</select>';
								} else {
									printf( '<input type="text" name="%1$s" value="%2$s"%3$s>', esc_attr( $cn ), esc_attr( $cell ), 0 === $i && 'value' === $col ? ' id="' . esc_attr( $id ) . '"' : '' );
								}
								echo '</td>';
							}
							echo '</tr>';
						}
						echo '</tbody></table><p class="description">' . esc_html__( 'Fill the empty last row to add an item; clear a row to remove it.', 'sac' ) . '</p>';
						break;
					case 'image':
						$url = function_exists( 'sac_opt_image' ) ? sac_image_url( $value ? $value : $default, 'medium' ) : '';
						printf(
							'<div class="sac-img-field"><div class="sac-img-preview">%1$s</div><input type="hidden" id="%2$s" name="%3$s" value="%4$s"><button type="button" class="button sac-img-pick">%5$s</button> <button type="button" class="button-link sac-img-clear">%6$s</button></div>',
							$url ? '<img src="' . esc_url( $url ) . '" alt="">' : '',
							esc_attr( $id ),
							esc_attr( $name ),
							esc_attr( $value ),
							esc_html__( 'Choose from Media Library', 'sac' ),
							esc_html__( 'Use original image', 'sac' )
						);
						break;
					case 'checkbox':
						printf( '<input type="checkbox" id="%1$s" name="%2$s" value="1"%3$s>', esc_attr( $id ), esc_attr( $name ), checked( '1', (string) $value, false ) );
						break;
					case 'textarea':
						printf( '<textarea id="%1$s" name="%2$s" rows="4" class="large-text">%3$s</textarea>', esc_attr( $id ), esc_attr( $name ), esc_textarea( $value ) );
						break;
					default:
						printf( '<input type="%1$s" id="%2$s" name="%3$s" value="%4$s" class="regular-text">', 'email' === $type ? 'email' : 'text', esc_attr( $id ), esc_attr( $name ), esc_attr( $value ) );
				}
				echo '</td></tr>';
			}
			?>
			</tbody></table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
