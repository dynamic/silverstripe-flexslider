<% if $Video %>
	$Video
<% end_if %>

<% if $Headline %><h2>$Headline</h2><% end_if %>
<% if $Description %><p>$Description</p><% end_if %>
<% if $PageLinkID %>
	<p>
		<a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><%t Dynamic\FlexSlider\ORM\FlexSlider.LEARN_MORE "Learn more" %></a>
	</p>
<% end_if %>
