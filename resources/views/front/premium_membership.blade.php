@extends('layouts.app')

@section('content')
    <div class="cover">
        <img data-src="{{ URL::to(config('app.cloud_url').'/images/covers/premium_membership.jpg') }}" alt="Go-Models" class="lazyload"/>
        <div class="inner">
            <div class="text">
                <div class="holder wide">
                    <h1>{!! trans('frontPage.about_us_title') !!}</h1>

                    <ul class="bullet-pipe">
                        <li>{{ trans('frontPage.about_us_feature1') }}</li>
                        <li>{{ trans('frontPage.about_us_feature2') }}</li>
                        <li>{{ trans('frontPage.about_us_feature3') }}</li>
                   </ul>

                    <div class="btn">
                        @if (auth()->check())
                            <a href="javascript:void(0);" class="disabled_opacity disabled">{{ trans('frontPage.about_us_btn_label') }}</a>
                        @else
                            <a href="#" class="mfp-register-form">{{ trans('frontPage.about_us_btn_label') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <h2>{{ trans('frontPage.how_it_works_title') }}</h2>

        <div class="image-and-text-rows">
            <div class="row">
                <div>
                    <!-- <span class="num">1</span> -->
                    <h3>{{ trans('frontPage.how_it_works_step1_title') }}</h3>
                    <ul>
                        {!! trans('frontPage.how_it_works_step1_desc') !!}
                    </ul>
                </div>

                <div>
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/premium1.jpg') }}" alt="Dein Model Profil" class="lazyload"/>
                </div>
            </div>

            <div class="row">
                <div>
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/premium2.png') }}" alt="Job posten" class="lazyload"/>
                </div>

                <div>
                    <!-- <span class="num">2</span> -->
                    <h3>{{ trans('frontPage.how_it_works_step2_title') }}</h3>
                    <ul>
                         {!! trans('frontPage.how_it_works_step2_desc') !!}
                    </ul>
                </div>
            </div>

            <div class="row">
                <div>
                    <!-- <span class="num">3</span> -->
                    <h3>{{ trans('frontPage.how_it_works_step3_title') }}</h3>
                    <ul>
                         {!! trans('frontPage.how_it_works_step3_desc') !!}
                    </ul>
                </div>

                <div>
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/premium3.png') }}" alt="Deine Jobliste" class="lazyload"/>
                </div>
            </div>

            <div class="row">
                <div>
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/premium4.png') }}" alt="Kontaktaufnahme" class="lazyload"/>
                </div>

                <div>
                    <!-- <span class="num">4</span> -->
                    <h3>{{ trans('frontPage.how_it_works_step4_title') }}</h3>
                    <ul>
                         {!! trans('frontPage.how_it_works_step4_desc') !!}
                    </ul>
                </div>
            </div>

            <div class="row">
                <div>
                    <!-- <span class="num">5</span> -->
                    <h3>{{ trans('frontPage.how_it_works_step5_title') }}</h3>
                    <ul>
                         {!! trans('frontPage.how_it_works_step5_desc') !!}
                    </ul>
                </div>

                <div>
                    <img data-src="{{ URL::to(config('app.cloud_url').'/images/IndexPicture4-Call.jpg') }}" alt="Dein go-models Support" class="lazyload"/>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd no-pd-b">
        <div class="try-it">
            <h4>{{ trans('frontPage.premium_footer_title') }}</h4>
            <div class="btn">
                @if (auth()->check())
                    <a href="javascript:void(0);" class="green next disabled_opacity disabled">{{ trans('frontPage.premium_footer_btn1_lbl') }}</a>
                    <?php /* 
                    <a href="javascript:void(0);" class="next disabled_opacity disabled">{{ trans('frontPage.premium_footer_btn2_lbl') }}</a>
                    */?>
                @else
                    <a href="#" class="green next mfp-register-form">{{ trans('frontPage.premium_footer_btn1_lbl') }}</a>
                    <?php /* 
                        <a href="#" class="green next mfp-register-form">{{ trans('frontPage.premium_footer_btn2_lbl') }}</a>
                    */?>
                @endif
            </div>
        </div>
    </div>

    @include('childs.cta4')
@endsection