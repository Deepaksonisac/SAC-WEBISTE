<?php
/**
 * Site footer.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

$sac_social = array(
	'social_linkedin' => array( 'LinkedIn', 'M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.13 1.45-2.13 2.94v5.67H9.35V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14zM7.12 20.45H3.55V9h3.57v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0z' ),
	'social_x'        => array( 'X', 'M18.24 2.25h3.31l-7.23 8.26L23 21.75h-6.63l-5.2-6.79-5.95 6.79H1.9l7.73-8.84L1 2.25h6.8l4.7 6.21 5.74-6.21zm-1.16 17.52h1.83L7.02 4.13H5.06l12.02 15.64z' ),
	'social_facebook' => array( 'Facebook', 'M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z' ),
);
?>
</main>

<footer class="border-t border-border bg-background">
	<div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
		<div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
			<div>
				<?php get_template_part( 'template-parts/site-logo', null, array( 'variant' => 'footer' ) ); ?>
				<p class="mt-4 max-w-xs text-sm leading-relaxed text-muted-foreground"><?php sac_e( 'footer_tagline' ); ?></p>
				<div class="mt-5 flex gap-3">
					<?php foreach ( $sac_social as $sac_key => $sac_item ) : ?>
						<?php
						$sac_href = sac_opt( $sac_key );
						if ( 'none' === $sac_href ) {
							continue;
						}
						?>
						<a href="<?php echo esc_url( $sac_href ); ?>" aria-label="<?php echo esc_attr( $sac_item[0] ); ?>" <?php echo '#' !== $sac_href ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="flex h-9 w-9 items-center justify-center rounded-md border border-border text-muted-foreground transition-colors hover:border-primary hover:text-primary">
							<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-4 w-4"><path d="<?php echo esc_attr( $sac_item[1] ); ?>"/></svg>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<div>
				<h3 class="text-sm font-semibold uppercase tracking-wider"><?php esc_html_e( 'Quick Links', 'sac' ); ?></h3>
				<ul class="mt-4 flex flex-col gap-2.5">
					<?php foreach ( sac_menu_items( 'footer_quick' ) as $sac_link ) : ?>
						<li><a href="<?php echo esc_url( $sac_link['url'] ); ?>" class="text-sm text-muted-foreground transition-colors hover:text-foreground"><?php echo esc_html( $sac_link['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h3 class="text-sm font-semibold uppercase tracking-wider"><?php esc_html_e( 'Services', 'sac' ); ?></h3>
				<ul class="mt-4 flex flex-col gap-2.5">
					<?php foreach ( sac_menu_items( 'footer_services' ) as $sac_link ) : ?>
						<li class="text-sm text-muted-foreground"><a href="<?php echo esc_url( $sac_link['url'] ); ?>" class="cursor-pointer transition-colors hover:text-foreground focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"><?php echo esc_html( $sac_link['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h3 class="text-sm font-semibold uppercase tracking-wider"><?php esc_html_e( 'Get in Touch', 'sac' ); ?></h3>
				<ul class="mt-4 flex flex-col gap-3">
					<?php foreach ( array( 'phone_1', 'phone_2' ) as $sac_key ) : ?>
						<?php if ( sac_opt( $sac_key ) ) : ?>
							<li class="flex items-start gap-2.5 text-sm text-muted-foreground">
								<?php echo sac_icon( 'phone', 'mt-0.5 h-4 w-4 shrink-0 text-primary' ); // phpcs:ignore ?>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', sac_opt( $sac_key ) ) ); ?>" class="transition-colors hover:text-primary"><?php sac_e( $sac_key ); ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php foreach ( array( 'email_1', 'email_2' ) as $sac_key ) : ?>
						<?php if ( sac_opt( $sac_key ) ) : ?>
							<li class="flex items-start gap-2.5 text-sm text-muted-foreground">
								<?php echo sac_icon( 'mail', 'mt-0.5 h-4 w-4 shrink-0 text-primary' ); // phpcs:ignore ?>
								<a href="mailto:<?php echo esc_attr( antispambot( sac_opt( $sac_key ) ) ); ?>" class="transition-colors hover:text-primary"><?php echo esc_html( antispambot( sac_opt( $sac_key ) ) ); ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
					<li class="text-sm leading-relaxed text-muted-foreground"><?php echo nl2br( esc_html( sac_opt( 'address' ) ) ); ?></li>
				</ul>
			</div>
		</div>

		<div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-border pt-6 text-sm text-muted-foreground sm:flex-row">
			<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php esc_html_e( 'Secure Automation Consultants. All rights reserved.', 'sac' ); ?></p>
			<p><?php sac_e( 'footer_location' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
