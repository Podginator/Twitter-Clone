 <div class="storySelect well">
	 <div class="panel-heading text-muted">
			<a class="text-muted" href="{{url('/<% post.username %>') }}">
				<% post.username %> <span style="float:right;"> <% post.relativeTime %> </span>
			</a> 
		</div>
	    <p compile="post.adText" class = "panel-body"><% post.adText %></p>
			
		<div style="padding-bottom:15px" ng-if="post.url" compile="post.url"> 
			
		</div>
		<p ng-if="post.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>

		<div><a href = "{{ url( 'posts/<% post.id %>') }}" style = "float: right; padding-right: 10px;" class = "text-muted">Display post</a></div>
	   
		<div class ="tags" >
			<p style="padding-left:15px"> <small> Tags <span ng-repeat= "tags in post.getTags()"><a href="/tag/<% tags.replace('#', '') %>"> <% tags %> </a></span></small></p>
		</div>
	</div>
</div>