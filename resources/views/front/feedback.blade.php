@extends('layouts.app')

@section('content')
    <div class="subcover colored-light-blue">
        <h1>{{ trans('frontPage.feedback_title') }}</h1>
    </div>

    <div class="block">
        <div class="form">
            <div class="inner">
                <h2>{{ trans('frontPage.feedback_form_title') }}</h2>
                <?php /* <!-- <h4>{{ trans('frontPage.contact_us_form_sub_title') }}</h4> --> */ ?>
                {!! trans('frontPage.feedback_form_sub_title') !!}
                <div class="row">
                    
                    @if (isset($errors) and $errors->any() and $errors->has('g-recaptcha-response'))
                        <div class="col-lg-12 pt-20 no-pd-lr">
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul style="padding-left: 20px; text-align: left;">
                                    @if(isset($errors) && $errors->has('g-recaptcha-response'))
                                        <li>{{ $errors->first('g-recaptcha-response') }}</li>
                                    @endif
                                </ul>
                            </div> 
                        </div>
                    @endif

                    @if (Session::has('flash_notification'))
                        <div class="col-lg-12 col-sm-12 col-md-12 no-pd-lr">
                            @include('flash::message')
                        </div>
                    @endif
                </div>
                <div class="alert alert-success print-success-msg" style="display:none"></div>

                <form class="form-horizontal" id="feedback-form" role="form" method="post" action="{{ lurl(trans('routes.feedback')) }}">
                    {!! csrf_field() !!}
                    <input type="hidden" id="post_url" name="post_url" value="{{ lurl(trans('routes.feedback')) }}">
                    <div class="row">
                        {{ Form::text('first_name', old('first_name'),['placeholder' => t('full name').'*', 'required' => 'required']) }}
                        <?php /*
                        @if(isset($errors) && $errors->has('first_name'))
                            <span class="help-block error-p">{{ $errors->first('first_name') }}</span>
                        @endif
                        */ ?>
                        <span class="help-block error-input" id='first_name'></span>
                    </div>

                    <div class="row">
                        {{ Form::email('email', old('email'),['placeholder' => t('Email Address').'*', 'required' => 'required']) }}
                        <?php /*
                            @if(isset($errors) && $errors->has('email'))
                                <span class="help-block error-p">{{ $errors->first('email') }}</span>
                            @endif
                        */ ?>
                        <span class="help-block error-input" id='email'></span>
                    </div>

                    <div class="row">
                        {{ Form::text('subject', old('subject') ,['placeholder' => t('Subject').'*', 'required' => 'required']) }}
                        <?php /*
                            @if(isset($errors) && $errors->has('subject'))
                                <span class="help-block error-p">{{ $errors->first('subject') }}</span>
                            @endif
                        */?>
                        <span class="help-block error-input" id='subject'></span>
                    </div>

                    <div class="row">
                        <label class="control-label" for="">{{ t('Message (upto 500 letters)') }}</label>
                        {{Form::textarea('message', old('message') ,['placeholder' => t('Your suggestion for improvement').'*', 'required' => 'required', "maxlength"=>"500", "minlength" =>"5"])}}
                        <?php /*
                            @if(isset($errors) && $errors->has('message'))
                                <span class="help-block error-p">{{ $errors->first('message') }}</span>
                            @endif
                        */ ?>
                        <span class="help-block error-input" id='message'></span>
                    </div>
                    @if (config('settings.security.recaptcha_activation'))
                        <!-- g-recaptcha-response -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>" style="margin-left: unset;margin-right: unset;">
                            <label class="control-label" for="g-recaptcha-response"></label>
                            <div class="no-label">
                                {!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
                            </div>
                        </div>
                        <span class="help-block error-input" id="error-recaptcha-msg"></span>
                    @endif
                
                    <?php /*
                    <!-- <div class="checkbox">
                        {{ Form::checkbox('terms',1,false,['class' => 'css-checkbox', 'id' => 'terms']) }}
                        {!! trans('frontPage.terms_link') !!}
                    </div> -->
                    */ ?>
                    <div class="btn pt-60 ">
                        {{ Form::button(trans('frontPage.btn_feedback_submit'),['type' => 'submit', 'class' => 'green next']) }}
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('page-script')
    @endsection

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