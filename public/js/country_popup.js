$(document).ready(function() {
    $('.mfp-country-select').click(function(e) {
        e.preventDefault();
        
        $('.mfp-country-select').magnificPopup({
            items: {
                src: "#mfp-country",
                type: "inline"
            },
            closeOnBgClick: false,
            closeBtnInside: true,
        }).magnificPopup('open');
    });
});