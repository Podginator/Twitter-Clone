<div class="panel panel-default" ng-controller="UserController">
	<div class="panel-heading">{{$user->username}}</div>
	
	<div class="row text-center panel-body">
			<img alt="140x140" src="http://lorempixel.com/140/140/" class="i">
	</div>
	<div class="panel-body">
			<p> User Bio </p>
	</div>
	
	<div class="panel-body">
		@include('users.forms')
	</div>
		
</div>

