<?php
/**
 * Template Name: Press Left Side Page Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div class="press-left-siderbar">
<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-5' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
</div>	
	

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	
<?php get_footer(); ?>	