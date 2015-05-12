function PreviewImage() {
	//Get new FileReader
    var Reader = new FileReader();
	
    Reader.readAsDataURL(document.getElementById("imageUploaded").files[0]);

    Reader.onload = function (oFREvent) {
        $("#preview").show();
        document.getElementById("preview").src = oFREvent.target.result;
    };
};
