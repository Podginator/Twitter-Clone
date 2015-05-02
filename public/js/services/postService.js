angular.module('postService', [])

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
      return (this.text.match(/\S*#(?:\[[^\]]+\]|\S+)/g)) ? this.text.match(/\S*#(?:\[[^\]]+\]|\S+)/g) : [];
  };
  
  Post.prototype.createLinks = function(){
	  var tags = this.getTags();
	  
	  var text = this.text;
	  this.adText = $sce.trustAsHtml(text);
	  for(var tag in tags){
		  var str = tags[tag];
		  text = text.replace(str, "<a href='/tag/"+str.substring(1, str.length)+"'>" + tags[tag] + "</a>");
		  this.adText = $sce.trustAsHtml(text);
	  }
  }
  
  return Post;
});