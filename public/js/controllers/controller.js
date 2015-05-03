angular.module('postCtrl', [])
.controller('PostController', function($scope,$http, Post, PostObject, Images){
	$scope.postData = {};
	$scope.imageData = {}; 
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
	
	//We should extrapalote this to avoid code reuse.
	var PostToServer = function(postData){
		Post.save(postData)
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
	}
	
	
	$scope.submitPost = function(){
		$scope.animation = true;
		
		var image = new FormData();
		image.append("image", postForm.image.files[0]);
		
		if($scope.imageData.image)
		{
			Images.save(image)
				.success(function(data){
					if(data.success)
					{
						$scope.postData.imgID = data.id;
						PostToServer($scope.postData);
					}
				});
		}
		else{
			PostToServer($scope.postData);
		}

		
		console.log($scope.postData, "Hey");
		
		//We then try to save the Post.
		
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