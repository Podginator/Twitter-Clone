<div class="panel-body" ng-if="errors.length > 0">
	<div class="alert alert-danger" >
		<strong>Sorry, there were some problems with your input..</strong><br><br>
		<ul>
			<li ng-repeat= "error in errors"><% error %></li>
		</ul>
	</div>
</div>

<form name="storyForm" ng-submit="SetName(storyData.title)" action="/story/create" method="get">
		<span class="input-group-btn center-text">
			<button type="submit" class="btn btn-primary btn-lg" style="width:100%" ng-disabled="postForm.$invalid">Create a story.</button>
		</span>
</form>