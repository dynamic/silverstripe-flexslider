<?php

class FlexSliderExtension extends Extension {

	public function onAfterInit() {
		
		Requirements::javascript('flexslider/thirdparty/flexslider/jquery.flexslider-min.js');
		Requirements::css('flexslider/thirdparty/flexslider/flexslider.css');
		
		Requirements::customScript("
			$(document).ready(function(){
				$('.flexslider').flexslider({
					animation: 'slide',
					animationLoop: true,
					controlNav: true,
					directionNav: true, 
					pauseOnAction: true,
					pauseOnHover: true,
					start: function(slider){
					  $('body').removeClass('loading');
					}	
				});
			});
		");
		
	}
	
}