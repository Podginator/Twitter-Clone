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
			<div class="panel-default" ng-controller="PostController" ng-init="GetPostsFromStory({{$story->id}})">
				<div class="panel-heading">Story: {{$story->name}} (#{{$story->hashtag}})</div>	
				    <div class="panel panel-body">{{$story->description}}</div>
					
					<div class="panel-body">
						<div class="panel-default" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation">
									@include("story.postcontent")
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
