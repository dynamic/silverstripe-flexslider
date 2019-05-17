<% if $SlideLink %><a href="$SlideLink.URL" title="$SlideLink.Title"><% end_if %>
<% if $Image %>
		<img src="$Image.Fill(1200,600).URL" alt="<% if $Headline %>$Headline<% end_if %>">
<% end_if %>
<% if $SlideLink %></a><% end_if %>

<% if $Headline %><h2>$Headline</h2><% end_if %>
<% if $Description %><p>$Description</p><% end_if %>
<% if $SlideLink %>
	<p>
		<a href="$SlideLink.URL" title="$SlideLink.Title"><%t Dynamic\FlexSlider\ORM\FlexSlider.LEARN_MORE "Learn more" %></a>
	</p>
<% end_if %>
