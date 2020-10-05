$(document).ready( function(){
   

    $.ajax({
        type: "get",
        url: siteUrl + "/header-ajax-country",
        success: function(res) 
        {
            if (res.success == true) {

                if(res.unreadMessages > 0){
                    
                    var message_label = $('.message-lbl').html();
                    var msgcount = "";

                    if( res.unreadMessages > num_counter ){ 
                        msgcount = message_label + " <span class='msg-num'>"+num_counter+" +</span>";
                    } else { 
                        msgcount = message_label + " <span class='msg-num'>"+res.unreadMessages+"</span>";
                    }

                    if(msgcount != ""){
                        $('.message-lbl').html(msgcount);
                    }else{
                        $('.message-lbl').html(msg_label);
                    }
                }else{
                    $('.message-lbl').html(msg_label);
                }

                if(res.totalInvitations > 0){

                    var int_label = $('.inviation-lbl').html();
                    var intcount = "";

                    if( res.totalInvitations > num_counter ){ 
                        intcount = int_label + " <span class='msg-num num-invited'>"+num_counter+" +</span>";
                    } else { 
                        intcount = int_label + " <span class='msg-num num-invited'>"+res.totalInvitations+"</span>";
                    }
                    
                    if(intcount != ""){
                        $('.inviation-lbl').html(intcount);
                    }else{
                        $('.inviation-lbl').html(intv_label);
                    }
                                           
                }else{
                    $('.inviation-lbl').html(intv_label);
                }
            }
            
        }
    });
});