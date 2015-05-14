angular.module('userCtrl', [])
//Here is the logic for the Post Controller
.controller('UserController', function($scope,$http,User,Images){
	$scope.followData = {};
	$scope.submitFollow = function(){
		console.log("TurnDownForWhat");
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

});