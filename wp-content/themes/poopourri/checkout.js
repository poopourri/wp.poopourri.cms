jQuery(document).ready(function($) {
	$("#change_shipping_country").click(function() {
		$(".fc_shipping_country_change").hide();
		$(".fc_shipping_country_name").show();
		return false;
	});
	$("#change_customer_country").click(function() {
		$(".fc_customer_country_change").hide();
		$(".fc_customer_country_name").show();
		return false;
	});

	$("#different_billing_address").click(function() {

		//Use Different
		if ($(this).is(":checked")) {
			$("#fc_customer_billing_container").show();
			copyShippingFieldsToBillingFields();

		//Don't Use Different
		} else {
			$("#fc_customer_billing_container").hide();
			clearBillingFields();

		}
	});

	$(".fc_foxycomplete_input").css("width", $(".fc_foxycomplete_input").innerWidth() + 14);
	$(".fc_shipping_country_name, .fc_customer_country_name").hide();



});



FC.customLiveShipping = {}

FC.customLiveShipping.config = {
	autoSelect: true
};

FC.customLiveShipping.logic = function() {
	var country = (jQuery("#use_different_addresses").is(":checked") ? $("#shipping_country").val() : $("#customer_country").val());
	if ((country == "US" && fc_json.total_price < 49) || country != "US") FC.customLiveShipping.remove("free");
}








function clearBillingFields() {
	$("#customer_first_name, #customer_last_name, #customer_address1, #customer_address2, #customer_city, #customer_state, #customer_postal_code, #customer_phone").val("");
}

