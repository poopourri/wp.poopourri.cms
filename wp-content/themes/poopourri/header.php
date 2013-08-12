<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<script src="//cdn.optimizely.com/js/23860275.js"></script>
<!--<script type="text/javascript" src="<?php // echo get_template_directory_uri(); ?>/js/jquery-1.7.min.js"></script>-->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=1100" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
if(is_page("home") || is_front_page()){ 
?>
<meta name="description" content="Beat Bad Dog Breath without a Toothbrush" />
<meta name="keywords" content="dog breath, dogs, tongue scraper, tongue cleaner, bad breath cure, halitosis cure, tongue brush, bad breath remedies, how to get rid of bad breath, cure bad breath, how to cure bad breath">	
<?php }?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.dataTables.css" type="text/css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.fancybox-1.3.4.css" type="text/css">
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34492614-1']);
  _gaq.push(['_setDomainName', 'orapup.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
  _gaq.push(function(){prepGALinks();});
  var currURL = (document.URL);
  if(currURL.indexOf('?ref=')>-1){
    _gaq.push(['_setReferrerOverride', currURL]);
  }
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript" charset="utf-8">
	fcc.events.cart.preprocess.add(function(e, arr) {
		if (arr['cart'] == 'checkout' || arr['cart'] == 'updateinfo' || arr['output'] == 'json') {
			return true;
		}
		if (arr['cart'] == 'checkout_paypal_express') {
			_gaq.push(['_trackPageview', '/paypal_checkout']);
			return true;
		}
		_gaq.push(['_trackPageview', '/cart']);
		return true;
	});
	        // for links in the product categories that go directly to the checkout
        function prepGALinks(){
                var pageTracker = _gat._getTrackerByName();
                jQuery('.foxyshop_product_list .cart_link').each(function(){
                        var href_link = jQuery(this).attr('href') + pageTracker._getLinkerUrl('', true);
                        jQuery(this).attr('href', href_link);
                        //alert(href_link);
                });
                prepDirectForms();
        }

        // for forms that go directly to checkout
        function prepDirectForms(){
                var pageTracker = _gat._getTrackerByName();
                jQuery('<input type="hidden" name="h:host_site" value="orapup"/><input type="hidden" name="h:ga" value="'+pageTracker._getLinkerUrl('', true)+'"/>').appendTo('.foxyshop_product');
        }

	fcc.events.cart.process.add_pre(function(e, arr) {
		var pageTracker = _gat._getTrackerByName();
		jQuery.getJSON('https://' + storedomain + '/cart?' + fcc.session_get() + '&h:ga=' + escape(pageTracker._getLinkerUrl('', true)) + '&output=json&callback=?', function(data){});
		return true;
	});
</script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header orapup-nav" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="http://d24u6jzgh6a90w.cloudfront.net/wp-content/uploads/sites/2/2013/03/orapup_logo_by_orabrush_gray.png"/>
			</a></h1>
			<div class="logo-right-space">&nbsp;</div>
<!--			<?php bloginfo( 'name' ); ?>
			
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>-->
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
				
				<div class="header-login">
				</div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			
			<div class="facebook-like-count"> <?php echo get_facebook_fans()?></div>
			<div class="youtube-like-count"> <?php echo get_youtube_views()?></div>
				<div class='user-links logged-our-user-links' style="display: none;">
					<div class="profile-detail-links">
					<div class="account-div">	
					<?php if(is_user_logged_in()){ ?>
						<a href="<?php echo get_bloginfo('url') ?>/user-profile" class='menu-link profile'>Profile</a>
						<a href="<?php echo get_bloginfo('url') ?>/myorders" class='menu-link order-history'>Order History</a>
					<?php
					}
					?>
					
					<span class='menu-link loginout'>
					<?php 
						wp_loginout();
					?>
					</span>
					</div>
					</div>
					</div>
			</nav>

	<?php 
	$page_name = $wp_query->post->post_name;
	$pages = array('home','privacy','press','distributor');
	if(strpos(strtolower($page_name),'home')!==false){
	?>
			<div class="header-order-button">
				<a name="t_button" id="t_button" href="packages">
					<span>Free Shipping in the USA</span>
				</a>
			</div>
	<?php }else if(strpos(strtolower($wp_query->post->post_type,'product')===false)){ ?>
			<div class="header-order-button">
				<a name="t_button" id="t_button" href="/packages">
					<span>Free Shipping in the USA</span>
				</a>
			</div>	
	<?php } ?>
			<div class="hidden">
				<div id="youtube_page"><iframe src="http://www.youtube.com/subscribe_widget?p=orapup" id="imagesone"></iframe></div>
			</div>
			<div class="hidden">
				<div id="facebook_page"><iframe src="http://www.orapup.com/facebook.html?width=500&height=220" id="imagesone"></iframe></div>
			</div>
		</hgroup>

		
<!--		 #site-navigation-->

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->
	
	<?php 
	if(strpos(strtolower($page_name),'home')!==false){
	?>
	    <?php if(function_exists(string_override_manual)) echo string_override_manual(2)?>
	<?php }?>

	<div id="main" class="wrapper">
