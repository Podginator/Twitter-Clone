@extends('template.nav')

@section('title') 
	Stories: Posts 
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')

<div class="container" ng-controller="PostController"  ng-init="ChangeDefault(GetDefault)">
	<div class="row">
		@if(Auth::user())
			<div class="col-md-4">
				@include('users.profile', array("user"=>Auth::user()))
			</div>
			<div class="col-md-8 ">
		@else
			<div class="col-md-10 col-md-offset-1">
		@endif

			<div class="panel panel-default postcontainer">
				
				@if (Auth::user())
					@include('posts.form')
				@endif
				
				<div class="panel-heading">Posts feed</div>

				
				<div class="posts">
					@include('posts.post')
				</div>
					
			</div>
		</div>
	</div>
</div>
@endsection
