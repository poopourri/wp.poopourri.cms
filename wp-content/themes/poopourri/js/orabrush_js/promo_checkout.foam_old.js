var promoCountriesToCurrencies = new Object({'default':'USD','GB':'GBP','FR':'EUR','IE':'EUR','SE':'EUR','FI':'EUR','PT':'EUR','ES':'EUR','BE':'EUR','LU':'EUR','NL':'EUR','DK':'EUR','DE':'EUR','CZ':'EUR','AT':'EUR','SI':'EUR','HU':'EUR','SK':'EUR','PL':'EUR','RO':'EUR','LT':'EUR','LV':'EUR','EE':'EUR','BG':'EUR','IT':'EUR','GR':'EUR','MT':'EUR','CY':'EUR'});
var promoCurrenciesToInfo = new Object({'USD':{'store':'en','symbol':'$','pid':'167'},'GBPP':{'store':'free_shipping','symbol':'&pound;','pid':'173'},'GBP':{'store':'en_uk','symbol':'&pound;','pid':'171'},'EUR':{'store':'en_eur','symbol':'&euro;','pid':'172'}});
var promoPrices = new Object({'USD':  7.00, 'GBPP': 7.00, 'GBP':  7.00, 'EUR':  7.00});
var promoInterntlDiscount = new Object({'USD': {'1': 7.00, '2': 11.25, '4': 11.01, '6': 18.01, '10': 40.01},
                                   'GBPP': {'1': 7.00, '2': 7.01, '4': 12.01, '6': 18.01, '10': 30.01},
                                   'GBP': {'1': 7.00, '2': 7.01, '4': 12.01, '6': 18.01, '10': 30.01},
                                   'EUR': {'1': 7.00, '2': 10.44, '4': 14.01, '6': 22.03, '10': 45.01}});
var promoInterntlShipping = new Object({'USD': {'1': 4.73, '2': 6.73, '4': 8.73, '6': 10.73, '10': 14.73},
                                   'GBPP': {'1': 3.99, '2': 3.99, '4': 7.99, '6': 9.99, '10': 13.99},
                                   'GBP': {'1': 3.99, '2': 3.99, '4': 7.99, '6': 9.99, '10': 13.99},
                                   'EUR': {'1': 3.93, '2': 5.93, '4': 7.93, '6': 9.93, '10': 13.93}});
var promoInterntlShipDisc = new Object({'USD': {'1': 0, '2': 0, '4': 8.74, '6': 10.73, '10': 14.73},
                                   'GBPP': {'1': 0, '2': 3.99, '4': 7.99, '6': 9.99, '10': 13.99},
                                   'GBP': {'1': 0, '2': 3.99, '4': 7.99, '6': 9.99, '10': 13.99},
                                   'EUR': {'1': 0, '2': 2, '4': 7.93, '6': 9.93, '10': 13.93}});
var promoDomesticDiscount = new Object({'1': 7.00, '2': 7.01, '4': 13.01, '6': 18.05, '10': 30.01});
var promoDomesticShipping = new Object({'1': 3.99, '2': 5.99, '4': 7.99, '6': 9.99, '10': 13.99});
var promoDomesticShipDisc = new Object({'1': 0, '2': 3.99, '4': 7.99, '6': 9.99, '10': 13.99});

var promoSelectedCountry = 'US';
var promoSelectedStore = 'en';
var promoDomesticOrInt = 'd';
var promoSelectedPackage = 0;
var promoSelectedPid = 167;
var promoFullSiteUrl = 'http://localhost:81/wporabrush/form-trial/';
var promoFreeShipping = false;

