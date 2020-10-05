var viewportWidth = $(window).width();

if (viewportWidth < 767) {

    $(".dropdown-main").addClass("mobile-menu-right");
}else{

    $(".dropdown-main").removeClass("mobile-menu-right");
}

$(window).on("load, resize", function() {
    
    // var viewportWidth = $(window).width();
    
    // if (viewportWidth < 767) {

    //     // cover image responsive code
    //     if($('.heroimage img').length == 0 && !$('.content .cover').hasClass('contract-payment-cover')){

    //         $('.content .cover img').wrap('<div class="heroimage"></div>');
            
    //         if($('.heroimage img').length){
    //             var imgSrc = $('.heroimage img').attr('src');
    //             console.log(imgSrc);
    //             $('.heroimage img').css('opacity', '0');
    //             $('.heroimage').css('display', 'block');
    //             $('.heroimage').css('background-image', 'url("'+imgSrc+'")');
    //             // $('.heroimage img').parent('.heroimage').css('background-image', 'url('+imgSrc+')'); 
    //         }
    //     }

    //     $(".dropdown-main").addClass("mobile-menu-right");
    // }else {

    //     // cover image responsive code
    //     if($('.cover .heroimage').length && !$('.content .cover').hasClass('contract-payment-cover') ){

    //         var $clone = $('.content .cover img').clone();
    //         $('.content .cover .heroimage').remove();
    //         $('.content .cover').prepend($clone);
    //         $('.content .cover img').css('opacity' , 1);
    //     }

    //     // cover image responsive code
    //     if($('.cover .heroimage').length){

    //         var $clone = $('.content .cover img').clone();
    //         $('.content .cover .heroimage').remove();
    //         $('.content .cover').prepend($clone);
    //         $('.content .cover img').css('opacity' , 1);
    //     }

    //     $(".dropdown-main").removeClass("mobile-menu-right");
    // }
});

$('body').on('click', '.mobile-menu-button', function (e) {
    
    $(".mobile-menu-right").removeClass('active');
    $(".wrapper-right").find('.mobile-menu').removeClass('active');
    $(".wrapper-right").hide();
    
    if($(".wrapper-left").find('.mobile-menu').hasClass('active')){

        $(".wrapper-left").find('.mobile-menu').removeClass('active');
        $(".wrapper-left").show();
        return false;
    }

    $(".wrapper-left").find('.mobile-menu').addClass('active');
    $(".wrapper-left").show();

    if ($(this).hasClass('active')) {
        $('body').css('overflow-y', 'hidden');
    } else {
        $('body').css('overflow-y', 'auto');
    }
    e.preventDefault();
});

$('body').on('click', '.mobile-menu-right', function (e) {
    
    $(".mobile-menu-button").removeClass('active');
    $(".wrapper-left").find('.mobile-menu').removeClass('active');
    $(".wrapper-left").hide();
    
    if($(".wrapper-right").find('.mobile-menu').hasClass('active')){

        $(".wrapper-right").find('.mobile-menu').removeClass('active');
        $(".wrapper-right").show();
        return false;
    }

    $(".wrapper-right").find('.mobile-menu').addClass('active');
    $(".wrapper-right").show();

    if ($(this).hasClass('active')) {
        $('body').css('overflow-y', 'hidden');
    } else {
        $('body').css('overflow-y', 'auto');
    }
    e.preventDefault();
});


$('body').on('click', '.dropdown-main', function (e) {
    $('.dropdown-content[data-content="' + $(this).data('content') + '"]').toggleClass('active');
    e.preventDefault();
});

// $('body').on('click change', '.select2', function () {
//     if ($(this).hasClass('select2-container--open')) {
//         $(this).parent().css('box-shadow', '0 3px 14.4px 3.6px rgba(188, 188, 188, 0.34)');
//     } else {
//         $(this).parent().css('box-shadow', 'none');
//     }
// });

jQuery("#signupBtn").on('click',function (e) {
    $.ajax({
        method: "post",
        url: jQuery("#registerForm").attr('action'),
        data: new FormData(jQuery('#registerForm')[0]),
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            window.location = data.redirectUrl;
        }, error: function (a, b, c) {
            console.log('error');
        }
    });
    return false;
});

$(window).bind("load", function() {
    var pageurl = window.location.href;
    if(pageurl != "" && pageurl != undefined && pageurl != null){
    	// var register_url = '<?php echo trans('routes.register'); ?>'; 
    	var regArr = pageurl.split('#');
        if(regArr != null && regArr != undefined && regArr != ""){ 
			if($.inArray(register_url, regArr) >= 0){
				// $('.mfp-register-form').trigger('click');
                $('#mfp-register-form').trigger('click');
			}
        }
    }
});

document.onreadystatechange = function () {
    if(document.readyState == 'complete'){
        var pageurl = window.location.href;
        var mautic_signup_url = 'signup';
        if(pageurl != "" && pageurl != undefined && pageurl != null){
            var regArr = pageurl.split('#');
            // if mautic url
            if($.inArray(mautic_signup_url, regArr) >= 0 ){
                setTimeout(function() {
                    $("#mfp-register-form").trigger('click');
                }, 1000); 
            }
        }
    }
} 

// cover image responsive code
// if($(window).width() < 767) {
//     $('.content .cover img').wrap('<div class="heroimage"></div>');
//     if($('.heroimage img').length){
//         var imgSrc = $('.heroimage img').attr('src');
//         $('.heroimage img').css('opacity', '0');
//        $('.heroimage img').parent('.heroimage').css('background-image', 'url("'+imgSrc+'")'); 
//     }
// }

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}