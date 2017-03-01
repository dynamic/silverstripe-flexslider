<% require css('flexslider/thirdparty/flexslider/flexslider.css') %>
<% require css('flexslider/css/silverstripe-flexslider.css') %>
<% if $SlideShow %>
    <div class="flexslider">
        <ul class="slides">
			<% loop $SlideShow %>
                <li class="remove-bottom">
                    <div class="col-md-3 col-sm-5 home-slider">
                        <h2>$Name</h2>
						<% if $Description %><p class="half-bottom">$Description</p><% end_if %>
						<% if $PageLinkID %><p class="remove-bottom"><a href="$PageLink.Link" class="flex-button" title="$PageLink.MenuTitle.XML">Learn more</a></p><% end_if %>
                    </div>
                    <div class="col-md-9 col-sm-7">
						<% if $PageLink %><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><% end_if %>
						<% if $Image %>
                            <img src="$Image.URL" alt="$Name Slider Image">
						<% end_if %>
						<% if $PageLink %></a><% end_if %>
                    </div>
                </li>
			<% end_loop %>
        </ul>
    </div>
	<% if $ThumbnailNav %>
        <div class="carousel">
            <ul class="slides">
				<% loop $SlideShow %>
                    <li>
						<% if $Image %>
                            <img src="$Image.Fill(200,200).URL"  alt="$Name.XML" class="slide">
						<% end_if %>
                    </li>
				<% end_loop %>
            </ul>
        </div>
	<% end_if %>
<% end_if %>
<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<% require javascript('flexslider/thirdparty/flexslider/jquery.flexslider-min.js') %>