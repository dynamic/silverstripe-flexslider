<% if $SlideLink %><% with $SlideLink %><a href="$LinkURL"{$TargetAttr}$ClassAttr title="$Title"><% end_with %><% end_if %>
    <% if $Image %>
        <img src="$Image.Fill(1200,600).URL" alt="<% if $Headline %>$Headline<% end_if %>" class="card-img-top">
    <% end_if %>
<% if $SlideLink %></a><% end_if %>
<div class="card-body">
<% if $Headline %><h2 class="card-title">$Headline</h2><% end_if %>
<% if $Description %><p class="card-text">$Description</p><% end_if %>
<% if $SlideLink %>
    <div>
        $SlideLink
    </div>
<% end_if %>
</div>
