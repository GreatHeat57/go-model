@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container pt-40 pb-60 px-0 w-lg-750 w-xl-1220">

        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">{{ t('applications') }}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="javascript:void(0);" class="btn btn-white search mini-under-desktop">{{ t('Search') }}</a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                <form method="POST" action="{{ url()->current() }}" accept-charset="UTF-8" id="search-form">
                    {{ csrf_field() }}
                    <div class="input-bar">
                        <div class="input-bar-item width100">
                            <div class="form-group">
                                {{ Form::text('search', null, ['id' => 'searchtext', 'class' => 'width100', 'placeholder' => t('Search'), 'autofocus'=>'autofocus', 'required'=> 'required']) }}
                            </div>
                        </div>
                        <div class="input-bar-item">
                            <input type="button" class="btn btn-white search no-bg" value="" id="mypost-search-submit">
                        </div>
                    </div>
                </form>
                <?php /*
                {{ Form::open() }}
                {{ Form::text('search', null, ['class' => 'search', 'id' => 'searchUser', 'placeholder' => t('Search Applications')]) }}
                {{ Form::submit('Keresés') }}
                {{ Form::close() }}
                */?>
            </div>
        </div>

        @if( $post && !empty($post) )
        <div class="custom-tabs mb-20 mb-xl-30">
            <ul class="d-none d-md-block application_title">
                <li><a href="{{ lurl($post->uri) }}" style="text-decoration: underline;">{{ ucfirst(strip_tags($post->title)) }}</a></li>

            </ul>
        </div>
        @endif
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <?php /*
        <div class="row mx-0 mx-lg-auto position-relative pr-20 w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                @if(!empty( $applications ) && count($applications) > 0 ) 
                    <form name="listForm" method="POST" action="{{ lurl('account/conversations/delete') }}">
                        {!! csrf_field() !!}
                        <span class="">
                            <div class="col-md-12 form-group custom-checkbox mb-30">
                                <input class="checkbox_field" id="checkAll" name="entries" type="checkbox">
                                <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }} </label>
                                <button type="submit"  class="btn btn-white trash_white delete-btn">{{ t('Delete') }}</button>
                            </div>
                        </span>
                @endif
            </div>
        </div>
        <?php */ ?>

        @include('account.inc.job-application-list')

        <?php /* 
        <div class="position-relative w-xl-1220 mx-xl-auto pr-20 pb-20 pl-30 mb-30">
            @if(isset( $posts ) && !empty($posts) ) 
                <form name="listForm" method="POST" action="{{ lurl('account/model-book/delete') }}">
                    {!! csrf_field() !!}
                    <span class="mb-30">
                        <div class="col-md-6 form-group custom-checkbox mb-30">
                            <input class="checkbox_field" id="checkAll" name="entries[]" type="checkbox">
                            <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }} </label>
                            <button type="submit"  class="btn btn-white trash_white delete-btn">{{ t('Delete') }}</button>
                        </div>
                    </span>
            @endif
        </div>
        */ ?>
        <?php /*//$ismodel =  isset($post->ismodel) ? $post->ismodel : 0;  ?>
        @if(!empty( $applications ) && count($applications) > 0 ) 
            @foreach($applications as $k => $job) 
                
                <?php
                    $user = $job->user;
                    $logo = ($user->profile->logo) ? $user->profile->logo : '';
                ?>

                <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
                        <div class="mr-md-40 mb-lg-30 mb-xl-0">
                            <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">

                                @if($logo !== "" && $logo !== null && Storage::exists($logo))
                                    <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}">
                                        <img src="{{ \Storage::url($user->profile->logo) }}" alt="user" class="logoImage from-img full-width"/>
                                    </a>
                                @else
                                    <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                                     {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                                     {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                    src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                                @endif
                            </div>
                        </div>
                    <div>
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                            <span class="d-block">{{ $user->profile->city }}</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block"><img src="{{ url('images/flags/16/' . strtolower($user->country_code) . '.png') }}" data-toggle="tooltip" title="{{ $user->country_code }}"></span>
                        </div>
                        
                        <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><span class="{{ $post->title }} title">{{ $user->profile->first_name }} {{ $user->profile->last_name }}</span></a>
                        
                        <div class="modelcard-top">
                            
                            @if($ismodel == 1)
                                <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class=""><span class="d-inline-block">{{ t('Profile View') }}</span></a>
                            @else
                                <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class=""><span class="d-inline-block">{{ t('Profile View') }}</span></a>
                            @endif
                            
                            <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                            
                            <a href="{{ lurl('account/conversations/'.$job->id.'/messages') }}" class=""><span class="d-inline-block">{{ t('Send a Message') }}</span></a>

                            @if($ismodel == 1)
                                <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>

                                <a href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}" class=""><span class="d-inline-block">{{ t('Sedcard') }}</span></a>
                            @endif
                            
                            <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>

                            @if($ismodel == 1)
                                <a href="{{ lurl('account/'.$user->id.'/downloadmbook') }}" class=""><span class="d-inline-block">{{ t('Model Book') }}</span></a>
                            @else
                                <a href="{{ lurl('partner-public-portfolio/'.$user->id) }}" class=""><span class="d-inline-block">{{ t('Portfolio') }}</span></a>
                            @endif    

                        </div>
                        
                        <div class="divider"></div>
                         
                        <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                            <span class="form-group custom-checkbox">
                                <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $job->id }}">
                                <label for="studio_{{$k}}" class="checkbox-label">{{ t('Delete') }}</label>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="bg-white box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">{{ t('No records found') }}</h5>
                </div>
            @endif
        
        <?php *//* ?>
        @if(!empty( $applications ) && count($applications) > 0 ) 

            @foreach($applications as $k => $model) 

                <?php  
                    $user = \App\Models\User::find($model->from_user_id);
                    $logo = ($user->profile->logo) ? $user->profile->logo : '';

                 ?>

                 <div class="row mx-0 bg-white box-shadow position-relative pt-20 pb-10 pl-30 pr-30 mb-10">
                        
                        <div class="mr-md-40 mb-lg-30 mb-xl-0">
                            <div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender msg-img-holder">
                                @if($logo !== "" && file_exists(public_path('uploads').'/'.$logo))
                                    <img class="logoImage" src="{{ \Storage::url($user->profile->logo) }}" class="from-img full-width" alt="user">&nbsp;
                                @else
                                    <img class="logoImage from-img full-width" src="{{ url('images/user.jpg') }}" alt="user">
                                @endif
                            </div>
                        </div>

                        <div>
                            
                            <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                <span class="d-block">{{ $user->profile->city }}</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                <span class="d-block"><img src="{{ url('images/flags/16/' . strtolower($user->country_code) . '.png') }}" data-toggle="tooltip" title="{{ $user->country_code }}"></span>
                            </div>
                            
                            <a href="#"><span class="{{ $post->title }}">{{ $user->profile->first_name }} {{ $user->profile->last_name }}</span></a>
                            
                            <div class="modelcard-top">
                                
                                <span class="d-inline-block">
                                    <a href="{{ lurl('account/user/'.$user->id) }}" class="">
                                        <strong>{{ t('Profile View') }}</strong>
                                    </a>
                                </span>
                                
                                <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                                
                                <span class="d-inline-block">
                                    <a href="{{ lurl('account/conversations/'.$model->id.'/messages') }}" class="">
                                        <strong>{{ t('Send a Message') }}</strong>
                                    </a>
                                </span>
                                
                                <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                                
                                <span class="d-inline-block">
                                    <a href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}" class="">
                                        <strong>{{ t('Sedcard') }}</strong>
                                    </a>
                                </span>
                                
                                <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                                
                                <span class="d-inline-block">
                                    <a href="{{ lurl('account/'.$user->id.'/downloadmbook') }}" class="">
                                        <strong>{{ t('Model Book') }}</strong>
                                    </a>
                                </span>


                                <span class="pt-20 pb-10 form-group custom-checkbox">
                                    <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $post->id }}">
                                    <label for="studio_{{$k}}" class="checkbox-label">{{ t('Delete') }}</label>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
        @else
        <div class="bg-white box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                <h5 class="prata">{{ t('No records found') }}</h5>
        </div>
        @endif
        <?php */ ?>

        </form>
        
        <div class="text-cente pt-40 mb-30 position-relative">
            @include('customPagination')
        </div>
    </div>
    @include('childs.bottom-bar')
@endsection

@section('after_scripts')
    <script></script>
@endsection