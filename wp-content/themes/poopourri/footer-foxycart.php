		</div><!-- #container -->
	</div>
	<?php wp_footer(); ?>

{% if first_receipt_display %}
<script type="text/javascript" charset="utf-8">
  var my_order_total = "{{ order_total }}"; //twig
  my_order_total = my_order_total.replace("$", "");
  if(typeof my_future_order_total==="undefined"){
  }else if(my_future_order_total>0){
    my_order_total = my_future_order_total;
  }
 
  window.optimizely = window.optimizely || [];
 
  window.optimizely.push(['trackEvent', 'new_pp_revenue', (parseFloat(my_order_total) * 100 )]);
 
</script>
^^analytics_google_ga_async^^
<!-- Google Code for Sale on Poopourri.com Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 988742319;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "lyosCKG1twcQr4W81wM";
var google_conversion_value = 40;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/988742319/?value=40&amp;label=lyosCKG1twcQr4W81wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
{% endif %}

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 988742319;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/988742319/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>
