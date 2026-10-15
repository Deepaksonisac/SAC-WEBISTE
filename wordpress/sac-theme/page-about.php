<?php
/**
 * Template Name: SAC — About
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="grid items-center gap-12 lg:grid-cols-2">
			<div>
				<?php sac_reveal( 0 ); sac_eyebrow( sac_opt( 'about_eyebrow' ) ); ?></div>
				<?php sac_reveal( 1 ); ?><h2 class="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'about_title' ); ?></h2></div>
				<?php sac_reveal( 2 ); ?><p class="mt-6 text-pretty leading-relaxed text-muted-foreground"><?php sac_e( 'about_p1' ); ?></p></div>
				<?php sac_reveal( 3 ); ?><p class="mt-4 text-pretty leading-relaxed text-muted-foreground"><?php sac_e( 'about_p2' ); ?></p></div>
			</div>
			<?php sac_reveal( 1 ); ?>
				<div class="relative overflow-hidden rounded-xl border border-border shadow-sm">
					<img src="<?php echo esc_url( sac_opt_image( 'about_image', 'large' ) ); ?>" alt="<?php esc_attr_e( 'Modern security operations center with a video wall of surveillance feeds', 'sac' ); ?>" width="880" height="620" loading="lazy" decoding="async" class="h-full w-full object-cover">
					<div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-primary/10"></div>
				</div>
			</div>
		</div>
		<div class="mt-16"><?php get_template_part( 'template-parts/stats-row' ); ?></div>
	</div>
</section>

<section id="leadership" class="scroll-mt-20 border-t border-border bg-card/30 py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="mx-auto max-w-2xl text-center">
			<?php sac_reveal( 0 ); sac_eyebrow( sac_opt( 'leadership_eyebrow' ) ); ?></div>
			<?php sac_reveal( 1 ); ?><h2 class="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'leadership_title' ); ?></h2></div>
		</div>
		<div class="mt-14 grid gap-6 md:grid-cols-3">
			<?php foreach ( sac_get_leaders() as $sac_i => $sac_l ) : ?>
				<?php sac_reveal( $sac_i ); ?>
					<article class="sac-glow group h-full overflow-hidden rounded-xl border border-border bg-card transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">
						<div class="relative aspect-[4/5] overflow-hidden">
							<?php if ( $sac_l['image'] ) : ?>
								<img src="<?php echo esc_url( $sac_l['image'] ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s name */ __( 'Portrait of %s', 'sac' ), $sac_l['name'] ) ); ?>" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
							<?php endif; ?>
						</div>
						<div class="p-6">
							<h3 class="text-lg font-semibold"><?php echo esc_html( $sac_l['name'] ); ?></h3>
							<p class="mt-1 text-sm font-medium text-primary"><?php echo esc_html( $sac_l['role'] ); ?></p>
							<div class="mt-3 text-sm leading-relaxed text-muted-foreground"><?php echo wp_kses_post( $sac_l['bio'] ); ?></div>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
		<?php sac_reveal( 1 ); ?>
			<div class="mx-auto mt-14 flex max-w-3xl items-center justify-center gap-4 rounded-xl border border-primary/25 bg-primary/5 px-8 py-10 text-center">
				<?php echo sac_icon( 'quote', 'hidden h-8 w-8 shrink-0 text-primary sm:block' ); // phpcs:ignore ?>
				<p class="font-heading text-2xl font-bold tracking-tight sm:text-3xl"><?php sac_e( 'leadership_quote' ); ?></p>
			</div>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band' );
get_footer();
