angular.module('userService', [])
  
  //This is the User Factor, where the http and ajax requests happen
.factory('User', function($http){
	return {
		save: function(data){
			return $http({
					method: 'POST',
					url: '/api/user/follow',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		},
		saveUser: function(id){
			console.log(id);
			return $http.get('/api/user/follow/'+id);
		},
		isFollowing: function(username){
			return $http.get('/api/user/following/'+username);
		}
	}
});

