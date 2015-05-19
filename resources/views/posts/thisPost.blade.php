@extends('template.nav')

@section('title') 
	Tag: post
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')
	
	<?php

	function getPostedTime($created) 				// Show dynamic post time: 
	{	
		$createdDate = date_create(date('Y-m-d', 		// Create date var. from the post. 
		strtotime($created)) );
		$currentDate = date_create(date('Y-m-d'));		// Create date var. of the current date.
		
		$diff=date_diff($createdDate,$currentDate); 	// Get the time difference.

		$d = $diff->format('%a');						// Number of days.
		$m = $diff->format('%m');						// Number of months.

		if ($d <= 31) 									// Posted the past 31 days:					
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
		else if( $m > 0 ) 								// Posted over a month ago:
			return "$m month(s), $d day(s) ago";
	}

	function splitByHashtag($Alltags) 				// Create link for each tag.
	{
		$tags = explode('#', $Alltags);					// Create array element on split hashtag(#)

		array_shift($tags);								// Since hashtag(#) is the first char in the string,
															// it will create a new empty element. Remove this.
		foreach($tags as $tag )							// Loop Through all tags and create a link.
		{
			echo "<a href = '/tag/$tag'>#$tag</a> ";
		}
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
			tags: {{ splitByHashTag($text) }} 		<!-- Get all tags with separated link. -->
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
@endsection