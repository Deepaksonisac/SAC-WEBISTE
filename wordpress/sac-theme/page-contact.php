<?php
/**
 * Template Name: SAC — Contact
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
$sac_sent  = isset( $_GET['sac_form'], $_GET['sac_status'] ) && 'contact' === $_GET['sac_form'] && 'sent' === $_GET['sac_status'];
$sac_input = 'w-full rounded-md border border-input bg-background px-3.5 py-2.5 text-sm text-foreground placeholder:text-muted-foreground/70 outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/25';
$sac_ready = function_exists( 'sac_companion_active' );

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 sm:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="grid gap-8 lg:grid-cols-5">
			<?php sac_reveal( 0, 'lg:col-span-3' ); ?>
				<div id="contact-form" class="scroll-mt-28 rounded-xl border border-border bg-card p-6 sm:p-8">
					<?php if ( $sac_sent ) : ?>
						<div class="flex min-h-[420px] flex-col items-center justify-center text-center" role="status">
							<?php echo sac_icon( 'check-circle', 'h-14 w-14 text-primary' ); // phpcs:ignore ?>
							<h3 class="mt-4 text-xl font-semibold"><?php sac_e( 'contact_success_title' ); ?></h3>
							<p class="mt-2 max-w-sm text-muted-foreground"><?php sac_e( 'contact_success_text' ); ?></p>
						</div>
					<?php else : ?>
						<?php get_template_part( 'template-parts/form-status', null, array( 'form' => 'contact' ) ); ?>
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="grid gap-4 sm:grid-cols-2" data-sac-form>
							<input type="hidden" name="action" value="sac_contact">
							<input type="hidden" name="sac_return" value="<?php echo esc_url( get_permalink() ); ?>">
							<input type="hidden" name="sac_ts" value="<?php echo esc_attr( time() ); ?>">
							<?php wp_nonce_field( 'sac_contact', 'sac_nonce' ); ?>
							<div class="sac-hp" aria-hidden="true"><label for="sac-website">Website</label><input id="sac-website" type="text" name="website" tabindex="-1" autocomplete="off"></div>
							<div>
								<label for="name" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Name', 'sac' ); ?></label>
								<input id="name" name="name" required maxlength="120" autocomplete="name" class="<?php echo esc_attr( $sac_input ); ?>" placeholder="<?php esc_attr_e( 'Your name', 'sac' ); ?>">
							</div>
							<div>
								<label for="company" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Company', 'sac' ); ?></label>
								<input id="company" name="company" maxlength="160" autocomplete="organization" class="<?php echo esc_attr( $sac_input ); ?>" placeholder="<?php esc_attr_e( 'Organisation', 'sac' ); ?>">
							</div>
							<div>
								<label for="email" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Email', 'sac' ); ?></label>
								<input id="email" name="email" type="email" required maxlength="160" autocomplete="email" class="<?php echo esc_attr( $sac_input ); ?>" placeholder="you@company.com">
							</div>
							<div>
								<label for="phone" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Phone', 'sac' ); ?></label>
								<input id="phone" name="phone" type="tel" maxlength="30" pattern="[0-9+()\-\s]{6,30}" autocomplete="tel" class="<?php echo esc_attr( $sac_input ); ?>" placeholder="+91">
							</div>
							<div class="sm:col-span-2">
								<label for="requirement" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Project Requirement', 'sac' ); ?></label>
								<input id="requirement" name="requirement" maxlength="200" class="<?php echo esc_attr( $sac_input ); ?>" placeholder="<?php esc_attr_e( 'e.g. IP surveillance, BMS, access control', 'sac' ); ?>">
							</div>
							<div class="sm:col-span-2">
								<label for="message" class="mb-1.5 block text-sm font-medium"><?php esc_html_e( 'Message', 'sac' ); ?></label>
								<textarea id="message" name="message" rows="4" maxlength="5000" class="<?php echo esc_attr( $sac_input ); ?> resize-none" placeholder="<?php esc_attr_e( 'Tell us about your facility and goals', 'sac' ); ?>"></textarea>
							</div>
							<div class="sm:col-span-2">
								<button type="submit" class="sac-btn sac-btn-lg w-full sm:w-auto" <?php disabled( ! $sac_ready ); ?>><?php esc_html_e( 'Submit Enquiry', 'sac' ); ?></button>
								<?php if ( ! $sac_ready ) : ?>
									<p class="mt-3 text-xs text-muted-foreground"><?php esc_html_e( 'Activate the SAC Companion plugin to enable this form.', 'sac' ); ?></p>
								<?php endif; ?>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>

			<?php sac_reveal( 1, 'lg:col-span-2' ); ?>
				<div class="flex h-full flex-col gap-6">
					<div class="rounded-xl border border-border bg-card p-6">
						<ul class="flex flex-col gap-5">
							<li class="flex items-start gap-3">
								<?php echo sac_icon( 'phone', 'mt-0.5 h-5 w-5 shrink-0 text-primary' ); // phpcs:ignore ?>
								<div class="text-sm">
									<p class="font-medium"><?php esc_html_e( 'Phone', 'sac' ); ?></p>
									<?php foreach ( array( 'phone_1', 'phone_2' ) as $sac_key ) : ?>
										<?php if ( sac_opt( $sac_key ) ) : ?>
											<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', sac_opt( $sac_key ) ) ); ?>" class="block text-muted-foreground hover:text-foreground"><?php sac_e( $sac_key ); ?></a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</li>
							<li class="flex items-start gap-3">
								<?php echo sac_icon( 'mail', 'mt-0.5 h-5 w-5 shrink-0 text-primary' ); // phpcs:ignore ?>
								<div class="text-sm">
									<p class="font-medium"><?php esc_html_e( 'Email', 'sac' ); ?></p>
									<?php foreach ( array( 'email_1', 'email_2' ) as $sac_key ) : ?>
										<?php if ( sac_opt( $sac_key ) ) : ?>
											<a href="mailto:<?php echo esc_attr( antispambot( sac_opt( $sac_key ) ) ); ?>" class="block text-muted-foreground hover:text-foreground"><?php echo esc_html( antispambot( sac_opt( $sac_key ) ) ); ?></a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</li>
							<li class="flex items-start gap-3">
								<?php echo sac_icon( 'map-pin', 'mt-0.5 h-5 w-5 shrink-0 text-primary' ); // phpcs:ignore ?>
								<div class="text-sm">
									<p class="font-medium"><?php esc_html_e( 'Office', 'sac' ); ?></p>
									<p class="leading-relaxed text-muted-foreground"><?php echo nl2br( esc_html( sac_opt( 'address' ) ) ); ?></p>
								</div>
							</li>
						</ul>
					</div>
					<div class="min-h-[220px] flex-1 overflow-hidden rounded-xl border border-border">
						<iframe title="<?php esc_attr_e( 'SAC office location on map', 'sac' ); ?>" src="<?php echo esc_url( 'https://www.google.com/maps?q=' . rawurlencode( sac_opt( 'map_query' ) ) . '&output=embed' ); ?>" class="h-full min-h-[220px] w-full grayscale-[0.15]" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
