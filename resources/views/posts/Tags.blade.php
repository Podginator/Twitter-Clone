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
			<div class="panel panel-default">
				<div class="panel-heading">All posts with Tag: #{{$tag}}</div>

				    <p class="text-center" ng-if="animation"><img src="{{asset('imgs/loader.gif')}}" height="50" width="50" ></p>
				    <div class="panel panel-default"  ng-repeat="post in posts">
					    <div class="post" ng-hide="loading">
				        <div class="panel-heading"><% post.username %></div>
					        <p htmlcompile="post.adText"></p>
					        <p ng-if="post.editable"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>
							<div class ="tags" >
								<p><small> Tags <span ng-repeat= "tags in post.getTags()"><% tags %> </span></small></p>
							</div>
						</div>
				    </div>


				<div class="panel-body">
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
