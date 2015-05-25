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
			return $http({
					method: 'POST',
					url: '/api/posts',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		},
		//Fires the destroy even and gets post id.
		destroy: function(id){
			return $http.delete('/api/posts/'+id);
		},
		//We get the tag from the api at PostController@getTags
		getTags: function(tag){
			return $http.get('/api/posts/'+tag);
		},
		// Get the post id from the API at PostController@getPost
		getPost: function(id) 	
		{
			return $http.get('/api/posts/id/' + id);
		},
		
		getStoryPosts: function(id)
		{
			return $http.get('/api/story/posts/'+id);
		},
		
		getUserPost: function(user)
		{
			return $http.get('/api/posts/user/' + user);
		}
		
	}
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
		this.following = null;
		this.ytEmbed = null;
		this.relativeTime = null;
  	}

	//We get the tags here, by matching the tags against a regex statement.
	Post.prototype.getTags = function() {
	  return (this.text.match(/#(\[[\w\s]+\])|#(\w+)/g)) ? this.text.match(/#(\[[\w\s]+\])|#(\w+)/g) : [];
	};
	
	//We create a tag out of these statements
	Post.prototype.createLinks = function(isRelative){
	  var tags = this.getTags();
	
	  //We need to escape the HTML, because we are trusting this as html. 
	  var text = this.text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	  //this is that Adjusted Text, we do this so that we don't modify the original object (If it needs to be used elsewhere.) 
	  this.adText = text;
	  //We then go through tags and replace things with lings.
	  for(var tag in tags){
		  var str = tags[tag];
		 if(isRelative){
 		  	text = text.replace(str, "<a href='/tag/"+str.replace("#", '') +"'>" + str + "</a>");
		 }else {
		  	text = text.replace(str, "<a href='#' ng-click='GetTags(\""+str+"\")'>" + str + "</a>");
		 }
		  this.adText = text;
	  }
	}
	
	Post.prototype.GetMediaHTML = function(){
			if(this.url == null)
			{
				return;
			}
			var url = this.url;
			var extension = url.split('.').pop();
			
			if(extension == "mp4" || extension == "ogg")
			{
				this.url='<video width="100%" controls>\
							  <source src="'+this.url+'" type="video/'+ extension +'">\
							Your browser does not support the video tag.\
							</video>';
			} else {
				this.url = "<img class='img-responsive center-block' src='"+this.url+"')}}'>";
			}
	}
	
	Post.prototype.hasYouTube = function(){
		if(this.url != null || this.url != undefined)
		{
			//We already have some media in this post and we therefore don't need more.
			return;
		}
		
		//Next we detect if there's an applicable youtube link.
		var regex = /\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i;
		var yt = regex.exec(this.text);
		
		if(yt && yt[0].length > 0)
		{
			this.url  = '<div class="videoContainer"><iframe class="video" src="http://www.youtube.com/embed/' + yt[1] + '" frameborder="0" allowfullscreen></div>';
		}
	}
	Post.prototype.initialize = function(isRelative){
		this.createLinks(isRelative);
		this.GetMediaHTML();
		this.hasYouTube();
		//Should maybe be called in a ctor.
	}
		
 	return Post;
});