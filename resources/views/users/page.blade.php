@extends('template.nav')

@section('title') 
	{{$user->username}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')

<div class="container" ng-controller="PostController"  data-user="{{ $user->username }}"  ng-init="ChangeDefault(GetUserPost)">
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
				<div class="panel-heading">{{$user->username}}s Posts</div>
				
				<div class="posts">
					@include('posts.post')
				</div>
					
			</div>
		</div>
	</div>
</div>
@endsection
