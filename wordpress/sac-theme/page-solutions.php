<?php
/**
 * Template Name: SAC — Solutions
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
			<?php sac_reveal( 0 ); ?><h2 class="text-balance text-3xl font-bold tracking-tight sm:text-4xl"><?php sac_e( 'solutions_title' ); ?></h2></div>
			<?php sac_reveal( 1 ); ?><p class="mt-4 text-pretty leading-relaxed text-muted-foreground"><?php sac_e( 'solutions_intro' ); ?></p></div>
		</div>
		<div class="mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
			<?php foreach ( sac_get_solutions() as $sac_i => $sac_s ) : ?>
				<?php $sac_panel = 'sac-sol-panel-' . $sac_i; ?>
				<?php sac_reveal( $sac_i % 3 ); ?>
					<div id="<?php echo esc_attr( $sac_s['anchor'] ); ?>" data-sac-solution class="sac-solution flex h-full scroll-mt-28 flex-col rounded-xl border border-border bg-card p-6 transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">
						<div class="flex items-start justify-between gap-4">
							<span class="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary"><?php echo sac_icon( $sac_s['icon'], 'h-5 w-5' ); // phpcs:ignore ?></span>
							<button type="button" data-sac-solution-toggle aria-expanded="false" aria-controls="<?php echo esc_attr( $sac_panel ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s solution title */ __( 'Expand %s', 'sac' ), $sac_s['title'] ) ); ?>" data-label-open="<?php echo esc_attr( sprintf( __( 'Collapse %s', 'sac' ), $sac_s['title'] ) ); ?>" data-label-closed="<?php echo esc_attr( sprintf( __( 'Expand %s', 'sac' ), $sac_s['title'] ) ); ?>" class="flex h-8 w-8 items-center justify-center rounded-full border border-border text-muted-foreground transition-colors hover:border-primary hover:text-primary">
								<?php echo sac_icon( 'plus', 'sac-plus h-4 w-4 transition-transform duration-300' ); // phpcs:ignore ?>
							</button>
						</div>
						<h3 class="mt-5 text-lg font-semibold"><?php echo esc_html( $sac_s['title'] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-muted-foreground"><?php echo esc_html( $sac_s['summary'] ); ?></p>
						<div id="<?php echo esc_attr( $sac_panel ); ?>" class="sac-collapse">
							<div class="sac-collapse-inner">
								<div class="mt-5 border-t border-border pt-5">
									<?php if ( $sac_s['details_title'] ) : ?>
										<p class="mb-3 text-xs font-semibold uppercase tracking-wider text-primary"><?php echo esc_html( $sac_s['details_title'] ); ?></p>
									<?php endif; ?>
									<ul class="flex flex-col gap-2.5">
										<?php foreach ( $sac_s['details'] as $sac_d ) : ?>
											<li class="flex items-start gap-2.5 text-sm text-muted-foreground"><?php echo sac_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-primary' ); // phpcs:ignore ?><span><?php echo esc_html( $sac_d ); ?></span></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band' );
get_footer();
