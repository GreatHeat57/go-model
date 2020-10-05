<div class="block colored2">
    <div class="have-a-job">
        <div class="col">
            <h3>{{ trans('frontPage.have_job_title') }}</h3>
        </div>

        <div class="col">
            <ul class="bullet-pipe max no-mg-b">
                <li>{{ trans('frontPage.have_job_feature1') }}</li>
                <li>{{ trans('frontPage.have_job_feature2') }}</li>
            </ul>
        </div>

        <div class="col">
            <div class="btn">
                @if (auth()->check() && auth()->user()->user_type_id == 2)
                <a href="{{ lurl(trans('routes.model-list')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a>
                @elseif (Auth::User() && Auth::User()->user_type_id == 3)
                    <a href="javascript:void(0);" class="next disabled_opacity disabled">{{ trans('frontPage.have_job_btn_label') }}</a>
                @else
                <?php /*
                <!-- <a href="{{ lurl(trans('routes.post-a-job')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a> -->
                */ ?>
                <a href="{{ lurl(trans('routes.login')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a>
                @endif
                <?php /*
                <!-- <a href="{{ lurl(trans('routes.post-a-job')) }}" class="next">{{ trans('frontPage.have_job_btn_label') }}</a> -->
                */ ?>
            </div>
        </div>
    </div>
</div>