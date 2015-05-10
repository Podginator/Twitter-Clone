angular.module('postService', [])


//So we need to be able VIEW html content in our app
//but on top of this, it'll have a click component to it
//So we need to compile too. 
//Hence, NG-HTML-COMPILE.
.directive('compile', ['$compile', function ($compile) {

  return function(scope, element, attribute) {
	  //Here we set up a watch on a variable, in this instance it's the directives 
	  //attribute. 
	scope.$watch(
		//Here is where we get the attr, and compile it, revealing it's value
      function(scope) {
        return scope.$eval(attribute.compile);
      },
	  //We then pass it to a callback, where we append the html to then element it was
	  //a part of, then compile the element. This is important. 
      function(value) {
        element.html(value);
        $compile(element.contents())(scope);
      }
   )};
  }])
  
  //This is the Post Factor, where the http and ajax requests happen
.factory('Post', function($http){
	return {
		//We get the posts from /api/posts, which fires the index() item in PostController
		get: function(){
			return $http.get('/api/posts');
		},
		//Save grabs some data, and POSTs it to the server. This fires the store() event
		save: function(data){
			console.log(data);
			return $http({
					method: 'POST',
					url: '/api/posts',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		},
		//Fires the destroy even and gets post id.
		destroy: function(id){
			return $http.delete('/api/posts/' + id);
		},
		//We get the tag from the api at PostController@getTags
		GetTags: function(tag){
			console.log(tag);
			return $http.get('/api/posts/'+tag);
		},
		// Get the post id from the API at PostController@getPost
		 GetPost: function(id) 	
		{
			return $http.get('/api/posts/' + id);
		}
		
	}
})

//A simple factory that sends a request every 15seconds to inform the client
//as to whether there are any new posts.
.factory('PostCounter', function($http, $interval, $q, Post){
	var posts = {};
	var deferred = $q.defer();
	
	//Set an interval every 5 minutes. 
	//Defer this (so that it's not Asynchronous data anymore.)
	$interval(function(){
		Post.get()
			.then(function(data){
				deferred.notify(data);
			});
	}, 15000);
	
	//Return the promise each time.
	return deferred.promise;
	
})

.factory('Images', function($http){
	//Where we post the image.
	return{
		save: function(image){
			return $http.post('/api/images', image, {
		        withCredentials: true,
		        headers: {'Content-Type': undefined },
		        transformRequest: angular.identity
		    });
		}
	}
})

//This is where we define the post object for use in scope with Angular
.factory('PostObject', function($sce){
	function Post(text, created_at, username, id, editable, url, updated_at) {
	    this.text = text;
		this.adText = "";
	    this.created_at = created_at;
	    this.username = username;
	    this.editable = editable;
	    this.updated_at = updated_at;
	    this.id = id;
		this.url = url;
  	}

	//We get the tags here, by matching the tags against a regex statement.
	  Post.prototype.getTags = function() {
	      return (this.text.match(/#(\[[\w\s]+\])|#(\w+)/g)) ? this.text.match(/#(\[[\w\s]+\])|#(\w+)/g) : [];
	  };
	  
	  //We create a tag out of these statements
	  Post.prototype.createLinks = function(){
		  var tags = this.getTags();
		
		  //We need to escape the HTML, because we are trusting this as html. 
		  var text = this.text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		  //this is that Adjusted Text, we do this so that we don't modify the original object (If it needs to be used elsewhere.) 
		  this.adText = text;
		  //We then go through tags and replace things with lings.
		  for(var tag in tags){
			  var str = tags[tag];
			  text = text.replace(str, "<a href='#' ng-click='GetTags(\""+str+"\")'>" + str + "</a>");
			  this.adText = text;
		  }
  }
  
  return Post;
});