var $ = jQuery.noConflict();
var isChecked = false;
$.cookie.json = true;

var freeProductFormId = "foxyshop_product_form_1290";
var checkoutURL = "https://oraclub-staging.foxycart.com/checkout.php";
var packageFormIds = ["foxyshop_product_form_225", "foxyshop_product_form_231", "foxyshop_product_form_236", "foxyshop_product_form_1124","foxyshop_product_form_906","foxyshop_product_form_1035","foxyshop_product_form_914","foxyshop_product_form_989","foxyshop_product_form_1106","foxyshop_product_form_1094","foxyshop_product_form_965","foxyshop_product_form_950","foxyshop_product_form_914","foxyshop_product_form_758","foxyshop_product_form_749","foxyshop_product_form_738"];
var foxyCartBaseURL = "https://oraclub-staging.foxycart.com/";
$(document).ready(function() {
	
	// Load image with scroll 	
	$('img').lazyload({
        effect : "fadeIn"
    });
	
	// Added counts of facebook and youtube
	$('#menu-item-1520 a').text('');
	var likeCount = $('.facebook-like-count').html();
	$('#menu-item-1520 a').append(likeCount)

	$('#menu-item-1521 a').text('');
	var ytLikeCount = $('.youtube-like-count').html();
	$('#menu-item-1521 a').append(ytLikeCount);

	// Added rel attribute in the header links.
	$('.menu-item-1521 a').attr('rel', 'prettyPhoto');
	$('.menu-item-1520 a').attr('rel', 'prettyPhoto');
	
	//Added Login link on the My Account
	$('.menu-item-1524 a').attr('href','#')
	showLoginMenu();
	showMyAccount();
	$('#main').click(function(){
		$('.account-div').hide();
	});
	//Slidedown for Limited offer for Orapup
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

    $('#foxyshop_product_form_231 select#2pupstart_2,#foxyshop_product_form_236 select#puphood_2').parent().append('<img class="package-pick-color" src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/04/orapup_colors.png" />'); 
	$('#foxyshop_product_form_236 select#puphood_4').parent().append('<a class="dog-size-link" href="http://orapup.com/hoodie-sizes.html">(dog sizes)</a>');
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
	createHiddenFieldsOnFoxyForm();
	addFirstOption();
    	continueToSetPackageCookie();
	beautifyDropdown();
	removeErrorMsg();
	showColorOptionImage();
	handleLickiesCookieClearance();
	drawFromCookie();
    drawFromPackageCookies();
	changeColorOptionHandler();
	paypalSubmit();
	amazonSubmit();
	setHiddenFieldForMobile();
});

