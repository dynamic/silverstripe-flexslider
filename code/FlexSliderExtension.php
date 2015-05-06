<?php

class FlexSliderExtension extends Extension {

	public function onAfterInit() {
        
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

        // only call custom script if page has Slides
        if ($this->owner->data()->Slides()->exists()) {
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
