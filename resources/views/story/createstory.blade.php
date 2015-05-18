@extends('template.nav')

@section('title') 
	{{$story->name . ' by '. $story->users->username}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')	
<div class="container" data-tag="{{ $story->name }}" ng-controller="StoryController">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default postcontainer">
				<div class="panel-heading">Story: {{$story->name}}</div>	
					
				   <form name="storyForm" ng-submit="editStory({{$story->id}})" enctype="multipart/form-data">
					<div class="panel-body">
					    <input 
							type="text" 
							class="form-control input-lg postInput"
						 	name="desc" 
							ng-model="storyData.description" 
							placeholder="Story Description."
						>
					
					<div class="panel panel-default" style="margin:15px">
						<div class="panel-heading"> Select Posts </div>
						<div class="panel-body" ng-controller="PostController" ng-init="GetTags({{$story->name}}, true)">
							<div class="panel panel-default" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation">
								<div class="storypost-<%post.id%>" ng-click="ModifyStoryPosts(post.id)">
									@include("story.postcontent")
								</div>
							</div>
						</div>
					</div>
						
						<button type="submit" class="btn btn-primary btn-lg" ng-disabled="postForm.$invalid">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
