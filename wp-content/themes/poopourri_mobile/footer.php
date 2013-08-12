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
	<div id="colophon" class="footer-content" role="contentinfo">
		<div class="site-info">
			<div class="footer-container">
				<div class="footer">
			    	
			    	<?php if(function_exists(string_override_manual)) echo string_override_manual(1)?> 
			    	
			  	</div>
			</div>
					
						<!--<?php do_action( 'twentytwelve_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>-->
		</div><!-- .site-info -->
	</div><!-- #colophon -->
	<div id="footer_nav"><?php wp_nav_menu(array('container' => '','menu_id' => 'footer_nav','fallback_cb' => 'nav_menu','theme_location' => 'footer', )); ?></div>
</div><!-- #page -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dd.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.anythingfader.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/orapup-mobile.js" type="text/javascript"></script>
<?php wp_footer(); ?>
</body>
</html>