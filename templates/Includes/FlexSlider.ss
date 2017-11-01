<% require css('dynamic/flexslider: thirdparty/flexslider/flexslider.css') %>
<% require css('dynamic/flexslider: css/silverstripe-flexslider.css') %>
<% if $SlideShow %>
  <div class="slideshow">
    <div class="flexslider">
      <ul class="slides">
		<% loop $SlideShow %>
          <li>
			<% if $PageLink %><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><% end_if %>
			<% if $Image %>
				<img src="$Image.Fill(1200,600).URL" alt="<% if $Headline %>$Headline<% end_if %>">
			<% end_if %>
			<% if $PageLink %></a><% end_if %>

            <% if $Headline %><h2>$Headline</h2><% end_if %>
            <% if $Description %><p>$Description</p><% end_if %>
            <% if $PageLinkID %><p><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML">Learn more</a></p><% end_if %>
          </li>
  			<% end_loop %>
      </ul>
    </div>
  	<% if $ThumbnailNav && $SlideShow.Count > 1 %>
      <div class="carousel">
        <ul class="slides">
			<% loop $SlideShow %>
			  <li>
				<% if $Image %>
				  <img src="$Image.URL"  alt="$Name.XML" class="slide">
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
