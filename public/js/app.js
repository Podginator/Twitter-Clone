
  
//Starting point for Angular
var postApp = angular.module('postApp', ['postCtrl', 'postService'],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }); 
    
