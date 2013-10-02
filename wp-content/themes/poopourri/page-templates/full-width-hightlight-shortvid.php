<?php
/**
 * Template Name: Home Page Short Video
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
		<center>
			<img alt="Spritz the bowl before-you-go &amp; no one else will ever know" src="/wp-content/themes/poopourri/images/spritz-before-fancy.png" width="695" height="88">
		</center>
<script>

function loadMovie(){
  $('#movie_container').html('<iframe title="YouTube video player" class="youtube-player" type="text/html" width="630" height="355" src="http://www.youtube.com/embed/ZKLnhuzh9uY?rel=0&amp;hd=1&amp;wmode=transparent&amp;autoplay=1&amp;showinfo=0&amp;color=white&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;origin=https%3A%2F%2Fpoopourri.com" frameborder="0"></iframe>');
}

</script>
<div style="position: absolute;left: 0px;top: 155px;box-shadow: 1px 2px 4px;width:630px;height:355px;" id="movie_container"><a href="javascript:void(0);" onclick="loadMovie();" onmouseover="$('#thumbnail_movie').prop('src','/wp-content/themes/poopourri/images/play_button_hvr.png');" onmouseout="$('#thumbnail_movie').prop('src','/wp-content/themes/poopourri/images/play_button.png');"><img id="thumbnail_movie" src="/wp-content/themes/poopourri/images/play_button.png" style="cursor:pointer;background-image:url('/wp-content/uploads/2013/09/variation-1-1024x575.jpg');background-position:center;background-size:cover;"></a></div>
 		<img src="/wp-content/uploads/2013/09/leave_the_toilet_smelling_better.png" style="position:absolute;right:160px;top:155px;">
  		<p style="position:absolute;right:132px;top:250px;width:250px;font-size:14pt;text-align:left;">
			Poo-Pourri is a blend of essential oils that virtually eliminates bathroom odors! Our award-winning before-you-go&reg; sprays come in a variety of scents and sizes. 		</p>
		<img src="/wp-content/uploads/2013/08/By-Scent_Original-4oz-218x300.png" style="position:absolute;bottom:125px;right:-90px;">
  		<p style="position:absolute;right:100px;bottom: 100px;width:280px;text-align:center;font-size:14pt;font-weight:bold;color:#0088B0;" id="buy_now_text">
			Over 4 million sold!
		</p>
  		<a href="packages" class="order_now_btn" style="position:absolute;right:0px;bottom: 30px;"></a>
 
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style " style="position:absolute;left:0px;bottom:6px;width:400px;height:20px;">
<a class="addthis_button_facebook_like" fb:like:layout="button_count" addthis:url="http://www2.poopourri.com" addthis:title="Girls Don't Poop - Poopourri.com" addthis:description="Yes, this is a real product! Yes, it's scientifically proven to work. http://poopourri.com"></a>
<a class="addthis_button_tweet" addthis:url="http://www2.poopourri.com" addthis:title="Girls Don't Poop - Poopourri.com" addthis:description="Yes, this is a real product! Yes, it's scientifically proven to work. http://poopourri.com"></a>
<a class="addthis_button_pinterest_pinit" addthis:url="http://www2.poopourri.com" addthis:title="Girls Don't Poop - Poopourri.com" addthis:description="Yes, this is a real product! Yes, it's scientifically proven to work. http://poopourri.com"></a>
<a class="addthis_counter addthis_pill_style" addthis:url="http://www2.poopourri.com" addthis:title="Girls Don't Poop - Poopourri.com" addthis:description="Yes, this is a real product! Yes, it's scientifically proven to work. http://poopourri.com"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-522e30237ef8e7c8"></script>
<!-- AddThis Button END -->

 
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
<script><!--

/* Calculate the initial number as of now */
	  var beginMilliseconds = 1322069896041; /* Milliseconds as of November 22, 2011 */
	  var millisecondsPerMin = 60000;
	  var today = new Date();
	  var NumberPerMinute = 1.7;  /* Don't use the actual number per minute*/
          var total = 2405000;
	  total = total + (NumberPerMinute * (today.getTime() - beginMilliseconds) / millisecondsPerMin);

	  /* Update every two seconds */
	  setInterval("UpdateBuyBtn()", 2000);

function UpdateBuyBtn() {
    /* Increment by a random number between 0 and 11 */
    total = total + Math.floor(Math.random() * 11);

    total = Math.round(total);

    /* Update the Buy Buttons */
    var s = addCommas(total) + ' SOLD';
    $('#buy_now_text').html(s);
}

/* Buy Now Count*/
function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

//--></script>
<?php get_footer(); ?>
