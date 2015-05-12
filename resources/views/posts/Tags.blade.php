@extends('template.nav')

@section('title') 
	Tag: {{$tag}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
<div class="container" ng-controller="PostController" data-tag="{{ $tag }}" data-ng-init="GetTags()">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default posts">
				<div class="panel-heading">All posts with Tag: #{{$tag}}</div>
			   		@include('posts.post');
			</div>
		</div>
	</div>
</div>
@endsection
