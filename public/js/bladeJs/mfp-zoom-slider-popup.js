$(document).ready( function(){
    var magnificPopup = $.magnificPopup.instance;
    $('.some-button').click( function(e){ 
        e.preventDefault();
        var url = $(this).attr('data-url');
        $.ajax({
            method: "get",
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    const magnificpopup = $.magnificPopup.instance;
                    magnificpopup.open({
                        mainClass: 'mfp-with-zoom',
                        items: response.imageArr,
                        gallery: { enabled: true },
                        fixedContentPos: true,
                        type: 'image',
                        tError: '<a href="%url%">The image</a> could not be loaded.',
                        /*image: {
                            verticalFit: true
                        },
                         /*zoom: {  
                                    enabled: true,
                                    duration: 100 
                                }*/
                            });
                    magnificpopup.ev.off('mfpBeforeChange.ajax');
                }
            }, error: function (a, b, c) {
                console.log('error');
            }
        });
    });
});