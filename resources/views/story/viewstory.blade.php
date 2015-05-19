@extends('template.nav')

@section('title') 
	{{$story->name . ' by '. $story->users->username}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')	
<div class="container">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default postcontainer" ng-controller="PostController" ng-init="GetPostsFromStory({{$story->id}})">
				<div class="panel-heading">Story: {{$story->name}}({{$story->hashtag}})</div>	
				    <p class="panel-body">{{$story->description}}</p>
					
					<div class="panel-body">
						<div class="panel panel-default" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation">
									@include("story.postcontent")
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
