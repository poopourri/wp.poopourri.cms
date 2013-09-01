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
 
  window.optimizely.push(['trackEvent', 'new_revenue', (parseFloat(my_order_total) * 100 )]);
 
</script>
^^analytics_google_ga_async^^
{% endif %}
</body>
</html>
