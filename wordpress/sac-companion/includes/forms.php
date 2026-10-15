<?php
/**
 * Contact & careers form processing: nonce, honeypot, timing check, rate limit,
 * server-side validation, private resume storage, wp_mail notification and a
 * "Form Submissions" log in the dashboard.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

const SAC_RESUME_MAX_BYTES = 5242880; // 5 MB.

foreach ( array( 'sac_contact', 'sac_career' ) as $sac_action ) {
	add_action( 'admin_post_' . $sac_action, 'sac_handle_form' );
	add_action( 'admin_post_nopriv_' . $sac_action, 'sac_handle_form' );
}
unset( $sac_action );

/** Redirect back to the form page with a status code. */
function sac_form_redirect( $form, $status ) {
	$fallback = home_url( '/' . ( 'contact' === $form ? 'contact' : 'careers' ) . '/' );
	$return   = isset( $_POST['sac_return'] ) ? esc_url_raw( wp_unslash( $_POST['sac_return'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$return   = wp_validate_redirect( $return, $fallback );
	$url      = add_query_arg( array( 'sac_form' => $form, 'sac_status' => $status ), $return );
	wp_safe_redirect( $url . ( 'sent' === $status ? '' : '#' . ( 'contact' === $form ? 'contact-form' : 'apply' ) ), 303 );
	exit;
}

function sac_post_field( $key, $max = 200, $multiline = false ) {
	// phpcs:ignore WordPress.Security.NonceVerification -- verified in sac_handle_form().
	$raw = isset( $_POST[ $key ] ) ? (string) wp_unslash( $_POST[ $key ] ) : '';
	$val = $multiline ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
	return function_exists( 'mb_substr' ) ? mb_substr( $val, 0, $max ) : substr( $val, 0, $max );
}

function sac_client_ip_hash() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return wp_hash( $ip );
}

function sac_handle_form() {
	$action = isset( $_POST['action'] ) ? sanitize_key( wp_unslash( $_POST['action'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$form   = 'sac_career' === $action ? 'career' : 'contact';

	if ( ! isset( $_POST['sac_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['sac_nonce'] ) ), $action ) ) {
		sac_form_redirect( $form, 'expired' );
	}

	// Honeypot filled or submitted faster than a human could: pretend success, store nothing.
	$ts = isset( $_POST['sac_ts'] ) ? absint( wp_unslash( $_POST['sac_ts'] ) ) : 0;
	if ( '' !== sac_post_field( 'website' ) ) {
		sac_form_redirect( $form, 'sent' );
	}
	if ( ! $ts || ( time() - $ts ) < 3 ) {
		sac_form_redirect( $form, 'spam' );
	}

	$limit_key = 'sac_rl_' . sac_client_ip_hash();
	$count     = (int) get_transient( $limit_key );
	if ( $count >= (int) apply_filters( 'sac_form_rate_limit', 5 ) ) {
		sac_form_redirect( $form, 'limit' );
	}

	$email = sanitize_email( sac_post_field( 'email', 160 ) );
	$phone = sac_post_field( 'phone', 30 );
	if ( '' !== $phone && ! preg_match( '/^[0-9+()\-\s]{6,30}$/', $phone ) ) {
		sac_form_redirect( $form, 'invalid' );
	}

	if ( 'contact' === $form ) {
		$data = array(
			'Name'        => sac_post_field( 'name', 120 ),
			'Company'     => sac_post_field( 'company', 160 ),
			'Email'       => $email,
			'Phone'       => $phone,
			'Requirement' => sac_post_field( 'requirement', 200 ),
			'Message'     => sac_post_field( 'message', 5000, true ),
		);
		if ( '' === $data['Name'] || ! is_email( $email ) ) {
			sac_form_redirect( $form, 'invalid' );
		}
		$subject = sprintf( 'New enquiry from %s', $data['Name'] );
	} else {
		$data = array(
			'Full Name'        => sac_post_field( 'full_name', 120 ),
			'Email'            => $email,
			'Phone'            => $phone,
			'Current Location' => sac_post_field( 'location', 120 ),
			'Position'         => sac_post_field( 'position', 160 ),
			'Experience'       => sac_post_field( 'experience', 60 ),
			'Current Company'  => sac_post_field( 'company', 160 ),
			'Message'          => sac_post_field( 'message', 5000, true ),
		);
		if ( '' === $data['Full Name'] || ! is_email( $email ) || '' === $phone || '' === $data['Position'] ) {
			sac_form_redirect( $form, 'invalid' );
		}
		$subject = sprintf( 'Job application: %s — %s', $data['Position'], $data['Full Name'] );
	}

	$resume = '';
	if ( 'career' === $form ) {
		$resume = sac_store_resume();
		if ( is_wp_error( $resume ) ) {
			sac_form_redirect( $form, 'file' );
		}
	}

	set_transient( $limit_key, $count + 1, 10 * MINUTE_IN_SECONDS );

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'sac_submission',
			'post_status' => 'private',
			'post_title'  => ( 'career' === $form ? 'Career: ' : 'Contact: ' ) . reset( $data ),
		),
		true
	);
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_sac_form', $form );
		update_post_meta( $post_id, '_sac_fields', $data );
		if ( $resume ) {
			update_post_meta( $post_id, '_sac_resume', $resume );
		}
	}

	$to = sac_companion_theme_ready() ? sac_opt( 'form_recipient' ) : '';
	if ( ! is_email( $to ) ) {
		$to = sac_companion_theme_ready() ? sac_opt( 'email_1' ) : '';
	}
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}
	$body = '';
	foreach ( $data as $label => $value ) {
		$body .= $label . ': ' . ( '' === $value ? '-' : $value ) . "\n";
	}
	if ( ! is_wp_error( $post_id ) ) {
		$body .= "\n" . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . "\n";
	}
	$headers = array( 'Reply-To: ' . str_replace( array( "\r", "\n", '<', '>', ',' ), '', reset( $data ) ) . ' <' . $email . '>' );
	$sent    = wp_mail( $to, $subject, $body, $headers, $resume ? array( $resume ) : array() );

	// The submission is safely stored even if the host cannot send mail; only fail when both failed.
	if ( ! $sent && is_wp_error( $post_id ) ) {
		sac_form_redirect( $form, 'mail' );
	}
	sac_form_redirect( $form, 'sent' );
}

/** Private uploads folder that the web server must never serve directly. */
function sac_private_dir() {
	$upload = wp_upload_dir();
	$dir    = trailingslashit( $upload['basedir'] ) . 'sac-private';
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
	}
	if ( ! file_exists( $dir . '/.htaccess' ) ) {
		file_put_contents( $dir . '/.htaccess', "Require all denied\nDeny from all\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		file_put_contents( $dir . '/index.php', "<?php // Silence.\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
	return $dir;
}

/** Validate and store the uploaded resume. Returns the absolute path or WP_Error. */
function sac_store_resume() {
	// phpcs:ignore WordPress.Security.NonceVerification -- verified in sac_handle_form().
	if ( empty( $_FILES['resume'] ) || ! isset( $_FILES['resume']['error'], $_FILES['resume']['tmp_name'], $_FILES['resume']['name'], $_FILES['resume']['size'] ) ) {
		return new WP_Error( 'missing' );
	}
	$file = $_FILES['resume']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput, WordPress.Security.NonceVerification
	if ( UPLOAD_ERR_OK !== (int) $file['error'] || ! is_uploaded_file( $file['tmp_name'] ) || (int) $file['size'] <= 0 || (int) $file['size'] > SAC_RESUME_MAX_BYTES ) {
		return new WP_Error( 'upload' );
	}
	$mimes = array(
		'pdf'  => 'application/pdf',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	);
	$check = wp_check_filetype_and_ext( $file['tmp_name'], sanitize_file_name( $file['name'] ), $mimes );
	if ( empty( $check['ext'] ) || empty( $check['type'] ) ) {
		return new WP_Error( 'type' );
	}
	$dir  = sac_private_dir();
	$base = sanitize_file_name( pathinfo( $file['name'], PATHINFO_FILENAME ) );
	$name = wp_unique_filename( $dir, gmdate( 'Ymd-His' ) . '-' . wp_generate_password( 8, false ) . '-' . substr( $base, 0, 40 ) . '.' . $check['ext'] );
	$path = $dir . '/' . $name;
	if ( ! move_uploaded_file( $file['tmp_name'], $path ) ) { // phpcs:ignore Generic.PHP.ForbiddenFunctions
		return new WP_Error( 'move' );
	}
	chmod( $path, 0640 ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	return $path;
}

/* ---- Dashboard: read-only submission view & secure resume download ---- */

add_action(
	'add_meta_boxes_sac_submission',
	function () {
		add_meta_box(
			'sac-submission',
			__( 'Submission details', 'sac' ),
			function ( $post ) {
				$fields = (array) get_post_meta( $post->ID, '_sac_fields', true );
				echo '<table class="widefat striped"><tbody>';
				foreach ( $fields as $label => $value ) {
					echo '<tr><th style="width:180px">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $value ) ) . '</td></tr>';
				}
				echo '<tr><th>' . esc_html__( 'Received', 'sac' ) . '</th><td>' . esc_html( get_the_date( 'd M Y, H:i', $post ) ) . '</td></tr>';
				if ( get_post_meta( $post->ID, '_sac_resume', true ) ) {
					$url = wp_nonce_url( admin_url( 'admin-post.php?action=sac_resume&id=' . $post->ID ), 'sac_resume_' . $post->ID );
					echo '<tr><th>' . esc_html__( 'Resume', 'sac' ) . '</th><td><a class="button" href="' . esc_url( $url ) . '">' . esc_html__( 'Download resume', 'sac' ) . '</a></td></tr>';
				}
				echo '</tbody></table>';
			},
			'sac_submission',
			'normal',
			'high'
		);
		remove_meta_box( 'submitdiv', 'sac_submission', 'side' );
	}
);

add_action(
	'admin_post_sac_resume',
	function () {
		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		if ( ! $id || ! check_admin_referer( 'sac_resume_' . $id ) || ! current_user_can( 'edit_post', $id ) ) {
			wp_die( esc_html__( 'Not allowed.', 'sac' ), 403 );
		}
		$path = (string) get_post_meta( $id, '_sac_resume', true );
		$dir  = realpath( sac_private_dir() );
		$real = $path ? realpath( $path ) : false;
		if ( ! $real || ! $dir || 0 !== strpos( $real, $dir ) || ! is_readable( $real ) ) {
			wp_die( esc_html__( 'File not found.', 'sac' ), 404 );
		}
		nocache_headers();
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename="' . basename( $real ) . '"' );
		header( 'Content-Length: ' . filesize( $real ) );
		header( 'X-Content-Type-Options: nosniff' );
		readfile( $real ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		exit;
	}
);

/* Delete the stored resume when a submission is permanently deleted. */
add_action(
	'before_delete_post',
	function ( $post_id ) {
		if ( 'sac_submission' !== get_post_type( $post_id ) ) {
			return;
		}
		$path = (string) get_post_meta( $post_id, '_sac_resume', true );
		$dir  = realpath( sac_private_dir() );
		$real = $path ? realpath( $path ) : false;
		if ( $real && $dir && 0 === strpos( $real, $dir ) ) {
			wp_delete_file( $real );
		}
	}
);

add_filter(
	'manage_sac_submission_posts_columns',
	function ( $cols ) {
		return array(
			'cb'        => $cols['cb'],
			'title'     => __( 'From', 'sac' ),
			'sac_form'  => __( 'Form', 'sac' ),
			'sac_email' => __( 'Email', 'sac' ),
			'date'      => $cols['date'],
		);
	}
);
add_action(
	'manage_sac_submission_posts_custom_column',
	function ( $col, $post_id ) {
		$fields = (array) get_post_meta( $post_id, '_sac_fields', true );
		if ( 'sac_form' === $col ) {
			echo 'career' === get_post_meta( $post_id, '_sac_form', true ) ? esc_html__( 'Careers', 'sac' ) : esc_html__( 'Contact', 'sac' );
		} elseif ( 'sac_email' === $col && ! empty( $fields['Email'] ) ) {
			echo '<a href="mailto:' . esc_attr( $fields['Email'] ) . '">' . esc_html( $fields['Email'] ) . '</a>';
		}
	},
	10,
	2
);
