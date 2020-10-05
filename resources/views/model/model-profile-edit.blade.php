@extends('layouts.logged_in.app-model')

@section('content')
<style type="text/css">
    /*#reference_date span.select2.select2-container.select2-container--default{width: 33% !important;padding-right: 10px !important; }*/
    .select2-container--default{
        width: 100% !important;
    }
    span.select2-container--open {z-index: 99999 !important;}
</style>
<div class="container px-0 pt-40 pb-60 w-xl-1220">
    <h1 class="text-center prata">{{ t('My profile')}}</h1>
    <div class="position-relative">
        <div class="divider mx-auto"></div>
        <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{ t('Your username, name, bio and links appear on your model profile')}} {{ t('Your real name, email address and other contact details remaining private') }}</p>
        <div class="text-center mb-30"><a href="{{ lurl(trans('routes.user').'/'.Auth::user()->username) }}" class="btn btn-default insight mini-mobile">{{ t('View')}}</a></div>
    </div>
    <?php /* @include('flash::message') */ ?>
    <div class="w-xl-1220 mx-auto">
        @if($user->is_profile_completed == 0)
            <p class="text-center mb-30 mx-lg-auto notes-zone">{{ t('profile information update warning msg') }}</p>
        @endif
        @include('childs.notification-message')
    </div>
    <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
        
        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pb-40 px-20 px-xl-0 text-center">
                <div class="prog mb-20">
                    <div class="bar position-relative">
                        <div class="prog-bg position-absolute" style="width: {{$profile_complete_percentage}}%"></div>
                        <span class="number box-shadow position-absolute" style="left:  calc({{$profile_complete_percentage}}% - 30px);">{{$profile_complete_percentage}}%</span>
                    </div>
                </div>
                @if(empty($resume))
                <p class="f-15 lh-14 dark-grey2 mb-0">{{ t('improve profile')}}</p>
                @endif
            </div>
        </div>
       
        {{ Form::open(array('url' =>  lurl('/account/profile/update'), 'method' => 'post','files' => true,'id'=>'edit_profile_form','class'=>'edit_profile_form')) }}

        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pt-40 px-38 px-lg-0">

                <?php /* ?>
                <div class="pb-40 mb-40 bb-light-lavender3 ">
                    <h2 class="bold f-18 lh-18">{{ t('Profile Logo') }}</h2>
                    <div class="divider"></div>

                    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                        <div class="pt-40 px-38 px-lg-0">
                            <div class="pb-40 mb-40 d-md-flex">
                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                    
                                    @if($user->profile->logo !== "" && $user->profile->logo !== null && Storage::exists($user->profile->logo))
                                        <img id="output-partner-logo" src="{{ \Storage::url($user->profile->logo) }}" alt="user" width="75%">&nbsp;
                                    @else
                                        <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="user" >
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

                <!--start crop profile image Content-->
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
                                      
                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select new photo') }}                                   <input type="file"  id="upload_image" name="upload_image"  accept="image/x-png,image/jpeg,image/jpg"/></a>
                                      

                                    </div>
                                        <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                </div>
                            </div>
                            <p id="error-profile-logo" class="mb-20 px-10"></p>
                            <?php /*<p id="success-profile-logo" class="mb-20 px-10"></p> */?>
                        </div>
                    </div>
                </div>
                <!--end crop profile image Content -->

                <div class="pb-40 mb-40 bb-light-lavender3 ">
                    <h2 class="bold f-18 lh-18">{{ t('Cover Picture') }}</h2>
                    <div class="divider"></div>

                    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                        <div class="pt-40 px-38 px-lg-0">
                            <div class="pb-40 mb-40 d-md-flex">
                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">

                                    @if($user->profile->cover !== "" && $user->profile->cover !== null && Storage::exists($user->profile->cover))
                                        <img id="output-partner-cover" src="{{ \Storage::url($user->profile->cover) }}" class="" alt="user" width="75%">&nbsp;
                                    @else
                                        <img id="output-partner-cover" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="user" >
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

                <div class="pb-40 mb-40 bb-light-lavender3 ">
                    <h2 class="bold f-18 lh-18">{{ t('Upload your CV') }}</h2>
                    <div class="divider"></div>

                    <div class="w-lg-750 w-xl-970 mx-auto ">
                        <!-- <div class="pt-40 px-38 px-lg-0">
                            <div class="pb-40 mb-40 d-md-flex"> -->
                                
                                <div class="d-md-inline-block">
                                    
                                    <div class="upload-btn-wrapper">
                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20"> {{ t('select file') }}
                                      <input type="file"  id="model_resume" name="resume[filename]" onchange="loadCVFile(event)"  accept=".doc,.docx,.pdf,.txt"/>
                                      </a>
                                    </div>

                                   
                                    <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('resume')]) }}</p>
                                    <p id="error-cv-cover" class="show-selected-resume"></p>
                                    <?php
                                        $resume_file = '';
                                        if (!empty($resume)) {
                                            $resume_file = isset($resume->name) ? $resume->name : '';
                                        }
                                    ?>
                                    @if($resume_file)

                                        @if($resume->filename !== "" && $resume->filename !== null && Storage::exists($resume->filename))
                                            <p class="w-lg-460" id="saved-file">
                                            <a class="text-decoration-underline" href="{{ \Storage::url($resume->filename) }}" target="_blank">{{$resume_file}}  </a> 
                                            <a onclick="delete_resume({{$user->id}})" title="Delete Resume"><i style="color: red" class=" icon-remove-circle"></i>
                                            </a> 
                                        </p>

                                        @else
                                            <p class="w-lg-460" id="saved-file">{{$resume_file}}
                                            <a onclick="delete_resume({{$user->id}})" title="Delete Resume"><i style="color: red" class="  icon-remove-circle"></i></a>
                                            </p>
                                        @endif
                                        <div id="success_delete" style="display: none;" class="alert alert-success"></div>
                                        <div id="fail_delete" style="display: none;" class="alert alert-danger"></div>
                                        


                                    @endif
                                </div>
                           <!--  </div>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-12 pb-40 mb-40 bb-light-lavender3">
                    <div class="col-md-6 pr-0 pl-0" id="gender-jq-err">
                                               
                        {{ Form::label(t('Gender'), t('Gender'), ['class' => 'control-label  input-label required position-relative']) }}

                        <select name="gender" class="form-control" id="gender">
                            @if ($genders->count() > 0)
                                @foreach ($genders as $gender)
                                <option value="{{ $gender->tid }}" {{ ( $user->gender_id == $gender->tid) ? 'selected' : '' }}>{{ t($gender->name) }} </option>
                              @endforeach
                            @endif
                        </select>
                        <p class="help-block gender-error-msg"></p>
                        <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                    </div>
                </div>

                <?php /*
                <?php $parent_categories = array();
                   if (!empty($user->profile->parent_category)) {
                       $parent_categories = explode(',', $user->profile->parent_category);
                    } ?>
                
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18 required">{{t('categories')}}</h2>
                    <div class="divider"></div>


                    <div class="row custom-checkbox">
                        
                        @foreach ($categories as $cat)

                            <?php 
                                
                                $selected_cat = $cat->id;
                                
                                if($cat->translation_of > 0) {
                                    $selected_cat = $cat->parent_id;
                                } 

                                $is_true = in_array($selected_cat , $parent_categories) ? true : false;
                            ?>

                            <div class="col-md-6 col-xl-3 col-sm-12 mb-10">

                                {{ Form::checkbox('categories[]',  $cat->parent_id, $is_true, ['class' => 'checkbox_field', 'id' => 'parent_'.($cat->id)]) }}

                                {{ Form::label('parent_'.($cat->id), $cat->name, ['class' => 'checkbox-label']) }}
                            </div>
                        @endforeach
                    </div>
                     <p class="help-block category-error-msg"></p>
                </div>

                <?php */ ?>
                 
                <div class="pb-40 mb-40 bb-light-lavender3" id="model_categories-jq-err">
                    <h2 class="bold f-18 lh-18 required">{{t('lbl_model_categories')}}</h2>
                    <div class="divider"></div>
                    <div class="row custom-radio">
                        <!-- <div class="col-md-12"> -->
                            <?php
                                $parent_categories = explode(',', $user->profile->category_id);
                                
                            ?>
                            @foreach ($modelCategories as $cat)
                                
                                {{ Form::radio('model_categories',  $cat->parent_id, in_array($cat->parent_id , $parent_categories), ['class' => 'radio_field', 'id' => 'option_'.($loop->index +1)]) }}
                                
                                {{ Form::label('option_'.($loop->index +1), $cat->name, ['class' => 'radio-label col-md-6']) }}
                            @endforeach
                        <!-- </div> -->
                    </div>
                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                    <p class="help-block model-category-error-msg"></p>
                </div>

                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18 required">{{t('Introduction')}}</h2>
                    <div class="divider"></div>

                    <?php /*
                    <div class="input-group">

                        {{ Form::label('go_code', t('go-code'), ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('go_code',  $user->profile->go_code , ['class' => 'noanimlabel' ,'readOnly' => 'readonly','id' => 'go_code']) }}
                        <p class="help-block user-error-msg"></p>
                    </div>

                    <div class="input-group">

                        {{ Form::label('username', t('Username'), ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('username',  $user->username , ['class' => 'noanimlabel' ,'readOnly' => 'readonly','id' => 'username']) }}
                         <p class="help-block user-error-msg"></p>
                    </div>
                    <div class="input-group">

                        {{ Form::label('first_name', t('First Name'), ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('first_name',  old('first_name', (!empty($user->profile->first_name))? $user->profile->first_name:'' ),['class' => (!empty(old('first_name', $user->profile->first_name)))? 'noanimlabel': 'animlabel' ,'id' => 'first_name','required']) }}
                         <p class="help-block user-error-msg"></p>
                    </div>
                    <div class="input-group">

                        {{ Form::label('last_name', t('Last name'), ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('last_name',  old('last_name', (!empty($user->profile->last_name))? $user->profile->last_name:'' ),['class' => (!empty(old('last_name', $user->profile->last_name)))? 'noanimlabel': 'animlabel','id' => 'last_name','required']) }}
                         <p class="help-block user-error-msg"></p>
                    </div>
                    <div class="input-group">
                        
                        {{ Form::label('street', t('Street'), ['class' => 'position-relative required control-label input-label']) }}
                        
                        {{ Form::text('street', old('street',(!empty($user->profile->street))?$user->profile->street :'' ),['class' => (!empty(old('street', $user->profile->street)))? 'noanimlabel': 'animlabel','id'=>'address_1','required']) }}
                    </div>
                    
                    <div class="input-group">

                        {{ Form::label('postcode',  t('postcode') , ['class' => 'position-relative required control-label input-label']) }}

                        {{ Form::text('zip', old('zip',(!empty($user->profile->zip))? $user->profile->zip:''),['class' => (!empty(old('postcode', $user->profile->zip)))? 'noanimlabel': 'animlabel','id'=>'postcode','required']) }}
                     </div>
                     <div class="row input-group">
                        <div class="col-md-6">
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
                            <select id="phone_code" name="phone_code" class="form-control form-select2 phone-code-auto-search" required>
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
                        </div>
                        <div class="col-md-6">
                            {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative input-label required']) }}
                            
                            {{ Form::text('phone', phoneFormat(old('phone',(!empty($user->phone))? $user->phone:'' )),['class' => (!empty(old('phone', $user->phone)))? 'noanimlabel': 'animlabel','id'=>'phone', 'placeholder' => t('Phone'), 'required', 'maxlength' => '10', 'minlength' => '10', 'onkeypress '=> "return isNumber(event)"]) }}
                        </div>
                    </div>
                    <div class="row input-group">
                        <div class="col-md-6">

                            {{ Form::label(t('Select a country'), t('Select a country'), ['class' => 'control-label input-label required position-relative']) }} 
                            <?php

                                if( old('country') !== null) { 
                                    $country_option = old('country'); 
                                } 
                                else {
                                    
                                    $country_option = isset($user->country_code) ? $user->country_code : '';
                                }
                            ?>
                            <select id="country" name="country" class="form-control form-select2 country-auto-search" required="required">
                                @foreach ($countries as $item)
                                    <option value="{{ $item->get('code') }}" {{ $country_option == $item->get('code') ? 'selected="selected"' : '' }} >{{ $item->get('name') }}</option>
                                @endforeach
                            </select>
                             <input type="hidden" name="country_name" id='country_name'>
                            <p class="help-block country-error-msg"></p>
                        </div>
                        <div class="col-md-6"> 
                            {{ Form::label(t('City'), t('City'), ['class' => 'control-label  input-label required position-relative']) }}

                            {{ Form::text('city', old('city',(!empty($user->profile->city))?$user->profile->city :'' ),['class' => (!empty(old('city', $user->profile->city)))? 'noanimlabel': 'animlabel','id'=>'city','required']) }}
                            <p class="help-block city-error-msg"></p>
                        </div>
                    </div>

                    
                    <div class="row input-group">
                        <div class="col-md-6">
                            {{ Form::label('geburtstag' , t('Birthday'), ['class' => 'control-label input-label position-relative required']) }}
                            
                            {{ Form::text('geburtstag', old('geburtstag',(!empty($birth_day))? $birth_day :'' ),['class' =>(!empty(old('geburtstag', $user->profile->birth_day)))? 'noanimlabel': 'animlabel','id' => 'birth_day','required','readonly' => true]) }}
                            <p class="help-block birthdate-error-msg"></p>
                            <!-- {{ Form::select('geburtstag', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }} -->
                             <input type="hidden" name="age" value="" id="user_age">
                        </div>

                         <?php

                            // $gender_option = $errors->has('gender') ? '' : $user->gender_id;
                        ?>

                        <div class="col-md-6">
                                   
                            {{ Form::label(t('Gender'), t('Gender'), ['class' => 'control-label  input-label required position-relative']) }}

                            <select name="gender" class="form-control" id="gender">
                                 

                                @if ($genders->count() > 0)
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender->tid }}" {{ ( $user->gender_id == $gender->tid) ? 'selected' : '' }}>{{ t($gender->name) }} </option>
                                  @endforeach
                                @endif

                            </select>

                            <p class="help-block gender-error-msg"></p>
                        </div>
                    </div>

                    <div class="row input-group" id="parent-fields">
                        <div class="col-md-6">
                            {{ Form::label(t('fname_parent') , t('fname_parent'), ['class' => 'control-label input-label position-relative required']) }}

                            {{ Form::text('fname_parent', old('fname_parent',(!empty($user->profile->fname_parent))? $user->profile->fname_parent:'' ),['class' =>(!empty(old('fname_parent', $user->profile->fname_parent)))? 'noanimlabel': 'animlabel','id' => 'fname_parent']) }}

                            <p class="help-block fname_parent-error-msg"></p>
                           
                        </div>
                        <div class="col-md-6">
                                   
                           {{ Form::label(t('lname_parent') , t('lname_parent'), ['class' => 'control-label input-label position-relative required']) }}

                            {{ Form::text('lname_parent', old('lname_parent',(!empty($user->profile->lname_parent))? $user->profile->lname_parent:'' ),['class' =>(!empty(old('lname_parent', $user->profile->lname_parent)))? 'noanimlabel': 'animlabel','id' => 'lname_parent']) }}

                            <p class="help-block lname_parent-error-msg"></p>
                        </div>
                    </div>

                    <?php */ ?>

                    <!-- <input type="hidden" name="gender" id="gender" value="{{ $user->gender_id }}"> -->
                    <input type="hidden" name="country_code" id="country" value="{{ $user->country_code }}">
                    <div class="input-group" id="description-jq-err">

                        {{-- Form::label('description', t('Introduction'), ['class' => 'position-relative input-label required']) --}}

                        {{ Form::textarea('description', stripslashes($user->profile->description), ['class' => 'animlabel textarea-description', 'id' => 'pageContent']) }}
                        <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                    </div>
                </div>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Personal Information')}}</h2>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-20" id="height-jq-err">

                            {{ Form::label('height' , t('Height'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('height') !== null) { 
                                    $height_option = old('height'); 
                                } 
                                else {
                                    $height_option = isset($user->profile->height_id) ? $user->profile->height_id : '';
                                }
                            ?>

                            <input type="hidden" id="height_selected" value="{{ $height_option }}">
                            
                            <select name="height" id="height" class="form-control form-select2" required></select>
                            
                            <?php /*
                                <select name="height" id="height" class="form-control" required="required">
                                    <!-- <option value="">{{ t('Select height') }}</option> -->
                                  <?php foreach ($properties['height'] as $key => $cat) {?>
                                    <option value="<?=$key?>"  {{ ($user->profile->height_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                <?php }?>
                                </select>
                            */?>
                            
                             
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block height-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="weight-jq-err">

                            {{ Form::label('weight' ,  t('Weight'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('weight') !== null) { 
                                    $weight_option = old('weight'); 
                                } 
                                else {
                                    $weight_option = isset($user->profile->weight_id) ? $user->profile->weight_id : '';
                                }
                            ?>
                            
                            <input type="hidden" id="weight_selected" value="{{ $weight_option }}">

                            <select name="weight" id="weight" class="form-control" required="required"></select>
                            
                            <?php /*
                                
                                <select name="weight" id="weight" class="form-control" required="required">
                                <!-- <option value="">{{ t('Select weight') }}</option> -->
                                <?php foreach ($properties['weight'] as $key => $cat) {?>
                                    <option value="<?=$key?>"  {{ ($user->profile->weight_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                <?php }?>
                            </select>
                            */?>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block weight-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="cloth_size-jq-err">

                            {{ Form::label('cloth_size' , t('Clothes Size'), ['class' => 'control-label  select-label position-relative required']) }}

                            <?php   
                                if(old('cloth_size') !== null) { 
                                    $dressSize_option = old('cloth_size'); 
                                } 
                                else {
                                    $dressSize_option = isset($user->profile->size_id) ? $user->profile->size_id : '';
                                }
                            ?>

                            <input type="hidden" id="dressSize_selected" value="{{ $dressSize_option }}">
                            
                            <select name="cloth_size" id="cloth_size" class="form-control" required="required"></select>

                            <?php /*
                                <select name="cloth_size" id="cloth_size" class="form-control" required="required">
                                   <!-- <option value="">{{ t('Select dress size') }}</option> -->
                                    <?php foreach ($properties['dress_size'] as $key => $cat) {?>
                                    <option value="<?=$key?>"  {{ ($user->profile->size_id == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                    <?php }?>
                                </select>
                            */?>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block cloth-error-msg"></p>
                        </div>
                        <!-- old field chest -->
                        <?php /*
                        <div class="col-md-6 form-group mb-20">

                            {{ Form::label('breast' , t('Breast'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('breast') !== null) { 
                                    $breast_option = old('breast'); 
                                } 
                                else {
                                    $breast_option = isset($user->profile->chest_id) ? $user->profile->chest_id : '';
                                }
                            ?>

                            <select name="breast" id="breast" class="form-control" required="required">
                                <option value="">{{ t('Select chest') }}</option>
                                @foreach($properties['chest'] as $key => $chestFrom)
                                    <option value="{{ $chestFrom }}" {{ ($breast_option == $key) ? 'selected' : '' }}>{{ $chestFrom }}</option>
                                @endforeach
                            </select>

                            <p class="help-block breast-error-msg"></p>
                        </div>
                        
                        <!-- end old field chest -->
                        <?php */ ?>
                        
                        <!-- new field chest -->
                        <div class="col-md-6 form-group mb-20" id="breast-jq-err">

                            {{ Form::label('breast' , t('Breast'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('breast') !== null) { 
                                    $breast_option = old('breast'); 
                                } 
                                else {
                                    $breast_option = isset($user->profile->chest_id) ? $user->profile->chest_id : '';
                                }
                            ?>

                            <input type="hidden" id="chestSize_selected" value="{{ $breast_option }}">

                            <select name="breast" id="chest_size" class="form-control" required="required"></select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block chest-error-msg"></p>
                        </div>
                        <!-- end new field chest -->
                        
    
                        <?php /*
                        <!-- old field waist -->
                        
                        <div class="col-md-6 form-group mb-20">
                            
                            {{ Form::label('Waist' , t('Waist'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('waist') !== null) { 
                                    $waist_option = old('waist'); 
                                } 
                                else {
                                    $waist_option = isset($user->profile->waist_id) ? $user->profile->waist_id : '';
                                }
                            ?>

                            <select name="waist" id="waist" class="form-control" required="required">
                                <option value="">{{  t('Select waist')}}</option>
                                @foreach($properties['waist'] as $key => $waistFrom)
                                    <option value="{{ $waistFrom }}" {{ ($waist_option == $key) ? 'selected' : '' }}>{{ $waistFrom }}</option>
                                @endforeach
                            </select>
                            <p class="help-block breast-error-msg"></p>
                        </div>
                        
                        <!-- end old field waist -->
                        <?php */ ?>
                        
                        <!-- new field waist -->
                        <div class="col-md-6 form-group mb-20" id="waist-jq-err">

                            {{ Form::label('Waist' , t('Waist'), ['class' => 'control-label select-label position-relative']) }}

                            <?php   
                                if(old('waist') !== null) { 
                                    $waist_option = old('waist'); 
                                } 
                                else {
                                    $waist_option = isset($user->profile->waist_id) ? $user->profile->waist_id : '';
                                }
                            ?>

                            <input type="hidden" id="waistSize_selected" value="{{ $waist_option }}">

                            <select name="waist" id="waist_size" class="form-control"></select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block waist-error-msg"></p>
                        </div>
                        <!-- end new field waist  -->
                        

                         <?php /*
                        <!-- old field hips -->
                       
                        <div class="col-md-6 form-group mb-20">

                            {{ Form::label('hip' , t('Hips'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('hip') !== null) { 
                                    $hip_option = old('hip'); 
                                } 
                                else {
                                    $hip_option = isset($user->profile->hips_id) ? $user->profile->hips_id : '';
                                }
                            ?>

                            <select name="hip" id="hip" class="form-control" required="required">
                                <option value="">{{  t('Select hips')}}</option>
                                @foreach($properties['hips'] as $key => $hipsFrom)
                                    <option value="{{ $hipsFrom }}" {{ ($hip_option == $key) ? 'selected' : '' }}>{{ $hipsFrom }}</option>
                                @endforeach
                            </select>

                            <p class="help-block hips-error-msg"></p>
                        </div>
                        
                        <!-- end old field hips -->
                        <?php */ ?>
                        
                        <!-- new field hips -->
                        <div class="col-md-6 form-group mb-20" id="hip-jq-err">

                            {{ Form::label('hip' , t('Hips'), ['class' => 'control-label select-label position-relative']) }}

                            <?php   
                                if(old('hip') !== null) { 
                                    $hip_option = old('hip'); 
                                } 
                                else {
                                    $hip_option = isset($user->profile->hips_id) ? $user->profile->hips_id : '';
                                }
                            ?>

                            <input type="hidden" id="hipsSize_selected" value="{{ $hip_option }}">

                            <select name="hip" id="hips_size" class="form-control"></select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block hips-error-msg"></p>
                        </div>
                        <!-- end new field hips -->
                        

                        <div class="col-md-6 form-group mb-20" id="shoe_size-jq-err">

                            {{ Form::label('shoe_size' , t('Shoe size'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('shoe_size') !== null) { 
                                    $shoeSize_option = old('shoe_size'); 
                                } 
                                else {
                                    $shoeSize_option = isset($user->profile->shoes_size_id) ? $user->profile->shoes_size_id : '';
                                }
                            ?>

                            <input type="hidden" id="shoeSize_selected" value="{{ $shoeSize_option }}">

                            <select name="shoe_size" id="shoe_size" class="form-control" required="required"></select>


                            <?php /*

                                <select name="shoe_size" id="shoe_size" class="form-control" required="required">
                                    <option value="">{{ t('Select shoe size') }}</option>
                                        <?php foreach ($properties['shoe_size'] as $key => $cat) {?>
                                            <option value="<?=$key?>"  {{ ($shoeSize_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                        <?php }?>
                                </select>
                            */ ?>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block shoe-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="eye_color-jq-err">

                            {{ Form::label('eye_color' , t('Eye color'), ['class' => 'control-label  select-label position-relative required']) }}

                            <?php   
                                if(old('eye_color') !== null) { 
                                    $eyeColor_option = old('eye_color'); 
                                } 
                                else {
                                    $eyeColor_option = isset($user->profile->eye_color_id) ? $user->profile->eye_color_id : '';
                                }
                            ?>

                            <select name="eye_color" id="eye_color" class="form-control" required="required">
                                <option value="">{{ t('Select eye color') }}</option> 
                                <?php foreach ($properties['eye_color'] as $key => $cat) {?>
                                <option value="<?=$key?>"  {{ ($eyeColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                <?php }?>
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block eye-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="hair_color-jq-err">

                            {{ Form::label('hair_color' , t('Hair color'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('hair_color') !== null) { 
                                    $hairColor_option = old('hair_color'); 
                                } 
                                else {
                                    $hairColor_option = isset($user->profile->hair_color_id) ? $user->profile->hair_color_id : '';
                                }
                            ?>

                            <select name="hair_color" id="hair_color" class="form-control" required="required">
                                <option value="">{{ t('Select hair color') }}</option>
                                <?php foreach ($properties['hair_color'] as $key => $cat) {?>
                                <option value="<?=$key?>"  {{ ($hairColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                <?php }?>
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block hair-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="skin_color-jq-err">
                            
                            {{ Form::label('skin color' , t('Skin color'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('skin_color') !== null) { 
                                    $skinColor_option = old('skin_color'); 
                                } 
                                else {
                                    $skinColor_option = isset($user->profile->skin_color_id) ? $user->profile->skin_color_id : '';
                                }
                            ?>

                            <select name="skin_color" id="skin_color" class="form-control" required="required">
                                <option value="">{{ t('Select skin color') }}</option>
                                <?php foreach ($properties['skin_color'] as $key => $cat) {?>
                                <option value="<?=$key?>"  {{ ($skinColor_option == $key) ? 'selected' : '' }} ><?=$cat?></option>
                                <?php }?>
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block dress-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="piercing-jq-err">

                            {{ Form::label('piercing' , t('Piercing'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('piercing') !== null) { 
                                    $piercing_option = old('piercing'); 
                                } 
                                else {
                                    $piercing_option = isset($user->profile->piercing) ? $user->profile->piercing : '';
                                }
                            ?>
                           
                            <select name="piercing" id="piercing" class="form-control" required="required">
                                <option value="" >{{t('Choose')}}</option>
                                <option value="1" {{($piercing_option == 1)?'selected':''}}>{{ t('Yes') }}</option>
                                <option value="2" {{($piercing_option == 2)?'selected':''}}>{{ t('No') }}</option>
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block piercing-error-msg"></p>
                        </div>
                        <div class="col-md-6 form-group mb-20" id="tattoo-jq-err">

                            {{ Form::label('tattoo' , t('Tattoo'), ['class' => 'control-label select-label position-relative required']) }}

                            <?php   
                                if(old('tattoo') !== null) { 
                                    $tattoo_option = old('tattoo'); 
                                } 
                                else {
                                    $tattoo_option = isset($user->profile->tattoo) ? $user->profile->tattoo : '';
                                }
                            ?>
                             
                            <select name="tattoo" class="form-control" id="tattoo" required="required">
                                <option value="" >{{t('Choose')}}</option>
                                <option value="1" {{($tattoo_option == 1)?'selected':''}}>{{ t('Yes') }}</option>
                                <option value="2" {{($tattoo_option == 2)?'selected':''}}>{{ t('No') }}</option>
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <p class="help-block tattoo-error-msg"></p>
                        </div>
                    </div>
                </div>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Website & Social Networks')}}</h2>
                    <div class="divider"></div>

                    {{ Form::text('personal_website', !empty($user->profile->website_url)? $user->profile->website_url:'', ['placeholder' => 'Personal website', 'class' => 'mb-30']) }}

                    {{ Form::text('instagram', !empty($user->profile->instagram)? $user->profile->instagram:'', ['placeholder' => 'Instagram', 'class' => 'mb-30']) }}

                    {{ Form::text('instagram_followers_count', !empty($user->profile->instagram_followers_count)? $user->profile->instagram_followers_count:'', ['placeholder' => 'Count of Instagram Followers', 'class' => 'mb-30']) }}

                    {{ Form::text('facebook', !empty($user->profile->facebook)? $user->profile->facebook:'', ['placeholder' => 'Facebook', 'class' => 'mb-30']) }}

                    {{ Form::text('linkedin', !empty($user->profile->linkedin)? $user->profile->linkedin:'', ['placeholder' => 'LinkedIn', 'class' => 'mb-30']) }}

                    {{ Form::text('twitter', !empty($user->profile->twitter)? $user->profile->twitter:'', ['placeholder' => 'Twitter', 'class' => 'mb-30']) }}

                    {{ Form::text('pintrest', !empty($user->profile->pinterest)? $user->profile->pinterest:'', ['placeholder' => 'Pintrest']) }}
                </div>
            </div>    
        </div>

        @include('childs.bottom-bar-save')
    

        {{ Form::close() }}
        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pt-40 px-38 px-lg-0">
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Professional skills')}}</h2>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-between mb-20">
                        {{ Form::text('title', null, ['placeholder' => t('Enter Talent'), 'class' => 'mr-20 skills_value']) }}
                        <button name="create" type="button" class="btn add_new_skill btn-success add_new mini-all h-40"></button>
                    </div>
                    <input type="hidden" name="create" value="create">
                    <div style="display: none; color: red;" id="error-skill">This field is required!</div>
                    <div class="skill-list">
                        <?php
                            if (!empty($talent)) {
	                            foreach ($talent as $key => $tal) {?>
                                    <a href="javascript:void(0);" class="tag extended delete-talent" data-talent-id="{{ $tal['id']}}" style="margin: 2px;">{{$tal['title']}}</a>
                                <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-lg-750 w-xl-970 mx-auto" id="user_language_append">
            <div class="pt-40 px-38 px-lg-0">
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Languages')}}</h2>
                    <div class="divider"></div>
                    <div class="language_list">
                        <?php
                            if (isset($language) && sizeof($language) > 0) {
	                            foreach ($language as $key => $lang) {
		                            if (!empty($lang['language_name']) && isset($language_list[$lang['language_name']])) {
			                            $language_title = trans('language.'.$language_list[$lang['language_name']]);
                                    } 
                                    else {
			                            $language_title = '';
                                    }
                                    $proficiency_level = '';
                                    if (!empty($lang['proficiency_level'])) {
                                        // if ($lang['proficiency_level'] == 'beginner') {
                                        //     $proficiency_level = t("Beginner");
                                        // }
                                        // if ($lang['proficiency_level'] == 'elementary') {
                                        //     $proficiency_level = t("Elementary");
                                        // }
                                        // if ($lang['proficiency_level'] == 'intermediate') {
                                        //     $proficiency_level = t("Intermediate");
                                        // }                                        
                                        // if ($lang['proficiency_level'] == 'upper_intermediate') {
                                        //     $proficiency_level = t("Upper Intermediate");
                                        // }
                                        // if ($lang['proficiency_level'] == 'advanced') {
                                        //     $proficiency_level = t("Advanced");
                                        // }
                                        // if ($lang['proficiency_level'] == 'proficient') {
                                        //     $proficiency_level = t("Proficient");
                                        // }
                                        if ($lang['proficiency_level'] == 'native_language') {
                                            $proficiency_level = t("Native Language");
                                        }
                                        if ($lang['proficiency_level'] == 'basic_knowledge') {
                                            $proficiency_level = t("Basic Knowledge");
                                        }
                                        if ($lang['proficiency_level'] == 'perfect') {
                                            $proficiency_level = t("Perfect");
                                        }                                        
                                        if ($lang['proficiency_level'] == 'advanced') {
                                            $proficiency_level = t("Advanced");
                                        }
                                        
                                    } 
                                    else {
                                        $proficiency_level = '';
                                    }
                                    ?>
                                    <div class="pb-40 mb-40 bb-pale-grey row" id="language_item_{{ $lang['id'] }}">
                                        <div class="col-md-9">
                                            <span class="title">{{$language_title}}</span>
                                            <p class="mb-md-0">{{ $proficiency_level }}</p>
                                            <p class="mb-md-0">  {!! !empty($lang['description']) ? $lang['description'] : '' !!}</p>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-md-end">

                                            <!-- <a data-featherlight="{{-- lurl('account/profile/language/'.$lang['id'].'/edit') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-white edit_grey mr-20 mini-all" ></a> -->

                                            <a href="{{ lurl('account/profile/language/'.$lang['id'].'/edit') }}" class="btn btn-white edit_grey mr-20 mini-all add_new_language" ></a>

                                            <a href="javascript:void(0);" data-language-id="{{ $lang['id'] }}" class="btn btn-white trash_white mini-all delete-language"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="pb-40 mb-40 bb-pale-grey row">
                                    <div class="col-md-12">{{t('There are no languages yet')}}</div>
                                </div>
                            <?php } ?>
                    </div>
                    <div class="d-flex">
                        <!-- <a href="#" data-featherlight="{{-- route('add-language-popup') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-success add_new open_in_popup">{{-- t('Add new') --}}</a> -->
                         <a href="{{ route('add-language-popup') }}"  class="btn btn-success add_new add_new_language">{{t('Add new')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pt-40 px-38 px-lg-0">
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Experience in Model Business')}}</h2>
                    <div class="divider"></div>
                    <div class="experience_list">
                        <?php
                            if (isset($experience) && sizeof($experience) > 0) {
	                            foreach ($experience as $key => $exp) {
		                    ?>
                                <div class="pb-40 mb-40 bb-pale-grey row" id="experience_item_{{ $exp['id'] }}">
                                    <div class="col-md-9"><p>{{$exp['title']}} @ {{$exp['company']}}</p>
                                        <?php
                                            if (isset($exp['up_to_date']) && $exp['up_to_date'] == '1') {
                                            $to_date = t('up to today');
                                            // date('Y-m-d');
                                            } else {
                                                $to_date = date("Y", strtotime($exp['to']));
                                            }
                                        ?>
                                        <p>{{date("Y", strtotime($exp['from']))}} - {{ $to_date }}</p>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-md-end">
                                        <!-- <a data-featherlight="{{-- lurl('account/profile/experience/'.$exp['id'].'/edit') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-white edit_grey mr-20 mini-all"></a> -->

                                        <a href="{{ lurl('account/profile/experience/'.$exp['id'].'/edit') }}" class="btn btn-white edit_grey mr-20 mini-all add_new_experience"></a>

                                        <a data-experience-id="{{ $exp['id'] }}" href="javascript:void(0);"  class="btn btn-white trash_white mini-all delete-experience"></a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else {?>
                            <div class="pb-40 mb-40 bb-pale-grey row">
                                <div class="col-md-12">{{t('There are no experiences yet')}}</div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('add-experience-popup') }}" class="btn btn-success add_new add_new_experience">{{t('Add new')}}</a>
                        <!--<a href="#" data-featherlight="{{-- route('add-experience-popup') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-success add_new add_new_experience">{{-- t('Add new') --}}</a>-->
                    </div>
                </div>
            </div>    
        </div>
        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pt-40 px-38 px-lg-0">
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Experience / Reference')}}</h2>
                    <div class="divider"></div>
                    <div class="reference_list">
                        <?php
                            if (isset($reference) && sizeof($reference) > 0) {
	                            foreach ($reference as $key => $ref) {
		                        ?>
                                    <div class="pb-40 mb-40 bb-pale-grey row" id="reference_item_{{ $ref['id'] }}">
                                        <div class="col-md-9">
                                            <p>{{$ref['title']}}</p>
                                            <p>{{date("Y", strtotime($ref['date']))}}</p>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-md-end">
                                            
                                            <!-- <a data-featherlight="{{-- lurl('account/profile/reference/'.$ref['id'].'/edit') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-white edit_grey mr-20 mini-all"></a> -->

                                            <a href="{{ lurl('account/profile/reference/'.$ref['id'].'/edit') }}" class="btn btn-white edit_grey mr-20 mini-all add_new_reference"></a>

                                            <a data-reference-id="{{ $ref['id'] }}" class="btn btn-white trash_white mini-all delete-reference"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else {?>
                                <div class="pb-40 mb-40 bb-pale-grey row">
                                    <div class="col-md-12">{{t('There are no achievements / references')}}</div>
                                </div>
                        <?php } ?>
                    </div>
                    <div class="d-flex">
                    <a href="{{ route('add-reference-popup') }}" class="btn btn-success add_new add_new_reference">{{t('Add new')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-lg-750 w-xl-970 mx-auto">
            <div class="pt-40 px-38 px-lg-0">       
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Education')}}</h2>
                    <div class="divider"></div>
                    <div class="education_list">
                        <?php
                            if (isset($education) && sizeof($education) > 0) {
	                            foreach ($education as $key => $edu) {
		                        ?>
                                    <div class="pb-40 mb-40 bb-pale-grey row" id="education_item_{{ $edu['id'] }}">
                                        <div class="col-md-9">
                                            <p> {{$edu['title']}}
                                            <span class="bullet rounded-circle bg-lavender d-inline-block mx-2 mb-1"></span>
                                                {{$edu['institute']}}
                                            </p>
                                            <?php
                                                if (isset($edu['up_to_date']) && $edu['up_to_date'] == '1') {
                                                    $to_date = t('up to today');
                                                } else {
                                                    $to_date = date("Y", strtotime($edu['to']));
                                                }
                                            ?>
                                            <p>{{date("Y", strtotime($edu['from']))}} - {{$to_date}}</p>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-md-end">
                                            
                                            <!-- <a data-featherlight="{{-- lurl('account/profile/education/'.$edu['id'].'/edit') --}}" data-featherlight-type="ajax" data-featherlight-persist="true" class="btn btn-white edit_grey mr-20 mini-all"></a> -->

                                            <a href="{{ lurl('account/profile/education/'.$edu['id'].'/edit') }}" class="btn btn-white edit_grey mr-20 mini-all add_new_education"></a>

                                            <a href="javascript:void(0);" data-education-id="{{$edu['id']}}"  class="btn btn-white trash_white mini-all delete-education"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="pb-40 mb-40 bb-pale-grey row">
                                    <div class="col-md-12">{{t('There are no educations yet')}}</div>
                                </div>
                            <?php } ?>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('add-education-popup') }}" class="btn btn-success add_new add_new_education">{{t('Add new')}}</a>
                    </div>
                </div>
            </div>
        </div>
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
                    <button class="btn btn-white no-bg mr-20 mb-20" data-dismiss="modal">{{ t('Cancel') }}</button>
                    <button name="create" type="button" class="btn btn-success crop_image no-bg mb-20">{{ t('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap model --> 
  <div class="modal fade" id="popup-model" data-keyboard="false" data-backdrop="static" role="dialog" style="margin-top: 3%;">
    <div class="modal-dialog modal-lg">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body"></div>
      </div>
    </div>
   </div>
<!-- Bootstrap model -->



    <link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
    <link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/zoom.css') }}" />
    <style type="text/css">
        .simditor { 
            width: 100% !important;
        }
        .simditor .simditor-toolbar {
            width: 100% !important;
        }
    </style>

    <style>
        .partnerprofileLogo { vertical-align: middle; border-style: none; width: 200px; height: auto; }
    </style>
   
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>
    
    <script>
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
                    defaultImage: '{{ url('assets/plugins/simditor/images/image.png') }}',
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
@endsection
@section('page-script')
<style type="text/css">
.input-group > .form-control, .input-group > .custom-select{
    height: 55px;
    line-height: 42px;
}
.file-input .upload_white{
    line-height: 18px !important;
}
.krajee-default .file-footer-caption{
    margin-bottom:0 !important;
}
.krajee-default .file-caption-info, .krajee-default .file-size-info{
    height:20px !important;
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

    #uploadimageModal, #popup-model .modal-dialog {
        width: 500px;
        margin: 1rem auto;
    }

    #freejobs .modal-dialog{
        width: auto;
    }
    
    @media (max-width: 576px) {
        #uploadimageModal, #popup-model .modal-dialog {
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
        #uploadimageModal, #popup-model .modal-dialog {
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
<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
<!-- <link rel="stylesheet" href="{{ url(config('app.cloud_url').'/assets/plugins/datepicker/datepicker.css') }}"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="{{ url(config('app.cloud_url').'/assets/plugins/font-awesome/css/font-awesome.min.css') }}">
@if (config('lang.direction') == 'rtl')
<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
@endif
<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ url(config('app.cloud_url').'/assets/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
@endif

@if(Lang::locale()=='de')
<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker-de.min.js') }}" type="text/javascript"></script>
@else
<script src="{{ url(config('app.cloud_url').'/assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
@endif
<script type="text/javascript">
    var english = '{{t('English')}}';
    var spanish = '{{t('Spanish')}}';
    var french = '{{t('French')}}';
    var german = '{{t('German')}}';
    
    /*var beginner = '{{t('Beginner')}}';
    var elementary = '{{t('Elementary')}}';
    var intermediate = '{{t('Intermediate')}}';
    var upper_intermediate = '{{t('Upper Intermediate')}}';
    var advanced = '{{t('Advanced')}}';
    var proficient = '{{t('Proficient')}}';*/

    var native_language = '{{t('Native Language')}}';
    var basic_knowledge = '{{t('Basic Knowledge')}}';
    var perfect = '{{t('Perfect')}}';
    var advanced = '{{t('Advanced')}}';

    var upto_today = '{{t('up to today')}}';
    var language_msg = '{{t('Please select language')}}';
    var professional_msg = '{{t('Please select Proficiency Level')}}';
    var description_msg = '{{t('Please enter description')}}';
    var title_msg = '{{t('Please enter title')}}';
    var from_date = '{{t('Please select from date')}}';
    var from_to_msg = '{{t('To date must be greater than From date')}}';
    var to_date_msg = '{{t('Please select to date')}}';
    var company_msg = '{{t('Please enter company')}}';
    var date_msg = '{{t('Please select date')}}';
    var institute_msg = '{{t('Please enter institute')}}';
    var required_msg = '{{t('required_field')}}';
    var skill_msg = '{{t('Your skill contains illegal characters')}}';
    var education_success_msg = '{{t('Education added successfully')}}';
    var experience_success_msg = '{{t('Experience added successfully')}}';
    var language_success_msg = '{{t('Language added successfully')}}';
    var reference_success_msg = '{{t('Reference added successfully')}}';
    var error_msg = '{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}';
    function hidepic(){
        $('#profile-photo').attr('style','display:none !important');
    }

    function hidecoverpic(){
        $('#cover-photo').attr('style','display:none !important');
    }

    function Char_Only(name)
    {
        var expr=/[a-zA-Z -()+]+$/;
        return expr.test(name);
    };
    

    $(document).ready( function(){
        // var countryname = $("#country option:selected").text();
        // $('#country_name').val(countryname);
        // commneted city code
        // var code = $("#country option:selected").val();

        // var ajaxUrl = "/ajax/getAjaxUnites/"+code;
        // getUnitMesurment(ajaxUrl);
        // getCityByCountryCode(code);

        getUnitsOnCountryChange();
    });



    // $('#country').bind('change', function(e){
    //     // commneted city code
    //     // var code = $("#country option:selected").val();
    //     var countryname = $("#country option:selected").text();
    //     $('#country_name').val(countryname);

    //     getUnitsOnCountryChange();

    //     // getCityByCountryCode(code);
    // });

    $('input[type=radio][name=model_categories]').change(function() {
        getUnitsOnCountryChange();
    });

    $('#gender').bind('change', function(e){
        getUnitsOnCountryChange();
    });

    function getUnitsOnCountryChange(){

        var url = "/ajax/getAjaxUnites";
        getUnitMesurment(url);
            
        // if (typeof code !== 'undefined' && code != "" && code != null ) {
        //     var url = "/ajax/getAjaxUnites";
        //     getUnitMesurment(url);
        // }
    }

    function getUnitMesurment(url){

        // get selected dropdown value. height, weight, dressSize
        var heightSelected = $("#height_selected").val();
        var weightSelected = $("#weight_selected").val();
        var dressSizeSelected = $("#dressSize_selected").val();
        var shoeSizeSelected = $("#shoeSize_selected").val();

        var waistSizeSelected = $("#waistSize_selected").val();
        var chestSizeSelected = $("#chestSize_selected").val();
        var hipsSizeSelected = $("#hipsSize_selected").val();

        var category_id = $("input[name='model_categories']:checked").val();
        
        var gender = $("#gender option:selected").val();
        var country_code = $("#country").val(); 

        var siteUrl =  window.location.origin;

        data = {
            'allUnits' : 1,
            'category_id' : (category_id != undefined && category_id != null)? category_id : '',
            'gender'  : (gender != undefined && gender != null)? gender : '',
            'country_code' :  (country_code != undefined && country_code != null)? country_code : '',
        };
        
        $.ajax({
            method: "POST",
            url: siteUrl + url,
            data: data,
            beforeSend: function(){
                $(".loading-process").show();
            },
            complete: function(){
                $(".loading-process").hide();
            },
        }).done(function(response) {
            if( response.success == true ){
               heightSelect =  $("#height");
               
                var selectHeightLabel = "<?php echo t('Select height'); ?>";
                
                if(response.data.height != undefined && response.data.height != null){
                    
                    heightSelect.empty();
                    heightSelect.append("<option value=''>"+selectHeightLabel+"</option>");
                    
                    $.each(response.data.height, function (key, val) {

                        // check selected height value
                        if(heightSelected != '' && heightSelected == key){
                            heightSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            heightSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }

                weightSelect =  $("#weight");
                var selectweightLabel = "<?php echo t('Select weight'); ?>";

                if(response.data.weight != undefined && response.data.weight != null){
                    weightSelect.empty();
                    weightSelect.append("<option value=''>"+selectweightLabel+"</option>");
                    $.each(response.data.weight, function (key, val) {

                        // check selected weight value
                        if(weightSelected != '' && weightSelected == key){
                            weightSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            weightSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }


                dressSizeSelect =  $("#cloth_size");
                var selectdressSizeLabel = "<?php echo t('Select dress size'); ?>";

                if(response.data.dress_size != undefined && response.data.dress_size != null){
                    dressSizeSelect.empty();
                    dressSizeSelect.append("<option value=''>"+selectdressSizeLabel+"</option>");
                    $.each(response.data.dress_size, function (key, val) {

                        // check selected dressSize value
                        if(dressSizeSelected != '' && dressSizeSelected == key){
                            dressSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            dressSizeSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }

                shoeSizeSelect =  $("#shoe_size");
                var selectshoeSizeLabel = "<?php echo t('Select shoe size'); ?>";

                if(response.data.shoe_size != undefined && response.data.shoe_size != null){
                    shoeSizeSelect.empty();

                    shoeSizeSelect.append("<option value=''>"+selectshoeSizeLabel+"</option>");
                    $.each(response.data.shoe_size, function (key, val) {

                        // check selected dressSize value
                        if(shoeSizeSelected != '' && shoeSizeSelected == key){
                            shoeSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            shoeSizeSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }

                waistSizeSelect =  $("#waist_size");
                var waistSizeSelectLable = "<?php echo t('Select waist'); ?>";
                if(response.data.waist != undefined && response.data.waist != null){
                    waistSizeSelect.empty();
                    waistSizeSelect.append("<option value=''>"+waistSizeSelectLable+"</option>");
                    $.each(response.data.waist, function (key, val) {

                        // check selected waistSize value
                        if(waistSizeSelected != '' && waistSizeSelected == key){
                            waistSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            waistSizeSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }

                chestSizeSelect =  $("#chest_size");
                var chestSizeSelectLable = "<?php echo t('Select chest'); ?>";
                if(response.data.chest != undefined && response.data.chest != null){
                    chestSizeSelect.empty();
                    chestSizeSelect.append("<option value=''>"+chestSizeSelectLable+"</option>");
                    $.each(response.data.chest, function (key, val) {

                        // check selected chestSize value
                        if(chestSizeSelected != '' && chestSizeSelected == key){
                            chestSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            chestSizeSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }

                hipsSizeSelect =  $("#hips_size");
                var hipsSizeSelectLable = "<?php echo t('Select hips'); ?>";
                if(response.data.hips != undefined && response.data.hips != null){
                    hipsSizeSelect.empty();
                    hipsSizeSelect.append("<option value=''>"+hipsSizeSelectLable+"</option>");
                    $.each(response.data.hips, function (key, val) {

                        // check selected hipsSize value
                        if(hipsSizeSelected != '' && hipsSizeSelected == key){
                            hipsSizeSelect.append($("<option selected></option>").attr("value", key).text(val));
                        }else{
                            hipsSizeSelect.append($("<option></option>").attr("value", key).text(val));
                        }
                    });
                }
            }
        });
    }

    // commneted city code starts
     // $('#city').bind('change', function(e){
     //       var cityname = $("#city option:selected").text();
     //       $('#city_name').val(cityname);
     //    });
     // commneted city code ends



    // $('#country').attr("disabled", true);
    // $('#city').attr("disabled", true);

    // commneted city code starts
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
    //             var cityname = $("#city option:selected").text();
    //             $('#city_name').val(cityname);
    //         });
    //     }
    // }
    // commented city code ends

    $('.file-upload2').on('fileclear', function(event) {
        $('#profile-photo').attr('style','display:flex !important');
    });

    $('.file-upload4').on('fileclear', function(event) {
        $('#cover-photo').attr('style','display:flex !important');
    });

    /* Initialize with defaults (sedcard) */
    $('.btn-upload').fileinput({
        browseLabel:"{{t('select new photo')}}",
        browseClass: 'btn btn-white upload_white upload-picture mb-20 mini-mobile',
        language: '{{ config('app.locale') }}',
        @if (config('lang.direction') == 'rtl')
        rtl: true,
        @endif
        showPreview: true,
        allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
        showUpload: false,
        showRemove: false,
        maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
        fileActionSettings:{
            showZoom: false,
        }
    }).on("fileerror", function (event, files) {
        $("#"+files.id).remove();
    });

    $('.upload-resume').fileinput({
        browseLabel:"{{t('select file')}}",
        browseClass: 'btn btn-white upload_white upload-picture mb-20 mini-mobile',
        language: '{{ config('app.locale') }}',
        @if (config('lang.direction') == 'rtl')
        rtl: true,
        @endif
        showPreview: true,
        allowedFileExtensions: {!! getUploadFileTypes('resume', true) !!},
        showUpload: false,
        showRemove: false,
        maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
        fileActionSettings:{
            showZoom: false,
        }
    }).on("fileerror", function (event, files) {
        $("#"+files.id).remove();
    });

    $('#parent-fields').hide();
    
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

    var loadCoverFile = function(event) {
        $('#error-profile-cover').html('');
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('output-partner-cover');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    // var loadLogoFile = function(event) {
    //     $('#error-profile-logo').html('');
    //     var reader = new FileReader();
    //     reader.onload = function(){
    //       var output = document.getElementById('output-partner-logo');
    //       output.src = reader.result;
    //     };
    //     reader.readAsDataURL(event.target.files[0]);
    // };

    var loadCVFile = function(event) {

        // $('#error-cv-logo').html('');
        // var reader = new FileReader();
        // reader.onload = function(){
        //   var output = document.getElementById('output-partner-logo');
        //   output.src = reader.result;
        // };   
        
        if(event.target.files && event.target.files != undefined && event.target.files != ""){
            $('.show-selected-resume').html(event.target.files[0].name);
        }
    };
    

        $('#edit_profile_form').submit(function(event) {

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

             // resume validate
            var model_resume = document.getElementById('model_resume');
            if(model_resume.files.length > 0) { 


                var imageType = model_resume.files[0].type.toLowerCase();
                var imageSize = model_resume.files[0].size;
                var fileSize = Math.round((imageSize / 1024));
                
                
               if(model_resume.files[0].name != "" && model_resume.files[0].name != undefined){
                    var extension = model_resume.files[0].name.split('.');
               }

                //check file extension  
                if($.inArray(extension[1].toLowerCase(), ['pdf','doc','docx']) == -1) {
                   $('#error-cv-cover').html('{{ t("invalid_resume_type") }} ').css("color", "red");
                    return false;   
                }
            }

            return true;
        });

        $(document).on('click', '.add_new_language, .add_new_experience, .add_new_reference, .add_new_education', function(e){
        // $('.add_new_language').bind('click', function(e){
            e.preventDefault();

            var href = $(this).attr('href');

            $.ajax({
                method: "GET",
                url: href,
                beforeSend: function(){
                    //$(".loading-process").show();
                },
                complete: function(){
                    //$(".loading-process").hide();
                },
                success: function(respnose){

                    if(respnose.status == true){
                        // Add response in Modal body
                        $('.modal-body').html(respnose.html);

                       // Display Modal
                        $('#popup-model').modal('show'); 
                    }
                }
            });
        });

        $(document).on('click', '.no-bg', function(e){
            $('#popup-model').modal('hide'); 
        });
       
        function delete_resume(id)
        {

            var confirmation = confirm("Are you sure you want to perform this action?");
            
            if (confirmation) 
            {
                url = baseurl + "account/profile/resume_delete";
            
                $.ajax({
                    method: "get",
                    url: url,
                    dataType: 'json',
                    beforeSend: function(){
                      $(".loading-process").show();
                    },
                    complete: function(){
                      $(".loading-process").hide();
                    },
                    success: function (data) {

                        if(data.status == true){
                           $("#saved-file").remove();
                           $("#success_delete").show();
                           $("#success_delete").html(data.message);
                           setTimeout(function(){ $("#success_delete").hide();}, 3000);
                       }else{
                        $("#fail_delete").show();
                        $("#fail_delete").html(data.message);
                        setTimeout(function(){ $("#fail_delete").hide();}, 3000);
                       }
                    }, 
                    error: function (a, b, c) {
                       // console.log('error');
                        $("#fail_delete").show();
                        $("#fail_delete").html(data.message);
                        setTimeout(function(){ $("#fail_delete").hide();}, 3000);
                    }  
                });
            }
            return false;
        }
</script>
<script> 


// start crop image functionalities
$(document).ready(function(){

    var viewportWidth = 300;
    var viewport = $(window).width();

    if (viewport < 361) {
        viewportWidth = 250;
    }

    // profile picture input reset after upload image or close popup
    $('#uploadimageModal').on('hide.bs.modal', function(){
        
        if ($('#upload_image').length > 0) {
            
            $('#upload_image').val("");
        }
        scrollLock.enablePageScroll(document.getElementById('uploadimageModal'));
    })

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

        console.log('clicked');

        // Firefox 1.0+
        var isFirefox = typeof InstallTrigger !== 'undefined';

        // Safari 3.0+ "[object HTMLElementConstructor]" 
        var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

        $('input,textarea,select,radio').filter('[required]:visible').each(function(i, requiredField){
            
            document.getElementsByName($(requiredField).attr('name'))[0].setCustomValidity('');

            if($(requiredField).val() == '' || $(requiredField).val() == null)
            {
                console.log(requiredField);
                
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
            $('#edit_profile_form').submit();
        }   
    });
}); 
// End crop image functionalities 
</script>
@endsection

