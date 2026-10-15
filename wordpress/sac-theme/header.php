<?php
/**
 * Site header: fixed navbar with desktop links and the mobile slide-in menu.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_links = sac_menu_items( 'primary' );
?><!doctype html>
<html <?php language_attributes(); ?> class="bg-background">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:rounded-md focus:bg-primary focus:px-4 focus:py-2 focus:text-primary-foreground" href="#sac-main"><?php esc_html_e( 'Skip to content', 'sac' ); ?></a>

<header id="sac-header" data-solid="<?php echo is_front_page() ? '0' : '1'; ?>" class="sac-header fixed inset-x-0 top-0 z-50 border-b bg-background transition-shadow duration-300 <?php echo is_front_page() ? 'border-border/60' : 'is-solid border-border'; ?>">
	<nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-6 px-4 sm:h-20 sm:px-6 lg:h-24 lg:px-8" aria-label="<?php esc_attr_e( 'Primary', 'sac' ); ?>">
		<?php get_template_part( 'template-parts/site-logo', null, array( 'variant' => 'header' ) ); ?>

		<ul class="hidden items-center gap-1 lg:flex">
			<?php foreach ( $sac_links as $sac_link ) : ?>
				<li>
					<a href="<?php echo esc_url( $sac_link['url'] ); ?>" <?php echo $sac_link['target'] ? 'target="' . esc_attr( $sac_link['target'] ) . '" rel="noopener"' : ''; ?> <?php echo $sac_link['active'] ? 'aria-current="page"' : ''; ?> class="rounded-md px-3 py-2 text-sm font-medium transition-colors <?php echo $sac_link['active'] ? 'text-primary' : 'text-muted-foreground hover:text-foreground'; ?>"><?php echo esc_html( $sac_link['label'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="hidden items-center gap-3 lg:flex">
			<a href="<?php echo esc_url( sac_link( sac_opt( 'header_cta_url' ) ) ); ?>" class="sac-btn"><?php sac_e( 'header_cta_label' ); ?></a>
		</div>

		<div class="flex items-center gap-2 lg:hidden">
			<button type="button" data-sac-menu-open aria-controls="sac-mobile-menu" aria-expanded="false" class="inline-flex items-center justify-center rounded-md p-2 text-foreground" aria-label="<?php esc_attr_e( 'Open menu', 'sac' ); ?>">
				<?php echo sac_icon( 'menu', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</button>
		</div>
	</nav>

	<div data-sac-menu-backdrop class="sac-menu-backdrop fixed inset-0 z-50 h-[100dvh] w-screen bg-background/70 backdrop-blur-sm lg:hidden" hidden></div>
	<aside id="sac-mobile-menu" class="sac-menu-panel fixed inset-y-0 right-0 z-[60] flex h-[100dvh] w-72 max-w-[80vw] flex-col gap-2 overflow-y-auto border-l border-black/10 bg-[#c8f0d0] p-6 text-black shadow-xl lg:hidden" aria-label="<?php esc_attr_e( 'Mobile menu', 'sac' ); ?>" hidden>
		<div class="mb-4 flex items-center justify-between">
			<?php get_template_part( 'template-parts/site-logo', null, array( 'variant' => 'menu' ) ); ?>
			<button type="button" data-sac-menu-close class="rounded-md p-2 text-black" aria-label="<?php esc_attr_e( 'Close menu', 'sac' ); ?>">
				<?php echo sac_icon( 'x', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</button>
		</div>
		<?php foreach ( $sac_links as $sac_link ) : ?>
			<a href="<?php echo esc_url( $sac_link['url'] ); ?>" data-sac-menu-link <?php echo $sac_link['active'] ? 'aria-current="page"' : ''; ?> class="rounded-md px-3 py-3 text-base font-medium text-black transition-colors hover:bg-primary-foreground/20 hover:text-black <?php echo $sac_link['active'] ? 'bg-primary-foreground/25' : ''; ?>"><?php echo esc_html( $sac_link['label'] ); ?></a>
		<?php endforeach; ?>
		<a href="<?php echo esc_url( sac_link( sac_opt( 'header_cta_url' ) ) ); ?>" data-sac-menu-link class="sac-btn mt-4 bg-black text-white hover:bg-black/80"><?php sac_e( 'header_cta_label' ); ?></a>
	</aside>
</header>

<main id="sac-main" class="sac-page-enter">
