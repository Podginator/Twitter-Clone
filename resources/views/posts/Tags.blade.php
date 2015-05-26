@extends('template.nav')

@section('title') 
	Tag: {{$tag}}
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection


@section('content')
<div class="container" data-tag="{{ $tag }}">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<dir-tab>
				<tab-content title="Posts">
					<div ng-controller="PostController"  ng-init="ChangeDefault(GetTags)">
						<div class="panel-heading">Posts</div>
						
						<div class="posts">
							@include('posts.post')
						</div>
				</tab-content>
			
				<tab-content title="Stories">
					<div ng-controller="StoryController" ng-init="GetStoryTags('{{ $tag }}')">
						<div class="panel-heading">Stories</div>
						
						<div class="posts">
							@include('story.story')
						</div>
					</div>
				</tab-content>
			</dir-tab>
		</div>
	</div>
</div>
@endsection
