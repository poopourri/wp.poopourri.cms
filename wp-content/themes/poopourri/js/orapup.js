var $ = jQuery.noConflict();
var isChecked = false;
$.cookie.json = true;

var freeProductFormId = "foxyshop_product_form_1290";
var additionalProductFormId = "foxyshop_product_form_1948";
var freeOrabrushId = "foxyshop_product_form_276";
var checkoutURL = "https://oraclub-staging.foxycart.com/checkout.php";
var packageFormIds = ["foxyshop_product_form_225", "foxyshop_product_form_231", "foxyshop_product_form_236", "foxyshop_product_form_1124","foxyshop_product_form_906","foxyshop_product_form_1035","foxyshop_product_form_914","foxyshop_product_form_989","foxyshop_product_form_1106","foxyshop_product_form_1094","foxyshop_product_form_965","foxyshop_product_form_950","foxyshop_product_form_914","foxyshop_product_form_758","foxyshop_product_form_749","foxyshop_product_form_738"];
var foxyCartBaseURL = "https://oraclub-staging.foxycart.com/";
var pickColorsProductIds = new Array(231,1035,906,749,1094);
var hoodieProductIds = new Array(989,914,913,874,236);
var extraOrapup = 0;
var totalPurchasePrice = 0;
var divCount = 0;
var threashHoldForFreePup = 33;
$(document).ready(function() {
    // Added counts of facebook and youtube
    $('#menu-item-14 a').text('');
    var likeCount = $('.facebook-like-count').html();
    $('#menu-item-14 a').append(likeCount)

    $('#menu-item-15 a').text('');
    var ytLikeCount = $('.youtube-like-count').html();
    $('#menu-item-15 a').append(ytLikeCount);
    // Added rel attribute in the header links.
    $('.menu-item-15 a').attr('rel', 'prettyPhoto');
    $('.menu-item-14 a').attr('rel', 'prettyPhoto');
	
    // Added Login link on the My Account
    $('.menu-item-265 a').attr('href','#')
    showLoginMenu();
    showMyAccount();
    $('#main, .login').click(function(){
        $('.account-div').hide();
    });
    // Slidedown for Limited offer for Orapup
    $('.limited-offer-orapup').hide().delay(3000).slideDown(1000);
    $('.club-price').parent().parent().addClass('foxyshop_main_price_club');
    removeBottomPrice();
	
	// Create Myorders Table
	createDataTables();
	//Youtube Playlist front pages functionality 
	hideshowplaylist();
	getcounterdata();
	setFoxyFormTarget();
	foxyshopQuantityChangeHandler();
	lickiesPageDisplay();
    showAddOralHealth();
	for(var i=0;i<pickColorsProductIds.length;i++){
    		$('#foxyshop_product_form_'+pickColorsProductIds[i]+' select#2pupstart_2, #foxyshop_product_form_'+pickColorsProductIds[i]+' select#2LkOH_1').parent().append('<img class="package-pick-color" src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/04/orapup_colors.png" />'); 
	}
	for(var i=0;i<hoodieProductIds.length;i++){
    		$('#foxyshop_product_form_'+hoodieProductIds[i]+' select#puphood_2').parent().append('<img class="package-pick-color" src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/04/orapup_colors.png" />'); 
		$('#foxyshop_product_form_'+hoodieProductIds[i]+' select#puphood_4').parent().append('<a class="dog-size-link" href="http://orapup.com/hoodie-sizes.html">(dog sizes)</a>');
	}
	checkoutButtonHandler();
	$("#productsubmit").on("mousedown", function() {
		addOptimizelyForPackage();
	});
	// is there an optimizely or foxyshop checkoutVariation? if undefined, set default
	var checkoutVariation = $('.variation-checkoutvariation').val();
	$('.variation-checkoutvariation').remove();
	if (typeof(checkoutVariation) !== "undefined") {
  		window.checkoutVariation = checkoutVariation;
		if(typeof(window.showAmazon)!=='undefined'){
  		  	$('<div id="productsubmit-amazon" style="clear:both;padding-top:15px;padding-bottom:25px;cursor: hand;cursor: pointer;"><center><img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" style="cursor: hand;cursor: pointer;"/></center></div>').insertAfter('.single-foxyshop_product div.foxyshop_product_info');
		}
		if(typeof(window.showPaypal)!=='undefined'){
			$('<div id="productsubmit-paypal"><center><img src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/04/paypalCheckout.gif"/></center></div>').insertAfter('.single-foxyshop_product div.foxyshop_product_info');
		}
	}else if (typeof(window.checkoutVariation) == "undefined") {
  		window.checkoutVariation = "standard";
	}
	// add the variation as a form variable so it reads as a custom_field in foxycart
	$('form.foxyshop_product').prepend('<input type="hidden" name="h:checkoutVariation" value="'+window.checkoutVariation+'"/>');

    // Amazon everywhere
    if(typeof(window.oldAmazon)!=='undefined'){
        $('<p class="text-refill-link"><a href="http://www.orapup.com/country.php?package=orapupstart&src=fxy&or=20" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(0) > .ordernow-pkg-btn');
        $('<p class="text-refill-link"><a href="http://www.orapup.com/country.php?package=orapupcolors&src=fxy&or=20" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(1) > .ordernow-pkg-btn');
        $('<p class="text-refill-link"><a href="http://www.orapup.com/country.php?package=orapuphoodie&src=fxy&or=20" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(2) > .ordernow-pkg-btn');
    }else{
        $('<p class="text-refill-link"><a href="'+$('.ordernow-tbl > tbody > tr:eq(2) > td:eq(0) > a:eq(0)').attr('href')+'#amazon" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(0) > .ordernow-pkg-btn');
        $('<p class="text-refill-link"><a href="'+$('.ordernow-tbl > tbody > tr:eq(2) > td:eq(1) > a:eq(0)').attr('href')+'#amazon" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(1) > .ordernow-pkg-btn');
        $('<p class="text-refill-link"><a href="'+$('.ordernow-tbl > tbody > tr:eq(2) > td:eq(2) > a:eq(0)').attr('href')+'#amazon" class="amazon-link">OR &nbsp;<img src="http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif" class="amazon-link"></a></p>').insertAfter('.ordernow-tbl > tbody > tr:eq(2) > td:eq(2) > .ordernow-pkg-btn');
    }
    createHiddenFieldsOnFoxyForm();
    addFirstOption();
    continueToSetPackageCookie();
	$('.lickies-version select.foxyshop_quantity option[value="none"]').remove();
	$('.lickies-version select.foxyshop_quantity, .lickies-refill-div #'+freeOrabrushId +' select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Quantity</option>");
	beautifyDropdown();
    removeErrorMsg();
    showAdditionalColor();
    totalPrice();
	changeNumbering();
    showColorOptionImage();
    handleLickiesCookieClearance();
    drawFromCookie();
    drawFromPackageCookies();
    changeColorOptionHandler();
    showLickiesTable();
    paypalSubmit();
    amazonSubmit();    
    showDropDownOnbannerClick();
    addHiddenFieldForLickiesV();
    onPageBackfromCheckout();
});
var packageCookieKey = 'PACKAGE_COOKIE_KEY';
function paypalSubmit(){
	$('#productsubmit-paypal').click(function(){
		$('form.foxyshop_product').prepend('<input type="hidden" name="h:oraclub_payment_method" value="paypal"/>');
		$('[name="cart"]').val('checkout_paypal_express');
		$('#productsubmit').click();
	});
}
function amazonSubmit(){
	$('#productsubmit-amazon').click(function(){
		navigate_to_amazon();
	});	
}
function drawFromPackageCookies(){
    cookieValForPackage = $.cookie(packageCookieKey);
    if(cookieValForPackage){
        $('#customer_email').val(cookieValForPackage.email);
        var cookieCountry = cookieValForPackage.country;
        $('.color-option select.variation-country option').each(function(){
        	var optionVal = $(this).text();
        	if((optionVal == cookieCountry) || (isUnitedStates(optionVal) && isUnitedStates(cookieCountry))){
        		$(this).parent().val($(this).val());
				$(this).prop("selected", true);
        	}
        });
        $('.color-option select.variation-orapup-1 option').each(function(){
            if($(this).text() == cookieValForPackage.color1){
                $(this).parent().val($(this).val());
                $(this).prop("selected", true);
            }
        });
        
        $('.color-option select.variation-orapup-2 option').each(function(){
            if($(this).text() == cookieValForPackage.color2){
                $(this).parent().val($(this).val());
                $(this).prop("selected", true);
            }
        });        
        
        $('.color-option select.variation-hoodie-color option').each(function(){
            if($(this).text() == cookieValForPackage.hoodyColor){
                $(this).parent().val($(this).val());
                $(this).prop("selected", true);
            }
        });        
        
        $('.color-option select.variation-hoodie-size option').each(function(){
        	if($(this).text() == cookieValForPackage.dogSize){
        		$(this).parent().val($(this).val());
				$(this).prop("selected", true);
        	}
        });
        $('.variation-flavor').prop('checked', cookieValForPackage.isChecked);
        $('.color-option select').trigger('change');
    }
}
function continueToSetPackageCookie(){
    $('.foxyshop_product #productsubmit').click(function(){
        var packageFormId = $(this).closest("form").attr("id");
        if($.inArray( packageFormId, packageFormIds) > -1){
            setPackageCookies();
        }
    });
}
function setPackageCookies(){
    cookieValForPackage = $.cookie(packageCookieKey);
    var hoodieColor = "";
    var hoodieSize = "";
    var color1 = "";
    var color2 = "";
    if(cookieValForPackage){
        hoodieColor = cookieValForPackage.hoodyColor;
        hoodieSize = cookieValForPackage.dogSize;
        color1 = cookieValForPackage.color1;
        color2 = cookieValForPackage.color2;
        $.removeCookie(packageCookieKey);
    }
    packageJSONObject = {"email":$('#customer_email').val(), "country": $('.color-option select.variation-country option:selected').text(), "color1": $('.color-option select.variation-orapup-1 option:selected').text()?$('.color-option select.variation-orapup-1 option:selected').text():color1, "color2":$('.color-option #2pupstart_3 option:selected').text()?$('.color-option #2pupstart_3 option:selected').text():color2, "hoodyColor":$('.color-option select.variation-hoodie-color option:selected').text()?$('.color-option select.variation-hoodie-color option:selected').text():hoodieColor, "dogSize":$('.color-option select.variation-hoodie-size option:selected').text()? $('.color-option select.variation-hoodie-size option:selected').text():hoodieSize, "isChecked":$('.variation-flavor').is(':checked')};
    $.cookie(packageCookieKey, packageJSONObject, {expires: 7, path:'/'});
}


function htmlEncode(value) {
   if (value) {
       return $('<div/>').text(value).html();
   }
}

function createHiddenFieldsOnFoxyForm(){
    var image_src = $('img.package_product_image').attr('src');
    if(image_src){
        $('form.foxyshop_product').prepend('<input type="hidden" name="h:imagePath" value="'+image_src+'"/>');
    }
    $('.color-option #2pupstart_2').change(function(){
        $('.select-color1').remove();
        var color1 = $(".color-option #2pupstart_2 option:selected").text();
        $('form.foxyshop_product').prepend('<input type="hidden" class = "select-color1" name="h:selectColor1" value="'+color1+'"/>');
    });
    $('.color-option #2pupstart_3').change(function(){
        $('.select-color2').remove();
        var color2 = $(".color-option #2pupstart_3 option:selected").text();
        $('form.foxyshop_product').prepend('<input type="hidden" class = "select-color2" name="h:selectColor2" value="'+color2+'"/>');
    });
    $('.variation-country').change(function(){		
        $('.select-country').remove();
        var text1 = $(".color-option .variation-country option:selected").text();
        $('form.foxyshop_product').prepend('<input type="hidden" class = "select-country" name="h:selectCountry" value="'+text1+'"/>');
    });
}
function lickiesPageDisplay(){
    var styleCheckoutButton = false;
    var freequantity = $('.variation-freehiddencolorsquantity').val();
    $('.variation-freehiddencolorsquantity').remove();
	
    var freeSelect = false;
    var basePriceArray = []; 
    $('.foxyshop_product').each(function(){
        // get the product_id
        var formId = $(this).attr('id');
        var basePriceStr = $("#" + formId + " .foxyshop_currentprice label:first").text();
        var basePrice = parseFloat(basePriceStr.replace('$',''));
        basePriceArray.push(basePrice);
    });
	

    $('.foxyshop_product').each(function(counter){
        var product_id = $(this).attr('rel');
        var formId = $(this).attr('id');
        freeSelect = false;
        if(formId == freeProductFormId){
            freeSelect = true;
        }
        // if(!freeSelect){
        var quantity = $('#'+ formId + ' .variation-hiddencolorsquantity').val();
        $('#'+ formId + ' .variation-hiddencolorsquantity').remove();
        var consideredkeys2dkeys = {};
        var freekeys2dkeys = {};
        if(typeof freequantity!='undefined'){
            var freeQuantityArray = freequantity.split(';');
            for(var i=0;i<freeQuantityArray.length;i++){
                var keyVal = freeQuantityArray[i].split(':');
                freekeys2dkeys[keyVal[0]]=keyVal[1];
            }	
        }
        var keys2dkeys = {};
        if(typeof quantity!='undefined'){
            var quantityArray = quantity.split(';');
            for(var i=0;i<quantityArray.length;i++){
                var keyVal = quantityArray[i].split(':');
                keys2dkeys[keyVal[0]]=keyVal[1];
            }		    
        }
        var currentDisplayKey = '';
        var savingsString = '';
        var newPrice = 0;
        var basePrice = basePriceArray[counter];
        var fs_discount_string = $('#fs_discount_quantity_amount_'+product_id).val();
        var number2discounts = {};
        if(typeof fs_discount_string != 'undefined'){
            fs_discount_string = fs_discount_string.split('{')[1];
            fs_discount_string = fs_discount_string.replace('}','');
            var discountArray = fs_discount_string.split('|');
            for(var i=0;i<discountArray.length;i++){
                if(discountArray[i]=='allunits'){
                }else{
                    number2discounts[discountArray[i].split('-')[0]]=discountArray[i].split('-')[1];
                }
            }
        }
        if(formId == freeProductFormId){
            consideredkeys2dkeys = freekeys2dkeys;
        }else{
            consideredkeys2dkeys = keys2dkeys;
        }
        currentDisplayKey = '';				
		
        $('#'+ formId + ' select.foxyshop_quantity option').each(function()
        {
            var theValArray = $(this).val().split('|');
            var theVal = theValArray[0];
            var perBottleSuffix = ' per bottle';
            savingsString = '';
            if(number2discounts[theVal]){
                newPrice = (parseFloat(basePrice) - parseFloat(number2discounts[theVal])).toFixed(2);
                newPrice = newPrice.replace('.00','');
                savingsString = '$'+newPrice+perBottleSuffix;
            }else{
                newPrice = parseFloat(basePrice).toFixed(2);
                newPrice = newPrice.replace('.00','');
                savingsString = '$'+newPrice+perBottleSuffix;
            }
            
            if(consideredkeys2dkeys[theVal]){
                currentDisplayKey = consideredkeys2dkeys[theVal];
                $(this).attr('displaykey',currentDisplayKey);
                if(!freeSelect){
                    $(this).html(theValArray[0]+' <span>('+savingsString+' + '+currentDisplayKey.split(',').length+' FREE Orapup'+(currentDisplayKey.split(',').length>1?'s':'')+')</span>');
                }else{
                    $(this).html(theValArray[0]);
                }					
                $(this).attr('rel',newPrice*100);
                $(this).attr('relBase',basePrice.toFixed(2)*100);
            }else if(currentDisplayKey!=''){
                if(theValArray[0]>3){
                    $(this).remove();
                }
            }else{
                if(savingsString!=''){
                    $(this).html(theValArray[0]+' <span>('+savingsString+')</span>');
                }
                $(this).attr('rel',newPrice*100);
                $(this).attr('relBase',basePrice.toFixed(2)*100);
            }				
        });
        if($('.select-lickies-table').length==0){
            $('#'+ formId + ' select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Qty</option>");
        }
        if(quantity){
        	if(formId != additionalProductFormId){
        		foxyshop_after_quantity_modifier(1200,750,'Regular Bottle Price','As Low As',product_id);
        	}
        	else{
        		return false;
        	}
            $('#'+ formId + ' select.foxyshop_quantity').change(function () {
                $('#'+ formId + ' select option:selected').each(function () {
                    if($(this).is(':selected') && $(this).attr('relBase')>0){
                        foxyshop_after_quantity_modifier($(this).attr('relBase'),$(this).attr('rel'),'Regular Bottle Price','Per Bottle Qty Price',product_id);
                    }else{
                        foxyshop_after_quantity_modifier(1200,750,'Regular Bottle Price','As Low As',product_id);
                    }
                });
            });
        }
        // adjust the display of the upgrade
        if($('.single-foxyshop_product label.variation-flavor').html()){
            $('.single-foxyshop_product label.variation-flavor').html($('.single-foxyshop_product label.variation-flavor').html().replace('(+$8.00)','').replace('$8','<strike>$12</strike> $8'));
            $('.single-foxyshop_product label.variation-flavor').html($('.single-foxyshop_product label.variation-flavor').html().replace('(+$7.00)','').replace('$7','<strike>$12</strike> $7'));
        }
        // correct for packages css when not a package
        $('#productsubmit').attr('style','height:32px !important;width:157px !important;float:right !important;');
			
    });
    // packages checkout flow
    $('.single-foxyshop_product #productsubmit label').click(function(){
        $('#productsubmit').click();
    });
    $('.single-foxyshop_product #productsubmit').attr('style','background:none !important');
    $('.postid-595 #productsubmit,.postid-4 #productsubmit').attr('style','background:url("http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/03/add_to_cart1.png") no-repeat scroll right 0 transparent !important');

    $('.single-foxyshop_product #productsubmit label').hide();
    $('#productsubmit').hide();
    $('.single-foxyshop_product .foxyshop_quantity').hide();
    $('<h2 class="title bold" style="font-size:22px; height: 45px;">Your Package</h2><img class="package_product_image" src="'+$('#foxyshop_main_product_image').parent().attr('href')+'"/><h2 class="title bold" style="padding-top:30px;font-size:28px;">Your Info</h2>').insertBefore('.single-foxyshop_product div.foxyshop_product_info');
    $('<div class="color-option"><label class="customer_email" for="customer_email">Email Address:</label><input name="customer_email" id="customer_email" style="width:360px; border-radius: 6px; "/><br/><small style="margin-left:160px;font-size:10px;float: left;">We respect your privacy and HATE spam. We will not sell or rent your personal info.</small><br/><br/>').insertBefore('.single-foxyshop_product div.color-option:first');

    // successful optimizely test implementation 5/15/2013 Paypal versus Amazon
    if(location.href.indexOf('#amazon')==-1){
        var checkoutB = '//cdn.optimizely.com/img/23860275/75aff344d1914920b8d7d4b29a91f570.png';
        var checkoutBhover = '//cdn.optimizely.com/img/23860275/38402cedce674f8eb2dfc361045a70e8.png';
    }else{
        var checkoutB = 'http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/05/continuetoorderonamazonpayments_btn.png';
        var checkoutBhover = 'http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/05/continuetoorderonamazonpayments_btn_hvr.png';
    }
		
    $(".product-options").prepend("<img id=\"optimizely_207298648\" src=\""+checkoutB+"\" />");
    $("#optimizely_207298648").css({
        "position":"relative", 
        "left":-144, 
        "top":0
    });
    $("#optimizely_207298648").css({
        "left":-144, 
        "top":-2
    });

    $(".product-options").prepend("<img id=\"optimizely_218566253\" src=\"//cdn.optimizely.com/img/23860275/cac9321249b04988b85e0c9060ae12f8.png\" />");
    $("#optimizely_218566253").css({
        "position":"relative", 
        "left":-55, 
        "top":40
    });
    $("#optimizely_207298648").css({
        "left":-230, 
        "top":1
    });
    $("#optimizely_218566253").css({
        "left":-319, 
        "top":52
    });
    if(location.href.indexOf('#amazon')==-1){
        $("#optimizely_207298648").css({
            "left":-146, 
            "top":-39
        });
        $(".product-options").prepend("<img id=\"optimizely_99594907\" src=\"http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif\" />");
        $(".lickies-version .foxyshop_product_info").prepend("<img id=\"optimizely_99594907\" src=\"http://s3.amazonaws.com/media.orabrush.com/imgs/amazon_buynow.gif\" />");
        $("#optimizely_99594907").css({
            "position":"relative", 
            "left":-197, 
            "top":158
        });
        $("#optimizely_99594907").css({
            "left":-183, 
            "top":103
        });
        $('#optimizely_99594907').click(function(){
            navigate_to_amazon();
        });
        $('#optimizely_207298648').click(function(){
            $('#productsubmit').click();
        });
		
    }else{
        $("#optimizely_218566253").css({
            "left":-255, 
            "top":75
        });
        $("#optimizely_207298648").css({
            "left":-50, 
            "top":-30
        });
        $('#optimizely_207298648').attr('href','#amazon');
        $('#optimizely_207298648').click(function(){
            navigate_to_amazon();
        });
    }
    $('#optimizely_99594907').mouseover(function(){
        $(this).css('cursor','hand').css('cursor','pointer');
    }).mouseout(function(){
        $(this).css('cursor','default').css('cursor','default');
    });
    $('#optimizely_207298648').mouseover(function(){
        $(this).attr('src',checkoutBhover);
    }).mouseout(function(){
        $(this).attr('src',checkoutB);
    });
    $(".products-content").css({
        "position":"relative", 
        "left":0, 
        "top":0
    });
    $(".products-content").css({
        "width":680, 
        "min-height":710
    });
    $('#optimizely_207298648').mouseover(function(){
        $(this).css('cursor','hand').css('cursor','pointer');
    }).mouseout(function(){
        $(this).css('cursor','default').css('cursor','default');
    });
    $(".products-content").append('<img id="toll-free" src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/05/problemsorquestions.png"/>');
    $("#toll-free").css({
        "position":"relative", 
        "left":0, 
        "top":65
    });

    $('.clr').eq(-5).css('clear','both');
    (new Image()).src = '//cdn.optimizely.com/img/23860275/38402cedce674f8eb2dfc361045a70e8.png';
}
function showColorOptionImage(){
    $('.lickies-refill-div div.color-option select').change(function(){
        var valStr = $(this).val();
        var colorVal = '';
    	if(valStr.indexOf("{")>-1){
    		colorVal = valStr.substring(0, valStr.indexOf('{'));
    		colorVal = colorVal.toLowerCase() + 'brush.png';
    	}
        iKeyStrStart = "ikey:";
        iKeyVal = valStr.substring(valStr.indexOf(iKeyStrStart)+5, valStr.indexOf("|"));
        new_ikey = "-1";
        for (i=0; i<ikey.length; i++) {
            if (ikey[i][0] == iKeyVal) new_ikey = i;
        }
        
        var parentElemId = $(this).parent().parent().attr("id");
        $('#' + parentElemId + ' .foxyshop_product_image_new').remove();
        if(new_ikey==-1 && colorVal != ''){
	    	for (i=0; i<ikey.length; i++) {
	            if (ikey[i][2].indexOf(colorVal)>-1) new_ikey = i;
	        }	
        }
        if(new_ikey>-1){
            var colorImageSrc = ikey[new_ikey][2];
            var colorImageAlt = ikey[new_ikey][4];
            // var colorImage = $('.common-color-option .foxyshop_product_image
			// a').html();
            $('#' + parentElemId).append('<div class="foxyshop_product_image_new"><img src='+colorImageSrc+' alt='+ colorImageAlt +' /></div>');
        }
    });
}
function beautifyDropdown(){
    $(".lickies-refill-div .color-option").each(function(j){
        $(this).attr("id", "color-option-" + j);
        divCount +=1;
        $(this).prepend('<span class="bottles-numbering">'+divCount+'.</span>')
        if((j%3) == 0){
            $(this).addClass("co-new-row");
        }
    });
	
    try {
        $(".lickies-refill-div select.foxyshop_quantity, .lickies-refill-div .color-option select").msDropdown();
        handleFreeColorOptionBeautification();
    } catch(e) {
        console.log(e);	
    }
}

function handleFreeColorOptionBeautification(){
	$('.lickies-refill-div .color-option').hide();
	var additionalValue = $('.additional-product select.foxyshop_quantity option:selected').text();
	$('div.additional-variation div.color-option').each(function(j){
		if(j<additionalValue){
			$(this).show();
			colorOpId = $(this).attr('id');
			$('#'+colorOpId +' .ddcommon').show();
		}
	})
    for(i=0; i< freeEligible; i++){
        $('#color-option-'+i).show();
    }
    $('.lickies-refill-div .color-option').each(function(){
        coId = $(this).attr('id');
        if($(this).is(':visible')){
            $('#'+coId+ ' div.ddcommon').show();
        }else{
            $('#'+coId+ ' div.ddcommon').hide();
            $('#'+coId+ ' select').prop("selected", true);
            $('#'+coId+ ' select').trigger('change');
        }
    });	
}
function addOptimizelyForPackage(){
    window.optimizely = window.optimizely || [];
    $("#productsubmit").click(function() {
        var isValidSubmission = true;
        $('.foxyshop_required').each(function(){        			
            if ($(this).is('select') && $(this).is(':visible') && $('option:selected', this).index() == 0) {
                isValidSubmission = false;
            }        			
        });
        if(isValidSubmission){
            window.optimizely.push(['trackEvent', 'navigated_to_checkout']);
            _gaq.push(['_trackEvent', 'Forms', 'Submitted', "Checkout"]);
        }
    });
}
var ongoingSubmission = 0;
var formSubmissionUnderway = false;
var selectedValArray = new Array();
var selectedValSanitizedArray = new Array();
var addSelectedValue = 0;
var lotSize = 4;
var freeEligible = 0;

function showFreeOptions(){
    selectedValSanitizedArray = new Array();
    addSelectedValue = 0;
    freeEligible = 0;
    if((selectedValArray.length) == 0){
        $('#bottle_replacer').text("4 MORE BOTTLES");
        
    }
    for(i=0; i< selectedValArray.length; i++){
        selectedVal = selectedValArray[i];
        selectedValArrayEntry = selectedVal.split("||");
        selectedValSanitizedArray.push(selectedValArrayEntry[0]);
    }
    for(i=0; i< selectedValSanitizedArray.length;i++){
        addSelectedValue = parseInt(addSelectedValue)+parseInt(selectedValSanitizedArray[i]);
    }
    var remainder = (addSelectedValue%lotSize);
    if(addSelectedValue>0){
        $('.checkout-error-div').html('');
        remainingBottles = (lotSize-remainder);
        if(remainingBottles == 0){
            $('#bottle_replacer').text("4 MORE BOTTLES");
        }else{
            if(remainingBottles == 1){
                $('#bottle_replacer').text(remainingBottles + " MORE BOTTLE");	
            }else{
                $('#bottle_replacer').text(remainingBottles + " MORE BOTTLES");
            }
        }
        
        freeEligible = (addSelectedValue-remainder)/lotSize;
        if(freeEligible>=1){
            $('#another_bottle').text('another');
        }else{
            $('#another_bottle').text('a');
        }
    }
    if(freeEligible>0){
        for(i=0;i<freeOra.length; i++){
            freeOraVal = freeOra[i];
            freeOraValArrayEntry = freeOraVal.split("||");
            if(freeOraValArrayEntry[0] == freeEligible){
                $('#'+ freeProductFormId+ ' select.foxyshop_quantity option').each(function(k){
                    if(i==(k-1)){
                        $(this).prop("selected", true);
                        $(this).parent().trigger('change');
                        handleFreeColorOptionBeautification();
                    }
                });
            }
        }
		
    }else{
        $('#' + freeProductFormId +' select.foxyshop_quantity option').each(function(k){
            if(k==0){
                $(this).prop("selected", true);
                $(this).parent().trigger('change');
                handleFreeColorOptionBeautification();
            }
        });
    }
    toggleAddRemoveQuantityOption();
    resetCookie();
}
function isUnitedStates(countryStr){
    var isUS = false;
	
    if(countryStr.indexOf("United States")>-1){
        isUS = true;
    }
    return isUS;
}
function removeErrorMsg(){
    $('.common-color-option .color-option label').click(function(){
        $('.checkout-error-div').html('');
    });
}
function toggleAddRemoveQuantityOption(){
    $('.select-lickies-table select.foxyshop_quantity, .lickies-flavor-block select.foxyshop_quantity').each(function(){
        var selectedVal = $(this).val();
        var selectId = $(this).attr('id');
        var formId = $(this).closest("form").attr("id");
        var firstOptionText = $('select[id='+selectId+ '] > option:first-child').text();
        var newFirstOptionText = "";
        if(selectedVal !="" && selectedVal != 'none'){
            newFirstOptionText = firstOptionText.replace("Add", "Remove");
        }else{
            newFirstOptionText = firstOptionText.replace("Remove", "Add");
        }        	
        $('select[id='+selectId+ '] > option:first-child').text(newFirstOptionText);
        $("#"+formId +" span.ddlabel:contains('" + firstOptionText +"')").text(newFirstOptionText);
        var oHandler = $(".lickies-refill-div select.foxyshop_quantity").msDropDown().data("dd");
        oHandler.close();
    });
}

function foxyshopQuantityChangeHandler(){
    $('#'+ freeProductFormId + ' select.foxyshop_quantity').css("display","block");
    $('#'+ freeProductFormId + ' select.foxyshop_quantity').css("visibility","hidden");
    $('.select-lickies-table select.foxyshop_quantity, .lickies-flavor-block select.foxyshop_quantity').change(function(){
        selectedValArray = new Array();
        $('.select-lickies-table select.foxyshop_quantity, .lickies-flavor-block select.foxyshop_quantity').each(function(){
            selectedVal = $(this).val();
            if(selectedVal !="" && selectedVal != 'none'){
                selectedValArray.push(selectedVal);
            }        	
        });
        showFreeOptions(selectedValArray);
    });
}

function changeColorOptionHandler(){
    $('.color-option select').change(function(){
        resetCookie();		
    });
}
var paidCookieKey = "paidCookieKey";
var freeCookieKey = "freeCookieKey";
var colorCookieKey = "colorCookieKey";
var addMoreHtmlKey = "addMoreHtmlKey";
var setPriceCookieKey = "setPriceCookieKey";

function setPaidCookie(){
	// iterate over the select
	// get the selected val for each
	// set the paid cookieKey and set the value for each
	var paidArray = new Array();
	$('.foxyshop_quantity').each(function(){
		var formId = $(this).closest("form").attr("id");
		if(formId != freeProductFormId){
			val = $(this).val();
			id = $(this).attr('id');
			if(id && id.indexOf('msdrpdd')>-1){
				cookieJSONObject = {"id":id, "value": val};
				paidArray.push(cookieJSONObject);
			}
		}else{
			// do nothing
		}
	});
	$.cookie(paidCookieKey, paidArray);
	
}

function drawFromCookie(){
    paidCookie = $.cookie(paidCookieKey);
    freeCookie = $.cookie(freeCookieKey);
    colorCookie = $.cookie(colorCookieKey);
    addMoreCookies = $.cookie(addMoreHtmlKey);
    addPriceCookie = $.cookie(setPriceCookieKey);
    if(paidCookie){
        for(i=0; i<paidCookie.length; i++){
            entry = paidCookie[i];
            entryVal = entry.value;
            if(entryVal){
	            if(entryVal.indexOf("||")>0){
	                $('#'+entry.id).msDropDown().data("dd").set("value", entryVal);
	                $('#'+entry.id).parent().parent().addClass('drop-selected');
	            }
            }
        }			
    }
    if(freeCookie){
        for(i=0; i<freeCookie.length; i++){
            entry = freeCookie[i];
            entryVal = entry.value;
            $('#'+entry.id).msDropDown().data("dd").set("value", entryVal);
        }
    }
    if(colorCookie){
        for(i=0; i<colorCookie.length; i++){
            entry = colorCookie[i];
            entryVal = entry.value;
            var colorOptionId = $('#'+entry.id).closest("div.color-option").attr("id");
            if(entryVal){
            	$('#'+entry.id).msDropDown().data("dd").set("value", entryVal);
        	}
            $('#'+ colorOptionId).show();
            $('#' + colorOptionId + ' label').show();
            $('#' +colorOptionId + ' .ddcommon').show();
            if(entry.img){
                $('#'+ colorOptionId).append("<div class='foxyshop_product_image_new'><img src='" + entry.img +"' alt='Lickies'></div>");	
            }
        }
    }
    if(addMoreCookies){
    	$('.lickies-free-div').empty();
    	$('.lickies-free-div').append(addMoreCookies.html);
    }
    if(addPriceCookie){
    	$('.total-price').html(addPriceCookie.html);
    }
    toggleAddRemoveQuantityOption();	
}
function getQSParams(passedKey) {
    var query = window.location.search.substring(1);
    var parms = query.split('&');
    var returnVal = "";
    for (var i = 0; i < parms.length; i++) {
        var pos = parms[i].indexOf('=');
        if (pos > 0) {
            var key = parms[i].substring(0, pos);
            var val = parms[i].substring(pos + 1);
            if(key == passedKey){
                returnVal = val;
            }
        }
    }
    return returnVal;
}
function handleLickiesCookieClearance(){
    if(getQSParams('clear_selection')=='1'){
        clearLickiesCookies();	
    }
}

function clearLickiesCookies(){
    $.removeCookie(paidCookieKey);
    $.removeCookie(freeCookieKey);
    $.removeCookie(colorCookieKey);
    $.removeCookie(addMoreHtmlKey);
    $.removeCookie(setPriceCookieKey);
}
function setFreeCookie(){
    freeArray = new Array();
    $('#'+freeProductFormId+ ' .hiddenColorPref').remove();
    $('#'+additionalProductFormId+ ' .hiddenColorPref').remove();
    $('select.foxyshop_quantity').each(function(){
        var formId = $(this).closest("form").attr("id");
        if(formId == freeProductFormId){
            val = $(this).val();
            id = $(this).attr('id');
            if(id && id.indexOf('msdrpdd')>-1){
                cookieJSONObject = {"id":id, "value": val};
                freeArray.push(cookieJSONObject);
            }
        }
    });	
    colorArray = new Array();
    var imgSrcVal = "";
    $('.color-option select').each(function(){
        val = $(this).val();
        id = $(this).attr('id');
        colorOptionId = $(this).parent().parent().attr('id');
        if($('#'+colorOptionId).is(':visible')){
            imgSrc = $('#'+ colorOptionId + ' img').attr('src');
            cookieJSONObject = {"id":id, "value": val, "img": imgSrc};
            colorArray.push(cookieJSONObject)
            if(imgSrc){
                imgSrcVal = imgSrcVal + imgSrc + ",";	
            }
        }
    });
    $.cookie(freeCookieKey, freeArray);
    $.cookie(colorCookieKey, colorArray);
    imageData = imgSrcVal ;
    $('#'+freeProductFormId).append("<input type='hidden' name='h:hiddenColorPref' id='hiddenColorPref' class='hiddenColorPref' value='" + imageData + "'/>");
    $('#'+additionalProductFormId).append("<input type='hidden' name='h:hiddenColorPref' id='hiddenColorPref' class='hiddenColorPref' value='" + imageData + "'/>");
}
function setMoreCookie(){
	var addMoreHtml = $('.lickies-free-div').html();
	addMoreHtml = {"html": addMoreHtml};
	$.cookie(addMoreHtmlKey, addMoreHtml);
}
function setPriceCookie(){
	var addPriceHtml = $('.total-price').html();
	addPriceHtml = {"html": addPriceHtml};
	$.cookie(setPriceCookieKey, addPriceHtml);
}

function resetCookie(){
    clearLickiesCookies();
    setPaidCookie();
    setFreeCookie();
    setMoreCookie();
    setPriceCookie();
}
function createCookieJSON(cookieKey, value, img){
	existingCookie = getExistingCookie(cookieKey);
	var cookieJSONObject = {"key":cookieKey, "value": value, "img": img};
	return cookieJSONObject;
}
function clearCart(){
}
function checkoutButtonHandler(){
    checkoutErrorMsg = "";
    $('.common-checkoutbutton').click(function(){
        resetCookie();		
        selectedValArray = new Array();
        if(!formSubmissionUnderway){
            selectedItem = 0;
            $('select.foxyshop_quantity').each(function(){
                selectedVal = $(this).val();
                if(selectedVal !="" && selectedVal != 'none'){
                    selectedValArray.push(selectedVal);
                    selectedItem++;
                }
            });
            var canCheckout = true;
            if(selectedItem == 0){
                checkoutErrorMsg  = "Please add a product to checkout";
                var canCheckout = false;
            };
            var totalPrice = $('.total-price').text();
            $('#'+ freeOrabrushId +' select.foxyshop_quantity option[value=none]').prop("selected", true);
            if(getNumberFromString(totalPrice) > threashHoldForFreePup){
            	$('#'+ freeOrabrushId +' select.foxyshop_quantity option').each(function(i){
            		if(i==1){
            			$(this).prop("selected", true);
            		}
            	});
            	
            	
            };
            areColorsSelected = true;
            $('select.foxyshop_quantity').each(function(){
                var selectedVal = $(this).val();
                if(selectedVal !="" && selectedVal != 'none'){
                    var formId = $(this).closest("form").attr("id");
                    $('#'+formId + ' .foxyshop_required').each(function(){        			
                        if ($(this).is('select') && $(this).is(':visible') && $('option:selected', this).index() == 0) {
                            if(canCheckout){
                                checkoutErrorMsg  = "Please select a color for your Orapup(s)";								
                            };
                            areColorsSelected = false;
                        }        			
                    });
                }
            }); 
	
			if(canCheckout && areColorsSelected){
				showLoadImage();				
				var emptyCartUrlVal = foxyCartBaseURL + 'cart?empty=true&output=json&callback=?';
				jQuery.getJSON(emptyCartUrlVal, function(data){
					$('select.foxyshop_quantity').each(function(){
						formSubmissionUnderway = true;
						var selectedVal = $(this).val();
						if(selectedVal !="" && selectedVal != 'none'){
							var formId = $(this).closest("form").attr("id");
							ongoingSubmission++;
							$('#'+formId).submit();
						}
					});
				 });
			}
			$('.checkout-error-div').html(checkoutErrorMsg);
		}	
	});
}
var fccSessionStr = "";
function redirectToCheckout(){
	document.location.href = checkoutURL+"?ThisAction=customer_info"+fccSessionStr;
}
function setFoxyFormTarget(){
	var fccSession = fcc.session_get();
	fccSession = "";
	if(!fccSession || fccSession == ""){
		var emptyCartUrlVal = foxyCartBaseURL + 'cart?empty=true&output=json&callback=?';
		jQuery.getJSON(emptyCartUrlVal, function(data){
			fccSession = "&fcsid=" + data.session_id;
			fccSessionStr = fccSession;
			setLickiesFormTargets(fccSession);
		});
	}else{
		fccSessionStr = fccSession;
		setLickiesFormTargets(fccSession);
	}
}

function setLickiesFormTargets(fccSession){
    var options = { 
        success: showResponse  // post-submit callback
    };
    $('.lickies-refill-div .foxyshop_product').each(function(i){
        $(this).attr("action", "/lickies-form?id=1&randNum=" + new Date().getTime()+fccSession);
        $(this).ajaxForm(options);
    });
    getFreeOrapupProdValueArray();
}

var freeOra = new Array();
function getFreeOrapupProdValueArray(){
    $('#' + freeProductFormId + ' select.foxyshop_quantity option').each(function(){
        optionVal = $(this).val();
        optionValArray = optionVal.split("||");
        freeOra.push(optionValArray[0]);
    });
}
function showLoadImage(){
    $('#page-load-image').dialog({
        modal: true
    });
}
function removeLoadImage(){
    $('#page-load-image').dialog('close');
}
function showResponse(responseText, statusText, xhr, $form)  {
    ongoingSubmission--;
    if(ongoingSubmission==0){
        removeLoadImage();
        formSubmissionUnderway=0;		
        redirectToCheckout();
    }
} 

function addFirstOption(){
    if($('.page-id-1297 .lickies-refill-div select.foxyshop_quantity').length>1){
        $('#foxyshop_product_form_1290 select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Qty</option>");
        $('.four-bottles-select select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Add Oral Health</option>");
        $(".lickies-refill-div select.foxyshop_quantity")[0].options[0].selected = true;
        $('.skin-koat-bottles-select select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Add Skin & Coat</option>");
        $(".skin-koat-bottles-select select.foxyshop_quantity")[0].options[0].selected = true;
        $('.joint-bottles-select select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Add Joint Health</option>");
        $(".joint-bottles-select select.foxyshop_quantity")[0].options[0].selected = true;
    }
}
function showAddOralHealth(){
    $('.select-lickies-table select.foxyshop_quantity, .lickies-flavor-block select.foxyshop_quantity').change(function(e) {
        var selectValue = $(this).val();
        if(selectValue == '' || selectValue == 'none')
        {
            $(this).removeClass('drop-selected');
            $(this).parent().parent().removeClass('drop-selected');
        }
        else{
            $(this).parent().parent().addClass('drop-selected');
        }
    });
}
function showMyAccount(){
    $('.menu-item-265 a').click(function(){
        $('.account-div').toggle();
    });
}
function showLoginMenu(){
    var loginDetails = $('.profile-detail-links').html();
    $('.menu-item-265').append(loginDetails);
}
function createDataTables(){
    $('.page-template-page-view-orders-php table').dataTable({
        "aaSortingFixed": [[0,'desc']]
    });
}
function removeBottomPrice(){
    var quantityValue = $('.foxyshop_variations').html();
    var productValue = $('.product-options').html();
    var colorOption = $('.color-option').html();
    if(colorOption != null){
        $('.product-options #foxyshop_main_price').show();
    }
    else
    {
        $('.foxyshop_product_info').addClass('without-color-option');
        $('.top-price').append('<div class="top-quantity-cart"><span>'+ quantityValue +'</span>'+ productValue+'</div>');
    }
}
function foxyshop_after_variation_modifiers(new_code, new_codeadd, new_price, new_price_original, new_ikey, current_product_id) {
    var parentFormStr ="foxyshop_product_form_" + current_product_id;
    if(parentFormStr == freeProductFormId){
        return;
    }
	
    var parentForm = "#" + parentFormStr;
    var quantity_pricing_found = false;
    $(parentForm + ' select.foxyshop_quantity option').each(function()
    {
        if(typeof $(this).attr('rel') != 'undefined'){
            quantity_pricing_found = true;
        }
    });
	
    if(quantity_pricing_found!=true){
        l18n_settings = $("#foxyshop_l18n_" + current_product_id).val();
        arrl18n_settings = l18n_settings.split("|");
        currencySymbol = arrl18n_settings[0];
        decimalSeparator = arrl18n_settings[1];
        thousandsSeparator = arrl18n_settings[2];
        p_precedes = arrl18n_settings[3];
        n_sep_by_space = arrl18n_settings[4];
	
        new_currency = toCurrency(new_price, currencySymbol, thousandsSeparator, decimalSeparator, p_precedes, n_sep_by_space);
        $(parentForm + " #foxyshop_main_price .foxyshop_currentprice label").text(new_currency);
    }
}
function toCurrency(n, c, g, d, first, separator) {
    var s = (0 > n) ? '-' : '';
    if (separator == 1) {
        separator = ' ';
    } else {
        separator = '';
    }
    var m = String(Math.round(Math.abs(n)));
    var i = '', j, f;
    c = c || '';
    g = g || '';
    d = d || '.';
    while(m.length < 3) {
        m = '0' + m;
    }
    f = m.substring((j = m.length - 2));
    while(j > 3) {
        i = g + m.substring(j - 3, j) + i;
        j -= 3;
    }
    i = m.substring(0, j) + i;
    if (first == 1) {
        return s + c + separator + i + d + f;
    } else {
        return s + i + d + f + separator + c;
    }
}
function foxyshop_after_quantity_modifier(oldPrice,newPrice,oldLabel,newLabel,current_product_id){
    var parentForm = "#foxyshop_product_form_" + current_product_id;
    // currency settings
    l18n_settings = $("#foxyshop_l18n_" + current_product_id).val();
    arrl18n_settings = l18n_settings.split("|");
    currencySymbol = arrl18n_settings[0];
    decimalSeparator = arrl18n_settings[1];
    thousandsSeparator = arrl18n_settings[2];
    p_precedes = arrl18n_settings[3];
    n_sep_by_space = arrl18n_settings[4];

    // pricing comparison
    var price = toCurrency(oldPrice, currencySymbol, thousandsSeparator, decimalSeparator, p_precedes, n_sep_by_space);
    var special_price = toCurrency(newPrice, currencySymbol, thousandsSeparator, decimalSeparator, p_precedes, n_sep_by_space);
    if(parseInt(newPrice)<parseInt(oldPrice)){
        var price_html = '<span class="foxyshop_oldprice">'+oldLabel+': <label>'+price+'</label></span>';
        price_html += '<span class="foxyshop_currentprice foxyshop_saleprice">'+newLabel+': <label>'+special_price+'</label></span>';
    }else{
        var price_html = '<span class="foxyshop_currentprice">'+oldLabel+': <label>'+price+'</label></span>';
    }
    // reset pricing display
    $(parentForm+' .foxyshop_price').html(price_html);
}

function hideshowplaylist(){
    $('.ytclink').attr('rel','prettyPhoto');
    $('.ytc-row').hide();
    $('.ytc-r-1').show();
    showMoreVideoes();
}

function showMoreVideoes(){
    $('#Show-video-more').click(function(){
        var c = $('#counter').val();
        c++;
        $('.ytc-r-' + c).show();
        $('#counter').val(c);
    });
}

function getcounterdata(){
    var total_people_value = $("#total_people").val();
    var total_sale_value = $("#total_sale").val();
    $('#total_people_value').html(total_people_value);
    $('#total_sale_value').html(total_sale_value);
}

function navigate_to_amazon(){
    fc_amazon_fps_checkout();
    return false;
    var productId = $('.foxyshop_product').attr('id').split('_')[3];
    var country = 'US';
    if($('[name="Country"]').val().indexOf('United Kingdom')!=-1){
        country = 'UK';
    }
    if($('[name="Country"]').val().indexOf('Canada')!=-1){
        country = 'CA';
    }
    if($('[name="Country"]').val().indexOf('Other')!=-1){
        country = 'default';
    }
    var url = 'email='+$('#customer_email').val()+'&package='+$('#fs_code_'+productId).val()+(typeof $('[name="Orapup_1"]').val()!='undefined'?'&colorOne='+$('[name="Orapup_1"]').val().split('{')[0].split(' ')[1].toLowerCase():'')+'&country='+country+($('[name="Flavor"]').is(':checked')?'&addtocart='+($('[name="Flavor"]').val().indexOf('$8')!=-1?'15flavor':($('[name="Flavor"]').val().indexOf('$1875')!=-1?'250flavor':'25flavor')):'')+(typeof $('[name="Orapup_2"]').val()!='undefined'? '&colorTwo='+$('[name="Orapup_2"]').val().split('{')[0].split(' ')[1].toLowerCase():'')+(typeof $('[name="Hoodie_Color"]').val()!='undefined'? '&hoodieColor='+$('[name="Hoodie_Color"]').val().split('{')[0].toLowerCase():'')+(typeof $('[name="Hoodie_Size"]').val()!='undefined'? '&hoodieSize='+$('[name="Hoodie_Size"]').val().split('{')[0].toLowerCase():'')+(typeof $('[name="I_am_selling_these:"]:checked').val()!='undefined'?'&soldRetail='+(($('[name="I_am_selling_these:"]:checked').val().split('||')[0].indexOf('retail')!=-1)?'1':'0'):'');
    document.location.href='http://www.orapup.com/foxy2amz.php?'+url;
}

function fc_amazon_fps_checkout(){
    var productId = $('.foxyshop_product').attr('id').split('_')[3];
    var categoryId = $('#fs_category_'+productId).val();
    // prep for amazon
    $('form.foxyshop_product').prepend('<input type="hidden" name="fc_payment_method" value="amazon_fps"/>');
    $('form.foxyshop_product').prepend('<input type="hidden" name="h:oraclub_payment_method" value="amazon_fps"/>');
    if(categoryId=='checkout_delivery' || categoryId=='standard' || categoryId=='default'){
        // paid shipping
        $('#fs_category_'+productId).attr('name','category'+$('#amazon_fps_category_hmac').text());
        $('#fs_category_'+productId).val('no_tax_flat_shipping');
    }else{
        // hoodie/pick colors or any free shipping
        $('#fs_category_'+productId).attr('name','category'+$('#amazon_fps_category_hmac').text()); 
        $('#fs_category_'+productId).val('no_tax_free_shipping');
    }
    // do we need a state?
    // $('form.foxyshop_product').prepend('<input type="hidden"
	// name="h:oraclub_payment_method" value="amazon_fps"/>');
    $('#productsubmit').click();
}
// for lickies page
function getNumberFromString(str){
	  var pattern = /[0-9]+/g;
	  return parseFloat(str.match(pattern));
}
function totalPrice(){
	$('.lickies-refill-div select.foxyshop_quantity').change(function(){
		 var netAmount = 0;
	     var amountText = 0;
	     var tempAmount = 0;
	     var additionalTotal = 0;
		$('.lickies-refill-div select.foxyshop_quantity').each(function(){
	      var idPrice = $(this).closest("form").attr("id");
	      	if($('#'+idPrice + 'select.foxyshop_quantity').val()!= null || $('#'+idPrice + 'select.foxyshop_quantity').val()!= "none"){
	      		if(idPrice == additionalProductFormId){
		    	var additionalPriceValue = $('#'+idPrice + ' select.foxyshop_quantity option:selected').text();
		    	if(additionalPriceValue != 'Quantity'){
			      var filteredAddPrice = getNumberFromString($('#'+additionalProductFormId+ ' #foxyshop_main_price label').text());
			      additionalTotal += (additionalPriceValue)*parseInt(filteredAddPrice);
			    }
		      }
	    	  var amountText = $('#'+idPrice + ' select.foxyshop_quantity option:selected').text();
		      if(amountText && amountText.indexOf('$') >= 0){
			      var filteredPrice = amountText.split('$')
			      if(filteredPrice && (filteredPrice[0].toLowerCase() != 'quantity')){
				      filteredPriceUnits = filteredPrice[0];
				      filteredPriceRate = filteredPrice[1];
				      var filteredUnitValue = parseFloat(filteredPriceUnits.split(' ')[0]);				      
				      var filteredUnitPrice = parseFloat(filteredPriceRate.split(' ')[0]); 
				      netAmount += (filteredUnitValue*filteredUnitPrice);
			      }
		      }
	      }
		});
		$('.total-price').html("$"+ (netAmount + additionalTotal).toFixed(2));
	});
}
function changeNumbering(){
	$('.lickies-free-div .bottles-numbering').html(freeEligible+1+'.'); 
	$('.lickies-flavor-block select.foxyshop_quantity').change(function(){
        $('.lickies-free-div .bottles-numbering').html(freeEligible+1+'.');			
	});	
}
function showAdditionalColor(){
	var additionalValue;
	$('.additional-product select.foxyshop_quantity option, .additional-product .ddcommon .ddChild li .ddlabel').each(function(){
		$('.additional-product select.foxyshop_quantity option span').remove();
		additionalValue = $(this).text().replace(/\([^)]*?\)/g, '');
		$(this).html(additionalValue);
	});
	$('.additional-product .foxyshop_variations').addClass('additional-variation');
	$('.additional-product select.foxyshop_quantity').change(function(){
		$('div.additional-product .color-option').hide();
		$('div.additional-product .color-option .ddcommon .ddTitle').hide();
		additionalValue = $('.additional-product select.foxyshop_quantity option:selected').text();
		$('div.additional-variation div.color-option').each(function(j){
			if(j<additionalValue){
				$(this).show();
				colorOpId = $(this).attr('id');
				$('#'+colorOpId +' .ddcommon').show();
				$('#'+colorOpId +' .ddcommon .ddTitle').show();
			}
		})
	});
}
function showLickiesTable(){
	$('.lickies-flavor-block .view-details a, .beef-bacon-img, .cinnamon-img, .cherry-img').click(function(){
		$.fancybox({
			'content' : $("#lickies-table-details").html(),
	    });
	});
}
function scrollUptoDropDown(){
	$("html, body").animate({
		scrollTop:$('.lickies-buy-products').height()}, 'slow');
}
function showDropDownOnbannerClick(){
	$('img.oral-health-img').click(function(){
		$(".lickies-refill-div .foxyshop_variations .ddcommon .ddChild").hide();
		if ($('#foxyshop_product_form_1287 select.foxyshop_quantity').prop("checked", "checked")) {
			$(".lickies-refill-div #foxyshop_product_form_1287 .foxyshop_variations .ddcommon .ddChild").show();
			scrollUptoDropDown();	
		}
	});
	$('img.skin-coat-img').click(function(){
		$(".lickies-refill-div .foxyshop_variations .ddcommon .ddChild").hide();
		if ($('#foxyshop_product_form_1288 select.foxyshop_quantity').prop("checked", "checked")) {
			$(".lickies-refill-div #foxyshop_product_form_1288 .foxyshop_variations .ddcommon .ddChild").show();
			scrollUptoDropDown();
		}
	});
	$('img.joint-health-img').click(function(){
		$(".lickies-refill-div .foxyshop_variations .ddcommon .ddChild").hide();
		if ($('#foxyshop_product_form_1285 select.foxyshop_quantity').prop("checked", "checked")) {
			$(".lickies-refill-div #foxyshop_product_form_1285 .foxyshop_variations .ddcommon .ddChild").show();
			scrollUptoDropDown();
		}
	});
}
function fetchColorFromString(str){
	var colorStr = "";
	if(str){
		bracketIdx = str.indexOf("{");
		if(bracketIdx>-1){
			colorStr = str.substring(0, bracketIdx);
		}
	}
	return colorStr;
}
function addHiddenFieldForLickiesV(){
	if($('.page-id-1944')){
		$('.lickies-version form.foxyshop_product').prepend('<input type="hidden" name="h:lickiesVersion" value="lickiesv"/>');
	}
	if($('.page-id-523')){
		$('.lickies-version form.foxyshop_product').prepend('<input type="hidden" name="h:lickiesVersion" value="lickiesv"/>');
	}
}
function onPageBackfromCheckout(){
	$('.color-option .ddOutOfVision select').each(function(){
		var currentSelectedVal = $(this).val();
		if(currentSelectedVal.indexOf("Pick Color")==-1){
			var id = $(this).attr('id');			
			$('#'+id + ' option').each(function(i){
				if(i == 0){
					$(this).prop("selected", true);
				}
			});
			$(this).trigger('change');			
			$(this).val(currentSelectedVal);
			$(this).trigger('change');
		}

	});
}