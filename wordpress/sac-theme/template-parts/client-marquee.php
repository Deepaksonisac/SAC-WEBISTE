<?php
/**
 * Optional client marquee. Disabled by default (it was removed from the live
 * home page); enable it under SAC Settings → Home. Clients are editable.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_clients = sac_get_clients();
if ( ! $sac_clients ) {
	return;
}
$sac_render = function ( $hidden ) use ( $sac_clients ) {
	echo '<ul class="sac-marquee-group flex shrink-0 items-center gap-12 pr-12"' . ( $hidden ? ' aria-hidden="true"' : '' ) . '>';
	foreach ( $sac_clients as $client ) {
		echo '<li class="flex shrink-0 items-center">';
		if ( $client['logo'] ) {
			printf( '<img src="%s" alt="%s" loading="lazy" decoding="async" class="h-10 w-auto max-w-[160px] object-contain opacity-70 grayscale transition hover:opacity-100 hover:grayscale-0">', esc_url( $client['logo'] ), esc_attr( $hidden ? '' : $client['name'] ) );
		} else {
			printf( '<span class="whitespace-nowrap font-heading text-lg font-semibold text-muted-foreground">%s</span>', esc_html( $client['name'] ) );
		}
		echo '</li>';
	}
	echo '</ul>';
};
?>
<section class="border-y border-border bg-background py-12" aria-label="<?php esc_attr_e( 'Clients', 'sac' ); ?>">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<p class="text-center text-sm font-semibold uppercase tracking-[0.2em] text-primary"><?php sac_e( 'marquee_title' ); ?></p>
	</div>
	<div class="sac-marquee mt-8 flex overflow-hidden" style="--sac-marquee-duration:<?php echo esc_attr( max( 20, count( $sac_clients ) * 3.5 ) ); ?>s">
		<div class="sac-marquee-track flex">
			<?php $sac_render( false ); ?>
			<?php $sac_render( true ); ?>
		</div>
	</div>
</section>
