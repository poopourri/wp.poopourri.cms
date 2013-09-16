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

  		<iframe title="YouTube video player" class="youtube-player" type="text/html" width="630" height="355" src="http://www.youtube.com/embed/5hrQROTuSgs?rel=0&hd=1&wmode=transparent&autoplay=0&showinfo=0&color=white&autohide=1&rel=0&modestbranding=1&origin=https%3A%2F%2Fpoopourri.com" frameborder="0" style="position: absolute;left: 0px;top: 155px;box-shadow: 1px 2px 4px;"></iframe>
  
  		<img src="/wp-content/uploads/2013/09/leave_the_toilet_smelling_better.png" style="position:absolute;right:160px;top:155px;">
  		<p style="position:absolute;right:132px;top:250px;width:250px;font-size:14pt;text-align:left;">
			Poo-Pourri is a blend of essential oils that virtually eliminates bathroom odors! Our award-winning before-you-go&reg; sprays come in a variety of scents and sizes. 		</p>
		<img src="/wp-content/uploads/2013/09/100_uses_lasts_over_3_months_productshot.png" style="position:absolute;bottom:125px;right:-90px;">
  		<p style="position:absolute;right:100px;bottom: 100px;width:280px;text-align:center;font-size:14pt;font-weight:bold;color:#0088B0;" id="buy_now_text">
			Over 4 million sold!
		</p>
  		<a href="packages" class="order_now_btn" style="position:absolute;right:0px;bottom: 30px;"></a>
   
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style " style="position:absolute;left:0px;bottom:6px;width:400px;height:20px;">
<a class="addthis_button_youtube"></a>
<a class="addthis_button_instagram"></a>
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit"></a>
<a class="addthis_counter addthis_pill_style"></a>
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