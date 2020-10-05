@extends('layouts.logged_in.app-model')

@section('content')

    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords(t('My account')) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>

        <?php

            // Start Code Available Contact
            $time_format = 12;
            
            if(isset($user->country->time_format)){
                
                if($user->country->time_format == '24 Hours'){
                    $time_format = 24;
                }
            }

            $start_time = config('app.available_contact_start_time');
            $end_time = config('app.available_contact_end_time');

            $availableTimeArr = array();
            $select_first_from = '';
            $select_first_to = '';
            
            // check old value set or not
            if(isset($user->profile->availability_time) && !empty($user->profile->availability_time)){

                $availableTimeArr = json_decode($user->profile->availability_time);

                if(isset($availableTimeArr[0]->from_time) && !empty($availableTimeArr[0]->from_time)){

                    $select_first_from = $availableTimeArr[0]->from_time;
                }

                if(isset($availableTimeArr[0]->to_time) && !empty($availableTimeArr[0]->to_time)){

                    $select_first_to = $availableTimeArr[0]->to_time;
                }
            }
            // $availableTimeArr = array();

            // $d_none2 = 'd-none';
            // $d_none3 = 'd-none';

            // $select_first_from = '';
            // $select_second_from = '';
            // $select_third_from = '';
            // $select_first_to = '';
            // $select_second_to = '';
            // $select_third_to = '';

            // check old value set or not
            // if(isset($user->profile->availability_time) && !empty($user->profile->availability_time)){

            //     $availableTimeArr = json_decode($user->profile->availability_time);
                
            //     if(isset($availableTimeArr[0]->from_time) && !empty($availableTimeArr[0]->from_time)){

            //         $select_first_from = $availableTimeArr[0]->from_time;
            //     }
            //     if(isset($availableTimeArr[1]->from_time) && !empty($availableTimeArr[1]->from_time)){

            //         $select_second_from = $availableTimeArr[1]->from_time;
            //         $d_none2 = '';
            //     }
            //     if(isset($availableTimeArr[2]->from_time) && !empty($availableTimeArr[2]->from_time)){

            //         $select_third_from = $availableTimeArr[2]->from_time;
            //         $d_none3 = '';
            //     }

            //     if(isset($availableTimeArr[0]->to_time) && !empty($availableTimeArr[0]->to_time)){

            //         $select_first_to = $availableTimeArr[0]->to_time;
            //     }
            //     if(isset($availableTimeArr[1]->to_time) && !empty($availableTimeArr[1]->to_time)){

            //         $select_second_to = $availableTimeArr[1]->to_time;
            //     }
            //     if(isset($availableTimeArr[2]->to_time) && !empty($availableTimeArr[2]->to_time)){

            //         $select_third_to = $availableTimeArr[2]->to_time;
            //     }
            // }
            // End Code Available Contact 
            
            $attr = ['countryCode' => config('country.icode')];
            $tabs = array();
            
            $tabs[lurl(trans('routes.my-data', $attr), $attr)] = t('Personal Info');
            $tabs[lurl(trans('routes.work-settings', $attr), $attr)] = t('Work Settings');

            $disabled = 'disabled';

        ?>

        @can('update_profile', $user)
           <?php $disabled = ''; ?>
        @endcan

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-block">
                <li><a href="{{ lurl(trans('routes.my-data', $attr), $attr) }}" class="active" data-id="1">{{ t('Personal Info') }}</a></li>
                <li><a href="{{ lurl(trans('routes.work-settings', $attr), $attr) }}" class="" data-id="2">{{ t('Work Settings') }}</a></li>
            </ul>
        </div>

        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">

            {{ Form::open(array('url' => lurl('account/update'), 'method' =>'post','id'=>'my-data-form', 'autocomplete' => 'off')) }}
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="is_place" value="{{ old('is_place', '1') }}" id="is_place_select">
                <?php /*
                <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state"> */ ?>
                <div class="w-lg-750 w-xl-970 mx-auto">
                    <div class="px-38 px-lg-0">
                        <div class="pb-40 mb-40 bb-light-lavender3">
                            
                            <h2 class="bold f-18 lh-18">{{t('Profile Data')}}</h2>
                            <div class="divider"></div>

                            <div class="input-group" id="go_code-jq-err">

                                {{ Form::label('go_code', t('go-code'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('go_code',  $user->profile->go_code , ['class' => 'noanimlabel' ,'readOnly' => 'readonly','id' => 'go_code']) }}
                                <p class="help-block user-error-msg"></p>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>

                            <div class="input-group" id="username-jq-err">

                                {{ Form::label('username', t('Username'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('username',  $user->username , ['class' => 'noanimlabel' ,'readOnly' => 'readonly','id' => 'username']) }}
                                 <p class="help-block user-error-msg"></p>
                                 <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <div class="input-group" id="first_name-jq-err">

                                {{ Form::label('first_name', t('First Name'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('first_name',  old('first_name', (!empty($user->profile->first_name))? $user->profile->first_name:'' ),['class' => (!empty(old('first_name', $user->profile->first_name)))? 'noanimlabel': 'animlabel' ,'id' => 'first_name','required']) }}
                                 <p class="help-block user-error-msg"></p>
                                 <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <div class="input-group" id="last_name-jq-err">

                                {{ Form::label('last_name', t('Last name'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('last_name',  old('last_name', (!empty($user->profile->last_name))? $user->profile->last_name:'' ),['class' => (!empty(old('last_name', $user->profile->last_name)))? 'noanimlabel': 'animlabel','id' => 'last_name','required']) }}
                                 <p class="help-block user-error-msg"></p>
                                 <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>

                            <div class="row input-group">
                                <div class="col-md-6">
                                    {{ Form::label('geburtstag' , t('Birthday'), ['class' => 'control-label input-label position-relative required']) }}
                                    
                                    {{ Form::text('geburtstag', old('geburtstag',(!empty($birth_day))? $birth_day :'' ),['class' =>(!empty(old('geburtstag', $user->profile->birth_day)))? 'noanimlabel': 'animlabel','id' => 'birth_day','required','readonly' => true]) }}
                                    <p class="help-block birthdate-error-msg"></p>
                                    <input type="hidden" name="age" value="" id="user_age">
                                </div>
                                <div class="col-md-6">
                                    
                                    <input type="hidden" name="timezone_name" id='timezone_name' value=""> 


                                    <?php   
                                        if(old('timezone') !== null) { 
                                            $timezone_option = old('timezone'); 
                                        } 
                                        else {
                                            $timezone_option = isset($user->profile->timezone) ? $user->profile->timezone : '';
                                        }
                                    ?> 
                                    <?php /*
                                    <input type="hidden" name="selected_timezone" value="{{ $user->profile->timezone }}" class="selected_timezone">
                                    */ ?>

                                    {{ Form::label(t('Time Zone'), t('Time Zone'), ['class' => 'control-label  input-label required position-relative']) }}

                                    {{ Form::select('timezone', $timezone, $timezone_option, ['class' => 'form-control custom_select timezone_list']) }}
                                </div>
                            </div>

                            <div class="row input-group" >
                                <div class="col-md-6" id="phone-code-row">
                                    {{ Form::label(t('Phone Code'), t('Phone Code'), ['class' => 'position-relative input-label required']) }}
                                    
                                    <?php   
                                        if(old('phone_code') !== null) { 
                                            $phone_code_option = old('phone_code'); 
                                        } 
                                        else {
                                            $phone_code_option = isset($user->phone_code) ? $user->phone_code : '';
                                        }
                                        $phoneIcon = "";
                                    ?>

                                    <select id="phone_code" name="phone_code" class="form-control form-select2 phone-code-auto-search" {{ $disabled }}  required>
                                        @foreach ($countries as $item)
                                            @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                                <?php
                                                $phoneIcon = url('images/flags/16/' . strtolower($item->get('code')) . '.png');
                                                ?>
                                            @endif

                                            <option data-image="{{ $phoneIcon }}" value="{{ $item->get('phone') }}" {{ $phone_code_option == $item->get('phone') ? 'selected="selected"' : '' }}>
                                                {{ $item->get('name')." ".$item->get('phone') }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                <div class="col-md-6" id="phone-jq-err">
                                    {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative input-label required']) }}
                                    
                                    {{ Form::text('phone', phoneFormat(old('phone',(!empty($user->phone))? $user->phone:'' )),['class' => (!empty(old('phone', $user->phone)))? 'noanimlabel': 'animlabel','id'=>'phone', 'placeholder' => t('Phone'), 'required', 'autocomplete' => 'phone-add', 'minlength' => 5, 'maxlength' => 20, 'onkeypress '=> "return isNumber(event)"]) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                            </div>
                            <div class="row input-group">
                                <div class="col-md-6" id="country-jq-err">
                                    
                                    {{ Form::label(t('Select a country'), t('Select a country'), ['class' => 'control-label input-label required position-relative']) }} 
                                    
                                    <?php

                                        if( old('country') !== null) { 
                                            $country_option = old('country'); 
                                        } 
                                        else {
                                            
                                            $country_option = isset($user->country_code) ? $user->country_code : '';
                                        }
                                    ?>
                                    
                                    
                                    <select id="countryid" name="country" class="form-control form-select2 country-auto-search" required="required" {{ $disabled }}>
                                        @foreach ($countries as $item)
                                         @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                                <?php
                                                $phoneIcon = url('images/flags/16/' . strtolower($item->get('code')) . '.png');
                                                ?>
                                            @endif
                                            <option data-image="{{ $phoneIcon }}" value="{{ $item->get('code') }}" {{ $country_option == $item->get('code') ? 'selected="selected"' : '' }} >{{ $item->get('name') }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                    <input type="hidden" name="country_name" id='country_name'>
                                    <p class="help-block country-error-msg"></p>
                                </div>
                                <div class="col-md-6" id="city-jq-err">
                                    {{ Form::label(t('City'), t('City'), ['class' => 'control-label  input-label required position-relative']) }}

                                    {{ Form::text('city', old('city',(!empty($user->profile->city))?$user->profile->city :'' ),['class' => (!empty(old('city', $user->profile->city)))? 'noanimlabel': 'animlabel','id'=>'pac-input','required']) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                    <p class="help-block city-error-msg"></p>
                                </div>
                            </div>
                            <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state">
                            <?php $languagesArr = config('languages'); ?>
                            <!-- Start preferred_language -->
                            <div class="input-group {{ $errors->has('preferred_language') ? 'has-error' : ''}}">
                                <?php   
                                    if(old('preferred_language') !== null) { 
                                        $language_option = old('preferred_language'); 
                                    } 
                                    else {
                                        $language_option = isset($user->profile->preferred_language) ? $user->profile->preferred_language : '';
                                    }
                                ?>
                                {{ Form::label(t('Select a Preferred Language'), t('Select a Preferred Language'), ['class' => 'control-label required  input-label position-relative']) }}
                                <select name="preferred_language" id="preferred_language" class="form-control form-select2 validate">
                                    <option class="not-option" value="">{{ t('Select a Preferred Language') }}</option>
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @if(isset($languagesArr[$properties['abbr']]) && $localeCode != 'uk')
                                            <option value="{{ $properties['abbr'] }}" <?php echo ($language_option == $properties['abbr'] ? "selected":"") ?>>{{ trans('language.'.$languagesArr[$properties['abbr']])  }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <!-- End preferred_language -->

                            <div class="input-group" id="street-jq-err">
                                
                                {{ Form::label('street', t('Street'), ['class' => 'position-relative required control-label input-label']) }}
                                
                                {{ Form::text('street', old('street',(!empty($user->profile->street))?$user->profile->street :'' ),['class' => (!empty(old('street', $user->profile->street)))? 'noanimlabel': 'animlabel','id'=>'street','required', 'autocomplete' => 'street-add']) }}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <div class="input-group" id="zip-jq-err">

                                {{ Form::label('postcode',  t('postcode') , ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('zip', old('zip',(!empty($user->profile->zip))? $user->profile->zip:''),['class' => (!empty(old('postcode', $user->profile->zip)))? 'noanimlabel': 'animlabel','id'=>'postcode','required', 'autocomplete' => 'zip-add']) }}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            
                            <div class="row input-group" id="parent-fields">
                                <div class="col-md-6" id="fname_parent-jq-err">
                                    {{ Form::label(t('fname_parent') , t('fname_parent'), ['class' => 'control-label input-label position-relative required']) }}

                                    {{ Form::text('fname_parent', old('fname_parent',(!empty($user->profile->fname_parent))? $user->profile->fname_parent:'' ),['class' =>(!empty(old('fname_parent', $user->profile->fname_parent)))? 'noanimlabel': 'animlabel','id' => 'fname_parent']) }}

                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                    <p class="help-block fname_parent-error-msg"></p>
                                </div>
                                <div class="col-md-6" id="lname_parent-jq-err">
                                           
                                   {{ Form::label(t('lname_parent') , t('lname_parent'), ['class' => 'control-label input-label position-relative required']) }}

                                    {{ Form::text('lname_parent', old('lname_parent',(!empty($user->profile->lname_parent))? $user->profile->lname_parent:'' ),['class' =>(!empty(old('lname_parent', $user->profile->lname_parent)))? 'noanimlabel': 'animlabel','id' => 'lname_parent']) }}

                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                    <p class="help-block lname_parent-error-msg"></p>
                                </div>
                            </div>

                            <!-- Start Available times to contact you Section -->
                            <div class="timeformat-div">
                                <h2 class="bold f-18 lh-18">{{ t('Available times to contact you') }}</h2>
                                <div class="divider"></div>
                                <!-- Start Available Time Section 1 -->
                                <div class="row timeformat_section pt-15" id="timeformat_section1">
                                    <div class="col-md-6">
                                        {{ Form::label('from',  t('From') , ['class' => 'position-relative required control-label input-label']) }}
                                        <select name="from[]" class="form-control form-select2" id="tf1-select-from" required>
                                            <option value="">{{ t('From') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) {

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>
                                                    <option value="<?=$value?>" {{ ($select_first_from == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>

                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        {{ Form::label('to',  t('To') , ['class' => 'position-relative required control-label input-label']) }}
                                        <select name="to[]" class="form-control form-select2" id="tf1-select-to" required>
                                            <option value="">{{ t('To') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) { 

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>

                                                    <option value="<?=$value?>" {{ ($select_first_to == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>
                                                        
                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- error message div section1-->
                                <div class="row error_timeformat_section1" style="display: none;">
                                    <div class="col-md-12">
                                        <p class="help-block mb-0">{{ t('To time must be greater than From time') }}</p>
                                    </div>
                                </div>
                                <!-- End Available Time Section 1 -->
                                <?php /*
                                <!-- Start Available Time Section 2 -->
                                <div class="row timeformat_section {{ $d_none2 }} tf2 pt-15" id="timeformat_section2">
                                    <div class="col-md-6 col-5">
                                        {{ Form::label('from2',  t('From') , ['class' => 'position-relative control-label input-label']) }}
                                        <select name="from[]" class="form-control form-select2" id="tf2-select-from">
                                            <option value="">{{ t('From') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) {

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>
                                                    <option value="<?=$value?>" {{ ($select_second_from == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>
                                                        
                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-5">
                                         {{ Form::label('to2',  t('To') , ['class' => 'position-relative control-label input-label']) }}
                                        <select name="to[]" class="form-control form-select2" id="tf2-select-to">
                                            <option value="">{{ t('To') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) { 

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>
                                                    <option value="<?=$value?>" {{ ($select_second_to == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>
                                                        
                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                    <a class="hide-time-div" id="tf2" title="{{ t('Delete') }}" data-id='timeformat_section2' data-error-id="error_timeformat_section2"><img src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-c-del.png') }}"></a>
                                </div>
                                <!-- Error message div section2 -->
                                <div class="row error_timeformat_section2" style="display: none;">
                                    <div class="col-md-12">
                                        <p class="help-block mb-0">{{ t('To time must be greater than From time') }}</p>
                                    </div>
                                </div>
                                <!-- End Available Time Section 2 -->

                                <!-- Start Available Time Section 3 -->
                                <div class="row timeformat_section {{ $d_none3 }} tf3 pt-15" id="timeformat_section3">
                                    <div class="col-md-6 col-5">
                                        {{ Form::label('from3',  t('From') , ['class' => 'position-relative control-label input-label']) }}
                                        <select name="from[]" class="form-control form-select2 tf3-select" id="tf3-select-from">
                                            <option value="">{{ t('From') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) {

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>
                                                    <option value="<?=$value?>" {{ ($select_third_from == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>
                                                        
                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-5">
                                        {{ Form::label('to3',  t('To') , ['class' => 'position-relative control-label input-label']) }}
                                        <select name="to[]" class="form-control form-select2 tf3-select" id="tf3-select-to">
                                            <option value="">{{ t('To') }}</option>
                                            <?php

                                                for ($i = $start_time; $i <= $end_time; $i++) { 

                                                    $time = $i;
                                                    
                                                    if(strlen(trim($i)) == 1){
                                                        
                                                        $time = '0'.$i;
                                                    }

                                                    $value = $time.':00';
                                                ?>
                                                    <option value="<?=$value?>" {{ ($select_third_to == $value)? 'selected' : '' }}>{{ ($time_format == 12) ? date("h a", strtotime($value)) : $value }}</option>
                                                        
                                                    <?php 
                                                } ?>
                                            ?>
                                        </select>
                                    </div>
                                    <a class="hide-time-div" title="{{ t('Delete') }}" id="tf3" data-id='timeformat_section3' data-error-id="error_timeformat_section3"><img src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-c-del.png') }}"></a>
                                </div>
                                <!-- Error message div section3 -->
                                <div class="row error_timeformat_section3" style="display: none;">
                                    <div class="col-md-12">
                                        <p class="help-block mb-0">{{ t('To time must be greater than From time') }}</p>
                                    </div>
                                </div>
                                <!-- End Available Time Section 3 -->

                                <!-- Start Add More Button -->
                                <div class="text-center mb-20 pt-20">
                                    <a class="append-time-div btn add-more" title="{{ t('Add more') }}">{{ t('Add more') }}</a>
                                </div>
                                <!-- End Add More Button -->
                                */ ?>
                            </div>
                        </div>

                        @include('childs.bottom-bar-save')
                    </div>
                </div>



            <?php /*

            <div class="col-lg-12">
                <div class="error-message mb-30 d-none"></div>
                <div class="success-message mb-30 d-none"></div>
            </div>

            {{ Form::open(array('url' => lurl('account/update'), 'method' =>'post','id'=>'my-data-form')) }}
            <input name="_method" type="hidden" value="PUT">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="px-38 px-lg-0">
                    <div class="pb-40 mb-40 bb-light-lavender3 text-center">
                        <span>{{ t('Your go-code') }}:</span>
                        <span class="bold">{{$user->profile->go_code }}</span>
                    </div>
                    <div class="pb-20 mb-20">
                        <h2 class="bold f-18 lh-18">{{t('profile data')}}</h2>
                        <div class="divider"></div>
                        <div class="input-group">
                            {{ Form::text('first_name',old('first_name', (!empty($user->profile->first_name))? $user->profile->first_name:'' ),['class' => (!empty(old('first_name',$user->profile->first_name)))? 'noanimlabel': 'animlabel','id'=>'first_name','required']) }}
                            {{ Form::label('first_name', t('First name') , ['class' => 'required']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::text('last_name',old('last_name', (!empty($user->profile->last_name))? $user->profile->last_name:'' ),['class' => (!empty(old('last_name',$user->profile->last_name)))? 'noanimlabel': 'animlabel','id'=>'last_name','required']) }}
                            {{ Form::label('last_name', t('Last name') , ['class' => 'required']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::email('email', old('email', (!empty($user->email))? $user->email:'' ),['class' => (!empty(old('email', $user->email)))? 'noanimlabel': 'animlabel','id'=>'email', 'required']) }}
                            {{ Form::label('email', t('email'), ['class' => 'required']) }}
                        </div>
                        <div class="row">
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone_code') ? 'has-error' : ''}}">
                                {{ Form::label(t('Select a phone code'), t('Select a phone code'), ['class' => 'control-label required  input-label position-relative']) }}
                                <?php

                                // get old phone code value   
                                    if(old('phone_code') !== null) { 
                                        $phone_code_option = old('phone_code'); 
                                    } 
                                    else {
                                        $phone_code_option = isset($user->phone_code) ? $user->phone_code : '0';
                                    }
                                    $phoneIcon = "";
                                    ?>

                                <select id="phone_code" name="phone_code" class="form-control form-select2 phone-code-auto-search" required>
                                        @foreach ($countries as $item)
                                            @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                                <?php
                                                $phoneIcon = url('images/flags/16/' . strtolower($item->get('code')) . '.png');
                                                ?>

                                            @endif
                                            <option data-image="{{ $phoneIcon }}" value="{{ $item->get('phone') }}" @if($phone_code_option == $item->get('phone'))  selected="selected"  @endif >{{ $item->get('name')." ".$item->get('phone') }}</option>
                                        @endforeach
                                </select>
                                 {!! $errors->first('phone_code', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone') ? 'has-error' : ''}}">
                                {{ Form::label('phone', t('phone'), ['class' => 'control-label required  input-label position-relative']) }}
                                {{ Form::text('phone', phoneFormat(old('phone',(!empty($user->phone))? $user->phone:'' )),['class' => (!empty(old('phone', $user->phone)))? 'noanimlabel': 'animlabel','id'=>'phone','required', 'maxlength' => '10', 'minlength' => '10', 'onkeypress '=> "return isNumber(event)"]) }}
                                {{-- Form::label('phone', t('phone'), ['class' => 'required']) --}}
                            </div>
                        </div>
                        <div class="input-group">
                            {{ Form::text('address_1', old('address_1',(!empty($user->profile->street))?$user->profile->street :'' ),['class' => (!empty(old('address_1', $user->profile->street)))? 'noanimlabel': 'animlabel','id'=>'address_1','required']) }}
                            {{ Form::label('address_1', t('Address'), ['class' => 'required']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::text('postcode', old('zip',(!empty($user->profile->zip))? $user->profile->zip:''),['class' => (!empty(old('postcode', $user->profile->zip)))? 'noanimlabel': 'animlabel','id'=>'postcode','required']) }}
                            {{ Form::label('postcode',  t('postcode') , ['class' => 'required']) }}
                        </div>
                        
                        <div class="row">
                                <div class="input-group col-md-6 col-sm-12 {{ $errors->has('country') ? 'has-error' : ''}}">
                                    {{ Form::label(t('Select a country'), t('Select a country'), ['class' => 'control-label required  input-label position-relative']) }}

                                    <?php

                                        // get old country value   
                                        if(old('country') !== null) { 
                                            $country_option = old('country'); 
                                        } 
                                        else {
                                            $country_option = isset($user->country_code) ? $user->country_code : '0';
                                        }
                                        ?>

                                    <select id="country" name="country" class="form-control form-select2 country-auto-search" required>
                                        <option value="" {{ (!old('country') or old('country')==0 or $country_option == 0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                                            @foreach ($countries as $item)
                                                <option value="{{ $item->get('code') }}" @if($country_option == $item->get('code'))  selected="selected"  @endif >{{ $item->get('name') }}</option>
                                            @endforeach
                                    </select>
                                      <input type="hidden" name="country_name" id='country_name'>
                                     {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="input-group col-md-6 col-sm-12 {{ $errors->has('city') ? 'has-error' : ''}} ">
                                    {{ Form::label(t('City'), t('City'), ['class' => 'control-label  input-label required position-relative']) }}
                                    {{ Form::text('city', old('city',(!empty($user->profile->city))? $user->profile->city:''),['class' => (!empty(old('city', $user->profile->city)))? 'noanimlabel': 'animlabel','id'=>'city','required']) }}
                                    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                                </div>
                        </div>
                    </div>
                    @include('childs.bottom-bar-save')
                </div>
            </div>
            <?php */ ?>

            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('page-script')
<style type="text/css">
    .dropdown-menu {
    margin: 3.125rem 0 0 !important;
}
</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">

<link rel="stylesheet" href="{{ url(config('app.cloud_url').'/assets/plugins/font-awesome/css/font-awesome.min.css') }}">

<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

@if(Lang::locale()=='de')
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker-de.min.js') }}" type="text/javascript"></script>
@else
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
@endif

<!-- Place Auto Complete start -->
{{ Html::script(config('app.cloud_url').'/assets/js/place-autocomplete.js') }}
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlemaps.key')}}&libraries=places"></script>
<!-- Place Auto Complete End -->

<script type="text/javascript">

    // Start Google AutoComplate Place cities
    var autocomplete;
    var input = document.getElementById('pac-input');
    var options = { types: ['(cities)'] };
    autocomplete = new google.maps.places.Autocomplete(input, options);

    var code = $("#countryid option:selected").val();

    if(code){
       initMapRegister();
    }

    $(document).ready(function(){

        // getTimeZone();
        
        if($('#pac-input').val() == ''){

            $('#is_place_select').val('');
        }

        if($('#is_place_select').val()){

            $('#pac-input').removeClass('border-bottom-error');
        }

        // Diff between birthdate and current date grater than 18 year than show gardian form
        selected_date = $('#birth_day').val();
        if(selected_date != "" && selected_date != undefined && selected_date != null){
            showparent(selected_date);
        }

        $("#birth_day").datepicker({
            format: "mm/dd/yyyy",
            /*todayHighlight: true,*/
            autoclose: true,
            /*clearBtn: true,*/
            endDate:new Date(),
        }).change(dateChanged).on('changeDate', dateChanged);

        function dateChanged(ev) {
            selected_date = $('#birth_day').val();
            var show_parent = true;

            if(selected_date != "" && selected_date != undefined && selected_date != null){
                showparent(selected_date);
            }
        }


        function showparent(selected_date){
    
            var SelectDateArr = selected_date.split('/');
            
            var DOB = new Date(selected_date);
            var today = new Date();

            var age = today.getTime() - DOB.getTime();
            age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));

            $('#user_age').val(age);

            if (age < 18) {
                $('#parent-fields').show();
                $('#fname_parent').prop('required', true);
                $('#lname_parent').prop('required' , true);
            } else {
                $("#parent-fields").hide();
                
                $('#fname_parent').prop('required', false);
                $('#lname_parent').prop('required' , false);

                $('#fname_parent').val('');
                $('#lname_parent').val('');
            }
        }
        
        // commented city code
        // var code = $("#country option:selected").val();
        // getCityByCountryCode(code);
        var countryname = $("#countryid option:selected").text();
        $('#country_name').val(countryname);

        $('#countryid').bind('change', function(e){
            $('#pac-input').removeClass('border-bottom-error');
           // var code = $("#country option:selected").val();
            var countryname = $("#countryid option:selected").text();
            $('#country_name').val(countryname);
            // getCityByCountryCode(code);
            $('#pac-input').val('');
            $('#street').val('');
            $('#geo_state').val('');
            $('#postcode').val('');
            initMapRegister();
            // getTimeZone();
        });

        $('#pac-input').bind('change keyup', function(e){
            $('#street').val('');
            $('#geo_state').val('');
            $('#postcode').val('');
            $('#pac-input').addClass('border-bottom-error');
            $('#is_place_select').val('');
            
            if( $('#pac-input').val() == ""){
                $('#pac-input').removeClass('border-bottom-error');
            }
        });

        $("#email").attr('disabled','disabled');

        $('#my-data-form').submit(function(event) {

            $('#pac-input').removeClass('border-bottom-error');
            
            // if cities empty, form submit true
            if($('#pac-input').val() == "" || $('#is_place_select').val() != 1){
                
                $('#pac-input').addClass('border-bottom-error');

                $('html, body').animate({
                    scrollTop: $("#phone-code-row").offset().top
                }, 1000, function() {
                    $("#my-data-form [name='city']").focus();
                });
                return false;
            }

            return true;
        });
    });

    $(document).ready(function(){
        $('#submit-btn').on('click', function(e){
            
            var requiredMsg = '{{ t("required_field") }}';
            $('.error-text-safari').css('display','none');

            e.preventDefault();

            var is_validation_true = true;

            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';

            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

            $('input,textarea,select,radio').filter('[required]:visible').each(function(i, requiredField){
                
                document.getElementsByName($(requiredField).attr('name'))[0].setCustomValidity('');

                if($(requiredField).val() == '' || $(requiredField).val() == null)
                {
                    
                    var element = document.getElementsByName($(requiredField).attr('name'))[0];

                    element.oninvalid = function(e) {
                        e.target.setCustomValidity("");
                        if (!e.target.validity.valid) {
                            e.target.setCustomValidity(requiredMsg);
                        }
                    };

                    document.getElementsByName($(requiredField).attr('name'))[0].reportValidity();

                    $('html, body').animate({
                        scrollTop: ($(requiredField).offset().top - 100)
                    }, 500, function() {
                        // $(requiredField).focus();
                    });

                   

                    if(isFirefox || isSafari){
                        
                        if($(requiredField).attr('name') === "phone_code"){
                            $('#phone-code-row').find('.error-text-safari').css('display','block');
                        }else{
                            var err_f = $(requiredField).attr('name')+'-jq-err';
                            $('#'+err_f).find('.error-text-safari').css('display','block');
                        }
                    }

                    is_validation_true = false;

                    return false;
                }

            });
        
            if(is_validation_true){
                $('#my-data-form').submit();
            }   
        });
    });
    
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/getTimeZoneByCountryCode-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/added-time-format.js') }}
<!-- disable autocomplete off on google autocomplete -->
<script type="text/javascript">
    window.onload = function() {
        //document.getElementById("pac-input").autocomplete = 'city-add';

        var isFirefox = typeof InstallTrigger !== 'undefined';

        if(isFirefox){
            document.getElementById("pac-input").autocomplete = 'off';
        }else{
            document.getElementById("pac-input").autocomplete = 'city-add';
        }

    }
</script>
@endsection