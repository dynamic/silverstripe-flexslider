;(function ($) {
    $(document).ready(function () {
        $('.flexslider').flexslider({
            slideshow: $animate,
            animation: "{$animationType}",
            animationLoop: $loop,
            controlNav: true,
            directionNav: true,
            prevText: '',
            nextText: '',
            pauseOnAction: true,
            pauseOnHover: true,
            start: function (slider) {
                $('body').removeClass('loading');
            },
            before: $before,
            after: $after,
            slideshowSpeed: $speed
        });
    });
    if ($sync !== false) {
        $('.flexslider').flexslider({sync: $sync});
    }
}(jQuery));