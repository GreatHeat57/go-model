$(document).ready(function(){
    var getUrl =  window.location.origin;
    var url = getUrl+"/ajax-flash-message";

    $.ajax({
        url: url,
        type: 'get',
        success: function(response){
            $('.ajax-message').html(response.html);
        },
        error: function(err){
            console.log(err);
        }
    });

});