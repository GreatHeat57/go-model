<style type="text/css">
    .select2-container--default{width: 100% !important;}
    .birthday_picker_div .col-md-12{padding-left: 0px; padding-right: 0px;}
    .birthday_picker_div label{font-size: 13px;}
    .birthday_picker_div .required:after { content:" *"; }
    .birthday_picker_div .col-4{ padding-left: 0px; padding-right: 0px; }

</style>
<div class="white-popup-block" id="mfp-contract-profile"> <!-- mfp-sign-up -->
    <h2 class="smaller">{{ t('Update Profile')}}</h2>
    
    <div class="alert alert-danger print-error-msg" style="display:none"></div>
    <div class="alert alert-success print-success-msg" style="display:none"></div>


    <form method="POST" name="settings" id="user-profile" action="{{ lurl('contract/profileUpdate') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <input type="hidden" name="is_place" value="{{ old('is_place', '1') }}" id="is_place_select">
    <input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">
    <div class="form">
        <div class="row" id='email'>

            <span class="popup_lable">{{ t('Email').' *' }} </span>

            {{ Form::email('email', old('email', $user->email), ['class' => 'disable-input', 'required' => 'required']) }}
        </div>

        <div class="row" >

            <span class="popup_lable">{{ t('First name').' *' }} </span>

            {{ Form::text('first_name', old('first_name', $user->profile->first_name), ['class' => '', 'required' => 'required']) }}

            <p class="help-block err-input" id='first_name'></p>
        </div>

        <div class="row">
            <span class="popup_lable">{{ t('Last name').' *' }} </span>

            {{ Form::text('last_name', old('last_name', $user->profile->last_name), ['class' => '', 'required' => 'required']) }}
            <p class="help-block err-input" id='last_name'></p>
        </div>
        <?php /*
        <div class="row" id="">
            <span class="popup_lable">{{ t('Birthday').' *' }} </span>

            <div class="col-md-12" id="cs_birthday"></div>
            <p class="help-block err-input" id='cs_birthday_birthDay'></p>
        </div>
        */ ?>
        <div class="row birthday_picker_div" id="cs_birthday" data-label="{{ t('Birthday') }}">
        </div>

        <div class="row parent_details" style="display: none;">

            <span class="popup_lable">{{ t('fname_parent').' *' }} </span>

            {{ Form::text('fname_parent', old('fname_parent', $user->profile->fname_parent)) }}
            <p class="help-block err-input" id='fname_parent'></p>
        </div>

        <div class="row parent_details" style="display: none;">

            <span class="popup_lable">{{ t('lname_parent').'*' }} </span>

            {{ Form::text('lname_parent', old('lname_parent', $user->profile->lname_parent)) }}
            <p class="help-block err-input" id='lname_parent'></p>
        </div>
        <div class="row" id="country-row">
            <span class="popup_lable">{{ t('Select a country').' *' }} </span>

            <?php
                // get old country value
                $country_option = isset($user->country_code) ? $user->country_code : 'en';
            ?>

            <select id="countryid" class="form-control form-select2 country-select2 country-id disable-input" required>
                <option value="0" {{ (!old('country') or old('country')==0 or $country_option == 0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                    @foreach ($countries as $item)
                        <option value="{{ $item->get('code') }}" @if($country_option == $item->get('code'))  selected="selected"  @endif >{{ $item->get('name') }}</option>
                    @endforeach
            </select>

            <p class="help-block err-input" id='country'></p>
            <input type="hidden" name="country" value="<?php echo $country_option; ?>">
            <input type="hidden" name="country_name" id='country_name'>
        </div>

        <div class="row" id="city-row">

            <span class="popup_lable">{{ t('City').' *' }}</span>

            {{ Form::text('city', old('city', $user->profile->city), ['class' => '', 'required' => 'required', 'id' => 'pac-input', 'autocomplete' => 'city-add']) }}

            <p class="help-block err-input" id='city'></p>
        </div>
        <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state">

        <div class="row">

            <span class="popup_lable">{{ t('Street').' *' }} </span>

            {{ Form::text('street', old('street', $user->profile->street), ['class' => '', 'required' => 'required', 'id' => 'street-input', 'autocomplete' => 'street-add']) }}

            <p class="help-block err-input" id='street'></p>
        </div>

        <div class="row">
            <span class="popup_lable">{{ t('Zip').' *' }}</span>
             
            {{ Form::text('zip', old('zip', $user->profile->zip), ['class' => '', 'required' => 'required', 'id' => 'zip-input', 'autocomplete' => 'zip-add']) }}
            <p class="help-block err-input" id='zip'></p>
        </div>


        <div class="radio">
            <span class="popup_lable">{{ t('Gender').' *' }}</span>

            @if ($genders->count() > 0)
                @foreach ($genders as $gender)
                    <input name="gender" type="radio" id="gender_{{ $gender->tid }}" class="css-radio" value="{{ $gender->tid }}" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }} required>
                    <label for="gender_{{ $gender->tid }}" class="css-label2">{{ t($gender->name) }}</label>
                @endforeach
            @endif

            <p class="help-block err-input" id='gender'></p>
        </div>

        <input type="hidden" name="user_birthdate" value="{{ $user->profile->birth_day }}">
        <input type="hidden" name="user_type_id" value="{{ $user->user_type_id }}">
       
        <div class="btn mb-10">
            <button class="green next" type="submit" id="contract-form">{{ t('Update') }}</button>
        </div>
        </form>
    </div>
</div>
{{ Html::style(config('app.cloud_url').'/css/formValidator.css') }}

<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>

<link href="{{ url(config('app.cloud_url').'/css/custom_select2.css') }}" rel="stylesheet">

<style type="text/css">
    .select2-container--open{
        z-index: 99999;
    }

    .birthdayPicker { 
        box-shadow: none !important;
    }

    .invalid-input { color: #fa4754; border-bottom: 1px solid #fa4754;}

    .form-select { display: block; width: 100%; height: 36px; outline: none;  resize: none; -webkit-appearance: none; border-radius: 0; border: 0; border-bottom: 1px solid #d0d0d0; font-family: work_sansregular,arial,tahoma; font-size: 16px;padding: 0;margin: 0; }

    .text-decoration-none{
        text-decoration: none !important;
    }

    .white-popup-block p, .white-popup-block h3 {
        text-align: left !important;
        margin-bottom : 0px !important;
        padding : 0px !important;
    }

    p.help-block { color: red; }
</style>


 