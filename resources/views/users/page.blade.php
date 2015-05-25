@extends('template.nav')

@section('title') 
	{{$user->username}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
<div class="container"  ng-controller="StoryController"  data-user="{{ $user->username }}"  ng-init="GetUserStory('{{$user->username}}')">
	<div class="row">
		@if($user)
			<div class="col-md-4">
				@include('users.profile', array("user"=>$user))
			</div>
			<div class="col-md-8 ">
		@else
			<div class="col-md-10 col-md-offset-1">
		@endif

			<div class="panel panel-default postcontainer">
				<div class="tabSelecter"> 
					<ul>
						<li class="storyTab selector active"> Stories </li>
						<li class="postTab selector inactive"> Posts </li>
					</ul>
			
					<div class="storyTab active">
						<div class="panel-heading">{{$user->username}}s Stories</div>
						
						<div class="posts">
							@include('story.story')
						</div>
					</div>
					
					<div class="postTab inactive" ng-controller="PostController"  ng-init="ChangeDefault(GetUserPost)">
						<div class="panel-heading">{{$user->username}}s Posts</div>
						
						<div class="posts">
							@include('posts.post')
						</div>
					</div>
				</div>
						
			</div>
		</div>
	</div>
</div>

@endsection
