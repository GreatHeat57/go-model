<div class="follow-us pt-60">
    <div class="inner">
        <h2>{{ trans('frontPage.lbl_follow_us') }}</h2>
        <ul>
            <li><a target="_blank" href="{{ (config('country.facebook_link') != '') ? config('country.facebook_link') : config('app.go_model_facebook') }}" class="facebook">Facebook</a></li>
            <li><a target="_blank" href="{{ (config('country.instagram_link') != '') ? config('country.instagram_link') : config('app.go_model_instagram') }}" class="instagram">Instagram</a></li>
            <li><a target="_blank" href="{{ (config('country.twitter_link') != '') ? config('country.twitter_link') : config('app.go_model_twiiter') }}" class="twitter">Twitter</a></li>
            <?php /*<li><a target="_blank" href="{{ config('app.go_model_youtube') }}" class="youtube">Youtube</a></li> */ ?>
            <li><a target="_blank" href="{{ (config('country.pinterest_link') != '') ? config('country.pinterest_link') : config('app.go_model_pinterest') }}" class="pinterest">Pinterest</a></li>
            <?php /* <!-- <li><a href="#" class="pinterest">Pinterest</a></li> --> */ ?>
        </ul>
    </div>
</div>