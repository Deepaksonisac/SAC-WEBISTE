<?php
/**
 * Logo link. Variants match the original SiteLogo component sizes.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_variant = isset( $args['variant'] ) ? $args['variant'] : 'header';
$sac_sizes   = array(
	'header' => 'w-[120px] sm:w-[150px] lg:w-[176px]',
	'footer' => 'w-[200px]',
	'menu'   => 'w-[132px]',
);
$sac_class   = isset( $sac_sizes[ $sac_variant ] ) ? $sac_sizes[ $sac_variant ] : $sac_sizes['header'];
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex shrink-0 items-center <?php echo 'footer' === $sac_variant ? 'w-fit' : ''; ?>" aria-label="<?php esc_attr_e( 'Secure Automation Consultants home', 'sac' ); ?>">
	<img src="<?php echo esc_url( sac_opt_image( 'logo' ) ); ?>" alt="<?php esc_attr_e( 'SAC — business is people. BMS, Security, Fire, IT, AV', 'sac' ); ?>" width="1416" height="724" class="h-auto max-w-none object-contain <?php echo esc_attr( $sac_class ); ?>" <?php echo 'header' === $sac_variant ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async">
</a>
