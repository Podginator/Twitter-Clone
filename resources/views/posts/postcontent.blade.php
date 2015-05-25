 <div class="panel-heading text-muted" >
		<a class="text-muted" href="{{url('/<% post.username %>') }}">
			<!-- <img class = "thumbProPic" src = ""/> -->
			<% post.username %>
		</a>
		<span style="float:right;"><% post.relativeTime %> </span>
		@if (Auth::user())
			<span ng-show="<% post.following %> == 0 && <% post.editable %> == 0" class="<% post.username %>-nf addIndicator" ng-click="submitUser(post.username)">
				<img height='16' width="16" src="{{asset('/imgs/add.png')}}"> 
			</span>
			<span class="<% post.username %>-f addIndicator" ng-show="<% post.following %> && <% post.editable %> == 0">
				<span style = "margin-left: -10px; color: #888;" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
			</span>
		@endif
		
		  
		
	</div>

    <p compile="post.adText" class = "panel-body"><% post.adText %></p>
		
	<div style="padding-bottom:15px" ng-if="post.url" compile="post.url"> 
		
	</div>
	<p ng-if="post.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>

	<div><a href = "{{ url( 'posts/<% post.id %>') }}" style = "float: right; padding-right: 10px;" class = "text-muted">Display post</a></div>
   
	<div class ="tags" >
		<p style="padding-left:15px"> <small> Tags <span ng-repeat= "tags in post.getTags()"><a href="#" ng-click="GetTags(tags)" > <% tags %> </a></span></small></p>
	</div>
</div>
