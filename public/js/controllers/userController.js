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
				for(var user in data.users){
					console.log(data.users[user]);
				   $scope.following.push(data.users[user].username);
			    }
				$('.followThisUserContainer').removeClass('ng-hide');
			}
	});
	
	$scope.userFollows=function(username){
		console.log($scope.following.indexOf(username));
		return $scope.following.indexOf(username) != -1;
	};
	
	$scope.submitUser = function(id){
		User.saveUser(id)
			.success(function(data){
				if(data.success){
					//Then we can unhide all the stuff.
					$('.'+id+'-nf').addClass('ng-hide');
					$('.'+id+'-f').removeClass( "ng-hide" );
					$scope.userFollowing=true;
				}
			});
	}

});