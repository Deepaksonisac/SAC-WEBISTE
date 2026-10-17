<?php
/**
 * Count-up statistics row.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_stats = sac_opt( 'stats' );
if ( ! is_array( $sac_stats ) ) {
	return;
}
?>
<div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
	<?php foreach ( array_values( $sac_stats ) as $sac_i => $sac_stat ) : ?>
		<?php sac_reveal( $sac_i, 'rounded-xl border border-border bg-card p-6 text-center shadow-sm' ); ?>
			<div class="font-heading text-3xl font-bold text-primary sm:text-4xl">
				<?php if ( ! empty( $sac_stat['display'] ) ) : ?>
					<?php echo esc_html( $sac_stat['display'] ); ?>
				<?php else : ?>
					<span data-sac-count="<?php echo esc_attr( (int) $sac_stat['value'] ); ?>" data-suffix="<?php echo esc_attr( $sac_stat['suffix'] ); ?>"><?php echo esc_html( (int) $sac_stat['value'] . $sac_stat['suffix'] ); ?></span>
				<?php endif; ?>
			</div>
			<div class="mt-2 text-sm text-muted-foreground"><?php echo esc_html( $sac_stat['label'] ); ?></div>
		</div>
	<?php endforeach; ?>
</div>
