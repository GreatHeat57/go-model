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

    $('#feedback-form').submit(function() {
        var data = new FormData(jQuery('#feedback-form')[0])
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
                    $("#feedback-form")[0].reset();
                    window.grecaptcha.reset();
                }
            },
            error: function(a, b, c) { console.log('error'); }
        });
        return false;
    });

    $('#contact-form').submit(function() {
        var data = new FormData(jQuery('#contact-form')[0])
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
                    $("#contact-form")[0].reset();
                    window.grecaptcha.reset();
                }
            },
            error: function(a, b, c) { console.log('error'); }
        });
        return false;
    });
});