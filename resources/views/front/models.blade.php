@extends('layouts.app')

@section('content')
    <div class="subcover colored-light">
        <h1>{{ trans('frontPage.category_page_title') }}</h1>
    </div>

    <div class="tabs">
        <ul>
            <li><a href="{{ lurl(trans('routes.models-category')) }}" class="active">{{ trans('frontPage.category_tab1') }}</a></li>
            <li><a href="{{ lurl(trans('routes.professionals')) }}">{{ trans('frontPage.category_tab2') }}</a></li>
        </ul>
    </div>

    <div class="block no-pd-b" id="homecategories">
        <div class="cols-3 no-mg-b">
            @if(isset($modelCategories) && count($modelCategories) > 0)
                @foreach($modelCategories as $cat)
                    <div class="col">
                        <div class="category">
                            <?php $attr = ['countryCode' => config('country.icode'), 'slug' => $cat->slug]; ?>
                            
                            <?php /*
                                @if($cat->picture !== "" && file_exists(public_path($cat->picture)))
                                    <a href="{{ lurl(trans('routes.v-page-category', $attr), $attr) }}"><img data-src="{{ URL::to($cat->picture) }}" alt="{{$cat->name}}" class="lazyload"/></a>
                                @else
                                    <a href="{{ lurl(trans('routes.v-page-category', $attr), $attr) }}">
                                        <img class="full-width lazyload" data-src="{{ URL::to('uploads/app/default/categoryPicture.webp') }}" alt="Go Models" onerror=this.src='{{ URL::to('uploads/app/default/categoryPicture.jpg') }}'/>
                                    </a>
                                @endif
                            */ ?>

                            @if($cat->picture !== "" && file_exists(public_path($cat->picture)))
                                <?php
                                    $img = explode(".", $cat->picture);
                                    $altImg = $img[0].".jpg";
                                ?>
                                <a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">
                                    <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url').$cat->picture) }}" alt="{{$cat->title}}" onerror=this.src='{{ URL::to(config('app.cloud_url').$altImg) }}' />
                                </a>
                            @else
                                <a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">
                                    <img class="full-width lazyload" data-src="{{ URL::to(config('app.cloud_url') . '/uploads/app/default/categoryPicture.webp') }}" alt="{{$cat->title}}" onerror=this.src='{{ URL::to('uploads/app/default/categoryPicture.jpg') }}'/>
                                </a>
                            @endif
                            <div class="data">
                                <div>
                                    <h3><a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">{{$cat->title}}</a></h3>
                                    <span>{{ $cat->age_range }} {{ trans('frontPage.age') }}</span>
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

        <div class="cols-3 no-mg-b">
            <div class="col" style="display: none;">
                <div class="category">
                    <a href="#"><img class="lazyload" data-src="{{ URL::to(config('app.cloud_url') . '/images/category7.jpg') }}" alt="Ugly Models" /></a>
                    <div class="data">
                        <div>
                            <h3><a href="#">Ugly Models</a></h3>
                            <span>15+ {{ trans('frontPage.age') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" style="display: none">
                <div class="category">
                    <a href="#"><img class="lazyload" data-src="{{ URL::to(config('app.cloud_url') . '/images/category8.jpg') }}" alt="Tattoo Models" /></a>
                    <div class="data">
                        <div>
                            <h3><a href="#">Tattoo Models</a></h3>
                            <span>15+ {{ trans('frontPage.age') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" style="display: none">
                <div class="category">
                    <a href="#"><img class="lazyload" data-src="{{ URL::to(config('app.cloud_url') . '/images/category9.jpg') }}" alt="Pet Models" /></a>
                    <div class="data">
                        <div>
                            <h3><a href="#">Pet Models</a></h3>
                            <span>dogs, cats, birds etc</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('childs.cta')

    <div class="block no-pd">
        <h2 class="mg-b-20">{{ trans('frontPage.model_category_Go_your_way') }}</h2>
        <p class="cols-3 text-center">{{ trans('frontPage.model_category_Go_your_way_text') }}</p>
        
        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>{{ trans('frontPage.model_category_benefit_1_title') }}</h4>
                    <p>{!! trans('frontPage.model_category_benefit_1_description') !!}</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>2</span>
                    <h4>{{ trans('frontPage.model_category_benefit_2_title') }}</h4>
                    <p>{{ trans('frontPage.model_category_benefit_2_description') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>3</span>
                    <h4>{{ trans('frontPage.model_category_benefit_3_title') }}</h4>
                    <p>{{ trans('frontPage.model_category_benefit_3_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block colored2">
       <div class="have-a-job">
            <div class="col">
                <h3>{!! trans('frontPage.model_category_Advantages_titlle') !!}</h3>
            </div>
            <div class="col">
                <p class="text-left mb-10">{{ trans('frontPage.model_category_Advantages_text_1') }}</p>
                <p class="text-left mb-10">{{ trans('frontPage.model_category_Advantages_text_2') }}</p>
                <p class="text-left mb-10">{{ trans('frontPage.model_category_Advantages_text_3') }}</p>
            </div>
       </div>
    </div>

@endsection