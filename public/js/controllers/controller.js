angular.module('postCtrl', [])
//This is the counter for new posts
.controller('PostCountCtrl', function($scope, Post, PostCounter){
	$scope.postCounter = 0;
	var prevCounter = 0;
	var checkFirst = true;
	//We use the PostCounter object, which fires an $interval every 15 seconds
	PostCounter.then(
		//Success(Or Finish)
		function(val){
			console.log(val);
		},

		function(err){
			console.log(err);
		},
		//Every 'tick' it sends a notify request which we then use to update the post counter.
		function(notify){
			if(!checkFirst){
				$scope.postCounter = notify.data.length - prevCounter;
			}else{
				prevCounter = notify.data.length;
				checkFirst = false;
			}
		}
	)
	
	//This FN resets the post counter.
	$scope.ResetCounter = function(){
		$scope.postCounter = 0;
		checkFirst = true;
	}
})

//Here is the logic for the Post Controller
.controller('PostController', function($scope,$http, Post, PostObject, Images){
	//We have Form Objects in the form of Post and Image Data
	$scope.postData = {};
	$scope.imageData = {}; 
	//This is where angular decides to show animations and custom hashtags names
	$scope.animation = true;
	$scope.custom = false;
	//Where all the posts are formed
	$scope.posts = [];
	
	//This creates Post Objects from the data we get
	$scope.getAndObjectify = function(data)
	{
		$scope.custom=false;
		$scope.posts = [];
		for (var i in data) {
			$scope.posts[i] = angular.extend(new PostObject, data[i]);
			$scope.posts[i].initialize();
		};
	}
	
	$scope.ActiveFunction = null;
	
	//This is where we get the default 
	$scope.GetDefault = function(){
		$scope.animation = true;
		//We do a Post.Get() (Check postService.js)
		Post.get()
			.success(function(data){
				//objectifies the success data that returns and finishes animations.
				$scope.getAndObjectify(data);
				$scope.animation = false;
				$scope.custom = false;
			});
		
		$scope.ActiveFunction = $scope.GetDefault;
	}
	
	//We should extrapalote this to avoid code reuse.
	//This is where we save a post to the server.
	var PostToServer = function(postData){
		Post.save(postData)
			.success(function (data){	
				if(data.success){
					//On success we return the default state
					$scope.GetDefault();
				}else{
					alert("Unsuccessful Post.");
				}
				//We then reset the postInputs
				$('.postInput').val('');
				//This is ridiculous. Workaround for Firefox.
				var control = document.getElementById("imageUploaded");
				control.value = null;
				control = $("#imageUploaded");
				control.replaceWith(control = control.clone( true ));
				$("#preview").hide();
				document.getElementById("preview").src = '';
				$scope.imageData = {};
				$scope.postData.imgID = null;
			})
			.error(function(data){
						alert("Error!");
					});
	}
	
	$scope.submitPost = function(){
		$scope.animation = true;
		//When we submit the post we get an image FormData
		var image = new FormData();
		image.append("image", postForm.image.files[0]);
		
		//Check if it's saved
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
						//Then post to server with img id
						PostToServer($scope.postData);
					}
				});
		}
		else{
			$scope.postData.imgID = null;
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
	
	/*-------------------*/
	
	$scope.GetPost = function(id)
	{
		$scope.animation = true;
		
		Post.GetPost(id).success(function(data)
		{
			console.log('controller, success: ' + data);
			$scope.GetDefault();
		})
	};
	
	/*-------------------*/
	
	$scope.GetUserPost = function(user)
	{
		$scope.ActiveFunction = user ? $scope.ActiveFunction : $scope.GetUserPost;		
		user = user ? user : $('.container').data('user');
		$scope.animation = true;
		Post.GetUserPost(user)
            .success(function(data)
			{

				$scope.getAndObjectify(data);
				$scope.animation = false;
            });
	}
	
	
	//We get posts with the specific tag
	$scope.GetTags = function(id){
		$scope.animation = true;
		//If we don't save an id to it then we make sure that the '.container' contains a databind (ie:/tag/hashtag)
		$scope.ActiveFunction = id ? $scope.ActiveFunction : $scope.GetTags;		
		id = id ? id.replace("#", "") : $('.container').data('tag');
		Post.GetTags(id)
			.success(function(data){
				$scope.getAndObjectify(data);
				$scope.custom = id;
				$scope.animation = false;
			});
	};
});

