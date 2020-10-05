@extends('layouts.logged_in.app-model')

@section('content')
<?php
if (!empty($system_settings)) {
	$language = !empty($system_settings['language']) ? $system_settings['language'] : '';
	$message = !empty($system_settings['message']) ? $system_settings['message'] : '';
	$invite = !empty($system_settings['invite']) ? $system_settings['invite'] : '';
	$reminder = !empty($system_settings['reminder']) ? $system_settings['reminder'] : '';
} else {
	$language = '';
	$message = '';
	$invite = '';
	$reminder = '';
}
?>
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{t('system settings')}}</h1>
        <div class="divider mx-auto"></div>
        <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{t('system settings subtitle')}}</p>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            <?php /*
            @include('flash::message')

            @if (isset($errors) and $errors->any())
                <div class="alert alert-danger w-lg-750 w-xl-970 mx-auto">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
                    <ul class="list list-check">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            */ ?>

            <div class="col-lg-12">
                <div class="error-message mb-30 d-none"></div>
                <div class="success-message mb-30 d-none"></div>
            </div>

            <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
            </div>

            {{ Form::open(array('url' => 'system-settings/update','id'=>'system_settings_form', 'method' => 'post')) }}
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="w-md-440 px-38 px-lg-0">
                    <span class="bold f-18 lh-18 mb-10">{{t('system language')}}</span>

                    <div class="form-group mb-30">
                        {{ Form::label('data_select' , t('Select data'), ['class' => 'control-label required select-label position-relative']) }}
                        {{ Form::select('data_select', [0=>t('Select Language'),1 => t('English'), 2 => t('Deutsch'),3=>t('Spanish'),4=>t('French')], $language, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-30">
                        <span class="bold f-18 lh-18 mb-10">{{t('email notifications')}}</span>
                        <p>{{t('email notifications subtitle')}}</p>
                    </div>

                    <div class="mb-30">
                        <span class="bold f-18 lh-18 mb-10">{{t('Messages')}}</span>
                        <div class="col-md-6 form-group custom-radio">
                            {{ Form::radio('message_radio', 1, $message == '1', ['class' => 'radio_field message_radio', 'id' => 'm_instant']) }}
                            {{ Form::label('m_instant', t('instant'), ['class' => 'radio-label']) }}
                            {{ Form::radio('message_radio', 2, $message == '2', ['class' => 'radio_field message_radio', 'id' => 'm_periodically']) }}
                            {{ Form::label('m_periodically', t('periodically'), ['class' => 'radio-label']) }}
                            {{ Form::radio('message_radio', 3, $message == '3', ['class' => 'radio_field message_radio', 'id' => 'm_never']) }}
                            {{ Form::label('m_never', t('never'), ['class' => 'radio-label mb-0']) }}
                        </div>
                    </div>

                    <div class="mb-30">
                        <span class="bold f-18 lh-18 mb-10">{{t('invites')}}</span>
                        <div class="col-md-6 form-group custom-radio">
                            {{ Form::radio('invite_radio', 1, $invite == '1', ['class' => 'radio_field invite_radio', 'id' => 'i_instant']) }}
                            {{ Form::label('i_instant', t('instant'), ['class' => 'radio-label']) }}
                            {{ Form::radio('invite_radio', 2, $invite == '2', ['class' => 'radio_field invite_radio', 'id' => 'i_periodically']) }}
                            {{ Form::label('i_periodically',  t('periodically'), ['class' => 'radio-label']) }}
                            {{ Form::radio('invite_radio', 3, $invite == '3', ['class' => 'radio_field invite_radio', 'id' => 'i_never']) }}
                            {{ Form::label('i_never', t('never'), ['class' => 'radio-label mb-0']) }}
                        </div>
                    </div>

                    <div>
                        <span class="bold f-18 lh-18 mb-10">{{t('reminders')}}</span>
                        <div class="col-md-6 form-group custom-radio">
                            {{ Form::radio('reminder_radio', 1, $reminder == '1', ['class' => 'radio_field reminder_radio', 'id' => 'r_instant']) }}
                            {{ Form::label('r_instant', t('instant'), ['class' => 'radio-label']) }}
                            {{ Form::radio('reminder_radio', 2, $reminder == '2', ['class' => 'radio_field reminder_radio', 'id' => 'r_periodically']) }}
                            {{ Form::label('r_periodically',  t('periodically'), ['class' => 'radio-label']) }}
                            {{ Form::radio('reminder_radio', 3, $reminder == '3', ['class' => 'radio_field reminder_radio', 'id' => 'r_never']) }}
                            {{ Form::label('r_never', t('never'), ['class' => 'radio-label mb-0']) }}
                        </div>
                    </div>
                </div>
                @include('childs.bottom-bar-save')
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('page-script')
<script type="text/javascript">
$(document).ready(function(){
    function validEmail(v) {
    // var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    var r = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
    return (r.test(v)) ? true : false;
}

    $('.save').on('click',function(e){
      e.preventDefault();
      e.stopPropagation();

    var is_message_radio_checked = false;
    var is_invite_radio_checked = false;
    var is_reminder_radio_checked = false;
      $('.message_radio').each(function () {
        if ($(this).is(':checked')) {
            is_message_radio_checked = true;
        }
      });
      $('.invite_radio').each(function () {
        if ($(this).is(':checked')) {
            is_invite_radio_checked = true;
        }
      });
      $('.reminder_radio').each(function () {
        if ($(this).is(':checked')) {
            is_reminder_radio_checked = true;
        }
      });
      if($('#data_select').val() == 0){
        $('.error-message').removeClass('d-none');
        $('.error-message').html('Please select language');
      }else if(is_message_radio_checked == false){
        $('.error-message').removeClass('d-none');
        $('.error-message').html('Please select message settings');
      }else if(is_invite_radio_checked == false){
        $('.error-message').removeClass('d-none');
        $('.error-message').html('Please enter invite settings');
      }else if(is_reminder_radio_checked == false){
        $('.error-message').removeClass('d-none');
        $('.error-message').html('Please enter memories settings');
      }else{
         $.ajax({
          method: "post",
          url: $('#system_settings_form').attr('action'),
          data: new FormData($('#system_settings_form')[0]),
          contentType: false,
          processData: false,
          success: function (data) {
            window.location.reload();
          }, error: function (a, b, c) {
              console.log('error');
          }
      });
      }

    });
});
</script>
@endsection