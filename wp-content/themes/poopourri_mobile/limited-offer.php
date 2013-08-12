<?php
/**
 * Template Name: Limited offer Page Template
 * @package WordPress
 * @subpackage Orabrush
 * @since Twenty Ten 1.0
 */
?>
<html>
<head>



<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/jquery.query.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/common.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/promo_checkout.foam.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/orabrush_js/pricing.multi.js?apri1"></script>
<script src="//cdn.foxycart.com/oraclub-staging/foxycart.colorbox.js?ver=2" type="text/javascript" charset="utf-8"></script>


<link media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/orabrush_css/jquery.fancybox-1.3.4.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/orabrush_css/promo_checkout.css" type="text/css">


<style type="text/css">
#fancybox_holder
{
  display: block !important;
}
</style>

<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function() {

	$('.buynowchk').click(function(){
		$('#dialog').dialog('close');
		window.opener.location.href = '#paypal';
		window.close();
		 $('#dialog').dialog('close');
	});
	$('.buynowchkpay').click(function(){
		
	});

});

</script>





</head>


<body >


<div id="primary-help" class="site-content" style="overflow: hidden;">
		<div id="content11" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	

<div id="content" class="container">
  <div class="inner">
       
<script type="text/javascript" src="/store/js/cache/pricing.multi.js?apri1"></script>
<script>
  var selectedCountry = 'US';
  var selectedStore = 'en';
  var domesticOrInt = 'd';
  var selectedPackage = false;
  var selectedPid = 167;
  var full_site_url = 'http://www.orabrush.com/store';
  var freeShipping = false;
  var domesticOrInt = 'd';
  var gGrandTotal = '3.99';
  
  function dPrice(p){
    return p.toFixed(2);
  }

  var media_url = 'http://drtoqvya7fqx1.cloudfront.net/free/images/';
  function showPackage(numBrushes,where){
   var el_pre =  'img';
   if(selectedPackage!=1){
    jQuery('#p1').css('color','rgb(150, 150, 150)');
    jQuery(el_pre + '1').attr('src', media_url + 'stick1-off.gif');
   }
   if(selectedPackage!=2){
    jQuery('#p2').css('color','rgb(150, 150, 150)');
    jQuery(el_pre + '2').attr('src', media_url + 'stick2-off.gif');
   }
   if(selectedPackage!=4){
    jQuery('#p4').css('color','rgb(150, 150, 150)');
    jQuery(el_pre + '4').attr('src', media_url + 'stick4-off.gif');
   }
   if(selectedPackage!=6){
    jQuery('#p6').css('color','rgb(150, 150, 150)');
    jQuery(el_pre + '6').attr('src', media_url + 'stick6-off.gif');
   }
   if(selectedPackage!=10){
    jQuery('#p10').css('color','rgb(150, 150, 150)');
    jQuery(el_pre + '10').attr('src', media_url + 'stick10-off.gif');
   }
   if(numBrushes>0 && numBrushes!=selectedPackage){
     jQuery(el_pre +numBrushes).attr('src', media_url + 'stick' + numBrushes + '-on.gif');
     jQuery('#p'+numBrushes).css('color','rgb(0, 150, 150)');
   }else if(selectedPackage!=false){
     numBrushes = selectedPackage;
   }else{
     jQuery('#cart').html('<img src="http://media.orabrush.com/free/images/FreeCartBackground.gif" style="left:20px;top:30px;position:absolute;"/>');
     return;
   }

   // set up the arrays and variables
   var currencyCode = (gCountriesToCurrencies[selectedCountry] ? gCountriesToCurrencies[selectedCountry] : gCountriesToCurrencies['default']);
   if(currencyCode=='GBP'){
     currencyCode='GBPP';
   }
   var currencySymbol = (gCurrenciesToInfo[currencyCode] ? gCurrenciesToInfo[currencyCode]['symbol'] : gCurrenciesToInfo['default']['symbol']);
   var defaultPrice = gDefaultPrice[currencyCode];
   var IntShipping = gIntShipping[currencyCode];
   var Intdiscounts = gIntdiscounts[currencyCode];
   if(domesticOrInt=='d'){
     var Shipping = DomesticShipping;
     var Discount =  discounts;
    }else{
     var Shipping = gIntShipping[currencyCode];
     var Discount =  gIntdiscounts[currencyCode];
    }
    var localFreeShipping = (Shipping[numBrushes] == 0);
    if(numBrushes == 1){
      localFreeShipping = (Discount[numBrushes] > Shipping[numBrushes]) || (currencyCode == 'GBPP');
      jQuery('#cart').html(numBrushes + ' Orabrush '+currencySymbol+dPrice(defaultPrice * numBrushes)+'<br/>Shipping/Handling  '+currencySymbol+dPrice(Shipping[1])+'<br/><b>Subtotal '+currencySymbol+dPrice(Shipping[1] + defaultPrice * numBrushes)+'</b><br/><span style="color: #E76200;">Web discount - '+currencySymbol+ dPrice(Discount[numBrushes] - Shipping[1]) + '<br/>'+(localFreeShipping == true ? '<b>FREE shipping!</b>' : 'Shipping discounts' )+' - '+currencySymbol+ dPrice(Shipping[1]) + '</span><br/><div style="margin-bottom:4px;margin-top:4px;border:1px solid #666666;height:0px;"></div><h2>Total  '+currencySymbol+dPrice(defaultPrice * numBrushes - Discount[numBrushes] + Shipping[numBrushes])+'</h2><br/><span style="font-weight: bold; font-size: 11pt; color: red; position: absolute; right: 25px; bottom: 30px;">You are saving  '+currencySymbol+dPrice(Shipping[1] +  Discount[numBrushes] - Shipping[numBrushes])+'!</span></b>');
      gGrandTotal = dPrice(defaultPrice * numBrushes - Discount[numBrushes] + Shipping[numBrushes]);
    }else if (numBrushes == 4 && selectedCountry == 'US') {
      jQuery('#cart').html('Orabrush 4-Packs are available from select online retailers');
    }else{
      gGrandTotal = dPrice(defaultPrice * numBrushes - Discount[numBrushes] + Shipping[numBrushes]);
      jQuery('#cart').html(numBrushes + ' Orabrushes '+currencySymbol+dPrice(defaultPrice * numBrushes)+'<br/>'+ (localFreeShipping == true ? '<span style="color: #E76200;"><b>FREE shipping!</b></span>' : 'Shipping/Handling'+currencySymbol+dPrice(Shipping[1] + numBrushes))+'<br/><b>Subtotal '+currencySymbol+dPrice(Shipping[1] + numBrushes + defaultPrice * numBrushes)+'</b><br/><span style="color: #E76200;">Web discount - '+currencySymbol+ dPrice(Discount[numBrushes]) + '<br/>Shipping discount - '+currencySymbol+ dPrice(Shipping[1] + numBrushes - Shipping[numBrushes]) + '</span><br/><div style="margin-bottom:4px;margin-top:4px;border:1px solid #666666;height:0px;"></div><h2>Total  '+currencySymbol+dPrice(defaultPrice * numBrushes - Discount[numBrushes] + Shipping[numBrushes])+'</h2><br/><span style="font-weight: bold; font-size: 11pt; color: red; position: absolute; right: 25px; bottom: 30px;">You are saving  '+currencySymbol+dPrice(Shipping[1] + numBrushes +  Discount[numBrushes] - Shipping[numBrushes])+'!</span></b>');
    }
  }

  function selectPackage(numBrushes,where){
   var el_pre =  'img';
   var currencyCode = (gCountriesToCurrencies[selectedCountry] ? gCountriesToCurrencies[selectedCountry] : gCountriesToCurrencies['default']);
   if(currencyCode=='GBP'){
     currencyCode='GBPP';
   }
   selectedPid = (gCurrenciesToInfo[currencyCode] ? gCurrenciesToInfo[currencyCode]['pid'] : gCurrenciesToInfo['default']['pid']);
   selectedStore = (gCurrenciesToInfo[currencyCode] ? gCurrenciesToInfo[currencyCode]['store'] : gCurrenciesToInfo['default']['store']);
   selectedPackage = numBrushes;
   freeShipping =  (DomesticShipping[numBrushes] == 0);
  showPackage(numBrushes,where);
   if(numBrushes>0){
     jQuery(el_pre+numBrushes).attr('src', media_url + 'stick' + numBrushes + '-on.gif');
   }

   if(numBrushes == 4 && selectedCountry == 'US'){
     jQuery('#buttons').hide();
     jQuery('#retailer-buttons').show();
   } else {
     jQuery('#retailer-buttons').hide();
     jQuery('#buttons').show();
   }
   
   pageTracker._trackPageview('selectPackage'+numBrushes);
  }

  function showPackages(){
   var currencyCode = (gCountriesToCurrencies[selectedCountry] ? gCountriesToCurrencies[selectedCountry] : gCountriesToCurrencies['default']);
   if(currencyCode=='GBP'){
     jQuery('#sel1pack').show();
     jQuery('#sel6pack').hide();
   }else{
     jQuery('#sel1pack').hide();
     jQuery('#sel6pack').show();
   }
  }

  function go_to_checkout(typeofcheckout){
   var currencyCode = (gCountriesToCurrencies[selectedCountry] ? gCountriesToCurrencies[selectedCountry] : gCountriesToCurrencies['default']);
   if(currencyCode=='GBP'){
     currencyCode='GBPP';
   }
  if(jQuery('#coupon')){
     var coupon = (jQuery('#coupon').val() != '' ? '/coupon/' + jQuery('#coupon').val() : '');
     var couponCode = jQuery('#coupon').val();
   }else{
     var coupon = '';
     var couponCode = '';
   }
   if(typeofcheckout=='paypal'){
    document.location.href =  full_site_url  + (selectedPackage<=2 && currencyCode!='GBPP' ? '/'+selectedStore+'_micro' : '/'+selectedStore) + '/checkout/cart/bridge/id/'+selectedPid+'/method/paypal/qty/' + selectedPackage + (freeShipping==true || currencyCode=='GBPP' ? '/ship/free' : '') + coupon + (domesticOrInt=='int' ? '/int/1' : '') + '/country/' + selectedCountry;
   }else{
    document.location.href =  full_site_url + (selectedPackage==2 && currencyCode!='GBPP' ? '/'+selectedStore+'_micro' : '/'+selectedStore)  + '/checkout/cart/bridge/id/'+selectedPid+'/method/cc/qty/' + selectedPackage + (freeShipping==true || currencyCode=='GBPP' && selectedPackage > 1 ? '/ship/free' : '') + coupon + (domesticOrInt=='int' ? '/int/1' : '') + '/country/' + selectedCountry;
   }
   document.location.href = 'http://localhost:81/wporabrush/form-trial/?qty=' + selectedPackage + '&checkout=' + typeofcheckout + '&pid=' + selectedPid + '&price=' + gGrandTotal + '&coupon=' + coupon + (freeShipping==true || currencyCode=='GBPP' && selectedPackage > 1 ? '&free_shipping=true' : '') + '&currency=' + currencyCode + '&store=' + (selectedPackage==2 && currencyCode!='GBPP' ? selectedStore+'_micro' : selectedStore);
  }
  
  jQuery(document).ready(function($) {
    $('#coupon_notice').hide();

    $('#coupon').keyup(function() {
      if($(this).val() == '') {
        $('#coupon_notice').hide();
      } else {
        $('#coupon_notice').show();
      }
    });
    
    $('#checkout_target').click(function(e) {
      pageTracker._trackPageview('target-checkout');
    });
    
    $('#checkout_walgreens').click(function(e) {
      pageTracker._trackPageview('walgreens-checkout');
    });
    
    /*
     *  Special check to display a country specific message.
     */
    /*
    $('#countrys').change(function () {
      if ($('#countrys').val() == 'CA') {
        $('#canada-strike').show();
      } else {
        $('#canada-strike').hide();
      }
    });
    */
  });
