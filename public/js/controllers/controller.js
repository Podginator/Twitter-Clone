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
	
	$scope.GetDefault = function(){
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
						if(datum.success)
						{
							$scope.getAndObjectify(data);
							$scope.animation = false;
						}
						else
						{
							alert("Error with formatting, did you have a hashtag? Does your message have >0 characters?");
							$scope.animation = false;
						}
					});
				$('.postInput').val('');
			})
			.error(function(data){
						alert("Error!");
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
					})
					.error(function(data){
						alert("Error!");
					});
            });
    };
	
	$scope.GetTags = function(id){
		$scope.animation = true;
		id = id ? id.replace("#", "") : $('.container').data('tag');
		Post.GetTags(id)
			.success(function(data){
				$scope.custom = id;
				$scope.getAndObjectify(data);
				$scope.animation = false;
			});
	};
});