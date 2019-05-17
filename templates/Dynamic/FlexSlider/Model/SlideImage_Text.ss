<% if $Headline %><h2>$Headline</h2><% end_if %>
<% if $Description %><p>$Description</p><% end_if %>
<% if $SlideLink %>
	<p>
		<a href="$SlideLink.URL" title="$SlideLink.Title"><%t Dynamic\FlexSlider\ORM\FlexSlider.LEARN_MORE "Learn more" %></a>
	</p>
<% end_if %>
