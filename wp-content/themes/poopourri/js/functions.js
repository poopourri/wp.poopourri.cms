/**
 * Functionality specific to Twenty Thirteen.
 *
 * Provides helper functions to enhance the theme experience.
 */

var free_shipping_total_required = 49;

( function( $ ) {
	var body    = $( 'body' ),
	    _window = $( window ),
		_foxycartURL = 'https://poopourri.foxycart.com/';

	/**
	 * Adds a top margin to the footer if the sidebar widget area is higher
	 * than the rest of the page, to help the footer always visually clear
	 * the sidebar.
	 */
	$( function() {
		if ( body.is( '.sidebar' ) ) {
			var sidebar   = $( '#secondary .widget-area' ),
			    secondary = ( 0 == sidebar.length ) ? -40 : sidebar.height(),
			    margin    = $( '#tertiary .widget-area' ).height() - $( '#content' ).height() - secondary;

			if ( margin > 0 && _window.innerWidth() > 999 )
				$( '#colophon' ).css( 'margin-top', margin + 'px' );
		}
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var nav = $( '#site-navigation' ), button, menu;
		if ( ! nav )
			return;

		button = nav.find( '.menu-toggle' );
		if ( ! button )
			return;

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.twentythirteen', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.twentythirteen', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
				element.tabIndex = -1;

			element.focus();
		}
	} );

	// Header content classes
	var contentClasses = 'follow-content-open shop-content-open',
	    expandedClass = 'is-expanded',
	    _header = $('.site_header');

    // Detect scroll position and change header class
	_window.scroll(function() {
            if($('.site_header_checkout').length!=0){
		return false;
            }
	    var minimize = 300, top = _window.scrollTop();
	    if (top >= minimize) {
	        if (!_header.hasClass('is-minimized')) {
	            _header.removeClass(contentClasses + ' ' + expandedClass);
	            setTimeout(function() {
	                if (_header.hasClass('is-minimized')) {
	                    $('.header-content-link').hide();
	                }
	            }, 300);
	        }
	        _header.addClass('is-minimized');
	    }
	    else {
	        if (_header.hasClass('is-minimized')) {
	            $('.header-content-link').show();
	        }
	        setTimeout(function() {
	            _header.removeClass('is-minimized');
	        }, 0);
	    }
	} );

	// Toggles for header content
	$('.header-content-link').click(function() {
	    var _link = $(this),
	        _content = _link.attr('data-content'),
	        openClass = _content + '-open';
	    if (_header.hasClass(openClass)) {
	        _header.removeClass(expandedClass + ' ' + openClass);
	        return false;
	    }
	    if (_header.hasClass(expandedClass)) {
	        _header.removeClass(contentClasses);
	        _header.addClass(openClass);
	        return false;
	    }
	    _header.addClass(expandedClass + ' ' + openClass);
	});

	function updateFreeShippingNotice(cart_price){
		if($('.foxyshop_product').length!=0){
			var package_price_on_page = parseInt($('#adding_package input#fs_price_'+$('.foxyshop_product').prop('id').split('_')[3]).val());
		}else{
			var package_price_on_page = 0;
		}
		var current_total_price = cart_price + package_price_on_page;
		$('#total_order_on_page').text(current_total_price);
		if(current_total_price < free_shipping_total_required){
			var remaining = free_shipping_total_required - current_total_price;
			$('.free_shipping_notice').html('FREE FAST shipping to USA on any order $49+ ($<span class="free_shipping_remaining">'+remaining+'</span> left)');
		}else{
			$('.free_shipping_notice').html('You qualify for FREE shipping to the USA!');
		}
	}

	// Toggle cart content
	$('.cart-link, .close_cart_btn').click(function() {
	    var openClass = 'cart-is-open';
	    _header.toggleClass(openClass);
            // load the cart if it has something in it
	    if(_header.hasClass(openClass)){
		$('#cart-content').html('<iframe id="foxycart_iframe" src="'+_foxycartURL+'cart?'+fcc.session_get()+'" style="width:'+$('#cart-content').width()+'px;height:'+$('#cart-content').height()+'px;border:0px;margin:0px;padding:0px;"></iframe>');
	    }

	    jQuery.getJSON(_foxycartURL+'cart?'+fcc.session_get()+'&output=json&callback=?', function(cart) {
		$('.cart-items .count').text(cart.product_count);
		updateFreeShippingNotice(cart.total_price);
	    });
	});

	/**
	 * Load the cart quantity
	 */
	if (typeof fcc !== 'undefined') {
	jQuery.getJSON(_foxycartURL+'cart?'+fcc.session_get()+'&output=json&callback=?', function(cart) {

		$('#cart-content').html('<iframe id="foxycart_iframe" src="'+_foxycartURL+'cart?'+fcc.session_get()+'" style="width:'+$('#cart-content').width()+'px;height:'+$('#cart-content').height()+'px;border:0px;margin:0px;padding:0px;"></iframe>');

		$('.cart-items .count').text(cart.product_count);

		updateFreeShippingNotice(cart.total_price);

		fcc.events.cart.preprocess.add_pre(function(e, arr) {
        	    if (arr['cart'] != "view" && arr['cart'] != "checkout") {
			console.log("Preprocess - adding a product silently");
            		var jsonString = "";
            		jsonString = 'https://' + fcc.storedomain + '/cart?output=json&'+jQuery(e).serialize();
            		$.getJSON(jsonString+'&callback=?' + fcc.session_get(), function(data) {
                		console.log("And added.");
                		console.info(this);
                		FC.json = data;
                		// fcc.cart_update();
                		console.log('= = = = = = = = = = = = = = = = = = = = =');
                		console.info(this);
                		fcc.events.cart.postprocess.execute(e);
            		});
            		return "pause";
        	    } else {
           		 return true;
        	    }
    		});

		fcc.events.cart.postprocess.add(function(){
	    		jQuery.getJSON(_foxycartURL+'cart?'+fcc.session_get()+'&output=json&callback=?', function(cart) {
				var openClass = 'cart-is-open';
				if(!_header.hasClass(openClass)){
	    				_header.toggleClass(openClass);
				}
            			// load the cart if it has something in it
	    			if(_header.hasClass(openClass)){
					$('#cart-content').html('<iframe id="foxycart_iframe" src="'+_foxycartURL+'cart?'+fcc.session_get()+'" style="width:'+$('#cart-content').width()+'px;height:'+$('#cart-content').height()+'px;border:0px;margin:0px;padding:0px;"></iframe>');
	    			}
				$('.cart-items .count').text(cart.product_count);
 	    		});
		});
 	});

	}



	/**
	 * Arranges footer widgets vertically.
	 */
	if ( $.isFunction( $.fn.masonry ) ) {
		var columnWidth = body.is( '.sidebar' ) ? 228 : 245;

		$( '#secondary .widget-area' ).masonry( {
			itemSelector: '.widget',
			columnWidth: columnWidth,
			gutterWidth: 20,
			isRTL: body.is( '.rtl' )
		} );
	}
} )( jQuery );
