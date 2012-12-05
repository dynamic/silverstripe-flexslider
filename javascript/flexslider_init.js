$(document).ready(function(){

	$('.flexslider').flexslider({
		animation: "slide",
		animationLoop: true,
		//itemWidth: 600,
		//video: true,
		controlNav: true,
		directionNav: true, 
		pauseOnAction: true,
		pauseOnHover: true,
		start: function(slider){
		  $('body').removeClass('loading');
		}	
	});	
	
	/*
	// touch device click actions
	
	$(".touch .section-grid li a").each(function(){
		var t = $(this);
		t.data("tapped","false");
		t.on("click", function(event){			
			$(".section-grid li a").not(this).data("tapped","false");						
			if(t.data("tapped")== "true")
			{
				//Second click: use HREF
			} else {
				//First click: set flag, show overlay
				t.data("tapped","true");
				return false;
			}
		})
	});
	*/
	
});