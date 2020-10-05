$(document).ready(function(){
    var imageEle = $("img");
    $(imageEle).each(function(){
        //check if current image has alt tag
        if(typeof $(this).attr("alt") == typeof undefined || $(this).attr("alt") == "") {
            //find title for blog
            var altText = "Go-Models";
            if($(this).closest("div.post").find("h2").text() != "") {
                altText = $(this).closest("div.post").find("h2").text().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
            }
            $(this).attr("alt", altText);
        }

        var name = $(this).attr("alt").substr(0, $(this).attr("alt").lastIndexOf('.'));
        
        if(name !== null && name != undefined && name != ""){
            $(this).attr("alt", name);
        }
        
    });
});

// magazine read page script
$(document).ready(function() {
    $('.facebook-share-link').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });

    $('.twitter-share-link, .linkedIn-share-link, .youtube-share-link').click(function(e) {
        e.preventDefault();
        window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ',');
        return false;
    });
});
 