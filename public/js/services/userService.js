angular.module('userService', [])
  
  //This is the Post Factor, where the http and ajax requests happen
.factory('User', function($http){
	return {
		save: function(data){
			return $http({
					method: 'POST',
					url: '/api/user/follow',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(data)
			});
		}
	}
});

