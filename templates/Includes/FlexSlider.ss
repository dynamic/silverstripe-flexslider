<% require css('dynamic/flexslider: thirdparty/flexslider/flexslider.css') %>
<% require css('dynamic/flexslider: css/silverstripe-flexslider.css') %>
<% if $SlideShow %>
    <div class="slideshow">
        <div class="flexslider">
            <ul class="slides">
                <% loop $SlideShow %>
                    <li>
                        <% if $SlideType == Video %>
                            <% include Dynamic\\FlexSlider\\Model\\SlideImage_Video %>
                        <% else_if $SlideType == Text %>
                            <% include Dynamic\\FlexSlider\\Model\\SlideImage_Text %>
                        <% else %>
                            <% include Dynamic\\FlexSlider\\Model\\SlideImage_Image %>
                        <% end_if %>
                    </li>
                <% end_loop %>
            </ul>
        </div>
        <% if $ThumbnailNav && $SlideShow.Count > 1 %>
        <div class="fs-carousel">
            <ul class="slides">
                <% loop $SlideShow %>
                    <li>
                        <% if $Image %>
                            <img src="$Image.URL"  alt="$Image.Title" class="slide">
                        <% end_if %>
                    </li>
                <% end_loop %>
            </ul>
        </div>
    <% end_if %>
</div>
<% end_if %>
<% require javascript('silverstripe/admin: thirdparty/jquery/jquery.js') %>
<% require javascript('dynamic/flexslider: thirdparty/flexslider/jquery.flexslider-min.js') %>
