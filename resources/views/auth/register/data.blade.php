@extends('layouts.logged_in.out_of_app')
@section('content')
    @include('childs.register_title')
    
    @if (Session::has('flash_notification'))
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-20">
                    @include('flash::message')
                </div>
            </div>
        </div>
    @endif

    @include('auth.register.inc.wizard_new')
    {{ Html::style(config('app.cloud_url').'/css/formValidator.css') }}
    {{ Html::style(config('app.cloud_url').'/css/bladeCss/data-blade.css') }}
    <div class="d-flex align-items-center container px-0 mw-970 pt-20" >
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-970 py-20 px-30">
                    <form name="asd" class="form-horizontal pt-20" role="form" method="POST" action="{{ url()->current() }}" id="reg-data" autocomplete="off">
                    {!! csrf_field() !!}

                    <input type="hidden" name="is_place" value="{{ old('is_place', '1') }}" id="is_place_select">

                    <?php /*
                    <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state"> */ ?>

                    <input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">
                    <input type="hidden" id="gclid_field" name="gclid_field" value="">

                    <input type="hidden" name="user_type" value="<?php echo $user->user_type_id; ?>">

                    @if ($user->user_type_id == 3)

                        <!-- birthday -->
                        <div class="row" id="cs_birthday" data-label="{{ t('Birthday') }}" style="padding-top: 10px;"></div>
                        <!-- <div class="col-md-12 {{ $errors->has('cs_birthday_birthDay') ? 'has-error' : ''}}" id="custom_birthday-jq-err">
                            {{ Form::label('birthday', t('Birthday'), ['class' => 'position-relative control-label required input-label']) }}
                            <div class="custom" id="cs_birthday" style="padding-top: 10px;"></div>
                            {!! $errors->first('cs_birthday_birthDay', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div -->


                        <input type="hidden" name="age" value="" id="user_age">

                        <div class="parent-fields" style="display: none;">
                            <!-- Parent fname -->
                            <div class="input-group {{ $errors->has('fname_parent') ? 'has-error' : ''}} " id="fname_parent-jq-err">
                                {{ Form::label(t('fname_parent'), t('fname_parent'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('fname_parent', old('fname_parent', $user->profile->fname_parent), ['class' => 'animlabel', 'id' => 'fname_parent', 'placeholder' => '', 'autocomplete' => 'pfirst-add' ]) }}

                                <div class="form-input-error-msg {{ $errors->has('fname_parent') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('fname_parent') ? $errors->first('fname_parent', ':message') : t("required_field") }} 
                                </div>

                                <!-- 
                                {!! $errors->first('fname_parent', '<p class="help-block">:message</p>') !!}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>

                            <!-- Parent lname -->
                            <div class="input-group {{ $errors->has('lname_parent') ? 'has-error' : ''}}" id="lname_parent-jq-err">
                                {{ Form::label(t('lname_parent'), t('lname_parent'), ['class' => 'position-relative required control-label input-label']) }}

                                {{ Form::text('lname_parent', old('lname_parent', $user->profile->lname_parent), ['class' => 'animlabel', 'id' => 'lname_parent', 'placeholder' => '', 'autocomplete' => 'plast-add' ]) }}

                                <div class="form-input-error-msg {{ $errors->has('lname_parent') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('lname_parent') ? $errors->first('lname_parent', ':message') : t("required_field") }} 
                                </div>

                                <!-- 
                                {!! $errors->first('lname_parent', '<p class="help-block">:message</p>') !!}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="input-group {{ $errors->has('category') ? 'has-error' : ''}}" id="category-jq-err">
                            <?php   
                                if(old('category') !== null) { 
                                    $category_option = old('category'); 
                                } 
                                else {
                                    $category_option = isset($user->profile->category_id) ? $user->profile->category_id : '';
                                }
                            ?>

                            {{ Form::label(t('Select a category'), t('Select a category'), ['class' => 'control-label required  input-label position-relative']) }}

                            <select name="category" id="category" class="form-control form-select2 validate">
                                <option class="not-option" value="">{{ t('Select a category') }}</option>
                                @foreach ($modelCategories as $cat)
                                    <?php /*
                                    <option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"  
                                        {{ ($user->profile->category_id == $cat->tid) ? 'selected' : '' }}> {{ $cat->name }} </option> */ ?>
                                    <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}" data-slug="{{ $cat->slug }}" {{ ($category_option == $cat->parent_id ? "selected":"") }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-input-error-msg {{ $errors->has('category') ? 'show-error' : ''}}">
                                <span class="fa fa-exclamation-circle"></span>{{ $errors->has('category') ? $errors->first('category', ':message') : t("required_field") }} 
                            </div>

                            <!-- 
                            {!! $errors->first('category', '<p class="help-block">:message</p>') !!} -->
                            <!-- <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                        </div>
                        <?php /*
                            <!-- <div class="input-group custom-checkbox mb-40">
                                <select  name="minAge" id="minAge" class="form-control">
                                    <option value=""> {{ t('age_min') }} </option>
                                    @for($i = 1; $i < 101; $i
                                        <option value="{{ $i }}" {{ (Request::get('minAge')==$i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div> -->
                        */ ?>
                    @endif

                    <!-- Company name and company website added for the partner -->
                    @if ($user->user_type_id == 2)

                    <!-- company_name -->
                    <div class="input-group {{ $errors->has('company_name') ? 'has-error' : ''}} " id="company_name-jq-err">
                        {{ Form::label(t('Company Name'), t('Company Name'), ['class' => 'position-relative required control-label input-label']) }}
                        {{ Form::text('company_name', old('company_name', $company_name), ['class' => 'animlabel validate', 'id' => 'company_name', 'placeholder' => '' ,'', 'autocomplete' => 'company_name-add']) }}
                        <div class="form-input-error-msg {{ $errors->has('company_name') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('company_name') ? $errors->first('company_name', ':message') : t("required_field") }} 
                        </div>
                    </div>

                    <!-- company_name -->
                    <div class="input-group {{ $errors->has('website') ? 'has-error' : ''}} " id="website-jq-err">
                        {{ Form::label(t('Website'), t('Website'), ['class' => 'position-relative required control-label input-label']) }}
                        {{ Form::text('website', old('website', $website), ['class' => 'animlabel validate', 'id' => 'website', 'placeholder' => '' ,'', 'autocomplete' => 'website-add']) }}
                        <div class="form-input-error-msg {{ $errors->has('website') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('website') ? $errors->first('website', ':message') : t("required_field") }} 
                        </div>
                    </div>

                    @endif
                    <!-- Company name and company website added for the partner -->
                   
                    <!-- email -->
                    <div class="input-group {{ $errors->has('email') ? 'has-error' : ''}} " id="email-jq-err">
                        {{ Form::label(t('Email'), t('Email'), ['class' => 'position-relative control-label required input-label']) }}
                        {{ Form::email('email', old('email', $user->email), ['class' => 'animlabel ', 'id' => 'email', 'placeholder' => '' ,'readonly', 'autocomplete' => 'email-add']) }}
                        
                        <div class="form-input-error-msg {{ $errors->has('email') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('email') ? $errors->first('email', ':message') : t("required_field") }} 
                        </div>

                        <!-- {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                    </div>

                    @if ($user->user_type_id == 3)

                    <!-- gender -->
                    <div class="col-md-6 px-0 " id="gender-div">

                        <?php   
                            if(old('gender') !== null) { 
                                $gender_id = old('gender'); 
                            } 
                            else {
                                $gender_id = isset($user->gender_id) ? $user->gender_id : '';
                            }
                        ?>
                        
                        {{ Form::label(t('Gender'), t('Gender') , ['class' => 'control-label required input-label position-relative']) }}
                        <div class="input-group radio-group validate custom-radio {{ $errors->has('gender') ? 'has-error' : ''}} " style="padding-top : 10px;" id="gender-div">

                            @if ($genders->count() > 0)
                                @foreach ($genders as $gender)
                                     <?php 
                                        $checked = '';
                                        if($gender_id == $gender->tid){
                                           $checked = 'checked="checked"';
                                        }
                                     ?>
                                    {{ Form::radio('gender', $gender->tid, $checked , ['class' => 'radio_field gender-radio', 'id' => t($gender->name)]) }}

                                    {{ Form::label(t($gender->name), t($gender->name), ['class' => 'd-inline-block radio-label col-sm-6', 'style' => 'margin-bottom: 5px !important']) }}
                                @endforeach
                            @endif

                            <div class="form-input-error-msg {{ $errors->has('gender') ? 'show-error' : ''}}">
                                <span class="fa fa-exclamation-circle"></span>{{ $errors->has('gender') ? $errors->first('gender', ':message') : t("required_field") }} 
                            </div>

                            <!-- 
                            <p class="help-block gender-error" ></p>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                        </div>
                        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                    </div>

                    @endif

                    @if ($user->user_type_id == 2)
                        <!-- Branch -->
                        <div id="partner_category" class="input-group {{ $errors->has('category') ? 'has-error' : ''}}">

                            <?php   
                                if(old('category') !== null) { 
                                    $category_option = old('category'); 
                                } 
                                else {
                                    $category_option = isset($user->profile->category_id) ? $user->profile->category_id : '';
                                }
                            ?>

                            {{ Form::label(t('Select a branch'), t('Select a branch'), ['class' => 'control-label required  input-label position-relative']) }}

                            <select name="category" id="category" class="form-control form-select2 validate">
                                <option class="not-option" value="">{{ t('Select a branch') }}</option>
                                @foreach ($branches as $key=>$cat)
                                    <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"  {{ ($category_option == $cat->parent_id ? "selected":"") }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-input-error-msg {{ $errors->has('category') ? 'show-error' : ''}}">
                                <span class="fa fa-exclamation-circle"></span>{{ $errors->has('category') ? $errors->first('category', ':message') : t("required_field") }} 
                            </div>
                            <!-- 
                            {!! $errors->first('category', '<p class="help-block">:message</p>') !!} -->
                        </div>
                    @endif

                    <!-- phone code and phone number fields -->
                    <div class="row" id="phone-code-row">
                        <div class="col-md-6">
                            <!-- phone code -->
                            <div class="md-form input-group {{ $errors->has('phone_code') ? 'has-error' : ''}}" id="phone_code-jq-err">
                                {{ Form::label(t('Select a phone code'), t('Select a phone code'), ['class' => 'control-label required  input-label position-relative']) }}
                                <?php   
                                    if(old('phone_code') !== null) { 
                                        $phone_code_option = old('phone_code'); 
                                    } 
                                    else {
                                        $phone_code_option = isset($user->phone_code) ? $user->phone_code : config('country.phone_code');
                                    }
                                    $phoneIcon = "";
                                ?>
                                <select id="phone_code" name="phone_code" class="form-control form-select2 phone-code-auto-search validate" autocomplete="phone_number" >
                                        <option class="not-option" value="" {{ (!old('phone_code') or old('phone_code')==0 or $phone_code_option == 0) ? 'selected="selected"' : '' }}> {{ t('Select a phone code') }} </option>
                                        @foreach ($countries as $item)
                                            @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                                <?php
                                                    $phoneIcon = URL::to(config('app.cloud_url').'/images/flags/16/'.strtolower($item->get('code')).'.png');
                                                ?>

                                            @endif
                                            <option data-image="{{ $phoneIcon }}" value="{{ $item->get('phone') }}" {{ $phone_code_option == $item->get('phone') ? 'selected="selected"' : '' }} >{{ $item->get('name')." ".$item->get('phone') }}</option>
                                        @endforeach
                                </select>
                                <div class="form-input-error-msg {{ $errors->has('phone_code') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('phone_code') ? $errors->first('phone_code', ':message') : t("required_field") }} 
                                </div>
                                <!-- {!! $errors->first('phone_code', '<p class="help-block">:message</p>') !!} -->
                                <!-- <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>
                        </div>
                        <!-- phone number -->
                        <div class="col-md-6">
                            <div class="md-form input-group {{ $errors->has('phone') ? 'has-error' : ''}} " id="phone-jq-err">
                                {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative control-label required input-label']) }}
                                {{ Form::text('phone', old('phone', $user->phone), ['class' => 'animlabel validate', 'id' => 'phone', 'placeholder' => '', 'autocomplete' => 'phone-add' , 'minlength' => 5 , 'maxlength' => 20, 'onkeypress '=> "return isNumber(event)"]) }}

                                <div class="form-input-error-msg {{ $errors->has('phone') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('phone') ? $errors->first('phone', ':message') : t("required_field") }} 
                                </div>

                                <!-- {!! $errors->first('phone', '<p class="help-block">:message</p>') !!} -->
                                <!-- <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>
                        </div>                      
                    </div>
                    <!-- end phone code and phone number fields -->
                    
                    <!-- start country and city fields -->
                    <div class="row" id="city-row">
                        <!-- country fields -->
                        <div class="col-md-6">
                            <div class="md-form input-group {{ $errors->has('country') ? 'has-error' : ''}}" id="country-jq-err">
                                {{ Form::label(t('Select a country'), t('Select a country'), ['class' => 'control-label required  input-label position-relative']) }}

                                <?php   
                                    if(old('country') !== null) { 
                                        $country_option = old('country'); 
                                    } 
                                    else {
                                        $country_option = isset($user->country->code) ? $user->country->code : strtoupper(config('country.icode'));
                                    }
                                ?>
                                <input type="hidden" id="country_selected" value="{{ $country_option }}">
                                <select id="countryid" name="country" class="form-control form-select2 country-auto-search validate">
                                    <option class="not-option" value="" {{ (!old('country') or old('country')==0 or $country_option == 0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                                        @foreach ($countries as $item)
                                        @if (file_exists(public_path() . '/images/flags/16/' . strtolower($item->get("code")) . '.png')) 
                                         <?php
                                                $phoneIcon = URL::to(config('app.cloud_url').'/images/flags/16/'.strtolower($item->get('code')).'.png');
                                                ?>

                                            @endif
                                            <option data-image="{{ $phoneIcon }}" value="{{ $item->get('code') }}" {{ $country_option == $item->get('code') ? 'selected="selected"' : '' }} >{{ $item->get('name') }}</option>
                                        @endforeach
                                </select>
                                <div class="form-input-error-msg {{ $errors->has('country') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('country') ? $errors->first('country', ':message') : t("required_field") }} 
                                </div>
                                <input type="hidden" name="country_name" id='country_name'>
                                <!-- {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="md-form input-group {{ $errors->has('city') ? 'has-error' : ''}} " id="city-jq-err">
                                {{ Form::label(t('City'), t('City'), ['class' => 'control-label  input-label required position-relative']) }}
                                
                                {{ Form::text('city', old('city', $user->profile->city), ['class' => 'animlabel validate', 'id' => 'pac-input', 'placeholder' => '', 'autocomplete' => 'off' ]) }}
                                <div class="form-input-error-msg {{ $errors->has('city') ? 'show-error' : ''}}">
                                    <span class="fa fa-exclamation-circle"></span>{{ $errors->has('city') ? $errors->first('city', ':message') : t("required_field") }} 
                                </div>
                                <!-- 
                                {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                            </div>
                        </div>
                    </div>
                    <!-- end country and city fields  -->
                    <input type="hidden" name="latitude" value="" id="latitude">
                    <input type="hidden" name="longitude" value="" id="longitude">
                    <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state">
                    <input type="hidden" name="geo_city" value="" id="geo_city">
                    <input type="hidden" name="geo_country" value="" id="geo_country">

                    
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
                        <div class="form-input-error-msg {{ $errors->has('preferred_language') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('preferred_language') ? $errors->first('preferred_language', ':message') : t("required_field") }}
                        </div> 
                    </div>
                    <!-- End preferred_language -->
                    <!-- street -->
                    <div class="input-group {{ $errors->has('street') ? 'has-error' : ''}}" id="street-jq-err">
                        {{ Form::label(t('Street'), t('Street'), ['class' => 'position-relative control-label required input-label']) }}
                        {{ Form::text('street', old('street', $user->profile->street), ['class' => 'animlabel validate', 'id' => 'street', 'placeholder' => '', 'autocomplete' => 'street-add']) }}
                        
                        <div class="form-input-error-msg {{ $errors->has('street') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('street') ? $errors->first('street', ':message') : t("required_field") }} 
                        </div>
                        <!-- 
                        {!! $errors->first('street', '<p class="help-block">:message</p>') !!}
                        <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                    </div>

                    <!-- zip -->
                    <div class="input-group pb-30 {{ $errors->has('zip') ? 'has-error' : ''}}" id="zip-jq-err">
                        {{ Form::label(t('Zip'), t('Zip'), ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('zip', old('zip', $user->profile->zip), ['class' => 'animlabel validate', 'id' => 'zip', 'placeholder' => '', 'autocomplete' => 'zip-add' ]) }}

                        <div class="form-input-error-msg {{ $errors->has('zip') ? 'show-error' : ''}}">
                            <span class="fa fa-exclamation-circle"></span>{{ $errors->has('zip') ? $errors->first('zip', ':message') : t("required_field") }} 
                        </div>

                        <!-- 
                        {!! $errors->first('zip', '<p class="help-block">:message</p>') !!}
                        <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span> -->
                    </div>

                    <?php /*
                    @if ($user->user_type_id == 3)

                    <div class="row">
                        <!-- Body Height -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('height') ? 'has-error' : ''}}" id="height-jq-err">

                            <?php   
                                if(old('height') !== null) { 
                                    $height_option = old('height'); 
                                } 
                                else {
                                    $height_option = isset($user->profile->height_id) ? $user->profile->height_id : '';
                                }
                            ?>

                            <input type="hidden" id="height_selected" value="{{ $height_option }}">

                            {{ Form::label(t('Select height'), t('Select height'), ['class' => 'control-label required  input-label position-relative']) }}
                            
                            <select name="height" id="height" class="form-control form-select2" required>
                                <option value="">{{ t('Select height') }}</option>
                            </select> 
                            
                            {!! $errors->first('height', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <!-- Body Weight -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('weight') ? 'has-error' : ''}} " id="weight-jq-err">
                            
                            <?php   
                                if(old('weight') !== null) { 
                                    $weight_option = old('weight'); 
                                } 
                                else {
                                    $weight_option = isset($user->profile->weight_id) ? $user->profile->weight_id : '';
                                }
                            ?>

                            <input type="hidden" id="weight_selected" value="{{ $weight_option }}">

                            {{ Form::label(t('Select weight'), t('Select weight'), ['class' => 'control-label  required input-label position-relative']) }}

                            <select name="weight" id="weight" class="form-control form-select2" required>
                                <option value="">{{ t('Select weight') }}</option>
                            </select> 
                            
                            {!! $errors->first('weight', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Dress size -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('dressSize') ? 'has-error' : ''}}" id="dressSize-jq-err">

                            <?php   
                                if(old('dressSize') !== null) { 
                                    $dressSize_option = old('dressSize'); 
                                } 
                                else {
                                    $dressSize_option = isset($user->profile->size_id) ? $user->profile->size_id : '';
                                }
                            ?>

                            <input type="hidden" id="dressSize_selected" value="{{ $dressSize_option }}">

                            {{ Form::label(t('Select dress size'), t('Select dress size'), ['class' => 'control-label required  input-label position-relative']) }}

                            <select name="dressSize" id="dressSize" class="form-control form-select2" required>
                                <option value="">{{ t('Select dress size') }}</option>
                            </select> 
                            
                            {!! $errors->first('dressSize', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <!-- Shoe size -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('shoeSize') ? 'has-error' : ''}}" id="shoeSize-jq-err">

                            <?php   
                                if(old('shoeSize') !== null) { 
                                    $shoeSize_option = old('shoeSize'); 
                                } 
                                else {
                                    $shoeSize_option = isset($user->profile->shoes_size_id) ? $user->profile->shoes_size_id : '';
                                }
                            ?>

                            <input type="hidden" id="shoeSize_selected" value="{{ $shoeSize_option }}">

                            {{ Form::label(t('Select shoe size'), t('Select shoe size'), ['class' => 'control-label required input-label position-relative']) }}

                            <select  name="shoeSize" id="shoeSize" class="form-control form-select2" required>
                                <option value="">{{  t('Select shoe size') }}</option>
                            </select> 
                            
                            {!! $errors->first('shoeSize', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        
                    </div>

                    <div class="row">
                        <!-- Eye color -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('eyeColor') ? 'has-error' : ''}}" id="eyeColor-jq-err">

                            <?php   
                                if(old('eyeColor') !== null) { 
                                    $eyeColor_option = old('eyeColor'); 
                                } 
                                else {
                                    $eyeColor_option = isset($user->profile->eye_color_id) ? $user->profile->eye_color_id : '';
                                }
                            ?>

                            {{ Form::label(t('Select eye color'), t('Select eye color'), ['class' => 'control-label required input-label position-relative']) }}

                            <select  name="eyeColor" id="eyeColor" class="form-control form-select2" required>
                                <option value="">{{ t('Select eye color') }}</option>
                                    <?php foreach ($properties['eye_color'] as $key => $cat) {?>
                                        <option value="<?=$key?>"  {{ ($eyeColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                    <?php }?>
                            </select>
                            {!! $errors->first('eyeColor', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <!-- Hair color -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('hairColor') ? 'has-error' : ''}}" id="hairColor-jq-err">

                            <?php   
                                if(old('hairColor') !== null) { 
                                    $hairColor_option = old('hairColor'); 
                                } 
                                else {
                                    $hairColor_option = isset($user->profile->hair_color_id) ? $user->profile->hair_color_id : '';
                                }
                            ?>

                            {{ Form::label(t('Select hair color'), t('Select hair color'), ['class' => 'control-label required  input-label position-relative']) }}

                            <select  name="hairColor" id="hairColor" class="form-control form-select2" required>
                                <option value="">{{ t('Select hair color') }}</option>
                                    <?php foreach ($properties['hair_color'] as $key => $cat) {?>
                                        <option value="<?=$key?>"  {{ ($hairColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                    <?php }?>
                            </select>
                            {!! $errors->first('hairColor', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Skin color -->
                        <div class="input-group col-md-6 col-sm-12 {{ $errors->has('skinColor') ? 'has-error' : ''}} " id="skinColor-jq-err">

                            <?php   
                                if(old('skinColor') !== null) { 
                                    $skinColor_option = old('skinColor'); 
                                } 
                                else {
                                    $skinColor_option = isset($user->profile->skin_color_id) ? $user->profile->skin_color_id : '';
                                }
                            ?>

                            {{ Form::label(t('Skin color'), t('Skin color'), ['class' => 'control-label  input-label required position-relative']) }}
                            
                            <select  name="skinColor" id="skinColor" class="form-control form-select2" required>
                                <option value="">{{ t('Select skin color') }}</option>
                                    <?php foreach ($properties['skin_color'] as $key => $cat) {?>
                                        <option value="<?=$key?>"  {{ ($skinColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                    <?php }?>
                            </select>
                            {!! $errors->first('skinColor', '<p class="help-block">:message</p>') !!}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                    </div>
                    @endif

                    */ ?>
                    

                    <div class="text-center"><button type="submit" id="register_data" class="d-inline-block btn btn-success register mb-10">{{ ucfirst(t('next')) }}</button></div>
                    <div class="text-center color-gray mb-40">{{ t('Please fill up all required fields') }}</div>
                    <?php /*
                        <!-- <div class="text-center"><span>Already have an account? <a href="{{ route('login') }}" class="d-inline-block bold bb-black lh-15">Login</a></span></div> -->
                    */  ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
<script src="{{ url(config('app.cloud_url').'/assets/js/jquery/jquery-latest.js') }}"></script>
@if(Lang::locale()=='de')
<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker-de.min.js') }}" type="text/javascript"></script>
@else
<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- Place Auto Complete start -->
{{ Html::script(config('app.cloud_url').'/assets/js/place-autocomplete.js') }}

<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlemaps.key')}}&libraries=places"></script>
<!-- Place Auto Complete End -->

<script type="text/javascript">
    var requiredMsg = '{{ t("required_field") }}';
    var genderError = "<?php echo t('The Gender field is required'); ?>";
    var defaultCountryCode = '<?php echo $country_code; ?>';
    var userType = "<?php echo $user->user_type_id ?>";
    var username = "<?php echo $user->username; ?>";
    var funnelPageName = "reg_data";
    var selectHeightLabel = "<?php echo t('Select height'); ?>";
    var selectweightLabel = "<?php echo t('Select weight'); ?>";
    var selectdressSizeLabel = "<?php echo t('Select dress size'); ?>";
    var selectshoeSizeLabel = "<?php echo t('Select shoe size'); ?>";
    var cs_birthday_birthDay = '<?php echo old('cs_birthday_birthDay'); ?>';
    var userBirthday = '<?php echo $user->profile->birth_day; ?>';
    var verification_link = "<?php echo config('app.url').'/'.config('app.locale').'/verify/user/email/'.$user->email_token; ?>"; 
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/data-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
{{ Html::script(config('app.cloud_url').'/js/formValidator.js') }}
@endsection