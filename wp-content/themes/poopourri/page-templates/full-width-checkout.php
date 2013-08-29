<?php
/**
 * Template Name: Full-width Page Template, Checkout Header
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
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
		<header id="masthead" class="site_header is-minimized" role="banner">
		    <div id="header-container">
		        <div id="header-links">
    		        <a class="shop-link shop_header_btn header-content-link" data-content="shop-content"><span class="screen-reader-text">Shop over 20 scents</span></a>
    		        <div class="logo-container">
    			        <a class="home-link poopourri_logo_btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="screen-reader-text"><?php bloginfo( 'name' ); ?>: <?php bloginfo( 'description' ); ?></span></a>
    			    </div>
    			    <a class="follow-link follow_header_btn header-content-link" data-content="follow-content"><span class="screen-reader-text">Follow:</span><span class="following"><span class="counter">1,230,000</span> Followers</span></a>
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
            </div>
			<a class="cart-link cart_btn"><span class="cart-items"><span class="count">0</span> item(s)</span></a>

		</header><!-- #masthead -->

		<div id="main-checkout" class="site-main">


	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>