
<input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
<input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>


<div class="message-list">
        <?php
        if (isset($conversations) && count($conversations) > 0) {
            
           foreach ($conversations as $key => $conversation) {

            /* $unreadCount = count($conversation->convunreadmessages); */
            
            $unreadCount = (isset($conversation->msgcount)? $conversation->msgcount : 0 ); 

            /*
            // $lastConversation = $conversation->convmessages->first();
            // $userName = $userProfile = $username = '';
            // $totalMessagesCount = count($conversation->totalmessages); 


            // if($lastConversation->from_user_id == auth()->user()->id){
            //     $userProfile = $lastConversation->to_user->profile;
            //     $full_name = $lastConversation->to_user->profile->full_name;
            //     $userName = $lastConversation->to_user->username;
            // }else{
            //     $userProfile = $lastConversation->from_user->profile;
            //     $full_name = $lastConversation->from_user->profile->full_name;
            //     $userName = $lastConversation->from_user->username;
            // }

            // $created_at =  $conversation->created_at;

            // if(isset($conversation->convmessages) && count($conversation->convmessages) > 0 ){
            //     if(isset($conversation->convmessages[0]->created_at) && !empty($conversation->convmessages[0]->created_at)){
            //         $created_at =  $conversation->convmessages[0]->created_at;
            //     }
            // }
            */

            $created_at =  ($conversation->created_at)? $conversation->created_at : '';

            $unreadClass = '';
            $unreadClassRound = '';

            if($conversation->user_is_read != "" && $conversation->user_is_read == 0){
                $unreadClass = 'unreaded';
                $unreadClassRound = 'bg-red';
            }
            
            ?>
               

                <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 {{ $unreadClass }} w-lg-920 w-xl-1220">
                    <div class="mr-md-40 mb-lg-30 mb-xl-0">
                        <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">

                            <?php $userUrl = lurl(trans('routes.user').'/'.(($conversation->username)? $conversation->username : '')); ?>

                            @if(isset($conversation->logo) && Storage::exists($conversation->logo))
                                <?php /* <a href="{{ $userUrl }}"><img src="{{ \Storage::url($conversation->logo) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img full-width" /></a> */ ?>
                                <?php $img = "<img src=".\Storage::url($conversation->logo)." alt=".trans('metaTags.Go-Models')." class='from-img full-width' />"; ?>
                                {!! App\Helpers\CommonHelper::createLink('view_profile', '', $userUrl, '', '', '','', $img, '') !!}
                            @else
                            <?php /*
                                <!-- <a href="{{ $userUrl }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                     {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                     {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a> --> */ ?>
                               <?php /* <a href="{{ $userUrl }}"><img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                                     {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                                     {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                     src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/></a>
                                     */ ?>

                                <?php $img = "<img srcset='".URL::to(config('app.cloud_url').'/images/user.png').",".
                                                     URL::to(config('app.cloud_url').'/images/user.png')." 2x,".
                                                     URL::to(config('app.cloud_url').'/images/user.png')."  3x'
                                     src='".URL::to(config('app.cloud_url').'/images/user.png')."' alt='trans('metaTags.Go-Models')' class='from-img nopic full-width'/>"; ?>

                                {!! App\Helpers\CommonHelper::createLink('view_profile', '', $userUrl, '', '', '','', $img, '') !!}
                            @endif
                        </div>
                    </div>
                    <div class="text-details">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                            <?php /*
                            <!--<span class="d-block">{{-- t('Conversation') --}} #{{-- $lastConversation->parent_id --}}</span>--> */ ?>
                        </div>

                        <?php 
                            
                            if(empty($conversation->title)){ 
                                $title = $conversation->first_name.' '.t('has contacted you');
                            ?>
                                
                                <a href="{{  lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><span class="title" title="{{ $title }}">{{ $title }}</span></a>
                            <?php } else { ?>

                                <a href="{{  lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><span class="title" title="{{ (isset($conversation->title))? $conversation->title : '' }}">{{ (isset($conversation->title))? ucfirst($conversation->title) : '' }}</span></a>
                            <?php }
                        ?>
                        
                        <div class="modelcard-top">
                            <a href="{{ $userUrl }}"><span class="d-inline-block overflow-wrap">{{ $conversation->full_name }}</span></a>
                        </div>
                        <div class="divider"></div>
                            <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><p class="overflow-wrap">{{ str_limit($conversation->message, config('constant.message_content_limit')) }}</p></a>
                        <div class="d-flex justify-content-start align-items-center">
                            
                            @if(isset($unreadClassRound) && !empty($unreadClassRound))
                                <?php /* <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}" title="{{ t('Click here to read the messages') }}"><span class="{{ $unreadClassRound }} d-xl-inline-block rounded-circle card-appointment-number bold mr-10">{{ $unreadCount }}</span></a> */ ?>

                                <?php $unreadClassRound = $unreadClassRound.' d-xl-inline-block rounded-circle card-appointment-number bold mr-10'; ?>
                                <?php $startspan = "<span class='".$unreadClassRound."' >"; ?> <?php $endspan = "</span>"; ?>
                                {!! App\Helpers\CommonHelper::createLink('view_conversations', $unreadCount, lurl('account/conversations/' . $conversation->parent_id . '/messages'), '', '', t('Click here to read the messages'),'', $startspan, $endspan) !!}
                            @endif

                            <span class="bold">{{ \App\Helpers\CommonHelper::getFormatedDate($created_at) 
                             }}</span>
                        </div>
                    </div>
                </div>


            <?php } ?>
    </div>

        @if(isset($is_last_page) && (!$is_last_page) )
            <div class="text-center"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('load more') }}</a></div>
        @endif


        <?php } else {?>
                <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">
                        {{ t('No results found') }}
                    </h5>
                </div>
        <?php } ?>


