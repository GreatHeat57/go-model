$(document).ready(function (){

    if($("#is_last_page").val() == 1){
        $("#more-posts").addClass("disabled");
        $('.more-post-div').hide();
    }

    $('.more-posts').click(function(){

        var pageNo = $("#pageNo").val();
        var data = 'page=' + pageNo;
        var type = 'get';
        
        $.ajax({
            url: currentUrl,
            type : type,
            dataType :'json',
            beforeSend: function(){
                $(".loading-process").show();
            },
            complete: function(){
                $(".loading-process").hide();
            },
            data : data,
            success : function(res){
                
                var append = $(res.html).filter(".append-data").html();

                $("#pageNo").val(res.pageNo);
                
                if(res.is_last_page == 1){
                    $("#is_last_page").val(res.is_last_page);
                    $("#more-posts").addClass("disabled");
                    $('.more-post-div').hide();
                }

                $('.append-data').append(append);
            }
        });
    });
});