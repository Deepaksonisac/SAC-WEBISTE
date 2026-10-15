<?php
/**
 * Template Name: SAC — Careers
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
$sac_sent  = isset( $_GET['sac_form'], $_GET['sac_status'] ) && 'career' === $_GET['sac_form'] && 'sent' === $_GET['sac_status'];
$sac_jobs  = sac_get_jobs();
$sac_field = 'mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10';
$sac_ready = function_exists( 'sac_companion_active' );

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 md:py-28">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
			<?php sac_reveal( 0 ); ?>
				<?php sac_eyebrow( sac_opt( 'careers_eyebrow' ), 'text-sm font-bold uppercase tracking-[0.22em] text-primary' ); ?>
				<h2 class="mt-4 text-4xl font-bold tracking-tight text-foreground md:text-5xl"><?php sac_e( 'careers_title' ); ?> <span class="block text-primary"><?php sac_e( 'careers_title_highlight' ); ?></span></h2>
				<p class="mt-7 max-w-2xl text-lg leading-8 text-muted-foreground"><?php sac_e( 'careers_p1' ); ?></p>
				<p class="mt-5 max-w-2xl text-lg leading-8 text-muted-foreground"><?php sac_e( 'careers_p2' ); ?></p>
				<a href="#openings" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 font-semibold text-primary-foreground transition hover:opacity-90"><?php sac_e( 'careers_btn_label' ); ?><?php echo sac_icon( 'arrow-right', 'h-4 w-4' ); // phpcs:ignore ?></a>
			</div>
			<?php sac_reveal( 1 ); ?>
				<div class="relative overflow-hidden rounded-3xl border border-primary/20 bg-primary/5 p-10 md:p-12">
					<div aria-hidden="true" class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-primary/10 blur-3xl"></div>
					<div class="relative">
						<div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary text-primary-foreground"><?php echo sac_icon( 'briefcase-business', 'h-8 w-8' ); // phpcs:ignore ?></div>
						<h3 class="mt-8 text-3xl font-bold"><?php sac_e( 'careers_card_title' ); ?></h3>
						<p class="mt-5 text-lg leading-8 text-muted-foreground"><?php sac_e( 'careers_card_text' ); ?></p>
						<div class="mt-8 grid gap-4 sm:grid-cols-2">
							<?php foreach ( (array) sac_opt( 'careers_highlights' ) as $sac_h ) : ?>
								<div class="rounded-xl border border-border bg-background p-5">
									<p class="text-2xl font-bold text-primary"><?php echo esc_html( $sac_h['value'] ); ?></p>
									<p class="mt-1 text-sm text-muted-foreground"><?php echo esc_html( $sac_h['label'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="border-y border-border bg-primary/[0.035] py-20 md:py-28">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<?php sac_reveal( 0, 'mx-auto max-w-3xl text-center' ); ?>
			<?php sac_eyebrow( sac_opt( 'benefits_eyebrow' ), 'text-sm font-bold uppercase tracking-[0.22em] text-primary' ); ?>
			<h2 class="mt-4 text-4xl font-bold tracking-tight md:text-5xl"><?php sac_e( 'benefits_title' ); ?></h2>
			<p class="mt-6 text-lg leading-8 text-muted-foreground"><?php sac_e( 'benefits_text' ); ?></p>
		</div>
		<div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( array_values( (array) sac_opt( 'benefits' ) ) as $sac_i => $sac_b ) : ?>
				<?php sac_reveal( $sac_i ); ?>
					<div class="group h-full rounded-2xl border border-border bg-background p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg">
						<div class="flex h-13 w-13 items-center justify-center rounded-xl bg-primary/10 text-primary"><?php echo sac_icon( $sac_b['icon'], 'h-6 w-6' ); // phpcs:ignore ?></div>
						<h3 class="mt-6 text-xl font-bold"><?php echo esc_html( $sac_b['title'] ); ?></h3>
						<p class="mt-3 leading-7 text-muted-foreground"><?php echo esc_html( $sac_b['text'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="openings" class="scroll-mt-24 py-20 md:py-28">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<?php sac_reveal( 0, 'max-w-3xl' ); ?>
			<?php sac_eyebrow( sac_opt( 'openings_eyebrow' ), 'text-sm font-bold uppercase tracking-[0.22em] text-primary' ); ?>
			<h2 class="mt-4 text-4xl font-bold tracking-tight md:text-5xl"><?php sac_e( 'openings_title' ); ?></h2>
			<p class="mt-5 text-lg leading-8 text-muted-foreground"><?php sac_e( 'openings_text' ); ?></p>
		</div>
		<?php if ( ! $sac_jobs ) : ?>
			<p class="mt-12 rounded-2xl border border-border bg-background p-8 text-muted-foreground"><?php esc_html_e( 'There are no open positions right now. You are welcome to send a general application below.', 'sac' ); ?></p>
		<?php endif; ?>
		<?php foreach ( $sac_jobs as $sac_job ) : ?>
			<?php sac_reveal( 1 ); ?>
				<div class="mt-12 overflow-hidden rounded-2xl border border-border bg-background shadow-sm">
					<div class="border-b border-border bg-primary/[0.04] p-7 md:p-9">
						<div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
							<div>
								<div class="flex flex-wrap items-center gap-3">
									<?php if ( $sac_job['badge'] ) : ?>
										<span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary"><?php echo esc_html( $sac_job['badge'] ); ?></span>
									<?php endif; ?>
									<?php if ( $sac_job['location'] ) : ?>
										<span class="flex items-center gap-1.5 text-sm text-muted-foreground"><?php echo sac_icon( 'map-pin', 'h-4 w-4 text-primary' ); // phpcs:ignore ?><?php echo esc_html( $sac_job['location'] ); ?></span>
									<?php endif; ?>
								</div>
								<h3 class="mt-5 text-2xl font-bold md:text-3xl"><?php echo esc_html( $sac_job['title'] ); ?></h3>
							</div>
							<a href="#apply" data-sac-apply="<?php echo esc_attr( $sac_job['title'] ); ?>" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-semibold text-primary-foreground transition hover:opacity-90"><?php esc_html_e( 'Apply Now', 'sac' ); ?><?php echo sac_icon( 'arrow-right', 'h-4 w-4' ); // phpcs:ignore ?></a>
						</div>
					</div>
					<div class="p-7 md:p-9">
						<div class="grid gap-6 border-b border-border pb-8 sm:grid-cols-3">
							<?php foreach ( array( 'experience' => __( 'Experience', 'sac' ), 'department' => __( 'Department', 'sac' ), 'employment' => __( 'Employment', 'sac' ) ) as $sac_k => $sac_label ) : ?>
								<div>
									<p class="text-xs font-bold uppercase tracking-wider text-muted-foreground"><?php echo esc_html( $sac_label ); ?></p>
									<p class="mt-2 text-lg font-semibold"><?php echo esc_html( $sac_job[ $sac_k ] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="mt-8 grid gap-10 lg:grid-cols-2">
							<div>
								<h4 class="text-lg font-bold"><?php esc_html_e( 'Required Knowledge', 'sac' ); ?></h4>
								<p class="mt-4 leading-7 text-muted-foreground"><?php echo esc_html( $sac_job['knowledge'] ); ?></p>
								<div class="mt-6 flex flex-wrap gap-2">
									<?php foreach ( $sac_job['skills'] as $sac_skill ) : ?>
										<span class="rounded-full border border-primary/20 bg-primary/5 px-3 py-1.5 text-sm font-medium text-primary"><?php echo esc_html( $sac_skill ); ?></span>
									<?php endforeach; ?>
								</div>
							</div>
							<div>
								<h4 class="text-lg font-bold"><?php esc_html_e( 'Key Responsibilities', 'sac' ); ?></h4>
								<div class="mt-4 flex flex-col gap-3">
									<?php foreach ( $sac_job['responsibilities'] as $sac_r ) : ?>
										<div class="flex items-start gap-3"><?php echo sac_icon( 'check-circle', 'mt-0.5 h-5 w-5 shrink-0 text-primary' ); // phpcs:ignore ?><p class="leading-6 text-muted-foreground"><?php echo esc_html( $sac_r ); ?></p></div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section id="apply" class="scroll-mt-24 border-y border-border bg-primary/[0.035] py-20 md:py-28">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
			<?php sac_reveal( 0 ); ?>
				<?php sac_eyebrow( sac_opt( 'apply_eyebrow' ), 'text-sm font-bold uppercase tracking-[0.22em] text-primary' ); ?>
				<h2 class="mt-4 text-4xl font-bold tracking-tight md:text-5xl"><?php sac_e( 'apply_title' ); ?></h2>
				<p class="mt-6 text-lg leading-8 text-muted-foreground"><?php sac_e( 'apply_text' ); ?></p>
				<div class="mt-9 rounded-2xl border border-border bg-background p-7">
					<h3 class="text-lg font-bold"><?php sac_e( 'apply_box_title' ); ?></h3>
					<p class="mt-3 leading-7 text-muted-foreground"><?php sac_e( 'apply_box_text' ); ?></p>
				</div>
			</div>
			<?php sac_reveal( 1 ); ?>
				<div class="rounded-2xl border border-border bg-background p-7 shadow-sm md:p-9">
					<?php if ( $sac_sent ) : ?>
						<div class="flex min-h-[420px] flex-col items-center justify-center text-center" role="status">
							<?php echo sac_icon( 'check-circle', 'h-14 w-14 text-primary' ); // phpcs:ignore ?>
							<h3 class="mt-4 text-2xl font-bold"><?php sac_e( 'careers_success_title' ); ?></h3>
							<p class="mt-2 max-w-sm text-muted-foreground"><?php sac_e( 'careers_success_text' ); ?></p>
						</div>
					<?php else : ?>
						<h3 class="text-2xl font-bold"><?php sac_e( 'apply_form_title' ); ?></h3>
						<p class="mt-2 text-muted-foreground"><?php sac_e( 'apply_form_text' ); ?></p>
						<div class="mt-6"><?php get_template_part( 'template-parts/form-status', null, array( 'form' => 'career' ) ); ?></div>
						<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mt-2" data-sac-form>
							<input type="hidden" name="action" value="sac_career">
							<input type="hidden" name="sac_return" value="<?php echo esc_url( get_permalink() ); ?>">
							<input type="hidden" name="sac_ts" value="<?php echo esc_attr( time() ); ?>">
							<?php wp_nonce_field( 'sac_career', 'sac_nonce' ); ?>
							<div class="sac-hp" aria-hidden="true"><label for="sac-website-c">Website</label><input id="sac-website-c" type="text" name="website" tabindex="-1" autocomplete="off"></div>
							<div class="grid gap-6 sm:grid-cols-2">
								<div><label for="fullName" class="text-sm font-semibold"><?php esc_html_e( 'Full Name *', 'sac' ); ?></label><input id="fullName" name="full_name" required maxlength="120" type="text" autocomplete="name" placeholder="<?php esc_attr_e( 'Your full name', 'sac' ); ?>" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div><label for="c-email" class="text-sm font-semibold"><?php esc_html_e( 'Email Address *', 'sac' ); ?></label><input id="c-email" name="email" required maxlength="160" type="email" autocomplete="email" placeholder="you@example.com" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div><label for="c-phone" class="text-sm font-semibold"><?php esc_html_e( 'Phone Number *', 'sac' ); ?></label><input id="c-phone" name="phone" required maxlength="30" pattern="[0-9+()\-\s]{6,30}" type="tel" autocomplete="tel" placeholder="+91" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div><label for="c-location" class="text-sm font-semibold"><?php esc_html_e( 'Current Location', 'sac' ); ?></label><input id="c-location" name="location" maxlength="120" type="text" placeholder="<?php esc_attr_e( 'City, State', 'sac' ); ?>" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div>
									<label for="position" class="text-sm font-semibold"><?php esc_html_e( 'Position Applied For *', 'sac' ); ?></label>
									<select id="position" name="position" required class="<?php echo esc_attr( $sac_field ); ?>">
										<option value="" disabled selected><?php esc_html_e( 'Select position', 'sac' ); ?></option>
										<?php foreach ( $sac_jobs as $sac_job ) : ?>
											<option value="<?php echo esc_attr( $sac_job['title'] ); ?>"><?php echo esc_html( $sac_job['title'] ); ?></option>
										<?php endforeach; ?>
										<option value="General Application"><?php esc_html_e( 'General Application', 'sac' ); ?></option>
									</select>
								</div>
								<div><label for="c-experience" class="text-sm font-semibold"><?php esc_html_e( 'Total Experience', 'sac' ); ?></label><input id="c-experience" name="experience" maxlength="60" type="text" placeholder="<?php esc_attr_e( 'e.g. 4 Years', 'sac' ); ?>" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div class="sm:col-span-2"><label for="c-company" class="text-sm font-semibold"><?php esc_html_e( 'Current Company', 'sac' ); ?></label><input id="c-company" name="company" maxlength="160" type="text" placeholder="<?php esc_attr_e( 'Current organization', 'sac' ); ?>" class="<?php echo esc_attr( $sac_field ); ?>"></div>
								<div class="sm:col-span-2"><label for="c-message" class="text-sm font-semibold"><?php esc_html_e( 'Message / Cover Note', 'sac' ); ?></label><textarea id="c-message" name="message" rows="5" maxlength="5000" placeholder="<?php esc_attr_e( 'Tell us about your experience and interest in this role.', 'sac' ); ?>" class="mt-2 w-full resize-none rounded-lg border border-border bg-background px-4 py-3 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"></textarea></div>
								<div class="sm:col-span-2">
									<label for="resume" class="text-sm font-semibold"><?php esc_html_e( 'Upload Resume / CV *', 'sac' ); ?></label>
									<div class="mt-2 rounded-xl border border-dashed border-primary/30 bg-primary/[0.025] p-5">
										<input id="resume" name="resume" required type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-max-bytes="5242880" class="w-full text-sm text-muted-foreground file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2.5 file:font-semibold file:text-primary-foreground">
										<p class="mt-3 text-xs text-muted-foreground"><?php esc_html_e( 'Accepted formats: PDF, DOC, DOCX (max 5 MB)', 'sac' ); ?></p>
									</div>
								</div>
							</div>
							<button type="submit" class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-7 py-3.5 font-semibold text-primary-foreground transition hover:opacity-90 disabled:opacity-50 sm:w-auto" <?php disabled( ! $sac_ready ); ?>><?php esc_html_e( 'Submit Application', 'sac' ); ?><?php echo sac_icon( 'arrow-right', 'h-4 w-4' ); // phpcs:ignore ?></button>
							<?php if ( ! $sac_ready ) : ?>
								<p class="mt-4 text-xs leading-5 text-muted-foreground"><?php esc_html_e( 'Activate the SAC Companion plugin to enable this form.', 'sac' ); ?></p>
							<?php endif; ?>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band', null, array( 'title' => sac_opt( 'careers_cta_title' ), 'text' => sac_opt( 'careers_cta_text' ) ) );
get_footer();
