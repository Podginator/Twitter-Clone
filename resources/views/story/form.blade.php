<div class="panel-body">
	<div class="alert alert-danger" ng-if="errors.length > 0">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			<li ng-repeat= "error in errors"><% error %></li>
		</ul>
	</div>
</div>

<form name="storyForm" ng-submit="submitStory()" enctype="multipart/form-data">
	<div class="input-group panel-body">
	    <input 
			type="text" 
			class="form-control input-lg postInput"
		 	name="text" 
			ng-model="storyData.title" 
			placeholder="Story Title."
		>
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary btn-lg" ng-disabled="postForm.$invalid">Create a story.</button>
		</span>
		
	</div>
</form>