angular.module('storyCtrl', [])

//Here is the logic for the Story Controller
.controller('StoryController', function($scope, $http, Story){
	$scope.storyData = {};
	$scope.animation = true;
	$scope.custom = false;
	
	//Where all the posts are formed
	$scope.stories = [];
	$scope.errors = [];
	$scope.postsToAdd = []
	
	$scope.GetDefault = function(){
		$scope.animation = true;
		//We do a Post.Get() (Check postService.js)
		Story.get()
			.success(function(data){
				//objectifies the success data that returns and finishes animations.
				$scope.stories = data;
				$scope.animation = false;
				$scope.custom = false;
			});
	}
	
	$scope.ModifyStoryPosts = function(id)
	{
		var index = $scope.postsToAdd.indexOf(id);
		if(index == -1)
		{
			$('.storypost-'+id).addClass('selected');
			$scope.postsToAdd.push(id);
		}
		else{
			$('.storypost-'+id).removeClass('selected');
			$scope.postsToAdd.splice(index,1);
		}
	}
	
	$scope.submitStory = function()
	{
		$scope.errors = [];
		$scope.storyData.posts = $scope.postsToAdd;
		Story.save($scope.storyData)
			.success(function (data){	
				console.log(data);
				if(data.success){
					window.location.replace("/story/" + data.id);
				}else{
					alert("Unsuccessful Story.");
				}
			})
			.error(function(data){
				for(var key in data){
				   $scope.errors.push(data[key][0]);
			    }
				
				
			});
	}
	
	$scope.SetName = function(val)
	{
		$scope.storyData.title=val;
	}
	
	$scope.ResetPosts = function()
	{
		$scope.posts = [];
	}
	$scope.editStory = function(id)
	{
		$scope.storyData.posts = $scope.postsToAdd;
		console.log($scope.storyData);
		Story.edit(id, $scope.storyData)
			.success(function (data){	
				console.log(data);
				if(data.success){
					console.log(data);
					//window.location.replace("/story/edit/" + data.id);
				}else{
					alert("Unsuccessful Story.");
				}
			})
			.error(function(data){
				for(var key in data){
				   $scope.errors.push(data[key][0]);
			    }	
			});
	}
	
});

