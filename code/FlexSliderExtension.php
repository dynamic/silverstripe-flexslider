<?php

class FlexSliderExtension extends Extension {

	public function onAfterInit() {

		Requirements::javascript('flexslider/thirdparty/flexslider/jquery.flexslider-min.js');
		Requirements::css('flexslider/thirdparty/flexslider/flexslider.css');

		// Flexslider options
		$animate = ($this->owner->Animate) ? 'true' : 'false';
		$loop = ($this->owner->Loop) ? 'true' : 'false';
		$sync = ($this->owner->ThumbnailNav==true) ? "sync: '#carousel'," : "";
		$before = (method_exists($this->owner->ClassName, 'flexSliderBeforeAction'))
			? $this->owner->flexSliderBeforeAction()
			: "function(){}";
		$after = (method_exists($this->owner->ClassName, 'flexSliderAfterAction'))
			? $this->owner->flexSliderAfterAction()
			: "function(){}";
		$speed = (method_exists($this->owner->ClassName, 'setFlexSliderSpeed'))
			? $this->owner->setFlexSliderSpeed()
			: 7000;

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
					".$sync."
					start: function(slider){
					  $('body').removeClass('loading');
					},
					before: ".$before.",
					after: ".$after.",
					slideshowSpeed: " . $speed . "
				});
			});
		");

	}

}
