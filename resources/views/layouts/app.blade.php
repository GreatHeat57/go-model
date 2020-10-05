<?php
$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
$detectAdsBlockerPlugin = load_installed_plugin('detectadsblocker');
$htmlLang = config('app.locale');
// if(strtolower(config('app.locale')) == "de")
// {
// 	$htmlLang = strtolower(config('app.locale')).'-'.strtoupper(config('app.locale'));
// }
?>
<!DOCTYPE html>
<html lang="{{ $htmlLang }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<head>
{!! config('constant.Google_Tag_Manager')!!}	
{!! config('constant.Cookie_Google_Tag_Manager')!!}    
	<?php /*`
		<!-- Google Tag Manager -->
		<!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-T5RPTCX');</script> -->
		<!-- End Google Tag Manager -->
	*/ ?>

	@include('layouts.logged_in.meta')

    @include('layouts.head')

    <script type="text/javascript">
	  var baseurl = "{{ lurl('/') }}/";
	</script>

	<!-- defined register popup url to convert based on local and get it pupop form action-->
	<script type="text/javascript">
	  var registerurl = "{{ lurl(trans('routes.register-from')) }}/";
	</script>

	<?php /*
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	*/ ?>
	<script src="{{ url(config('app.cloud_url').'/js/jquery-3.0.0.min.js') }}"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/lazysizes.min.js') }}" defer></script>

	
</head>
<body>
	{!! config('constant.noscript_Google_Tag_Manager') !!}
    {!! config('constant.Cookie_noscript_Google_Tag_Manager') !!}
<?php /*
<!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->

<!-- <button onclick="topFunction()" id="btnScrollTop" title="Scroll to top"><img src="{{ URL::to(config('app.cloud_url').'/images/icons/up-arrow-white.png') }}"/></button> -->
*/ ?>
<script>
	var textAddtoFav = '<?php echo t('Add to Favorite') ?>';
	var textRemoveFromFav = '<?php echo t('Remove from Favorite') ?>';
	var siteUrl = '<?php echo url('/'); ?>';
	var languageCode = '<?php echo config('app.locale'); ?>';
	var countryCode = '<?php echo config('country.code', 0); ?>';

	var langLayout = {
		'hideMaxListItems': {
			'moreText': "{{ t('View More') }}",
			'lessText': "{{ t('View Less') }}"
		},
		'select2': {
			errorLoading: function(){
				return "{!! t('The results could not be loaded') !!}"
			},
			inputTooLong: function(e){
				var t = e.input.length - e.maximum, n = {!! t('Please delete #t character') !!};
				return t != 1 && (n += 's'),n
			},
			inputTooShort: function(e){
				var t = e.minimum - e.input.length, n = {!! t('Please enter #t or more characters') !!};
				return n
			},
			loadingMore: function(){
				return "{!! t('Loading more results') !!}"
			},
			maximumSelected: function(e){
				var t = {!! t('You can only select #max item') !!};
				return e.maximum != 1 && (t += 's'),t
			},
			noResults: function(){
				return "{!! t('No results found') !!}"
			},
			searching: function(){
				return "{!! t('Searching') !!}"
			}
		}
	};
</script>


<?php
$user = \Auth::user();
$user_type_id = !empty($user) ? $user->user_type_id : 0;

if ($user_type_id == 1) {
	if (!isset($is_page)) {  }
	?>

	@include('layouts.header')

<?php } else if ($user_type_id == 3) {?>
	@include('layouts.logged_in.header-model')
<?php } else if ($user_type_id == 2) {?>
	@include('layouts.logged_in.header-partner')
<?php } else {?>
	@include('layouts.header')
<?php }
?>

<div class="content">
    @yield('content')
</div>

<?php if ($user_type_id == 2) {?>
    @include('childs.mobile-menu-partner')
    @include('childs.mobile-menu-partner-right')
 <?php } else if ($user_type_id == 3) {?>
    @include('childs.mobile-menu-model')
    @include('childs.mobile-menu-model-right')
<?php } else {?>
    @include('layouts.mobile_menu')
<?php }
?>

