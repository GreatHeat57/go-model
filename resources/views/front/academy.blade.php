@extends('layouts.app')

@section('content')


    <div class="block bd-b-light">
        <div class="image-and-text">
            <img data-src="{{ URL::to(config('app.cloud_url').'/images/premium2.png') }}" alt="{{ trans('frontPage.model_find_title') }}" class="lazyload"/>
            <div class="text">
                <h2 class="smaller">{{ trans('frontPage.model_find_title') }} </h2>
                <p>{{ trans('frontPage.model_find_sub_title') }}</p>

                <ul class="bullet-pipe">
                    <li>{{ trans('frontPage.model_find_feature1') }}</li>
                    <li>{{ trans('frontPage.model_find_feature2') }}</li>
                    <li>{{ trans('frontPage.model_find_feature3') }}</li>
                </ul>
                <div class="btn">
                    @if (Auth::User() && Auth::User()->user_type_id == 2)
                        <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.btn_find_model') }}</a>
                    @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                        <a href="javascript:void(0);" class="next disabled disabled_opacity">{{ trans('frontPage.btn_find_model') }}</a>
                    @else
                    <!-- <a href="#" class="next mfp-register">{{ trans('frontPage.btn_find_model') }}</a> -->
                    <a href="{{ lurl(trans('routes.login')) }}" class="next">{{ trans('frontPage.btn_find_model') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('childs.reasons',['class' => 'no-pd-b'])
    @include('childs.cta3',['class' => 'no-pd-b'])
    @include('childs.categories',['title' => t('go-models - It\'s your choice!'), 'class' => 'colored-light'])
    @include('childs.working_with_us',['class' => 'bd-b-light'])

    <!-- new section -->
    <div class="block no-pd-lr {{ isset($class) ? $class : '' }}">
        <div class="cta">
            <img data-src="{{ URL::to(config('app.cloud_url').'/images/model_agency.jpg') }}" alt="{{ trans('metaTags.img_model_agency') }}" class="lazyload"/>
            <div class="inner">
                <div class="text">
                    <div class="holder">
                        <h2>{!! trans('frontPage.find_model_label') !!}</h2>
                        <ul class="bullet-pipe max2">
                            <li>{{ trans('frontPage.find_model_feature1') }}</li>
                            <li>{{ trans('frontPage.find_model_feature2') }}</li>
                            <li>{{ trans('frontPage.find_model_feature3') }}</li>
                        </ul>
                        <div class="btn">
                            @if (Auth::User() && Auth::User()->user_type_id == 2)
                                <a href="{{ lurl(trans('routes.model-list')) }}" class="next green white">{{ trans('frontPage.btn_start_now') }}</a>
                            @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                                <a href="javascript:void(0);" class="next green white disabled disabled_opacity">{{ trans('frontPage.btn_start_now') }}</a>
                            @else
                                <a href="#" class="next mfp-register-form green white">{{ trans('frontPage.btn_start_now') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- new section -->
    <div class="block {{ isset($class) ? $class : '' }}">
        <h2>{{ trans('frontPage.go_model_category_title') }}</h2>

        <div class="cols-2 nested">
            <p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
        </div>

        <div class="btn">
            @if (auth()->check() && auth()->user()->user_type_id == 2)
                <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.btn_hire') }}</a>
            @else
                <a href="{{ lurl(trans('routes.post-a-job')) }}" class="next">{{ trans('frontPage.btn_hire') }}</a>
                <!-- <a href="javascript:void(0);" class="next mfp-register">{{ trans('frontPage.btn_hire') }}</a> -->
            @endif
        </div>
    </div>

    <!-- @include('childs.references') -->
    <?php /*
    @include('childs.featured',['class' => 'mg-b'])
    */?>
@endsection