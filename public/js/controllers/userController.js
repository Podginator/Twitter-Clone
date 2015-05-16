angular.module('userCtrl', [])
//Here is the logic for the Post Controller
.controller('UserController', function($scope,$http,User,Images){
	$scope.followData = {};
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
	
	$scope.submitUser = function(id){
		User.saveUser(id)
			.success(function(data){
				if(data.success){
					//Then we can unhide all the stuff.
					$('.'+id+'-nf').addClass('ng-hide');
					$('.'+id+'-f').removeClass( "ng-hide" );
				}
			});
	}

});