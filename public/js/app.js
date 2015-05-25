
  
//Starting point for Angular
var postApp = angular.module('postApp', ['postCtrl', 'postService','dirTabs', 'userCtrl', 'userService', 'storyCtrl', 'storyService', 'angularUtils.directives.dirPagination'],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }); 
    


