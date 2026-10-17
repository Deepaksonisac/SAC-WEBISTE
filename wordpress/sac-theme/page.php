<?php
/**
 * Generic page (privacy policy, etc.) styled like the interior pages.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/page-header' );
?>
<section class="py-20 sm:py-24">
	<div class="sac-prose mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
		<?php
		while ( have_posts() ) {
			the_post();
			the_content();
		}
		?>
	</div>
</section>
<?php
get_footer();
