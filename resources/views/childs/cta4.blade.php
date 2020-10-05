<div class="block no-pd-lr">
    <div class="cta">
        <img src="{{ URL::to(config('app.cloud_url').'/images/CTA.jpg') }}" alt="{{ trans('metaTags.img_Go-Models-Call-Center') }}" />
        <div class="inner">
            <div class="text">
                <div class="holder left">
                    <h2>{!! trans('frontPage.have_questions') !!}</h2>
                    <p>{!! trans('frontPage.have_questions_desc') !!}</p>
                    <a href="{{ lurl(trans('routes.contact')) }}">{!! trans('frontPage.write_us') !!}</a>
                </div>
            </div>
        </div>
    </div>
</div>