@section('page-script')
<script type="text/javascript">
    
    $(document).ready(function(){

        $('#msg-search-submit').click( function(e){
            e.preventDefault();
            $("#search-form").submit();
        });


        if($("#is_last_page").val() == 1){
            $("#more-posts").addClass("disabled");
        }

        var search = $('#search_input').val();

        $('.more-posts').click(function(){
            
            var url = '<?php echo lurl(trans('routes.messages')); ?>';  
            var pageNo = $("#pageNo").val();
            var formData = { page : pageNo, search : search }

            var type = 'post';
            var is_last_page = $("#is_last_page").val();

            if (is_last_page == 1) {
                return false;
            }
                    
            var data = formData;

            $.ajax({
                url: url,
                type : type,
                dataType :'json',
                data : data,
                beforeSend: function(){
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                },
                success : function(res){

                    var append = $(res.html).filter(".message-list").html();

                    $("#pageNo").val(res.pageNo);
                    
                    if(res.is_last_page == 1){
                        $("#is_last_page").val(res.is_last_page);
                        $("#more-posts").addClass("disabled");
                        $("#more-posts").hide();
                    }

                    $('.message-list').append(append);
                }
            });
        });
    });
</script>
@endsection


        <?php /*
        if (isset($conversations) && $conversations->count() > 0) {
	       foreach ($conversations as $key => $conversation) {

    		// Get the latest reply
    		// $latestReply = $conversation->latestReply();

                $unreadCount = count($conversation->userUnreadConversation); 
                $lastConversation = $conversation->userConversation->last();

                if($lastConversation->from_user_id == auth()->user()->id){
                    $userProfile = $lastConversation->to_user->profile;
                    $userName = $lastConversation->to_user->username;
                }else{
                    $userProfile = $lastConversation->from_user->profile;
                    $userName = $lastConversation->from_user->username;
                }
            ?>
               

                <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 {{ (count($conversation->convunreadmessages) > 0)? 'unreaded' : ''}} w-lg-750 w-xl-1220">
                    <div class="mr-md-40 mb-lg-30 mb-xl-0">
                        <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">

                            @if(\Auth::check() && \Auth::User()->user_type_id == 2)

                                @if(file_exists(public_path('uploads').'/'.$conversation->from_user_profile))
                                <a href="{{ URL::to($conversation->post->uri) }}"><img src="{{ \Storage::url($conversation->from_user_profile) }}" alt="Go Models" class="from-img full-width" style="width: 102%;" /></a>

                                @else
                                    <a href="{{ URL::to($conversation->post->uri) }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                     {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                     {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                                @endif

                            @else

                                @if(file_exists(public_path('uploads').'/'.$conversation->from_user_profile))
                                    <a href="{{ URL::to($conversation->post->uri) }}"><img src="{{ \Storage::url($conversation->from_user_profile) }}" alt="Go Models" class="from-img full-width" style="width: 102%;" /></a>

                                @else
                                    <a href="{{ URL::to($conversation->post->uri) }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                     {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                     {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                            <span class="d-block">{{t('Conversation')}} #{{ $conversation->id }}</span>
                            <!-- <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">kategoria</span> -->
                        </div>
                        <a href="{{ URL::to($conversation->post->uri) }}"><span class="title">{{ str_limit($conversation->title,35) }}</span></a>
                        <div class="modelcard-top">
                            @if(\Auth::check() && \Auth::User()->user_type_id == 2)
                                <!-- <span class="d-inline-block">{{ $conversation->to_user_name }}</span> -->
                                <span class="d-inline-block">{{ $conversation->from_user_name }}</span>
                            @else
                                <!-- <span class="d-inline-block">{{ $conversation->from_user_name }}</span> -->
                                <span class="d-inline-block">{{ $conversation->to_user_name }}</span>
                                @if($conversation->contact_name != $conversation->from_user_name)
                                <!-- <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                                <span class="d-inline-block">{{ $conversation->contact_name }}</span> -->
                                @endif
                            @endif
                        </div>
                        <div class="divider"></div>

                        @if(\Auth::check() && \Auth::User()->user_type_id == 2)
                            @if($conversation->from_user_id ==  \Auth::User()->id)
                                <p>{{ trans('mail.model_accepted_invitation') }}</p>
                            @else
                                <p>{{ trans('mail.apply_for_job') }}</p>
                            @endif
                        @else
                            @if($conversation->from_user_id ==  \Auth::User()->id)
                                <p>{{ trans('mail.you_have_applied_for_job') }}</p>
                            @else
                                <p>{{ trans('mail.partner_invite_you_for_Job') }}</p>
                            @endif
                        @endif
                        <!-- <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30"> -->
                        <div class="d-flex justify-content-start align-items-center">
                            <a href="{{ lurl('account/conversations/' . $conversation->id . '/messages') }}"><span class="d-xl-inline-block rounded-circle bg-green card-appointment-number bold mr-10">{{ count($conversation->convunreadmessages) }}</span></a>
                            <span class="bold">{{ $conversation->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</span>
                        </div>
                    </div>
                </div>


            <?php }?>


        <?php } else {?>
                <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">
                        {{ t('No results found') }}
                    </h5>
                </div>

        <?php } ?>
        
            @if(!empty($conversations))
            <div class="row col-md-12">
                <div class="row mx-0 mx-lg-auto position-relative w-xl-1220 pagination-bar">
                    @include('customPagination', ['paginator' => $conversations])
                </div>
            </div>
            @endif
   <?php */ ?>