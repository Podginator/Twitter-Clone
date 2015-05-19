 <div class="panel-heading text-muted" >
	 	<span><a href = "{{ url( 'story/<% story.id %>') }}" class = "text-muted"> <% story.name %> (#<% story.hashtag %>) </a> </span>
		<a style="float:right" class="text-muted" href="{{url('/<% story.username %>') }}">
			by: <% story.username %>
		</a> 
	</div>
    <p class = "panel-body"><% story.description %></p>
		
	<div style="padding-bottom:15px" ng-if="post.url" compile="post.url"> 
		
	</div>
	<p ng-if="story.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deleteStory(story.id)" class="text-muted">Delete</a></p>

	<div><a href = "{{ url( 'story/<% story.id %>') }}" style = "float: right; padding-right: 10px;" class = "text-muted">Display story</a></div>
   
	<div class ="tags" >
		<p style="padding-left:15px"> <small> Posts in this Story: <span> <% story.PostAmount %> </span></small></p>
	</div>
</div>