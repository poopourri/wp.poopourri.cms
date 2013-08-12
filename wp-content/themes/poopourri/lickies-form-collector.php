<?php
/**
 * Template Name: Lickies Form Collector
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */
$postArray = $_POST;
$fcsid = $_GET['fcsid'];
if(count($postArray)){
	header('Content-type: application/json');
	$storedomain = "oraclub-staging.foxycart.com";
	$url = 'https://'.$storedomain.'/cart?output=json';
	$appendQuantity = true;
	$xQuantity = 1;
	$freeCodeKey = array_search('freepup',$postArray) ;
	foreach($postArray as $key=>$value) {
		$appendString = $key.'='.urlencode($value).'&';
		if($key == 'x:quantity'){
			 $xQuantity = $value;
		}
		if(($key == 'quantity' || $key == 'x:quantity') && !strncmp($freeCodeKey,'code',4)){
			$appendString = 'x:quantity=1%7C%7Ce6ed1c6875c556f4a8129e2f2ce2949d7f652f4149ab0009b9b283094fc5d512&';	
			$appendQuantity = false;
		} else if($key == 'quantity'){
			$appendQuantity = false;
		}
		$fields_string .= $appendString;
	}
	rtrim($fields_string, '&');
	$fields_string = $fields_string."fcsid=" . urlencode($fcsid);
	if($appendQuantity){
		$fields_string = $fields_string."&quantity=" . urlencode($xQuantity);
	}
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_POST, count($postArray)+1);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $fields_string);

	$response = curl_exec($curl);
	echo(1);
	curl_close($curl);
}
?>
