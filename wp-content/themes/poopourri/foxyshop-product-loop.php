<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------
*/

/***************************
Product display details
referenced in:
- foxyshop-all-products.php
- foxyshop-search.php
- foxyshop-single-category.php
- foxyshop-single-category-shortcode.php
- foxyshop-single-category-widget.php
****************************/

global $foxyshop_prettyphoto_included;
	
	//Initialize Product
	global $product, $prod;
	$product = foxyshop_setup_product($prod);
	

if (!$product['hide_product']) {

       echo '<li id="'.str_replace(' ','',$product['name']).'"><div>';

	//Just for the widget, since url links are no longer available
	global $foxyshop_skip_url_link;
	$foxyshop_skip_url_link = 1;
	
	//This is for testing to see what is included in the $product array
	//print_r($product);
	
	//Initialize Form
	foxyshop_start_form();
	
	
	//Write Breadcrumbs
	//foxyshop_breadcrumbs(" &raquo; ", "&laquo; Back to Products");
	

	//Shows Main Image and Optional Slideshow
	//Available Built-in Options: prettyPhoto (lightbox), cloud-zoom (inline zooming)
	//Second arg writes css and js includes on page
	//If you want to make more customizations, you can grab the code from helperfunctions.php line ~650 and paste here
	//-------------------------------------------------------------------------------------------------------------------------
	//Show Image on Left
	echo '<div class="category_image_holder">';
		if ($thumbnailSRC = foxyshop_get_main_image("medium")) echo '<a href="' . $product['url'] . '"><img src="' . $thumbnailSRC . '" alt="' . htmlspecialchars($product['name']) . '"/></a>';
      		 echo '<div style="display:none" class="foxyshop_image_holder">';
       		foxyshop_build_image_slideshow("prettyPhoto", true);
		 echo '</div>';
	echo "</div>\n";


	//Main Product Information Area
	echo '<div class="category_product_info"><div class="foxycart_product_info">';
	echo '<h2>' . apply_filters('the_title', $product['name']) . '</h2>';
	
	//Show a sale tag if the product is on sale
	//if (foxyshop_is_on_sale()) echo '<p>SALE!</p>';

	//Product Is New Tag (number of days since added)
	//if (foxyshop_is_product_new(14)) echo '<p>NEW!</p>';
	
	//Main Product Description
	echo $product['description'];

	//Shows the Price (includes sale price if applicable)
	echo '<div id="foxyshop_main_price"><div class="price_label">100-Use Bottle:</div> ';
	foxyshop_price();
	echo '</div><div class="clr"></div><br/><br/>';


	
	//Add To Cart Button
	echo '<button type="submit" name="x:productsubmit" id="productsubmit'.$product['id'].'" class="foxyshop_button" style="display:none;">Add To Cart</button>';

	//Show Variations (showQuantity: 0 = Do Not Show Qty, 1 = Show Before Variations, 2 = Show Below Variations)
	foxyshop_product_variations(2,true,'','');
	
	//(style) clear floats before the submit button
	//echo '<div class="clr"></div>';

	//Check Inventory Levels and Display Status (last variable allows ordering of out of stock items)
	foxyshop_inventory_management("There are only %c item%s left in stock.", "Item is not in stock.", false);

	echo '<a href="javascript:void(0)" class="add_to_cart_btn" onclick="$(\'#productsubmit'.$product['id'].'\').click();"><span class="screen-reader-text">Add to Cart</span></a>';


	//Custom Code Can Go Here




	//Ends the form
	echo '</div></div>';
	echo '</form>';


	?>
	<div style="clear:both;"></div>
</div></li>
<?

}

?>