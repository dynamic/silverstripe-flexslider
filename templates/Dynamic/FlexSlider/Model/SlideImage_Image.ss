<% if $SlideLink %><% with $SlideLink %><a href="$LinkURL"{$TargetAttr}$ClassAttr title="$Title"><% end_with %><% end_if %>
    <% if $Image %>
        <img src="$Image.Fill(1200,600).URL" alt="<% if $Headline %>$Headline<% end_if %>">
    <% end_if %>
<% if $SlideLink %></a><% end_if %>

<% if $Headline %><h2>$Headline</h2><% end_if %>
<% if $Description %><p>$Description</p><% end_if %>
<% if $SlideLink %>
    <div>
        $SlideLink
    </div>
<% end_if %>
