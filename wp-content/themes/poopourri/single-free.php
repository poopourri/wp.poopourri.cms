<?php
/**
 * Template Name: Free Page Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div id="dialog" title="" style="display:none;">
<iframe src="<?php get_bloginfo('wpurl'); ?>/limited-offer/" width="525" height="505"></iframe>
</div>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui.css" />
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jslasted/jcarousellite_1.0.1.pack.js" type="text/javascript"></script>


<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function() {
	 $(".items").jCarouselLite({
	        btnNext: ".next",
	        btnPrev: ".prev"
	    });
	 $(function() {
		 $( "#dialog" ).dialog({ 
			 width:  560,
			 height: 570,
			 autoOpen: false,
			 model: true  
			 });
		  });
	 popupHandler();
});

function popupHandler(){
	$('#offer_button').click(function(){
		$( "#dialog" ).show();
		$("#dialog").dialog("open");
	    
	});
}

        
</script>




<div id="primary-help" class="site-content">
		<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	

	    <h1><?php // the_title(); ?></h1>
	    
    
	    <div class="limited-offer" id="offer"><?php the_content(); ?>  </div>  
	    
	    <div class="content-top-page">
	    <div class="content-top-left-page">
	    
	    
		<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
			<div class="thired custom-widgets">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
			</div><!-- .second -->
		<?php endif; ?>

	    <div id="content-left-side">
			       <div class="space-left">&nbsp;</div>
			       <div class="content-left-text">
			            <?php print_custom_field('contentlefttop:do_shortcode'); ?>
			       </div>
			    </div>
		 </div>
	    <div class="content-top-right-page">
	    <div class="space-height"> 
	    
	    </div>
	    <div  class="title-head-top">
	     <?php print_custom_field('headtitletop:do_shortcode'); ?>
	    </div>
	    <div id="content-text-top">
	    <?php print_custom_field('contentright:do_shortcode'); ?>
	    <div id="buy_now_button">
		    <a class="buy_now" href="/products/"><span id="buy_now_text"></span></a>
	    </div>
	    </div>	
	    </div>
	    
	    </div>
			 <div class="title-taking"><?php print_custom_field('titleoforabursh:do_shortcode'); ?></div>
		<div class="reviews-content">
		
		<img class="click-here-img" src="<?php echo get_template_directory_uri(); ?>/images/ClickHere.png"/>
		
		<div class="content-below-page">
		<div class="content-below-left-page">
		<?php print_custom_field('contentleftbelow:do_shortcode'); ?>
		</div>
		
		<div class="content-below-middel-pages"><?php print_custom_field('youtubgalleryone:do_shortcode'); ?></div>
		
		
		<div class="content-below-right-pages"> 
		    <?php if ( function_exists( 'get_smooth_slider' ) ) { get_smooth_slider(); } ?> 
		    <?php print_custom_field('youtubgallerytwo:do_shortcode'); ?>
		    
		</div>
		
		</div>
		</div>
		<?php print_custom_field('youtubeimg:do_shortcode'); ?>
		<?php if (function_exists (udisg)) udisg(); ?> 
		
	

		</div><!-- #content -->
	</div><!-- #primary -->


<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
