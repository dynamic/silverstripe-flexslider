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
		if($this->owner->ThumbnailNav==true){
			$sync = "sync: '#carousel',";
		}else{
			$sync = "";
		}
		if(method_exists($this->owner->ClassName, 'flexSliderBeforeAction')){
			$before = $this->owner->flexSliderBeforeAction();
		}else{
			$before = "function(){}";
		}
		if(method_exists($this->owner->ClassName, 'flexSliderAfterAction')){
			$after = $this->owner->flexSliderAfterAction();
		}else{
			$after = "function(){}";
		}
		if(method_exists($this->owner->ClassName, 'setFlexSliderSpeed')){
			$speed = $this->owner->setFlexSliderSpeed();
		}else{
			$speed = 7000;
		}

        // only call custom script if page has Slides
        if (Object::has_extension($this->owner->data()->ClassName, 'FlexSlider')) {
            if($this->owner->data()->Slides()->exists()){
                Requirements::customScript("
                (function($) {
                    $(document).ready(function(){
                        $('.flexslider').flexslider({
                            slideshow: " . $animate . ",
                            animation: '" . $this->owner->Animation . "',
                            animationLoop: " . $loop . ",
                            controlNav: true,
                            directionNav: true,
                            prevText: '',
                            nextText: '',
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
                }(jQuery));");
            }
        }

	}

}