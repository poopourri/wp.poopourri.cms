<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<div class="footer-container">
				<div class="footer">
			    	
			    	<?php if(function_exists(string_override_manual)) echo string_override_manual(1)?> 
			    	
			  	</div>
			</div>
					
						<!--<?php do_action( 'twentytwelve_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>-->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<div id="footer_nav"><?php wp_nav_menu(array('container' => '','menu_id' => 'footer_nav','fallback_cb' => 'nav_menu','theme_location' => 'footer', )); ?></div>
</div><!-- #page -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dd.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox-1.3.4.js" type=" text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/orapup.js" type="text/javascript"></script>
<?php wp_footer(); ?>

<?php if(is_page(1297) || is_page(1944)){ // lickies ?>
<!-- Google Code for Orapup Lickies Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "cSxlCP3H_AgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=cSxlCP3H_AgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php }else if(is_page(206)){ ?>
<!-- Google Code for Orapup Packages Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1038938345;
var google_conversion_label = "xT1aCNWY-wgQ6eGz7wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1038938345/?value=0&amp;label=xT1aCNWY-wgQ6eGz7wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php } ?>
</body>
</html>
