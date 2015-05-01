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
		}
	}
});