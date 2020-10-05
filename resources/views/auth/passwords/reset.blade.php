@extends('layouts.logged_in.out_of_app')

@section('content')
    <div class="d-flex align-items-center container out_of_app px-0 mw-970">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20 py-md-30 bb-grey">
                <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                     src="URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo"/>
            </div>
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 py-40 px-30">

						@if (Session::has('flash_notification'))
							<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
								<div class="row">
									<div class="col-lg-12">
										@include('flash::message')
									</div>
								</div>
							</div>
						@endif


						@if (session('status'))
							<div class="col-lg-12">
								<div class="alert alert-success">
									<?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
									<p>{{ session('status') }}</p>
								</div>
							</div>
						@endif

						@if (session('email'))
							<div class="col-lg-12">
								<div class="alert alert-danger">
									<?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
									<p>{{ session('email') }}</p>
								</div>
							</div>
						@endif

						@if (session('phone'))
							<div class="col-lg-12">
								<div class="alert alert-danger">
									<?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
									<p>{{ session('phone') }}</p>
								</div>
							</div>
						@endif

						@if (session('login'))
							<div class="col-lg-12">
								<div class="alert alert-danger">
									<?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
									<p>{{ session('login') }}</p>
								</div>
							</div>
						@endif

						@if (isset($errors) and $errors->any() && (!$errors->has('login')) && (!$errors->has('password')) && (!$errors->has('password_confirmation')))
							<div class="pt-20">
								<div class="alert alert-danger">
								<?php /* <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --> */ ?>
									<ul style="padding-left: 20px; text-align: left;">
										@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						@endif
					<span class="title">{{ t('Reset Password') }}</span>
                    <span class="divider"></span>
					<form id="pwdForm" role="form" method="POST" action="{{ lurl(trans('routes.password-reset')) }}" autocomplete="off" >
						{!! csrf_field() !!}
						<input type="hidden" name="token" value="{{ $token }}">
						<!-- Login -->
						<div class="input-group <?php echo (isset($errors) and $errors->has('login')) ? 'has-error' : ''; ?>">

							<input type="text" name="login" value="{{ old('login') }}" placeholder="" id="login" class="{{ !empty(old('login'))? 'noanimlabel': 'animlabel' }}" required="true" autocomplete="nope">
							<label for="login" class="control-label required">{{ t('Login') }} ( {{ t('Username_Email_Address') }} )</label>

							@if(isset($errors) && $errors->has('login'))
	                            <span class="help-block">{{ $errors->first('login') }}</span>
	                        @endif
						</div>

						<!-- Password -->
						<div class="input-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
							<input type="password" name="password" placeholder="" id="password" class=" email {{ !empty(old('password'))? 'noanimlabel': 'animlabel' }}"  required="true" autocomplete="new-password">
							<label for="password" class="control-label required">{{ t('Password') }}</label>
							@if(isset($errors) && $errors->has('password'))
	                            <span class="help-block">{{ $errors->first('password') }}</span>
	                        @endif
						</div>

						<!-- Confirmation -->
						<div class="input-group <?php echo (isset($errors) and $errors->has('password_confirmation')) ? 'has-error' : ''; ?>">
							<input type="password" name="password_confirmation" id="password_confirmation" placeholder="" class="{{ !empty(old('password_confirmation'))? 'noanimlabel': 'animlabel' }}"  required="true" autocomplete="new-password">
							<label for="password_confirmation" class="control-label required">{{ t('Password Confirmation') }}</label>

							@if(isset($errors) && $errors->has('password_confirmation'))
	                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
	                        @endif
						</div>
						
						<?php /* <!-- <a href="{{-- lurl(trans('routes.login')) --}}" class="d-inline-block bold bb-black lh-15 mb-40 text-decoration-none">{{ t('Login here') }}</a> --> */ ?>


						<!-- Submit -->
						<div class="text-center">
							<button type="submit" class="d-inline-block btn btn-success login mb-40">{{ t('reset') }}</button>
						</div>
					</form>
					<div class="text-center">
						<span>{{ t('Already have password') }} <a href="{{ lurl(trans('routes.login')) }}" class="d-inline-block bold bb-black lh-15 text-decoration-none"><strong>{{ t('Login here') }}</strong></a></span>
					</div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
<script> $(document).ready( function(){ $('#password_confirmation').val(''); $('#password').val(''); $('#login').val(''); });</script>
{{ Html::style(config('app.cloud_url').'/css/bladeCss/login-blade.css') }}
@endsection