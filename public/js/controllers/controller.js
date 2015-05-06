angular.module('postCtrl', [])

.controller('PostCountCtrl', function($scope, Post, PostCounter){
	$scope.postCounter = 0;
	var prevCounter = 0;
	var checkFirst = true;
	
	PostCounter.then(
		//Success(Or Finish)
		function(val){
			console.log(val);
		},

		function(err){
			console.log(err);
		},
		function(notify){
			console.log("Tick");
			if(!checkFirst){
				$scope.postCounter = notify.data.length - prevCounter;
				console.log($scope.postCounter);
			}else{
				prevCounter = notify.data.length;
				checkFirst = false;
			}
		}
	)
	
	$scope.ResetCounter = function(){
		$scope.postCounter = 0;
		checkFirst = true;
	}
})

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
			.success(function (data){	
				if(data.success){
					$scope.GetDefault();
				}else{
					alert("Unsuccessful Post.");
				}
				
				$('.postInput').val('');
				$("#imageUploaded").val('');
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
			//Since these functions run asynchrnously we need to 
			//Make sure that we only run PostToServer after we have a success
			//Message to ensure that we have the correct ID after upload.
			Images.save(image)
				.success(function(data){
					if(data.success)
					{
						//Add imgID to the FormData we are sending to the server.
						$scope.postData.imgID = data.id;
						PostToServer($scope.postData);
					}
				});
		}
		else{
			//If there's no image then we post the normal PostToServer
			PostToServer($scope.postData);
		}
	};
	
	$scope.deletePost = function(id) {
		$scope.animation = true;
		 Post.destroy(id)
            .success(function(data) {
               	$scope.GetDefault();
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