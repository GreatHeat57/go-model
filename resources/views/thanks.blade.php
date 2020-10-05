@extends('layouts.logged_in.out_of_app')
@section('content')

    @include('childs.register_title')

    @include('auth.register.inc.wizard_new')

    {{ Html::style(config('app.cloud_url').'/css/bladeCss/data-blade.css') }}
    {{ Html::style(config('app.cloud_url').'/css/formValidator.css') }}

    <?php /*<!-- <div class="d-flex align-items-center container out_of_app px-0 mw-970"> --> */ ?>
    @if (Session::has('flash_notification'))
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-20">
                    @include('flash::message')
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex align-items-center container px-0 mw-970 pt-20">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 py-20 px-30">
                    <div class="text-center py-40 mx-auto mw-760">
                        <div class="d-block mx-auto feedback-check bg-grey2 mb-40"></div>

                            {!! t('Register thanks page content :first_name', ['first_name' => $user->profile->first_name]) !!} 
                            
                            @if($user->user_type_id == 3)
                                {!! t('profile information update warning msg thanks page') !!}
                            @endif
                        
                        <?php /*
                        <p class="m-0">When you registered, you provided the following address:<span class="d-block"><?php echo config('app.suppport_email'); ?></span></p>
                        <?php */ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- If user is from free countr free model then hide the available time drop down -->
    

    <?php
        
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

        // // check old value set or not
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
    ?>

    @if(isset($is_premium_user) && $is_premium_user == true)

    <!-- Start Available Time sections -->
    <div class="d-flex align-items-center container px-0 mw-970 pt-20" >
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-760 py-20 px-30 timeformat-div">
                    <div class="text-center mb-20 py-40">
                        <h1 class="prata mb-20">{{ ucWords(t('Available times to contact you')) }}</h1>
                        {{ t('Let us know when is the best time to contact you from 9am to 7pm') }}
                    </div>
                    {{ Form::open(array('url' => lurl('saveUserPhoneAvailable'), 'method' => 'post', 'id' => 'available-phone-data')) }}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <!-- Start Available Time Section 1 -->
                        <div class="row timeformat_section pt-15" id="timeformat_section1">
                            <div class="col-md-4 offset-md-2">
                                {{ Form::label('from',  t('From') , ['class' => 'position-relative required control-label input-label']) }}
                                <select name="from[]" class="form-control form-select2" id="tf1-select-from">
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
                            <div class="col-md-4">
                                {{ Form::label('to',  t('To') , ['class' => 'position-relative required control-label input-label']) }}
                                <select name="to[]" class="form-control form-select2" id="tf1-select-to">
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
                        <div class="row error_timeformat_section1" style="display: none;">
                            <div class="col-md-12 offset-md-2 form-input-error-msg show-error">
                                <span class="fa fa-exclamation-circle"></span>{{ t('To time must be greater than From time') }}
                            </div>
                        </div>

                        <!-- End Available Time Section 1 -->

                        <?php /*
                        <!-- Start Available Time Section 2 -->
                        <div class="row timeformat_section {{ $d_none2 }} tf2 pt-15" id="timeformat_section2">
                            <div class="col-md-4 col-5 offset-md-2">
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
                            <div class="col-md-4 col-5">
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
                        <div class="row error_timeformat_section2" style="display: none;">
                            <div class="col-md-12 offset-md-2">
                                <p class="help-block mb-0">{{ t('To time must be greater than From time') }}</p>
                            </div>
                        </div>
                        <!-- End Available Time Section 2 -->

                        <!-- Start Available Time Section 3 -->
                        <div class="row timeformat_section {{ $d_none3 }} tf3 pt-15" id="timeformat_section3">
                            <div class="col-md-4 col-5 offset-md-2">
                                {{ Form::label('from2',  t('From') , ['class' => 'position-relative control-label input-label']) }}
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
                            <div class="col-md-4 col-5">
                                {{ Form::label('to2',  t('To') , ['class' => 'position-relative control-label input-label']) }}
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
                        <div class="row error_timeformat_section3" style="display: none;">
                            <div class="col-md-12 offset-md-2">
                                <p class="help-block mb-0">{{ t('To time must be greater than From time') }}</p>
                            </div>
                        </div>
                        <!-- End Available Time Section 3 -->
                        
                        <!-- Start Add More Button -->
                        <div class="text-center py-20">
                            <a class="append-time-div btn add-more" title="{{ t('Add more') }}">{{ t('Add more') }}</a>
                        </div> 
                        <!-- End Add More Button -->
                        */ ?>

                        <!-- End Piercing and Tattoo fields -->
                        <div class="text-center py-30">
                            <button type="submit" class="d-inline-block btn btn-success register" id="finish-available-phone-submit-btn">{{ t('Save') }}</button></div>
                    {{ Form::close() }}
                     
                    <div class="alert alert-danger print-error-msg" style="display: none;"></div>
                    <div class="alert alert-success print-success-msg" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Available Time sections -->

    @endif

    <!-- Start profile information -->
    @if ($user->user_type_id == 3)
    
    <div class="d-flex align-items-center container px-0 mw-970 pt-20" >
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-970 py-20 px-30">
                    <div class="text-center pt-40">
                        <h1 class="prata">{{ ucWords(t('Your profile information')) }}</h1>
                    </div>
                    {{ Form::open(array('url' => lurl('updateProfileInfo'), 'method' => 'post', 'id' => 'reg-data')) }}

                        {!! csrf_field() !!}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <!-- Start Height && Weight Fields -->
                        <div class="row">
                            <!-- Body Height -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('height') ? 'has-error' : ''}}" id="height-jq-err">

                                    <?php   
                                        if(old('height') !== null) { 
                                            $height_option = old('height'); 
                                        } 
                                        else {
                                            $height_option = isset($user->profile->height_id) ? $user->profile->height_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Height'), t('Height'), ['class' => 'control-label required  input-label position-relative']) }}
                                    
                                    <select name="height" id="height" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select height') }}</option>
                                        <?php foreach ($properties['height'] as $hk => $hv) {?>
                                                <option value="<?=$hk?>"  {{ ($height_option == $hk) ? 'selected' : '' }} ><?=$hv?></option>
                                            <?php }?>
                                    </select>

                                    <div class="form-input-error-msg {{ $errors->has('height') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('height') ? $errors->first('height', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Body Weight -->
                                <div class="md-form input-group {{ $errors->has('weight') ? 'has-error' : ''}} " id="weight-jq-err">
                                    
                                    <?php   
                                        if(old('weight') !== null) { 
                                            $weight_option = old('weight'); 
                                        } 
                                        else {
                                            $weight_option = isset($user->profile->weight_id) ? $user->profile->weight_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Weight'), t('Weight'), ['class' => 'control-label  required input-label position-relative']) }}

                                    <select name="weight" id="weight" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select weight') }}</option>
                                        <?php foreach ($properties['weight'] as $wk => $wv) {?>
                                                <option value="<?=$wk?>"  {{ ($weight_option == $wk) ? 'selected' : '' }} ><?=$wv?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('weight') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('weight') ? $errors->first('weight', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Height && Weight Fields -->

                        <!-- Start Dress Size && Breast Fields -->
                        <div class="row">
                            <!-- Dress size -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('dressSize') ? 'has-error' : ''}}" id="dressSize-jq-err">

                                    <?php   
                                        if(old('dressSize') !== null) { 
                                            $dressSize_option = old('dressSize'); 
                                        } 
                                        else {
                                            $dressSize_option = isset($user->profile->size_id) ? $user->profile->size_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Clothes Size'), t('Clothes Size'), ['class' => 'control-label required  input-label position-relative']) }}

                                    <select name="dressSize" id="dressSize" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select dress size') }}</option>
                                        <?php foreach ($properties['dress_size'] as $dk => $dv) {?>
                                                <option value="<?=$dk?>"  {{ ($dressSize_option == $dk) ? 'selected' : '' }} ><?=$dv?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('dressSize') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('dressSize') ? $errors->first('dressSize', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                            <!-- breast size -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('breast') ? 'has-error' : ''}}" id="breast-jq-err">

                                    {{ Form::label('breast' , t('Breast'), ['class' => 'control-label select-label position-relative required']) }}

                                    <?php   
                                        if(old('breast') !== null) { 
                                            $breast_option = old('breast'); 
                                        } 
                                        else {
                                            $breast_option = isset($user->profile->chest_id) ? $user->profile->chest_id : '';
                                        }
                                    ?>
                                    <select name="breast" id="breast" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select chest') }}</option>
                                        <?php foreach ($properties['chest'] as $bk => $bv) {?>
                                                <option value="<?=$bk?>"  {{ ($breast_option == $bk) ? 'selected' : '' }} ><?=$bv?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('breast') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('breast') ? $errors->first('breast', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Dress Size && Breast Fields -->

                        <!-- Start Waist && Hips Fields -->
                        <div class="row">
                            <!-- Waist size -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('waist') ? 'has-error' : ''}}" id="waist-jq-err">

                                   <?php   
                                        if(old('waist') !== null) { 
                                            $waist_option = old('waist'); 
                                        } 
                                        else {
                                            $waist_option = isset($user->profile->waist_id) ? $user->profile->waist_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Waist'), t('Waist'), ['class' => 'control-label input-label position-relative']) }}

                                    <select name="waist" id="waist" class="form-control form-select2">
                                        <option value="">{{ t('Select waist') }}</option>
                                        <?php foreach ($properties['waist'] as $waistk => $waistv) {?>
                                                <option value="<?=$waistk?>"  {{ ($waist_option == $waistk) ? 'selected' : '' }} ><?=$waistv?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Hips size -->
                                <div class="md-form input-group {{ $errors->has('hip') ? 'has-error' : ''}}" id="hip-jq-err">

                                    <?php   
                                        if(old('hip') !== null) { 
                                            $hip_option = old('hip'); 
                                        } 
                                        else {
                                            $hip_option = isset($user->profile->hips_id) ? $user->profile->hips_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Hips'), t('Hips'), ['class' => 'control-label input-label position-relative']) }}

                                    <select name="hip" id="hip" class="form-control form-select2">
                                        <option value="">{{ t('Select hips') }}</option>
                                        <?php foreach ($properties['hips'] as $hipk => $hipv) {?>
                                                <option value="<?=$hipk?>"  {{ ($hip_option == $hipk) ? 'selected' : '' }} ><?=$hipv?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Waist && Hips Fields -->
                        
                        <!-- Start Shoe size and Eye colour fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Shoe size -->
                                <div class="md-form input-group {{ $errors->has('shoeSize') ? 'has-error' : ''}}" id="shoeSize-jq-err">
                                    <?php   
                                        if(old('shoeSize') !== null) { 
                                            $shoeSize_option = old('shoeSize'); 
                                        } 
                                        else {
                                            $shoeSize_option = isset($user->profile->shoes_size_id) ? $user->profile->shoes_size_id : '';
                                        }
                                    ?> 
                                    {{ Form::label(t('Shoe size'), t('Shoe size'), ['class' => 'control-label required input-label position-relative']) }}

                                    <select  name="shoeSize" id="shoeSize" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{  t('Select shoe size') }}</option>
                                        <?php foreach ($properties['shoe_size'] as $sk => $sv) {?>
                                                <option value="<?=$sk?>"  {{ ($shoeSize_option == $sk) ? 'selected' : '' }} ><?=$sv?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('shoeSize') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('shoeSize') ? $errors->first('shoeSize', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Eye color -->
                                <div class="md-form input-group {{ $errors->has('eyeColor') ? 'has-error' : ''}}" id="eyeColor-jq-err">
                                    <?php   
                                        if(old('eyeColor') !== null) { 
                                            $eyeColor_option = old('eyeColor'); 
                                        } 
                                        else {
                                            $eyeColor_option = isset($user->profile->eye_color_id) ? $user->profile->eye_color_id : '';
                                        }
                                    ?>
                                    {{ Form::label(t('Eye color'), t('Eye color'), ['class' => 'control-label required input-label position-relative']) }}
                                    <select  name="eyeColor" id="eyeColor" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select eye color') }}</option>
                                            <?php foreach ($properties['eye_color'] as $ek => $ev) {?>
                                                <option value="<?=$ek?>"  {{ ($eyeColor_option == $ek) ? 'selected' : '' }} ><?=$ev?></option>
                                            <?php }?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('eyeColor') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('eyeColor') ? $errors->first('eyeColor', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Shoe size and Eye colour fields -->

                        <!-- Start Hair Color and Skin color fields -->
                        <div class="row">
                            <!-- Hair color -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('hairColor') ? 'has-error' : ''}}" id="hairColor-jq-err">

                                    <?php   
                                        if(old('hairColor') !== null) { 
                                            $hairColor_option = old('hairColor'); 
                                        } 
                                        else {
                                            $hairColor_option = isset($user->profile->hair_color_id) ? $user->profile->hair_color_id : '';
                                        }
                                    ?>

                                    {{ Form::label(t('Hair color'), t('Hair color'), ['class' => 'control-label required  input-label position-relative']) }}

                                    <select  name="hairColor" id="hairColor" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select hair color') }}</option>
                                            <?php foreach ($properties['hair_color'] as $hairk => $hairv) {?>
                                                <option value="<?=$hairk?>"  {{ ($hairColor_option == $hairk) ? 'selected' : '' }} ><?=$hairv?></option>
                                            <?php }?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('hairColor') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('hairColor') ? $errors->first('hairColor', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Skin color -->
                                <div class="md-form php input-group{{ $errors->has('skinColor') ? 'has-error' : ''}} " id="skinColor-jq-err">

                                    <?php   
                                        if(old('skinColor') !== null) { 
                                            $skinColor_option = old('skinColor'); 
                                        } 
                                        else {
                                            $skinColor_option = isset($user->profile->skin_color_id) ? $user->profile->skin_color_id : '';
                                        }
                                    ?>

                                    {{ Form::label(t('Skin color'), t('Skin color'), ['class' => 'control-label  input-label required position-relative']) }}
                                    
                                    <select  name="skinColor" id="skinColor" class="form-control form-select2 validate">
                                        <option class="not-option" value="">{{ t('Select skin color') }}</option>
                                            <?php foreach ($properties['skin_color'] as $skink => $skinv) {?>
                                                <option value="<?=$skink?>"  {{ ($skinColor_option == $skink) ? 'selected' : '' }} ><?=$skinv?></option>
                                            <?php }?>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('skinColor') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('skinColor') ? $errors->first('skinColor', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Hair Color and Skin color fields -->

                        <!-- Start Piercing and Tattoo fields -->
                        <div class="row">
                            <!-- Piercing -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('piercing') ? 'has-error' : ''}}" id="piercing-jq-err">
                                
                                    {{ Form::label(t('Piercing'), t('Piercing'), ['class' => 'control-label required  input-label position-relative']) }}

                                    <select  name="piercing" id="piercing" class="form-control form-select2 validate">
                                        <option class="not-option" value="" >{{t('Choose')}}</option>
                                        <option value="1" {{(!empty($user->profile->piercing) && $user->profile->piercing == 1)?'selected':''}}>{{ t('Yes') }}</option>
                                        <option value="2" {{(!empty($user->profile->piercing) && $user->profile->piercing == 2)?'selected':''}}>{{ t('No') }}</option>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('piercing') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('piercing') ? $errors->first('piercing', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                            <!-- Tattoo -->
                            <div class="col-md-6">
                                <div class="md-form input-group {{ $errors->has('tattoo') ? 'has-error' : ''}}" id="tattoo-jq-err">

                                    {{ Form::label(t('Tattoo'), t('Tattoo'), ['class' => 'control-label required  input-label position-relative']) }}

                                    <select  name="tattoo" id="tattoo" class="form-control form-select2 validate">
                                        <option class="not-option" value="" >{{t('Choose')}}</option>
                                        <option value="1" {{(!empty($user->profile->tattoo) && $user->profile->tattoo == 1)?'selected':''}}>{{ t('Yes') }}</option>
                                        <option value="2" {{(!empty($user->profile->tattoo) && $user->profile->tattoo == 2)?'selected':''}}>{{ t('No') }}</option>
                                    </select>
                                    <div class="form-input-error-msg {{ $errors->has('tattoo') ? 'show-error' : ''}}">
                                        <span class="fa fa-exclamation-circle"></span>{{ $errors->has('tattoo') ? $errors->first('tattoo', ':message') : t("required_field") }} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Piercing and Tattoo fields -->
                        <div class="text-center py-20"><button type="submit" id="register_data" class="d-inline-block btn btn-success register">{{ t('Save') }}</button></div>
                        <div class="text-center color-gray mb-40">{{ t('Please fill up all required fields') }}</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End profile information -->
@endsection
@section('page-scripts')
<script src="{{ url(config('app.cloud_url').'/assets/js/jquery/jquery-latest.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
    var username = "<?php echo $user->username; ?>";
    var funnelPageName = "reg_finish";
    var requiredMsg = '{{ t("required_field") }}';
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/finish-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/added-time-format.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
{{ Html::script(config('app.cloud_url').'/js/formValidator.js') }}
@endsection
