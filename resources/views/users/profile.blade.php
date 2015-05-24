<div ng-controller="UserController">
	
	<ul class = "profileSidebar">
		<li>
			@if ($user->files)
				<img alt="Profile Image" src="{{asset($user->files->url)}}">
			@else
				<img alt="Profile Image" width="140" height="140" src="{{asset('/imgs/default-avatar.png')}}">
			@endif
		</li>
		<li class = "profileSidebarText">
			<span style = "color: #0ad; font-size: 125%;">{{$user->username}}</span><br>
			<!-- Get nr of posts for this user -->  n posts<br>
			<!-- Get nr of stories for this user -->  n stories
		</li>
	</ul>	
	
	
			
	<div class="panel-body" style = "background: #fff; margin-top: -10px;">
			<p><b>Bio:<br></b> {{$user->biography }} </p>
	</div>
	
	@if (Auth::user()->username != $user->username)
	<div class = "followThisUserContainer ng-hide" ng-init="isFollowing('{{$user->username}}')">

		<!-- insert if: not followed: Follow --> 
		<div class = "followThisUser {{$user->username}}-nf'" ng-click="submitUser('{{$user->username}}')" ng-if="!userFollowing">
			Follow <span class="glyphicon glyphicon-plus" style = "font-size: 75%; padding-left: 2px;" aria-hidden="true"></span>
		</div>
		<!-- Insert else followed: Unfollow -->
		<div class = "followThisUser {{$user->username}}-f'" style = "background: #dd5454;" ng-if="userFollowing">
			Unfollow <span class="glyphicon glyphicon-remove" style = "font-size: 75%; padding-left: 2px;" aria-hidden="true"></span>
		</div>

	</div>
	@endif

	@if(Auth::user() == $user)
	
		<div class="panel-body">
			@include('users.forms')
		</div>
	@endif
		
</div>

