<div class="block no-pd-lr">
    <div class="cta">
        <img class="lazyload" data-src="{{ URL::to(config('app.cloud_url') . '/images/model_agency.webp') }}" alt="{{ trans('metaTags.img_model_agency') }}" onerror=this.src="{{ URL::to(config('app.cloud_url') . '/images/model_agency.jpg') }}" />
        <div class="inner">
            <div class="text text-center">
                <div class="holder">
                    <h2>{{ trans('frontPage.apply_lbl') }}</h2>
                    <p>{{ trans('frontPage.apply_desc') }}</p>
                    <div class="btn">
                        <a href="{{ lurl(trans('routes.go-premium')) }}" class="green next white">
                        {{ trans('frontPage.apply_btn') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>