@include('internetExplorerPopup')
@include('layouts.footer')

<script type="text/javascript">
    $(document).ready( function(){
        /* update header flag and message,inviation count on cache page */
        var num_counter = "<?php echo config('app.num_counter'); ?>";
        var msg_label = "<?php echo t('Messages'); ?>";
        var intv_label = "<?php echo t('Invitations'); ?>";

        $.ajax({
            type: "get",
            url: siteUrl + "/header-ajax-country",
            success: function(res) 
            {
                if (res.success == true) {
                    $('#render-country').html(res.html);

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
                /*
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
                */
                $('.mfp-country-select').click(function(e) {
                    $.ajax({
                        type: "GET",
                        url: siteUrl+"/"+languageCode +"/header-ajax-country-list",
                        beforeSend: function() {
                            $(".loading-process").show();
                        },
                        complete: function() {
                            $(".loading-process").hide();
                        },
                        success: function(result) {
                            $('.mfp-country-select').magnificPopup({
                                items: {
                                    src: result.html,
                                    type: 'inline'
                                },
                                closeOnBgClick: false,
                                closeBtnInside: true,
                            }).magnificPopup('open');
                        }
                    });
                });
            }
        });

        var d = siteUrl + "/" + languageCode;
        
        $(".open-popup").click(function() {
            $.ajax({
                type: "get",
                url: d + "/get-restriction-popup",
                beforeSend: function() {
                    $(".loading-process").show()
                },
                complete: function() {
                    $(".loading-process").hide()
                },
                success: function(e) {
                    if (e.success == true) {
                        $.magnificPopup.open({
                            items: {
                                src: e.html,
                                type: "inline"
                            }
                        })
                    }
                }
            })
        });

        $(".go-premium-button").click(function() {
            $.ajax({
                type: "get",
                url: d + "/get-go-restriction-popup",
                beforeSend: function() {
                    $(".loading-process").show()
                },
                complete: function() {
                    $(".loading-process").hide()
                },
                success: function(e) {
                    if (e.success == true) {
                        $.magnificPopup.open({
                            items: {
                                src: e.html,
                                type: "inline"
                            }
                        })
                    }
                }
            })
        });

    });
</script>

<?php
/*
// $UserType = (new \App\Models\UserType);
// $page = (new \App\Models\Page);
// $userTypes = $UserType->all();
// $page_terms = $page::where('type', 'terms')->where('active', '1')->trans()->first();
// $page_termsclient = $page::where('type', 'termsclient')->where('active', '1')->trans()->first();
*/
?>

<?php /* @include('childs.sign_up') */ ?>
{{-- Html::script(config('app.cloud_url').'/js/sign_up.min.js') --}}
{{-- Html::script(config('app.cloud_url').'/js/bladeJs/front-form-ajax-blade.js') --}}

<script type="text/javascript">
        var hasClient = !1;
        $(document).ready(function() {
            /* Get the user-agent string */
            let userAgentString =  navigator.userAgent;
            /* Detect Firefox */
            let firefoxAgent = userAgentString.indexOf("Firefox") > -1; 
            /* Detect Internet Explorer */
            let IExplorerAgent =  userAgentString.indexOf("MSIE") > -1 ||  userAgentString.indexOf("rv:") > -1;
            /* open internet Explorer popup */
            if(IExplorerAgent == true && firefoxAgent == false){
                $.magnificPopup.open({
                    items: {
                        src: '#internetExplorerPopup' 
                    },
                    closeOnBgClick: false,
                    closeBtnInside: false,
                    enableEscapeKey: false,
                    showCloseBtn:false,
                    type: 'inline'
                });
                $("body").css("overflow", "hidden");
            }
            var a = {}, i = 3;
        });
        function signupFormPopup(){
            var r = window.location.href,
                l = document.referrer;
            hasClient = !!$(this).hasClass("register-client"), $.ajax({
                type: "GET",
                url: registerurl,
                beforeSend: function() {
                    $(".loading-process").show()
                },
                complete: function() {
                    $(".loading-process").hide()
                },
                success: function(e) {
                    if (1 == e.status) {
                        var t = !0;

                        function n() {
                            
                            i = $("input[name='user_type']:checked").val(), partner_type = $("input[name='partner_type_id']").val(), model_type = $("input[name='model_type_id']").val(), hasClient && (i = partner_type), $("#radio-" + i).prop("checked", !0), $(".first-popup-link, .second-popup-link").magnificPopup({
                                closeBtnInside: !0
                            }), 3 == i ? ($("#partner-fields").hide(), $("label[for = newsletter]").text($("#newsletter_model_id").text())) : ($("#partner-fields").show(), $("label[for = newsletter]").text($("#newsletter_partner_id").text())), $('input[name="user_type"]').click(function() {
                                3 == (i = $("input[name='user_type']:checked").val()) ? ($("#partner-fields").hide(), $("label[for = newsletter]").text($("#newsletter_model_id").text())) : ($("#partner-fields").show(), $("label[for = newsletter]").text($("#newsletter_partner_id").text()))
                            }), $(".mfp-register-form").on("click", function(e) {
                                t = !0
                            }), $("#register-form").on("click", function(e) {
                                e.preventDefault();
                                var n = $("#fields-validations").html();
                                $("input,textarea,select").filter("[required]:visible").each(function(e, t) {
                                    if ("" == $(t).val() || null == $(t).val()) return document.getElementsByName($(t).attr("name"))[0].setCustomValidity(""), document.getElementsByName($(t).attr("name"))[0].oninvalid = function(e) {
                                        e.target.setCustomValidity(""), e.target.validity.valid || e.target.setCustomValidity(n)
                                    }, document.getElementsByName($(t).attr("name"))[0].reportValidity(), $("html, body").animate({
                                        scrollTop: $(t).offset().top - 100
                                    }, 500, function() {
                                        $(t).focus()
                                    }), !1
                                });
                                window.location.origin;
                                    i = {
                                        _token: $("input[name='_token']").val(),
                                        first_name: $("input[name='first_name']").val(),
                                        last_name: $("input[name='last_name']").val(),
                                        user_type: $("input[name='user_type']:checked").val(),
                                        company_name: $("input[name='company_name']").val(),
                                        website: $("input[name='website']").val(),
                                        country: $("#country").val(),
                                        email: $("input[name='email']").val(),
                                        term: $("input[name='term']:checked").val(),
                                        "g-recaptcha-response": $("#submit-register .g-recaptcha-response").val(),
                                        newsletter: $("input[name='newsletter']:checked").val(),
                                        referer_url: l,
                                        current_url: r
                                    };
                                $.ajax({
                                    method: "post",
                                    url: $("#submit-register").attr("action"),
                                    dataType: "json",
                                    data: i,
                                    beforeSend: function() {
                                        $(".loading-process").show(), $(".print-success-msg").html(""), $(".print-success-msg").css("display", "none"), $("p").removeClass("help-block"), $(".err-input").html(""), $("#error-recaptcha-msg").html(""), $("#error-terms").html("")
                                    },
                                    complete: function() {
                                        $(".loading-process").hide()
                                    },
                                    success: function(e) {
										console.log(e);
                                        null != e && 0 == e.success ? ($(".err-input").html(""), $("p").removeClass("help-block"), $("#error-recaptcha-msg").html(""), $("#error-terms").html(""), $.each(e.errors, function(e, t) {
                                            $("#" + e).addClass("help-block"), "g-recaptcha-response" === e ? ($("#error-recaptcha-msg").addClass("help-block"), $("#error-recaptcha-msg").html(t[0])) : "term" === e ? ($("#error-terms").addClass("help-block"), $("#error-terms").html(t[0])) : $("#" + e).html(t[0])
                                        })) : e.success && ("live" == document.getElementById("app-env").value && window.dataLayer.push({
                                            event: "signup-form-submit",
                                            firstname: $("input[name='first_name']").val(),
                                            lastname: $("input[name='last_name']").val(),
                                            email: $("input[name='email']").val(),
                                            usertype: "3" == $("input[name='user_type']:checked").val() ? "model" : "partner"
                                        }), null != e.message && "" != e.message && null != e.message && null != e.redirectUrl && "" != e.redirectUrl && null != e.redirectUrl && (null != e.direct && "" != e.direct && null != e.direct ? window.location.replace(e.redirectUrl) : ($("div").removeClass("invalid-input"), $(".print-success-msg").css("display", "block"), $(".print-success-msg").append("<p>" + e.message + "</p>"), $("#register-form").prop("disabled", !0), setTimeout(function() {
                                            $(".print-success-msg").css("display", "none"), $.magnificPopup.close(), window.location.replace(e.redirectUrl)
                                        }, 3e3))))
                                    },
                                    error: function(e, t, n) {
                                        console.log("error")
                                    }
                                })
                            }), $("#term-condition").on("click", function(e) {
                                e.preventDefault(), e.stopPropagation(), a = {
                                    _token: $("input[name='_token']").val(),
                                    first_name: $("input[name='first_name']").val(),
                                    last_name: $("input[name='last_name']").val(),
                                    user_type: $("input[name='user_type']:checked").val(),
                                    company_name: $("input[name='company_name']").val(),
                                    website: $("input[name='website']").val(),
                                    country: $("#country").val(),
                                    email: $("input[name='email']").val(),
                                    term: $("input[name='term']:checked").val(),
                                    newsletter: $("input[name='newsletter']:checked").val()
                                }, i = $("input[name='user_type']:checked").val(), $.ajax({
                                    type: "POST",
                                    url: siteUrl + "/get-term-ajax",
                                    data: {
                                        userType: i
                                    },
                                    beforeSend: function() {
                                        $(".loading-process").show()
                                    },
                                    complete: function() {
                                        $(".loading-process").hide()
                                    },
                                    success: function(e) {
                                        1 == e.status && $.magnificPopup.open({
                                            items: {
                                                src: e.html,
                                                type: "inline"
                                            },
                                            closeOnBgClick: !1,
                                            closeBtnInside: !0
                                        })
                                    }
                                })
                            }), $(".mobile-popup-btn").on("click", function() {
                                return $.magnificPopup.close(), $(".mfp-register-form").magnificPopup({
                                    items: {
                                        src: e.html,
                                        type: "inline"
                                    },
                                    closeOnBgClick: !1,
                                    closeBtnInside: !0
                                }).magnificPopup("open"), n(), !1
                            }), $("#fb_login").on("click", function() {
                                window.location = $("input[name='facebook_link']").val()
                            }), $("#google_login").on("click", function() {
                                window.location = $("input[name='google_link']").val()
                            })
                        }
                        $(".mfp-register-form").magnificPopup({
                            items: {
                                src: e.html,
                                type: "inline"
                            },
                            closeOnBgClick: !1,
                            closeBtnInside: !0
                        }).magnificPopup("open"), n(), $.magnificPopup.instance.close = function() {
                            if (null != $.magnificPopup.instance.currItem && t && $("div.term-condition-popup-ajax").length) return $(".mfp-register-form").magnificPopup({
                                items: {
                                    src: e.html,
                                    type: "inline"
                                },
                                closeOnBgClick: !1,
                                closeBtnInside: !0
                            }).magnificPopup("open"), i = a.user_type, $("input[name='first_name']").val(a.first_name), $("input[name='last_name']").val(a.last_name), $("input[name='company_name']").val(a.company_name), $("input[name='website']").val(a.website), $("#country").val(a.country), $("input[name='email']").val(a.email), $("input[name='term']:checked").val(a.term), $("input[name='newsletter']:checked").val(a.newsletter), 3 == i ? ($("#radio-2").attr("checked", !1), $("#radio-3").attr("checked", !0)) : ($("#radio-3").attr("checked", !1), $("#radio-2").attr("checked", !0)), 1 == a.term && $("#terms").attr("checked", !0), 1 == a.newsletter && $("#newsletter").attr("checked", !0), n(), !1;
                            "#mfp-sign-up" === $.magnificPopup.instance.currItem.data.src && $("div").removeClass("invalid-input"), $.magnificPopup.proto.close.call(this)
                        }
                    }
                }
            }), $(document).on("click", ".close-popup-button", function() {
                $('.term-condition-popup-ajax').find('.mfp-close').trigger('click')
                /* $("#mfp-model-terms").magnificPopup("close") */
            })
        }
        
        function formatState (opt) {
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
        }
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        };
    $(window).on('load', function() { 
        $(".mfp-register-form").click(function(e) { e.preventDefault(); signupFormPopup(); }); 
    });

    document.onreadystatechange = function () {
        if (document.readyState == 'complete') {
            var pageurl = window.location.href;
            var mautic_signup_url = 'signup';

            let userAgent =  navigator.userAgent;
            let firefox = userAgent.indexOf("Firefox") > -1; 
            let IExplorer =  userAgent.indexOf("MSIE") > -1 ||  userAgent.indexOf("rv:") > -1;
            if (pageurl != "" && pageurl != undefined && pageurl != null) {
                var regArr = pageurl.split('#');
                /* if mautic url */
                if ($.inArray(mautic_signup_url, regArr) >= 0) {
            if(IExplorer == false || firefox == true){
                        setTimeout(function () {
                            /* $("#mfp-register-form").trigger('click'); */
                            signupFormPopup();
                        }, 1000);
                    }
                }
            }
        }
    }
