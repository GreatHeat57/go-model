<div class="white-popup-block" id="mfp-sign-up">
    <h2 class="smaller">{{ t('apply now') }}</h2>
    <p class="text-center" style="text-align: center !important;">{{ t('Create your account, Its free') }}</p>

    <div class="alert alert-danger print-error-msg" style="display:none"></div>
    <div class="alert alert-success print-success-msg" style="display:none"></div>
    
    <input type="hidden" name="partner_type_id" value="{{ config('constant.partner_type_id') }}">
    <input type="hidden" name="model_type_id" value="{{ config('constant.model_type_id') }}">

    <label style="display: none;" id="fields-validations">{{ t("required_field") }}</label>

    <form method="POST" id="submit-register" action="{{ lurl(trans('routes.register')) }}" enctype="multipart/form-data">
    {!! csrf_field() !!}

        <?php
            /*$utm_source   = (Session::has('utm_source')) ? Session::get('utm_source') : '';
            $utm_medium   = (Session::has('utm_medium')) ? Session::get('utm_medium') : '';
            $utm_campaign = (Session::has('utm_campaign')) ? Session::get('utm_campaign') : '';
            $utm_content  = (Session::has('utm_content')) ? Session::get('utm_content') : '';
            $utm_term     = (Session::has('utm_term')) ? Session::get('utm_term') : '';
            $gclid        = (Session::has('gclid')) ? Session::get('gclid') : '';
            $clientId     = (Session::has('clientId')) ? Session::get('clientId') : '';*/
        ?>
        
        <?php
        /*<input type="hidden" name="utm_source" id="utm_source" value="{{ $utm_source }}">
        <input type="hidden" name="utm_medium" id="utm_medium" value="{{ $utm_medium }}">
        <input type="hidden" name="utm_campaign" id="utm_campaign" value="{{ $utm_campaign }}">
        <input type="hidden" name="utm_content" id="utm_content" value="{{ $utm_content }}">
        <input type="hidden" name="utm_term" id="utm_term" value="{{ $utm_term }}">
        <input type="hidden" name="gclid" id="gclid" value="{{ $gclid }}">
        <input type="hidden" name="clientId" id="clientId" value="{{ $clientId }}">*/
        ?>

        <div class="form">
            <div class="row" >
                {{ Form::text('first_name', old('first_name'), ['class' => '', 'placeholder' => t('First Name').'*', 'required' => 'required', 'autocomplete' => 'first-add' ]) }}
                <p class="help-block err-input" id='first_name'></p>
            </div>

            <div class="row" >
                {{ Form::text('last_name', old('last_name'), ['class' => '','placeholder' => t('Last Name').'*', 'required' => 'required', 'autocomplete' => 'last-add']) }}
                <p class="help-block err-input" id='last_name'></p>
            </div>

            <div class="radio" >
                <span>{{ t('You are a').'*' }}</span>

                <?php if (isset($userTypes) && count($userTypes) > 0) {?>

                    @foreach ($userTypes as $type)
                        @if ($type->id == config('constant.partner_type_id') || $type->id == config('constant.model_type_id'))
                            <input name="user_type" type="radio" id="radio-{{ $type->id }}" class="css-radio" value="{{$type->id}}" @if($type->id == config('constant.model_type_id')) checked='checked'  @endif>
                            <label for="radio-{{$type->id}}" class="css-label2">{{ t($type->name) }}</label>
                        @endif
                    @endforeach

                <?php }?>
                <p class="help-block err-input" id="user_type"></p>
            </div>

            <div id="partner-fields">
                <div class="row"  >
                    {{ Form::text('company_name', old('company_name'), ['class' => '','placeholder' => t('Company Name').'*', 'required' => 'required', 'autocomplete' => 'company-add']) }}
                    <p class="help-block err-input" id='company_name'></p>
                </div>

                <div class="row" >
                    {{ Form::text('website', old('website'), ['class' => '','placeholder' => t('Website').'*', 'required' => 'required', 'autocomplete' => 'website-add' ]) }}
                    <p class="help-block err-input" id='website'></p>
                </div>
            </div>

            <div class="row" >
                {{ Form::email('email',old('email'),['class' => '','placeholder' => t('Email').'*', 'required' => 'required', 'autocomplete' => 'email-add']) }}
                <p class="help-block err-input" id="email"></p>
            </div>
            
            <?php /* 
            
            <!-- phone code dropdown and phone number input -->
            <div class="row mb-0" id="phone-code-row">                        
                <div class="row col-md-6 col-sm-12 pl-0 padding-lr-0 mb-0" id="phone_code-jq-err">
                    <select name="phone_code" class="form-control phone-select2 phone-code-auto-search-signup" required autocomplete="phone_number" >
                            <option value=""> {{ t('Phone Code').'*' }} </option>
                            @foreach ($countries as $item)
                                @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                    <?php
                                    $phoneIcon = url('images/flags/16/' . strtolower($item->get('code')) . '.png');
                                    ?>
                                @endif
                                <option data-image-phone="{{ $phoneIcon }}" value="{{ $item->get('phone') }}">{{ $item->get('name')." ".$item->get('phone') }}</option>
                            @endforeach
                    </select>
                    <p class="help-block err-input" id="phone_code"></p>
                </div>
                <div class="row col-md-6 col-sm-12 pr-0 mb-0" style="padding-left: 0px; padding-right: 0px;" id="phone-jq-err">
                    {{ Form::text('phone', old('phone'), ['class' => 'animlabel', 'placeholder' => t('Phone').'*', 'required', 'autocomplete' => 'phone-add' , 'minlength' => 5 , 'maxlength' => 20, 'onkeypress '=> "return isNumber(event)"]) }}
                    <p class="help-block err-input" id="phone"></p>
                </div>
            </div>
            <!-- End phone code dropdown and phone number input -->
            
            */?>

            <!-- recaptcha -->
            @if (config('settings.security.recaptcha_activation'))
                <div class="form-group <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="g-recaptcha-response"></label>
                    <div class="no-label">
                        {!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
                    </div>
                </div>
                <p class="help-block err-input" id="error-recaptcha-msg"></p>
            @endif

            <div class="checkbox" >
                {{ Form::checkbox('term',1,false,['class' => 'css-checkbox', 'id' => 'terms']) }}
                <label for="terms" class="css-label">{!! t('I have read and agree') !!}</label>
                <p class="help-block err-input" id="error-terms"></p>
                

                {{ Form::checkbox('newsletter',1, false,['class' => 'css-checkbox', 'id' => 'newsletter']) }}

                <label for="newsletter" class="css-label" id="newsletter_id">{{ t('Job-Newsletters') }}</label>
            </div>

            <label id="newsletter_model_id" style="display: none;">{{ t('Job-Newsletters') }}</label>
            <label id="newsletter_partner_id" style="display: none;">{{ t('Job-Newsletters-partner') }}</label>
            <div class="btn mb-30">
                <button class="green next" type="submit" id="register-form">{{ t('apply for free') }}</button>
            </div>
            <div class="text-center">
                <span>{{t('Already registered')}} 
                    <a href="{{ lurl(trans('routes.login')) }}" class="already-register text-decoration-none">{{t('Log In')}}</a>
                </span>
            </div>
        </div>
    </form>
    <?php /*
    <div class="row social-link sign_up_links"> 
            <button class="social-button facebook social-facebook-btn" type="button" id="fb_login">{{ 'Facebook' }}</button>
            <input type="hidden" name="facebook_link" value="{{ lurl('auth/facebook') }}">
            <button class="social-button google social-google-btn" type="button" id="google_login">{{ 'Google' }}</button>
            <input type="hidden" name="google_link" value="{{ lurl('auth/google') }}">
    </div> */ ?>
</div>
<style type="text/css">
    .invalid-input { color: #fa4754; border-bottom: 1px solid #fa4754;}
    .form-select { display: block; width: 100%; height: 36px; outline: none;  resize: none; -webkit-appearance: none; border-radius: 0; border: 0; border-bottom: 1px solid #d0d0d0; font-family: work_sansregular,arial,tahoma; font-size: 16px;padding: 0;margin: 0; }
    .text-decoration-none{
        text-decoration: none !important;
    }
    .white-popup-block p, .white-popup-block h3 {
        text-align: left !important;
    }

    .err-input { padding: 0 !important; }
    p.help-block { color: red; }
    
    div#phone-jq-err input {
        height: 38px;
    }
</style>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->

<link src="{{ config('app.cloud_url').'/assets/plugins/select2/css/select2.css' }}" rel="stylesheet">
<link href="{{ url(config('app.cloud_url').'/css/custom_select2.css') }}" rel="stylesheet">