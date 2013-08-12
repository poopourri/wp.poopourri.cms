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
$(document).ready(function() {
	load_video();
	$('#video_player').hide();
	$('.vidLink').click(function(){
		$('#video_player_new').remove();
		$('#video_player').show();
	});
});

function load_video(vid_id, autoplay, time){
	$('#video_player').html('<iframe title="YouTube video player" class="youtube-player" type="text/html" width="502" height="280" src="http://www.youtube.com/embed/'+vid_id+'?rel=0&amp;hd=1&amp;wmode=transparent&amp;autoplay='+(autoplay==true ? '1':'0')+(time>0?'&amp;start='+time:'')+'&amp;showinfo=0&amp;color=white&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;origin=https%3A%2F%2Forapup.com" frameborder="0"></iframe>');
}
</script>

<div id="primary-orapup" class="site-content">
		<div id="content" role="main">

         <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
         <div class="inner">
	       <h1><?php // the_title(); ?></h1>
	       <?php $salesInfo = getSalesInfoDisplay();
	       ?>
	       <input type="hidden" id="total_people" name="array1" value="<?php echo($salesInfo['total_people']); ?>">
           <input type="hidden" id="total_sale" name="array2" value="<?php echo ($salesInfo['total_sale']); ?>">
	       
	       <div class="header-title-img"><?php print_custom_field('topheaderimg:do_shortcode'); ?></div>
	       
	       <div class="top-head-left">
	          <div class="video-home" id="offer"><?php the_content(); ?>  </div>
	       </div>
	       
	       <div class="top-head-right">
	       
	       <center>
	       
	          <?php print_custom_field('topheaderrightdetail:do_shortcode'); ?>
	          
	       </center> 
	       <div class="social-network-icon">
	             <!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count" addthis:url="http://www.orapup.com" addthis:title="Orapup" addthis:description="Beat Bad Dog Breath without a Toothbrush!"></a> 
				<a class="addthis_button_tweet" addthis:url="http://www.orapup.com" addthis:title="Orapup" addthis:description="Beat Bad Dog Breath without a Toothbrush!"></a>
				<a class="addthis_button_pinterest_pinit" addthis:url="http://www.orapup.com" addthis:title="Orapup" addthis:description="Beat Bad Dog Breath without a Toothbrush!"></a>
				<a class="addthis_counter addthis_pill_style" addthis:url="http://www.orapup.com" addthis:title="Orapup" addthis:description="Beat Bad Dog Breath without a Toothbrush!"></a>
				</div>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":true,"data_track_addressbar_paths":["/*"]};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5092ae500ffdd73e"></script>
		   <!-- AddThis Button END --> 
		  
	       </div>  
	       </div>
	    
		</div>
		
		<div class="how-it-works">
			  <?php print_custom_field('howitworks:do_shortcode'); ?>
		</div>
		
		<div class="media-buzz-home">
			
			<?php print_custom_field('mediabuzz:do_shortcode'); ?>
		
		</div>
		
		
		<div class="add-video-playlist" >
			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div id="video-playlist-show" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div><!-- #secondary -->
			<?php endif; ?>
			<input type="hidden" id="counter" value="1">
			<div id="more-video-show"><a id="Show-video-more">Show More Videos</a> </div>
		</div>
		
		
		<div class="veta-love">
			<?php print_custom_field('vetsloveit:do_shortcode'); ?>
		</div>
		
		
		<div class="packages-order-now">
			<?php print_custom_field('ordernow:do_shortcode'); ?>
		</div>
	
		</div><!-- #content -->
</div><!-- #primary -->


<?php endwhile; // end of the loop. ?>

<?php //get_sidebar( 'front' ); ?>

<!-- Google Code for Orapup Home Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "fLa2CN2X-wgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=fLa2CN2X-wgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php get_footer(); ?>
