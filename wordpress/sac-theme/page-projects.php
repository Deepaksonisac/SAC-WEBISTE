<?php
/**
 * Template Name: SAC — Projects
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_projects   = sac_get_projects();
$sac_industries = sac_get_industries();

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<?php sac_reveal( 0 ); ?>
			<div class="flex flex-wrap justify-center gap-3" role="group" aria-label="<?php esc_attr_e( 'Filter projects by industry', 'sac' ); ?>">
				<button type="button" data-sac-filter="all" aria-pressed="true" class="sac-filter is-active rounded-full border px-5 py-2 text-sm font-medium transition-colors"><?php esc_html_e( 'All', 'sac' ); ?></button>
				<?php foreach ( $sac_industries as $sac_slug => $sac_name ) : ?>
					<button type="button" data-sac-filter="<?php echo esc_attr( $sac_slug ); ?>" aria-pressed="false" class="sac-filter rounded-full border px-5 py-2 text-sm font-medium transition-colors"><?php echo esc_html( $sac_name ); ?></button>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3" data-sac-projects aria-live="polite">
			<?php foreach ( $sac_projects as $sac_p ) : ?>
				<article data-industry="<?php echo esc_attr( $sac_p['industry'] ); ?>" class="sac-project group flex flex-col overflow-hidden rounded-xl border border-border bg-card transition-colors hover:border-primary/40">
					<div class="relative h-[260px] overflow-hidden sm:h-[290px]">
						<?php if ( $sac_p['image'] ) : ?>
							<img src="<?php echo esc_url( $sac_p['image'] ); ?>" alt="<?php echo esc_attr( $sac_p['image_alt'] ? $sac_p['image_alt'] : $sac_p['title'] . ' project site' ); ?>" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
						<?php endif; ?>
						<?php if ( $sac_p['industry_name'] ) : ?>
							<span class="absolute left-3 top-3 rounded-full border border-border bg-background/80 px-3 py-1 text-xs font-medium text-foreground backdrop-blur"><?php echo esc_html( $sac_p['industry_name'] ); ?></span>
						<?php endif; ?>
					</div>
					<div class="flex flex-1 flex-col p-6">
						<h3 class="text-base font-semibold leading-snug"><?php echo esc_html( $sac_p['title'] ); ?></h3>
						<?php if ( $sac_p['location'] ) : ?>
							<p class="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground"><?php echo sac_icon( 'map-pin', 'h-3.5 w-3.5 text-primary' ); // phpcs:ignore ?><?php echo esc_html( $sac_p['location'] ); ?></p>
						<?php endif; ?>
						<div class="mt-4 flex flex-wrap gap-2">
							<?php foreach ( $sac_p['tags'] as $sac_tag ) : ?>
								<span class="rounded-md bg-secondary px-2.5 py-1 text-xs text-secondary-foreground"><?php echo esc_html( $sac_tag ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band' );
get_footer();
