<?php /*
------------ ATTENTION ------------
If you need to edit this template, do not edit the version in the plugin directory. Place a copy in your template folder and edit it there.
This will allow you to upgrade FoxyShop without breaking your customizations. More details here: http://www.foxy-shop.com/documentation/theme-customization/
-----------------------------------

------------ FOXYCART TEMPLATE INSTRUCTIONS ------------
You can find these templates at:
http://yoursite.com/foxycart-checkout-template/
http://yoursite.com/foxycart-receipt-template/

*/

//Remove jQuery and FoxyCart Includes
add_action('wp_enqueue_scripts', 'foxyshop_remove_jquery', 99);
remove_action('wp_footer', 'foxyshop_insert_google_analytics', 100);
remove_action('wp_head', 'foxyshop_insert_foxycart_files');
remove_action('init', 'foxyshop_insert_jquery');

add_action('init', 'my_foxyshop_dequeue', 11);
function my_foxyshop_dequeue() { wp_dequeue_style('foxyshop_css'); }

//Do Special Google Analytics If Required
add_action('wp_footer', 'foxyshop_insert_google_analytics_checkout');

//Put Special JS in Foot
add_action('wp_footer', 'foxycart_template_footer_includes');
function foxycart_template_footer_includes() {
    ?>
    <script type="text/javascript" src="<?php bloginfo("stylesheet_directory"); ?>/checkout.js"></script>
    <?php
}

//Put Special CSS in Head
add_action('wp_head', 'foxycart_template_header_includes');
function foxycart_template_header_includes() {
	?>
<!--<link rel="shortcut icon" href="<?php bloginfo("url");?>/favicon.ico" />-->
<meta name="ROBOTS" content="NOINDEX">
	<?php
}

get_header("foxycart"); ?>

    <div class="container">


        {% if error_codes|length > 0 %}
            {% include 'checkout_error.inc.twig' %}
        {% else %}
            {% if not is_updateinfo %}
            <div id="fc_checkout_cart">
                <?php include "cart.twig.blocks.php"; ?>
            </div>
            {% endif %}


            <?php include "checkout.twig.blocks.php"; ?>

        {% endif %}


    </div>









^^custom_begin^^
<?php
//Displays anything that's dynamically hooked to the custom fields section. You can also put your own code or fields here.
do_action('foxyshop_checkout_template_custom_fields_section');
?>
^^custom_end^^


<?php get_footer("foxycart"); ?>
