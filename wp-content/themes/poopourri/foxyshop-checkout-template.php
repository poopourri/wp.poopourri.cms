<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------

------------ FOXYCART TEMPLATE INSTRUCTIONS ------------
You can find these templates at:
http://yoursite.com/foxycart-checkout-template/
http://yoursite.com/foxycart-receipt-template/

*/

//Remove jQuery and FoxyCart Includes
add_action('wp_enqueue_scripts', 'foxyshop_remove_jquery', 99);
remove_action('wp_footer', 'foxyshop_insert_google_analytics', 100);
remove_action('wp_head', 'foxyshop_insert_foxycart_files');
remove_action('init', 'foxyshop_insert_jquery');

add_action('init', 'my_foxyshop_dequeue', 11);
function my_foxyshop_dequeue() { wp_dequeue_style('foxyshop_css'); }

//Do Special Google Analytics If Required
add_action('wp_footer', 'foxyshop_insert_google_analytics_checkout');

//Put Special JS in Foot
add_action('wp_footer', 'foxycart_template_footer_includes');
function foxycart_template_footer_includes() {
    ?>
    <script type="text/javascript" src="<?php bloginfo("stylesheet_directory"); ?>/checkout.js"></script>
    <?php
}

//Put Special CSS in Head
add_action('wp_head', 'foxycart_template_header_includes');
function foxycart_template_header_includes() {
	?>
<!--<link rel="shortcut icon" href="<?php bloginfo("url");?>/favicon.ico" />-->
<meta name="ROBOTS" content="NOINDEX">
	<?php
}

get_header("foxycart"); ?>

    <div class="container">


        {% if error_codes|length > 0 %}
            {% include 'checkout_error.inc.twig' %}
        {% else %}
            {% if not is_updateinfo %}
            <div id="fc_checkout_cart">
                <?php include "cart.twig.blocks.php"; ?>
            </div>
            {% endif %}


            <?php include "checkout.twig.blocks.php"; ?>

        {% endif %}


    </div>









^^custom_begin^^
<?php
//Displays anything that's dynamically hooked to the custom fields section. You can also put your own code or fields here.
do_action('foxyshop_checkout_template_custom_fields_section');
?>
^^custom_end^^

