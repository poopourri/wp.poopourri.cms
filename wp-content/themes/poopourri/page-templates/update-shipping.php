<?php
/**
 * Template Name: Update Shipping Address
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if(isset($_POST['foxycart_transaction_id'])){
	$_GET = $_POST;
	$sql = 'select count(*) from foxycart_mistaken_shipping_addresses where foxycart_transaction_id='.(int)$_POST['foxycart_transaction_id'].';';
	$address_count = $wpdb->get_var( $sql );
	if($address_count>0){
		$sql = 'UPDATE foxycart_mistaken_shipping_addresses SET ';
	}else{
		$sql = 'INSERT INTO foxycart_mistaken_shipping_addresses SET ';
	}
	$fields = array();
	foreach($_POST as $key=>$value){
		$fields[]=mysql_escape_string($key)."='".mysql_escape_string($value)."'";
	}
	
	if($address_count>0){
		$sql .= implode(',',$fields).',submitted_at=NOW() WHERE foxycart_transaction_id='.(int)$_POST['foxycart_transaction_id'].';';
	}else{
		$sql .= implode(',',$fields).',submitted_at=NOW();';
	}
	if($wpdb->query($sql)){
		$sql = '';
		$positive_message = 'New shipping address saved!';	
	}
}else if(isset($_GET['foxycart_transaction_id']) && count($_GET)==1){
	if(!isset($neg_message)){
	$sql = 'select * from foxycart_mistaken_shipping_addresses where foxycart_transaction_id='.(int)$_GET['foxycart_transaction_id'].';';
	$_GET = mysql_fetch_assoc(mysql_query( $sql ));
	if($_GET!=false){
		$sql ='';
	}else{
		$neg_message = 'Could not find a shipping address associated with that order.';
	}
	unset($_GET['submitted_at']);
	}
	
}else if(isset($_GET['foxycart_transaction_id'])){

$_POST['transaction_id_search'] = $_GET['foxycart_transaction_id'];
// we are going to fetch the foxycart order
global $foxyshop_settings;

//If there was a search for a transaction ID
if (isset($_POST['transaction_id_search'])) {
	$foxy_data_defaults = array("transaction_id" => $_POST['transaction_id_search']);
	$foxy_data = wp_parse_args(array("api_action" => "transaction_get"), $foxy_data_defaults);
	$foxy_response = foxyshop_get_foxycart_data($foxy_data);
	$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);

	if ($xml->result == "ERROR") {
		$neg_message = "<p>We could not find this order. Please <a href="/customer-service/contact-us/">Call or Contact Us</a>. We'll be happy to provide any details you need ASAP</p>".print_r($xml,1);
	} else {
		foreach($xml->transaction as $transaction) {
			$transaction_id = $transaction->id;
			if ((int)$transaction->is_hidden == 1){
				$neg_message = 'This order has already been sent to the shipping department. Please <a href="/customer-service/contact-us/">click here to contact us</a> to see if we can update your shipping address before it leaves our warehouse (no promises at this point that we can fix it).';
			}
		}

	}

}

}else{
	$neg_message = 'No order id provided.';
}

$html_content = '<center><h1>Update Your Shipping Address</h1><div style="background:green;color:white;font-weight:bold;border:1px solid white;width:580px;padding:10px;'.(strlen($positive_message)>0?'':'display:none;').'">'.$positive_message.'</div>';
$html_content .= '<div style="background:red;color:white;font-weight:bold;border:1px solid white;width:580px;padding:10px;'.(strlen($neg_message)>0?'':'display:none;').'">'.$neg_message.'</div>';
$html_content .= '<form method="post" style="width:880px;text-align:left;"><table>';
foreach($_GET as $key=>$value){
	$html_content .= '<tr><td style="font-weight:bold;width:150px;text-align:right;">'.($key=='foxycart_transaction_id' ? '':ucfirst(str_replace(array('fc_shipping_','_'),array('',' '),$key)).':').'</td><td align="left"><input name="'.$key.'" value="'.$value.'" type="'.($key=='foxycart_transaction_id' ? 'hidden':'text').'" style="width:500px;"/></td></tr>';
}
$html_content .= '<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Save Shipping Address" style="'.(count($_GET)<=1 ? 'display:none;':'').'"/></td></tr></table></form></center><br/><br/>';
get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php echo $html_content; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>