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
		},
		//Fires the destroy even and gets story id.
		destroy: function(id){
			return $http.delete('/api/story/'+id);
		},
			//------------Dette har jeg addet ------------//
			getUserStory: function(user)
		{
			return $http.get('/api/story/user/' + user);
		}
		//-----------------------------------------------//
	}
});
