@extends('layouts.logged_in.out_of_app')

@section('content')
    <div class="d-flex align-items-center container out_of_app px-0 mw-970">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20 py-md-30 bb-grey">
                <img srcset="{{ URL::to('images/img-logo.png') }},
                                 {{ URL::to('images/img-logo@2x.png') }} 2x,
                                 {{ URL::to('images/img-logo@3x.png') }} 3x"
                     src="/images/img-logo.png" alt="{{ trans('metaTags.Go-Models') }}" class="logo"/>
            </div>
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 py-40 px-30">
                    <span class="title">Sign Up</span>
                    <span class="divider"></span>
                    {{ Form::open() }}
                    <div class="input-group">
                        {{ Form::email('email', null, ['class' => 'animlabel']) }}
                        {{ Form::label('email', 'E-mail address', ['class' => 'required']) }}
                    </div>
                    <div class="input-group mb-40">
                        {{ Form::password('password', ['class' => 'animlabel']) }}
                        {{ Form::label('password', 'Password', ['class' => 'required']) }}
                    </div>
                    <div class="col-md-6 px-0">
                        <p>I am</p>
                        <div class="input-group custom-radio mb-20">
                            {{ Form::radio('radio', null, 1, ['class' => 'radio_field', 'id' => 'model']) }}
                            {{ Form::label('model', 'Model', ['class' => 'd-inline-block radio-label col-sm-6']) }}
                            {{ Form::radio('radio', null, 0, ['class' => 'radio_field', 'id' => 'partner']) }}
                            {{ Form::label('partner', 'Partner', ['class' => 'd-inline-block radio-label col-sm-6']) }}
                        </div>
                    </div>
                    <div class="input-group custom-checkbox mb-40">
                        {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                        {{ Form::label('option_1', 'I have read and agree to the Terms of Use and Privacy Policy.', ['class' => 'checkbox-label mb-0']) }}
                    </div>
                    <div class="text-center"><a href="#" class="d-inline-block btn btn-success register mb-40">Register</a></div>
                    <div class="text-center"><span>Already have an account? <a href="{{ route('login') }}" class="d-inline-block bold bb-black lh-15">Login</a></span></div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection