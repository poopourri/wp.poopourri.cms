<?php /**
 * Template Name: Order Page Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */
?>

<?php 
global $wpdb;
if(isset($_GET['e']) && isset($_GET['o'])){
        $emailHash = $_GET['e'];
        $orderHash = $_GET['o'];
        $selectFoxyCustomerId = "SELECT customer_id from wp_fc_transaction_customers where transaction_id = '". $orderHash."' and customer_email = '".$emailHash."'";
        $customer_id = $wpdb->get_var($selectFoxyCustomerId);
        $select_user = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'foxycart_customer_id' AND meta_value = '$customer_id'";
        $user_id = $wpdb->get_var($select_user);
        $deleteFoxyCartEntry = "DELETE from wp_fc_transaction_customers where transaction_id = '". $orderHash."' and customer_email = '".$emailHash."'";
        $wpdb->query($deleteFoxyCartEntry );
        if($user_id>=1){
                wp_set_auth_cookie($user_id, false, true);
        }
        wp_redirect("/myorders?clear_selection=1");
        die;
}
get_header();
//"oraclub-staging.foxycart.com"
?>
<style>
<!--
.header-order-button{display:none;}
-->
</style>
<div id="foxyshop_container">

<?php
foxyshop_include('header');
//Setup Settings, Get Current User Information
global $foxyshop_settings;

$wp_user_id = get_current_user_id();
$wp_user = get_userdata($wp_user_id);
$wp_email = $wp_user->user_email;
$customer_id = get_user_meta($wp_user_id, 'foxycart_customer_id', 1);
if (!$customer_id) $customer_id = 0;
$date_filter = "n/j/Y";

//For Testing
//if ($wp_email == "david@sparkweb.net") $customer_id = "1825428";

//If there was a search for a transaction ID
if (isset($_POST['transaction_id_search'])) {

	echo '<h2>Transaction ' . $_POST['transaction_id_search'] . ' Status:</h2>' . "\n";

	$foxy_data_defaults = array("transaction_id" => $_POST['transaction_id_search']);
	$foxy_data = wp_parse_args(array("api_action" => "transaction_get"), $foxy_data_defaults);
	$foxy_response = foxyshop_get_foxycart_data($foxy_data);
	$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
        var_dump($xml);
	if ($xml->result == "ERROR") {
		echo "<p>We could not find this order. Please Call or Contact Us. We'll be happy to provide any details you need ASAP</p>";
	} else {
		foreach($xml->transaction as $transaction) {
			$transaction_id = $transaction->id;
			$tracking_info = "Call";
                        
			foreach($transaction->attributes->attribute as $attribute) {
				$attribute_name = (string)$attribute->name;
				$attribute_value = (string)$attribute->value;
				if ($attribute_name == "Tracking #") $tracking_info = $attribute_value;
			}

			if (substr($tracking_info, 0, 2) == "1Z") $tracking_info = '<a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';
			elseif ($tracking_info != "Call") $tracking_info = '<a href="http://www.fedex.com/Tracking?ascend_header=1&clienttype=dotcom&cntry_code=us&language=english&tracknumbers=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';
                        
			if ((int)$transaction->is_hidden == 1) $tracking_info = "Shipped: " . $tracking_info;

			echo '<p>' . $tracking_info . '</p>';
		}

	}

	echo '<hr />';
}


