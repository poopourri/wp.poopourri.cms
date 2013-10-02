<?php
//Set Timezone and errors
date_default_timezone_set("America/Chicago");

// just pull international numbers?
$shipping_region = 'all';
if(isset($_GET['shipping_region'])){
	$shipping_region = $_GET['shipping_region'];
}

//Set Config Details
$foxycart_domain = "secure.poopourri.com";
$foxycart_api_key = "sp92fx6c4bf31eddd9a1a5555b4274436991bfdcaa01a2a98554bc37ed10f3e76d9b76";
$entries_per_page = 300;

//Email Settings
//$to_email = "david@sparkweb.net"; //testing
//$to_email = "nealsharmon@gmail.com"; //testing
$to_email = "janette@poopourri.net";
$cc_email = array(
	//"todd@poopourri.net",
	//"nealsharmon@gmail.com",
	//"bentoncrane@gmail.com",
	//"hector@poopourri.net",
	//"janette@poopourri.net",
	"rod@poopourri.net"
);


//Setup Pagination
$pagination_start = 1;
if (isset($_GET['pagination_start'])) {
	$pagination_start = (int)$_GET['pagination_start'];
}


//Get Date Range
$query_date = "yesterday";
if (isset($_GET['q'])) {
	$query_date = $_GET['q'];
}

//Get Days Ago
$daysago = "1";
if (isset($_GET['daysago'])) {
	$daysago = $_GET['daysago'];
}

//Today **just for testing
if ($query_date == "today") {
	$start_date = date("Y-m-d");
	$end_date = date("Y-m-d");

//Lots of Days **testing
} elseif ($query_date == "30days") {
	$start_date = date("Y-m-d", strtotime("-30 days"));
	$end_date = date("Y-m-d", strtotime("-1 day"));

//days ago
} elseif ($query_date == "daysago") {
	$start_date = date("Y-m-d", strtotime("-".$daysago." days"));
	$end_date = date("Y-m-d", strtotime("-".$daysago." days"));

//Just Yesterday
} else {
	$query_date = 'yesterday';
	$start_date = date("Y-m-d", strtotime("-1 day"));
	$end_date = date("Y-m-d", strtotime("-1 day"));
}



//Includes
require "class.phpmailer.php";
require "countries.php";
require "fields.php";
require "functions.php";

//Setup Args
$foxydata = array(
	"api_action" => "transaction_list",
	"is_test_filter" => 0,
//	"id_filter" => "XX",
	"transaction_date_filter_begin" => $start_date,
	"transaction_date_filter_end" => $end_date,
	"pagination_start" => $pagination_start,
	"entries_per_page" => $entries_per_page,
);

//Get Orders
$foxy_response = foxyshop_get_foxycart_data($foxydata, $foxycart_domain, $foxycart_api_key);
$xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);

//Stop On Error
if ((string)$xml->result == "ERROR") {
	foreach ($xml->messages->message as $message) {
		echo $message . "\n";
	}
	die;
}

//Setup Rows
$rows = array();
// easier for them to import orders without the titles
//$rows[] = array_keys(getFieldTitles());

//Setup Statistics
$pagination_end = (int)$xml->statistics->pagination_end;
$filtered_total = (int)$xml->statistics->filtered_total;

