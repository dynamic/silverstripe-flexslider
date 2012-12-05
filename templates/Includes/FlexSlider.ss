<% if SlideList %>
<div class="flexslider">
    <ul class="slides">
    	<% loop SlideList %>
        <li class="remove-bottom">
			<% if Image %>
            	<img src="$Image.CroppedImage(960,450).URL"  alt="$Name.XML">
            <% end_if %>
            <h4 class="detail-title flex-caption">$Name</h4>
        </li>
        <% end_loop %>
    </ul>
</div>
<% end_if %>