(function($){
  $.orabrushPromoCheckout = {
    // Converts floating point price to a string representation with 2 places
    // after the decimal point preserved.
    dPrice: function(p) {
        return p.toFixed(2);
      },
  
    showPackage: function(numBrushes,where) {
        if(numBrushes == 0) {
          $('#cart').html('<img src="http://media.orabrush.com/free/images/FreeCartBackground.gif" style="left:20px;top:30px;position:absolute;"/>');
          return;
        }

        var promoElPre =  'img';

        var promoCurrencyCode = (promoCountriesToCurrencies[promoSelectedCountry] ? promoCountriesToCurrencies[promoSelectedCountry] : promoCountriesToCurrencies['default']);

        if(promoCurrencyCode=='GBP'){
          promoCurrencyCode = 'GBPP';
          promoFreeShipping = true;
        }

        var promoCurrencySymbol = (promoCurrenciesToInfo[promoCurrencyCode] ? promoCurrenciesToInfo[promoCurrencyCode]['symbol'] : promoCurrenciesToInfo['default']['symbol']);
        var promoDefaultPrice = promoPrices[promoCurrencyCode];
        var promoIntShipping = promoInterntlShipping[promoCurrencyCode];
        var promoIntDiscount = promoInterntlDiscount[promoCurrencyCode];
        var promoIntShipDisc = promoInterntlShipDisc[promoCurrencyCode];

        if(promoDomesticOrInt=='d'){
          var promoShippingValue = promoDomesticShipping[numBrushes];
          var promoDiscountValue = promoDomesticDiscount[numBrushes];
          var promoShipDiscValue = promoDomesticShipDisc[numBrushes];
        } else {
          var promoShippingValue = promoIntShipping[numBrushes];
          var promoDiscountValue = promoIntDiscount[numBrushes];
          var promoShipDiscValue = promoIntShipDisc[numBrushes];
        }

        if(promoCurrencyCode == 'JPY') {
          var promoBasePrice = promoDefaultPrice * numBrushes;
          var promoShipPrice = promoShippingValue;
          var promoSubTotal = (promoDefaultPrice * numBrushes) + promoShippingValue;
          var promoDiscount = promoDiscountValue;
          var promoShipDisc = promoShipDiscValue;
          var promotTotal = ((promoDefaultPrice * numBrushes) + promoShippingValue) - (promoDiscountValue + promoShipDiscValue);
          var promotTotalDiscount = (promoDiscountValue + promoShipDiscValue);
        } else {
          var promoBasePrice = $.orabrushPromoCheckout.dPrice(promoDefaultPrice * numBrushes);
          var promoShipPrice = $.orabrushPromoCheckout.dPrice(promoShippingValue);
          var promoSubTotal = $.orabrushPromoCheckout.dPrice((promoDefaultPrice * numBrushes) + promoShippingValue);
          var promoDiscount = $.orabrushPromoCheckout.dPrice(promoDiscountValue);
          var promoShipDisc = $.orabrushPromoCheckout.dPrice(promoShipDiscValue);
          var promotTotal = $.orabrushPromoCheckout.dPrice(((promoDefaultPrice * numBrushes) + promoShippingValue) - (promoDiscountValue + promoShipDiscValue));
          var promotTotalDiscount = $.orabrushPromoCheckout.dPrice((promoDiscountValue + promoShipDiscValue));
        }

        if (promoShipDisc > 0 && promoShipDisc != promoShipPrice) {
          var shippingDiscountNotice = '<span style="color: #E76200;">Shipping Discount - '+ promoCurrencySymbol+promoShipDisc +'</span><br/>';
        } else if (promoShipDisc > 0 && promoShipDisc == promoShipPrice) {
          var shippingDiscountNotice = '<span style="color: #E76200;">FREE Shipping! - '+ promoCurrencySymbol+promoShipDisc +'</span><br/>';
        } else {
          var shippingDiscountNotice = '';
        }
        promoGrandTotal = promotTotal;
        $('#promo_checkout > .accordion > .order > .widget > .cart').html(numBrushes + ' Orabrush '+promoCurrencySymbol+promoBasePrice+'<br/>Shipping/Handling  '+promoCurrencySymbol+promoShipPrice+'<br/><b>Subtotal '+promoCurrencySymbol+promoSubTotal+'</b><br/><span style="color: #E76200;">Promo Discount - '+promoCurrencySymbol+promoDiscount+ '</span><br/>'+ shippingDiscountNotice +'<div style="margin-bottom:4px;margin-top:4px;border:1px solid #666666;height:0px;"></div><h2>Total  '+promoCurrencySymbol+promotTotal+'</h2><br/><span style="font-weight: bold; font-size: 11pt; color: red; position: absolute; right: 25px; bottom: 30px;">You are saving  '+promoCurrencySymbol+promotTotalDiscount+'!</span></b>');
      },
  
    selectPackage: function(numBrushes,where) {
        var promoElPre =  'img';
        var promoCurrencyCode = (promoCountriesToCurrencies[promoSelectedCountry] ? promoCountriesToCurrencies[promoSelectedCountry] : promoCountriesToCurrencies['default']);

        if(promoCurrencyCode=='GBP'){
          promoCurrencyCode='GBPP';
        }

        promoSelectedPid = (promoCurrenciesToInfo[promoCurrencyCode] ? promoCurrenciesToInfo[promoCurrencyCode]['pid'] : promoCurrenciesToInfo['default']['pid']);
        promoSelectedStore = (promoCurrenciesToInfo[promoCurrencyCode] ? promoCurrenciesToInfo[promoCurrencyCode]['store'] : promoCurrenciesToInfo['default']['store']);
        promoSelectedPackage = numBrushes;

        $.orabrushPromoCheckout.showPackage(numBrushes, where);

        $('#promo_checkout > .accordion > .order > .widget > .buttons').show();
      },
  
    go_to_checkout: function(typeofcheckout) {
        var promoCurrencyCode = (promoCountriesToCurrencies[promoSelectedCountry] ? promoCountriesToCurrencies[promoSelectedCountry] : promoCountriesToCurrencies['default']);

        if(promoCurrencyCode=='GBP'){
          promoCurrencyCode='GBPP';
        }

        var coupon = promoSelectedPackage == 1 ? '/coupon/FREE' : '';  
/*
        if(typeofcheckout=='paypal'){
          document.location.href =  promoFullSiteUrl  + (promoSelectedPackage<=2 && promoCurrencyCode!='GBPP' ? '/'+promoSelectedStore+'_micro' : '/'+promoSelectedStore) + '/checkout/cart/bridge/id/'+promoSelectedPid+'/method/paypal/qty/' + promoSelectedPackage + (promoFreeShipping==true || promoCurrencyCode=='GBPP' ? '/ship/free' : '') + coupon + (promoDomesticOrInt=='int' ? '/int/1' : '') + '/country/' + promoSelectedCountry;
        } else{
          document.location.href =  promoFullSiteUrl + (promoSelectedPackage==2 && promoCurrencyCode!='GBPP' ? '/'+promoSelectedStore+'_micro' : '/'+promoSelectedStore)  + '/checkout/cart/bridge/id/'+promoSelectedPid+'/method/cc/qty/' + promoSelectedPackage + (promoFreeShipping==true || promoCurrencyCode=='GBPP' && promoSelectedPackage > 1 ? '/ship/free' : '') + coupon + (promoDomesticOrInt=='int' ? '/int/1' : '') + '/country/' + promoSelectedCountry;
        }  
*/
          document.location.href = 'http://localhost:81/wporabrush/form-trial/?qty=' + promoSelectedPackage + '&checkout=' + typeofcheckout + '&pid=' + promoSelectedPid + '&price=' + promoGrandTotal + '&coupon=' + coupon + (freeShipping==true || promoCurrencyCode=='GBPP' && promoSelectedPackage > 1 ? '&free_shipping=true' : '') + '&currency=' + promoCurrencyCode + '&store=' + (promoSelectedPackage==2 && promoCurrencyCode!='GBPP' ? promoSelectedStore+'_micro' : promoSelectedStore);
 
      }
  }
})(jQuery);

