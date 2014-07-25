//responsive main menu
$(document).ready(function() {
    $("#responsive-menu-toggle").click(function(){
        if($(this).hasClass("closed")){
            if($("#responsive-grid").is(":visible")){
                $("#responsive-grid").css('display','none');
                $("#responsive-grid-toggle").addClass("closed");
            }else{
                $("#responsive-page-menu-toggle").addClass("closed");
            }
            $("#primary-nav").addClass("pri-show");
            //$("#primary-nav").show();
            //$("#full-modal").show();
            $("#full-modal").css('z-index','9997');
        $(this).removeClass("closed");
        }else{
            $("#primary-nav").removeClass("pri-show");
            $("#full-modal").css('z-index','-9999');
        	$(this).addClass("closed"); 
        }
    });
//responsive icon menu
    $("#responsive-grid-toggle").click(function(){
        if ($(this).hasClass("closed")){
             if($("#primary-nav").is(":visible")){
                $("#primary-nav").css('display','none').css("margin-left","0");
                $("#responsive-menu-toggle").addClass("closed");
            }
            $("#responsive-grid").fadeIn('fast');
            $(this).removeClass("closed");
            //$("#full-modal").show();
            $("#full-modal").css('z-index','9997');
        }else{
            $("#responsive-grid").fadeOut('fast');
            $(this).addClass("closed");
            $("#full-modal").css('z-index','-9999');
        }
    });
//close open menus
    $("#full-modal").click(function(){
       if ($("#primary-nav").is(":visible")){
            $("#primary-nav").removeClass("pri-show");
            $("#responsive-menu-toggle").addClass("closed");
            $("#full-modal").css('z-index','-9999');
        }
        if ($("#responsive-grid").is(":visible")){
            $("#responsive-grid").fadeOut("fast");
            $("#responsive-grid-toggle").addClass("closed");
            $("#full-modal").css('z-index','-9999');
        }

    });
});
function pageMenu(){
 if ( $(window).width() < 699) {
        $("#sidebar-nav").appendTo("#main-content");
    }
    else{
        $("#sidebar-nav").appendTo("#content");
        $("#primary-nav").css("display", "block");
    }
}

