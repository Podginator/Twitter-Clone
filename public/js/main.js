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

/* Old Code for Tabs
$(document).ready(function () {
    var tabSelect = $(".tabSelecter");
    var selector = $('.tabSelecter  .selector');

    selector.bind('click', ActiveTab);

    function ActiveTab(event) {
        var divClass = event.target.className.split(' ')[0];
        console.log(divClass, tabSelect.children());

        tabSelect.children('div').each(function () {
            console.log('div', $(this));
            $(this).removeClass('active');
            $(this).addClass('inactive');
        });
        selector.removeClass('active').addClass('inactive');

        $('.' + divClass).removeClass('inactive').addClass('active');

    };
});
*/
