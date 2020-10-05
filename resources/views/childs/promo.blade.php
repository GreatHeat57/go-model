<div class="block {{ isset($class) ? $class : '' }}">
    <div class="cols-2 no-mg-b">
        <div class="col">
            <div class="promo">
                <img src="{{ URL::to(config('app.cloud_url').'/images/promo1.webp') }}" alt="{{ trans('frontPage.partner_step_title') }}" onerror=this.src='{{ URL::to(config('app.cloud_url').'/images/promo1.jpg') }}' />
                <div class="data">
                    <h2>{{ trans('frontPage.partner_step_title') }}</h2>
                    <ul>
                        <li>{{ trans('frontPage.partner_list_item1') }}</li>
                        <li>{{ trans('frontPage.partner_list_item2') }}</li>
                        <li>{{ trans('frontPage.partner_list_item3') }}</li>
                    </ul>
                    <div class="btn pt-15">
                        @if (Auth::User() && Auth::User()->user_type_id == 2)
                            <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.partner_step_button_label') }}</a>
                        @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                            <a href="javascript:void(0);" class="next disabled disabled_opacity">{{ trans('frontPage.partner_step_button_label') }}</a>
                        @else
                        <!-- <a href="#" class="next mfp-register">{{ trans('frontPage.partner_step_button_label') }}</a> -->
                        <a href="{{ lurl(trans('routes.login')) }}" class="next">{{ trans('frontPage.partner_step_button_label') }}</a>
                        @endif
                        <!-- route('book_a_model')  -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="promo">
                <img src="{{ URL::to(config('app.cloud_url').'/images/promo2.webp') }}" alt="{{ trans('frontPage.model_step_title') }}" onerror=this.src='{{ URL::to(config('app.cloud_url').'/images/promo2.jpg') }}' />
                <div class="data">
                    <h2>{{ trans('frontPage.model_step_title') }}</h2>
                    <ul>
                        <li>{{ trans('frontPage.model_list_item1') }}</li>
                        <li>{{ trans('frontPage.model_list_item2') }}</li>
                        <li>{{ trans('frontPage.model_list_item3') }}</li>
                    </ul>
                    <div class="btn pt-15">
                        @if (auth()->check())
                            <a href="javascript:void(0);" class="next disabled_opacity disabled">{{ trans('frontPage.model_step_button_label') }}</a>
                        @else
                        <a href="#" class="next mfp-register-form">{{ trans('frontPage.model_step_button_label') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>