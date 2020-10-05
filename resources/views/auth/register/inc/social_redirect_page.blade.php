@extends('layouts.logged_in.out_of_app')


@section('content')

    @include('childs.register_title')
    <div class="container px-0 pt-20 w-xl-1220 mx-auto">
        @if (Session::has('flash_notification'))
            <div class="">
                <div class="">
                    <div class="pt-20">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        @endif
        <div class="">
            <div class="">
                <div class="pt-20">
                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        p.help-block { color: red; }
    </style>
    <div class="d-flex align-items-center container px-0 mw-970 pt-20">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 mw-970 py-20 px-30">
                    <form method="POST" id="submit-register" action="{{ lurl(trans('routes.register')) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">
                    
                    @if( isset($user->email) && !empty($user->email) )
                    <!-- email -->
                    <div class="input-group pb-20 mb-20 pt-60  {{ $errors->has('email') ? 'has-error' : ''}} ">
                        {{ Form::label(t('Email'), t('Email'), ['class' => 'position-relative control-label required input-label']) }}
                        {{ Form::email('email', old('email', $user->email), ['class' => 'animlabel', 'placeholder' => '', 'disabled' => 'disabled']) }}
                        <p class="help-block err-input" id='email'></p>
                    </div>
                    @else
                        <div class="input-group pb-20 mb-20 pt-60  {{ $errors->has('email') ? 'has-error' : ''}} ">
                            {{ Form::label(t('Email'), t('Email'), ['class' => 'position-relative control-label required input-label']) }}
                            {{ Form::email('email', old('email', $user->email), ['class' => 'animlabel', 'placeholder' => '']) }}
                            <p class="help-block err-input" id='email'></p>
                        </div>
                    @endif
                    <!-- gender -->
                    <div class="col-md-6 px-0 " id="user-type-div">

                        <?php   
                            if(old('user_type_id') !== null) { 
                                $user_types_id = old('user_type_id'); 
                            } 
                            else {
                                $user_types_id = isset($user->user_type_id) ? $user->user_type_id : '';
                            }

                            if($user_types_id == ""){
                                $user_types_id = config('constant.model_type_id');
                            }
                        ?>
                        
                        {{ Form::label(t('You are a'), t('You are a') , ['class' => 'control-label required input-label position-relative']) }}
                        <div class="input-group custom-radio mb-20 {{ $errors->has('user_type_id') ? 'has-error' : ''}} " style="padding-top : 10px;">

                            @if (isset($userTypes) && count($userTypes) > 0 )
                                @foreach ($userTypes as $type)
                                    @if ($type->id == config('constant.partner_type_id') || $type->id == config('constant.model_type_id'))
                                        <input name="user_type" type="radio" id="radio-{{ $type->id }}" class="radio_field" value="{{$type->id}}" @if($type->id == $user_types_id) checked='checked'  @endif>
                                        <label for="radio-{{$type->id}}" class="d-inline-block radio-label col-sm-6">{{ t($type->name) }}</label>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                        <p class="help-block err-input" id='user_type'></p>
                    </div>

                    <div id="partner_fields" style="display: none;">
                        <!-- company name -->
                        <div class="input-group pb-20 mb-20 {{ $errors->has('email') ? 'has-error' : ''}} ">
                            <label class="position-relative control-label required input-label">{{ t('Company Name') }}</label>
                            <input type="text" name="company_name" placeholder="" class="animlabel">
                            <p class="help-block err-input" id='company_name'></p>
                        </div>

                        <div class="input-group pb-20 mb-20 {{ $errors->has('email') ? 'has-error' : ''}} ">
                            <label class="position-relative control-label required input-label">{{ t('Website') }}</label>
                            <input type="text" name="website" placeholder="" class="animlabel">
                            <p class="help-block err-input" id='website'></p>
                        </div>
                    </div>

                    <div class="text-center"><button type="submit" class="d-inline-block btn btn-success register mb-40" id="social-form">{{ t('Save') }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')

<script>
    var userType_selected = $("input[type='radio'][name='user_type']:checked").val();
    var partnerId = "<?php echo config('constant.partner_type_id'); ?>";
    
    if(userType_selected != "" && userType_selected != undefined && userType_selected != null){
        if( userType_selected == partnerId ){
            $('#partner_fields').show();
        }
    }

    $('input[type=radio][name=user_type]').change(function() {
        
        var userType_selected = $("input[type='radio'][name='user_type']:checked").val();
        var partnerId = "<?php echo config('constant.partner_type_id'); ?>";

        if(userType_selected != "" && userType_selected != undefined && userType_selected != null){
            if( userType_selected == partnerId ){
                $('#partner_fields').show();
            }else{
                $('#partner_fields').hide();
            }
        }
    });

    $('#social-form').on('click', function(e){
        e.preventDefault();
       
        var getUrl = window.location.origin;
        
        var formData = {
            user_id : $("input[name='user_id']").val(),
            _token : $("input[name='_token']").val(),
            user_type : $("input[name='user_type']:checked").val(),
            company_name : $("input[name='company_name']").val(),
            website : $("input[name='website']").val(),
            email : $("input[name='email']").val(),
        };

        $.ajax({
            method: "post",
            url: $("#submit-register").attr('action'),
            dataType: 'json',
            data:formData,
            beforeSend: function(){
                $(".loading-process").show();
                clearMessage();
            },
            complete: function(){
                $(".loading-process").hide();
            },
            success: function (data) {
                
            if( data != undefined && data.success == false ){
                $(".err-input").html('');
                $("p").removeClass('help-block');
                $('#error-recaptcha-msg').html('');
                $('#error-terms').html('');
                
                $.each( data.errors, function( key, value ) {
                    $('#'+key).addClass('help-block');
                    $('#'+key).html(value[0]);
                });

            }else{
                if(data.success){
                    $("div").removeClass('invalid-input');
                    // $(".alert-success").html(data.message);
                    // $('#social-form').prop("disabled", true);

                    if(data.redirectUrl != undefined && data.redirectUrl != "" && data.redirectUrl != null){
                        // setTimeout(function(){
                            $(".print-success-msg").css('display','none');
                            window.location.replace(data.redirectUrl);
                        // }, 1000);
                    }
                }
            }

                console.log(data);
            }, error: function (a, b, c) {
                console.log('error');
            }
        });

        function clearMessage(){
            $(".print-success-msg").html('');
            $(".print-success-msg").css('display','none');
            $("p").removeClass('help-block');
            $(".err-input").html('');
            $('#error-recaptcha-msg').html('');
            $('#error-terms').html('');
        }
        
    });

</script>

@endsection