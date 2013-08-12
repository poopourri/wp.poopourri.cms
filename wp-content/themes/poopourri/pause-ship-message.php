<?php /**
 * Template Name: Pause Ship Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */
get_header();
?>
<?php
$sub_token = $_GET['sub_token'];
$sub_date = $_GET['shipdate'];
if(!$sub_token && !$shipdate){
    echo '<h1 class="entry-title" style="margin-bottom: 20px;">Sub token is not found</h1>';
}
$undoFlag = $_GET['undo'];
if($undoFlag == true){
    
    $oldShipDate = strtotime(' '.$sub_date.' ');
    $oldShippingDate = date('M d, Y', $oldShipDate);
    $shipDate = strtotime("-1 month", $oldShipDate);
    $newShipDate = date('Y-m-d', $shipDate);
    $newShippingDate = date('M d, Y', $shipDate);

    $foxy_data = array("api_action" => "subscription_modify", "sub_token" => $sub_token, "next_transaction_date" => $newShipDate);
    $foxy_response = foxyshop_get_foxycart_data($foxy_data);
    $xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
    
    if ($xml->result == "ERROR") {
            echo '<div class = "ship-date-info-height" style="height: 60px;"></div>';
            echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your Scheduled Deliveries</h1>';
            echo "<p>No Scheduled Deliveries.</p>";
    }else{
            echo '<div class = "ship-date-info-height" style="height: 60px;"></div>';
            echo '<div class = "ship-date-info-main-div" style="min-height: 400px;">';
            echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your shipping date has been changed</h1>';
            echo '<div class = "ship-date-info" style= "line-height: 31px;">Your old shipping date was '.$oldShippingDate.'</div>';
            echo '<div class = "ship-date-info" style= "line-height: 31px;">Now your shipping date is  '.$newShippingDate.'</div>';
            echo '</div>';
    }
    
}else{
    
    $foxy_data = array("api_action" => "subscription_get", "sub_token" => $sub_token);
    $foxy_response = foxyshop_get_foxycart_data($foxy_data);
    $xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);
    
    $nextTransactionDate = (string)$xml->subscription->next_transaction_date;
    
    $oldShipDate = strtotime(' '.$sub_date.' ');
    
    if($nextTransactionDate == $sub_date){
        
        $oldShippingDate = date('M d, Y', $oldShipDate);
        $shipDate = strtotime("+1 month", $oldShipDate);
        $newShipDate = date('Y-m-d', $shipDate);
        $newShippingDate = date('M d, Y', $shipDate);

        $foxy_data = array("api_action" => "subscription_modify", "sub_token" => $sub_token, "next_transaction_date" => $newShipDate);
        $foxy_response = foxyshop_get_foxycart_data($foxy_data);
        $xml = simplexml_load_string($foxy_response, NULL, LIBXML_NOCDATA);

        if ($xml->result == "ERROR") {
                echo '<div class = "ship-date-info-height" style="height: 60px;"></div>';
                echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your Scheduled Deliveries</h1>';
                echo "<p>No Scheduled Deliveries.</p>";
        }else{
                echo '<div class = "ship-date-info-height" style="height: 60px;"></div>';
                echo '<div class = "ship-date-info-main-div" style="min-height: 400px;">';
                echo '<h1 class="entry-title" style="margin-bottom: 20px;">Your ship date is paused by 1 month</h1>';
                echo '<div class = "ship-date-info" style= "line-height: 31px;">Your old shipping date was  '.$oldShippingDate.'</div>';
                echo '<div class = "ship-date-info" style= "line-height: 31px;">Your new shipping date is now  '.$newShippingDate.'</div>';
                echo '<div class = "undo-shipping-date"><a href = "'.esc_url( home_url( '/' )).'pause-the-ship-date?sub_token='.$sub_token.'&shipdate='.$newShipDate.'&undo=true" >(undo)</a></div>';
                echo '</div>';
        }
    }else{
                echo '<div class = "ship-date-info-height" style="height: 60px;"></div>';
                echo '<div class = "ship-date-info-main-div" style="min-height: 400px;">';
                echo '<h1 class="entry-title" style="margin-bottom: 20px;">You have already changed your ship date</h1>';
    }
}    
?>
<?php get_footer(); ?>