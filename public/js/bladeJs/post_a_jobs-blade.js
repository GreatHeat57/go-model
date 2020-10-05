// $(document).ready(function () {
//     $(document).on("submit","#post-request",function(){
//         var error=0;
//         if($("#terms2:checked").length == 0)
//         {
//             $(".term-label").addClass('error-text');
//             $(".term-label a").addClass('error-text');
//             error++;
//         }
//         else{
//             $(".term-label").removeClass('error-text');
//             $(".term-label a").removeClass('error-text');
//         }
//         if(error > 0)
//         {
//             return false;
//         }
//     })

//     $('#post-term-condition').on('click', function(e){
//         e.preventDefault();
//         e.stopPropagation();
//         // static flag set to manage signup popup close functionality
//         signup_terms = false;
// 		$.ajax({
//             type: "POST",
//             url: siteUrl + "/get-term-ajax",
//             data : {userType : 2},
//             beforeSend: function() {
//                 $(".loading-process").show();
//             },
//             complete: function() {
//                 $(".loading-process").hide();
//             },
//             success: function(res) {
//                 if (res.status == true) {
//                     $.magnificPopup.open({
//                         items: {
//                             src: res.html,
//                             type: "inline"
//                         },
//                         closeOnBgClick: false,
//                         closeBtnInside: true,
//                     });
//                 }
//             }
//         });
// 		// $.magnificPopup.open({
//         //     items: {
//         //         src: "#mfp-partner-terms"
//         //     },
//         //     type: "inline",
//         // });
//     })
// });

$.noConflict()(function($){
	$('#post-request').submit(function() {
		var data = new FormData(jQuery('#post-request')[0])
		var url = $("#post_url").val();
		$(".error-input").html('');
		$('#error-recaptcha-msg').html('');
		$.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            processData: false,
			contentType: false,
            beforeSend: function() {
                $(".loading-process").show();
            },
            complete: function() {
                $(".loading-process").hide();
            },
            success: function(data) { 
            	if (data != undefined && data.success == false) {
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('help-block');
                        if (key === 'g-recaptcha-response') {
                            $('#error-recaptcha-msg').addClass('help-block');
                            $('#error-recaptcha-msg').html(value[0]);
                        }else {
                            $('#' + key).html(value[0]);
                        }
                    });
                } else {
                    if (data.success) {
                    	$(".print-success-msg").css('display', 'block');
                    	$(".print-success-msg").html(data.message);
                    	setTimeout(function() {
                            $(".print-success-msg").css('display', 'none');
                        }, 5000);
                    }
                    $("#post-request")[0].reset();
                    window.grecaptcha.reset();
                }
            },
            error: function(a, b, c) { console.log('error'); }
        });
		return false;
	});
});