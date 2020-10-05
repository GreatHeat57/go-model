@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
<?php
if (isset($conversation) && !empty($conversation) > 0) {

    // Conversation URLs
    $consUrl = lurl('account/conversations');
    $conDelAllUrl = lurl('account/conversations/' . $conversation->id . '/messages/delete');

    $post = !empty($conversation->post) ? $conversation->post : '';

    $job_url = '';
    $post_title = '';
    if ($is_direct_message != 1 && isset($conversation->post) && !empty($conversation->post)) {
        $post = $conversation->post;
        $job_url = $post->uri;
        $post_title = $post->title;
    }
?>
    <div class="container pt-40 px-0">
        <h1 class="prata text-center">{{ t("Messages") }} </h1>
        <div class="divider mx-auto"></div>
        <h4 class="prata text-center pt-20 pb-20 bold"><a>{{ $post_title }}</a></h4>

        <?php /*
        <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0" wfd-id="34">
           <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back') }}</a>
        </div>
        <?php */ ?>

        <div class="row">
            <div class="col-md-12 text-center mb-30 xl-to-right-0 xl-to-top-0" wfd-id="34">
               <a href="{{ lurl(trans('routes.messages')) }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back') }}</a>
            </div>
        </div>
        <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
        </div>

        <div class="dividermx-auto"></div>
        <div class="custom-tabs mb-20 mb-xl-30">
            <?php /* {{ Form::select('tabs',[1 => 'Details', 2 => 'Messages'],null) }} {{ route('message-details') }} */ ?>
            <ul class="d-none d-md-block">
                <?php if($is_direct_message != 1){ ?> 
                    <li><a href="{{ route('message-job',['id' => $conversation->id, 'jobId' => $post->id]) }}">{{ t('Job\'s Details')  }}</a></li>
                <?php } ?>
                
                <li><a href="{{ route('message-texts',['id' => $conversation->id]) }}" class="position-relative active">{{ t('Messages') }}</a></li>
            </ul>
        </div>
        <div class="w-xl-1220 mx-xl-auto">
            <div class="bg-white box-shadow mb-40">
                <div class="d-flex justify-content-md-between align-items-center py-sm-20 px-38 bb-md-down-grey2">
                    @if($conversation->from_user_id == \Auth::User()->id)
                        <div class="d-flex align-items-center">
                            <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-60">
                                @if(!empty($profile_image_from) && file_exists(public_path('uploads').'/'.$profile_image_from))
                                <img src="{{ \Storage::url($profile_image_from) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img-radius fit-conver full-width image_responsive"/>
                                @else
                                <!-- <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/> -->
                                     <img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                     src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/>
                                @endif
                            </div>
                            <p class="w-112 mb-0 overflow-wrap">
                                <span class="bold overflow-wrap">{{$to_user_name}}</span>
                                @if(!$is_operator)
                                <span>{{ ($to_user_city !== '')? $to_user_city.',' : '' }} {{$to_user_country}}</span>
                                @endif
                                <?php /*
                                <span> {{ \App\Helpers\CommonHelper::getFormatedDate( $conversation->created_at) }} </span> */?>
                            </p>
                        </div>

                        <div class="d-none d-md-block justify-content-start py-10">
                            <!-- <a href="#" class="btn btn-white post_white mini-all mr-20"></a> -->
                            <a target="_blank" href="{{ lurl(trans('routes.user').'/'.$conversation->to_user->username) }}" class="btn btn-white insight mini-all" title="{{ t('View profile') }}"></a>
                        </div>
                    @else
                        <div class="d-flex align-items-center">
                            <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-60">
                                @if(!empty($profile_image) && file_exists(public_path('uploads').'/'.$profile_image))
                                <img src="{{ \Storage::url($profile_image) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img-radius fit-conver full-width image_responsive"/>
                                @else
                                <!-- <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/> -->
                                     <img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                     src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/>
                                @endif
                            </div>
                            <p class="w-112 mb-0 overflow-wrap">
                                <span class="bold overflow-wrap">{{$from_user_name}}</span>
                                @if(!$is_operator)
                                <span dd="ds">{{ ($from_user_city !== '')? $from_user_city.',' : '' }} {{$from_user_country}}</span>
                                @endif
                                <?php /*
                                <span> {{ \App\Helpers\CommonHelper::getFormatedDate( $conversation->created_at) }} </span> */ ?>
                            </p>
                        </div>

                    <div class="d-none d-md-block justify-content-start py-10">
                        <!-- <a href="#" class="btn btn-white post_white mini-all mr-20"></a> -->
                            <a target="_blank" href="{{ lurl(trans('routes.user').'/'.$conversation->from_user->username) }}" class="btn btn-white insight mini-all" title="{{ t('View profile') }}"></a>
                    </div>
                    @endif
                    
                </div>
                <div class="d-flex d-md-none justify-content-center py-10">
                    <!-- <a href="#" class="btn btn-white post_white mini-all mr-20"></a> -->
                    <!-- <a href="#" class="btn btn-white insight mini-all"></a> -->
                    @if($conversation->from_user_id == \Auth::User()->id)
                        <a target="_blank" href="{{ lurl(trans('routes.user').'/'.$conversation->to_user->username) }}" class="btn btn-white insight mini-all" title="{{ t('View profile') }}"></a>
                    @else
                        <a target="_blank" href="{{ lurl(trans('routes.user').'/'.$conversation->from_user->username) }}" class="btn btn-white insight mini-all" title="{{ t('View profile') }}"></a>
                    @endif
                </div>
            </div>

            @if(isset($total_pages) && $total_pages > 1)
                <div class="text-center mb-40"><a class="btn btn-default refresh previous-msg">{{ t('load previous') }}</a></div>
            @endif
            <div class="text-center mb-40"><a class="btn btn-default refresh previous-msg hide-link" style="display: none">{{ t('load previous') }}</a></div>
            
            <div class="bg-white ">
                <div class="px-38">
                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                </div>
            </div>
            
            <div class="msg-texts py-40">
              
                <!-- All Conversation's Messages -->
                <?php

                    $previous_date = '';
                    $previous_date_arr = array();
                    if (isset($messages) && $messages->count() > 0) {
                        $index = ($messages->count() - 1);
                        foreach ($messages as $key => $message) {
                            $showhr = false;
                            // echo $message->created_at->format('d-m-y') . '  ' . $previous_date;
                            if ($message->from_user_id == auth()->user()->id) {
                                $chatclass = 'justify-content-end';
                                $shadowclass = 'bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p details-desc';

                            } else {
                                $chatclass = 'justify-content-start';
                                $shadowclass = 'bg-white box-shadow border py-20 px-20 w-75p';
                            }
                            if ($key == $index) {
                                $previous_date = $message->created_at->format('d-m-y');
                            }
                            if ($message->created_at->format('d-m-y') == $previous_date && !in_array($previous_date, $previous_date_arr)) {
                                $showhr = true;
                                array_push($previous_date_arr, $previous_date);
                            }

                            ?>
                            @if($showhr = false)
                            <div class="date-divider text-center my-40 mb-40">
                                <span>{{ \App\Helpers\CommonHelper::getFormatedDate($message->created_at) }}</span>
                            </div>
                            @endif
                            <div class="d-flex {{$chatclass}} mb-20">
                                @if(\Auth::User()->id != $message->from_user_id )
                                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-27 img-md-49">


                                    <?php
                                        if($conversation->from_user_id == $message->from_user_id)
                                        {
                                            $message_user_profile = $profile_image;
                                        }
                                        else
                                        {
                                            $message_user_profile = $profile_image_from;
                                        }
                                    ?>
                                        @if(!empty($message_user_profile) && file_exists(public_path('uploads').'/'.$message_user_profile))
                                            <img src="{{ \Storage::url($message_user_profile) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img-radius fit-conver full-width "/>
                                        @else
                                            <!-- <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/> -->
                                                <img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                                 src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/>
                                        @endif
                                    </div>
                                @endif

                                <div class="  {{ $shadowclass }} details-desc  msg_hover" id="{{ 'message'.$message->id }}">
                                    <?php /*
                                    @if ($message->from_user_id == auth()->user()->id)
                                    <span title="{{ t('Delete') }}" class="btn-invitation btn-rejected rejected delete-btn-msg" id="{{ 'msg-'.$message->id }}"></span>
                                    @endif
                                    <?php */ ?>
                                    <p class="mb-10 msg_hover overflow-wrap ">{!! \App\Helpers\CommonHelper::geturlfromstring(nl2br($message->message)) !!}</p>
                                    @if(!empty($message->filename))
                                    <div class="text-left"><a target="_blank" class="bold" href="{{ $message->filename }}">{{ t('View Attached Photos') }}</a></div>
                                    @endif
                                    <div class="text-right dark-grey2 f-14 lh-15">{{ \App\Helpers\CommonHelper::getFormatedDate($message->created_at, true) }} </div>
                                </div>
                            </div>
                            <?php
                            $previous_date = $message->created_at->format('d-m-y');
                        }
                    }
                ?> 
            
                <input type="hidden" name="current_page"  id="current_page" value="{{ $current_page }}">
                <input type="hidden" name="is_last_page" id="is_last_page" value="{{ $is_last_page }}">
                <input type="hidden" name="next_page" id="next_page" value="{{ $next_page }}">
            </div>
<?php }?>
        </div>
    </div>
    @include('childs.model-bottom-bar-write-message')
