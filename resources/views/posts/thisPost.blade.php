@extends('template.nav')

@section('title') 
	Tag: post
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
	<div class = "col-md-6 col-md-offset-3" style = "background: #fff; padding: 2%;">

		<h4 style = "display: inline-block;">{{ $post->users->username }}</h4>

		<div style = "display: inline-block; padding-left: 30px; color: #aaa;">
			{{ $time }}									<!-- days ago -->
			<span style = "font-size: 10px;" class="glyphicon glyphicon-time" aria-hidden="true"></span>   
		</div>
		<div> 												<!-- Display text -->
			{{$post->text}}
		</div>	
		<div class = "tags" style = "padding-top: 10px;">
			<span style = " color: #aaa">#</span>
			tags: 
			@foreach ($tags as $tag)
     		 	<a href="/tag/{{ str_replace('#', '', $tag) }}"> {{$tag}} </a>
    		@endforeach			<!-- Get all tags with separated link. -->
		</div>

		<hr>
		
		@if ($post->url)
			<img src = "/{{ $post->url }}">
		@endif
		<h4><a href = "/posts" class = "goBack">
			<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
			Go back
		</a></h4>
	</div>
@endsection