@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60 w-xl-1220">
        <h1 class="text-center prata">{{ ucWords(t('My profile')) }}</h1>
        <div class="position-relative">
        <div class="divider mx-auto"></div>
            <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{ t('Your username, name, bio and links appear on your model profile') }} {{ t('Your real name, email address and other contact details remaining private') }}</p>
        <div class="text-center mb-30"><a href="{{ lurl(trans('routes.user').'/'.Auth::user()->username) }}" class="btn btn-default insight mini-mobile">{{ t('View')}}</a></div>
        
        </div>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
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

             $disabled = 'disabled';

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
            // End Code Available Contact 
        ?>
        <?php /*
        <div class="w-xl-1220 mx-xl-auto">
           @include('flash::message')

            @if (isset($errors) and $errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
                    <ul class="list list-check">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <?php */ ?>
        
        @if($user->user_register_type !== config('constant.country_free'))
           <?php $disabled = ''; ?>
        @endif

        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            <?php /*
            <!-- <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pb-40 px-20 px-xl-0 text-center">
                    <div class="prog mb-20">
                        <div class="bar position-relative">
                            <div class="prog-bg position-absolute" style="width: 65%"></div>
                            <span class="number box-shadow position-absolute" style="left: calc(65% - 30px);">65%</span>
                        </div>
                    </div>
                    <p class="f-15 lh-14 dark-grey2 mb-0">Gib einen Wert für "Lebenslauf" ein um dein Profil um 35% zu verbessern!</p>
                </div>
            </div> -->
            
            @if(config('app.locale') == 'de')
            <?php $lang = '';?>
            @else
            <?php $lang = config('app.locale');?>
            @endif
            {{ Form::open(array('url' => $lang.'/partner-profile-save', 'method' => 'post', 'id' => 'partner-profile-save', 'files' => true)) }}
            
            */ ?>
            
            {{ Form::open(array('url' => lurl('partner-profile-save'), 'method' => 'post', 'id' => 'partner-profile-save', 'files' => true, 'autocomplete' => 'off')) }}
            
            <input type="hidden" name="is_place" value="{{ old('is_place', '1') }}" id="is_place_select">
            <?php /* <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state"> */ ?>
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pt-40 px-38 px-lg-0">
                    <?php /*
                    <!-- <div class="pb-40 mb-40 bb-light-lavender3">
                        <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                @if($logo !== "" && file_exists(public_path('uploads').'/'.$logo))
                                    <img id="output-partner-logo" src="{{ \Storage::url($profile->logo) }}" alt="user" data-action="zoom">&nbsp;
                                @elseif (!empty($gravatar))
                                    <img id="output-partner-logo" src="{{ $gravatar }}" alt="user" data-action="zoom">&nbsp;
                                @else
                                    <img id="output-partner-logo" src="{{ url('images/user.jpg') }}" alt="user" data-action="zoom">
                                @endif
                            <p class="w-md-440 mx-auto bold">{{ t('Profile Logo') }}</p>
                           
                        </div>
                        
                        <div class="d-md-inline-block pt-40">
                                <input type="file" id="partnerprofileLogo" name="profile[logo]" onchange="loadLogoFile(event)" class="upload_white mb-20" >
                                <label id="error-profile-logo" class="required"></label>
                        </div>
                    </div> -->
                    */ ?>
                    <?php /* coment old profile upload code ?>
                    <div class="pb-40 mb-40 bb-light-lavender3 ">
                        <h2 class="bold f-18 lh-18">{{ t('Profile Logo') }}</h2>
                        <div class="divider"></div>

                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-40 mb-40 d-md-flex">
                                    <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                        
                                        @if($logo !== "" && $logo !== null && Storage::exists($logo))
                                            <img id="output-partner-logo" src="{{ \Storage::url($profile->logo) }}" alt="{{ trans('metaTags.User') }}" width="75%">&nbsp;
                                         
                                        @else
                                            <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                        @endif

                                    </div>
                                    <div class="d-md-inline-block">
                                        <div class="upload-btn-wrapper">
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}</a>
                                          <input type="file"  id="partnerprofileLogo" name="profile[logo]" onchange="loadLogoFile(event)" accept="image/x-png,image/jpeg,image/jpg"/>
                                        </div>

                                        
                                        <p class="w-lg-460">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                        <p id="error-profile-logo" class=""></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php */ ?>
                    
                    <!--start crop image logo Content-->
                    <div class="pb-40 mb-40 bb-light-lavender3 ">
                        <h2 class="bold f-18 lh-18">{{ t('Profile Logo') }}</h2>
                        <div class="divider"></div>

                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="d-md-flex mb-40">
                                    <div id="uploaded_image" class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                        
                                        @if($user->profile->logo !== "" && $user->profile->logo !== null && Storage::exists($user->profile->logo))
                                            <img id="output-partner-logo" src="{{ \Storage::url($user->profile->logo) }}" alt="user" width="75%">&nbsp;
                                        @else
                                            <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="user" >
                                        @endif
                                    </div>
                                    <div class="d-md-inline-block">
                                        <div class="upload-btn-wrapper">
                                          
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}<input type="file"  id="upload_image" name="upload_image"  accept="image/x-png,image/jpeg,image/jpg"/></a>
                                            

                                        </div>
                                            <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                    </div>
                                </div>
                                <p id="error-profile-logo" class="mb-20 px-10"></p>
                                <?php /*<p id="success-profile-logo" class="mb-20 px-10"></p> */?>
                            </div>
                        </div>
                    </div>
                    <!--end crop image logo Content -->
                    
                    <div class="pb-40 mb-40 bb-light-lavender3 ">
                        <h2 class="bold f-18 lh-18">{{ t('Cover Picture') }}</h2>
                        <div class="divider"></div>

                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-40 mb-40 d-md-flex">
                                    <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">

                                        @if($cover !== "" && $cover !== null && Storage::exists($cover))
                                            <img id="output-partner-cover" src="{{ \Storage::url($profile->cover) }}" class="" alt="{{ trans('metaTags.User') }}" width="75%">&nbsp;
                                        @else
                                            <img id="output-partner-cover" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="{{ trans('metaTags.User') }}" >
                                        @endif

                                    </div>
                                    <div class="d-md-inline-block">
                                        
                                        <div class="upload-btn-wrapper">
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20"> {{ t('select new photo') }}
                                           <input type="file"  id="partnerprofileCover" name="profile[cover]" onchange="loadCoverFile(event)"  accept="image/x-png,image/jpeg,image/jpg"/>
                                        </a>
                                        </div>

                                       
                                        <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                        <p id="error-profile-cover" class=""></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php /*
                   <!--  <div class="pb-40 mb-40 bb-light-lavender3 ">
                        <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                 @if($profile->cover !== "" && file_exists(public_path('uploads').'/'.$profile->cover))
                                    <img id="output-partner-cover" src="{{ \Storage::url($profile->cover) }}" class="" alt="user" data-action="zoom">&nbsp;
                                @else
                                    <img id="output-partner-cover" class="" src="{{ url('images/user.jpg') }}" alt="user" data-action="zoom">
                                @endif
                            <p class="w-md-440 mx-auto bold">{{ t('Cover Picture') }}</p>
                        </div>
                        <div class="d-md-inline-block pt-40">
                            <input type="file" id="partnerprofileCover" name="profile[cover]" onchange="loadCoverFile(event)" class="upload_white mb-20" >
                            <label id="error-profile-cover" class="required"></label>
                        </div>
                    </div> -->
                    */ ?>
                    <div class="pb-20 mb-20 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('My details') }}</h2>
                        <div class="divider"></div>

                        <div class="input-group" id="go-code-jq-err">
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
                
                        <div class="input-group" id="company_name-jq-err">
                            {{ Form::label(t('Company Name'), t('Company Name'), ['class' => 'position-relative input-label required']) }}
                             
                            {{ Form::text('company_name', old('company_name',(!empty($profile->company_name)) ? $profile->company_name :'' ),['class' => 'animlabel','required']) }} 
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <div class="input-group" id="category-jq-err">

                            <?php  

                                if(old('category') !== null) { 
                                    $branch_option = old('category'); 
                                } 
                                else {
                                    $branch_option = isset($user->profile->category_id) ? $user->profile->category_id : '';
                                }
                            ?>

                            {{ Form::label('branch', t('Branch'), ['class' => 'control-label required input-label position-relative']) }}
                            <select name="category" id="category" class="form-control" required>
                                <option value="">{{ t('Select a branch') }}</option>
                                @foreach ($branches as $key => $cat)
                                    <?php /* ?>
                                   <option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"  {{ ($branch_option == $cat->tid ? "selected":"") }}>{{ $cat->name }}</option>
                                   <?php */ ?>
                                   <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"  {{ ($branch_option == $cat->parent_id ? "selected":"") }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>

                        </div>

                        <?php 
                            $yesCheck = '';
                            $noCheck = '';
                            
                            if(old('allow_search') !== null){
                                if(old('allow_search') == 1){
                                    $yesCheck = 'checked="checked"';
                                }else{
                                    $noCheck = 'checked="checked"';
                                }
                            }else{
                                if($profile->allow_search == 1){
                                    $yesCheck = 'checked="checked"';
                                }else{
                                    $noCheck = 'checked="checked"';
                                }
                            }
                        ?> 
                    
                        <div class="col-md-6 px-0">
                            {{ Form::label(t('Allow in search?'), t('Allow in search?'), ['class' => 'position-relative input-label']) }}
                            <div class="input-group custom-radio">

                                <input class="radio_field" id="model" name="allow_search" type="radio" value="1" <?php echo $yesCheck; ?> >

                                <label for="model" class="d-inline-block radio-label col-sm-6">{{ t('Yes') }} </label>

                                <input class="radio_field" id="partner" name="allow_search" type="radio" value="0" <?php echo $noCheck; ?> >

                                <label for="partner" class="d-inline-block radio-label col-sm-6">{{ t('No') }}</label>

                                <?php /*
                                {{ Form::radio('allow_search', 1, $yesCheck, ['class' => 'radio_field', 'id' => 'model']) }}

                                {{ Form::label('model',  t('Yes'), ['class' => 'd-inline-block radio-label col-sm-6']) }}

                                {{ Form::radio('allow_search', 0, $noCheck, ['class' => 'radio_field', 'id' => 'partner']) }}

                                {{ Form::label('partner', t('No'), ['class' => 'd-inline-block radio-label col-sm-6']) }} */?>

                            </div>
                        </div>

                        <div class="input-group" id="description-jq-err">
                            {{ Form::label('description', t('Introduction'), ['class' => 'position-relative input-label required']) }}
                            {{ Form::textarea('description', stripslashes($profile->description), ['class' => 'animlabel textarea-description', 'id' => 'pageContent']) }}
                             <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                    </div>

                    <?php 
                            $tfpYesCheck = '';
                            $tfpNoCheck = '';
                            
                            if(old('tfp') !== null){
                                if(old('tfp') == 1){
                                    $tfpYesCheck = 'checked="checked"';
                                }else{
                                    $tfpNoCheck = 'checked="checked"';
                                }
                            }else{
                                if($profile->tfp == 1){
                                    $tfpYesCheck = 'checked="checked"';
                                }else{
                                    $tfpNoCheck = 'checked="checked"';
                                }
                            }
                        ?> 


                    <div class="pb-10 mb-20  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('TFP Information') }}</h2>
                        <div class="divider"></div>
                        <div class="col-md-6 px-0">
                            {{ Form::label(t('TFP'), t('TFP'), ['class' => 'required position-relative input-label']) }}
                            <div class="input-group custom-radio">

                                <input class="radio_field" id="model1" name="tfp" type="radio" value="1" <?php echo $tfpYesCheck; ?>>

                                <label for="model1" class="d-inline-block radio-label col-sm-6">{{ t('Yes') }} </label>

                                <input class="radio_field" id="partner1" name="tfp" type="radio" value="0" <?php echo $tfpNoCheck; ?>>

                                <label for="partner1" class="d-inline-block radio-label col-sm-6">{{ t('No') }}</label>

                                <?php /*

                                {{ Form::radio('tfp', 1, ($profile->tfp == 1), ['class' => 'radio_field', 'id' => 'model1']) }}
                                {{ Form::label('model1',  t('Yes'), ['class' => 'd-inline-block radio-label col-sm-6']) }}
                                {{ Form::radio('tfp', 0, ($profile->tfp == 0), ['class' => 'radio_field', 'id' => 'partner1']) }}
                                {{ Form::label('partner1', t('No'), ['class' => 'd-inline-block radio-label col-sm-6']) }} */ ?>
                            </div>
                        </div>
                    </div>

                    <?php // newsletter section start ?>
                    <div class="pb-10 mb-20  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('newsletter') }}</h2>
                        <div class="divider"></div>
                        <div class="row custom-checkbox">
                            <div class="col-md-12 col-sm-12">
                                {{ Form::checkbox('newsletter',  1, old('newsletter',(!empty($user->receive_newsletter))? $user->receive_newsletter:'' ), ['class' => 'checkbox_field', 'id' => 'newsletter']) }}

                                {{ Form::label('newsletter', t('Job-Newsletters-partner'), ['class' => 'checkbox-label']) }}
                            </div>
                        </div>
                    </div>
                    <?php // newsletter section end ?>


                    <div class="pb-10 mb-20  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Website & Social Networks') }}</h2>
                        <div class="divider"></div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start align-items-center mb-30 ">
                                    {{ Form::text('facebook', old('facebook',(!empty($profile->facebook)) ? $profile->facebook :'' ), ['class' => 'animlabel', 'placeholder' => 'Facebook']) }}
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    {{ Form::text('instagram', old('instagram',(!empty($profile->instagram)) ? $profile->instagram :'' ), ['class' => 'animlabel', 'placeholder' => 'Instagram']) }}
                                </div>
                                <?php /*
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                   {{ Form::text('google_plus', old('google_plus',(!empty($profile->google_plus)) ? $profile->google_plus :'' ), ['class' => 'animlabel', 'placeholder' => 'Google Plus']) }}
                                </div>
                                */?>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    {{ Form::text('twitter', old('twitter',(!empty($profile->twitter)) ? $profile->twitter :'' ), ['class' => 'animlabel', 'placeholder' => 'Twitter']) }}
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    {{ Form::text('linkedin', old('linkedin',(!empty($profile->linkedin)) ? $profile->linkedin :'' ), ['class' => 'animlabel', 'placeholder' => 'Linkedin']) }}
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    {{ Form::text('pinterest', old('pinterest',(!empty($profile->pinterest)) ? $profile->pinterest :'' ), ['class' => 'animlabel', 'placeholder' => 'Pinterest']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-10 mb-20  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Contact Information') }}</h2>
                        <div class="divider"></div>

                        <div class=" row">
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone_code') ? 'has-error' : ''}}" id="phone_code-jq-err">
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
                                <select id="phone_code" name="phone_code" class="form-control form-select2 phone-code-auto-search" required {{ $disabled }}>
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
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone') ? 'has-error' : ''}}" id="phone-jq-err">
                                {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative input-label required']) }}
                                
                                {{ Form::text('phone', phoneFormat(old('phone',(!empty($user->phone))? $user->phone:'' )),['class' => (!empty(old('phone', $user->phone)))? 'noanimlabel': 'animlabel','id'=>'phone', 'placeholder' => t('Phone'), 'required', 'maxlength' => 20, 'autocomplete' => 'phone-add', 'minlength' => 5, 'onkeypress '=> "return isNumber(event)"]) }}
                                 <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                        </div>
                        <div class="pb-20" id="email-jq-err">
                            {{ Form::label(t('Email Address'), t('Email Address'), ['class' => 'position-relative input-label required']) }}

                            <span>{{ Form::email('email', old('email',(!empty($user->email)) ? $user->email :'' ), ['class' => 'animlabel', 'required', 'disabled' => 'disabled', 'placeholder' => t('Email Address')]) }}</span>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <div class="pb-20" id="website-row">
                            {{ Form::label(t('Website'), t('Website'), ['class' => 'position-relative input-label required']) }}

                            <span>{{ Form::text('website_url', old('website_url',(!empty($profile->website_url)) ? $profile->website_url :'' ) , ['class' => 'animlabel', 'placeholder' => t('Website'), 'required']) }}</span>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <div class="pb-20" id="country-jq-err">
                            {{ Form::label(t('Country'), t('Country'), ['class' => 'position-relative input-label required']) }}
                            <?php   
                                if(old('country') !== null) { 
                                    $country_option = old('country'); 
                                } 
                                else {
                                    $country_option = isset($user->country_code) ? $user->country_code : '';
                                }
                            ?>
                            <select id="countryid" name="country" class="form-control form-select2 country-auto-search" required {{ $disabled }}>
                                <option value="" {{ (!old('country') or old('country')=='' or $country_option == '') ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
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
                        </div>
                        <!-- Start Preferred Language -->
                        <?php $languagesArr = config('languages'); ?>
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
                        <!-- End Preferred Language -->
                        <div class="pb-20" id="city-jq-err">
                            {{ Form::label(t('City'), t('City'), ['class' => 'position-relative input-label required']) }}
                            <?php /*                            <!-- commented city code -->
                            // if(old('city') !== null) { 
                            //     $city_option = old('city'); 
                            // } 
                            // else {
                            //     $city_option = isset($user->profile->city) ? $user->profile->city : '0';
                            // }
                            <!-- <select name="city" id="city" class="form-control form-select2 city-auto-search" required>
                                <option value="0" {{ (!old('city') or old('city')==0 or $city_option == 0) ? 'selected="selected"' : '' }}>
                                {{ t('Select a city') }}
                                </option>
                            </select>
                            <input type="hidden" name="city_name" id='city_name'> -->
                            */ ?>
                            <span>{{ Form::text('city', old('city',(!empty($user->profile->city)) ? $user->profile->city :'' ) , ['class' => 'animlabel', 'placeholder' => t('City'), 'required', 'id' => 'pac-input']) }}</span>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <input type="hidden" name="geo_state" value="{{ old('geo_state', $user->profile->geo_state) }}" id="geo_state">
                        <div class="pb-20" id="street-row">
                            {{ Form::label(t('Street'), t('Street'), ['class' => 'position-relative input-label required']) }}
                            <span>{{ Form::text('street', old('street',(!empty($profile->street)) ? $profile->street :'' ) , ['class' => 'animlabel', 'placeholder' => t('Street'), 'required', 'id'=>'street', 'autocomplete' => 'street-add']) }}</span>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <div class="pb-20" id="zip-jq-err">
                            {{ Form::label(t('Zip'), t('Zip'), ['class' => 'position-relative input-label required']) }}
                            <span>{{ Form::text('zip', old('zip',(!empty($profile->zip)) ? $profile->zip :'' ), ['class' => 'animlabel', 'placeholder' => t('Zip'), 'required', 'id' => 'postcode', 'autocomplete' => 'zip-add']) }}</span>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="pb-20">
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

                    <div class="pb-10 mb-20  bb-light-lavender3 timeformat-div">
                        <!-- Start Available times to contact you Section -->
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
                        <!-- blanck space -->
                        <div class="mb-20"></div>
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
            {{ Form::close() }}
        </div>
    </div>

    <div id="uploadimageModal" class="modal crop-img-div" role="dialog" style="margin-top: inherit;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body1">
                    <span class="bold f-20 lh-28 text-center px-38 pt-20">{{ t('Upload and Crop Image') }}</span>
                    <!-- <h2 class="text-center prata px-38 pt-20">{{ t('Upload and Crop Image') }}</h2> -->
                    <div class="position-relative">
                        <div class="divider mx-auto"></div>
                    </div>
                    <div class="form-group mb-10">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="clearfix">
                                    <a class="rotate rotate-right pull-right"><i class="fa fa-repeat fa-lg" aria-hidden="true"></i></a>
                                    <a class="rotate rotate-left pull-right"><i class="fa fa-undo fa-lg" aria-hidden="true"></i></a>
                                </div>
                                <div id="image_demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-white no-bg mb-20 mr-20" data-dismiss="modal">{{ t('Cancel') }}</button>
                        <button name="create" type="button" class="btn btn-success crop_image  no-bg mb-20">{{ t('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('after_styles')
    <link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
    <link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/zoom.css') }}" />
    <style type="text/css">
        .simditor { 
            width: 100% !important;
        }
        .simditor .simditor-toolbar {
            width: 100% !important;
        }

        .rotate {
            padding: 5px;
        }

        #image_demo {
            width: 300px;
            padding: 0 !important;
        }

        .croppie-container .cr-slider-wrap {
            width: 100%;        
        }

        .modal-body1 {
            padding-left: 100px;
            padding-right: 100px;
        }

        .modal-dialog {
            width: 500px;
            margin: 1rem auto;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                width: 360px;
                margin: 0.5rem auto;
            }
            .modal-body1 {
                padding-left: 30px;
                padding-right: 30px;
            }
            #image_demo {
                width: 300px;
            }
        }

        @media (max-width: 360px) {
            .modal-dialog {
                width: 310px;
                margin: 0.5rem auto;
            }
            #image_demo {
                width: 250px;
            }
            .btn.no-bg {
                padding: 0 24px !important;
            }
        }

    </style>

    <style>
        .partnerprofileLogo { vertical-align: middle; border-style: none; width: 200px; height: auto; }
    </style>

@endsection

@section('after_scripts')
   
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>
    <!-- Place Auto Complete start -->
    {{ Html::script(config('app.cloud_url').'/assets/js/place-autocomplete.js') }}
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googlemaps.key')}}&libraries=places"></script>
    <!-- Place Auto Complete End -->
    <script> 
        // Start Google AutoComplate Place cities
        var autocomplete;
        var input = document.getElementById('pac-input');
        var options = { types: ['(cities)'] };
        autocomplete = new google.maps.places.Autocomplete(input, options);

        // $('#countryid').bind('change', function(e){
        //     $('#pac-input').removeClass('border-bottom-error');
        //     var code = $("#countryid option:selected").val();
        //     $('#pac-input').val('');
        //     initMapRegister();
        // });

        $('#user_email').attr('disabled','disabled');
        // commented city code start
        // getCityByCountryCode(code);
        var countryname = $("#countryid option:selected").text();
        if(countryname != "" && countryname != null && countryname != undefined){
            $('#country_name').val(countryname);
        }
        $('#countryid').bind('change', function(e){
            $('#pac-input').removeClass('border-bottom-error');
           // var code = $("#country option:selected").val();
            var countryname = $("#countryid option:selected").text();
            $('#country_name').val(countryname);
            // getCityByCountryCode(code);
            var code = $("#countryid option:selected").val();
            $('#pac-input').val('');
            $('#street').val('');
            $('#geo_state').val('');
            $('#postcode').val('');
            initMapRegister();
            // getTimeZone();
        });

        var code = $("#countryid option:selected").val();

        if(code){
           initMapRegister();
        }

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
        // End Google AutoComplate Place cities

        $(document).ready(function(){

            // getTimeZone();

            if($('#pac-input').val() == ''){

                $('#is_place_select').val('');
            }

            if($('#is_place_select').val()){

                $('#pac-input').removeClass('border-bottom-error');
            }
            $('#partner-profile-save').submit(function(event) {

                $('#pac-input').removeClass('border-bottom-error');
                // if cities empty, form submit true
                if($('#pac-input').val() == "" || $('#is_place_select').val() != 1){
                    
                    $('#pac-input').addClass('border-bottom-error');

                    $('html, body').animate({
                        scrollTop: $("#website-row").offset().top
                    }, 1000, function() {
                        $("#partner-profile-save [name='city']").focus();
                    });
                    return false;
                }

                return true;
            });
        });
        (function() {
            $(function() {
                var $preview, editor, mobileToolbar, toolbar, allowedTags;
                Simditor.locale = 'en-US';
                toolbar = ['bold','italic','underline','fontScale','|','ol','ul','blockquote','table','link'];
                mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
                if (mobilecheck()) {
                    toolbar = mobileToolbar;
                }
                allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
                editor = new Simditor({
                    textarea: $('#pageContent'),
                    //placeholder: 'Describe what makes your ad unique...',
                    toolbar: toolbar,
                    pasteImage: false,
                    defaultImage: '{{ url(config('app.cloud_url').'/assets/plugins/simditor/images/image.png') }}',
                    upload: false,
                    allowedTags: allowedTags
                });
                $preview = $('#preview');
                if ($preview.length > 0) {
                    return editor.on('valuechanged', function(e) {
                        return $preview.html(editor.getValue());
                    });
                }
            });
        }).call(this);
    </script>
   <script>
    // get city of selected country on refresh
    // var code = $("#countryid option:selected").val();
    // $('#user_email').attr('disabled','disabled');
    // // commented city code start
    // // getCityByCountryCode(code);
    // var countryname = $("#countryid option:selected").text();
    //     if(countryname != "" && countryname != null && countryname != undefined){
    //         $('#country_name').val(countryname);
    //     }
    // $('#countryid').bind('change', function(e){
    //        // var code = $("#country option:selected").val();
    //         var countryname = $("#countryid option:selected").text();
    //          $('#country_name').val(countryname);
    //        // getCityByCountryCode(code);
    //     });

    //      $('#city').bind('change', function(e){
    //        var cityname = $("#city option:selected").text();
    //        $('#city_name').val(cityname);
    //     });
    // commented city code ends
    // $('#country').attr("disabled", true);
    // $('#city').attr("disabled", true);

    // commented city code starts
    // function getCityByCountryCode(code){

    //     var siteUrl =  window.location.origin;
    //     if (typeof code !== 'undefined' && code != "" && code != null ) {
    //         var url = "/ajax/citiesByCode/"+code;
    //             $.ajax({
    //             method: "GET",
    //             url: siteUrl + url,
    //             beforeSend: function(){
    //                 $(".loading-process").show();
    //             },
    //             complete: function(){
    //                 $(".loading-process").hide();
    //             },
    //         }).done(function(e) {
    //             $("#city").empty().append(e);

    //             // selected city
    //             if('<?php //echo old('city') !== null ?>') {
    //                 selected_city = '<?php //echo old('city') ?>';
    //             } else{
    //                 var selected_city = '<?php //echo $user->profile->city; ?>';
    //             }
    //             if(selected_city != '' && selected_city != undefined && selected_city != null ){$('#city option[value="'+selected_city+'"]').attr("selected", "selected");
    //             }
    //         });
    //     }
    // }  
    // commented city code ends
      var loadCoverFile = function(event) {
        // var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
        // var fileSize = Math.round((event.target.files[0].size / 1024));
        // var filename = event.target.files[0].name;

        // if(fileSize > imageSize){
        //     $('#error-profile-cover').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
        //     return false;
        // }else{
        //     $('#error-profile-cover').html('');
        // }
        $('#error-profile-cover').html('');
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('output-partner-cover');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
      };

      // var loadLogoFile = function(event) {

      //   // var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
      //   // var fileSize = Math.round((event.target.files[0].size / 1024));
      //   // var filename = event.target.files[0].name;
        
      //   // if(fileSize > imageSize){
      //   //     $('#error-profile-logo').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
      //   //     return false;
      //   // }else{
      //   //     $('#error-profile-logo').html('');
      //   // }
      //   $('#error-profile-logo').html('');
      //   var reader = new FileReader();
      //   reader.onload = function(){
      //     var output = document.getElementById('output-partner-logo');
      //     output.src = reader.result;
      //   };
      //   reader.readAsDataURL(event.target.files[0]);
      // };

        $('#partner-profile-save').submit(function(event) {
            
            var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

            // profile logo validate
            // var partnerprofileLogo = document.getElementById('partnerprofileLogo');
            // if(partnerprofileLogo.files.length > 0) { 
                
            //     var logoImageType = partnerprofileLogo.files[0].type.toLowerCase();
            //     var logoImageSize = partnerprofileLogo.files[0].size;
            //     var logoFileSize = Math.round((logoImageSize / 1024));
            //     var logoExtension = logoImageType.split('/');

            //     //check image extension  
            //     if($.inArray(logoExtension[1], ['gif','png','jpg','jpeg']) == -1) {
            //        $('#error-profile-logo').html('{{ t("invalid_image_type") }} ').css("color", "red");
            //         return false;   
            //     }

            //     // filem size check
            //     if(logoFileSize > maxUploadImageSize){

            //         $('#error-profile-logo').html('{{ t("File") }} "'+partnerprofileLogo.files[0].name+'" ('+logoFileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");
            //         return false;
            //     }
            // }

            // profile cover photo validate
            var partnerprofileCover = document.getElementById('partnerprofileCover');
            if(partnerprofileCover.files.length > 0) { 
                var imageType = partnerprofileCover.files[0].type.toLowerCase();
                var imageSize = partnerprofileCover.files[0].size;
                var fileSize = Math.round((imageSize / 1024));
                var extension = imageType.split('/');

                //check image extension  
                if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                   $('#error-profile-cover').html('{{ t("invalid_image_type") }} ').css("color", "red");
                    return false;   
                }

                // filem size check
                if(fileSize > maxUploadImageSize){

                    $('#error-profile-cover').html('{{ t("File") }} "'+partnerprofileCover.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                    return false;
                }
            }
            return true;
        });

        // start crop image functionalities
        $(document).ready(function($){

            $.noConflict();

            // profile picture input reset after upload image or close popup
            $('#uploadimageModal').on('hide.bs.modal', function(){
                
                if ($('#upload_image').length > 0) {
                    
                    $('#upload_image').val("");
                }
                scrollLock.enablePageScroll(document.getElementById('uploadimageModal'));
            });

            var viewportWidth = 300;
            var viewport = $(window).width();

            if (viewport <  370) {
                
                viewportWidth = 250;
            }
            
            // $("#success-profile-logo").hide();
            $("#error-profile-logo").hide();

            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                  width:200,
                  height:200,
                  type:'square' //circle
                },
                boundary:{
                  width:viewportWidth,
                  height:300
                },
                enableOrientation: true
            });

            // default profile picture extention
            var imageType = 'png';

            // change event profile logo input
            $('#upload_image').on('change', function(){

                // $("#success-profile-logo").hide();
                $("#error-profile-logo").show();
                
                // get curent selected image
                var partnerprofileLogo = document.getElementById('upload_image');
                
                // get maxupload image size
                var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";

                // profile logo validate
                if(partnerprofileLogo.files.length > 0) { 
                    
                    var logoImageType = partnerprofileLogo.files[0].type.toLowerCase();
                    var logoImageSize = partnerprofileLogo.files[0].size;
                    var logoFileSize = Math.round((logoImageSize / 1024));
                    var logoExtension = logoImageType.split('/');

                    //check image extension  
                    if($.inArray(logoExtension[1], ['gif','png','jpg','jpeg']) == -1) {

                        $('#error-profile-logo').html('{{ t("The profile picture must be a file of type: jpg, jpeg, gif, png") }} ').css("color", "red");
                        return false;   
                    }

                    // file size check
                    if(logoFileSize > maxUploadImageSize){

                        $('#error-profile-logo').html('{{ t("File") }} "'+partnerprofileLogo.files[0].name+'" ('+logoFileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");
                        return false;
                    }
                }else{

                    $('#error-profile-logo').html('{{ t("uploaded image is corrupted") }} ').css("color", "red");
                    return false;
                }
            
                var reader = new FileReader();
                
                reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                  }).then(function(){
                    // console.log('jQuery bind complete');
                  });
                }

                reader.readAsDataURL(this.files[0]);

                // get image type string
                imageType = this.files[0].type.toLowerCase();

                // split image type string to array
                imageTypeArr = imageType.split('/');

                // image type
                imageType = imageTypeArr[1];

                // open model image croping
                $('#uploadimageModal').modal('show');
                scrollLock.disablePageScroll(document.getElementById('uploadimageModal'));

            });

            $('.rotate').click(function(event){
                var degree = 90;
                if($(this).hasClass("rotate-right")) {
                    degree = -90;
                }
                $image_crop.croppie('rotate', degree);
            });

            // crop image save
            $('.crop_image').click(function(event){
                
                $image_crop.croppie('result', {
                  type: 'canvas',
                  // size: 'viewport',
                  size : { width: 600, height: 600 },
                  format : imageType,
                }).then(function(response){
                  
                    $.ajax({
                    
                        url: '<?php echo lurl('/'); ?>' + "/cropProfileImage",
                        type: "POST",
                        data:{"image": response, "user_id": '<?php echo Auth::user()->id; ?>'},
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success:function(data){ 
                            
                            $('#uploadimageModal').modal('hide');
                            $('#uploaded_image').html(data.html);
                            
                            if(data.success == true){

                                $("#error-profile-logo").hide();
                                // $("#success-profile-logo").show();
                                // $("#success-profile-logo").html(data.message).css("color", "green");;
                            }else{

                                // $("#success-profile-logo").hide();
                                $("#error-profile-logo").show();
                                $("#error-profile-logo").html(data.message).css("color", "red");;
                            }
                        }
                    });
                })
            });

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
                            
                            if($(requiredField).attr('name') === "website_url"){
                                $('#website-row').find('.error-text-safari').css('display','block');
                            }else if($(requiredField).attr('name') === "street"){
                                $('#street-row').find('.error-text-safari').css('display','block');
                            }else{
                                var err_f = $(requiredField).attr('name')+'-jq-err';
                                $('#'+err_f).find('.error-text-safari').css('display','block');
                            }
                        }

                        is_validation_true = false;

                        return false;
                    }

                });

                if(isFirefox || isSafari){

                    if($('#pageContent').val() == ""){
                        $('#description-jq-err').find('.error-text-safari').css('display','block');
                        is_validation_true = false;
                        return false;
                    }

                }
                    if(is_validation_true){
                        $('#partner-profile-save').submit();
                    }   
            });
        });
        // End crop image functionalities
    </script>
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
{{ Html::script(config('app.cloud_url').'/js/bladeJs/getTimeZoneByCountryCode-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/added-time-format.js') }}
@endsection
 