<% if SlideShow %>
<div class="flexslider">
    <ul class="slides">
    	<% loop SlideShow %>
        <li class="remove-bottom">
        	<% if PageLink %><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><% end_if %>
			<% if Image %>
            	<img src="$Slide.URL"  alt="$Name.XML">
            <% end_if %>
            <% if PageLink %></a><% end_if %>
            <h4 class="detail-title flex-caption">$Name</h4>
        </li>
        <% end_loop %>
    </ul>
</div>
<% end_if %>
