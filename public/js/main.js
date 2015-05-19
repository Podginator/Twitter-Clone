function ChangeFile(angularEl) {

    
     if(angular.element(angularEl).scope().FileChange())
     {
          var Reader = new FileReader();
	
            Reader.readAsDataURL(document.getElementById("imageUploaded").files[0]);
        
            Reader.onload = function (oFREvent) {
                $("#preview").show();
                document.getElementById("preview").src = oFREvent.target.result;
            };
     }
};
