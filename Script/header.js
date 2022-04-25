header = false;
function headermenu(){
    if (header === false){
        // header opened
        openMenu();
    }else{
        // header closed
        closeMenu();
    }
}
function closeMenu(){
    header = false;
    $('#header').removeClass("header-mobile");
    $('#mobile-header-list').removeClass("mobile-header-view");
    $('#mobile-header-list').css("transform" , "translateX(100%)");
    $('body').css("overflow-y", "auto");
    // change icon
    $('#header-mobilebutton').removeClass("open");
}
function openMenu(){
    header = true;
    $('#header').addClass("header-mobile");
    $('#mobile-header-list').addClass("mobile-header-view");
    $('#mobile-header-list').css("transform" , "translateX(0)");
    $('body').css("overflow-y", "hidden");
    // change icon
    $('#header-mobilebutton').addClass("open");
}
$(window).resize(function() {
    if ($(window).width() > 1280) {
        closeMenu();
    }
});