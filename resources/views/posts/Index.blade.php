@extends('template.nav')

@section('title') 
	Stories: Posts 
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
<div class="container" ng-controller="PostController"  ng-init="GetDefault()">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Twitterings or whatever</div>

				@if (Auth::user())
					<form name="postForm" ng-submit="submitPost()">
				        <div class="form-group">
				            <input type="text" class="form-control input-lg postInput" name="text" 
								maxlength="140"
								ng-maxlength="140"
								ng-model="postData.text" 
								ng-pattern="/\S*#(?:\[[^\]]+\]|\S+)/"
								placeholder="Post to shitter.">
				       		<p ng-show="!postForm.text.$invalid"><% postData.text.length != undefined ? postData.text.length : 0 %> of 140</span></p>
							<p class="text-center" ng-show="postForm.text.$dirty && postForm.text.$invalid" style="color:red;">Sheets need a HashTag! </p>
						</div>
				    
				        <div class="form-group text-right">   
				            <button type="submit" class="btn btn-primary btn-lg" ng-disabled="postData.text.length == undefined || postData.text.length == 0 || postForm.$invalid">Submit</button>
				        </div>
				    </form>
	
				@endif
					 <p class="text-center" ng-if="custom" ng-click="GetDefault()">Posts with Tag: <b> <% custom %> </b> showing. Click Text to default</p>
				    <p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>
				    
					<div class="panel panel-default"  ng-repeat="post in posts" ng-hide="animation">
					    <div class="post">
					        <div class="panel-heading"><% post.username %></div>
					        <p compile="post.adText"><% posts.adText %></p>
					        <p ng-if="post.editable"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>
							<div class ="tags" >
								<p><small> Tags <span ng-repeat= "tags in post.getTags()"><a href="#" ng-click="GetTags(tags)" > <% tags %> </a> </span></small></p>
							</div>
						</div>
				    </div>



				<div class="panel-body">
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
