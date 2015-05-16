<div class="panel-body">
	<div class="alert alert-danger" ng-if="errors.length > 0">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			<li ng-repeat= "error in errors"><% error %></li>
		</ul>
	</div>
</div>

<form name="postForm" ng-submit="submitPost()" enctype="multipart/form-data">
	<div class="input-group panel-body">
	   <span class="input-group-btn btn btn-default btn-file">
			<input type="file"  ng-Change="FileChange()"" ng-model="imageData.image"  multiple accept='image/*|audio/*|video/*' name="image"/ onchange="PreviewImage()"  id="imageUploaded" style="padding-right:50px">
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
			<button type="submit" class="btn btn-primary btn-lg" ng-disabled="followForm.$invalid">Submit</button>
		</span>
		
	</div>
	<div class="panel-body postData">
		<p ng-show="!postForm.text.$invalid"><% postData.text.length != undefined ? postData.text.length : 0 %> of 140</span></p>
		<p class="text-center" ng-show="postForm.text.$dirty && postForm.text.$invalid" style="color:red;">Sheets need a HashTag!</p>
	</div>
	
	<div class="img-responsive"">
		<img id="preview" class="img-responsive center-block"/>

	</div>
	
	
</form>