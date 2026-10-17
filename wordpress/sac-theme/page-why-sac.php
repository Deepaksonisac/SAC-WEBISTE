<?php
/**
 * Template Name: SAC — Why SAC
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="mx-auto max-w-2xl text-center">
			<?php sac_reveal( 0 ); ?><h2 class="text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'why_title' ); ?></h2></div>
		</div>
		<div class="mt-14 grid gap-6 md:grid-cols-3">
			<?php foreach ( sac_get_pillars() as $sac_i => $sac_p ) : ?>
				<?php sac_reveal( $sac_i ); ?>
					<div class="sac-glow group relative h-full overflow-hidden rounded-xl border border-primary/15 bg-secondary/50 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">
						<div aria-hidden="true" class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-primary/5 blur-2xl"></div>
						<span class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 text-primary"><?php echo sac_icon( $sac_p['icon'], 'h-6 w-6' ); // phpcs:ignore ?></span>
						<h3 class="mt-6 text-xl font-semibold"><?php echo esc_html( $sac_p['title'] ); ?></h3>
						<p class="mt-3 leading-relaxed text-muted-foreground"><?php echo esc_html( $sac_p['body'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band' );
get_footer();
