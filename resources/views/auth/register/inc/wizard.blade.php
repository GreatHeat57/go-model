<div id="stepWizard" class="container">
    <div class="row">
        <div class="col-lg-12">
            <section>
                <div class="wizard">
                    
                    <ul class="nav nav-wizard">

                        <li class="{{ ($uriPath == 'email') ? 'active' : (in_array($uriPath, ['data', 'photo']) or (isset($post) and !empty($post)) ? '' : 'disabled') }}">
                            <!-- @if (isset($post) and !empty($post))
                                <a href="{{ lurl('posts/create/' . $post->tmp_token) }}">{{ t('Job Details') }}</a>
                            @else
                                <a href="{{ lurl('posts/create') }}">{{ t('Job Details') }}</a>
                            @endif -->
                            <a href="{{ lurl('register') }}" rel="nofollow">{{ t('Email') }}</a>
                        </li>

                        <li class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) or (isset($post) and !empty($post)) ? '' : 'disabled') }}">
                            @if (isset($slug) and !empty($slug))
                                <a href="{{ lurl('register/data/'.$slug) }}">{{ t('Data') }}</a>
                            @else
                                <a>{{ t('Data') }}</a>
                            @endif
                        </li>

                        @if (isset($user->user_type_id) and !empty($user->user_type_id))
                            @if ($user->user_type_id == 3)
                                <li>
                                    <a>{{ t('Photo') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="for-model {{ ($uriPath == 'photo') ? 'active' : '' }}" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 2) ? 'none': 'block'; ?>">
                                @if (isset($slug) and !empty($slug) and ($uriPath == 'photo'))
                                    <a href="{{ lurl('register/photo/'.$slug) }}">{{ t('Photo') }}</a>
                                @else
                                    <a>{{ t('Photo') }}</a>
                                @endif
                            </li>
                        @endif

                        <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                            <a>{{ t('Finish') }}</a>
                        </li>

                    </ul>
                    
                </div>
            </section>
        </div>
    </div>
</div>

@section('after_styles')
    @parent
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url(config('app.cloud_url').'/assets/css/rtl/wizard.css') }}" rel="stylesheet">
    @else
        <link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
    @endif
@endsection
@section('after_scripts')
    @parent
@endsection