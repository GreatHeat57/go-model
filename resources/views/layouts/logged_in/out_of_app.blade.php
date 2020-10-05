<!DOCTYPE html>
    <?php  
        $htmlLang = app()->getLocale();
        if(strtolower(config('app.locale')) == "de")
        {
            $htmlLang = strtolower(app()->getLocale()).'-'.strtoupper(app()->getLocale());
        }
    ?>
<html lang="{{ $htmlLang }}">
    <head>
        {!! config('constant.Google_Tag_Manager')!!} 
        {!! config('constant.Cookie_Google_Tag_Manager')!!}       
        <?php /*
        <!-- Google Tag Manager -->
        <!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T5RPTCX');</script> -->
        <!-- End Google Tag Manager -->
        */ ?>

        @include('layouts.logged_in.meta')
        @include('layouts.logged_in.head2')
    	@yield('scripts')
        <script src="{{ url(config('app.cloud_url').'/js/jquery-3.0.0.min.js') }}"></script>
        <script src="{{ url(config('app.cloud_url').'/assets/js/lazysizes.min.js') }}" defer></script>
    </head>
    <body>
        {!! config('constant.noscript_Google_Tag_Manager')!!}
        {!! config('constant.Cookie_noscript_Google_Tag_Manager') !!}      
        <?php /*
        <!-- Google Tag Manager (noscript) -->
        <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
        <!-- End Google Tag Manager (noscript) -->

        <!-- <button onclick="topFunction()" id="btnScrollTop" title="Scroll to top"><img src="{{ URL::to(config('app.cloud_url').'/images/icons/up-arrow-white.png') }}"/></button> -->
        */ ?>
        @include('layouts.header')

        <div class="px-13 px-sm-0 out-of-app-container">
            @yield('content')
        </div>

        <?php
        /*
        // $page = (new \App\Models\Page);
        // $page_terms = $page::where('type', 'terms')->where('active', '1')->trans()->first();
        // $page_termsclient = $page::where('type', 'termsclient')->where('active', '1')->trans()->first();
        */
        ?>

        {{ Html::script(config('app.cloud_url').'/js/sign_up.min.js') }}

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

        @include('internetExplorerPopup')
        @include('layouts.logged_in.footer')
        @include('layouts.mobile_menu')


        

        @yield('page-scripts')
        {{ Html::script(config('app.cloud_url').'/js/ui.min.js') }}
        <script type="text/javascript"> 
            var siteUrl = '<?php echo lurl('/'); ?>';
            // defined register popup url to convert based on local and get it pupop form action 
            var registerurl = "{{ lurl(trans('routes.register-from')) }}/";
        </script>

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
                                url: siteUrl + "/header-ajax-country-list",
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

            });
        </script>

        {{ Html::script(config('app.cloud_url').'/js/bladeJs/out_of_app-blade.js') }}
        {{ Html::style(config('app.cloud_url').'/css/bladeCss/out_of_app-blade.css') }}

        {{ Html::script(config('app.cloud_url').'/assets/croppie/2.6.2/croppie.js') }}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    </body>
</html>