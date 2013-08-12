<?php
/**
 * Template Name: Lickies Mobile Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div id="primary" class="site-content">
		<div id="content" role="main">
		
		<?php print_custom_field('topheaderimg:do_shortcode'); ?>
		

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