<script>

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
		} catch(e) {
			return;
		}

		try {
			// If we can't parse the cookie, ignore it, it's unusable.
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write
		if (value !== undefined && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {};

		// To prevent the for loop in the first place assign an empty array
		// in case there are no cookies at all. Also prevents odd result when
		// calling $.cookie().
		var cookies = document.cookie ? document.cookie.split('; ') : [];

		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			// Must not alter options, thus extending a fresh object...
			$.cookie(key, '', $.extend({}, options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));

function add_product_to_cart(product_id,quantity){
	//alert(quantity);
	var product_addtocart_url = location.origin + '/cart?';
	$('#quantity_'+product_id).val(quantity);
	$('#quantity_'+product_id).after('<input type="hidden" name="'+$('#quantity_'+product_id).prop('name').replace('x:quantity','quantity')+'" value="'+quantity+'"/>');
	var form_serialized = $('#foxyshop_product_form_'+product_id).serialize();
	//document.location.href = product_addtocart_url + form_serialized;
	jQuery.getJSON(product_addtocart_url + form_serialized + '&output=json&callback=?', function(cart) {
		$('#ThisAction').val('customer_info');
		document.location.href = location.origin + location.pathname + '?' + $('#fc_form_checkout').serialize();
	});	
}

function remove_product_from_cart(product_id){
	var url = location.origin + '/cart?fcsid=' + fc_json.session_id + '&cart=update&1:quantity=0&1:id=' + product_id + '&output=json&callback=?';
	//document.location.href = url;
	jQuery.getJSON(url, function(cart) {
		$('#ThisAction').val('customer_info');
		document.location.href = location.origin + location.pathname + '?' + $('#fc_form_checkout').serialize();
	});
}

function save_optimizely_data(data){
	if(typeof(data)!='undefined'){
		var regex = new RegExp('"',"g");
		var regex2 = new RegExp(':',"g");
		var url = location.origin + '/cart?fcsid=' + fc_json.session_id + '&h:optimizely='+data.replace('{','').replace('}','').replace(regex,'').replace(regex2,'-')+'&output=json&callback=?';
		jQuery.getJSON(url, function(cart) {});
	}
}

$(function(){
	optimizely_variation_id = '340560033';
	if(typeof($.cookie('optimizelyBuckets'))!='undefined' && $.cookie('optimizelyBuckets').indexOf(optimizely_variation_id)>-1 || location.hash.indexOf('showVariation')>-1){
		$('#fc_checkout_cart').css({width:'960px'});
		$('#cart_container_checkout').css({width:'600px'});
		var upsell_html = '<div id="upsell_box" style="float:right;width:325px;margin-top:-80px;">';
		upsell_html = upsell_html + '<img src="/wp-content/themes/poopourri/images/addstockingstuffers.png"/>';
		$('.foxyshop_product').each(function(){ 
			var pid = this.id.replace('foxyshop_product_form_',''); 
			var ptitle = $('#foxyshop_product_form_'+pid+' input[name^="name||"]').val(); 
			var saleprice = '$'+$('#foxyshop_product_form_'+pid+' .foxyshop_saleprice').text(); 
			var orgprice = '$'+$('#foxyshop_product_form_'+pid+' .foxyshop_oldprice').text(); 
			var pdescription = '<span style="font-size:9pt;">'+$('#foxyshop_product_form_'+pid+' .foxyshop_product_info p').html()+'</span>';
			has_promo_product = 0;
			var fcpid = 0;
			jQuery.each(fc_json.products, function(i, product){
				if (product.name == ptitle) {
					fcpid = product.id;
				}
			});
			if (fcpid ==  0) {
				var calltoaction = '<span id="purchase_info">Qty: <select id="qty_'+pid+'"><option value="1" label="1">1</option><option value="2" label="2">2</option><option value="3" label="3">3</option><option value="4" label="4">4</option><option value="5" label="5">5</option></select> <strike>'+orgprice+'</strike>  <span style="color:red;font-weight:bold;">'+saleprice+'</span><br/><a href="javascript:void(0);" onclick="add_product_to_cart('+pid+',$(\'#qty_'+pid+'\').val());" class="add_to_cart_btn"><span class="screen-reader-text">Add to cart</span></a></span>';
			}else{
				var calltoaction = '<span id="remove_info" style="font-weight:bold;color:red;text-decoration:underline;font-style:italic;"><a href="javascript:void(0);" onclick="remove_product_from_cart('+fcpid+');" style="color:red;">Remove</a></span>';
			}
			upsell_html = upsell_html + '<div><img src="'+$('#foxyshop_product_form_'+pid+' #foxyshop_main_product_image').prop('src')+'" title="'+ptitle+'" style="width:65px;float:left;"/><div style="float:right;width:250px;"><b>'+ptitle+'</b><br/>'+pdescription+'<br/>'+calltoaction+'</div></div><div style="clear:both;height:15px;"></div>'; 
		});
		upsell_html = upsell_html + '</div>';
		$('#your_cart_header').after(upsell_html);
		//$('#fc_cart_container_inner').html(upsell_html + $('#fc_cart_container_inner').html());
	}
	save_optimizely_data($.cookie('optimizelyBuckets'));
});

</script>

<div id="upsells" style="display:none;">
	<?php echo do_shortcode('[showproduct name="secret-santa-1oz-bottle"]'); ?>
	<?php echo do_shortcode('[showproduct name="santa-poo-1oz-bottle"]'); ?>
	<?php echo do_shortcode('[showproduct name="stocking-stuffer-4bottle-pack"]'); ?>
</div>

<script type="text/javascript">
function verify_address(address_type) {
 
	//Setup Vars
	var smarty_html_key = "5248874863931958361";
 
	var address = $("#" + address_type + "_address1").val();
	var city = $("#" + address_type + "_city").val();
	var state = $("#" + address_type + "_state").val();
	var postal_code = $("#" + address_type + "_postal_code").val();
	var country = $("#" + address_type + "_country").val();
 
	//Not US, Skip
	if ($("#" + address_type + "_country").val() != "US") return;
 
	//Not Enough Vals, Skip
	if (!address || !city || !state) return;
 
	var url = "https://api.smartystreets.com/street-address?street=";
	url += encodeURIComponent(address);
	if ($("#" + address_type + "_address1").val()) url += encodeURIComponent(" " + $("#" + address_type + "_address2").val());
	url += "&city=" + encodeURIComponent(city);
	url += "&state=" + encodeURIComponent(state);
	url += "&zipcode=" + encodeURIComponent(postal_code);
	url += "&candidates=3&auth-token=" + smarty_html_key + "&callback=?";
	jQuery.getJSON(url, function(response) {
		$("#" + address_type + "_address_select").html("");
		if (response.length == 0) {
			$("#" + address_type + "_address_warning").show();
			return false;
		}
		if (response.length == 1) {
			var a = response[0];
			var address1 = a.delivery_line_1;
			var address2 = a.delivery_line_2;
			var city = a.components.city_name;
			var state = a.components.state_abbreviation;
			var postal_code = a.components.zipcode;
			if (a.components.plus4_code) postal_code += "-" + a.components.plus4_code;
 
			$("#" + address_type + "_address1").val(address1);
			$("#" + address_type + "_address2").val(address2);
			$("#" + address_type + "_city").val(city);
			$("#" + address_type + "_state").val(state);
			$("#" + address_type + "_postal_code").val(postal_code);
 
		} else if (response.length > 1) {
			var str = "<p>Your Address Had a Few Options:</p>";
			for (i = 0; i < response.length; i++) {
				var a = response[i];
				var address1 = a.delivery_line_1;
				var address2 = a.delivery_line_2 ? a.delivery_line_2 : '';
				var city = a.components.city_name;
				var state = a.components.state_abbreviation;
				var postal_code = a.components.zipcode;
				if (a.components.plus4_code) postal_code += "-" + a.components.plus4_code;
				str += '<p><a href="#" class="set_verified_address" data-address_type="' + address_type + '" data-address1="' + address1 + '" data-address2="' + address2 + '" data-city="' + city + '" data-state="' + state + '" data-postal_code="' + postal_code + '">';
				str += address1 + "<br>";
				if (address2) str += address1 + "<br>";
				str += a.last_line;
				str += "</a></p>";
			}
			$("#" + address_type + "_address_select").html(str).show();
 
		}
		$("#" + address_type + "_address_warning").hide();
		return true;
	});
}
 
jQuery(document).ready(function($){
	$("#shipping_address1, #shipping_address2, #shipping_city, #shipping_state, #shipping_state, #shipping_postal_code, #shipping_country").change(function() {
		verify_address("shipping");
	});
	$(document).on("click", ".set_verified_address", function() {
		var address_type = $(this).attr("data-address_type");
		$("#" + address_type + "_address1").val($(this).attr("data-address1"));
		$("#" + address_type + "_address2").val($(this).attr("data-address2"));
		$("#" + address_type + "_city").val($(this).attr("data-city"));
		$("#" + address_type + "_state").val($(this).attr("data-state"));
		$("#" + address_type + "_postal_code").val($(this).attr("data-postal_code"));
		$("#" + address_type + "_address_select").html("").hide();
		return false;
	});
	$("#fc_customer_billing_list").append('<li id="customer_address_select" style="display: none;"></li><li id="customer_address_warning" style="display: none; color: #990000; font-weight: bold;">You may want to check this address as it appears it might have a problem.</li>');
	$("#fc_address_shipping_list").append('<li id="shipping_address_select" style="display: none;"></li><li id="shipping_address_warning" style="display: none; color: #990000; font-weight: bold;">You may want to check this address as it appears it might have a problem.</li>');
});
</script>

<?php get_footer("foxycart"); ?>
