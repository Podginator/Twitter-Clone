<div ng-controller="UserController">
	
	<ul class = "profileSidebar">
		<li>
			@if ($user->files)
				<img alt="Profile Image" src="{{asset($user->files->url)}}">
			@else
				<img alt="Profile Image" src="{{asset('/imgs/default-avatar.png')}}">
			@endif
		</li>
		<li class = "profileSidebarText">
			<span style = "color: #0ad; font-size: 125%;">{{$user->username}}</span><br>
			{{count($user->post)}} post(s)<br>
			{{count($user->story)}} storie(s)
		</li>
	</ul>	
	
	
			
	<div class="panel-body" style = "background: #fff; margin-top: -10px;">
			<p><b>Bio:</b><br> {{$user->biography }} </p>
	</div>
	
	@if (Auth::user() && Auth::user()->username != $user->username)
	<div class = "followThisUserContainer ng-hide">
		<div class = "followThisUser {{$user->username}}-nf'" ng-click="submitUser('{{$user->username}}')" ng-show="!userFollows('{{$user->username}}')">
			Follow <span class="glyphicon glyphicon-plus" style = "font-size: 75%; padding-left: 2px;" aria-hidden="true"></span>
		</div>
		<div class = "followThisUser {{$user->username}}-f'" ng-click="unsubmitUser('{{$user->username}}')" style = "background: #dd5454;" ng-show="userFollows('{{$user->username}}')">
			Unfollow <span class="glyphicon glyphicon-remove" style = "font-size: 75%; padding-left: 2px;" aria-hidden="true"></span>
		</div>

	</div>
	@endif

	@if(Auth::user() == $user)
	
		<div class="followForm panel-body">
			@include('users.forms')
		</div>
	@endif
		
</div>

