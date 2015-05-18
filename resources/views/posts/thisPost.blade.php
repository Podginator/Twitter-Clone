@extends('template.nav')

@section('title') 
	Tag: post
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
<h4>This post, ID: {{ $id }} </h4>
<h3><a href = "/posts" class = "text-muted">Go back</a></h3>
<hr>

<!--@extends('template.nav')



@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
	<h1>
		Hellu this is the content section.
	</h1>
@endsection -->

<p class="text-center" ng-if="custom" ng-click="ActiveFunction()">Posts with Tag: <b> <% custom %> </b> showing. Click to go back</p>
<p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>

<div class="panel panel-default" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation" ng-controller="UserController">
        <div class="panel-heading text-muted" >
			<a class="text-muted" href="{{url('/<% post.username %>') }}">
				<% post.username %>
			</a> 
			@if (Auth::user())
				<span ng-show="<% post.following %> == 0 && <% post.editable %> == 0" class="<% post.username %>-nf addIndicator" ng-click="submitUser(post.username)">
					<img height='16' width="16" src="{{asset('/imgs/add.png')}}"> 
				</span>
				<span class="<% post.username %>-f addIndicator" ng-show="<% post.following %> && <% post.editable %> == 0">
					<img height='16' width="16" src="{{asset('/imgs/added.png')}}">  
				</span>
			@endif
		</div>
        <p compile="post.adText" class = "panel-body"><% post.adText %></p>
			
		<div style="padding-bottom:15px" ng-if="post.url" compile="post.url"> 
			
		</div>
		<p ng-if="post.editable" style="float:right; margin-right:10px;"><a href="#" ng-click="deletePost(post.id)" class="text-muted">Delete</a></p>

		<div><a href = "/posts" style = "float: right; padding-right: 10px;" class = "text-muted">Go back</a></div>
       
		<div class ="tags" >
			<p style="padding-left:15px"> <small> Tags <span ng-repeat= "tags in post.getTags()"><a href="#" ng-click="GetTags(tags)" > <% tags %> </a></span></small></p>
		</div>
</div>

@endsection