function copyShippingFieldsToBillingFields() {
	var fields = new Array('first_name','last_name','address1','address2','city','state_name','postal_code','country','phone');
	var sourcePrefix = '#fc_address_shipping_list #shipping_';
	var targetPrefix = '#fc_customer_billing_list #customer_';
	for(var i=0;i<fields.length;i++){
		if(typeof $(sourcePrefix+fields[i]).val()!='undefined' && $(targetPrefix+fields[i]).val()=='' ||
	  	 typeof $(sourcePrefix+fields[i]).val()!='undefined' && $('#use_different_addresses').is(':checked')==false){
			$(targetPrefix+fields[i]).val($(sourcePrefix+fields[i]).val());
		}
	}
}

  jQuery(document).ready(function(){
     FC.checkout.overload('updateShipping',null,function(){copyShippingFieldsToBillingFields();});
     FC.checkout.overload('validateAndSubmit',function(){copyShippingFieldsToBillingFields();},null);
  });



  /* Live Rate Shipping Modification Logic v1.3 */

  jQuery(document).ready(function() {
    jQuery(document).ajaxComplete(function(event, request, settings) {
      if (settings.url.indexOf('GetShippingCost') != -1) {
        FC.customLiveShipping.execute();
      }
    });

    if (FC.checkout.config.postedCheckout && FC.checkout.config.shippingServiceId > 0) {
      FC.customLiveShipping.execute();
    }
  });


  /**
   *  PUBLIC FUNCTIONS
   *  Use these functions to modify the returned live rates
   */

  FC.customLiveShipping.add = function(code, cost, carrier, service) {
    var newShippingOption = '<label for="shipping_service_' + code + '" class="fc_radio"><input type="radio" class="fc_radio fc_required" value="' + code + '|' + cost + '" id="shipping_service_' + code + '" name="shipping_service" onclick="FC.checkout.updatePrice(-1)" /><span class="fc_shipping_carrier">' + carrier + '</span><span class="fc_shipping_service">' + service + '</span><span class="fc_shipping_cost">' + FC.formatter.currency(cost, true) + '</span></label>';
    jQuery("#fc_shipping_methods_inner").append(newShippingOption);
  }

  FC.customLiveShipping.hide = function(selector) {
    if (typeof(selector) != "number") FC.customLiveShipping.alterShippingOptions(FC.customLiveShipping.hide, selector);
    jQuery("label[for=shipping_service_" + selector + "]").hide();
  }

  FC.customLiveShipping.show = function(selector) {
    if (typeof(selector) != "number") FC.customLiveShipping.alterShippingOptions(FC.customLiveShipping.show, selector);
    jQuery("label[for=shipping_service_" + selector + "]").show();
  }

  FC.customLiveShipping.update = function(selector, modifier) {
    if (typeof(selector) != "number") FC.customLiveShipping.alterShippingOptions(FC.customLiveShipping.update, selector, modifier);
    var rateAttributes = FC.customLiveShipping.getShippingAttributes(jQuery("input#shipping_service_" + selector)),
        price = FC.customLiveShipping.modifyPrice(rateAttributes.price, modifier);
    jQuery("input#shipping_service_" + selector).val(selector + '|' + price).siblings("span.fc_shipping_cost").html(FC.formatter.currency(price, true));
  }

  FC.customLiveShipping.remove = function(selector) {
    if (typeof(selector) != "number") FC.customLiveShipping.alterShippingOptions(FC.customLiveShipping.remove, selector);
    jQuery("label[for=shipping_service_" + selector + "]").remove();
  }

  FC.customLiveShipping.reset = function() {
    FC.checkout.updateShipping(-1);
  }


  /**
   *  PRIVATE FUNCTIONS
   *  These aren't the droids you're looking for
   */

  FC.customLiveShipping.execute = function() {
    if (!jQuery("#fc_shipping_methods_inner input[type='radio']:first").data("custom-shipping-logic-applied")) {
      FC.customLiveShipping.logic();

      if (FC.customLiveShipping.config.autoSelect) {
        jQuery("#fc_shipping_methods_inner input[type='radio']:first").attr("checked", "checked");
      }

      // Remove hidden rates - they're obviously not needed
      jQuery("#fc_shipping_methods_inner label[for^='shipping_service']:hidden").remove();

      FC.checkout.updatePrice(-1);

      // Set the inputs to be marked as updated, to prevent it being run twice.
      jQuery("#fc_shipping_methods_inner input[type='radio']").data("custom-shipping-logic-applied", true);
    }
  }

  FC.customLiveShipping.alterShippingOptions = function(func, selector, modifier) {
    if (typeof(selector) == "number") {
      // They've just provided a rate code, pass them on.
      func.call(null, selector, modifier);

    } else if (typeof(selector) == "string") {
      // It's a string, must be a combination of carrier and service or all
      var rates = [];
      if (selector.toLowerCase() == "all") {
        // This applies to all returned rates
        rates = jQuery("#fc_shipping_methods_inner label[for^='shipping_service']");
      } else {
        // Some filter has been specified
        var regex = /(fedex|usps|ups)?\s?([\w\s]+)?/i,
            provider = regex.exec(selector);

        if (provider == undefined) return;

        var carrierSelector = "span.fc_shipping_carrier";
        if (provider[1] != undefined) {
          switch(provider[1].toLowerCase()) {
            case "fedex":
              carrierSelector = "span.fc_shipping_carrier:contains('FedEx')";
              break;
            case "usps":
              carrierSelector = "span.fc_shipping_carrier:contains('USPS')";
              break;
            case "ups":
              carrierSelector = "span.fc_shipping_carrier:contains('UPS')";
              break;
          }
        }

        if (provider[2] != undefined) {
          rates = jQuery("#fc_shipping_methods_inner label[for^='shipping_service'] "+carrierSelector).siblings("span.fc_shipping_service").filter(function() {
            return (jQuery(this).text().toLowerCase().indexOf(provider[2].toLowerCase()) > -1);
          }).parent();
        } else {
          rates = jQuery("#fc_shipping_methods_inner label[for^='shipping_service'] "+carrierSelector).parent();
        }
      }

      rates.each(function() {
        var rateAttributes = FC.customLiveShipping.getShippingAttributes(jQuery(this).children("input[name='shipping_service']"));
        func.call(null, parseInt(rateAttributes.id), modifier);
      });

    } else if (typeof(selector) == "object") {
      // Assume it's an array of codes
      for (var i in selector) {
        func.call(null, parseInt(selector[i]), modifier);
      }
    }
  }

  FC.customLiveShipping.getShippingAttributes = function(item) {
    if (typeof(item) == "number") {
      // Passed the code
      item = jQuery("input#shipping_service_" + item);
    }

    var carrier = "",
        service = "",
        inputVal = 0,
        id = 0,
        price = 0;

    if (item.length) {
      carrier = item.siblings(".fc_shipping_carrier").html(),
      service = item.siblings(".fc_shipping_service").html(),
      inputVal = item.val().split("|"),
      id = parseInt(inputVal[0]),
      price = parseFloat(inputVal[1]);
    }

    return {"carrier": carrier, "service": service, "id": id, "price": price};
  }

  FC.customLiveShipping.modifyPrice = function(price, modifier) {
    var modifier = modifier.toString(),
        regex = /([\+\-\=\*\/])?(\d+(?:\.\d+)?)(\%)?/,
        parts = regex.exec(modifier),
        price = parseFloat(price),
        modifyBy = parseFloat(parts[2]);

    if (parts[3] != undefined) {
      modifyBy = price * (modifyBy / 100);
    }

    var operator = (parts[1] == undefined) ? "=" : parts[1];
    switch(operator) {
      case "+":
        price = (price + modifyBy);
        break;
      case "-":
        price = (price - modifyBy);
        break;
      case "/":
        price = (price / modifyBy);
        break;
      case "*":
        price = (price * modifyBy);
        break;
      default:
        price = modifyBy;
    }

    return (price < 0) ? 0 : price;
  }
