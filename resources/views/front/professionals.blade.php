@extends('layouts.app')

@section('content')
    <div class="subcover colored-light-blue">
        <h1>{{ trans('frontPage.professional_page_title') }}</h1>
    </div>

    <div class="tabs">
        <ul>
            <li><a href="{{ lurl(trans('routes.models-category')) }}">{{ trans('frontPage.professional_page_tab1') }}</a></li>
            <li><a href="{{ lurl(trans('routes.professionals')) }}" class="active">{{ trans('frontPage.professional_page_tab2') }}</a></li>
        </ul>
    </div>

    <div class="block no-pd-b" id="homecategories">
        <div class="cols-3 no-mg-b">
            @if(isset($partnerCategories) && count($partnerCategories) > 0)
                @foreach($partnerCategories as $cat)
                    <div class="col">
                        <div class="category">
                           @if($cat->picture !== "" && file_exists(public_path($cat->picture)))
                                <?php
                                    $img = explode(".", $cat->picture);
                                    $altImg = $img[0].".jpg";
                                ?>
                                <a href="{{ lurl(trans('routes.post-a-job')) }}">
                                    <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url').$cat->picture) }}" alt="{{$cat->name}}" onerror=this.src='{{ URL::to(config("app.cloud_url").$altImg) }}' />
                                </a>
                            @else
                                <a href="{{ lurl(trans('routes.post-a-job')) }}">
                                    <img class="full-width lazyload" data-src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/categoryPicture.webp') }}" alt="Go Models" onerror=this.src='{{ URL::to("uploads/app/default/categoryPicture.jpg") }}'/>
                                </a>
                            @endif
                            <div class="data">
                                <div>
                                    <h3><a href="{{ lurl(trans('routes.post-a-job')) }}">{{$cat->name}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width: 100%;">
                    {{ t('No results found') }}
                </div>
            @endif
        </div>
    </div>

    <div class="block no-pd-lr">
        <div class="cta">
            <img class="lazyload" data-src="{{ URL::to('images/cta1.webp') }}" alt="Finde jetzt Models" onerror=this.src="{{ URL::to('images/cta1.jpg') }}" />
            <div class="inner">
                <div class="text text-center">
                    <div class="holder">
                        <h2>{{ trans('frontPage.apply_lbl') }}</h2>
                        <p>{{ trans('frontPage.apply_desc') }}</p>
                        <div class="btn">
                            <a href="{{ lurl(trans('routes.go-premium')) }}" class="green next white">{{ trans('frontPage.apply_btn') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection