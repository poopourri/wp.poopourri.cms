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
var google_conversion_value = 40;
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

{% endif %}



	<?php
}




//Do Special Google Analytics If Required
add_action('wp_footer', 'foxyshop_insert_google_analytics_receipt');

//Put Special CSS in Head
add_action('wp_head', 'foxycart_template_header_includes');
function foxycart_template_header_includes() {
	?>
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


<?php get_header("foxycart"); ?>



^^cart^^
^^receipt^^


<?php get_footer("foxycart"); ?>