//If User is Not Logged In
if ($wp_user_id == 0) {

	//Let them search for their order number with their transaction ID
	echo '<h2>Search For Your Order</h2>';
	echo '<form action="/myorders/" method="post">' . "\n";
	echo '<label for="transaction_id_search">Transaction ID</label>' . "\n";
	echo '<input id="transaction_id_search" name="transaction_id_search" value="" />' . "\n";
	echo '<button id="searchnow" name="searchnow" class="foxyshop_button" style="float: none;">Search Now</button>' . "\n";
	echo '</form>' . "\n";


	//Show Login
	echo '<h2>Login</h2>';
	echo "<p><a href='/wp-login.php?'>Login</a> to see your order history, tracking #s and reprint receipts. You can always call us 24/7 or <a href='/contact/'>Contact Us</a> and we will be happy to provide any details you need ASAP.</p>";

//User Is Logged In
} else {

	//ALTERNATELY YOU COULD JUST DO:
	//foxyshop_customer_order_history(get_user_meta(wp_get_current_user()->ID, 'foxycart_customer_id', 1));

	//Setup Fields and Defaults
	if ($customer_id != 0) { //There is a FoxyCart USER ID
		$foxy_data_defaults = array("hide_transaction_filter" => "", "customer_id_filter" => $customer_id);
	} else { //No User ID, just search with email address
		$foxy_data_defaults = array("hide_transaction_filter" => "", "customer_email_filter" => $wp_email);
	}
	$foxy_data = wp_parse_args(array("api_action" => "transaction_list"), $foxy_data_defaults);
	$foxy_data['pagination_start'] = (isset($_GET['pagination_start']) ? $_GET['pagination_start'] : 0);
	if (version_compare($foxyshop_settings['version'], '0.7.0', ">")) $foxy_data['entries_per_page'] = 50;
	$foxy_response = foxyshop_get_foxycart_data($foxy_data);
	$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);


	//Show Order History
	echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your Order History</h1>';
        echo '<div class = "order-note"><h4 style="margin-bottom: 20px;line-height: 20px;">Your order history is organized as Order History and Scheduled Delivery. Order History is for orders that are placed and processing for shipment. Scheduled Delivery are future orders. Scheduled Deliveries will eventually end up in your order history.</h4></div>';
	if ($xml->result == "ERROR") {
		echo "<p>We could not find any orders. Please Call or <a href='/contact/' >Contact Us.</a> We'll be happy to provide any details you need ASAP</p>";
	} else {

		//Table Header
		echo '<table cellpadding="0" cellspacing="0" border="0" class="foxyshop_table_list" id="foxyshop_customer_order_history">'."\n";
		echo '<thead>'."\n";
		echo '<tr>'."\n";
		echo '<th>Order ID</th>'."\n";
		echo '<th>Date</th>'."\n";
		echo '<th>Total</th>'."\n";
		echo '<th>Tracking Information</th>'."\n";
		echo '<th>Receipt</th>'."\n";
		echo '</tr>'."\n";
		echo '</thead>'."\n";
		echo '<tbody>'."\n";
                                
                              
 		foreach($xml->transactions->transaction as $transaction) {
			$transaction_id = $transaction->id;
			$tracking_info = "Call";

			foreach($transaction->attributes->attribute as $attribute) {
				$attribute_name = (string)$attribute->name;
				$attribute_value = (string)$attribute->value;
				if ($attribute_name == "Tracking #") $tracking_info = $attribute_value;
			}

			echo($tracking_info);
//			if (substr($tracking_info, 0, 2) == "1Z") $tracking_info = '<a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';
//			elseif ($tracking_info != "Call") $tracking_info = '<a href="http://www.fedex.com/Tracking?ascend_header=1&clienttype=dotcom&cntry_code=us&language=english&tracknumbers=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';
			if (substr($tracking_info, 0, 2) == "1Z") $tracking_info = '<a href="http://www.brokersworldwide.com/clientlogin/uspsbagtag/Track.aspx?c=0&p=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';
			elseif ($tracking_info != "Call") $tracking_info = '<a href="http://webtrack.dhlglobalmail.com/?mobile=&trackingnumber=' . $tracking_info . '" target="_blank">' . $tracking_info . '</a>';

			if ((int)$transaction->is_hidden == 1) $tracking_info = "Shipped: " . $tracking_info;
                                                                       
			echo '<tr rel="' . $transaction_id . '">';
			echo '<td class="order_id">' . $transaction_id . '</td>';
			echo '<td class="order_date">' . date($date_filter, strtotime($transaction->transaction_date)) . '</td>';
			echo '<td class="order_total">' . foxyshop_currency((double)$transaction->order_total) . '</td>';
			echo '<td class="order_total">' . $tracking_info . '</td>';
			echo '<td class="order_receipt"><a href="' . $transaction->receipt_url . '" target="_blank">Show Receipt</a></td>';
//                        echo '<td class="order_receipt"><a href="https://' . $transaction->sub_token_url. '&amp;empty=true&amp;cart=checkout&amp;sub_cancel=true">Cancel Order</a></td>';
			echo '</tr>'."\n";
		}

		echo '</tbody></table>';

		//Pagination
		$p = 50;
		$total_records = (int)$xml->statistics->total_orders;
		$filtered_total = (int)$xml->statistics->filtered_total;
		$pagination_start = (int)$xml->statistics->pagination_start;
		$pagination_end = (int)$xml->statistics->pagination_end;
		if ($pagination_start > 1 || $filtered_total > $pagination_end) {
			echo '<div id="foxyshop_list_pagination">';
			echo $xml->messages->message[1] . '<br />';
			if ($pagination_start > 1) echo '<a href="/view-orders/' . $querystring . '&amp;pagination_start=' . ($pagination_start - $p - 1) . '">&laquo; Previous</a>';
			if ($pagination_end < $filtered_total) {
				if ($pagination_start > 1) echo ' | ';
				echo '<a href="/view-orders/' . $querystring . '&amp;pagination_start=' . $pagination_end . '">Next &raquo;</a>';
			}
			echo '</div>';
		}
	}

