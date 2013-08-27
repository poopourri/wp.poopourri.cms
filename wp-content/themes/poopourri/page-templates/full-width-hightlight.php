<?php
/**
 * Template Name: Full-width Page Template, With Highlight
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Poopourri
 * @since Poopourri 1.0
 */

get_header(); ?>

	<div id="widget_highlight">
		<div class="content-inner" style="padding-top: 35px;position:relative;">
		<p>
			<img class="alignleft" alt="Spritz the bowl before-you-go &amp; no one else will ever know" src="/wp-content/themes/poopourri/images/spritz_the_bowl_header.png" width="916" height="88">
		</p>
  		<iframe title="YouTube video player" class="youtube-player" type="text/html" width="630" height="355" src="http://www.youtube.com/embed/XrswE_Q2900?rel=0&amp;hd=1&amp;wmode=transparent&amp;autoplay=0&amp;showinfo=0&amp;color=white&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;origin=https%3A%2F%2Forapup.com" frameborder="0" style="position: absolute;left: 0px;top: 155px;box-shadow: 1px 2px 4px;"></iframe>
  
  		<img src="/wp-content/themes/poopourri/images/leave_toilet_smelling_better.png" style="position:absolute;right:0px;top:155px;">
  		<p style="position:absolute;right:3px;top:220px;width:380px;font-size:14pt;text-align:left;">
			Poo~Pourri is the award-winning before-you-go toilet spray.
		</p>
		<img src="/wp-content/themes/poopourri/images/good_housekeeping_seal.png" style="position:absolute;bottom:25px;right:80px;">
  		<p style="position:absolute;right:0px;bottom: 225px;width:380px;text-align:center;font-size:14pt;font-weight:bold;color:#0088B0;">
			Over 4 million sold!
		</p>
  		<a href="#" class="order_now_btn" style="position:absolute;right:0px;bottom: 165px;"></a>
  
		</div>
		<div class="shadow_left"></div>
		<div class="shadow_right"></div>
		<div style="background-image:url(/wp-content/themes/poopourri/images/bottom_background_shadow.png);width:100%;height:5px;margin-top: -5px;"></div>
	</div>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>