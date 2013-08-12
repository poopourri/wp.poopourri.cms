<?php
header('Content-type: application/json');
$storedomain = $_POST['storedomain'];
$fccSession = $_POST['fccSession'];
$quantity = $_POST['quantity'];
$callback = $_REQUEST['callback'];

$secret = "spfx8b6b68fced71cd3c41c280513a89ed592382ae2ef8ae022622f1fac240838381";

$name = 'Orabrush';
$code = 'freeob';
$price = '7.00';
$discount = 'Discount{allunits|0-3.01|2-2.505|4-3.2525|6-3.0083|10-3.001}';

$name_hash = hash_hmac('sha256', $code.'name'.$name, $secret); // Hash of the "name" input
$price_hash = hash_hmac('sha256', $code.'price'.$price, $secret); // Hash of the "price" input
$quantity_hash = hash_hmac('sha256', $code.'quantity'.$quantity, $secret); // Hash of the "price" input
$code_hash = hash_hmac('sha256', $code.'code'.$code, $secret); // Hash of the "code" input
$discount_hash = hash_hmac('sha256', $code.'discount_quantity_amount'.$discount, $secret); // Hash of the "discount" input

$url = '?name||'.$name_hash.'=Orabrush&price||'.$price_hash.'='.$price.'&quantity||'.$quantity_hash.'='.$quantity.'&code||'.$code_hash.'='.$code.'&discount_quantity_amount||'.$discount_hash.'='.$discount;

$url = 'https://'.$storedomain.'/cart'.$url.$fccSession.'&output=json';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);	
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

curl_exec($curl);
curl_close($curl);

$response['status'] = $url;
echo $callback.'('.json_encode($response).')';
?>