angular.module('storyCtrl', [])

//Here is the logic for the Story Controller
.controller('StoryController', function($scope, $http, Story){
	$scope.storyData = {};
	$scope.animation = true;
	$scope.custom = false;
	
	//Where all the posts are formed
	$scope.stories = [];
	$scope.errors = [];
	$scope.postsToAdd = [];
	
	
/*---------------------------------------------------------------------------*/
/*								Get Story Behaviour		  					 */
/*---------------------------------------------------------------------------*/
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
	//-------------------Dette har jeg addet----------------//
	$scope.GetUserStory = function(user){
		user = user ? user : $('.container').data('user');
		$scope.animation = true;
		Story.getUserStory(user)
            .success(function(data)
			{
				$scope.stories = data;
				$scope.animation = false;
				$scope.custom = false;
            });
	},
	$scope.GetStoryTags = function(id){
		$scope.animation = true;
		//If we don't save an id to it then we make sure that the '.container' contains a databind (ie:/tag/hashtag)
		id = id ? id.replace("#", "") : $('.container').data('tag');
		Story.getTags(id)
			.success(function(data){
				$scope.stories = data;
				console.log(data);
				$scope.animation = false;
			});
	};
	//-------------------------------------------------------//
/*---------------------------------------------------------------------------*/
/*								Create Story Behaviour		  				 aa*/
/*---------------------------------------------------------------------------*/
	//submit the story.
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
	};
	
	//This is where the click on posts happen. It merely uploads postIds.
	$scope.ModifyStoryPosts = function(id)
	{
		var index = $scope.postsToAdd.indexOf(id);
		if(index == -1)
		{
			$('.storypost-'+id + ' > .well').addClass('selected');
			$scope.postsToAdd.push(id);
		}
		else{
			$('.storypost-'+id + '> .well').removeClass('selected');
			$scope.postsToAdd.splice(index,1);
		}
	};
	
	//Reset to postsToAdd on onBlur change.
	$scope.ResetPosts = function()
	{
		$scope.postsToAdd = [];
	}

/*---------------------------------------------------------------------------*/
/*								Delete  Behaviour		  					 */
/*---------------------------------------------------------------------------*/	
	
	$scope.deleteStory = function(id) {
		$scope.animation = true;
		 Story.destroy(id)
            .success(function(data) {
               	$scope.GetDefault();
            });
    };	
	
});