@endsection

@section('page-script')
    <style type="text/css">
        .from-img-radius { width: 100%; height: 100%; border-radius: 50%; }
        .delete-btn-msg { background-position: top 0px right; background-repeat: no-repeat;  background-size: 14px;  float: right; cursor: pointer;}
    </style>
    <script>
        $(document).ready( function(){

            var siteUrl = window.location.origin;

            $('#send-message').click( function(event){
                event.preventDefault();

                if($('#message').val().length == 0){
                    return false;
                }

                var message = $('#message').val();

                if( message != "" && message != undefined && message != null ){
                    var token = $("input[name=_token]").val();
                    var conversationId = '<?php echo $conversation_id; ?>';
                    var url = "/account/conversations/"+conversationId+"/reply";

                    $.ajax({
                        method: "post",
                        url: siteUrl + url,
                        data:{ 'message' : message, '_token' : token},
                        beforeSend: function(){
                            $(".loading-process").show();
                            $('#send-message').attr("disabled", true);
                        },
                        complete: function(){
                            $(".loading-process").hide();
                            $('#send-message').attr("disabled", false);
                        }
                    }).done(function(response) {

                        $('.print-error-msg').html('');
                        $('.print-success-msg').html('');
                        var label = '<?php echo trans('Delete'); ?>';

                        if( response.status == true ){ 
                            
                            var html = '<div class="d-flex justify-content-end mb-20">'+'<div class="bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p details-desc msg_hover" id="message'+response.messageId+'">'+'</span><p class="mb-10 overflow-wrap">'+response.msg+'</p>'+'<div class="text-right dark-grey2 f-14 lh-15">'+response.date+'</div>'+'</div></div>';

                            // '<span title="'+label+'" class="btn-invitation btn-rejected rejected delete-btn-msg" id="msg-'+response.messageId+'">'+
                            $('.msg-texts').append(html);

                            // $('.print-success-msg').html(response.message);
                            // $('.print-success-msg').show();

                            $('html, body').animate({scrollTop:$(document).height()}, 'slow');

                            if(response.pagination == false){
                                $(".previous-msg").addClass("disabled");
                                $('.previous-msg').hide();
                                $('.hide-link').hide();
                            }

                            if(response.pagination == true){
                                $(".previous-msg").removeClass("disabled");
                                $('.previous-msg').hide();
                                $('.hide-link').show();
                            }
                            
                            $('#message').val('');
                        }else{
                            
                            if (typeof response.message == "string"){
                                $('.print-error-msg').html(response.message);
                            }else{
                                $.each(response.message, function(key, value) {
                                    $('.print-error-msg').html(value);
                                });
                            }

                            $('.print-error-msg').show();
                        }

                        setTimeout(function(){
                            $(".print-error-msg").html('');
                            $(".print-success-msg").html('');
                            $('.print-error-msg').hide();
                            $('.print-success-msg').hide();
                        }, 10000);
                    });
                }
               
            });

            $(document).on('click', '.delete-btn-msg',function(e){
                
                e.preventDefault();
                var msgid = $(this).attr('id');

                if(msgid != "" && msgid != undefined && msgid != null){
                    msgidArr = msgid.split('-');
                    
                    if(msgidArr[1] != "" && msgidArr[1] != undefined && msgidArr[1] != null){
                        
                        var msg_id = msgidArr[1];
                        var token = $("input[name=_token]").val();
                        var conversationId = '<?php echo $conversation->id; ?>';

                        $.ajax({
                            method: "post",
                            url: siteUrl + "/account/messages/delete",
                            data:{ 'msg_id' : msg_id, '_token' : token, 'conversationId' : conversationId},
                            beforeSend: function(){
                                //$(".loading-process").show();
                            },
                            complete: function(){
                                //$(".loading-process").hide();
                            }
                            }).done(function(response) {

                            $('.print-error-msg').html('');
                            $('.print-success-msg').html('');

                            if( response.status == true ){ 
                                $('#message'+msg_id).remove();
                                // $('.print-success-msg').html(response.message);
                                // $('.print-success-msg').show();

                                if(response.pagination == false){
                                    $(".previous-msg").addClass("disabled");
                                    $('.previous-msg').hide();
                                    $('.hide-link').hide();
                                }

                            }else{ 
                                $('.print-error-msg').html(response.message);
                                $('.print-error-msg').show();
                            }

                            setTimeout(function(){
                                $(".print-error-msg").html('');
                                $(".print-success-msg").html('');
                                $('.print-error-msg').hide();
                                $('.print-success-msg').hide();
                            }, 4000);

                        });
                    }   
                }
            });


            $('.previous-msg').click(function(event){
                    event.preventDefault();

                    var next_page = $('#next_page').val();

                    var url = '<?php echo url()->current(); ?>?page='+next_page;

                    if(next_page != "" && next_page != undefined && next_page != null){
                        $.ajax({
                            url: url,
                            type : 'get',
                            beforeSend: function(){
                                $(".loading-process").show();
                            },
                            complete: function(){
                                $(".loading-process").hide();
                            },
                            success : function(res){

                                if(res.success == true){

                                    $('.msg-texts').prepend(res.html);
                                    $('#current_page').val(res.current_page);
                                    $('#is_last_page').val(res.is_last_page);
                                    $('#next_page').val(res.next_page);
                                    
                                    // $(window).scrollTop(100);

                                    if(res.next_page == undefined || res.next_page == "" || res.next_page == null){
                                        $(".previous-msg").addClass("disabled");
                                    }
                                }
                            }
                        });
                    }
                    
                });
        })
    </script>
@endsection