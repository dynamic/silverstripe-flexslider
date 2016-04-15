<% require css('flexslider/thirdparty/flexslider/flexslider.css') %>
<% require css('flexslider/css/silverstripe-flexslider.css') %>
<% if $SlideShow %>
<div class="flexslider">
    <ul class="slides">
    	<% loop $SlideShow %>
        <li>
        	<% if $PageLink %><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><% end_if %>
			<% if $Image %>
            	<img src="$Image.URL"  alt="$Name.XML" class="slide">
            <% end_if %>
            <% if $PageLink %></a><% end_if %>
            <% if $Headline %><h3>$Headline</h3><% end_if %>
            <% if $Description %><p>$Description</p><% end_if %>
        </li>
        <% end_loop %>
    </ul>
</div>
<% end_if %>
<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<% require javascript('flexslider/thirdparty/flexslider/jquery.flexslider-min.js') %>