<?php
/**
 * Green call-to-action band. Accepts optional title/text overrides via $args.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_title = ! empty( $args['title'] ) ? $args['title'] : sac_opt( 'cta_title' );
$sac_text  = ! empty( $args['text'] ) ? $args['text'] : sac_opt( 'cta_text' );
?>
<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<?php sac_reveal( 0, 'relative overflow-hidden rounded-2xl bg-primary px-6 py-14 text-center sm:px-12 sm:py-16' ); ?>
			<div aria-hidden="true" class="pointer-events-none absolute -left-16 -top-16 h-56 w-56 rounded-full bg-primary-foreground/10 blur-3xl"></div>
			<div aria-hidden="true" class="pointer-events-none absolute -bottom-20 -right-10 h-64 w-64 rounded-full bg-primary-foreground/10 blur-3xl"></div>
			<h2 class="relative mx-auto max-w-2xl text-balance text-3xl font-bold tracking-tight text-primary-foreground sm:text-4xl"><?php echo esc_html( $sac_title ); ?></h2>
			<p class="relative mx-auto mt-5 max-w-2xl text-pretty leading-relaxed text-primary-foreground/85"><?php echo esc_html( $sac_text ); ?></p>
			<div class="relative mt-8">
				<a href="<?php echo esc_url( sac_link( sac_opt( 'cta_btn_url' ) ) ); ?>" class="sac-btn sac-btn-lg sac-btn-secondary group">
					<?php sac_e( 'cta_btn_label' ); ?>
					<?php echo sac_icon( 'arrow-right', 'ml-1 h-4 w-4 transition-transform group-hover:translate-x-1' ); // phpcs:ignore ?>
				</a>
			</div>
		</div>
	</div>
</section>