</script>
<div id="fancybox_holder">
  <div id="promo_checkout">
    <div class="accordion">
      <h3 class="follow">
        <a href="#">1.) Follow us on Facebook or Twitter</a>
      </h3>
      <div class="follow">
        <div class="facebook_holder">
          Loading...
        </div>
        <div class="twitter_holder">
          <span>Orabrush <span>on Twitter</span></span>
          <iframe src="http://api.tweetmeme.com/v2/follow.js?screen_name=orabrush&style=normal" height="30" width="85"></iframe>
        </div>
      </div>
      <h3 class="subscribe">
        <a href="#">2.) Subscribe to Orabrush on YouTube (it's free too)</a>
      </h3>
      <div class="subscribe">
        Loading...
      </div>
      <h3 class="order">
        <a href="#">3.) Order your free* Orabrush here</a>
      </h3>
      <div class="order">
        <div class="widget">
          <p class="send_where">Where do you need your FREE Orabrush sent?</p>
          <select name="country" id="countrys"> 
            <option value="" selected="selected">Select your country</option>
            <option value="AU">Australia</option>
            <option value="CA">Canada</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="AF">Afghanistan</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="VG">British Virgin Islands</option>
            <option value="BN">Brunei</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="CV">Cape Verde</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo - Brazzaville</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czech Republic</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-Bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and McDonald Islands</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="CI">Ivory Coast</option>
            <option value="JM">Jamaica</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Laos</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macau</option>
            <option value="MK">Macedonia</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="FX">Metropolitan France</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia</option>
            <option value="MD">Moldova</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="AN">Netherlands Antilles</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="KP">North Korea</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Reunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russia</option>
            <option value="RW">Rwanda</option>
            <option value="SH">Saint Helena</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and the Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and the South Sandwich Islands</option>
            <option value="KR">South Korea</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SZ">Swaziland</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syria</option>
            <option value="TW">Taiwan</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania</option>
            <option value="TH">Thailand</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="VI">U.S. Virgin Islands</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VA">Vatican</option>
            <option value="VE">Venezuela</option>
            <option value="VN">Vietnam</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
          </select>
          <div class="select_qty">
            Select Quantity
            <ul>
              <li><a href="#single" data-value="1" title="Click to select 1 Orabrush Tongue Cleaner"><img src="http://media.orabrush.com/free/images/stick1-off.gif" id="img1" /> <i>Single</i></a></li>
              <li><a href="#double" data-value="2"title="Click to select 2 Orabrush Tongue Cleaners"><img src="http://media.orabrush.com/free/images/stick2-off.gif" id="img2" /> <i>His/Her Pack</i></a></li>
              <li><a href="#quad" data-value="4" title="Click to select 4 Orabrush Tongue Cleaners"><img src="http://media.orabrush.com/free/images/stick4-off.gif" id="img4" /> <i>Multi-pack</i></a></li>
              <li><a href="#six" data-value="6" title="Click to select 6 Orabrush Tongue Cleaners"><img src="http://media.orabrush.com/free/images/stick6-off.gif" id="img6" /> <i>Family Pack</i></a></li>
              <li><a href="#ten" data-value="10" title="Click to select 10 Orabrush Tongue Cleaners"><img src="http://media.orabrush.com/free/images/stick10-off.gif" id="img10" /> <i>Best Value - 10</i></a></li>
            </ul>
            <br/><br/>
            <a href="#why_pay_shipping">Why do I pay shipping?</a>
          </div>
          <div class="cart">
            <img src="http://media.orabrush.com/free/images/FreeCartBackground.gif" class="empty" />
          </div>
          <div class="buttons">
