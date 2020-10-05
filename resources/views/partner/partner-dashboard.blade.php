@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30">
            <h1 class="prata">{{ ucWords(t('Welcome back')) }}</h1>
            <div class="divider mx-auto"></div>
        </div>
        
        @if(auth()->user()->profile->allow_search != 1)
            <?php $href = lurl(trans('routes.partner-profile-edit')); ?>
            <?php $label = t('click here'); ?>
            <?php $button = "<a href='$href' style='margin-right: 6px; margin-left: 6px; text-decoration: underline;  margin-top: 1px;'>$label</a>"; ?>

            <span class="text-center mt-20 mb-30 mx-lg-auto notes-zone dashboard-allow-search">{!! t("allow search false alert to client :button", ['button' => $button]) !!}</span>
        @endif

        <div class="mx-auto">
            @include('childs.notification-message')
        </div>

        <!-- start tabbing  -->
        <div class="custom-tabs mb-20 mb-xl-30">
            <select  name="dash_dropdown" id="dash_dropdown"  class="form-control select-2">
                <option value="1">{{ t('social media') }}</option>
                <option value="2">{{t('My ads')}}</option>
                <option value="3">{{ t('Messages') }}</option>

                @if(Gate::check('list_models', $user))
                <option value="4">{{ t('New models near you') }}</option>
                @endif

            </select>
            <ul class="d-none d-md-flex justify-content-center">
                <li  id="social_tab" >
                    <a  class=" position-relative active" data-id="0" data-status="all" id="social_active" >{{ t('social media') }}
                    </a>
                </li>
                <li id="post_tab" >
                   
                    <a  class=" position-relative" data-id="0" data-status="all" id="post_active" >
                        {{ t('My ads') }}
                        @if(isset($countMyPosts) && $countMyPosts > 0)
                            <?php if( $countMyPosts > config('app.num_counter') ){ ?>
                                <span class="msg-num tab dashboard">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num  tab dashboard">{{ $countMyPosts }}</span>
                            <?php } ?>
                        @endif
                    </a>

                     <?php /*
                    <?php $titlemyjobs =  t('My ads'); 
                    if(isset($countMyPosts) && $countMyPosts > 0){
                        if( $countMyPosts > config('app.num_counter') ){
                            $titlemyjobs .= " <span class='msg-num tab dashboard'>".config('app.num_counter').'+'."</span>";
                        } else {
                            $titlemyjobs .= " <span class='msg-num  tab dashboard'>$countMyPosts</span>";
                        }
                    }
                    ?>
                    {!! App\Helpers\CommonHelper::createLink('my_jobs', $titlemyjobs, '#', 'position-relative', 'post_active','','data-id="0" data-status="all"') !!}
                     */?>

                </li>
                <li id="massges_tab">
                   
                    <a  class=" position-relative" data-id="0" data-status="all" id="massges_active">
                        {{t('Messages')}}
                        @if(isset($unreadMessages) && $unreadMessages > 0)
                            <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                                <span class="msg-num tab dashboard">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num tab dashboard">{{ $unreadMessages }}</span>
                            <?php } ?>
                        @endif
                    </a>

                </li>

                @if(Gate::check('list_models', $user))
                    <li id="model_tab" >
                         <a  id="model_active" data-id="3" data-status="Rejected" class="position-relative ">
                            {{ t('New models near you') }}
                       </a> 
                    </li>
                @endif
            </ul>
        </div>
        <!-- End tabbing section -->
        <div class="row">
            <!-- appliers -->
                <div class="col-lg-12 pb-40" id="my_jobs_tab" style="display: none;">
                   <?php /* <div class="mb-30 text-center">
                        <h2 class="position-relative prata d-inline-block"><!-- {{ t('My ads') }} -->
                            @if(isset($countMyPosts) && $countMyPosts > 0)

                                <?php if( $countMyPosts > config('app.num_counter') ){ ?>
                                    <span class="msg-num dashboard">{{ config('app.num_counter').'+' }}</span>
                                <?php } else { ?>
                                    <span class="msg-num dashboard">{{ $countMyPosts }}</span>
                                <?php } ?>
                            @endif
                        </h2>
                        <div class="divider mx-auto"></div>
                    </div> */ ?>
                      @if(!empty( $posts ) && count($posts) > 0 )
                        @foreach($posts as $k => $post)
                        <?php 

                            $applicationsCount = $post->jobApplicationsCount->count();
                            
                            $postUrl = lurl($post->uri);
                            
                            if (in_array($pagePath, ['pending-approval', 'archived'])) {
                                $postUrl = $postUrl . '?preview=1';
                            }

                            $iconPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';

                        ?>
                        <div class="row mx-0 bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-40 pl-30 mb-20">
                            <a href="{{ $post->uri }}" title="{{ t('View detail') }}">
                                @if(isset($post->is_home_job) && $post->is_home_job == 1)
                                    <span class="user-h to-left-30 to-top-0 home"></span>
                                @else
                                    <span class="flag to-left-30 to-top-0 ongoing"></span>
                                @endif
                            </a>
                            <div class="col-md-6 pt-40 pb-20 px-0 bordered">
                                <span class="title" title="{{ mb_ucfirst($post->title) }}"><a href="{{ $postUrl }}"><span class="{{ $post->title }}">{{ mb_ucfirst(str_limit($post->title, config('constant.title_limit'))) }}</a></span>
                                <span class="overflow-wrap">{{ str_limit( strip_tags($post->description), config('constant.title_limit') ) }}</span>
                                <div class="divider"></div>
                                <span class="posted">Date: {{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }}</span>
                            </div>
                            <div class="col-md-6 px-0 pt-40 pl-md-4">
                                <div class="d-flex justify-content-start align-items-center">
                                    <?php $applications = (!empty($post->postConversation) && count($post->postConversation) > 0)? count($post->postConversation) : '0'; ?>

                                    <div class="d-flex justify-content-start align-items-center">
                                        <a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">
                                            <span class="d-xl-inline-block rounded-circle card-appointment-number bold mr-10 bg-lavender">{{ $applicationsCount }}</span></a>
                                        <span class="title">
                                            <a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}"> {{ t('applications') }}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                        
                    @else
                        <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                    @endif
                    @if(!empty( $posts ) && count($posts) > 0 )
                    <div class="text-center"><a href="{{ lurl('account/my-posts') }}" class="btn btn-white no-bg">{{ t('All My ads') }}</a></div>
                    @endif
                   
                </div>
                <!-- End Of appliers -->
                <!-- massges -->
                <div class="col-lg-12 pb-40 " id="my_messag_tab" style="display: none;">
                    <?php /*
                    <div class="mb-30 text-center">
                        <h2 class="position-relative prata d-inline-block"><!-- {{t('Messages')}} -->
                            @if(isset($unreadMessages) && $unreadMessages > 0)
                                <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                                    <span class="msg-num dashboard">{{ config('app.num_counter').'+' }}</span>
                                <?php } else { ?>
                                    <span class="msg-num dashboard">{{ $unreadMessages }}</span>
                                <?php } ?>
                            @endif
                        </h2>
                        <div class="divider mx-auto"></div>
                    </div> */?>
                    
                    <?php
                    if (isset($conversations) && count($conversations) > 0) {

                        foreach ($conversations as $key => $conversation) {  
                            $unreadCount = (isset($conversation->msgcount)? $conversation->msgcount : 0 ); 
                            $created_at =  ($conversation->created_at)? $conversation->created_at : '';

                            $unreadClass = '';
                            $unreadClassRound = '';

                            if($conversation->user_is_read != "" && $conversation->user_is_read == 0){
                                $unreadClass = 'unreaded';
                                $unreadClassRound = 'bg-red';
                            }
                            /*
                            // $unreadCount = count($conversation->convunreadmessages); 
                            // $lastConversation = $conversation->convmessages->first();
                            // $userName = $userProfile = $username = '';

                            //     if($lastConversation->from_user_id == auth()->user()->id){
                            //         $userProfile = $lastConversation->to_user->profile;
                            //         $full_name = $lastConversation->to_user->profile->full_name;
                            //         $userName = $lastConversation->to_user->username;
                            //     }else{
                            //         $userProfile = $lastConversation->from_user->profile;
                            //         $full_name = $lastConversation->from_user->profile->full_name;
                            //         $userName = $lastConversation->from_user->username;
                            //     }

                            //     $created_at =  $conversation->created_at;

                            //     if(isset($conversation->convmessages) && count($conversation->convmessages) > 0 ){
                            //         if(isset($conversation->convmessages[0]->created_at) && !empty($conversation->convmessages[0]->created_at)){
                            //             $created_at =  $conversation->convmessages[0]->created_at;
                            //         }
                            //     }
                            */

                            ?>
                         
                            <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 {{ $unreadClass }} w-lg-920 w-xl-1220">
                    <div class="mr-md-40 mb-lg-30 mb-xl-0">
                        <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">

                            <?php $userUrl = lurl(trans('routes.user').'/'.(($conversation->username)? $conversation->username : '')); ?>

                            @if(isset($conversation->logo) && Storage::exists($conversation->logo))
                                <a href="{{ $userUrl }}"><img src="{{ \Storage::url($conversation->logo) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img full-width" /></a>
                            @else
                                <?php /*
                                <!-- <a href="{{ $userUrl }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                     {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                     {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a> -->
                                    */ ?>
                                <a href="{{ $userUrl }}"><img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                                     {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                                     {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                     src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/></a>
                            @endif
                        </div>
                    </div>
                    <div class="text-details">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                            <?php /*
                            <!--<span class="d-block">{{-- t('Conversation') --}} #{{-- $lastConversation->parent_id --}}</span>--> */ ?>
                        </div>
                        
                        <a href="{{  lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><span class="title" title="{{ (isset($conversation->title))? $conversation->title : '' }}">{{ (isset($conversation->title))? ucfirst($conversation->title) : '' }}</span></a>
                        
                        <div class="modelcard-top">
                            <a href="{{ $userUrl }}"><span class="d-inline-block overflow-wrap">{{ $conversation->full_name }}</span></a>
                        </div>
                        <div class="divider"></div>
                            <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}"><p class="overflow-wrap">{{ str_limit($conversation->message, config('constant.message_content_limit')) }}</p></a>
                        <div class="d-flex justify-content-start align-items-center">
                            
                            @if(isset($unreadClassRound) && !empty($unreadClassRound))
                                <a href="{{ lurl('account/conversations/' . $conversation->parent_id . '/messages') }}" title="{{ t('Click here to read the messages') }}"><span class="{{ $unreadClassRound }} d-xl-inline-block rounded-circle card-appointment-number bold mr-10">{{ $unreadCount }}</span></a>
                            @endif

                            <span class="bold">{{ \App\Helpers\CommonHelper::getFormatedDate($created_at) 
                             }}</span>
                        </div>
                    </div>
                </div>
                            <?php 
                        } ?>
                        <div class="text-center"><a href="{{ route('messages') }}" class="btn btn-white no-bg">{{t('all messages')}}</a></div>
                        <?php
                    }  else{ ?>
                         <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                   <?php  } 
                    ?>
                </div>
                <!-- End Of messages -->
          

                <!-- find model -->
                <div class="col-lg-12 pb-40 pb-lg-0 " id="my_model_tab" style="display: none;">
                    <?php /* <div class="mb-30 text-center">
                        <h2 class="position-relative prata d-inline-block"><!-- {{ t('New models near you') }} --><!-- <span class="msg-num dashboard">23</span> --></h2>
                        <div class="divider mx-auto"></div>
                       <!--  <div class="position-absolute-md md-to-left-0 md-to-top-0">
                            <a href="javascript:void(0);" class="btn btn-white filters mr-20 mini-all"></a>
                        </div> -->
                    </div> */ ?>

                    <?php /*
                    {{ Form::open(array('url' => lurl('model-list'), 'method' => 'get', 'files' => true)) }}
                        @include('childs.model-search-filter')
                    {{ Form::close() }} */ ?>

                
                    @if(!empty( $models ) && count($models) > 0 )
                        <div class="row tab_content mb-40">
                            @foreach($models as $k => $model)
                        
                                <?php

                                    $city = ($model->city) ? $model->city : '';
                                    $country = ($model->country_name) ? $model->country_name : '';
                                    $show_city_country = '';

                                    if(!empty($city)){
                                        $city_name = explode(',', $city);
                                        $show_city_country = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $city;
                                    }
                                    
                                    if(!empty($city) && !empty($country)){
                                        $show_city_country .= ', ';
                                    }
                                    
                                    $show_city_country .= $country;
                                    $profile = $model;
                                    $logo = ($profile->logo) ? $profile->logo : '';
                                ?>
                                <?php $show_category = ''; ?>

                                @if(count($modelCategories) > 0)
                                    @foreach ($modelCategories as $cat)
                                        @if($cat->parent_id == $model->category_id)
                                            <?php  $show_category = $cat->name; ?>
                                        @endif
                                    @endforeach
                                @endif

                                <div class="col-md-6 col-xl-3 all-post-div-count mb-20">
                                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                                        @if($logo !== "" && Storage::exists($logo))
                                            <img src="{{ \Storage::url($profile->logo) }}"  alt="{{ trans('metaTags.User') }}">&nbsp;
                                        @else
                                            <img  src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.User') }}">
                                        @endif 
                                    </div>
                                    <div class="box-shadow bg-white pt-20 pr-20 pb-20 pl-30">
                                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-2">
                                            <span class="bullet rounded-circle bg-lavender d-block mr-2 mb-1"></span>
                                            <span class="d-block">{{!empty($model->go_code)? $model->go_code: ''}}</span>
                                        </div>
                                        <div class="modelcard-top text-uppercase d-flex align-items-center">
                                            @if(!empty($show_category))
                                                <span class="bullet rounded-circle bg-lavender d-block mr-2"></span>
                                                <span class="d-block">{{ rtrim($show_category, ", ") }}</span>
                                            @endif
                                        </div>
                                        <?php $url = lurl(trans('routes.user').'/'.$model->username); ?>

                                        <span class="title pt-20" title="{{ t('View profile') }}">
                                            {!! App\Helpers\CommonHelper::createLink('view_models', $model->first_name, $url, '', '', $model->first_name, '') !!}
                                        </span>
                                        <span>{{ $show_city_country }}</span>
                                        <div class="divider"></div>
                                        <div class="pl-2 row">
                                            <div class="col-6 text-left px-xs-0 px-md-0 px-md-0">
                                                <span class="posted font-weight-bold">
                                                    <?php

                                                        date_default_timezone_set(config('timezone.id'));
                                                        $start  = date_create($model->last_login_at);
                                                        $end    = date_create();
                                                        
                                                        $diff   = date_diff( $start, $end );
                                                        
                                                        if ($diff->y) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>'; 
                                                            echo '<span class="lh-24">'.  (($diff->y == 1) ? t(':value year ago', ['value' => $diff->y]): t(':value years ago', ['value' => $diff->y])). '</span>';
                                                        }
                                                        else if ($diff->m) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>';
                                                            echo '<span class="lh-24">'.  (($diff->m == 1) ? t(':value month ago',['value' => $diff->m]): t(':value months ago',['value' => $diff->m])). '</span>';
                                                        }
                                                        else if ($diff->d) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>';
                                                            echo '<span class="lh-24">'.  (($diff->d == 1) ? t(':value day ago',['value' => $diff->d]): t(':value days ago',['value' => $diff->d])) . '</span>';
                                                        }
                                                        else if ($diff->h) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>';
                                                            echo '<span class="lh-24">'.  (($diff->h == 1) ? t(':value hour ago',['value' => $diff->h]): t(':value hours ago',['value' => $diff->h])) . '</span>';
                                                        }
                                                        else if ($diff->i) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>';
                                                            echo '<span class="lh-24">'.  (($diff->i == 1) ? t(':value minute ago',['value' => $diff->i]): t(':value minutes ago',['value' => $diff->i])) . '</span>';
                                                        }
                                                        else if ($diff->s) {
                                                            echo '<span class="lh-24">'. t('Last Active').': </span>';
                                                            echo '<span class="lh-24">'.  (($diff->s == 1) ? t(':value second ago',['value' => $diff->s]): t(':value seconds ago',['value' => $diff->s])) . '</span>';
                                                        }  
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="col-6 text-right px-xs-0 pl-md-0">
                                                <?php if(in_array($model->user_id, $favorites_user_ids)){ ?>
                                                   <a href="javascript:void(0);" id="{{ $model->user_id }}" class="make-favorite-acount-user btn btn-white favorite active mini-all fav-post" title="{{ t('Remove from Favorite') }}"></a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);" id="{{ $model->user_id }}" class="make-favorite-acount-user btn btn-white favorite mini-all" title="{{ t('Add to Favorite') }}"></a>
                                                <?php } ?>
                                                <a href="{{ lurl(trans('routes.user').'/'.$model->username) }}" class="btn btn-white insight signed mini-all" title="{{ t('View profile') }}"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white text-center box-shadow position-relative pt-40 pr-20 pb-20 pl-30 mb-30">
                            <h5 class="prata">{{ t('No records found') }}</h5>
                        </div>
                    @endif
                
                    @if(!empty( $models ) && count($models) > 0 )
                        <div class="text-center">
                        <a href="{{ lurl(trans('routes.model-list')) }}" class="btn btn-white no-bg">{{ t('Find model') }}</a>
                        <?php /*  {!! App\Helpers\CommonHelper::createLink('list_models', t('Find model'), lurl(trans('routes.model-list')), 'btn btn-white no-bg', '','','') !!}  */ ?>
                    @endif
                </div>
            </div>
            <!-- End of my model -->

            <!-- now on gomodels -->
            <div class="col-lg-12 pb-40 pb-lg-0 "  style="position: relative;display: block;" id="social_container">
                <div class="row grid mb-40" id="socialstream-section">
                    <div class="col-md-12 col-xl-12 col-sm-12 position-relative">
                        <div class="wall-outer mb-40">
                            <div id="social-stream" class="dc-wall col-lg-12 dcwss modern light table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End social -->
        </div>
    </div>
    @include('childs.bottom-bar')
