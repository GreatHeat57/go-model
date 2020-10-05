// Firefox 1.0+
var isFirefox = typeof InstallTrigger !== 'undefined';

if(isFirefox){
    
    var delay = 0;
    var offset = 150;

    document.addEventListener('invalid', function(e){
       $(e.target).addClass("html-invalid");
        $('html, body').animate({scrollTop: $($(".html-invalid")[0]).offset().top - offset }, delay);
    }, true);
}

$('body').on('change', 'form input.animlabel', function () {
    if ($(this).val().length > 0) {
        $(this).addClass('active');
    } else {
        $(this).removeClass('active');
    }
});

// mautic Signup
$(window).bind("load", function() {
    var pageurl = window.location.href;
    var mautic_signup_url = 'signup';
    if(pageurl != "" && pageurl != undefined && pageurl != null){
        // var register_url = '<?php echo trans('routes.register'); ?>'; 
        var regArr = pageurl.split('#');
        
        if(regArr != null && regArr != undefined && regArr != ""){ 
            // if mautic url
            if($.inArray(mautic_signup_url, regArr) >= 0 ){
                
                $('.mfp-register-form').trigger('click');
            }
        }
    }
});

$(document).ready(function() {
    /* Get the user-agent string */ 
    let userAgentString =  navigator.userAgent;
    /* Detect Firefox */
    let firefoxAgent = userAgentString.indexOf("Firefox") > -1; 
    /* Detect Internet Explorer */
    let IExplorerAgent =  userAgentString.indexOf("MSIE") > -1 ||  userAgentString.indexOf("rv:") > -1;
    /* open internet Explorer popup */
    if(IExplorerAgent == true && firefoxAgent == false){
        $.magnificPopup.open({
            items: {
                src: '#internetExplorerPopup' 
            },
            closeOnBgClick: false,
            closeBtnInside: false,
            enableEscapeKey: false,
            showCloseBtn:false,
            type: 'inline'
        });
        $("body").css("overflow", "hidden");
    }
});