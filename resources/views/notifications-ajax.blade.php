@if(count($notifications) > 0)
<div class="row mx-0 justify-content-md-center notification-sections">

    @foreach($notifications as $notification)
        
        <?php

            $classStatus = 'invited';
            if ($notification['invitation_status'] == 1) {
                $classStatus = 'applied';
            }else if($notification['invitation_status'] == 2){
                $classStatus = 'rejected';
            }

            if(Auth::user()->user_type_id == config('constant.model_type_id')){
                $to_from = t('From');
            }else{
                $notification['profile_pic'] = $notification['to_profile_pic'];
                $to_from = t('To');
            }
        ?>

        
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification notification-div {{ ($slug === 'Invited')? 'invite_'.$notification['id'] : '' }}">
                <!-- unreaded -->
                @if($notification['uri'] != "")
                    <a href="{{ lurl($notification['uri']) }}">
                        <span class="flag to-left-30 to-top-0 {{$classStatus}}"></span>
                    </a>
                @else
                    <span class="flag to-left-30 to-top-0 {{$classStatus}}"></span>
                @endif
                <div class="col-md-6 mt-20 pt-40 pb-20 pb-md-0 px-0 bordered">
                    @if($notification['uri'] != "")
                    <!-- <a href="{{-- lurl($notification['uri']) --}}">
                        <span class="title">{{-- $notification['title'] --}}</span>
                    </a> -->
                        <?php $start_tag = "<span class='title'>"; $close_tag = "</span>"; ?>
                        {!! App\Helpers\CommonHelper::createLink('view_jobs', $notification['title'], lurl($notification['uri']), '', '','','',$start_tag, $close_tag) !!}
                    @else
                        <span class="title">{{ $notification['title'] }}</span>
                    @endif
                    <span>{!! str_limit(strCleaner($notification['description']), config('constant.description_limit')) !!}</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">{{ \App\Helpers\CommonHelper::getFormatedDate($notification['created_at']) }}</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4 ">
                    <span class="dark-grey2 posted mb-10">{{ $to_from }}</span>
                    <div class="d-flex justify-content-start align-items-center mb-10">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            
                            @if($notification['profile_pic'] != '')
                                <img srcset="{{ $notification['profile_pic'] }}" src="{{ $notification['profile_pic'] }}" alt="{{ trans('metaTags.Go-Models') }}" class="full-width-round from-img full-width img-width-round"/>
                            @else
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                            {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                            {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                            src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"
                            class="from-img full-width"/>
                            @endif
                        </div>
                        <span class="title">{{ $notification['name'] }}</span>
                    </div>
                    @if($slug === 'Invited' && Auth::user()->user_type_id == config('constant.model_type_id'))
                        <div class="col-md-6 pt-40 pb-20 px-0 status-btn-{{ $notification['id'] }}">
                            <span class="title d-flex justify-content-start align-items-center">
                                
                                <?php /* <a href="{{ url('/account/invtresp/1/'.$notification['id']) }}" class="btn-invitation btn-applied mr-20 accepted" id="{{ $notification['id'] }}" title="{{ t('Accept') }}"></a> */ ?>


                                <?php $acceptcls = 'btn-invitation btn-applied mr-20'; ?>
                                @can('invited_jobs', Auth::user())
                                    <?php $acceptcls = 'btn-invitation btn-applied mr-20 accepted'; ?>
                                @endcan

                                {!! App\Helpers\CommonHelper::createLink('invited_jobs', '', url('/account/invtresp/1/'.$notification['id']), $acceptcls, $notification['id'],'', t('Accept')) !!}

                                &nbsp;
                                
                                <?php /* <a href="{{ url('/account/invtresp/2/'.$notification['id']) }}" class="btn-invitation btn-rejected rejected" id="{{ $notification['id'] }}" title="{{ t('Reject') }}"></a> */ ?>

                                
                                <?php $rejectcls = 'btn-invitation btn-rejected'; ?>
                                @can('invited_jobs', Auth::user())
                                    <?php $rejectcls = 'btn-invitation btn-rejected rejected'; ?>
                                @endcan

                                {!! App\Helpers\CommonHelper::createLink('invited_jobs', '', url('/account/invtresp/2/'.$notification['id']), $rejectcls, $notification['id'],'', t('Reject')) !!}
                            </span>
                            
                        </div>

                        

                    @endif
                    
                    @if($notification['invitation_status'] == 1)
                        <a class="notification" href="{{ lurl('account/conversations/' . $notification['id'] . '/messages') }}"><p>{{ t('start Conversations') }}</p></a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
    <div class="bg-white not-found-main text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
        <h5 class="prata">
            {{ t('No notifications found') }}
        </h5>
    </div>
@endif