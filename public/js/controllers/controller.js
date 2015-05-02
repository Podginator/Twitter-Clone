angular.module('postCtrl', [])
.controller('PostController', function($scope,$http, Post, PostObject){
	$scope.postData = {}; 
	$scope.animation = true;
	$scope.posts = [];
	
	$scope.getAndObjectify = function()
	{
		Post.get()
		.success(function(data){
			for (var i in data) {
				$scope.posts[i] = angular.extend(new PostObject, data[i]);
				$scope.posts[i].createLinks();
			};
			$scope.animation = false;
		});
	}
	
	Post.get()
		.success(function(data){
			for (var i in data) {
				$scope.posts[i] = angular.extend(new PostObject, data[i]);
				$scope.posts[i].createLinks();
			};
			$scope.animation = false;
		});
		
	$scope.submitPost = function(){
		$scope.animation = true;
		Post.save($scope.postData)
			.success(function (datum){
				$scope.getAndObjectify();
				$('.postInput').val('');
			});
	};

	
	$scope.deletePost = function(id) {
		$scope.animation = true;
		 Post.destroy(id)
            .success(function(data) {
               $scope.getAndObjectify();

            });
    };
});