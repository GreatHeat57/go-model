    @include('childs.have_a_job')

    @include('childs.featured-models')

    @include('childs.categories',['title' => t('Everyone can become a go model')])
    
    <?php $attr = ['countryCode' => config('country.icode')];?>

    <div class="block colored pd-10">
        <h2 class="mg-b-30">{{t('go-models Highlights')}}</h2>
        <div class="testimonials owl-carousel">
            @for($i=1;$i<=3;$i++)
                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/'.trans('frontPage.home-testimonials-img1')) }}" class="lazyload" alt="" onerror=this.src='{{ URL::to(config("app.cloud_url"). "/images/testimonials/".trans("frontPage.home-testimonials-img1-jpg")) }}' />
                        </div>
                        <div class="name">{{ trans('frontPage.home-testimonials-1-name') }}</div>
                        <div class="company">— {{ trans('frontPage.home-testimonials-1-company') }} —</div>

                        <div class="quote-holder">
                            <blockquote>{{ trans('frontPage.home-testimonials-1-title') }}</blockquote>
                        </div>
                        <p>{{ trans('frontPage.home-testimonials-1-details') }}</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/'.trans('frontPage.home-testimonials-img2')) }}" class="lazyload" alt="" onerror=this.src='{{ URL::to(config("app.cloud_url"). "/images/testimonials/".trans("frontPage.home-testimonials-img2-jpg")) }}' />
                        </div>
                        <div class="name">{{ trans('frontPage.home-testimonials-2-name') }}</div>
                        <div class="company">— {{ trans('frontPage.home-testimonials-1-company') }} —</div>

                        <div class="quote-holder">
                            <blockquote>{{ trans('frontPage.home-testimonials-2-title') }}</blockquote>
                        </div>
                        <p>{{ trans('frontPage.home-testimonials-2-details') }}</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="{{ URL::to(config('app.cloud_url').'/images/testimonials/'.trans('frontPage.home-testimonials-img3')) }}" class="lazyload" alt="" onerror=this.src='{{ URL::to(config("app.cloud_url"). "/images/testimonials/".trans("frontPage.home-testimonials-img3-jpg")) }}' />
                        </div>
                        <div class="name">{{ trans('frontPage.home-testimonials-3-name') }}</div>
                        <div class="company">— {{ trans('frontPage.home-testimonials-1-company') }} —</div>

                        <div class="quote-holder">
                            <blockquote>{{ trans('frontPage.home-testimonials-3-title') }}</blockquote>
                        </div>
                        <p>{{ trans('frontPage.home-testimonials-3-details') }}</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            @if(auth()->check())
                <a href="javascript:void(0);" class="disabled_opacity disabled">{{t('apply now')}}</a>
            @else
            <a href="javascript:void(0)" class="mfp-register-form">{{t('apply now')}}</a>
            @endif
        </div>
    </div>

    <div class="block">
        <h2>{!! trans('frontPage.being_model_title') !!}</h2>
        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul class="bullet-pipe">
                        <li><span>{{ trans('frontPage.being_model_feature1_title') }}</span><br />
                        {{ trans('frontPage.being_model_feature1_desc') }}</li>
                        <li><span>{{ trans('frontPage.being_model_feature3_title') }}</span><br /> {{ trans('frontPage.being_model_feature3_desc') }}</li>
                        <li><span>{{ trans('frontPage.being_model_feature5_title') }}</span><br /> {{ trans('frontPage.being_model_feature5_desc') }}</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="howto">
                    <ul class="bullet-pipe">
                        <li><span>{{ trans('frontPage.being_model_feature2_title') }}</span><br /> {{ trans('frontPage.being_model_feature2_desc') }}</li>
                        <li><span>{{ trans('frontPage.being_model_feature4_title') }}</span><br /> {{ trans('frontPage.being_model_feature4_desc') }}</li>
                        <li><span>{{ trans('frontPage.being_model_feature6_title') }}</span><br /> {{ trans('frontPage.being_model_feature6_desc') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="btn">
            @if (Auth::User() && Auth::User()->user_type_id == 2)
                <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a>
            @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                <a href="javascript:void(0);" class="next disabled disabled_opacity">{{ trans('frontPage.have_job_btn_label') }}</a>
            @else
                <a href="{{ lurl(trans('routes.login')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a>
            @endif
        </div>
    </div>

    <div class="block colored2">
        <div class="have-a-job">
            <div class="col">
                <h3>{{ trans('frontPage.book_model_title') }}</h3>
            </div>

            <div class="col">
                <p><strong style="font-weight:800;">{{ trans('frontPage.book_model_sub_title') }}</strong></p>
                <ul class="bullet-pipe max no-mg-b">
                    <li>{{ trans('frontPage.book_model_feature1') }}</li>
                    <li>{{ trans('frontPage.book_model_feature2') }}</li>
                    <li>{{ trans('frontPage.book_model_feature3') }}</li>
                </ul>
            </div>

            <div class="col">
                <div class="btn">

                    @if (auth()->check() && auth()->user()->user_type_id == 2)
                        <a href="{{ lurl(trans('routes.post-create', $attr), $attr) }}" class="next">{{ trans('frontPage.book_model_btn_label') }}</a>
                    @else
                        <a href="{{ lurl(trans('routes.post-a-job')) }}"  class="next">{{ trans('frontPage.book_model_btn_label') }}</a>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
    <?php /*
    <div class="block colored2">
        <div class="book">
            <h2>{{ trans('frontPage.book_model_title') }}</h2>
            <p>{{ trans('frontPage.book_model_sub_title') }}</p>
            <ul class="bullet-pipe">
                <li><span>{{ trans('frontPage.book_model_feature1') }}</span></li>
                <li><span>{{ trans('frontPage.book_model_feature2') }}</span></li>
                <li><span>{{ trans('frontPage.book_model_feature3') }}</span></li>
            </ul>
            <div class="btn pt-20">
                @if (auth()->check() && auth()->user()->user_type_id == 2)
                    <a href="{{ lurl(trans('routes.post-create', $attr), $attr) }}" class="next green white">{{ trans('frontPage.book_model_btn_label') }}</a>
                @else
                    <a href="{{ lurl(trans('routes.post-a-job')) }}">{{ trans('frontPage.book_model_btn_label') }}</a>
                @endif
            </div>
        </div>
    </div>
    */ ?>
    @include('childs.latest-blogs',['title' => t('Latest blog articles')])