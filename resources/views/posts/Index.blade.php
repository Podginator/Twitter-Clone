@extends('template.nav')

@section('title') 
	Stories: Posts 
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
<div class="container" ng-controller="PostController">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Twitterings or whatever</div>


					<form ng-submit="submitPost()">
				   	
				        <div class="form-group">
				            <input type="text" class="form-control input-lg" name="text" ng-maxlength="140" ng-model="postData.text" placeholder="Post to shitter.">
				       		<p><% postData.text.length != undefined ? postData.text.length : 0 %> of 140</span></p>
						</div>
				    
				        <div class="form-group text-right">   
				            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
				        </div>
				    </form>

				    <p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>
				    
				    <div class="post" ng-hide="loading" ng-repeat="post in posts">
				        <h3><% post.username %></h3>
				        <p><% post.text %></p>
				        <p ng-if="post.editable"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>
				    </div>


				<div class="panel-body">
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
