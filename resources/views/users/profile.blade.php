<div class="panel panel-default" ng-controller="UserController">
	<div class="panel-heading">{{$user->username}}</div>
	
	<div class="row text-center panel-body">
			@if ($user->files)
				<img alt="Profile Image" width="140" height="140" src="{{asset($user->files->url)}}">
			@else
				<img alt="Profile Image" width="140" height="140" src="{{asset('/imgs/default-avatar.png')}}">
			@endif
	</div>
	<div class="panel-body">
			<p> {{$user->biography }} </p>
	</div>
	
	@if(Auth::user() == $user)
	
		<div class="panel-body">
			@include('users.forms')
		</div>
	@endif
		
</div>

