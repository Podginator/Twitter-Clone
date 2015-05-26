angular.module('userCtrl', [])
//Here is the logic for the User Controller
.controller('UserController', function($scope,$http,User,Images){
	$scope.followData = {};
	$scope.following = [];
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
	
	User.isFollowing()
		.success(function(data){
			if(data.success){
				$scope.follow = [];
				for(var user in data.users){
				   $scope.following.push(data.users[user].username);
			    }
				$('.followThisUserContainer').removeClass('ng-hide');
			}
	});
	
	$scope.userFollows=function(username){
		return $scope.following.indexOf(username) != -1;
	};
	
	$scope.submitUser = function(id){
		User.saveUser(id)
			.success(function(data){
				if(data.success){
					$scope.following.push(id);
				}
			});
	}

	$scope.unfollowUser = function(id){
		User.removeUser(id)
			.success(function(data){
				var index = $scope.following.indexOf(id);
				$scope.following.splice(index,1);
			});
	}

});