<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------
*/ ?>

<?php get_header('checkout'); ?>

<?php foxyshop_include('header'); ?>
<div id="foxyshop_container"><div id="adding_package" style="width:900px;">
<h2 style="background:url(/wp-content/themes/poopourri/images/your_package_header.png); width:224px; height:22px; margin:0px; margin-top:50px;"><span class="screen-reader-text">Your Package</span></h2>
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
	//foxyshop_breadcrumbs(" &raquo; ", "&laquo; Back to Products");


	//Shows Main Image and Optional Slideshow
	//Available Built-in Options: prettyPhoto (lightbox), cloud-zoom (inline zooming), or colorbox (native FoxyCart lightbox)
	//Second arg writes css and js includes on page
	//If you want to make more customizations, you can grab the code from helperfunctions.php line ~650 and paste here
	//-------------------------------------------------------------------------------------------------------------------------
	echo '<div style="display:none;">';
	foxyshop_build_image_slideshow("prettyPhoto", true);
	echo '</div>';

	//foxyshop_build_image_slideshow("cloud-zoom", true); //Note, make sure to use jQuery 1.7.2 as 1.8+ seems to be incompatible for now
	//foxyshop_build_image_slideshow("colorbox", true); //only recommended for 0.7.2+
 	echo '<img src="'.get_field("package_header", $product['id']).'" class="package_header"/>';
	if ($thumbnailSRC = foxyshop_get_main_image("medium")) echo '<a href="' . $product['url'] . '"><img src="' . $thumbnailSRC . '" alt="' . htmlspecialchars($product['name']) . '" style="margin-left:25px;"/></a>';

	//Main Product Information Area
	// echo '<div class="foxyshop_package_info">';

	//edit_post_link('<img src="' . FOXYSHOP_DIR . '/images/editicon.png" alt="Edit Product" width="16" height="16" />','<span class="foxyshop_edit_product">','</span>');
	echo '<h2 class="screen-reader-text">' . apply_filters('the_title', $product['name']) . '</h2>';

	//Show a sale tag if the product is on sale
	//if (foxyshop_is_on_sale()) echo '<p class="sale-product">SALE!</p>';

	//Product Is New Tag (number of days since added)
	//if (foxyshop_is_product_new(14)) echo '<p class="new-product">NEW!</p>';

	//Main Product Description
	//echo $product['description'];


	//Show Variations (showQuantity: 0 = Do Not Show Qty, 1 = Show Before Variations, 2 = Show Below Variations)
	//If Qty is turned off on product, Qty box will not be shown at all
	//foxyshop_product_variations(2);

	//(style) clear floats before the submit button
	//echo '<div class="clr"></div>';

	//Check Inventory Levels and Display Status (last variable allows backordering of out of stock items)
	foxyshop_inventory_management("There are only %c item%s left in stock.", "Item is not in stock.", false);

	//Add On Products ($qty [1 or 0], $before_entry, $after_entry)
	foxyshop_addon_products();

	//Email
	echo '<div style="background:url(/wp-content/themes/poopourri/images/dashed_horizontal_line.png) bottom repeat-x;padding-bottom:10px;"><h2 style="background:url(/wp-content/themes/poopourri/images/email_header.png); width:118px; height:26px; margin:0px; margin-top:50px;"><span class="screen-reader-text">EMAIL</span></h2></div>';

	echo '<input name="customer_email" style="font-size:22pt;width:450px;height:40px;margin-top:15px;" placeholder="Email address"/>';
	echo '<p style="font-size:9pt;margin-top:5px;color:#444444;">We respect your privacy and HATE spam as we hate poo smells.<br/>We will not sell or rent your personal info.</p>';
	echo '<div style="background:url(/wp-content/themes/poopourri/images/dashed_horizontal_line.png) bottom repeat-x;padding-bottom:10px;"></div>';
	echo '<img src="/wp-content/themes/poopourri/images/credit_cards.png" title="We accept all major credit cards" style="height:174px;height:26px;margin-top:10px;margin-bottom:10px;"/>';
	//Add To Cart Button
	echo '<button type="submit" name="x:productsubmit" id="productsubmit" class="foxyshop_button" style="display:none;">Add To Cart</button>';

	echo '<a href="javascript:void(0)" class="continue_to_checkout_btn" onclick="$(\'#productsubmit\').click();"><span class="screen-reader-text">Add to Cart</span></a>';

	//Shows the Price (includes sale price if applicable)
	//echo '<div id="foxyshop_main_price">';
	//foxyshop_price();
	//echo '</div>';

	//Shows any related products
	foxyshop_related_products("Related Products");

	//Custom Code Can Go Here




endwhile;

	//Ends the form
	echo '</div>';
	echo '</form>';
?>
	<div class="clr"></div>