@endsection


@section('after_scripts')
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/inc/layout.css') }}" media="all" />
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/dcsns_wall.css') }}" media="all" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.plugins.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.site.js') }}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js')}}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js')}}"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var config = {
        feeds: {
            twitter: {
                url: "{{ url('twitter.php') }}",
                id: "go_models",
                intro: "Tweeted",
                search: "Tweeted",
                images: "thumb",
                thumb: true,
                retweets: false,
                replies: false,
                out: "intro,text,share"
            },
            facebook: {
                url: "{{ lurl('account/social/facebook') }}",
                id: "{{ config('app.facebook_page_id') }}",
                intro: "Posted",
                comments: 3,
                image_width: 6,
                feed: "feed",
                out: "intro,thumb,title,text,user,share"
            },
            /*youtube: {
                id: "UCFb_MTs7jJBr5iOiri0oWQw",
                intro: "Uploaded",
                search: "Search",
                thumb: "medium",
                out: "intro,thumb,title,text,user,share",
                api_key: "AIzaSyCuoP7CP3GNEFA2NBlI32dCK1yBgd_aATA"
            },*/
            pinterest: {
                url: "{{ url('account/social/rss') }}",
                id: "go_models",
                intro: "Pinned",
                out: "intro,thumb,text,user,share"
            },
            instagram: {
                id: "{{ config('app.instagram_id') }}",
                intro: "Posted",
                search: "Search",
                out: "intro,thumb,text,user,share",
                accessToken: "{{ config('app.instagram_access_token') }}",
                redirectUrl: "{{ config('app.instagram_redirect_url') }}",
                clientId: "{{ config('app.instagram_client_id') }}"
            }
        },
        remove: "",
        max: "limit",
        days: 50,
        limit: 50,
        center: true,
        speed: 600,
        style: {
            layout: "modern",
            colour: "light"
        },
        rotate: {
            delay: 0,
            direction: "up"
        },
        wall: true,
        container: "dcwss",
        cstream: "stream",
        content: "dcwss-content",
        imagePath: "{{ url(config('app.cloud_url').'/images/dcwss-dark/') }}",
        iconPath: "{{ url(config('app.cloud_url').'/images/dcwss-dark/') }}"
    };
    if (!jQuery().dcSocialStream) {
        $.getScript("{{ url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js') }}", function() {});
        $.getScript("{{ url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js') }}", function() {
            $("#social-stream").dcSocialStream(config);
        });
    } else {
        $("#social-stream").dcSocialStream(config);
    }



    $('#dcsns-filter li a.link-all').html('All');
    /* $('#dcsns-filter .f-facebook a').html('Facebook');
    $('#dcsns-filter .f-twitter a').html('Twitter');
    $('#dcsns-filter .f-youtube a').html('Youtube');
    $('#dcsns-filter .f-pinterest a').html('Pinterest');
    $('#dcsns-filter .f-instagram a').html('Instagram');

    $(window).on("load", function() {
    
        // var result = $(".wall-outer").height();
        $('.wall-outer').append('<div class="text-center full-width" id="more-social-post" style="padding-bottom: 100px;"><a href="<?php //echo route('social') ?>" class="btn btn-white no-bg"><?php //echo  t('more post'); ?></a></div>');//
    }); */

});
</script>
<script type="text/javascript">
$('#social_tab').click(function() {
    $("#social_active").addClass("active");
    $("#social_container").attr('style', 'display: block');
    $("#my_jobs_tab").attr('style', 'display: none');
    $("#my_messag_tab").attr('style', 'display: none');
    $("#my_model_tab").attr('style', 'display: none');
});
$('#post_tab').click(function() {
    if (!$("#post_tab a").data('toggle')){
        $("#post_active").addClass("active");
        $("#social_container").attr('style', 'display: none');
        $("#my_jobs_tab").attr('style', 'display: block');
        $("#my_messag_tab").attr('style', 'display: none');
        $("#my_model_tab").attr('style', 'display: none');
    }
});
$('#massges_tab').click(function() {
    if (!$("#massges_tab a").data('toggle')){
        $("#massges_active").addClass("active");
        $("#social_container").attr('style', 'display: none');
        $("#my_jobs_tab").attr('style', 'display: none');
        $("#my_messag_tab").attr('style', 'display: block');
        $("#my_model_tab").attr('style', 'display: none');
    }
});
$('#model_tab').click(function() {
    if (!$("#model_tab a").data('toggle')){
        $("#model_active").addClass("active");
        $("#social_container").attr('style', 'display: none');
        $("#my_jobs_tab").attr('style', 'display: none');
        $("#my_messag_tab").attr('style', 'display: none');
        $("#my_model_tab").attr('style', 'display: block');
    }
});

