<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){
	function formatText(index, panel) {
		  return index + "";
	    }
      $(function () {
      
          $('.anythingFader').anythingFader({
              autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
              delay: 5000,                    // How long between slide transitions in AutoPlay mode
              startStopped: false,            // If autoPlay is on, this can force it to start stopped
              animationTime: 500,             // How long the slide transition takes
              hashTags: true,                 // Should links change the hashtag in the URL?
              buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
              pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
              startText: "Go",                // Start text
              stopText: "Stop",               // Stop text
              navigationFormatter: formatText   // Details at the top of the file on this use (advanced use)
          });
          
          $("#slide-jump").click(function(){
              $('.anythingFader').anythingFader(6);
          });
          
      });
});
</script>
<div id="primary-orapup" class="site-content">
		<div class="by-orabrush"></div>
		<div id="content" role="main">
		<!-- mobile front page -->
         <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
         <div class="inner">
	       <h1><?php // the_title(); ?></h1>
             

			<?php print_custom_field('orabrushmobilefront'); ?>
			<div class="youtube-video" >
				<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
				<div id="show-video-playlist" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				</div> 
				<?php endif; ?>
				<input type="hidden" id="counter" value="1">
			</div>
			<div class="veta-love">
				<?php print_custom_field('orapupfrontvetslove'); ?>
			</div>
			</div>
		</div> 
		<?php endwhile; // end of the loop. ?>
</div>
<div class="mobile-footer"> <?php get_footer(); ?></div>