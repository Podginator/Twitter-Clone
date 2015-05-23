

<form name="postForm" ng-submit="submitPost()" enctype="multipart/form-data">
	<div class="input-group panel-header">
	   <span class="input-group-btn btn btn-default btn-file">
			<input type="file" name="image" onchange="ChangeFile(this)"  id="imageUploaded" style="padding-right:50px">
		</span>
	    <input 
			type="text" 
			class="form-control input-lg postInput"
		 	name="text" 
			maxlength="140"
			ng-maxlength="140"
			ng-model="postData.text" 
			ng-pattern="/\S*#(?:\[[^\]]+\]|\S+)/"
			placeholder="Add a Post."
		>
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary btn-lg" ng-disabled="postForm.$invalid">Submit</button>
		</span>
		
	</div>
	<div class="panel-body postData">
		<p class = "valTextLengthPost" ng-show="!postForm.text.$invalid"><% postData.text.length != undefined ? postData.text.length : 0 %> of 140</p>
		<p class="text-center valHashtagPost" ng-show="postForm.text.$dirty && postForm.text.$invalid">Sheets need a HashTag (#) !</p>
	</div>
	
	<div class="img-responsive"">
		<img id="preview" class="img-responsive center-block"/>

	</div>
	
	
</form>

<div class="panel-body">
	<div class="alert alert-danger" ng-if="errors.length > 0">
		<strong>Sorry, there were some problems with your sheet..</strong><br><br>
		<ul>
			<li ng-repeat= "error in errors"><% error %></li>
		</ul>
	</div>
</div>
