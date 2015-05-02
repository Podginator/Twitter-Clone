angular.module('postCtrl', [])
.controller('PostController', function($scope,$http, Post, PostObject){
	$scope.postData = {}; 
	$scope.animation = true;
	$scope.posts = [];
	
	$scope.getAndObjectify = function(data)
	{
		for (var i in data) {
			$scope.posts[i] = angular.extend(new PostObject, data[i]);
			$scope.posts[i].createLinks();
		};
	}
	
	$scope.GetDefault = function()
	{
		Post.get()
			.success(function(data){
				$scope.getAndObjectify(data);
				$scope.animation = false;
			});
	}
	$scope.submitPost = function(){
		$scope.animation = true;
		Post.save($scope.postData)
			.success(function (datum){
				Post.get()
					.success(function(data){
						$scope.getAndObjectify(data);
						$scope.animation = false;
					});
				$('.postInput').val('');
			});
	};
	
	$scope.deletePost = function(id) {
		$scope.animation = true;
		 Post.destroy(id)
            .success(function(data) {
               $scope.getAndObjectify(data);

            });
    };
	
	$scope.GetTags = function(){
		$scope.animation = true;
		Post.GetTags($('.container').data('tag'))
			.success(function(data){
				console.log("Hey");
				$scope.getAndObjectify(data);
				$scope.animation = false;
			});
		return $scope.posts;
	};
});