<div class="block {{ isset($class) ? $class : '' }}">
    <h2>{{ trans('frontPage.reason_client_title') }}</h2>

    <div class="cols-3 nested">
        <div class="col">
            <div class="reason">
                <span>1</span>
                <h4>{{ trans('frontPage.reason_client_title_step1_title') }}</h4>
                <p>{{ trans('frontPage.reason_client_title_step1_desc') }}</p>
            </div>
        </div>

        <div class="col">
            <div class="reason">
                <span>2</span>
                <h4>{{ trans('frontPage.reason_client_title_step2_title') }}</h4>
                <p>{{ trans('frontPage.reason_client_title_step2_desc') }}</p>
            </div>
        </div>

        <div class="col">
            <div class="reason">
                <span>3</span>
                <h4>{{ trans('frontPage.reason_client_title_step3_title') }}</h4>
                <p>{{ trans('frontPage.reason_client_title_step3_desc') }}</p>
            </div>
        </div>
    </div>

    <div class="btn">
        @if (Auth::User() && Auth::User()->user_type_id == 2)
            <a href="{{ lurl(trans('routes.model-list')) }}" class="register">{{ trans('frontPage.btn_register_client') }}</a>
        @elseif (Auth::User() && Auth::User()->user_type_id == 3)
            <a href="javascript:void(0);" class="register disabled disabled_opacity">{{ trans('frontPage.btn_register_client') }}</a>
        @else
            <a href="javascript:void(0);" class="register mfp-register-form">{{ trans('frontPage.btn_register_client') }}</a>
        @endif
    </div>
</div>