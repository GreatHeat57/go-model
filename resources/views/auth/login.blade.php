@extends('layouts.logged_in.out_of_app')

@section('content')
    <div class="d-flex align-items-center container out_of_app px-0 mw-970" id="login_div">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20 py-md-30 bb-grey">
                <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                     src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo"/>
            </div>
            
            @if (isset($errors) and $errors->any() && (!$errors->has('login')) && (!$errors->has('password')) )
                <div class="container">
                    <div class="row pt-20">
                        <div class="col-lg-12 pt-20">
                            <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul style="padding-left: 20px; text-align: left;">
                                    @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="mw-720 mx-auto">
                @if (Session::has('flash_notification'))
                    <div class=" pt-20">
                        @include('flash::message')
                    </div>
                @endif

                @if (session('status'))
                    <div class="pt-20">
                        <div class="alert alert-success">
                            <p>{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('email'))
                    <div class="pt-20">
                        <div class="alert alert-danger">
                            <p>{{ session('email') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 py-20 px-20">
                    <span class="title">{{t('Login')}}</span>
                    <span class="divider"></span>
                    
                    <?php /*
                    <div class="row mx-0 pb-4 border-bottom">
                        <div class="col-md-6 px-0 pb-2">
                            <button type="button" class="btn col-md-11 social-button facebook mb-3 mb-md-0 mr-1" id="fb_login">{{ 'Facebook' }}</button>
                        </div>
                        <div class="col-md-6 px-0 pb-2">
                            <button type="button" class="btn col-md-11 social-button google" id="google_login" style="float:right;">{{ 'Google' }}</button>
                        </div>
                    </div> */ ?>
                    <?php /* <!-- {{ Form::open() }} --> */ ?>

                    <form id="loginForm" role="form" method="POST" action="{{ url()->current() }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="country" value="{{ config('country.code') }}" autocomplete="off">
                        <?php
                            $loginValue = (session()->has('login')) ? session('login') : old('login');
                            $loginField = getLoginField($loginValue);
                            if ($loginField == 'phone') {
                            	$loginValue = phoneFormat($loginValue, old('country', config('country.code')));
                            }
                        ?>  
                        <?php /*
                            @if (Session::has('flash_notification'))
                                <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                                    <div class="row">
                                        <div class="col-lg-12 padding-none">
                                            @include('flash::message')
                                        </div>
                                    </div>
                                </div>
                            @endif */ 
                        ?>
                        <?php /* <!-- <div class="error-message mb-30">Wrong username!</div> --> */ ?>
                        <div class="input-group mt-5 <?php echo (isset($errors) and $errors->has('login')) ? 'has-error' : ''; ?>">
                            {{ Form::text('login', old('login'), ['class' => !empty(old('login'))? 'noanimlabel': 'animlabel','id'=>'email','required' => true, 'autocomplete' => 'nope']) }}
                            {{ Form::label('login', t('Username_Email_Address'), ['class' => 'required']) }}
                            
                            @if(isset($errors) && $errors->has('login'))
                                <p class="help-block">{{ $errors->first('login') }}</p>
                            @endif
                        </div>

                        <div class="input-group mb-20 <?php echo (isset($errors) and $errors->has('login')) ? 'has-error' : ''; ?>" >
                            {{ Form::password('password', ['class' => !empty(old('password'))? 'noanimlabel': 'animlabel','id'=>'password', 'required' => true, 'autocomplete' => 'new-password']) }}
                            {{ Form::label('password', t('Password'), ['class' => 'required']) }}

                            @if(isset($errors) && $errors->has('password'))
                                <p class="help-block">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        
                        <a href="{{ lurl(trans('routes.password-reset')) }}" class="d-inline-block bold bb-black lh-15 mb-40">{{t('Forgot password')}}</a>

                        <div class="text-center"><button id="loginBtn" class="d-inline-block btn btn-success login mb-40">{{t('Login')}}</button></div>
                        
                        <div class="text-center"><span>{{t('Not a member yet')}} <a href="#" class="d-inline-block bold bb-black lh-15 mfp-register-form">{{t('Signup')}}</a></span></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
{{ Html::style(config('app.cloud_url').'/css/bladeCss/login-blade.css') }}
<script type="text/javascript">
    var fb_login_url = "{{ lurl('auth/facebook') }}";
    var google_login_url = "{{ lurl('auth/google') }}";
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/login-blade.js') }}
@endsection