
  
//Starting point for Angular
var postApp = angular.module('postApp', ['postCtrl', 'postService', 'userCtrl', 'userService'],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }); 
    
