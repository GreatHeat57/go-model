var languageOpen = false;
$('body').on('click','.languages .link',function(e){
    if(!languageOpen) {
        $(this).parent().find('ul').slideDown('fast');
        languageOpen = true;
    } else {
        $(this).parent().find('ul').slideUp('fast');
        languageOpen = false;
    }
    e.preventDefault();
});

var menuOpened = false;
$("body").on("click", "header a.mobile-menu", function (e) {
    if (!menuOpened) {
        $("#mobile-menu").transition({x: '-110%', delay: 0});
        $(this).addClass("close");
        $('body').css('overflow', 'hidden');
        menuOpened = true;
    } else {
        $("#mobile-menu").transition({x: 0, delay: 0});
        $(this).removeClass("close");
        $('body').css('overflow', 'visible');
        menuOpened = false;
    }
    e.preventDefault();
});

$('body').on('click','#mobile-menu .dd',function(e){
    var submenu = $(this).parent().find('ul');
    if($(submenu).hasClass('opened'))
        $(submenu).removeClass('opened').slideUp(500);
    else
        $(submenu).addClass('opened').slideDown(500);

    e.preventDefault();
});

$('body').on('click','.mfp-register',function(e){
    $.magnificPopup.open({
        items: {
            src: '#mfp-sign-up'
        },
        type: 'inline'
    });
    e.preventDefault();
});

$('body').on('click','[name="show-password"]',function(){
    if($(this).is(':checked'))
        $('#registration-password').attr('type','text');
    else
        $('#registration-password').attr('type','password');
});