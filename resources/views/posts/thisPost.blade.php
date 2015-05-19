@extends('template.nav')

@section('title') 
	Tag: post
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
	
	<?php

	function getPostedTime($created)
	{
		$createdDate = date_create(date('Y-m-d', strtotime($created)) );
		$currentDate = date_create(date('Y-m-d'));
		
		$diff=date_diff($createdDate,$currentDate);

		$d = $diff->format('%a');	// nr of days.
		$m = $diff->format('%m');	// nr of months.

		if ($d <= 31)
		{
			switch($d)
			{
				case 0:		     			return 'Today'; 		break;
				case 1:		     			return 'Yesterday'; 	break;
				case ($d < 7):   		    return $d ." days ago"; break;
				case ($d >= 7 && $d < 14):  return '1 week ago'; 	break;
				case ($d >= 14 && $d < 21): return '2 weeks ago'; 	break;
				case ($d >= 21 && $d < 28): return '3 weeks ago'; 	break;
				case ($d >= 28):  			return '4 weeks ago'; 	break;
			}
		}
		else if( $m > 0 )
			return "$m months, $d day(s) ago";
	}

	?>
	<div class = "col-md-2 col-md-offset-2">

		<h4 style = "display: inline-block;">{{ $username }}</h4>

		<div style = "display: inline-block; padding-left: 30px; color: #aaa;">
			{{ getPostedTime($created_at) }}									 <!-- days ago -->
			<span style = "font-size: 10px;" class="glyphicon glyphicon-time" aria-hidden="true"></span>   
		</div>

		<div class = "tags">
			<span style = " color: #aaa">#</span>
			tags: <a href = "/posts/{{ $text }}">{{$text}}</a>
		</div>

		<hr>

		<h4><a href = "/posts" class = "goBack">
			<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
			Go back
		</a></h4>
	</div>

	<div class = "col-md-6 col-md-offset-1">
		<img src = {{ $url }}>
	</div>

	<!--

	<p class="text-center" ng-if="custom" ng-click="ActiveFunction()">Posts with Tag: <b> <% custom %> </b> showing. Click to go back</p>
	<p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>

	<div class="panel panel-default" dir-paginate="post in posts | itemsPerPage: 10" ng-hide="animation" ng-controller="UserController">
	       @include("posts.postcontent");
	</div>

	-->
@endsection