//        $subscriptionStartDate = date('Y-m-d H:i:s', strtotime("+1 week"));
//        $subscriptionEndDate = date('Y-m-d H:i:s', strtotime("+30 days"));
//
//        // To take subscription list
//        $foxy_data = wp_parse_args(array("api_action" => "subscription_list", "is_active_filter" => 1, "next_transaction_date_filter_begin" => $subscriptionStartDate, "next_transaction_date_filter_end" => $subscriptionEndDate));
//	$foxy_response = foxyshop_get_foxycart_data($foxy_data);
//	$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
//	if ($xml->result == "ERROR") {
//            	echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your Scheduled Deliveries</h1>';
//		echo "<p>No Scheduled Deliveries.</p>";
//        }
//                
//        //HTML Filter function for wp_mail
//        function wpse27856_set_content_type(){
//            return "text/html";
//        }
//        add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
//        
//        // iterate over the xml 
//        foreach($xml->subscriptions->subscription as $subscription) {
//                // get the customer id
//                // fetch email for that customer
//                $foxy_data = wp_parse_args(array("api_action" => "customer_get", "customer_id" => $subscription->customer_id));
//                $foxy_response = foxyshop_get_foxycart_data($foxy_data);
//                $emailxml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
//                $customerEmail = (string)$emailxml->customer_email;
//                $sub_token = (string)$subscription->sub_token;
//                $customer_id = $subscription->customer_id;
//                $transaction_id = (string)$subscription->original_transaction_id;
//                $transaction_date = (string)$subscription->next_transaction_date;
//                
//                // check if email is sent to customer id, transaction id
//                if( $customerEmail != 'nealsharmon@gmail.com'){
//                    // send email to him
//                    $subject = "Your fresh new [Orapup/Lickies] is being shipped!";
//                    $message .= 'Just letting you know that your new [Orapup and Lickies] are being shipped next <br/> '.$subscriptionStartDate.'.Here is what you ordered in your scheduled delivery:
//                    <br/>'.$subscription->transaction_details->product_name.'<br/>Adjust my order:<br/> To change your subscription click on update link and to cancel subscription click on cancel link<br/> <a href="https://' . $foxyshop_settings['domain']. '/cart?sub_token=' . $sub_token . '&amp;empty=true&amp;cart=checkout">Update</a><br/><a href="https://' . $foxyshop_settings['domain']. '/cart?sub_token=' . $sub_token . '&amp;empty=true&amp;cart=checkout&amp;sub_cancel=true">Cancel</a><br/>Thank you for your support,<br/>Dr Bob Wagstaff <br/>Inventor of the Orapup <br/><br/>NEW AT ORAPUP:[STUFF FROM THE NEWSLETTERS, new products, announcements, upsells to apparel...]';
//                    $headers[] = 'From: Orapup <staging.orapup.com>';
//                    
//                    //Check wether mail is sent or not
//                    $users_notification_sent_query = "SELECT * FROM wp_schedule_notification_email WHERE customer_id = $customer_id and transaction_id = $transaction_id";
//                    $users_notification_sent = $wpdb->get_results($users_notification_sent_query);
//                    
//                    if(!$users_notification_sent){
//                       $mail_result = wp_mail( $customerEmail, $subject, $message, $headers);
//                       $mailSentFlag = false;       
//                       if($mail_result){
//                             $mailSentFlag = true;
//                       }
//                       $insertNotificationEmailData = "INSERT INTO wp_schedule_notification_email (customer_id, email, transaction_date, transaction_id, is_mail_sent) VALUES ($customer_id,'" . $customerEmail ."','".$transaction_date."', $transaction_id, true)";
//                       $result = $wpdb->query($insertNotificationEmailData);  
//                    }
//                }
//        }
        
	//Show Subscriptions
	$foxy_data = wp_parse_args(array("api_action" => "subscription_list", "is_active_filter" => 1, "customer_id_filter" => $customer_id));
	$foxy_response = foxyshop_get_foxycart_data($foxy_data);
	$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
	if ($xml->result == "ERROR") {
                echo '<div style="clear:both;"></div><h1 class="entry-title" style="padding-top:35px;">Your Scheduled Deliveries</h1>';
		echo "<p>No Scheduled Deliveries.</p>";
	}else {

		//Table Header
		echo '<div style="clear:both;"></div><h1 class="entry-title" style="padding-top:35px;">Your Scheduled Deliveries</h1>';
		echo '<table cellpadding="0" cellspacing="0" border="0" class="foxyshop_table_list" id="foxyshop_customer_order_history">'."\n";
		echo '<thead>'."\n";
		echo '<tr>'."\n";
		echo '<th>Start</th>'."\n";
		echo '<th>Next</th>'."\n";
		echo '<th>End</th>'."\n";
		echo '<th>Past Due</th>'."\n";
		echo '<th>Description</th>'."\n";
		echo '<th>&nbsp;</th>'."\n";
		echo '<th>&nbsp;</th>'."\n";
		echo '</tr>'."\n";
		echo '</thead>'."\n";
		echo '<tbody>'."\n";
		foreach($xml->subscriptions->subscription as $subscription) {
			$sub_token = (string)$subscription->sub_token;
			$customer_id = (string)$subscription->customer_id;
			$customer_first_name = (string)$subscription->customer_first_name;
			$customer_last_name = (string)$subscription->customer_last_name;
			$start_date = (string)$subscription->start_date;
			$next_transaction_date = (string)$subscription->next_transaction_date;
			$end_date = (string)$subscription->end_date;
			$frequency = (string)$subscription->frequency;
			$past_due_amount = (string)$subscription->past_due_amount;
			$is_active = (string)$subscription->is_active;
			$product_name = "";
			$customer_name = $customer_last_name . ', ' . $customer_first_name;
                       
    			foreach($subscription->transaction_template->transaction_details->transaction_detail as $transaction_detail) {
				if ($product_name) $product_name .= "<br />";
				$product_price = (double)$transaction_detail->product_price;
				foreach($transaction_detail->transaction_detail_options->transaction_detail_option as $transaction_detail_option) {
					$product_price += (double)$transaction_detail_option->price_mod;
				}
				$product_name .= (string)$transaction_detail->product_name . ' ' . foxyshop_currency($product_price);
			}

			echo '<tr>';
			echo '<td class="start_date">' . $start_date . '</td>';
			echo '<td class="next_transaction_date">' . $next_transaction_date . '</td>';
			echo '<td class="end_date">' . $end_date . '</td>';
			echo '<td class="past_due_amount">$' . $past_due_amount . '</td>';
			echo '<td class="product_description">' . $product_name . '</td>';

			echo '<td class="sub_actions"><a href="https://' . $foxyshop_settings['domain']. '/cart?sub_token=' . $sub_token . '&amp;empty=true&amp;cart=checkout">Update</a></td>';
			echo '<td class="sub_actions"><a href="https://' . $foxyshop_settings['domain']. '/cart?sub_token=' . $sub_token . '&amp;empty=true&amp;cart=checkout&amp;sub_cancel=true">Cancel</a></td>';
			echo '</tr>'."\n";
		}

		echo '</tbody></table>';
	}
}
//echo '<div class = "bottom-note"><h4 style = "margin-bottom: 20px;line-height: 20px;"><b>NOTE ON BACKORDERS AND PREORDERS:</b> When you backorder or preorder from our website, it sets up a 1-time Scheduled Delivery with a future start date. This allows us to record your order without charging your credit card until a future date.</h4></div>';
foxyshop_include('footer');
?>

<div class="clr"></div>
</div>

<?php get_footer(); ?>
