jQuery.noConflict()(function($){
    $(document).ready(function(){
        
        var v_link = '';
        
        if (typeof verification_link !== 'undefined') {
           v_link =  verification_link;
        }

        $.ajax({
            url: siteUrl+"/funnelApiCallAjax",
            type: "POST",
            data:{"page": funnelPageName, "username": username, "status": 1, "verification_link": v_link },
            beforeSend: function(){
                $(".loading-process").show();
            },
            complete: function(){
                $(".loading-process").hide();
            },
            success:function(data){ 
                
            }
        });
    });
});