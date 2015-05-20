angular.module('storyService', [])
  
  //This is the Post Factor, where the http and ajax requests happen
.factory('Story', function($http){
	return {
		//We get the posts from /api/posts, which fires the index() item in PostController
		get: function(){
			return $http.get('/api/story');
		},
		//Save grabs some data, and POSTs it to the server. This fires the store() event
		save: function(data){
			return $http({
					method: 'POST',
					url: '/api/story',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		}
	}
})
//This is where we define the story object for use in scope with Angular
//Unused.
.factory('StoryObject', function(Post, PostObject){
	function Story(name, created_at, username, id, editable, updated_at, postAmount) {
	    this.name = name;
		this.description;
	    this.created_at = created_at;
	    this.username = username;
	    this.editable = editable;
	    this.updated_at = updated_at;
	    this.id = id;
		this.postAmount = postAmount;
		this.posts = [];
  	}
	  
	Story.prototype.getPosts = function(){
		Post.getStoryPosts()
	}
	
 	return Story;
});

