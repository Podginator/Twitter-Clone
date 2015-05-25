
<div class="panel panel-default" 
	dir-paginate="story in stories | itemsPerPage: 10"
	 pagination-id="story"
	 ng-hide="animation"
	 ng-controller="UserController">
		@include("story.storycontent")
</div>

<dir-pagination-controls 
	pagination-id="story" 
	template-url="{{asset('/js/dirPagination.tpl.htm')}}">
</dir-pagination-controls>

