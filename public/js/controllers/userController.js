angular.module('userCtrl', [])
//Here is the logic for the Post Controller
.controller('UserController', function($scope,$http,User,Images){
	$scope.followData = {};
	$scope.userFollowing = false;
	$scope.submitFollow = function(){
		User.save($scope.followData)
			.success(function(data){
				console.log("Err");
				if(data.success)
				{
					alert("Added a Follow Event");
				}
				else
				{
					alert("Err");
				}
			})
	};
	
	$scope.isFollowing= function(username){
		User.isFollowing(username)
			.success(function(data){
				$scope.userFollowing = data.following;	
				$('.followThisUserContainer').removeClass('ng-hide');
			});
	}
	
	$scope.submitUser = function(id){
		User.saveUser(id)
			.success(function(data){
				if(data.success){
					console.log("hey");
					//Then we can unhide all the stuff.
					$('.'+id+'-nf').addClass('ng-hide');
					$('.'+id+'-f').removeClass( "ng-hide" );
					$scope.userFollowing=true;
				}
			});
	}

});