</script>

<script type="text/javascript">
	
	if($('#post-request').length > 0 || $('#feedback-form').length > 0 || $('#contact-form').length > 0){
		$.noConflict()(function($){
			$('#post-request').submit(function() {
				var data = new FormData(jQuery('#post-request')[0]);
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
		        var data = new FormData(jQuery('#feedback-form')[0]);
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
		        var data = new FormData(jQuery('#contact-form')[0]);
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
	}
</script>

<?php /*
<!-- term and condtion popup for model and partner start -->
<?php if (!empty($page_terms)): ?>
@include('layouts.inc.modal.model.term')
<?php endif;?>
<?php if (!empty($page_termsclient)): ?>
@include('layouts.inc.modal.partner.term')
<?php endif;?>
<!-- term and condtion popup for model and partner end -->
*/ ?>

{{-- Html::script(config('app.cloud_url').'/js/app.min.js') --}}

<script src="{{ config('app.cloud_url').'/js/app.min.js' }}" defer></script>

<script type="text/javascript">
    jQuery.noConflict()(function($) {

        var register_url = "<?php echo trans('routes.register'); ?>";
        var viewportWidth = $(window).width();
        if (viewportWidth < 767) {
            $(".dropdown-main").addClass("mobile-menu-right")
        } else {
            $(".dropdown-main").removeClass("mobile-menu-right")
        }
        /*
            $(window).on("load, resize", function () {

                var viewportWidth = $(window).width();

                if (viewportWidth < 767) {

                    // cover image responsive code
                    if ($('.heroimage img').length == 0 && !$('.content .cover').hasClass('contract-payment-cover')) {

                        $('.content .cover img').wrap('<div class="heroimage"></div>');

                        if ($('.heroimage img').length) {
                            var imgSrc = $('.heroimage img').attr('src');
                            console.log(imgSrc);
                            $('.heroimage img').css('opacity', '0');
                            $('.heroimage').css('display', 'block');
                            $('.heroimage').css('background-image', 'url("' + imgSrc + '")');
                            // $('.heroimage img').parent('.heroimage').css('background-image', 'url('+imgSrc+')'); 
                        }
                    }

                    $(".dropdown-main").addClass("mobile-menu-right");
                } else {

                    // cover image responsive code
                    if ($('.cover .heroimage').length) {

                        var $clone = $('.content .cover img').clone();
                        $('.content .cover .heroimage').remove();
                        $('.content .cover').prepend($clone);
                        $('.content .cover img').css('opacity', 1);
                    }

                    $(".dropdown-main").removeClass("mobile-menu-right");
                }
            });
        */
        $("body").on("click", ".mobile-menu-button", function(d) {
            $(".mobile-menu-right").removeClass("active");
            $(".wrapper-right").find(".mobile-menu").removeClass("active");
            $(".wrapper-right").hide();
            if ($(".wrapper-left").find(".mobile-menu").hasClass("active")) {
                $(".wrapper-left").find(".mobile-menu").removeClass("active");
                $(".wrapper-left").show();
                return false
            }
            $(".wrapper-left").find(".mobile-menu").addClass("active");
            $(".wrapper-left").show();
            if ($(this).hasClass("active")) {
                $("body").css("overflow-y", "hidden")
            } else {
                $("body").css("overflow-y", "auto")
            }
            d.preventDefault()
        });
        $("body").on("click", ".mobile-menu-right", function(d) {
            $(".mobile-menu-button").removeClass("active");
            $(".wrapper-left").find(".mobile-menu").removeClass("active");
            $(".wrapper-left").hide();
            if ($(".wrapper-right").find(".mobile-menu").hasClass("active")) {
                $(".wrapper-right").find(".mobile-menu").removeClass("active");
                $(".wrapper-right").show();
                return false
            }
            $(".wrapper-right").find(".mobile-menu").addClass("active");
            $(".wrapper-right").show();
            if ($(this).hasClass("active")) {
                $("body").css("overflow-y", "hidden")
            } else {
                $("body").css("overflow-y", "auto")
            }
            d.preventDefault()
        });
        $("body").on("click", ".dropdown-main", function(d) {
            $('.dropdown-content[data-content="' + $(this).data("content") + '"]').toggleClass("active");
            d.preventDefault()
        });
        $("body").on("click change", ".select2", function() {
            if ($(this).hasClass("select2-container--open")) {
                $(this).parent().css("box-shadow", "0 3px 14.4px 3.6px rgba(188, 188, 188, 0.34)")
            } else {
                $(this).parent().css("box-shadow", "none")
            }
        });
        jQuery("#signupBtn").on("click", function(d) {
            $.ajax({
                method: "post",
                url: jQuery("#registerForm").attr("action"),
                data: new FormData(jQuery("#registerForm")[0]),
                contentType: false,
                processData: false,
                success: function(e) {
                    console.log(e);
                    window.location = e.redirectUrl
                },
                error: function(f, e, g) {
                    console.log("error")
                }
            });
            return false
        });
        $(window).bind("load", function() {
            var pageurl = window.location.href;
            if (pageurl != "" && pageurl != undefined && pageurl != null) {
                var regArr = pageurl.split("#");
                if (regArr != null && regArr != undefined && regArr != "") {
                    if ($.inArray(register_url, regArr) >= 0) {
                        $("#mfp-register-form").trigger("click")
                    }
                }
            }
        });
        /* cover image responsive code */
        /*
            if ($(window).width() < 767) {
                $('.content .cover img').wrap('<div class="heroimage"></div>');
                if ($('.heroimage img').length) {
                    var imgSrc = $('.heroimage img').attr('src');
                    $('.heroimage img').css('opacity', '0');
                    $('.heroimage img').parent('.heroimage').css('background-image', 'url("' + imgSrc + '")');
                }
            }
        */
        $(".banner-img img").on("error", function() {
            var e = $(this).siblings("source").attr("srcset");
            var d = $(this).siblings("source").attr("data-image");
            $(this).siblings("source").attr("srcset", d)
        });
        
        
        
    });
</script>
<script src="{{ config('app.cloud_url').'/js/ui.min.js' }}" defer></script>
<!-- <script src="{{ config('app.cloud_url').'/assets/plugins/select2/js/select2.js' }}" defer></script> -->
@stack('scripts')

<?php if ($user_type_id == 3 || $user_type_id == 2) {?>
<style type="text/css">
	@media (min-width: 980px){
    header {
        padding: 10px 38px;
    }
	}
	@media (min-width: 414px){
	    header {
	        padding: 10px 20px;
	    }
	}
	header {
     padding: 10px 13px;
   }
   @media (min-width: 768px){
   	   header {
        padding: 10px 28px;
       }
   }
</style>
<?php }?>

@yield('page-script')
<!-- <script src="//hi.go-models.com/focus/1.js" type="text/javascript" charset="utf-8" async="async"></script> -->
</body>
</html>