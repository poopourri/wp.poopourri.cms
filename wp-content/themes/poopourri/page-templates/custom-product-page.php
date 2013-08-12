<?php
/**
 * Template Name: Custom Product Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div id="primary-orapup" class="site-content">
	<div id="content" role="main">
		<form action="https://oraclub-staging.foxycart.com/cart" method="post" accept-charset="utf-8">
			<input type="hidden" name="name||74fea1ad4e252493b5bdf8e30492fb590b2184b9aa214d6df72cf5843851b65e" value="Cool Example"> 
			<input type="hidden" name="price||9597dd2f1ebfc36b85d7afd0d9c32f7ddd00096d1496bbb1431f164953aa4ea5" value="10"> 
			<input type="hidden" name="code||4cf5aca971905bb7d07acc4b355c1e297d06ffdf0e7ef261fc57b11578a06bff" value="foo"> 
			<input class="button green" type="submit" value="Add a Cool Example">
		</form>
				
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>