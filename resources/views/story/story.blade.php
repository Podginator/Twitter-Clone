<p class="text-center" ng-if="custom" ng-click="ActiveFunction()">Stories with Tag: <b> <% custom %> </b> showing. Click to go back</p>
<p class="text-center" ng-if="animation"><img src="imgs/loader.gif" height="50" width="50" ></p>

<div class="panel panel-default" dir-paginate="story in stories | itemsPerPage: 10" ng-hide="animation" ng-controller="UserController">
			@include("story.storycontent")
</div>

<dir-pagination-controls template-url="{{asset('/js/dirPagination.tpl.htm')}}"></dir-pagination-controls>

