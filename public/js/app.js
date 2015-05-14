
  
//Starting point for Angular
var postApp = angular.module('postApp', ['postCtrl', 'postService', 'userCtrl', 'userService', 'angularUtils.directives.dirPagination'],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }); 
    
