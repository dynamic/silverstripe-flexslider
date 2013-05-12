<?php

class FlexSliderExtension extends Extension {

	public function onAfterInit() {
		
		Requirements::javascript('flexslider/thirdparty/flexslider/jquery.flexslider-min.js');
		Requirements::css('flexslider/thirdparty/flexslider/flexslider.css');
		
		// Flexslider options
		if ($this->owner->Animate) {
			$animate = 'true';
		} else {
			$animate = 'false';
		}
		if ($this->owner->Loop) {
			$loop = 'true';
		} else {
			$loop = 'false';
		}
		
		Requirements::customScript("
			$(document).ready(function(){
				$('.flexslider').flexslider({
					slideshow: " . $animate . ",
					animation: '" . $this->owner->Animation . "',
					animationLoop: " . $loop . ",
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