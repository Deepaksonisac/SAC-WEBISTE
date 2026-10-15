<?php
/**
 * Error notice shown after a failed form submission (?sac_form=x&sac_status=error_code).
 * Success states are rendered by each form template.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_form = isset( $args['form'] ) ? $args['form'] : '';
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- display only.
if ( ! isset( $_GET['sac_form'], $_GET['sac_status'] ) || sanitize_key( wp_unslash( $_GET['sac_form'] ) ) !== $sac_form ) {
	return;
}
$sac_status = sanitize_key( wp_unslash( $_GET['sac_status'] ) );
// phpcs:enable
$sac_messages = array(
	'invalid'  => __( 'Please fill in all required fields with valid details and try again.', 'sac' ),
	'expired'  => __( 'Your session expired. Please submit the form again.', 'sac' ),
	'spam'     => __( 'Your submission could not be verified. Please try again.', 'sac' ),
	'file'     => __( 'Please upload your resume as a PDF, DOC or DOCX file under 5 MB.', 'sac' ),
	'mail'     => __( 'We could not send your message right now. Please call or email us directly.', 'sac' ),
	'limit'    => __( 'Too many submissions. Please wait a few minutes and try again.', 'sac' ),
	'disabled' => __( 'Form submissions are temporarily unavailable. Please call or email us directly.', 'sac' ),
);
if ( 'sent' === $sac_status || ! isset( $sac_messages[ $sac_status ] ) ) {
	return;
}
?>
<div role="alert" class="mb-6 rounded-md border border-destructive/40 bg-destructive/10 px-4 py-3 text-sm text-destructive"><?php echo esc_html( $sac_messages[ $sac_status ] ); ?></div>
