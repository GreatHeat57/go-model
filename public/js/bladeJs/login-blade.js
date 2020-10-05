$(document).ready(function () {

    $('#email').val('');
    $('#password').val('');
    
    $("#fb_login").on('click',function () {
        window.location = fb_login_url;
    });

    $("#google_login").on('click',function () {
        window.location = google_login_url;
    });

    setTimeout(function() {
        var hasValueEmail = $("#email").val().length > 0;//Normal
        if(!hasValueEmail){
            hasValueEmail = $("#email:-webkit-autofill").length > 0;//Chrome
        }

        var hasValuePassword = $("#password").val().length > 0;//Normal
        if(!hasValuePassword){
            hasValuePassword = $("#password:-webkit-autofill").length > 0;//Chrome
        }

        if (hasValueEmail && !$("#email").hasClass("active"))
        {
            $("#email").addClass("active");
        }
        if (hasValuePassword && !$("#password").hasClass("active"))
        {
            $("#password").addClass("active");
        }
    }, 2000);
});