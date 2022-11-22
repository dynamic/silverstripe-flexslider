<% require css('dynamic/flexslider: thirdparty/flexslider/flexslider.css') %>
<% if $SlideShow %>
    <div class="row slideshow">
        <div class="flexslider card col-md-12">
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
        <div class="fs-carousel col-md-12">
            <ul class="slides">
                <% loop $SlideShow %>
                    <li>
                        <% if $Image %>
                            <img src="$Image.Fill(200,200).URL"  alt="$Image.Title" class="slide">
                        <% end_if %>
                    </li>
                <% end_loop %>
            </ul>
        </div>
    <% end_if %>
    </div>
    <% require javascript('//code.jquery.com/jquery-3.6.1.min.js') %>
    <% require javascript('dynamic/flexslider: thirdparty/flexslider/jquery.flexslider-min.js') %>
<% end_if %>

