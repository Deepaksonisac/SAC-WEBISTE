<?php
/**
 * Not found.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="flex min-h-[70vh] items-center py-28">
	<div class="mx-auto max-w-2xl px-4 text-center sm:px-6">
		<p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">404</p>
		<h1 class="mt-4 text-balance text-4xl font-bold tracking-tight sm:text-5xl"><?php esc_html_e( 'Page not found', 'sac' ); ?></h1>
		<p class="mt-5 text-muted-foreground"><?php esc_html_e( 'The page you are looking for has moved or no longer exists.', 'sac' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sac-btn sac-btn-lg mt-8"><?php esc_html_e( 'Back to Home', 'sac' ); ?></a>
	</div>
</section>
<?php
get_footer();
