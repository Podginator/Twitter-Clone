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
  
.factory('Post', function($http){
	return {
		get: function(){
			return $http.get('/api/posts');
		},
		save: function(data){
			console.log(data);
			return $http({
					method: 'POST',
					url: '/api/posts',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		},
		destroy: function(id){
			return $http.delete('/api/posts/' + id);
		},
		GetTags: function(tag){
			console.log(tag);
			return $http.get('/api/posts/'+tag);
		}
	}
})

.factory('PostObject', function($sce){
	function Post(text, created_at, username, id, editable, imgId, updated_at) {
	    this.text = text;
		this.adText = "";
	    this.created_at = created_at;
	    this.username = username;
	    this.editable = editable;
	    this.imgId = imgId;
	    this.updated_at = updated_at;
	    this.id = id;
		
		//this.createLinks();
  }

  Post.prototype.getTags = function() {
      return (this.text.match(/#(\[[\w\s]+\])|#(\w+)/g)) ? this.text.match(/#(\[[\w\s]+\])|#(\w+)/g) : [];
  };
  
  Post.prototype.createLinks = function(){
	  var tags = this.getTags();
	
	  //We need to escape the HTML, because we are trusting this as html. 
	  var text = this.text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	  this.adText = text;
	  for(var tag in tags){
		  var str = tags[tag];
		  text = text.replace(str, "<a href='#' ng-click='GetTags(\""+str+"\")'>" + str + "</a>");
		  this.adText = text;
	  }
  }
  
  return Post;
});