//For Each Order
foreach ($xml->transactions->transaction as $transaction) {
   if(
	(get_country_code((string)$transaction->shipping_country)!="001" && $shipping_region=='international')
	|| (get_country_code((string)$transaction->shipping_country)=="001" && $shipping_region=='domestic')
	|| $shipping_region=='all'
	){
	$cols = getFieldTitles();
	$extra_rows = array();

	//Basics
	$cols['source_key'] = "HARMON";
	$cols['sales_id'] = "HAR";
	$cols['shipvia'] = "PM";
	$cols['paymethod'] = "CC";
	$cols['continued'] = "";
	$cols['useshipamt'] = "Y";
	$cols['internet'] = "T";
	//$cols['altit_id01'] = (string)$transaction->transaction_id;
	$cols['internetid'] = (string)$transaction->id;
	$cols['useprices'] = 'Y';

	// as recommended by Dennis from Dydacomp in email from Rod on 9/26/13
	$cols['useshipamt'] = "Y";

	//Credit Card Type
	$original_card_type = (string)$transaction->cc_type;
	$cardtype = "VI";
	if ($original_card_type == "Visa") {
		$cardtype = "VI";
	} elseif ($original_card_type == "MasterCard") {
		$cardtype = "MC";
	} elseif ($original_card_type == "Amex") {
		$cardtype = "AE";
	} elseif ($original_card_type == "Discover") {
		$cardtype = "DI";
	}
	$cols['cardtype'] = $cardtype;
	$cols['expires'] = '02/22';
	$cols['cardnum'] = (string)$transaction->cc_number_masked;

	//Billing Address
	$cols['firstname'] = (string)$transaction->customer_first_name;
	$cols['lastname'] = (string)$transaction->customer_last_name;
	$cols['company'] = (string)$transaction->customer_company;
	$cols['address1'] = (string)$transaction->customer_address1;
	$cols['address2'] = (string)$transaction->customer_address2;
	$cols['city'] = (string)$transaction->customer_city;
	$cols['state'] = (((string)$transaction->shipping_postal_code!=(string)$transaction->customer_postal_code) ? getStateCode((string)$transaction->customer_state,(string)$transaction->customer_country) : (string)$transaction->shipping_state);
	$cols['zipcode'] = (string)$transaction->customer_postal_code;
	if ((string)$transaction->customer_country != "US") {
		$cols['cforeign'] = "Y";
	}
	$cols['country'] = get_country_code((string)$transaction->customer_country);
	$cols['phone'] = substr((string)$transaction->customer_phone, 0, 18);

	//Order Details
	$cols['paid'] = (double)$transaction->order_total;
	$cols['order_date'] = date("Ymd", strtotime((string)$transaction->transaction_date));
	$cols['odr_num'] = (string)$transaction->id;
	$cols['shipping'] = (double)$transaction->shipping_total;
	$cols['email'] = substr((string)$transaction->customer_email, 0, 50);
	$processor_response = (string)$transaction->processor_response;
	if (strpos($processor_response, "Authorize.net") !== false) {
		$cols['reference'] = trim(substr($processor_response, strpos($processor_response, ":") + 1));
	}

	//Shipping Address
	$cols['sfirstname'] = (string)$transaction->shipping_first_name;
	$cols['slastname'] = (string)$transaction->shipping_last_name;
	$cols['scompany'] = (string)$transaction->shipping_company;
	$cols['saddress1'] = (string)$transaction->shipping_address1;
	$cols['saddress2'] = (string)$transaction->shipping_address2;
	$cols['scity'] = (string)$transaction->shipping_city;
	$cols['sstate'] = (string)$transaction->shipping_state;
	$cols['szipcode'] = (string)$transaction->shipping_postal_code;
	$cols['scountry'] = get_country_code((string)$transaction->shipping_country);
	$cols['sphone'] = substr((string)$transaction->shipping_phone, 0, 18);
	$cols['semail'] = substr((string)$transaction->customer_email, 0, 50);

	//Products
	$arr_products = array();
	foreach ($transaction->transaction_details->transaction_detail as $transaction_detail) {

		//Get The Price Mod
		$price_mod = 0;
		foreach($transaction_detail->transaction_detail_options->transaction_detail_option as $transaction_detail_option) {
			$price_mod = (double)$transaction_detail_option->price_mod;
		}

		//Setup Product
		$arr_products[] = array(
			"code" => (string)$transaction_detail->product_code,
			"quantity" => (int)$transaction_detail->product_quantity,
			"price" => (double)$transaction_detail->product_price + $price_mod,
		);
	}

	//Assign Products
	$product_count = 0;
	foreach ($arr_products as $key => $val) {
		$product_count++;
		if ($product_count > 5) continue;
		$cols["product0" . $product_count] = $val['code'];
		$cols["quantity0" . $product_count] = $val['quantity'];
		$cols["price0" . $product_count] = $val['price'];
	}


	//Extra Products
	if (count($arr_products) > 5) {
		$new_col = getFieldTitles();

		$product_count = 0;
		for ($i = 5; $i < count($arr_products); $i++) {
			$product_count++;
			$current_product = $arr_products[$i - 1];
			$new_col['continued'] = "Y";
			$new_col["product0" . $product_count] = $current_product['code'];
			$new_col["quantity0" . $product_count] = $current_product['quantity'];
			$new_col["price0" . $product_count] = $current_product['price'];
			if ($product_count == 5) {
				$product_count = 0;
				$extra_rows[] = $new_col;
				$new_col = getFieldTitles();
				$new_col['continued'] = "Y";
			}
		}
		if ($product_count > 0) {
			$extra_rows[] = $new_col;
		}
	}
	$rows[] = $cols;
	if (count($extra_rows) > 0) {
		foreach ($extra_rows as $new_row) {
			$rows[] = $new_row;
		}
	}
   }
}


