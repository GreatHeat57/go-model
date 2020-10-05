@extends('layouts.logged_in.out_of_app')

@section('content')
    <div class="d-flex align-items-center container out_of_app px-0 mw-970">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20 py-md-30 bb-grey">
                <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                     src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo"/>
            </div>
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 py-40 px-30">

                @if (Session::has('flash_notification'))
                <div class="">
                    <div class="row pt-20">
                        <div class="col-lg-12 pt-20">
                            @include('flash::message')
                        </div>
                    </div>
                </div>
                @endif
            
                @if (session('status'))
                    <div class="">
                        <div class="row pt-20">
                            <div class="col-lg-12 pt-20">
                                <div class="alert alert-success">
                                    <?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
                                    <p>{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @if (session('email'))
                <div class="">
                    <div class="row pt-20">
                        <div class="col-lg-12 pt-20">
                            <div class="alert alert-danger">
                                <?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
                                <p>{{ session('email') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($errors) and $errors->any() && (!$errors->has('email')) )
                <div class="">
                    <div class="row pt-20">
                        <div class="col-lg-12 pt-20">
                            <div class="alert alert-danger">
                            <?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
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
            
                    <span class="title">{{ t('Forgot password') }}</span>
                    <span class="divider"></span>
                    <span class="mb-40">{{ t("We'll send you an email with further instructions on how to reset your password") }}</span>

                    <form id="pwdForm" role="form" method="POST" action="{{ lurl('password/email') }}">
                        {!! csrf_field() !!}

                        <!-- Login -->
                        <div class="input-group mb-40 <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                            <input id="login" name="email" type="text" class="{{!empty(old('email'))? 'noanimlabel': 'animlabel'}}" value="{{ old('email') }}" required="true" autocomplete='off'>
                            <label for="email" class="required">{{ t('Username_Email_Address') }}</label>
                            @if(isset($errors) && $errors->has('email'))
                                <p class="help-block">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <?php /* <!--  <div class="input-group mb-40">
                            {{ Form::password('password', ['class' => 'animlabel']) }}
                            {{ Form::label('password', 'Password', ['class' => 'required']) }}
                        </div> --> */ ?>

                        <div class="text-center">
                            <?php /* <!-- <a href="#" class="d-inline-block btn btn-success login mb-40">Send email</a> --> */ ?>
                            <button id="pwdBtn" type="submit" class="d-inline-block btn btn-success login mb-40">{{ t('reset') }}</button>
                        </div>
                        <div class="text-center"><span>{{ t('Already have password') }} <a href="{{ lurl(trans('routes.login')) }}" class="d-inline-block bold bb-black lh-15 text-decoration-none">{{ t('Login here') }}</a></span></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
<script> $(document).ready( function(){ $('#login').val(''); }) </script>
{{ Html::style(config('app.cloud_url').'/css/bladeCss/login-blade.css') }}
@endsection