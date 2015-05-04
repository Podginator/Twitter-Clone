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
				<div class="panel-heading">Your Posts</div>
				
				@if (Auth::user())
					@include('posts.form')
				@endif
				
				@include('posts.post')
					
			</div>
		</div>
	</div>
</div>
@endsection
