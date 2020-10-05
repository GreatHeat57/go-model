@extends('layouts.app')
@section('content')
    <link href="{{ url(config('app.cloud_url').'/css/custom_select2.css') }}" rel="stylesheet">
    
    <div class="subcover colored-light-blue">
        <h1>{{ trans('frontPage.contact_us_title') }}</h1>
    </div>

    <div class="block">
        <div class="form">
            <div class="inner">
                <h2>{{ trans('frontPage.contact_us_form_title') }}</h2>
                <h4>{{ trans('frontPage.contact_us_form_sub_title') }}</h4>

                <div class="row">
                    <?php /*
                    @if (isset($errors) and $errors->any())
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <!--  <strong>{{-- t('Oops ! An error has occurred, Please correct the red fields in the form') --}}</strong> -->
                            <ul class="list list-check">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                    @if (isset($errors) and $errors->any() && $errors->has('g-recaptcha-response'))
                        <div class="container">
                            <div class="row pt-20">
                                <div class="col-lg-12 pt-20">
                                    <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <ul style="padding-left: 20px; text-align: left;">
                                            @if(isset($errors) && $errors->has('g-recaptcha-response'))
                                                <li>{{ $errors->first('g-recaptcha-response') }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    */ ?>

                    @if (Session::has('flash_notification'))
                        <div class="col-lg-12 col-sm-12 col-md-12 no-pd-lr">
                            @include('flash::message')
                        </div>
                    @endif
                </div>
                <div class="alert alert-success print-success-msg" style="display:none"></div>
                
                <form class="form-horizontal" id="contact-form" role="form" method="post" action="{{ lurl(trans('routes.contact')) }}">
                {!! csrf_field() !!}

                <input type="hidden" id="post_url" name="post_url" value="{{ lurl(trans('routes.contact')) }}">
                <div class="row">
                    {{ Form::text('first_name', old('first_name'),['placeholder' => trans('frontPage.contact_us_form_lbl3').'*', 'required' => 'required', 'class' => $errors->has('first_name') ? 'error-input-border' : '' ]) }}
                    <?php /*
                        @if(isset($errors) && $errors->has('first_name'))
                            <p class="help-block error-p">{{ $errors->first('first_name') }}</p>
                        @endif
                    */ ?>
                    <span class="help-block error-input" id='first_name'></span>
                </div>

                <div class="row">
                    {{ Form::email('email', old('email'),['placeholder' => trans('frontPage.contact_us_form_lbl4').'*', 'required' => 'required', 'class' => $errors->has('email') ? 'error-input-border' : '']) }}
                    <?php /*
                        @if(isset($errors) && $errors->has('email'))
                            <p class="help-block error-p">{{ $errors->first('email') }}</p>
                        @endif
                    */ ?>
                    <span class="help-block error-input" id='email'></span>
                </div>

                <div class="row">
                    <div class="input-group col-md-6 col-sm-12 pl-0 mb-10 padding-lr-0">
                        <?php   
                            $phone_code_option = "";
                            if(old('phone_code') !== null) { 
                                $phone_code_option = old('phone_code'); 
                            } 
                            $phoneIcon = "";
                        ?>
                        <select id="phone_code" name="phone_code" class="form-control form-select2 select2 phone-code-auto-search">
                                @foreach ($countries as $item)
                                    @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                        <?php
                                        $phoneIcon = url('images/flags/16/' . strtolower($item->get('code')) . '.png');
                                        ?>
                                    @endif
                                    <option data-image="{{ $phoneIcon }}" value="{{ $item->get('phone') }}" {{ $phone_code_option == $item->get('phone') ? 'selected="selected"' : '' }} >{{ $item->get('name')." ".$item->get('phone') }}</option>
                                @endforeach
                        </select>
                        <?php /*
                            @if(isset($errors) && $errors->has('phone_code'))
                                <p class="help-block error-p">{{ $errors->first('phone_code') }}</p>
                            @endif
                        */?>
                    </div>
                    <div class="input-group col-md-6 col-sm-12 pr-0 padding-lr-0">
                        {{ Form::text('phone', old('phone') ,['placeholder' => trans('frontPage.contact_us_form_lbl1'), 'onkeypress '=> "return isNumber(event)", 'minlength' => 5, 'maxlength' => 20]) }}
                        <?php /*
                            @if(isset($errors) && $errors->has('phone'))
                                <p class="help-block error-p">{{ $errors->first('phone') }}</p>
                            @endif
                        */?>

                    </div>
                </div>

                <div class="row">
                    {{ Form::text('company_name', old('company_name') ,['placeholder' => trans('frontPage.contact_us_form_lbl5') ]) }}
                    <?php /*
                        @if(isset($errors) && $errors->has('company_name'))
                            <p class="help-block error-p">{{ $errors->first('company_name') }}</p>
                        @endif
                    */?>
                    <span class="help-block error-input" id='company_name'></span>
                </div>

                <div class="row">
                    {{ Form::textarea('message', old('message') ,['placeholder' => trans('frontPage.contact_us_form_lbl2').'*', 'class' => $errors->has('message') ? 'error-input-border' : '', 'required' => 'required', "maxlength"=>"500", "minlength" =>"5"]) }}
                    <?php /*
                        @if(isset($errors) && $errors->has('message'))
                            <p class="help-block error-p">{{ $errors->first('message') }}</p>
                        @endif
                    */ ?>
                    <span class="help-block error-input" id='message'></span>
                </div>

                <?php /*
                    <!-- <div class="checkbox">
                        {{ Form::checkbox('terms',1,false,['class' => 'css-checkbox', 'id' => 'terms']) }}
                        {!! trans('frontPage.terms_link') !!}
                    </div> -->
                */ ?>

                 @if (config('settings.security.recaptcha_activation'))
                        <!-- g-recaptcha-response -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>" style="margin-left: unset;margin-right: unset;">
                            <label class="control-label" for="g-recaptcha-response"></label>
                            <div class="no-label">
                                <?php //{!! Recaptcha::render(['lang' => config('lang.locale'), 'template' => 'recaptcha_widget']) !!} ?>
                                 {!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
                            </div>
                        </div>
                        <span class="help-block error-input" id="error-recaptcha-msg"></span>
                    @endif
                <div class="btn pt-60">
                    {{ Form::button(trans('frontPage.btn_contact_submit'),['type' => 'submit', 'class' => 'green next']) }}
                </div>

                </form>
            </div>
        </div>
    </div>

    @if(!empty($page))
        {!! $page->content !!}
    @endif
    <?php /*
    <!-- <div class="block">
        <div class="cols-3 no-mg-b">
            <div class="col">
                <div class="list pd">
                    <h5>Deutschland</h5>
                    <ul class="nested">
                        <li>Friedrichstr. 123,  10117 Berlin</li>
                        <li>+49-30-61 09 1772</li>
                        <li>de.support@go-models.com</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="list pd">
                    <h5>Österreich</h5>
                    <ul class="nested">
                        <li>Postgasse 19, 1010 Wien</li>
                        <li>+43-1-93 232 93</li>
                        <li>at.support@go-models.com</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="list pd">
                    <h5>Schweiz</h5>
                    <ul class="nested">
                        <li>+41-43-544 80 38</li>
                        <li>ch.support@go-models.com</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="list pd">
                    <h5>Lichtenstein</h5>
                    <ul class="nested">
                        <li>+41-43-544 80 38</li>
                        <li>li.support@go-models.com</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="list pd">
                    <h5>United Kingdom</h5>
                    <ul class="nested">
                        <li>+44-20-3906 1220</li>
                        <li>uk.support@go-models.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="block colored-light-blue mg-b">
        <h4 class="pdleft">{{ trans('frontPage.impression_title') }}</h4>
        <div class="cols-3">
            <div class="col">
                <div class="list">
                   {!! trans('frontPage.impression_column1') !!}
                </div>
            </div>

            <div class="col">
                <div class="list">
                  {!! trans('frontPage.impression_column2') !!}
                </div>
            </div>

            <div class="col">
                <div class="list">
                    {!! trans('frontPage.impression_column3') !!}
                </div>
            </div>
        </div>
    </div> -->
    */ ?>
@endsection
@push('scripts')
    <script src="{{ config('app.cloud_url').'/assets/plugins/select2/js/select2.js' }}" defer></script>
    <script src="{{ config('app.cloud_url').'/js/bladeJs/contact-blade.js' }}" defer></script>

    @if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js'))
        <script src="{{ url(config('app.cloud_url').'/assets/plugins/select2/js/i18n/'.config('app.locale').'.js') }}" defer></script>
    @endif
@endpush