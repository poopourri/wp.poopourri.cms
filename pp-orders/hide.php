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
$entries_per_page = 5;


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

//Get import_to_MOM flag
$import_to_MOM = false;
if (isset($_GET['import_to_MOM'])) {
	$import_to_MOM = $_GET['import_to_MOM'];
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

//Just Yesterday - second one for testing and getting around caching problems with wpengine
} elseif ($query_date == "another") {
	$start_date = date("Y-m-d", strtotime("-1 day"));
	$end_date = date("Y-m-d", strtotime("-1 day"));

//Just Yesterday
} else {
	$query_date = 'yesterday';
	$start_date = date("Y-m-d", strtotime("-1 day"));
	$end_date = date("Y-m-d", strtotime("-1 day"));
}



//Includes
require "functions.php";

//Setup Args
$foxydata = array(
	"api_action" => "transaction_list",
	"is_test_filter" => 0,
	"hide_transaction_filter" => 0,
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

//Setup Statistics
$pagination_end = (int)$xml->statistics->pagination_end;
$filtered_total = (int)$xml->statistics->filtered_total;

//For Each Order
foreach ($xml->transactions->transaction as $transaction) {
	echo 'Processing:'.(string)$transaction->id.'<br/>'."\n";
		$foxy_data2 = array("api_action" => "transaction_modify", "hide_transaction" => 1, "transaction_id" => (string)$transaction->id);
		//print_r($foxy_data2);
		$foxy_response2 = foxyshop_get_foxycart_data($foxy_data2);

		$xml2 = simplexml_load_string($foxy_response2, NULL, LIBXML_NOCDATA);
		if ($xml2->result == "ERROR") {
			echo 'Failed to hide transaction id:'.(string)$transaction->id.'<br/>'."\n";
			foreach ($xml2->messages->message as $message) {
				echo $message . "\n";
			}
			die;
		}else{
			echo 'Hidden:'.(string)$transaction->id.'<br/>'."\n";
		}

}

//All Done
die;