angular.module('postCtrl', [])
.controller('PostController', function($scope,$http, Post){
	$scope.postData = {}; 
	$scope.animation = true;
	
	Post.get()
		.success(function(data){
			$scope.posts = data;
			$scope.animation = false;
		});
		
	$scope.submitPost = function(){
		$scope.animation = true;
		Post.save($scope.postData)
			.success(function (datum){
				Post.get()
					.success(function(getData){
						$scope.posts = getData;
						$scope.animation = false;
					});
			});
	};

	
	$scope.deletePost = function(id) {
		$scope.animation = true;
		 Post.destroy(id)
            .success(function(data) {
                Post.get()
                    .success(function(getData) {
                        $scope.posts = getData;
                        $scope.animation = false;
                    });

            });
    };
});