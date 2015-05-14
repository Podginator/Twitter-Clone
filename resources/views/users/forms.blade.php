<form name="followForm" ng-submit="submitFollow()" enctype="multipart/form-data">
	<div class="input-group">
	    <input 
			type="text" 
			class="form-control input-lg postInput"
		 	name="follow" 
			ng-model="followData.text" 
			ng-pattern="/^[a-zA-Z ]*$/"
			placeholder="Follow an event hashtag."
		>
		<p class="text-center" ng-show="followForm.follow.$dirty && followForm.follow.$invalid" style="color:red;">Only use text.</p>
	    <span class="input-group-btn">
			<button type="submit" class="btn btn-primary btn-lg" ng-disabled="followForm.$invalid">Submit</button>
		</span>
	</div>
</form>