<div class="panel-body">
	<div class="alert alert-danger" ng-if="errors.length > 0">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			<li ng-repeat= "error in errors"><% error %></li>
		</ul>
	</div>
</div>

<form name="storyForm" ng-submit="SetName(storyData.title)" action="/story/create" method="get">
		<span class="input-group-btn center-text">
			<button type="submit" class="btn btn-primary btn-lg" style="width:100%" ng-disabled="postForm.$invalid">Create a story.</button>
		</span>
		
	</div>
</form>