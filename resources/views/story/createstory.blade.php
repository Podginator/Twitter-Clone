@extends('template.nav')

@section('title') 
	Create a Story
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')	
<div class="container" ng-controller="StoryController" ng-init="storyData.title = Test">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default" style = "padding-bottom: 20px;">
				<div class="panel-heading">Create a story</div>	
					
					<div class="panel-body">
						<div class="alert alert-danger" ng-if="errors.length > 0">
							<strong>Sorry, there were some problems with your input..</strong><br><br>
							<ul>
								<li ng-repeat= "error in errors"><% error %></li>
							</ul>
						</div>
					</div>
						
				   <form name="storyForm" ng-submit="submitStory()" enctype="multipart/form-data">
					<div class="panel-body" ng-controller="PostController">
						  <input 
							type="text" 
							class="form-control input-lg postInput storyInput"
							ng-model="storyData.title" 
							placeholder="Story Title."
						>
						
						<input 
							type="text" 
							class="form-control input-lg postInput storyInput"
							ng-model="storyData.hashtag" 
							placeholder="Topic (Enter Hashtag without #)"
							ng-model-options="{ updateOn: 'blur' }" 
							ng-change="GetTags(storyData.hashtag, true);ResetPosts()"
						>
						
						<input 
							type="text" 
							class="form-control input-lg postInput storyInput"
						 	name="desc" 
							ng-model="storyData.description" 
							placeholder="Story Description."
						>
					
						<div class="panel panel-default" style="margin:15px">
							<div class="panel-heading"> Select Posts </div>
							<div class="panel-body">
								<div class="panel-body" ng-if="posts.length == 0"> No Posts for this topic </div>
								<div class="" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation">
									<div class="storypost-<%post.id%>" ng-click="ModifyStoryPosts(post.id)">
										@include("story.postcontent")
									</div>
								</div>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary btn-lg storyButton" ng-disabled="postForm.$invalid">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
