<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------
*/ ?>

<?php get_header(); ?>

<?php foxyshop_include('header'); ?>
<div id="foxyshop_container">
<?php
while (have_posts()) : the_post();

	//Initialize Product
	global $product;
	$product = foxyshop_setup_product();


	//This is for testing to see what is included in the $product array
	//print_r($product);

	//Initialize Form
	foxyshop_start_form();

	//Write Breadcrumbs
	foxyshop_breadcrumbs(" &raquo; ", "&laquo; Back to Products");

	echo '<div class="products-content">';
	//Shows Main Image and Optional Slideshow
	//Available Built-in Options: prettyPhoto (lightbox), cloud-zoom (inline zooming), or colorbox (native FoxyCart lightbox)
	//Second arg writes css and js includes on page
	//If you want to make more customizations, you can grab the code from helperfunctions.php line ~650 and paste here
	//-------------------------------------------------------------------------------------------------------------------------
	foxyshop_build_image_slideshow("prettyPhoto", true);
	//foxyshop_build_image_slideshow("cloud-zoom", true); //Note, make sure to use jQuery 1.7.2 as 1.8+ seems to be incompatible for now
	//foxyshop_build_image_slideshow("colorbox", true); //only recommended for 0.7.2+


	//Main Product Information Area
	echo '<div class="foxyshop_product_info">';
	//edit_post_link('<img src="' . FOXYSHOP_DIR . '/images/editicon.png" alt="Edit Product" width="16" height="16" />','<span class="foxyshop_edit_product">','</span>');
	echo '<h2>' . apply_filters('the_title', $product['name']) . '</h2>';
	
	//Showing top price.
	echo '<div id="foxyshop_main_price" class="top-price">';
	foxyshop_price();
	echo '</div>';
	//Show a sale tag if the product is on sale
	//if (foxyshop_is_on_sale()) echo '<p class="sale-product">SALE!</p>';

	//Product Is New Tag (number of days since added)
	//if (foxyshop_is_product_new(14)) echo '<p class="new-product">NEW!</p>';

	//Main Product Description
//	echo $product['description'];
	
	// Product Short Desc
	
	if ($product['short_description']) 
	echo '<h4> Quick Overview </h4>';
	echo "<p>" . $product['short_description'] . "</p>";
	
	
	//Show Variations (showQuantity: 0 = Do Not Show Qty, 1 = Show Before Variations, 2 = Show Below Variations)
	//If Qty is turned off on product, Qty box will not be shown at all
	foxyshop_product_variations(2);

	//(style) clear floats before the submit button
	echo '<div class="clr"></div>';
	echo '<div class="product-options">';
	
	//Shows the Price (includes sale price if applicable)
	echo '<div id="foxyshop_main_price">';
	foxyshop_price();
	echo '</div>';
	
	//Check Inventory Levels and Display Status (last variable allows backordering of out of stock items)
	foxyshop_inventory_management("There are only %c item%s left in stock.", "Item is not in stock.", false);

	//Add On Products ($qty [1 or 0], $before_entry, $after_entry)
	foxyshop_addon_products();

	//Add To Cart Button
	echo '<button type="submit" name="x:productsubmit" id="productsubmit" class="foxyshop_button"><label>Add To Cart</label></button>';
	echo '</div>';
	//Custom Code Can Go Here








	//Ends the form
	echo '</div>';
	echo '</div>';
	echo '<div class="product-description">';
	
	//Main Product Description
	echo '<h4>Product Description</h4>';
	echo $product['description'];
	
	//Shows any related products
	foxyshop_related_products("You may also be interested in the following product(s)");
		
	echo '</div>';
	echo '<input type = "hidden" name = "h:prev_page_referer" value = "'.$_SERVER['HTTP_REFERER'].'">';
	echo '<input type = "hidden" name = "h:host_site" value = "orapup">';
	echo '</form>';


endwhile;
?>
<span id="amazon_fps_category_hmac" style="display:none;"><?php echo foxyshop_get_verification("category",'--OPEN--'); ?></span>
	<div class="clr"></div>
</div>
<?php if($product['id']==(225)){ // starter kit ?>
<!-- Google Code for Orapup Product 1 Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "fHzVCIWi-wgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=fHzVCIWi-wgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php }else if($product['id']==(231)){ // pick your colors ?>
<!-- Google Code for Orapup Product 2 Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "cQwZCPWj-wgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=cQwZCPWj-wgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php }else if($product['id']==(236)){ // hoody ?>
<!-- Google Code for Orapup Product 3 Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "QbUpCO2k-wgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=QbUpCO2k-wgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php } ?>

<?php foxyshop_include('footer'); ?>

<?php get_footer(); ?>
