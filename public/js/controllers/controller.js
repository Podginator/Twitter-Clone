angular.module('postCtrl', [])
.controller('PostController', function($scope,$http, Post, PostObject){
	$scope.postData = {}; 
	$scope.animation = true;
	$scope.custom = false;
	$scope.posts = [];
	
	$scope.getAndObjectify = function(data)
	{
		$scope.posts = [];
		for (var i in data) {
			$scope.posts[i] = angular.extend(new PostObject, data[i]);
			$scope.posts[i].createLinks();
		};
	}
	
	$scope.GetDefault = function()
	{
		$scope.animation = true;
		Post.get()
			.success(function(data){
				$scope.getAndObjectify(data);
				$scope.animation = false;
				$scope.custom = false;
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
               Post.get()
					.success(function(data){
						$scope.getAndObjectify(data);
						$scope.animation = false;
					});
            });
    };
	
	$scope.GetTags = function(id){
		$scope.animation = true;
		
		console.log(id);
		
		id = id ? id.substr(1,id.length) : $('.container').data('tag');
		
		Post.GetTags(id)
			.success(function(data){
				$scope.custom = id;
				$scope.getAndObjectify(data);
				$scope.animation = false;
			});
	};
});