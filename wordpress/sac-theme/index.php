<?php
/**
 * Fallback template for posts, archives and search.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="border-b border-border bg-secondary/50">
	<div class="mx-auto max-w-7xl px-4 pb-14 pt-28 sm:px-6 sm:pt-32 lg:px-8">
		<h1 class="max-w-3xl text-balance text-4xl font-bold tracking-tight sm:text-5xl"><?php echo esc_html( is_singular() ? get_the_title() : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
	</div>
</section>
<section class="py-20 sm:py-24">
	<div class="sac-prose mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( is_singular() ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<article class="mb-10 border-b border-border pb-10">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endif; ?>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'sac' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
