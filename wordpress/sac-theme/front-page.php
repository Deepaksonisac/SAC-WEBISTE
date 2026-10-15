<?php
/**
 * Home page: hero, about teaser + stats, solutions teaser, optional marquee, CTA.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section id="home" class="relative min-h-[100svh] overflow-hidden">
	<div class="absolute inset-0 z-0">
		<div aria-hidden="true" class="sac-hero-fallback h-full w-full"></div>
		<?php if ( '1' === (string) sac_opt( 'hero_3d' ) ) : ?>
			<canvas id="sac-hero-canvas" class="absolute inset-0 h-full w-full" aria-hidden="true"></canvas>
		<?php endif; ?>
	</div>
	<div aria-hidden="true" class="absolute inset-0 z-10 bg-gradient-to-r from-background via-background/85 to-background/30 md:to-transparent"></div>
	<div aria-hidden="true" class="absolute inset-x-0 bottom-0 z-10 h-40 bg-gradient-to-t from-background to-transparent"></div>

	<div class="relative z-20 mx-auto flex min-h-[100svh] max-w-7xl flex-col justify-center px-4 pt-24 pb-16 sm:px-6 lg:px-8">
		<div class="max-w-2xl">
			<div class="sac-rise mb-6 inline-flex items-center gap-2 rounded-full border border-border bg-card/60 px-4 py-1.5 text-xs font-medium text-muted-foreground backdrop-blur" style="--d:.1s">
				<?php echo sac_icon( 'shield-check', 'h-3.5 w-3.5 text-primary' ); // phpcs:ignore ?>
				<?php sac_e( 'hero_badge' ); ?>
			</div>
			<h1 class="sac-rise text-balance text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl" style="--d:.22s">
				<?php sac_e( 'hero_title' ); ?> <span class="text-primary"><?php sac_e( 'hero_title_highlight' ); ?></span>
			</h1>
			<p class="sac-rise mt-6 max-w-xl text-pretty text-base leading-relaxed text-muted-foreground sm:text-lg" style="--d:.34s"><?php sac_e( 'hero_text' ); ?></p>
			<div class="sac-rise mt-9 flex flex-col gap-3 sm:flex-row" style="--d:.46s">
				<a href="<?php echo esc_url( sac_link( sac_opt( 'hero_btn1_url' ) ) ); ?>" class="sac-btn sac-btn-lg group">
					<?php sac_e( 'hero_btn1_label' ); ?>
					<?php echo sac_icon( 'arrow-right', 'ml-1 h-4 w-4 transition-transform group-hover:translate-x-1' ); // phpcs:ignore ?>
				</a>
				<a href="<?php echo esc_url( sac_link( sac_opt( 'hero_btn2_url' ) ) ); ?>" class="sac-btn sac-btn-lg sac-btn-outline border-border bg-card/40 backdrop-blur"><?php sac_e( 'hero_btn2_label' ); ?></a>
			</div>
		</div>
	</div>
</section>

<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="grid items-center gap-12 lg:grid-cols-2">
			<div>
				<?php sac_reveal( 0 ); sac_eyebrow( sac_opt( 'home_about_eyebrow' ) ); ?></div>
				<?php sac_reveal( 1 ); ?><h2 class="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'home_about_title' ); ?></h2></div>
				<?php sac_reveal( 2 ); ?><p class="mt-6 text-pretty leading-relaxed text-muted-foreground"><?php sac_e( 'home_about_text' ); ?></p></div>
				<?php sac_reveal( 3 ); ?>
					<a href="<?php echo esc_url( sac_page_url( 'about' ) ); ?>" class="group mt-7 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
						<?php sac_e( 'home_about_link_label' ); ?>
						<?php echo sac_icon( 'arrow-right', 'h-4 w-4 transition-transform group-hover:translate-x-1' ); // phpcs:ignore ?>
					</a>
				</div>
			</div>
			<?php sac_reveal( 1 ); ?>
				<div class="relative overflow-hidden rounded-xl border border-border shadow-sm">
					<img src="<?php echo esc_url( sac_opt_image( 'home_about_image', 'large' ) ); ?>" alt="<?php esc_attr_e( 'Modern security operations center with a video wall of surveillance feeds', 'sac' ); ?>" width="880" height="620" loading="lazy" decoding="async" class="h-full w-full object-cover">
					<div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-primary/10"></div>
				</div>
			</div>
		</div>
		<div class="mt-16"><?php get_template_part( 'template-parts/stats-row' ); ?></div>
	</div>
</section>

<section class="border-y border-border bg-secondary/40 py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="mx-auto max-w-2xl text-center">
			<?php sac_reveal( 0 ); sac_eyebrow( sac_opt( 'home_solutions_eyebrow' ) ); ?></div>
			<?php sac_reveal( 1 ); ?><h2 class="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'home_solutions_title' ); ?></h2></div>
		</div>
		<div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3">
			<?php foreach ( sac_get_solutions() as $sac_i => $sac_s ) : ?>
				<?php sac_reveal( $sac_i % 3 ); ?>
					<a href="<?php echo esc_url( sac_page_url( 'solutions' ) . '#' . $sac_s['anchor'] ); ?>" class="flex h-full items-center gap-4 rounded-xl border border-border bg-card p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">
						<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"><?php echo sac_icon( $sac_s['icon'], 'h-5 w-5' ); // phpcs:ignore ?></span>
						<span class="text-sm font-medium leading-snug"><?php echo esc_html( $sac_s['short_label'] ); ?></span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<?php sac_reveal( 1, 'mt-10 text-center' ); ?>
			<a href="<?php echo esc_url( sac_page_url( 'solutions' ) ); ?>" class="group inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
				<?php sac_e( 'home_solutions_link' ); ?>
				<?php echo sac_icon( 'arrow-right', 'h-4 w-4 transition-transform group-hover:translate-x-1' ); // phpcs:ignore ?>
			</a>
		</div>
	</div>
</section>

<?php
if ( '1' === (string) sac_opt( 'marquee_enabled' ) ) {
	get_template_part( 'template-parts/client-marquee' );
}
get_template_part( 'template-parts/cta-band' );
get_footer();
