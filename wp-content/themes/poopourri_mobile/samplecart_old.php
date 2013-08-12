<?php /**
 * Template Name: Sample Cart Page Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */
?>

<?php get_header(); ?>

<div id="foxyshop_container">

<?php
foxyshop_include('header');

//Setup Settings, Get Current User Information
global $foxyshop_settings;
$wp_user_id = get_current_user_id();
$wp_user = get_userdata($wp_user_id);
$wp_email = $wp_user->user_email;
$customer_id = get_user_meta($wp_user_id, 'foxycart_customer_id', 1);

$secret = "spfx8b6b68fced71cd3c41c280513a89ed592382ae2ef8ae022622f1fac240838381";
$code='1ora1foam';
$name_hash = hash_hmac('sha256', $code.'nametry me', $secret); // Hash of the "name" input
$price_hash = hash_hmac('sha256', $code.'price9.99', $secret); // Hash of the "price" input

$quantity_hash = hash_hmac('sha256', $code.'quantity4', $secret); // Hash of the "price" input
$code_hash = hash_hmac('sha256', $code.'code'.$code, $secret); // Hash of the "code" input

$url = '?name||'.$name_hash.'=try+me&price||'.$price_hash.'=9.99&quantity||'.$quantity_hash.'=4&code||'.$code_hash.'=1ora1foam';

?>
<input type="text" value="<?php echo $url?>" id="addcarturl">
<script type="text/javascript">
//alert(storedomain);
//var cart_request = 'https://'+storedomain+'/cart?name=Try+Me&price=9.99'+fcc.session_get() + '&cart=add&quantity=5';
var addcarturl = jQuery('#addcarturl').val();
var cart_request = 'https://'+storedomain+'/cart'+addcarturl+fcc.session_get();
console.log(cart_request);

jQuery.getJSON(cart_request+'&output=json&callback=?', function(data) {
	console.log(data);
//	alert(data);
});

//jQuery.getJSON('https://'+storedomain+'/cart?'+fcc.session_get()+'&output=json&callback=?', function(data) {
//	console.log(data);
//});

</script>
<?php 
//if (!$customer_id) $customer_id = 0;
$date_filter = "n/j/Y";
foxyshop_include('footer');
?>

<div class="clr"></div>
</div>

<?php get_footer(); ?>