<div id="stepWizard" class="d-flex align-items-center container px-0 mw-970 pt-20">
    <div class="box-shadow full-width">
        <div class="full-width">
            <section>
                <div class="wizard">
                    <ul class="nav nav-wizard">
                        <li class="{{ ($uriPath == 'email') ? 'active' : 'disabled' }}">
                            <a href="#" class="{{ ($uriPath == 'email') ? 'active' : 'disabled' }}">{{ t('Email') }}</a>
                        </li>
                        <li class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) ? 'disabled' : 'disabled') }}" >
                            @if (isset($slug) and !empty($slug) and $uriPath !== 'data')
                                <?php $url = '/'.trans('routes.registerData') . '/' . $slug; ?>
                                <a href="{{ lurl($url) }}" class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) ? '' : 'disabled') }}">{{ t('Personal Details') }}</a>
                            @else
                                <a class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) ? '' : 'disabled') }}">{{ t('Personal Details') }}</a>
                            @endif
                        </li>
                        @if (isset($user->user_type_id) and !empty($user->user_type_id))
                            @if ($user->user_type_id == 3)
                                <li class="{{ ($uriPath == 'photo') ? 'active' : 'disabled' }}">
                                    <a class="{{ ($uriPath == 'photo') ? 'active' : 'disabled' }}">{{ t('Profile Picture') }}</a>
                                </li>
                            @endif
                        @endif
                        <li class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">
                            <a class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">{{ t('Finish') }}</a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
/*

<ul class="tabs d-none d-md-block" style="border-top: 0px !important;">
    
    <li>
        <a href="#" class="{{ ($uriPath == 'email') ? 'active' : 'disabled' }}">{{ t('Email') }}</a>
    </li>

    <li>
        @if (isset($slug) and !empty($slug) and $uriPath !== 'data')
            <?php $url = '/'.trans('routes.registerData') . '/' . $slug; ?>
            <a href="{{ lurl($url) }}" class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) or (isset($post) and !empty($post)) ? '' : 'disabled') }}">{{ t('Personal Details') }}</a>
        @else
            <a class="{{ ($uriPath == 'data') ? 'active' : (in_array($uriPath, ['photo']) ? '' : 'disabled') }}">{{ t('Personal Details') }}</a>
        @endif
    </li>

    @if (isset($user->user_type_id) and !empty($user->user_type_id))
        @if ($user->user_type_id == 3)
            <li>
                <a class="{{ ($uriPath == 'photo') ? 'active' : '' }}" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 2) ? 'none': 'block'; ?>">{{ t('Profile Picture') }}</a>
            </li>
        @endif
    @endif   

    <?php /*
    @if (isset($user->user_type_id) and !empty($user->user_type_id))
        @if ($user->user_type_id == 3)
            <li>
                <a class="{{ ($uriPath == 'photo') ? 'active' : '' }}" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 2) ? 'none': 'block'; ?>">{{ t('Profile Picture') }}</a>
            </li>
        @endif
    @else
        <li>
            @if (isset($slug) and !empty($slug) and ($uriPath == 'photo'))
                <a href="{{ lurl('register/photo/'.$slug) }}" class=" {{ ($uriPath == 'photo') ? 'active' : '' }}" style="display: <?php echo (old('user_type', \Illuminate\Support\Facades\Request::input('type')) == 2) ? 'none': 'block'; ?>">{{ t('Profile Picture') }}</a>
            @else
                <a class="active">{{ t('Profile Picture') }}</a>
            @endif
        </li>
    @endif
    ?>

    <li>
        <a class="{{ ($uriPath == 'finish') ? 'active' : 'disabled' }}">{{ t('Finish') }}</a>
    </li>
</ul>

*/ ?>
@if (config('lang.direction') == 'rtl')
    <link href="{{ url(config('app.cloud_url').'/assets/css/rtl/wizard.css') }}" rel="stylesheet">
@else
    <link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
@endif
 