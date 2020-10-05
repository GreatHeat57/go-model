<div class="block no-pd-lr {{ isset($class) ? $class : '' }}">
    <div class="cta">
        <img src="{{ URL::to(config('app.cloud_url').'/images/model_agency.jpg') }}" alt="{{ trans('metaTags.img_model_agency') }}" />
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