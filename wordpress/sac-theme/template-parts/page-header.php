<?php
/**
 * Interior page header (eyebrow, title, subtitle) — editable per page.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_header = sac_page_header_data();
?>
<section class="relative overflow-hidden border-b border-border bg-secondary/50">
	<div aria-hidden="true" class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-primary/10 blur-3xl"></div>
	<div class="mx-auto max-w-7xl px-4 pb-14 pt-28 sm:px-6 sm:pb-16 sm:pt-32 lg:px-8">
		<?php if ( $sac_header['eyebrow'] ) : ?>
			<p class="sac-rise text-sm font-semibold uppercase tracking-[0.2em] text-primary" style="--d:0s"><?php echo esc_html( $sac_header['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1 class="sac-rise mt-4 max-w-3xl text-balance text-4xl font-bold tracking-tight sm:text-5xl" style="--d:.06s"><?php echo esc_html( $sac_header['heading'] ); ?></h1>
		<?php if ( $sac_header['subtitle'] ) : ?>
			<p class="sac-rise mt-5 max-w-2xl text-pretty text-base leading-relaxed text-muted-foreground sm:text-lg" style="--d:.12s"><?php echo esc_html( $sac_header['subtitle'] ); ?></p>
		<?php endif; ?>
	</div>
</section>
