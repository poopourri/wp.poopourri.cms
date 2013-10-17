<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Poopourri Checkout</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo("stylesheet_directory"); ?>/checkout.css" media="screen">
    <link rel="stylesheet" href="<?php bloginfo("stylesheet_directory"); ?>/checkout.poopourri.css" media="screen">
    <?php wp_head(); ?>

<script type="text/javascript" charset="utf-8">
	//<![CDATA[
	jQuery(document).ready(function() {
 
		/* BEGIN CUSTOM LOCATION LOGIC */
 
 		FC.locations.removeCountries("RU");
 
		/* END CUSTOM LOCATION LOGIC */
 
		FC.locations.updateFoxyComplete(true);
	});
	//]]>
</script>
 
<script type="text/javascript" charset="utf-8">
	//<![CDATA[
	// Country/State Helper Functions v1.1
	// Do not modify the following functions
 
	FC.locations.removeCountries = function(countries, locationArrayNames) {
		if (typeof countries == "undefined") { return false }
		if (typeof countries == "string") { countries = [countries]; }
		locationArrayNames = FC.locations.validateLocationArrayNames(locationArrayNames);
 
		for (l in locationArrayNames) {
			var locationArray = FC.locations.getLocationArray(locationArrayNames[l]);
			for (var c in countries) {
				if (typeof locationArray[countries[c]] == "undefined") { break; }
				delete locationArray[countries[c]];
			}
		}
 
		return true;
	}
 
	FC.locations.limitCountriesTo = function(countries, locationArrayNames) {
		if (typeof countries == "undefined") { return false }
		if (typeof countries == "string") { countries = [countries]; }
		locationArrayNames = FC.locations.validateLocationArrayNames(locationArrayNames);
 
		for (l in locationArrayNames) {
			var newLocations = {};
			var locationArray = FC.locations.getLocationArray(locationArrayNames[l]);
			for (var c in countries) {
				if (typeof locationArray[countries[c]] == "undefined") { break; }
				newLocations[countries[c]] = locationArray[countries[c]];
			}
 
			// Prevent the countries being set to nothing
			if (newLocations == {}) { return false; }
 
			if (locationArrayNames[l] == "customer") {
				FC.locations.config.locations = newLocations;
			} else {
				FC.locations.config.shippingLocations = newLocations;
			}
		}
		return true;
	}
 
	FC.locations.removeStates = function(country, states, locationArrayNames) {
		if (typeof country == "undefined" || typeof states == "undefined") { return false }
		if (typeof states == "string") { states = [states]; }
		locationArrayNames = FC.locations.validateLocationArrayNames(locationArrayNames);
 
		for (l in locationArrayNames) {
			var locationArray = FC.locations.getLocationArray(locationArrayNames[l]);
			if (typeof locationArray[country] == "undefined") { return false; }
			for (var s in states) {
				if (typeof locationArray[country].r[states[s]] == "undefined") { break; }
				delete locationArray[country].r[states[s]];
			}
		}
		return true;
	}
 
	FC.locations.limitStatesTo = function(country, states, locationArrayNames) {
		if (typeof country == "undefined" || typeof states == "undefined") { return false }
		if (typeof states == "string") { states = [states]; }
		locationArrayNames = FC.locations.validateLocationArrayNames(locationArrayNames);
 
		for (l in locationArrayNames) {
			var newLocations = {};
			var locationArray = FC.locations.getLocationArray(locationArrayNames[l]);
			if (typeof locationArray[country] == "undefined") { return false; }
			for (var s in states) {
				if (typeof locationArray[country].r[states[s]] == "undefined") { break; }
				newLocations[states[s]] = locationArray[country].r[states[s]];
			}
 
			if (locationArrayNames[l] == "customer") {
				FC.locations.config.locations[country].r = newLocations;
			} else {
				FC.locations.config.shippingLocations[country].r = newLocations;
			}
		}
		return true;
	}
 
	FC.locations.updateFoxyComplete = function(blockErrors) {
		FC.checkout.config.evaluateAjaxRequests = false;
 
		FC.checkout.setAutoComplete("customer_country");
		if (jQuery("#customer_country_name") != "") {
			FC.checkout.validateLocationName("customer_country");
		}
		if (jQuery("#customer_state_name").val() != "") {
			FC.checkout.validateLocationName("customer_state");
		}
		if (blockErrors) {
			FC.checkout.updateErrorDisplay("customer_country_name", false);
			FC.checkout.updateErrorDisplay("customer_state_name", false);
		}
		if (!FC.checkout.config.hasMultiship) {
			FC.checkout.setAutoComplete("shipping_country");
			if (jQuery("#shipping_country_name") != "") {
				FC.checkout.validateLocationName("shipping_country");
			}
			if (jQuery("#shipping_state_name") != "") {
				FC.checkout.validateLocationName("shipping_state");
			}
			if (blockErrors) {
				FC.checkout.updateErrorDisplay("shipping_country_name", false);
				FC.checkout.updateErrorDisplay("shipping_state_name", false);
			}
 
			FC.checkout.config.evaluateAjaxRequests = true;
			FC.checkout.updateShipping(-1);
			FC.checkout.updateTaxes(-1);
		} else {
			for (var i = 0; i < FC.checkout.config.multishipDetails.length; i++) {
				FC.checkout.setAutoComplete("shipto_" + i + "_country");
				if (jQuery("#shipto_" + i + "_country_name") != "") {
					FC.checkout.validateLocationName("shipto_" + i + "_country");
				}
				if (jQuery("#shipto_" + i + "_state_name") != "") {
					FC.checkout.validateLocationName("shipto_" + i + "_state");
				}
				if (blockErrors) {
					FC.checkout.updateErrorDisplay("shipto_" + i + "_country_name", false);
					FC.checkout.updateErrorDisplay("shipto_" + i + "_state_name", false);
				}
			}
 
			FC.checkout.config.evaluateAjaxRequests = true;
			for (var i = 0; i < FC.checkout.config.multishipDetails.length; i++) {
				FC.checkout.updateShipping(i);
				FC.checkout.updateTaxes(i);
			}
		}
	}
 
	FC.locations.getLocationArray = function(locationArrayNames) {
		return (locationArrayNames == "customer") ? FC.locations.config.locations : FC.locations.config.shippingLocations;
	}
 
	FC.locations.validateLocationArrayNames = function(locationArrayNames) {
		if (typeof locationArrayNames == "undefined" || locationArrayNames == "" || locationArrayNames == "both") { locationArrayNames = ["customer", "shipping"]; }
		if (typeof locationArrayNames == "string") { locationArrayNames = [locationArrayNames]; }
		return locationArrayNames;
	}
	//]]>
</script>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site_header is-minimized site_header_checkout" role="banner">
		    <div id="header-container">
		        <div id="header-links">
    		        <a class="shop-link shop_header_btn header-content-link" data-content="shop-content"><span class="screen-reader-text">Shop over 20 scents</span></a>
    		        <div class="logo-container">
    			        <a class="home-link poopourri_logo_btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="screen-reader-text"><?php bloginfo( 'name' ); ?>: <?php bloginfo( 'description' ); ?></span></a>
    			    </div>
    			    <a class="follow-link follow_header_btn header-content-link" data-content="follow-content"><span class="screen-reader-text">Follow:</span><span class="following"><span class="counter">1,230,000</span> Followers</span></a>
    			</div>
		    </div>
		</header><!-- #masthead -->


    <div class="container">