$(function (){
    $('#dash_dropdown').on("change",function () {
        var id =$(this).val();
        if(id==1)
        {
            $("#social_active").addClass("active");
            $("#model_active").removeClass("active");
            $("#massges_active").removeClass("active");
            $("#post_active").removeClass("active");
            $("#social_container").attr('style', 'display: block');
            $("#my_jobs_tab").attr('style', 'display: none');
            $("#my_messag_tab").attr('style', 'display: none');
            $("#my_model_tab").attr('style', 'display: none');
        }
        if(id==2)
        {
            $("#post_active").addClass("active");
            $("#social_active").removeClass("active");
            $("#model_active").removeClass("active");
            $("#massges_active").removeClass("active");
            $("#social_container").attr('style', 'display: none');
            $("#my_jobs_tab").attr('style', 'display: block');
            $("#my_messag_tab").attr('style', 'display: none');
            $("#my_model_tab").attr('style', 'display: none');
        }
        if(id==3)
        {
            $("#massges_active").addClass("active");
            $("#post_active").removeClass("active");
            $("#social_active").removeClass("active");
            $("#model_active").removeClass("active");
            $("#social_container").attr('style', 'display: none');
            $("#my_jobs_tab").attr('style', 'display: none');
            $("#my_messag_tab").attr('style', 'display: block');
            $("#my_model_tab").attr('style', 'display: none');
        }
        if(id==4)
        {
            $("#model_active").addClass("active");
            $("#massges_active").removeClass("active");
            $("#post_active").removeClass("active");
            $("#social_active").removeClass("active");
            $("#social_container").attr('style', 'display: none');
            $("#my_jobs_tab").attr('style', 'display: none');
            $("#my_messag_tab").attr('style', 'display: none');
            $("#my_model_tab").attr('style', 'display: block');
        }
    });
});
</script>
<style type="text/css">
    .stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.dcwss.dc-wall .stream li {width: 425px!important; margin: 0px 15px 15px 0px!important;}.wall-outer #dcsns-filter.dc-center{padding-left: 0% !important;margin-left: 0px !important;padding-right: 0%;}.stream li.dcsns-facebook .section-intro, .filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:transparent !important; }.stream li.dcsns-twitter .section-intro, .filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:transparent !important;}.stream li.dcsns-youtube .section-intro, .filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:transparent !important;}.stream li.dcsns-pinterest .section-intro, .filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:transparent !important;}.stream li.dcsns-instagram .section-intro, .filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:transparent !important;}.wall-outer .dcsns-toolbar .filter li a{padding: 10px 16px;}#socialstream-section{height:auto !important;}.wall-outer{max-height: 1000px;}
        .wall-outer .dcsns-toolbar .filter li{ padding-top: 3px; }

        .wall-outer .dcsns-toolbar .filter li a{padding: 10px 27px; }
        span.socicon.socicon-facebook { color: #3b5998; } span.socicon.socicon-twitter{ color: #55acee;  } span.socicon.socicon-youtube { color: #cd201f; } span.socicon.socicon-pinterest{ color: #bd081c; } span.socicon.socicon-instagram { color: #3f729b;  }

        @media (min-width: 768px) and (max-width: 1024px) {
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 9px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: auto; padding: 10px 36px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important; margin-left: -73px !important; }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 100px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px;}
        }

        /*Portrait*/ 
        @media only screen and (min-width: 1024px) and (orientation: portrait) { 
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 0px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: 100%; padding: 10px 20px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;margin-left: -73px !important }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 0px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px;}
        }
        
        @media (min-width: 320px) and (max-width: 480px) {
            .dcwss.dc-wall .stream li {
                width: auto; margin: 0px 15px 15px 0px!important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 18px; }
            .dcwss.dc-wall.modern.light .stream li { max-width: 100%;  }
            ul.stream{  width: auto !important; }
        }
        @media (max-width: 320px){
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 15px; }
            ul.stream{  width: auto !important; }
        }
        /* center text for social link */
        .dcsns-toolbar {
            display: flex !important;
            justify-content: center !important;
        }
        #dcsns-filter {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }
        /*@media (min-width: 375px) and (max-width: 424px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 21px; }
        }
        @media (min-width: 425px) and (max-width: 767px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 23px; }
        }
*/
</style>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
<script>
    $(window).on('load', function() {
        var height =  ($('.wall-outer').height() + 200);
        $("#social_container").css('height',height);
    });
</script>
@endsection