function is_mobile(){
	  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
	    return true;
	  }
	  return false;
}
function setHiddenFieldForMobile(){
	if(is_mobile()){
		$('input[name="h:checkoutVariation"]').val('mobile-checkout');
	}
}
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
//		if(!freeSelect){
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
				
				$('#'+ formId + ' .foxyshop_quantity option').each(function()
				{
	
						var theValArray = $(this).val().split('|');
						var theVal = theValArray[0];
						if(number2discounts[theVal]){
							newPrice = (parseFloat(basePrice) - parseFloat(number2discounts[theVal])).toFixed(2);
							newPrice = newPrice.replace('.00','');
							savingsString = '$'+newPrice+' per bottle';
						}else{
							newPrice = parseFloat(basePrice).toFixed(2);
							newPrice = newPrice.replace('.00','');
							savingsString = '$'+newPrice+' per bottle';
						}
	
						if(consideredkeys2dkeys[theVal]){
							currentDisplayKey = consideredkeys2dkeys[theVal];
							$(this).attr('displaykey',currentDisplayKey);
							if(!freeSelect){
								$(this).html(theValArray[0]+' ('+savingsString+' + '+currentDisplayKey.split(',').length+' FREE Orapup'+(currentDisplayKey.split(',').length>1?'s':'')+')');
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
								$(this).html(theValArray[0]+' ('+savingsString+')');
							}
							$(this).attr('rel',newPrice*100);
							$(this).attr('relBase',basePrice.toFixed(2)*100);
						}				
				});
				if($('.select-lickies-table').length==0){
					$('#'+ formId + ' select.foxyshop_quantity').prepend("<option value='none' selected='selected' rel='0' relBase='0'>Qty</option>");
				}
				if(quantity){
					foxyshop_after_quantity_modifier(1200,750,'Regular Bottle Price','As Low As',product_id);
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
		$('.single-foxyshop_product #productsubmit label').click(function(){$('#productsubmit').click();});
		$('.single-foxyshop_product #productsubmit').attr('style','background:none !important');
		$('.postid-595 #productsubmit,.postid-4 #productsubmit').attr('style','background:url("http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/03/add_to_cart1.png") no-repeat scroll right 0 transparent !important');
		if(typeof(window.hideOrderButton)=='undefined'){	
			$('.single-foxyshop_product #productsubmit label').text('Continue to Order >>');
		}else{
			$('.single-foxyshop_product #productsubmit label').hide();
			$('#productsubmit').hide();
		}
		$('.single-foxyshop_product .foxyshop_quantity').hide();
		if(typeof(window.hideOrderButton)=='undefined'){
			$('.foxyshop_short_element_holder').attr('style','clear:both, height:20px; width:20px');
			$('<center><img src="http://media.orapup.com/img/amz/CreditCards.jpg"/></center>').insertAfter('.single-foxyshop_product div.product-options');
		}
		$('<h2 class="title bold" style="font-size:22px; height: 45px;">Your Package</h2><img class="package_product_image" src="'+$('#foxyshop_main_product_image').parent().attr('href')+'"/><h2 class="title bold" style="padding-top:30px;font-size:28px;clear:both;">Your Info</h2>').insertBefore('.single-foxyshop_product div.foxyshop_product_info');
  //		$('<div class="color-option"><label class="customer_email" for="customer_email">Email Address:</label><input name="customer_email" id="customer_email" style="width:360px; border-radius: 6px; "/><br/><small style="margin-left:160px;font-size:10px;float: left;">We respect your privacy and HATE spam. We will not sell or rent your personal info.</small><br/><br/>').insertBefore('.single-foxyshop_product div.color-option:first');
		 $('<div class="color-option"><label class="customer_email" for="customer_email" style="display:none;">Email Address:</label><input name="customer_email" id="customer_email" placeholder = "*Email Address" value="" style="border-radius: 6px;"/><br/><small style="margin-left:8px; margin-top: 5px; font-size:10px;float: left;">We respect your privacy and HATE spam. We will not sell or rent your personal info.</small><br/><br/>').insertBefore('.single-foxyshop_product div.color-option:first');
		if(typeof(window.hideOrderButton)=='undefined'){	
			$('#productsubmit').show();		
		}		
}
function showColorOptionImage(){
	$('.lickies-refill-div div.color-option select').change(function(){
		var valStr = $(this).val();
		iKeyStrStart = "ikey:";
		iKeyVal = valStr.substring(valStr.indexOf(iKeyStrStart)+5, valStr.indexOf("|"));
		new_ikey = "-1";
		for (i=0; i<ikey.length; i++) {
			if (ikey[i][0] == iKeyVal) new_ikey = i;
		}
		var parentElemId = $(this).parent().parent().attr("id");
		$('#' + parentElemId + ' .foxyshop_product_image_new').remove();		
		if(new_ikey>-1){
			var colorImageSrc = ikey[new_ikey][2];
			var colorImageAlt = ikey[new_ikey][4];
			//var colorImage = $('.common-color-option .foxyshop_product_image a').html();
			$('#' + parentElemId).append('<div class="foxyshop_product_image_new"><img src='+colorImageSrc+' alt='+ colorImageAlt +' /></div>');
		}
	});
}
function beautifyDropdown(){
	$(".lickies-refill-div .color-option").each(function(j){
		$(this).attr("id", "color-option-" + j);
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
	for(i=0; i< freeEligible; i++){
		$('#color-option-'+i).show();
	}
	$('.lickies-refill-div .color-option').each(function(){
		coId = $(this).attr('id');
		if($(this).is(':visible')){
			$('#'+coId+ ' div.ddcommon').show();
		}else{
			$('#'+coId+ ' div.ddcommon').hide();
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
        if(selectedValArray.length == 0){
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
	var remainder = addSelectedValue%lotSize;
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
				$('#'+ freeProductFormId+ ' .foxyshop_quantity option').each(function(k){
					if(i==(k-1)){
						$(this).prop("selected", true);
						$(this).parent().trigger('change');
						handleFreeColorOptionBeautification();
					}
				});
			}
		}
		
	}else{
		$('#' + freeProductFormId +' .foxyshop_quantity option').each(function(k){
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
		$('.select-lickies-table .foxyshop_quantity').each(function(){
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
	$('.select-lickies-table .foxyshop_quantity').change(function(){
		selectedValArray = new Array();
		$('.select-lickies-table .foxyshop_quantity').each(function(){
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
	if(paidCookie){
		for(i=0; i<paidCookie.length; i++){
			entry = paidCookie[i];
			entryVal = entry.value;
			if(entryVal.indexOf("||")>0){
				$('#'+entry.id).msDropDown().data("dd").set("value", entryVal);
				$('#'+entry.id).parent().parent().addClass('drop-selected');
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
			
			$('#'+entry.id).msDropDown().data("dd").set("value", entryVal);
			$('#'+ colorOptionId).show();
			$('#' + colorOptionId + ' label').show();
			$('#' +colorOptionId + ' .ddcommon').show();
			if(entry.img){
				$('#'+ colorOptionId).append("<div class='foxyshop_product_image_new'><img src='" + entry.img +"' alt='Lickies'></div>");	
			}
		}
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
}
function setFreeCookie(){
	freeArray = new Array();
	$('#'+freeProductFormId+ ' .hiddenColorPref').remove();
	$('.foxyshop_quantity').each(function(){
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
}

function resetCookie(){
	clearLickiesCookies();
	setPaidCookie();
	setFreeCookie();
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
			$('.foxyshop_quantity').each(function(){
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
			areColorsSelected = true;
			$('.foxyshop_quantity').each(function(){
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
					$('.foxyshop_quantity').each(function(){
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

function redirectToCheckout(){
	document.location.href = checkoutURL;
}
function setFoxyFormTarget(){
	var fccSession = fcc.session_get();
	fccSession = "";
	if(!fccSession || fccSession == ""){
		var emptyCartUrlVal = foxyCartBaseURL + 'cart?empty=true&output=json&callback=?';
		jQuery.getJSON(emptyCartUrlVal, function(data){
			fccSession = "&fcsid=" + data.session_id;
			setLickiesFormTargets(fccSession);
		});
	}else{
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
	$('#' + freeProductFormId + ' .foxyshop_quantity option').each(function(){
		optionVal = $(this).val();
		optionValArray = optionVal.split("||");
		freeOra.push(optionValArray[0]);
	});
}
function showLoadImage(){
	$('.page-load-image').dialog({
	     modal: true,
	});
}
function removeLoadImage(){
      $('.page-load-image').dialog('close');
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
	if($('.lickies-refill-div select.foxyshop_quantity').length>1){
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
	$('.select-lickies-table .foxyshop_quantity').change(function(e) {
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
	$('.menu-item-1524 a').click(function(){
		$('.account-div').toggle();
	});
}
function showLoginMenu(){
	var loginDetails = $('.profile-detail-links').html();
	$('.menu-item-1524').append(loginDetails);
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
	if (separator == 1) { separator = ' '; } else { separator = ''; }
	var m = String(Math.round(Math.abs(n)));
	var i = '', j, f; c = c || ''; g = g || ''; d = d || '.';
	while(m.length < 3) {m = '0' + m;}
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
	$('.foxyshop_price').html(price_html);
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
	var productId = $('.foxyshop_product').attr('id').split('_')[3];
	var country = 'US';
	if($('[name="Country"]').val().indexOf('United Kingdom')!=-1){ country = 'UK'; }
	if($('[name="Country"]').val().indexOf('Canada')!=-1){ country = 'CA'; }
	if($('[name="Country"]').val().indexOf('Other')!=-1){ country = 'default'; }
	var url = 'email='+$('#customer_email').val()+'&package='+$('#fs_code_'+productId).val()+(typeof $('[name="Orapup_1"]').val()!='undefined'?'&colorOne='+$('[name="Orapup_1"]').val().split('{')[0].split(' ')[1].toLowerCase():'')+'&country='+country+($('[name="Flavor"]').is(':checked')?'&addtocart='+($('[name="Flavor"]').val().indexOf('$8')!=-1?'15flavor':($('[name="Flavor"]').val().indexOf('$1875')!=-1?'250flavor':'25flavor')):'')+(typeof $('[name="Orapup_2"]').val()!='undefined'? '&colorTwo='+$('[name="Orapup_2"]').val().split('{')[0].split(' ')[1].toLowerCase():'')+(typeof $('[name="Hoodie_Color"]').val()!='undefined'? '&hoodieColor='+$('[name="Hoodie_Color"]').val().split('{')[0].toLowerCase():'')+(typeof $('[name="Hoodie_Size"]').val()!='undefined'? '&hoodieSize='+$('[name="Hoodie_Size"]').val().split('{')[0].toLowerCase():'')+(typeof $('[name="I_am_selling_these:"]:checked').val()!='undefined'?'&soldRetail='+(($('[name="I_am_selling_these:"]:checked').val().split('||')[0].indexOf('retail')!=-1)?'1':'0'):'');
	document.location.href='http://www.orapup.com/foxy2amz.php?'+url;
}
