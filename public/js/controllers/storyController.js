angular.module('storyCtrl', [])

//Here is the logic for the Story Controller
.controller('StoryController', function($scope, $http, Story){
	$scope.storyData = {};
	$scope.animation = true;
	$scope.custom = false;
	
	//Where all the posts are formed
	$scope.stories = [];
	$scope.errors = [];
	
	$scope.GetDefault = function(){
		$scope.animation = true;
		//We do a Post.Get() (Check postService.js)
		Story.get()
			.success(function(data){
				//objectifies the success data that returns and finishes animations.
				$scope.getAndObjectify(data);
				$scope.animation = false;
				$scope.custom = false;
			});
		
		$scope.ActiveFunction = $scope.GetDefault;
	}
});

