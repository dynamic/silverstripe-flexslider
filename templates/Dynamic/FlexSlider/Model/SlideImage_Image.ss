<% if $PageLink %><a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><% end_if %>
<% if $Image %>
		<img src="$Image.Fill(1200,600).URL" alt="<% if $Headline %>$Headline<% end_if %>">
<% end_if %>
<% if $PageLink %></a><% end_if %>

<% if $Headline %><h2>$Headline</h2><% end_if %>
<% if $Description %><p>$Description</p><% end_if %>
<% if $PageLinkID %>
	<p>
		<a href="$PageLink.Link" title="$PageLink.MenuTitle.XML"><%t Dynamic\FlexSlider\ORM\FlexSlider.LEARN_MORE "Learn more" %></a>
	</p>
<% end_if %>
