$(document).ready(function () {
	$('.menu-button a').toggle(
			
			   function() {
			       $('#page').animate({ left: 250 }, 'slow', function() {
			    	   $("#page").css("margin-left", "400px");
			    	   $('#menu').show();
			       });
			   }, 
			   function() {
			       $('#page').animate({ left: 0 }, 'slow', function() {
			    	   $("#page").css("margin-left", "0px");
			    	   $('#menu').hide();
			       });
			   }
	);
});