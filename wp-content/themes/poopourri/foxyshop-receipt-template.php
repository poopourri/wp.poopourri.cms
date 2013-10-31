<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------

------------ FOXYCART TEMPLATE INSTRUCTIONS ------------
You can find these templates at:
http://yoursite.com/foxycart-checkout-template/
http://yoursite.com/foxycart-receipt-template/

*/ ?>

<?php
//Remove jQuery and FoxyCart Includes
add_action('wp_enqueue_scripts', 'foxyshop_remove_jquery', 99);
remove_action('wp_footer', 'foxyshop_insert_google_analytics', 100);
remove_action('wp_head', 'foxyshop_insert_foxycart_files');
remove_action('init', 'foxyshop_insert_jquery');


add_action('init', 'my_foxyshop_dequeue', 11);
function my_foxyshop_dequeue() { wp_dequeue_style('foxyshop_css'); }


//Do Special Google Analytics If Required
add_action('wp_footer', 'poopourri_footer');
function poopourri_footer() {
	?>



	{% if first_receipt_display %}
<script type="text/javascript" charset="utf-8">
  var my_order_total = "{{ order_total }}"; //twig
  my_order_total = my_order_total.replace("$", "");
  if(typeof my_future_order_total==="undefined"){
  }else if(my_future_order_total>0){
    my_order_total = my_future_order_total;
  }

  window.optimizely = window.optimizely || [];

  window.optimizely.push(['trackEvent', 'new_pp_revenue', (parseFloat(my_order_total) * 100 )]);

</script>
^^analytics_google_ga_async^^

<!-- Google Code for Sale on Poopourri.com Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 988742319;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "lyosCKG1twcQr4W81wM";
var google_conversion_value = my_order_total;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/988742319/?value=40&amp;label=lyosCKG1twcQr4W81wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Add Roll Code -->
<script type="text/javascript">
adroll_conversion_value_in_dollars = my_order_total;
</script>

<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6008700202648';
fb_param.value = my_order_total;
fb_param.currency = 'USD';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = '//connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6008700202648&amp;value=0&amp;currency=USD" /></noscript>

{% endif %}



	<?php
}




//Do Special Google Analytics If Required
add_action('wp_footer', 'foxyshop_insert_google_analytics_receipt');

//Put Special CSS in Head
add_action('wp_head', 'foxycart_template_header_includes');
function foxycart_template_header_includes() {
	?>
<!-- Rejoiner Conversion -->
<script type="text/javascript">
var _rejoiner = _rejoiner || [];
_rejoiner.push(["setAccount", "522ff53918484d289600004f"]);
_rejoiner.push(["setDomain", ".poopourri.com"]);
_rejoiner.push(["sendConversion"]);

(function() {
        var s = document.createElement('script'); s.type = 'text/javascript';
        s.async = true; s.src = 'https://s3.amazonaws.com/rejoiner/js/v3/t.js';
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
})();
</script>
<!--<link rel="shortcut icon" href="<?php bloginfo("url");?>/favicon.ico" />-->
<meta name="ROBOTS" content="NOINDEX">
<link rel="stylesheet" href="https://^^store_domain^^/themes/standard/styles.css" type="text/css" media="screen" charset="utf-8" />
<style type="text/css">
body {
	padding: 0;
	margin: 0;
}
.fc_cart_item_code, .fc_cart_category_code, .fc_cart_item_weight, .fc_minicart, #fc_minicart {
	display: none !important;
}
</style>

	<?php
}
?>


<?php get_header("foxycartoptimizely"); ?>

<style>
#fc_receipt_general_container{display:none;}
#fc_receipt_container{background-image:none;margin-top:-50px;padding:0px;}
#fc_checkout_cart{margin-top:0px;}
</style>
<h1>Your order has been placed successfully! Order details below...</h1>
^^cart^^
^^receipt^^

<script>
function changeAddress(){
	var querystr = '?';
	querystr = querystr + 'foxycart_transaction_id='+encodeURIComponent($('#fc_receipt_order_list .fc_order_id span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_first_name='+encodeURIComponent($('.fc_shipping_first_name span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_last_name='+encodeURIComponent($('.fc_shipping_last_name span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_address1='+encodeURIComponent($('.fc_shipping_address1 span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_address2='+encodeURIComponent($('.fc_shipping_address2 span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_city='+encodeURIComponent($('.fc_shipping_city span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_state='+encodeURIComponent($('.fc_shipping_state span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_postal_code='+encodeURIComponent($('.fc_shipping_postal_code span[class="fc_text"]').text());
	querystr = querystr + '&fc_shipping_country='+encodeURIComponent($('.fc_shipping_country span[class="fc_text"]').text());
	document.location.href = 'http://' + fc_json.page_referrer.split('/')[2] + '/customer-service/update-shipping-address/' + querystr;
}

$(function(){
	var shipping_header = 'Crap! Wrong address. <a href="javascript:void(0);" onclick="changeAddress();" style="color:red;text-decoration:underline;">Click here to change shipping address.</a>';
	$('#fc_receipt_shipping span[class="fc_clear"]').css({height:'auto',overflow:'none'});
	$('#fc_receipt_shipping span[class="fc_clear"]').html(shipping_header);
});
</script>

<?php get_footer("foxycart"); ?>
