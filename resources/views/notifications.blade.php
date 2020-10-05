@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

<style type="text/css">
   .notification a{ text-decoration:none; }
</style>

@section('content')
<div class="container pt-40 pb-60 px-0 w-xl-1220">
    <div class="text-center mb-30 position-relative">
        <div>
            <h1 class="text-center prata">{{ ucWords(t('Invitations')) }}</h1>
            <div class="divider mx-auto"></div>
        </div>
        <div class="position-absolute-md md-to-right-0 md-to-top-0">
            <a class="btn btn-white search mini-under-desktop">{{ t('Search') }}</a>
        </div>
    </div>

    <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
        <div class="w-md-440 mx-md-auto">
            
            <?php /*
            <form method="POST" action="{{ url()->current() }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input class="search_notification"  placeholder="Search" name="search" type="text" value="{{ (isset($search))? $search : '' }}" autocomplete="off">
                <input type="submit" value="Keresés" id="notification-submit">
           </form>
           <?php */ ?>

            <form method="POST" action="{{ url()->current() }}" accept-charset="UTF-8" id="search-form">
                
                {{ csrf_field() }}
                
                <div class="input-bar">
                    <div class="input-bar-item width100">
                        <div class="form-group">

                            {{ Form::text('search', null, ['id' => 'searchtext', 'class' => 'width100', 'placeholder' => t('Search'),'autofocus'=>'autofocus', 'required'=> 'required']) }}
                        </div>
                    </div>
                    <div class="input-bar-item">
                        <input type="button" class="btn btn-white search no-bg" value="" id="notification-submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    
    $options = [ 1 => 'Applications', 2 => 'Invites', 3 => 'Rejected'];

    $invited_active = '';
    $accepted_active = '';
    $rejected_active = '';
    $all_active = '';
     
    if($status == 0){ 
        $invited_active = 'active';
    }else if ($status == 1) {
        $accepted_active = 'active';
    }else if($status == 2){
        $rejected_active = 'active';
    }else{
        $all_active = 'active';
    }

    $tabs = array();
    
    $tabs[ lurl(trans('routes.notifications', ['countryCode' => config('country.icode')])) ] = t('All');

    $tabs[ lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Invited')) ])) ] = t('Invited');

    $tabs[ lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Accepted')) ])) ] = t('Accepted');

    $tabs[ lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Rejected')) ])) ] = t('Rejected');
?>

    <div class="custom-tabs mb-20 mb-xl-30">
        {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}

        <ul class="d-none d-md-flex justify-content-center">
            <li>
                <a href="{{ lurl(trans('routes.notifications', ['countryCode' => config('country.icode')])) }}" class="<?php  echo $all_active; ?> position-relative" data-id="0" data-status="all" >{{ t('All') }}
                    <?php if( $total_notifications > config('app.num_counter') ){ ?>
                        <span class="msg-num tab invited">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num tab invited">{{ $total_notifications }}</span>
                    <?php } ?>
                </a>
            </li>
            <li>
                <a href="{{  lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Invited')) ])) }}" id="<?php  echo $invited_active; ?>" data-id="2" data-status="Invited"  class="position-relative <?php echo $invited_active; ?>">{{ t('Invited') }}

                    <?php if( $total_invited > config('app.num_counter') ){ ?>
                        <span class="msg-num tab ongoing num-invited">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num tab ongoing num-invited">{{ $total_invited }}</span>
                    <?php } ?>
                </a>
            </li>
            <li>
                <a href="{{ lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Accepted')) ])) }}" id="<?php  echo $accepted_active; ?>" data-id="1" data-status="Accepted" class="position-relative <?php echo $accepted_active; ?>">{{ t('Accepted') }}

                    <?php if( $total_invited > config('app.num_counter') ){ ?>
                        <span class="msg-num tab applied num-applied">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num tab applied num-applied">{{ $total_accepted }}</span>
                    <?php } ?>
                </a>
            </li>
            <li>
                <a href="{{ lurl(trans('routes.v-notifications', ['countryCode' => config('country.icode'), 'status' => strtolower(t('Rejected')) ])) }}" id="<?php  echo $rejected_active; ?>" data-id="3" data-status="Rejected" class="position-relative <?php echo $rejected_active; ?>">{{ t('Rejected') }}
                   
                    <?php if( $total_rejected > config('app.num_counter') ){ ?>
                        <span class="msg-num tab rejected num-rejected">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num tab rejected num-rejected">{{ $total_rejected }}</span>
                    <?php } ?>
                </a>
            </li>
        </ul>
    </div>
@if(count($notifications) > 0)
    <div class="row mx-0 justify-content-md-center notification-sections">
        @foreach($notifications as $notification)
            <?php
                $classStatus = 'ongoing';
                $notification_status = strtolower( t('Pending') );
                $notification_message = t('Model still needs to accept or reject this invitation');
                $notification_message_model = '';

                if ($notification['invitation_status'] == 1) {
                    
                    $classStatus = 'applied';
                    $notification_status = strtolower( t('Accepted') );
                    $notification_message = '';
                }else if($notification['invitation_status'] == 2){
                    
                    $classStatus = 'rejected';
                    $notification_status = strtolower( t('Rejected') );
                    $notification_message = t('Model has rejected the invitation');
                    $notification_message_model = t('You have rejected the invitation');
                }
                if(Auth::user()->user_type_id == config('constant.model_type_id')){
                    $to_from = t('From');
                }else{
                    $notification['profile_pic'] = isset($notification['to_profile_pic']) ? $notification['to_profile_pic'] : '';
                    $to_from = t('To');
                }
            ?>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification notification-div {{ ($slug === 'Invited')? 'invite_'.$notification['id'] : '' }}">
                <!-- unreaded -->
                @if($notification['uri'] != "")
                    <?php
                        $notification_status 
                    ?>
                    <a href="{{ lurl($notification['uri']) }}" title="{{ t('Invitation :status Click to see job detail',['status' => $notification_status]) }}">

                        <span class="flag to-left-30 to-top-0 {{$classStatus}}"></span>
                    </a>
                @else
                    <span class="flag to-left-30 to-top-0 {{$classStatus}}"></span>
                @endif
                <div class="col-md-6 mt-20 pt-40 pb-20 pb-md-0 px-0 bordered pr-md-4">
                    @if($notification['uri'] != "")
                    <?php /*<a href="{{ lurl($notification['uri']) }}">
                        <span class="title">{{ $notification['title'] }}</span>
                    </a> */ ?>
                    <?php $start_tag = "<span class='title'>"; $close_tag = "</span>"; ?>
                    {!! App\Helpers\CommonHelper::createLink('view_jobs', $notification['title'], lurl($notification['uri']), '', '','','',$start_tag, $close_tag) !!}

                    @else
                        <span class="title">{{ $notification['title'] }}</span>
                    @endif
                    <span class="overflow-wrap">{!! str_limit(strCleaner($notification['description']), config('constant.description_limit')) !!}</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">{{ \App\Helpers\CommonHelper::getFormatedDate($notification['created_at']) }}</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4 ">
                    <span class="dark-grey2 posted mb-10">{{ $to_from }}</span>
                    <div class="d-flex justify-content-start align-items-center mb-10">
                        <div class="image_responsive from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            
                            @if($notification['profile_pic'] != '')
                                <img srcset="{{ $notification['profile_pic'] }}" src="{{ $notification['profile_pic'] }}" alt="{{ trans('metaTags.Go-Models') }}" class="image_responsive from-img full-width img-width-round fit-conver "/>
                            @else
                            <?php /*
                            <!-- <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                            {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                            {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                            src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                            class="from-img full-width"/> -->
                            */ ?>
                            <img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                            {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                            {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                            src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}"
                            class="from-img full-width fit-conver"/>
                            @endif
                        </div>
                        <span class="title overflow-wrap">{{ ucwords($notification['name']) }}</span>
                    </div>
                    
                    @if(!empty($notification_message) && Auth::user()->user_type_id == config('constant.partner_type_id'))
                        <span class="pt-20">{{ $notification_message }}</span>
                    @endif

                    @if(!empty($notification_message_model) && Auth::user()->user_type_id == config('constant.model_type_id'))
                        <span class="pt-20">{{ $notification_message_model }}</span>
                    @endif

                    @if($notification['invitation_status'] == 0 && Auth::user()->user_type_id == config('constant.model_type_id'))
                        <div class="col-md-8 pt-40 pb-20 px-0 status-btn-{{ $notification['id'] }}">
                            <span class="title d-flex justify-content-start align-items-center">
                                

                                <?php /* <a href="{{ url('/account/invtresp/1/'.$notification['id']) }}" class="btn-invitation btn-applied mr-20 accepted-btn" id="{{ $notification['id'] }}" title="{{ t('Accept') }}"></a> */ ?>

                                <?php $acceptcls = 'btn-invitation btn-applied mr-20'; ?>
                                @can('invited_jobs', Auth::user())
                                    <?php $acceptcls = 'btn-invitation btn-applied mr-20 accepted-btn'; ?>
                                @endcan


                                {!! App\Helpers\CommonHelper::createLink('invited_jobs', '', url('/account/invtresp/1/'.$notification['id']), $acceptcls, $notification['id'],'', t('Accept')) !!}

                                &nbsp;
                                
                                <?php /* <a href="{{ url('/account/invtresp/2/'.$notification['id']) }}" class="btn-invitation btn-rejected rejected-btn" id="{{ $notification['id'] }}" title="{{ t('Reject') }}"></a> */ ?>

                                <?php $rejectcls = 'btn-invitation btn-rejected'; ?>
                                @can('invited_jobs', Auth::user())
                                    <?php $rejectcls = 'btn-invitation btn-rejected rejected-btn'; ?>
                                @endcan

                                {!! App\Helpers\CommonHelper::createLink('invited_jobs', '', url('/account/invtresp/2/'.$notification['id']), $rejectcls, $notification['id'],'', t('Reject')) !!}

                            </span>
                            <span class="pt-20">{{ t('Partner has sent invitation') }}</span>
                        </div>
                    @endif
                    <div class="col-md-12 px-0">
                        <div class="alert alert-danger print-error-msg-{{$notification['id']}}" style="display:none"></div>
                        <div class="alert alert-success print-success-msg-{{$notification['id']}}" style="display:none"></div>
                    </div>
                    <span id="hidden-url-{{$notification['id']}}" style="display: none;">
                        <a class="notification" href=""  style="text-decoration: underline;">{{ t('click here') }}</a>{{ t('to send a Message') }}
                    </span>
                    @if($notification['invitation_status'] == 1)
                        <span>
                            <a class="notification" href="{{ lurl('account/conversations/' . $notification['id'] . '/messages') }}" style="text-decoration: underline;">{{ t('click here') }}</a>{{ t('to send a Message') }}
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white not-found-main text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
        <h5 class="prata">
            {{ t('No results found') }}
        </h5>
    </div>
@endif
    
    <div class="text-cente pt-40 mb-30 position-relative">
        @include('customPagination')
    </div>
    <div class="bg-white not-found text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30" style="display: none;">
        <h5 class="prata">
            {{ t('No results found') }}
        </h5>
    </div>
</div>
@include('childs.bottom-bar')
@endsection
@section('page-script')
<style>
    .search_notification{
        height: 54px;
        line-height: 56px !important;
        border: 1px solid #c2c2c2 !important;
        padding: 0 20px;
        padding-bottom: 0px !important;
    }

    .img-width-round {width: 100% !important; border-radius: 50% !important; height: 100%; }
    @media (min-width: 320px) and (max-width: 480px) {
    .img-width-round {width: 70px !important; height: 70px; }    
    }
    @media (min-width: 768px) {
     .img-width-round {width: 70px !important; height: 70px; }       
    }
</style>
<script type="text/javascript">
    var notification_msg = '{{t('No notifications found')}}';
    $('#notification-submit').click( function(e){
        e.preventDefault();
        $("#search-form").submit();
    });

    $('.rejected-btn').click( function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var ivt_id = $(this).attr('id');
        sendinviationstatus(url, 'rejected', ivt_id);
    });

    $('.accepted-btn').click( function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var ivt_id = $(this).attr('id');
        
        sendinviationstatus(url, 'accepted', ivt_id);
    });
    function sendinviationstatus(url, status, ivt_id){
                
        var invt_status = 1;
        
        if(status === 'rejected' ){
            invt_status = 0;
        }

        $.ajax({
            method: "get",
            url: url,
            beforeSend: function(){
                $(".loading-process").show();
            },
            complete: function(){
                $(".loading-process").hide();
            }
        }).done(function(response) {
            
            $(".print-error-msg-"+ivt_id).html('');
            $(".print-success-msg-"+ivt_id).html('');
            $(".print-success-msg-"+ivt_id).css('display','none');
            $(".print-error-msg-"+ivt_id).css('display','none');

            if(response.status == true){
                $(".print-success-msg-"+ivt_id).css('display','block');
                $(".print-success-msg-"+ivt_id).append('<p>'+response.msg+'</p>');

                $('.status-btn-'+ivt_id).remove();           
                // if invitation is accepted then increate accepted  count  and decrease inviation count
                if(response.invitation_status == '1'){
                    var invited_num = parseInt($('.num-invited').html());
                    var accetped_num = parseInt($('.num-applied').html());

                    $('.num-invited').html((invited_num - 1));
                    $('.num-applied').html((accetped_num + 1));
                    $('#hidden-url-'+ivt_id).find('a').attr('href', response.url);
                    $('#hidden-url-'+ivt_id).show();
                }

                // if invitation is rejected then increate rejected  count and decrease inviation count
                if(response.invitation_status == '2'){
                    var invited_num = parseInt($('.num-invited').html());
                    var rejected_num = parseInt($('.num-rejected').html());  

                    $('.num-invited').html((invited_num - 1));
                    $('.num-rejected').html((rejected_num + 1));
                }                 
            } else {
                $(".print-error-msg-"+ivt_id).css('display','block');
                
                if (typeof response.msg == "string") {
                    $(".print-error-msg-"+ivt_id).append('<p>'+response.msg+'</p>');

                } else {
                    $.each( response.msg, function( key, value ) {
                        $('#'+key).addClass('invalid-input');
                        $(".print-error-msg-"+ivt_id).append('<p>'+value[0]+'</p>');
                    });
                }               
            }
            // no more notifictions found then close the div
            var numItems = $('div.notification-div').length;
            if(numItems == '0' ){
                $('.not-found-main').hide();
                $('.not-found').show();
            }
        });
    }
</script>
@endsection