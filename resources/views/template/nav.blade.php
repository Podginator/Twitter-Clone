<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/main.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script> <!-- load angular -->
	<!-- AngularJS Loading (Production builds we'd probably .min this and put it in one file) !-->
	<script src="{{ asset('/js/main.js') }} "></script> <!-- load our controller -->
	<script src="{{ asset('/js/controllers/postcontroller.js') }} "></script> <!-- load our controller -->
	<script src="{{ asset('/js/controllers/userController.js') }} "></script> <!-- load our controller -->
	<script src="{{ asset('/js/controllers/storyController.js') }} "></script> <!-- load our controller -->
    <script src="{{ asset('/js/services/postService.js') }}"></script> <!-- load our service -->
    <script src="{{ asset('/js/services/storyService.js') }}"></script> <!-- load our service -->
	<script src="{{ asset('/js/services/userService.js') }}"></script> <!-- load our service -->
	<script src="{{ asset('/js/dirPagination.js') }}"></script> <!-- load our application -->
	<script src="{{ asset('/js/directives/dirTabs.js') }}"></script> <!-- load our application -->
	<script src="{{ asset('/js/app.js') }}"></script> <!-- load our application -->
    <script src="{{ asset('/js/search.js') }}"></script> <!-- load our SearchBar -->

    
</head>
	@yield('angularApp')
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Stories</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/posts') }}">Posts</a></li>
					<li><a href="{{ url('/story') }}">Stories</a></li>
					<li id = "searchBar">
						<input class = "searchField" placeholder = "search" type = "text"/>
						<button class = "searchButton" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
						<ul class = "searchResults"></ul>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/'.Auth::user()->username) }}">My Page</a></li>
								<li><a href="{{ url('/profile') }}">Edit Profile</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	
</body>
</html>
