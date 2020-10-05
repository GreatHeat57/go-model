<div class="container pt-40 px-0 w-xl-1220">
    <h1 class="text-center prata">{{ ucWords(t('Client Profile')) }}</h1>
    <div class="text-center mb-30 position-relative">
        <div class="divider mx-auto"></div>
        
        @if(Auth::user()->user_type_id !== config('constant.model_type_id') && Auth::user()->id == $profile->user_id)
            <?php /*<p>{{ t('Your profile, as the models see') }}</p> */?>
            <p>&nbsp;</p>
        @else
            <p></p>
        @endif

         
        @if(Auth::user()->id == $profile->user_id)
            <a href="{{ route('partner-profile-edit') }}" class="btn btn-default edit_grey mini-under-desktop position-absolute-md md-to-right-0 md-to-top-25">{{t('Edit')}}</a>
        @endif
    </div>
        @if(Auth::user()->user_type_id !== config('constant.model_type_id') && (Auth::user()->id == $profile->user_id) && $profile->allow_search == 0)
            <?php $href = lurl(trans('routes.partner-profile-edit')); ?>
            <?php $label = t('click here'); ?>
            <?php $button = "<a href='$href' style='margin-right: 6px; margin-left: 6px; text-decoration: underline;  margin-top: 1px;'>$label</a>"; ?>

            <span class="text-center mt-20 mb-30 mx-lg-auto notes-zone dashboard-allow-search">{!! t("allow search false alert to client :button", ['button' => $button]) !!}</span>
        @endif
</div>
    
    <div class="py-40 px-20-under-desktop px-lg-38 px-xl-65 mx-m13 mx-sm-0 public-profile-top"  @if(!empty($profile->cover) && Storage::exists($profile->cover)) style="background: url({{ \Storage::url($profile->cover) }}); background-position: center;background-repeat: no-repeat;background-size: cover;" @endif>

<!-- <div class="py-40 px-20-under-desktop px-lg-38 px-xl-65 mx-m13 mx-sm-0 public-profile-top"> -->
    <div class="wrapper-ppt"></div>
    <div class="d-md-flex justify-content-md-between justify-content-lg-center">
        <div class="mr-md-40 mb-lg-30 mb-xl-0">

            <!-- <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border mx-xs-auto bg-lavender msg-img-holder big"> -->

            <div class="d-flex justify-content-center align-items-center mb-sm-30  border mx-xs-auto bg-lavender msg-img-holder big">
                <!-- <img srcset="{{ URL::to('images/avatars/img-avatar.png') }},
                                     {{ URL::to('images/avatars/img-avatar@2x.png') }} 2x,
                                     {{ URL::to('images/avatars/img-avatar@3x.png') }} 3x"
                     src="{{ URL::to('images/avatars/img-avatar.png') }}" alt="Go Models" class="from-img full-width"/> -->
                @if($logo !== "" && Storage::exists($logo))
                    <img srcset="{{ \Storage::url($profile->logo) }},
                                            {{ \Storage::url($profile->logo) }} 2x,
                                            {{ \Storage::url($profile->logo) }} 3x"
                                            src="{{ \Storage::url($profile->logo) }}" alt="{{ trans('metaTags.User') }}" class="logoImage from-img full-width fit-contain"/>
                    <?php /*
                    <img class="from-img full-width" src="{{ \Storage::url($profile->logo) }}" class="from-img full-width" alt="{{ trans('metaTags.User') }}"> */?>

                {{-- @elseif (!empty($gravatar))
                    <img class="from-img full-width" src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}" > --}}
                @else
                    <img class="from-img full-width" src="{{ url(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.User') }}">
                @endif
            </div>
        </div>
        
        <div class="d-lg-flex justify-content-lg-between flex-lg-grow-2">
            <div class="text-center text-md-left mr-lg-70 w-lg-460">
                <!-- <div class="modelcard-top text-uppercase mb-30 f-12"><p>{{ t('You last logged in at') }}: {{ \App\Helpers\CommonHelper::getFormatedDate($user->last_login_at,true) }}</p></div> -->
                <span class="title">{{ ($user->profile->first_name)? ucfirst($user->profile->first_name) : '' }}</span>
                <div class="modelcard-top"><p>
                    <?php 

                        $show_city_country = '';
                        if(!empty($city)){
                           $show_city_country = $city;  
                        } 
                        if(!empty($city) && !empty($country)){
                            $show_city_country .= ', ';
                        }

                        $show_city_country .= $country;
                    ?>
                    {{ $show_city_country }}</p></div>

                <div class="divider mx-xs-auto"></div>
                <!-- <span class="mb-20">Hallo!</span> -->
                <?php /*
                <p class="mb-30">{{ ($user->profile->description)? str_limit(stripslashes(strip_tags($user->profile->description)), config('constant.description_limit')) : ''}}</p>
                */ ?>
            </div>

            @if(isset($user))
                @if($user->id == Auth::User()->id)
                    <div class="d-sm-flex justify-content-sm-between justify-content-md-start d-lg-inline-block">
                        <div class="d-block d-sm-inline-block d-lg-block text-center mb-20 mb-md-0 mb-lg-20 mr-md-20 mr-lg-0">
                            {{-- <a href="{{ lurl('account/my-posts') }}" class="btn btn-white members insight bg-s-25">&nbsp; {{ $countPostsVisits or 0 }}&nbsp;
                                {{ trans_choice('global.count_visits', (isset($countPostsVisits) ? getPlural($countPostsVisits) : getPlural(0))) }}
                            </a> --}}
                            <?php /*
                            <a href="javascript:void(0);" class="btn btn-white members insight bg-s-25 pointer-event-none">&nbsp; {{$user->userVisits->count()}}&nbsp;{{ trans_choice('global.count_visits',$user->userVisits->count()) }}
                            </a> */?>
                        </div>
                        <div class="d-block d-sm-inline-block d-lg-block text-center"><a href="{{ lurl('account/my-posts') }}" class="btn btn-white jobs">{{ $countPosts }}&nbsp;{{ trans_choice('global.count_posts', getPlural($countPosts)) }}</a></div>
                    </div>
                @endif

                @if( $user->user_type_id != Auth::User()->user_type_id  && $user->id != Auth::User()->id)

                    @if(isset($direct_message_link) && $direct_message_link != "")
                        <div class="d-sm-flex justify-content-sm-between justify-content-md-start d-lg-inline-block">
                            <div class="d-block d-sm-inline-block d-lg-block text-center"><a href="{{$direct_message_link}}" class="btn btn-white message">{{ t('Message') }}</a></div>
                        </div>
                    @else
                        <div class="d-sm-flex justify-content-sm-between justify-content-md-start d-lg-inline-block">
                            <div class="d-block d-sm-inline-block d-lg-block text-center"><a data-toggle="modal" href="#directMessage" class="btn btn-white message">{{ t('Message') }}</a></div>
                        </div>
                    @endif
                @endif
                 
            @endif
        </div>
    </div>
</div>