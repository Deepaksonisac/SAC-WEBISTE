<?php
/**
 * Custom fields for SAC content types and the seven pages.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

/** Fields per post type: key => [label, type, help]. Stored as _sac_{key}. */
function sac_companion_fields() {
	return array(
		'sac_solution' => array(
			'anchor'        => array( __( 'URL anchor', 'sac' ), 'text', __( 'Used in links like /solutions#access-control. Lowercase, hyphens only.', 'sac' ) ),
			'icon'          => array( __( 'Icon', 'sac' ), 'icon', '' ),
			'short_label'   => array( __( 'Short label (homepage & footer)', 'sac' ), 'text', '' ),
			'summary'       => array( __( 'Summary', 'sac' ), 'textarea', '' ),
			'details_title' => array( __( 'Details heading (optional)', 'sac' ), 'text', '' ),
			'details'       => array( __( 'Detail points', 'sac' ), 'lines', __( 'One point per line.', 'sac' ) ),
		),
		'sac_project'  => array(
			'location' => array( __( 'Location', 'sac' ), 'text', '' ),
			'tags'     => array( __( 'Tags', 'sac' ), 'text', __( 'Comma separated, e.g. ELV, BMS.', 'sac' ) ),
		),
		'sac_client'   => array(
			'url' => array( __( 'Website (optional)', 'sac' ), 'url', __( 'Logo is the Featured Image. Without a logo the name is shown as text.', 'sac' ) ),
		),
		'sac_leader'   => array(
			'role' => array( __( 'Role / designation', 'sac' ), 'text', __( 'Photo = Featured Image, profile = main content.', 'sac' ) ),
		),
		'sac_pillar'   => array(
			'icon' => array( __( 'Icon', 'sac' ), 'icon', __( 'Description = main content.', 'sac' ) ),
		),
		'sac_job'      => array(
			'badge'            => array( __( 'Badge', 'sac' ), 'text', __( 'e.g. Now Hiring', 'sac' ) ),
			'location'         => array( __( 'Location', 'sac' ), 'text', '' ),
			'experience'       => array( __( 'Experience', 'sac' ), 'text', '' ),
			'department'       => array( __( 'Department', 'sac' ), 'text', '' ),
			'employment'       => array( __( 'Employment type', 'sac' ), 'text', '' ),
			'knowledge'        => array( __( 'Technical knowledge', 'sac' ), 'textarea', '' ),
			'skills'           => array( __( 'Skills', 'sac' ), 'text', __( 'Comma separated.', 'sac' ) ),
			'responsibilities' => array( __( 'Responsibilities', 'sac' ), 'lines', __( 'One per line.', 'sac' ) ),
		),
		'page'         => array(
			'eyebrow'         => array( __( 'Page header — small label', 'sac' ), 'text', '' ),
			'heading'         => array( __( 'Page header — heading', 'sac' ), 'text', __( 'Leave empty to use the page title.', 'sac' ) ),
			'subtitle'        => array( __( 'Page header — subtitle', 'sac' ), 'textarea', '' ),
			'seo_title'       => array( __( 'SEO title', 'sac' ), 'text', __( 'Browser tab & Google title. Leave empty for the default.', 'sac' ) ),
			'seo_description' => array( __( 'SEO description', 'sac' ), 'textarea', __( 'About 150 characters.', 'sac' ) ),
		),
	);
}

add_action(
	'add_meta_boxes',
	function ( $post_type ) {
		$fields = sac_companion_fields();
		if ( empty( $fields[ $post_type ] ) ) {
			return;
		}
		add_meta_box(
			'sac-fields',
			'page' === $post_type ? __( 'SAC page header & SEO', 'sac' ) : __( 'SAC details', 'sac' ),
			'sac_render_meta_box',
			$post_type,
			'normal',
			'high'
		);
	}
);

function sac_render_meta_box( $post ) {
	$fields = sac_companion_fields();
	wp_nonce_field( 'sac_meta_' . $post->ID, 'sac_meta_nonce' );
	$icons = function_exists( 'sac_icon_choices' ) ? sac_icon_choices() : array();
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields[ $post->post_type ] as $key => $field ) {
		list( $label, $type, $help ) = $field;
		$id    = 'sac-' . $key;
		$name  = 'sac_meta[' . $key . ']';
		$value = (string) get_post_meta( $post->ID, '_sac_' . $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th><td>';
		if ( 'textarea' === $type || 'lines' === $type ) {
			printf( '<textarea id="%1$s" name="%2$s" rows="%3$d" class="large-text">%4$s</textarea>', esc_attr( $id ), esc_attr( $name ), 'lines' === $type ? 6 : 3, esc_textarea( $value ) );
		} elseif ( 'icon' === $type && $icons ) {
			printf( '<select id="%1$s" name="%2$s">', esc_attr( $id ), esc_attr( $name ) );
			foreach ( $icons as $icon ) {
				printf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $icon ), selected( $value, $icon, false ) );
			}
			echo '</select>';
		} else {
			printf( '<input id="%1$s" name="%2$s" type="%3$s" value="%4$s" class="regular-text">', esc_attr( $id ), esc_attr( $name ), 'url' === $type ? 'url' : 'text', esc_attr( $value ) );
		}
		if ( $help ) {
			echo '<p class="description">' . esc_html( $help ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

add_action(
	'save_post',
	function ( $post_id, $post ) {
		$fields = sac_companion_fields();
		if ( empty( $fields[ $post->post_type ] ) || wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}
		if ( ! isset( $_POST['sac_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sac_meta_nonce'] ) ), 'sac_meta_' . $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$input = isset( $_POST['sac_meta'] ) && is_array( $_POST['sac_meta'] ) ? wp_unslash( $_POST['sac_meta'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- sanitized per field below.
		foreach ( $fields[ $post->post_type ] as $key => $field ) {
			$raw = isset( $input[ $key ] ) ? (string) $input[ $key ] : '';
			switch ( $field[1] ) {
				case 'textarea':
				case 'lines':
					$clean = sanitize_textarea_field( $raw );
					break;
				case 'url':
					$clean = esc_url_raw( $raw );
					break;
				default:
					$clean = sanitize_text_field( $raw );
			}
			if ( 'anchor' === $key ) {
				$clean = sanitize_title( $clean );
			}
			update_post_meta( $post_id, '_sac_' . $key, $clean );
		}
	},
	10,
	2
);
