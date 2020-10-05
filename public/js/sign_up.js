var hasClient = false;
$(document).ready(function() {
    var registerData = {};
    var userType = 3;
    $('.mfp-register-form').click(function(e) {
        e.preventDefault();

        // var urlParams = new URLSearchParams(window.location.search);
        var current_url = window.location.href;
        var referer_url = document.referrer;
        // urlParams.get('clientId');
        
        if ($(this).hasClass('register-client')) {
            hasClient = true;
        } else {
            hasClient = false;
        }

        $.ajax({
            type: "GET",
            url: registerurl,
            beforeSend: function() {
                $(".loading-process").show();
            },
            complete: function() {
                $(".loading-process").hide();
            },
            success: function(result) {
                if (result.status == true) {
                    var signup_terms = true;
                    $('.mfp-register-form').magnificPopup({
                        items: {
                            src: result.html,
                            type: 'inline'
                        },
                        closeOnBgClick: false,
                        closeBtnInside: true,
                    }).magnificPopup('open'); 
                    
                    function call() {
                        //bindSelect2();
                        userType = $("input[name='user_type']:checked").val();
                        partner_type = $("input[name='partner_type_id']").val();
                        model_type = $("input[name='model_type_id']").val();
 

                        if (hasClient) {
                            userType = partner_type;
                            $("#radio-" + userType).prop("checked", true);
                        } else {
                            // userType = model_type;
                            $("#radio-" + userType).prop("checked", true);
                        }
                        $('.first-popup-link, .second-popup-link').magnificPopup({
                            closeBtnInside: true
                        });
                        if (userType == 3) {
                            $('#partner-fields').hide();
                            $("label[for = newsletter]").text($('#newsletter_model_id').text());
                        } else {
                            $('#partner-fields').show();
                            $("label[for = newsletter]").text($('#newsletter_partner_id').text());
                        }
                        $('input[name="user_type"]').click(function() {
                            userType = $("input[name='user_type']:checked").val();
                            if (userType == 3) {
                                $('#partner-fields').hide();
                                $("label[for = newsletter]").text($('#newsletter_model_id').text());
                            } else {
                                $('#partner-fields').show();
                                $("label[for = newsletter]").text($('#newsletter_partner_id').text());
                            }
                        });
                        $('.mfp-register-form').on('click', function(e) {
                            signup_terms = true;
                        });
                        $('#register-form').on('click', function(e) {
                            e.preventDefault();

                            // html form validations popup and scroll on fields
                            var requiredMsg = $('#fields-validations').html();

                            $('input,textarea,select').filter('[required]:visible').each(function(i, requiredField){
                                if($(requiredField).val() == '' || $(requiredField).val() == null)
                                {
                                    document.getElementsByName($(requiredField).attr('name'))[0].setCustomValidity('');
                                    var element = document.getElementsByName($(requiredField).attr('name'))[0];
                                    element.oninvalid = function(e) {
                                        e.target.setCustomValidity("");
                                        if (!e.target.validity.valid) {
                                            e.target.setCustomValidity(requiredMsg);
                                        }
                                    };
                                    document.getElementsByName($(requiredField).attr('name'))[0].reportValidity();
                                    $('html, body').animate({
                                        scrollTop: ($(requiredField).offset().top - 100)
                                    }, 500, function() {
                                        $(requiredField).focus();
                                    });
                                    return false;
                                }
                            });
                            
                            var getUrl = window.location.origin;
                            var recap_response = $('#submit-register .g-recaptcha');
                            var widgetId = recap_response.attr('data-widgetId');
                            var grecaptchaResponse = grecaptcha.getResponse(widgetId);

                            // var utm_source = $("#utm_source").val();
                            // var utm_medium = $("#utm_medium").val();
                            // var utm_campaign = $("#utm_campaign").val();
                            // var utm_content = $("#utm_content").val();
                            // var gclid = $("#gclid").val();
                            // var clientId = $("#clientId").val();
                            // var utm_term = $("#utm_term").val();
                            
                            var formData = {
                                _token: $("input[name='_token']").val(),
                                first_name: $("input[name='first_name']").val(),
                                last_name: $("input[name='last_name']").val(),
                                user_type: $("input[name='user_type']:checked").val(),
                                company_name: $("input[name='company_name']").val(),
                                website: $("input[name='website']").val(),
                                country: $("#country").val(),
                                email: $("input[name='email']").val(),
                                //phone_code: $("select[name='phone_code']").val(),
                                //phone: $("input[name='phone']").val(),
                                term: $("input[name='term']:checked").val(),
                                'g-recaptcha-response': grecaptchaResponse,
                                newsletter: $("input[name='newsletter']:checked").val(),
                                // utm_source: utm_source,
                                // utm_medium: utm_medium,
                                // utm_campaign: utm_campaign,
                                // utm_content: utm_content,
                                referer_url: referer_url,
                                current_url: current_url,
                                // google_gclid: gclid,
                                // google_clientId: clientId,
                                // utm_term: utm_term,
                            }; 
                            
                            $.ajax({
                                method: "post",
                                url: $("#submit-register").attr('action'),
                                dataType: 'json',
                                data: formData,
                                beforeSend: function() {
                                    $(".loading-process").show();
                                    clearMessage();
                                },
                                complete: function() {
                                    $(".loading-process").hide();
                                },
                                success: function(data) {
                                    if (data != undefined && data.success == false) {
                                        $(".err-input").html('');
                                        $("p").removeClass('help-block');
                                        $('#error-recaptcha-msg').html('');
                                        $('#error-terms').html('');
                                        $.each(data.errors, function(key, value) {
                                            $('#' + key).addClass('help-block');
                                            if (key === 'g-recaptcha-response') {
                                                $('#error-recaptcha-msg').addClass('help-block');
                                                $('#error-recaptcha-msg').html(value[0]);
                                            } else if (key === 'term') {
                                                $('#error-terms').addClass('help-block');
                                                $('#error-terms').html(value[0]);
                                            } else {
                                                $('#' + key).html(value[0]);
                                            }
                                        });
                                    } else {
                                        if (data.success) {
                                            if(document.getElementById('app-env').value == 'live') {
                                                window.dataLayer.push({
                                                    'event': 'signup-form-submit', 
                                                    'firstname': $("input[name='first_name']").val(),
                                                    'lastname': $("input[name='last_name']").val(),
                                                    'email': $("input[name='email']").val(),
                                                    'usertype': ($("input[name='user_type']:checked").val() == '3') ? 'model' : 'partner',
                                                });                                            
                                            }
                                            if (data.message != undefined && data.message != "" && data.message != null) {
                                                
                                                if (data.redirectUrl != undefined && data.redirectUrl != "" && data.redirectUrl != null) {
                                                    
                                                    if(data.direct != undefined && data.direct != "" && data.direct != null){
                                                        window.location.replace(data.redirectUrl);
                                                    }else{
                                                        
                                                        $("div").removeClass('invalid-input');
                                                        $(".print-success-msg").css('display', 'block');
                                                        $(".print-success-msg").append('<p>' + data.message + '</p>');
                                                        $('#register-form').prop("disabled", true);

                                                        setTimeout(function() {
                                                            $(".print-success-msg").css('display', 'none');
                                                            $.magnificPopup.close();
                                                            window.location.replace(data.redirectUrl);
                                                        }, 3000);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                                error: function(a, b, c) {
                                    console.log('error');
                                }
                            });

                            function clearMessage() {
                                $(".print-success-msg").html('');
                                $(".print-success-msg").css('display', 'none');
                                $("p").removeClass('help-block');
                                $(".err-input").html('');
                                $('#error-recaptcha-msg').html('');
                                $('#error-terms').html('');
                            }
                        });
                        $('#term-condition').on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            registerData = {
                                _token: $("input[name='_token']").val(),
                                first_name: $("input[name='first_name']").val(),
                                last_name: $("input[name='last_name']").val(),
                                user_type: $("input[name='user_type']:checked").val(),
                                company_name: $("input[name='company_name']").val(),
                                website: $("input[name='website']").val(),
                                country: $("#country").val(),
                                email: $("input[name='email']").val(),
                                //phone_code: $("select[name='phone_code']").val(),
                                //phone: $("input[name='phone']").val(),
                                term: $("input[name='term']:checked").val(),
                                newsletter: $("input[name='newsletter']:checked").val(),
                            };
                            userType = $("input[name='user_type']:checked").val();

                            // if (userType == 2) {
                            //     $.magnificPopup.open({
                            //         items: {
                            //             src: "#mfp-partner-terms",
                            //             type: "inline"
                            //         },
                            //         closeOnBgClick: false,
                            //         closeBtnInside: true,
                            //     });
                            // } else {
                            //     // $.magnificPopup.close();
                            //     // $.magnificPopup.open({
                            //     //     items: {
                            //     //         src: "#mfp-model-terms",
                            //     //         type: "inline"
                            //     //     },
                            //     //     closeOnBgClick: false,
                            //     //     closeBtnInside: true,
                            //     // });
                            //     $.ajax({
                            //         type: "POST",
                            //         url: siteUrl + "/get-term-ajax",
                            //         data : {userType : 3},
                            //         success: function(res) {
                            //             if (res.status == true) {
                            //                 $.magnificPopup.open({
                            //                     items: {
                            //                         src: res.html,
                            //                         type: "inline"
                            //                     },
                            //                     closeOnBgClick: false,
                            //                     closeBtnInside: true,
                            //                 });
                            //             }
                            //         }
                            //     });
                            // }

                            $.ajax({
                                type: "POST",
                                url: siteUrl + "/get-term-ajax",
                                data : {userType : userType},
                                beforeSend: function() {
                                    $(".loading-process").show();
                                },
                                complete: function() {
                                    $(".loading-process").hide();
                                },
                                success: function(res) {
                                    if (res.status == true) {
                                        $.magnificPopup.open({
                                            items: {
                                                src: res.html,
                                                type: "inline"
                                            },
                                            closeOnBgClick: false,
                                            closeBtnInside: true,
                                        });
                                    }
                                }
                            });
                        });
                        $('.mobile-popup-btn').on('click', function() {
                            $.magnificPopup.close();
                            $('.mfp-register-form').magnificPopup({
                                items: {
                                    src: result.html,
                                    type: 'inline'
                                },
                                closeOnBgClick: false,
                                closeBtnInside: true,
                            }).magnificPopup('open');
                            call();
                            return false;
                        });
                        $("#fb_login").on('click', function() {
                            window.location = $("input[name='facebook_link']").val();
                        });
                        $("#google_login").on('click', function() {
                            window.location = $("input[name='google_link']").val();
                        });
                    }
                    call();
                    $.magnificPopup.instance.close = function() {
                        
                        if ($.magnificPopup.instance.currItem != null && signup_terms) {
                            
                            if ($('div.term-condition-popup-ajax').length) {
                                
                                $('.mfp-register-form').magnificPopup({
                                    items: {
                                        src: result.html,
                                        type: 'inline'
                                    },
                                    closeOnBgClick: false,
                                    closeBtnInside: true,
                                }).magnificPopup('open');
                                
                                userType = registerData.user_type;
                                $("input[name='first_name']").val(registerData.first_name);
                                $("input[name='last_name']").val(registerData.last_name);
                                $("input[name='company_name']").val(registerData.company_name);
                                $("input[name='website']").val(registerData.website);
                                $("#country").val(registerData.country);
                                $("input[name='email']").val(registerData.email);
                                //$("select[name='phone_code']").val(registerData.phone_code);
                                //$("input[name='phone']").val(registerData.phone);
                                $("input[name='term']:checked").val(registerData.term);
                                $("input[name='newsletter']:checked").val(registerData.newsletter);
                                if (userType == 3) {
                                    $("#radio-2").attr('checked', false);
                                    $("#radio-3").attr('checked', true);
                                } else {
                                    $("#radio-3").attr('checked', false);
                                    $("#radio-2").attr('checked', true);
                                }
                                if (registerData.term == 1) {
                                    $("#terms").attr('checked', true);
                                }
                                if (registerData.newsletter == 1) {
                                    $("#newsletter").attr('checked', true);
                                }
                                call();
                                return false;
                            }
                        }

                             
                            // if ($.magnificPopup.instance.currItem.data.src == "#mfp-model-terms" || $.magnificPopup.instance.currItem.data.src == "#mfp-partner-terms") {
                            // if ($('.term-condition-popup').attr('id') == "mfp-model-terms" || $('.term-condition-popup').attr('id') == "mfp-partner-terms") {
                            //     $('.mfp-register-form').magnificPopup({
                            //         items: {
                            //             src: result.html,
                            //             type: 'inline'
                            //         },
                            //         closeOnBgClick: false,
                            //         closeBtnInside: true,
                            //     }).magnificPopup('open');
                            //     userType = registerData.user_type;
                            //     $("input[name='first_name']").val(registerData.first_name);
                            //     $("input[name='last_name']").val(registerData.last_name);
                            //     $("input[name='company_name']").val(registerData.company_name);
                            //     $("input[name='website']").val(registerData.website);
                            //     $("#country").val(registerData.country);
                            //     $("input[name='email']").val(registerData.email);
                            //     $("input[name='term']:checked").val(registerData.term);
                            //     $("input[name='newsletter']:checked").val(registerData.newsletter);
                            //     if (userType == 3) {
                            //         $("#radio-2").attr('checked', false);
                            //         $("#radio-3").attr('checked', true);
                            //     } else {
                            //         $("#radio-3").attr('checked', false);
                            //         $("#radio-2").attr('checked', true);
                            //     }
                            //     if (registerData.term == 1) {
                            //         $("#terms").attr('checked', true);
                            //     }
                            //     if (registerData.newsletter == 1) {
                            //         $("#newsletter").attr('checked', true);
                            //     }
                            //     call();
                            //     return false;
                            // }
                        // }
                        if ($.magnificPopup.instance.currItem.data.src === '#mfp-sign-up') {
                            $("div").removeClass("invalid-input");
                        }
                        $.magnificPopup.proto.close.call(this);
                    };
                }
            },
        });
    });
    
    $(document).on('click', '.close-popup-button', function() {
        $('#mfp-model-terms').magnificPopup('close');
    });

    /*function bindSelect2(){
        
        if ($('.phone-select2').length > 0) {
            $('.phone-select2').select2({
                closeOnSelect: true,
                minimumResultsForSearch: Infinity,
            });
        } 
        if ($('.phone-code-auto-search-signup').length > 0) {
            $(".phone-code-auto-search-signup").select2({
                minimumResultsForSearch: 5,
                width: '100%',
                templateResult: formatState,
                templateSelection: formatState,
                dropdownParent: $("#phone-code-row")
            });
        }
    }*/
    /*function formatState (opt) {
        if (!opt.id) { return opt.text; } 
        var optimage = $(opt.element).attr('data-image-phone');
        if(!optimage){
           return opt.text;
        } else {                    
            var $opt = $(
               '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
            );
            return $opt;
        }    
    };*/

});