<p class="text-center" ng-if="custom" ng-click="ActiveFunction()">Posts with Tag: <b> <% custom %> </b> showing. Click to go back</p>
<p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>

<div class="panel panel-default" ng-repeat="post in posts" ng-hide="animation">
        <div class="panel-heading text-muted"><a class="text-muted" href="{{url('/<% post.username %>') }}"><% post.username %></a></div>
        <p compile="post.adText" class = "panel-body"><% posts.adText %></p>
			
		<div class="img-responsive" style="padding-bottom:15px" ng-if="post.url"> 
			<img class="img-responsive center-block" src="{{asset('<% post.url %>')}}"> 
		</div>
		
        <div class="videoContainer" ng-if="post.ytEmbed" compile="post.ytEmbed"></div>
			

        <p ng-if="post.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>
		
		<div><a href = "#" ng-click = "GetPost(post.id)" style = "float: right; padding-right: 10px;" class = "text-muted">Display post</a></div>
       
		<div class ="tags" >
			<p style="padding-left:15px"> <small> Tags <span ng-repeat= "tags in post.getTags()"><a href="#" ng-click="GetTags(tags)" > <% tags %> </a></span></p>
		</div>
		
		
</div>