$write = "";
foreach ($rows as $row) {
	foreach ($row as $key => $val) {
		if ($key != "0" && $key != "custnum") {
			$write .= ",";
		}
		$write .= '"' . str_replace('"', '""', $val) . '"';
	}
	$write .= "\n";
}

//Debug
if (isset($_GET['neal-debug'])) {
	echo "<pre>" . $write . "</pre>";
	//echo "<pre>" . print_r($rows, 1) . "</pre>";
	die;
}


//Make subject and file name the same
$subject = "Sales Data ($shipping_region) For " . date("m-d-Y", strtotime("-$daysago day")) . " (" . $pagination_start . "-" . $pagination_end . ")";


//Setup File
$localpath = dirname(__FILE__) . "/tempfiles/";
$file = strtolower(str_replace(array('(',')','Sales Data '),array('','',''),$subject)).".csv";
$fp = fopen($localpath . $file, 'w');
//fwrite($fp, pack("CCC",0xef,0xbb,0xbf)); //Do the UTF-8 Encoding
//fwrite($fp, "\xEF\xBB\xBF");
fwrite($fp, $write);
fclose($fp);


//Prepare and send email (only if debug mode is false)
if (!isset($_GET['neal-debug'])) {
	$email_body = "The sales import file for " . date("m/d/Y", strtotime("-1 day")) . " is attached to this email.\n<br>";
	$email_attachment = $localpath . $file;

	$mail = new PHPMailer();

	//Attachment
	if (isset($email_attachment)) {
		if (!is_array($email_attachment)) $email_attachment = array($email_attachment);
		foreach ($email_attachment as $current_email_attachment) {
			$mail->AddAttachment($current_email_attachment);
		}
	}

	$mail->isHTML(true);
	$mail->CharSet = "UTF-8";
	$mail->SetFrom($to_email, "Order Management");
	$mail->AddAddress($to_email);
	if (is_array($cc_email)) {
		foreach ($cc_email as $cc) {
			$mail->AddCC($cc);
		}
	}
	$mail->Subject = $subject;
	$mail->Body = $email_body;
	if (!$mail->Send()) {
		echo "Email Not Sent\n";
	} else {
		echo "Email (".$shipping_region.") Sent (" . $pagination_start . "-" . $pagination_end . ")\n";
	}
}

//Delete Temp File
unlink($localpath . $file);

//Setup counter because we only want to do 5 at a time
$counter = 1;

//Keep Going if Paging Isn't Done
if ($pagination_end < $filtered_total && $counter <= 5) {
	$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?q=".$query_date."&shipping_region=".$shipping_region."&daysago=".$daysago."&pagination_start=" . ($pagination_end + 1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	echo curl_exec($ch);
	$info = curl_getinfo($ch);
	$counter++;

	//Show Diagnostic Info
	//echo "<pre>" . print_r($info, 1) . "</pre>";
	//echo "<pre>" . print_r($xml->statistics, 1) . "</pre>";

}


//All Done
die;
