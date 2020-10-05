<div class="block {{ isset($class) ? $class : '' }}" style="border-bottom:none;">
    <h2>{{ trans('frontPage.go_model_category_title') }}</h2>

    <div class="cols-2 nested">
        <div class="col">
            <div class="howto">
                <ul>
                    <li>{!! trans('frontPage.be_client_step1') !!}</li>
                    <li>{!! trans('frontPage.be_client_step2') !!}</li>
                    <li>{!! trans('frontPage.be_client_step3') !!}</li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="howto">
                <ul>
                    <li>{!! trans('frontPage.be_client_step4') !!}</li>
                    <li>{!! trans('frontPage.be_client_step5') !!}</li>
                    <li>{!! trans('frontPage.be_client_step6') !!}</li>
                </ul>
            </div>
        </div>
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