<p class="text-center" ng-if="custom" ng-click="ActiveFunction()">Posts with Tag: <b> <% custom %> </b> showing. Click to go back</p>
<p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>

<div class="panel panel-default" ng-repeat="post in posts" ng-hide="animation">
        <div class="panel-heading"><% post.username %></div>
        <p compile="post.adText" class = "panel-body"><% posts.adText %></p>
		<div class="img-responsive" style="padding-bottom:15px" ng-if="post.url"> <img class="img-responsive center-block" src="{{asset('<% post.url %>')}}"> </div>
        <p ng-if="post.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>

		<div class ="tags" >
			<p style="padding-left:15px"> <small> Tags <span ng-repeat= "tags in post.getTags()"><a href="#" ng-click="GetTags(tags)" > <% tags %> </a></span>  <a href = "#" ng-click = "getPost(post.id)" class = "text-muted" style="float:right; padding-right:15px">Display post</a> </small></p>
		</div>
</div>