<link rel="Stylesheet" type="text/css" href="/wp-content/themes/poopourri/css/smoothDivScroll.css" />

<div class="free_shipping_notice" style="height:30px;font-size:18pt;color:red;font-style:italic;font-weight:bold;margin-top:30px;"></div>
<span id="total_order_on_page" style="display:none;"></span>
<script><!--

function toggleCart(indexLoc,pid){
	var price = parseInt($('input[id$=":price_'+pid+'"]').val());
	if($('#addon_'+indexLoc).is(':checked')){
		$('#addon_'+indexLoc).click();
		$('#remove_btn_'+indexLoc).hide();
		$('#cart_btn_'+indexLoc).show();
		$('#total_order_on_page').text(parseFloat($('#total_order_on_page').text()) - price);
	}else{
		$('#addon_'+indexLoc).click();
		$('#remove_btn_'+indexLoc).show();
		$('#cart_btn_'+indexLoc).hide();
		$('#total_order_on_page').text(parseFloat($('#total_order_on_page').text()) + price);
	}
	var current_total = parseFloat($('#total_order_on_page').text());

	if(current_total < free_shipping_total_required){
		var remaining = free_shipping_total_required - current_total;
		$('.free_shipping_notice').html('FREE FAST shipping to USA on any order $49+ ($<span class="free_shipping_remaining">'+remaining+'</span> left)');
	}else{
		$('.free_shipping_notice').html('You qualify for FREE shipping to the USA!');
	}	
}

//--></script>

	<div id="mixedContent">
Loading...
	</div>

<style>
#mixedContent {
	width:900px;
	height: 330px;
	position: relative;

	margin-right:auto;
       border: 1px solid #ccc;
       -webkit-border-radius: 5px;
       border-radius: 5px;
       background-color: #fff;
	padding:10px;
}

#mixedContent .contentBox {
	position: relative;
	text-align:left;
	float: left;
	display: block;
	height: 308px;
	width: 220px;
	padding: 10px;
	margin: 0px 5px;
	background:#ffffff;
	/* If you don't want the images in the scroller to be selectable, try the following
	   block of code. It's just a nice feature that prevent the images from
	   accidentally becoming selected/inverted when the user interacts with the scroller. */
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-o-user-select: none;
	user-select: none;
}

#mixedContent .contentBox img {
	width:125px;
	margin-bottom: 10px;
}

#mixedContent .contentBox p {
	font-size: 14px;
}


#mixedContent .contentBox a.remove_btn {
	font-size: 18px;
	font-weight:bold;
	color:red;
	text-decoration:underline;
	padding:5px;
}

#mixedContent .contentBox div.remove_btn {
	display:none;
	height:42px;
	text-align:left;
}

</style>

	<!-- jQuery library - Please load it from Google API's -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>

	<!-- jQuery UI Widget and Effects Core (custom download)
		 You can make your own at: http://jqueryui.com/download -->
	<script src="/wp-content/themes/poopourri/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>

	<!-- Latest version of jQuery Mouse Wheel by Brandon Aaron
		 You will find it here: http://brandonaaron.net/code/mousewheel/demos -->
	<script src="/wp-content/themes/poopourri/js/jquery.mousewheel.min.js" type="text/javascript"></script>

	<!-- Smooth Div Scroll 1.3 minified-->
	<script src="/wp-content/themes/poopourri/js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>

	<!-- Plugin initialization -->
	<script type="text/javascript">


			$(document).ready(function() {
				var html = '';
				$('input[id*=":url_"]').each(function(){
					var product_id = $(this).attr('id').split('_')[1]; 
					var locIndex = $(this).attr('id').split(':')[0];
					html = html + '<div class="contentBox">';
					html = html + '<div class="remove_btn" id="remove_btn_'+locIndex+'"><a href="javascript:void(0)" class="remove_btn" onclick="toggleCart('+locIndex+','+product_id+');">Remove</a></div>';
					html = html + '<a href="javascript:void(0)" class="add_to_cart_btn" id="cart_btn_'+locIndex+'" onclick="toggleCart('+locIndex+','+product_id+');"><span class="screen-reader-text">Add to Cart</span></a>';
					html = html + '<p><img src="'+$('input[id$="image_'+product_id+'"]').val().replace('-150x150','')+'"/><br/>';
					html = html + $('input[id$="name_'+product_id+'"]').val()+'<br/>';
					html = html + '<b>Price: '+$('input[id$="price_'+product_id+'"]').val()+'</b></p>';
					html = html +'</div>';
				});
				$("#mixedContent").html(html);
				$("#mixedContent").smoothDivScroll({

				});
			});
	</script>

	<div class="clr"></div>
</div></div>

<?php foxyshop_include('footer'); ?>

<?php get_footer(); ?>