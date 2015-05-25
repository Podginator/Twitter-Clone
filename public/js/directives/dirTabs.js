//set up a directive for tabbing
angular.module('dirTabs', [])
    .directive('dirTab', function(){
        return {
            //Means that you can only use it like <dir-tab></dir-tab>
            restrict: 'E',
            transclude: true,
            scope: {},
            controller: ["$scope", function($scope){
                //Set up a small controller for it to bind the two together.
                var tabs = $scope.tabs = [];
                $scope.select = function(tab){
                    //Basically do what we did in main.js but with objects
                    $.each(tabs, function(index,tab){
                        tab.active = false;
                    });
                    //Activate the one we've selected
                    tab.active = true;
                }
                
                //This is more of a dynamic way of adding tabs in. 
                this.addTab = function(tab){
                    //If this is the first tab we've added then select it.
                    if(tabs.length == 0)
                    {
                        $scope.select(tab);
                    }
                    tabs.push(tab);
                }
            }],
            //Use basically the same code as before.
            template:
                '<div class="tabSelecter">'
                +   '<ul class="select">'
                +       '<li ng-repeat="tab in tabs" ng-class= "{ \'active\' : tab.active, \'inactive\' : !active }" ng-click="select(tab)">'
                +           "<%tab.title%>"
                +       '</li>'
                +   '</ul>'
                +   '<div class="content" ng-transclude></div>'
                +   '</div>',
            replace: true
        };
    }).
    //Then the content can be added here.
    directive('tabContent', [ function(){
        return{
            require: '^dirTab',
            restrict: 'E',
            scope: { title: '@' },
            link: function (scope, element,attrs,dirTabCtrl) {
                dirTabCtrl.addTab(scope);
            },
            transclude:true,
            template:
                '<div class="tab-content" ng-class="{ \'active\' : active, \'inactive\' : !active }" ng-transclude> </div>',
            replace:true
        };
    }]);


