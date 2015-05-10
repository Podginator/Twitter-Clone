<form name="postForm" ng-submit="submitPost()" enctype="multipart/form-data">
	<div class="input-group panel-body">
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
	<div class="panel-body">
		<p ng-show="!postForm.text.$invalid"><% postData.text.length != undefined ? postData.text.length : 0 %> of 140</span></p>
		<p class="text-center" ng-show="postForm.text.$dirty && postForm.text.$invalid" style="color:red;">Sheets need a HashTag!</p>
	    <label for="image">Image:</label>
		<input type="file" ng-model="imageData.image" name="image"/ id="imageUploaded">
	</div>
	
	
</form>