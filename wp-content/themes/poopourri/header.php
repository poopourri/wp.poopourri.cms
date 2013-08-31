<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site_header" role="banner">
		    <div id="header-container">
		        <div id="header-links">
    		        <a class="shop-link shop_header_btn header-content-link" data-content="shop-content"><span class="screen-reader-text">Shop over 20 scents</span></a>
    		        <div class="logo-container">
    			        <a class="home-link poopourri_logo_btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="screen-reader-text"><?php bloginfo( 'name' ); ?>: <?php bloginfo( 'description' ); ?></span></a>
    			    </div>
    			    <a class="follow-link follow_header_btn header-content-link" data-content="follow-content"><span class="screen-reader-text">Follow:</span><span class="following"><span class="counter">1,230,000</span> Followers</span></a>
    			</div>
		    </div>
		    <div id="header-content">
                <div id="shop-content" class="header-content clearfix">
                    <?php wp_nav_menu( array( 'theme_location' => 'shop', 'menu_class' => 'shop-menu' ) ); ?>
                </div>
                <div id="follow-content" class="header-content clearfix">
       		<div class="right">
            			<ul class="supernav-list connect-link-list addthis_toolbox addthis_default_style">
                			<li class="facebook"><a class="addthis_button_facebook_follow at300b" addthis:userid="JRWNaturals" href="http://www.facebook.com/poopourri.spray" target="_blank" title="Follow on Facebook"><span class="at16nc at300bs at15nc at15t_facebook at16t_facebook"><span class="screen-reader-text">Share on facebook</span></span>"Like Us" on Facebook</a></li>
                			<li class="twitter"><a class="addthis_button_twitter_follow at300b" addthis:userid="JRWNaturals" target="_blank" title="Follow on Twitter" href="https://twitter.com/poopourri1"><span class="at16nc at300bs at15nc at15t_twitter at16t_twitter"><span class="screen-reader-text">Share on twitter</span></span>"Follow Us" on Twitter</a></li>
                			<li class="pinterest"><a class="addthis_button_pinterest_follow at300b" addthis:userid="jrwnaturals" href="http://pinterest.com/poopourri1/" target="_blank" title="Follow on Pinterest"><span class=" at300bs at15nc at15t_pinterest"><span class="screen-reader-text">Share on pinterest</span></span>"Follow Us" on Pinterest</a></li>
                			<li class="tumblr"><a class="addthis_button_tumblr_follow at300b" addthis:userid="clearconscienceblog" href="http://www.youtube.com/channel/UCZyrOlKnW26YyLiPT0bvOCA" target="_blank" title="Subscribe on YouTube"><span class="at16nc at300bs at15nc at15t_tumblr at16t_tumblr"><span class="screen-reader-text">Subscribe on YouTube</span></span>"Subscribe" on YouTube</a></li>                
            				<div class="clear"></div>
				</ul>
        		</div>
  
		 </div>
            </div>
			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php if ( is_user_logged_in() ) { ?>
						<ul id="menu-account-menu" class="nav-menu"><li id="menu-item-account" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="#">My Account</a></li></ul>
					<?php } else { ?>
						<ul id="menu-account-menu" class="nav-menu"><li id="menu-item-account" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="#">Sign In / Create Account</a></li></ul>
					<?php } ?>
					<?php wp_nav_menu( array( 'theme_location' => 'customer', 'menu_class' => 'nav-menu' ) ); ?>
					<?php get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
            <div id="cart-container">
                <div id="cart-content">
                    <div style="margin-top: 150px; display: block; color: #ddd; text-transform: uppercase; font-size: 20px; text-align: center;">Your Cart Is Empty</div>
                </div>
		 <div id="cart-close-content">
			<a class="close_cart_btn"><span class="screen-reader-text">Close cart</span></a>
		 </div>
            </div>
			<a class="cart-link cart_btn"><span class="cart-items"><span class="count">0</span> item(s)</span></a>

		</header><!-- #masthead -->

		<div id="main" class="site-main">
