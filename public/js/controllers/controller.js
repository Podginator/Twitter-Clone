angular.module('postCtrl', [])
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
	$scope.errors = [];
	
	$scope.FileChange = function()
	{
		$scope.errors = [];
		var file =  postForm.image.files[0]
		var valid = ['mp4', 'jpg', 'png','gif'];
		var Mb = 2; 												// Change this value to assign nr of Mega bytes.
		var validSize = Mb * Math.pow( Math.pow(2,10), 2 );        	// Get value in Mb. 

		var extension = file.name.split('.').pop();
		if(valid.indexOf(extension) == -1 )
		{
			$scope.errors.push("The file you've chosen ("+file.name+") doesn't have the right extension (" + valid.join(" ") + ")");
		}
		if( file.size > validSize )
		{
			$scope.errors.push("The file you've chosen ("+file.name+") exceeds the limit of " + Mb + " Mb.");
		}
		$scope.$digest();
		
		return valid.indexOf(extension) != -1;
		
	}
	
	//This creates Post Objects from the data we get
	$scope.getAndObjectify = function(data, isRelative)
	{
		$scope.custom=false;
		$scope.posts = [];
		for (var i in data) {
			$scope.posts[i] = angular.extend(new PostObject, data[i]);
			$scope.posts[i].initialize(isRelative);
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
	
	$scope.GetPostsFromStory = function(id){
		$scope.animation = true;
		//We do a Post.Get() (Check postService.js)
		Post.GetStoryPosts(id)
			.success(function(data){
				//objectifies the success data that returns and finishes animations.
				$scope.getAndObjectify(data, true);
				$scope.animation = false;
				$scope.custom = false;
			});
		
		$scope.ActiveFunction = $scope.GetPostsFromStory;
	}
	
	var ResetControls = function()
	{
		//We then reset the postInputs
		$('.postInput').val('');
		//This is ridiculous. Workaround for Firefox.
		var control = document.getElementById("imageUploaded");
		control.value = null;
		//control = $("#imageUploaded");
		//control.replaceWith(control = control.clone( true ));
		$("#preview").hide();
		document.getElementById("preview").src = '';
		$scope.imageData.image = '';
		$scope.postData.imgID = null;
	}
	//We should extrapalote this to avoid code reuse.
	//This is where we save a post to the server.
	var PostToServer = function(postData){

		$scope.errors = [];
		
		Post.save(postData)
			.success(function (data){	
				if(data.success){
					//On success we return the default state
					$scope.GetDefault();
				}else{
					alert("Unsuccessful Post.");
				}
				ResetControls();
			})
			.error(function(data){
				for(var key in data){
				   $scope.errors.push(data[key][0]);
			    }
				
				$scope.animation = false;
				ResetControls();
				
			});
	}
	
	$scope.submitPost = function(){
		$scope.animation = true;
		//When we submit the post we get an image FormData
		var image = new FormData();
		image.append("image", postForm.image.files[0]);
		
		if(postForm.image.files[0])
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
				
				})
				.error(function(data){
				for(var key in data){
				   $scope.errors.push(data[key][0]);
			    }
				ResetControls();
				$scope.animation = false;
				return;
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
	$scope.GetTags = function(id,isRelative){
		$scope.animation = true;
		//If we don't save an id to it then we make sure that the '.container' contains a databind (ie:/tag/hashtag)
		$scope.ActiveFunction = id ? $scope.ActiveFunction : $scope.GetTags;		
		id = id ? id.replace("#", "") : $('.container').data('tag');
		console.log(id,isRelative);
		Post.GetTags(id)
			.success(function(data){
				$scope.getAndObjectify(data, isRelative);
				$scope.custom = id;
				$scope.animation = false;
			});
	};
});