jQuery(function($) {
  $(document).data('checkout_promo_followed', false);
  $(document).data('checkout_promo_subscribed', false);
  
  $('a[href="#promo_checkout"].fancybox').fancybox({
    width:    523,
    height:   516,
    padding:  0
  });

  $('#promo_checkout > .accordion').accordion({
    collapsible: true,
    autoHeight: false,
    active: false,
    animated: false,
    clearStyle: true,
    change: function(event, ui) {
        if(ui.newContent.hasClass('follow')) {
          $('#promo_checkout .follow > .facebook_holder').html('<iframe id="become_a_fan_iframe" scrolling="no" frameborder="0" src="http://www.facebook.com/connect/connect.php?id=82363921476&amp;connections=14&amp;stream=0" allowtransparency="true" style="border: none; width: 400px; height:245px;background:transparent;"></iframe>');
          $(document).data('checkout_promo_followed', true);
          pageTracker._trackPageview('become-a-fan');
        } else if(ui.newContent.hasClass('subscribe')) {
          ui.newContent.html('<iframe id="fr" src="http://www.youtube.com/subscribe_widget?p=curebadbreath" style="overflow: hidden; height: 105px; width: 300px; border: 0; margin: 0 50px;" scrolling="no" frameborder="0"></iframe>');
          $(document).data('checkout_promo_subscribed', true);
          pageTracker._trackPageview('subscribe');
        } else if(ui.newContent.hasClass('order')) {
          if($(document).data('checkout_promo_subscribed') && $(document).data('checkout_promo_followed')) {
            $('#promo_checkout > .accordion > .order > .complete_steps').hide();
            $('#promo_checkout > .accordion > .order > .widget').show();
          } else if($(document).data('checkout_promo_subscribed') && !$(document).data('checkout_promo_followed')) {
            pageTracker._trackPageview('please-complete-step1');
          } else if(!$(document).data('checkout_promo_subscribed') && $(document).data('checkout_promo_followed')) {
            pageTracker._trackPageview('please-complete-step2');
          } else {
            pageTracker._trackPageview('please-complete-both-steps');
          }
        }
      }
  });

  $('#promo_checkout > .accordion > .order > .widget').hide();
  $('#fancybox_holder').hide();
  $('#promo_checkout > .accordion > .order > .widget > .cart').hide();
  $('#promo_checkout > .accordion > .order > .widget > .select_qty').hide();
  $('#promo_checkout > .accordion > .order > .why_pay_shipping').hide();
  $('#promo_checkout > .accordion > .order > .widget > .buttons').hide();
  
  $('#promo_checkout > .accordion > .order > .widget > #countrys').change(function(e) {
    promoSelectedCountry = $(this).val();
    
    if(promoSelectedCountry == 'US' || promoSelectedCountry == 'CA') {
      promoDomesticOrInt = 'd';
    } else {
      promoDomesticOrInt = 'int';
    }
    
    $('#promo_checkout > .accordion > .order > .widget > .cart').show();
    $('#promo_checkout > .accordion > .order > .widget > .select_qty').show();
  });
  
  $('#promo_checkout > .accordion > .order > .widget > .select_qty > ul > li > a').mouseover(function() {
    var qty = $(this).attr('data-value');
    
    $.orabrushPromoCheckout.showPackage(qty, promoDomesticOrInt);
  });
  
  $('#promo_checkout > .accordion > .order > .widget > .select_qty > ul > li > a').mouseout(function() {
    $.orabrushPromoCheckout.showPackage(promoSelectedPackage, promoDomesticOrInt);
  });
  
  $('#promo_checkout > .accordion > .order > .widget > .select_qty > ul > li > a').click(function(e) {
    e.preventDefault();
    
    var qty = $(this).attr('data-value');
    
    if(qty < 4) {
      $('#promo_checkout > .accordion > .order > .widget > .select_qty > a[href="#why_pay_shipping"]').show();
    } else {
      $('#promo_checkout > .accordion > .order > .widget > .select_qty > a[href="#why_pay_shipping"]').hide();
    }
    
    $.orabrushPromoCheckout.selectPackage(qty, promoDomesticOrInt);
  });
  
  $('#promo_checkout a[href="#follow"]').click(function(e) {
    e.preventDefault();
    
    $('#promo_checkout > .accordion').accordion('activate', 0);
  });
  
  $('#promo_checkout a[href="#subscribe"]').click(function(e) {
    e.preventDefault();
    
    $('#promo_checkout > .accordion').accordion('activate', 1);
  });
  
  $('#promo_checkout a[href="#why_pay_shipping"]').click(function(e) {
    e.preventDefault();
    
    $('#promo_checkout > .accordion > .order > .widget').hide();
    $('#promo_checkout > .accordion > .order > .why_pay_shipping').show();
  });
  
  $('#promo_checkout > .accordion > .order > .why_pay_shipping > .back_to_cart').click(function(e) {
    e.preventDefault();
    
    $('#promo_checkout > .accordion > .order > .why_pay_shipping').hide();
    $('#promo_checkout > .accordion > .order > .widget').show();
  });
  
  $('#purchase3why').click(function(e) {
    e.preventDefault();
    
    $.orabrushPromoCheckout.selectPackage(4, promoDomesticOrInt);
    
    $('#promo_checkout > .accordion > .order > .why_pay_shipping').hide();
    $('#promo_checkout > .accordion > .order > .widget').show();
    $('#promo_checkout > .accordion > .order > .widget > .select_qty > a[href="#why_pay_shipping"]').hide();
  });
  
  $('#promo_checkout a[href="#paypal"]').click(function(e) {
    e.preventDefault();
    
    $.orabrushPromoCheckout.go_to_checkout('paypal');
  });
  
  $('#promo_checkout a[href="#cc"]').click(function(e) {
    e.preventDefault();
    
    $.orabrushPromoCheckout.go_to_checkout('cc');
  });
});