function rollob(id,on) {
  document.getElementById('ob' + id).src = 'https://s3.amazonaws.com/media.orabrush.com/dimages/' + id + (on==true ? '_rollover':'') + '.png';
}

if (document.images) {
  pic1= new Image(23,26); 
  pic1.src="http://media.orabrush.com/images/header/home_icon-rollover.png"; 
  pic2= new Image(31,26); 
  pic2.src="http://media.orabrush.com/images/header/youtube_icon-rollover.png"; 
  pic3= new Image(23,26); 
  pic3.src="http://media.orabrush.com/images/header/facebook_icon-rollover.png"; 
  pic4= new Image(33,26); 
  pic4.src="http://media.orabrush.com/images/header/reviews_icon-rollover.png"; 
  pic5= new Image(14,26); 
  pic5.src="http://media.orabrush.com/images/header/iphone_icon-rollover.png"; 
  pic6= new Image(98,32); 
  pic6.src="http://media.orabrush.com/images/header/buy_online-rollover.png";  
  pic7= new Image(51,26); 
  pic7.src="http://media.orabrush.com/images/header/find_store-rollover.png";
  pic8= new Image(264,73); 
  pic8.src="http://media.orabrush.com/dimages/order_now_rollover.png";
}

jQuery.noConflict()

jQuery(document).ready(function($) {
  $('.fancybox').fancybox();
  
  $('#orabrush_checkout > #checkout_box > p > #countrys').change(function(e) {
    $('#orabrush_checkout > #checkout_box #buttons').hide();
    $('#orabrush_checkout > #checkout_box #target-button').hide();
    $('#orabrush_checkout > #checkout_box #buyscreen').show();
    $('#orabrush_checkout > #checkout_box #quantity_selector').show();
    $('#orabrush_checkout > #checkout_box #cart').show();
    $('#orabrush_checkout > #checkout_box #gtitle').show();
    
    if (this.value == 'US' || this.value == 'CA') {
      domesticOrInt = 'd';
      selectedCountry = this.value;
    } else {
      domesticOrInt = 'int';
      selectedCountry = this.value;
    }
    
    if (selectedPackage > 0) {
      selectPackage(selectedPackage,domesticOrInt);
    }
    
    showPackages();
  });
});