<!--            Please choose your payment method.<br/>-->
<!--            <a class="buynowchk"  title="Checkout with PayPal" href="#paypal"><img title="Checkout with PayPal" src="https://s3.amazonaws.com/media.orabrush.com/images/checkout/checkout-paypal.png"/></a>-->
            <a class="buynowchkpay"  title="Checkout with Visa, Mastercard, Discover or American Express" href="#cc"><img title="Checkout with Visa, Mastercard, Discover or American Express" src="https://s3.amazonaws.com/media.orabrush.com/images/checkout/checkout-cc.png"/></a>
          </div>
        </div>
        <div class="complete_steps">
          <p>Before ordering your free Orabrush, please complete steps 1 and 2:</p>
          <ol>
            <li><a href="#follow">Follow us on Facebook or Twitter</a></li>
            <li><a href="#subscribe">Subscribe to Orabrush on YouTube</a></li>
          </ol>
        </div>
        <div class="why_pay_shipping">
          <a href="#" class="back_to_cart">&lt;&lt; back to cart</a>
          <img src="http://media.orabrush.com/free/images/drbob.jpg" title="Dr. Robert Wagstaff invented, patented and trademarked the Orabrush" style="width: 225px; float: right; margin-left: 1em; margin-bottom: 1em;">
          <p>Hello, I'm Dr. Bob, inventor of the Orabrush.</p>
          <p>This is a photo when I was working 12 hour days trying to fulfill the free Orabrush orders. I had to hire another company to help. We are small and cannot afford to cover s&amp;h on your first free brush.</p>
          <p>If you <a href="#" id="purchase3why">purchase three cleaners</a>, we can absorb the cost of <b>an additional FREE Orabrush AND FREE shipping.</b> Thank you for using Orabrush!</p>
          <a href="#" class="back_to_cart">back to cart &gt;&gt;</a>
        </div>
      </div>
    </div>
    <div class="shipping_notice">
      <img src="http://media.orabrush.com/images/promo_checkout/shipping.png" title="Shipping and handling not included">
    </div>
  </div>
</div>

<?php endwhile; // end of the loop. ?>


</body>
</html>

