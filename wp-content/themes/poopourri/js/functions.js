/**
 * Functionality specific to Twenty Thirteen.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	var body    = $( 'body' ),
	    _window = $( window );

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
	    expandedClass = 'is-expanded';

    // Detect scroll position and change header class
	_window.scroll(function() {
	    var minimize = 300, top = _window.scrollTop(),
	        _header = $('.site_header');
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
	$('.header-content-link').click(function(a) {
	    var _link = $(this),
	        _content = _link.attr('data-content'),
	        openClass = _content + '-open',
	        _header = $('.site_header');
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