@extends('layouts.logged_in.app-partner')

@section('content')
<?php
// Category
if ($post->category) {
    if ($post->category->parent_id == 0) {
        $postCatParentId = $post->category->id;
    } else {
        $postCatParentId = $post->category->parent_id;
    }
} else {
    $postCatParentId = 0;
}
?>
    <div class="container px-0 pt-40 pb-60 w-xl-1220">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata"> {{ t('Update a Job') }} </h1>
                <div class="divider mx-auto"></div>
                <p class="text-center prata">
                    <a href="{{ lurl($post->uri) }}" class="tooltipHere" title="" data-placement="top"
                               data-toggle="tooltip"
                               data-original-title="{!! $post->title !!}">
                                {!! str_limit($post->title, config('constant.title_limit')) !!}
                            </a>
                </p>
            </div>
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            
            <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data" autocomplete="off">
            {!! csrf_field() !!}
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            {{ Form::hidden('ismodel', $post->ismodel) }}
          
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pt-40 px-38 px-lg-0">
                        
                        <div class="pb-20 mb-20 bb-light-lavender3" id="newcompany" style="display: none;">

                        <!-- <div class="pt-20 pb-20 px-38 px-lg-0" id="newcompany" style="display: none;">
                            <div class="pb-10 mb-10 bb-light-lavender3" > -->
                                <h2 class="bold f-18 lh-18">{{ t('Company details') }}</h2>
                                <div class="divider"></div>
                                <div class="input-group <?php echo (isset($errors) and $errors->has('company.name')) ? 'err-invalid' : ''; ?>" id="company-name-jq-err">
                                    {{ Form::label(t('Company Name'), t('Company Name'), ['class' => 'input-label position-relative required']) }}
                                    {{ Form::text('company[name]', (isset($company->name) ? $company->name : ''), ['class' => 'animlabel', 'placeholder' => '', 'minlength' => '2', 'maxlength' => '200', 'id' => 'newCompanyInput']) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                
                                <div class="input-group <?php echo (isset($errors) and $errors->has('company.description')) ? 'err-invalid' : ''; ?>" id="company-description-jq-err">
                                    {{ Form::label('description', t('Description'), ['class' => 'input-label position-relative required']) }}
                                    {{ Form::textarea('company[description]', (isset($company->description) ? $company->description : ''), ['class' => 'animlabel textarea-description', 'id' => 'pageContent']) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>

                                <!-- <div class="input-group">
                                        <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)" class="upload_white mb-20" >
                                        <label id="error-profile-logo" class=""></label>
                                </div> -->

                                <div class="pb-20 mb-20 ">
                                    <h2 class="bold f-18 lh-18">{{ t('Logo') }}</h2>
                                    <div class="divider"></div>

                                    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                                        <div class="pt-40 px-38 px-lg-0">
                                            <div class="pb-40 mb-40 d-md-flex">
                                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                                    
                                                    <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.User') }}">

                                                </div>
                                                <div class="d-md-inline-block">
                                                   <!--  <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)" class="upload_white mb-20"> -->
                                                    
                                                    <div class="upload-btn-wrapper">
                                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>
                                                      <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)"  />
                                                    </div>

                                                    <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                                    <p id="error-profile-logo" class=""></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

<!--                                 <div class="input-group">
                                    <div id="logoField" class="form-group">
                                        <label class="col-md-3 control-label">&nbsp;</label>
                                        <div class="col-md-8">
                                            <div class="mb10">
                                                    <img id="output-partner-logo" src="{{ url('uploads/app/default/picture.jpg') }}" alt="user" width="120" height="80">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        <!-- </div> -->

                    <div class="pb-20 mb-20 bb-light-lavender3" id="oldcompany">
                        <h2 class="bold f-18 lh-18">{{ t('Company Information') }}</h2>
                        <div class="divider"></div>
                        <div class="input-group <?php echo (isset($errors) and $errors->has('company_id')) ? 'select-err-invalid' : ''; ?>" id="companyId-jq-err">
                            {{ Form::label('company', t('Select a Company') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="company_id" id="companyId" class="form-control">
                                <option value="0">{{ '[+]' }} {{ t('New Company') }}</option>
                                @if (isset($companies) and $companies->count() > 0)
                                    @foreach ($companies as $item)
                                        <option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}"  @if (old('company_id', (isset($postCompany) ? $postCompany->id : 0))==$item->id) selected="selected" @endif >{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                      

                        <div class="input-group">
                            <!-- logo -->
                            <div id="logoField" class="form-group">
                                <label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-12">
                                    <div class="mb10">
                                        <div id="logoFieldValue"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php /*
                        <div class="input-group edit-company" style="display: none;">
                            <?php $attr = ['countryCode' => config('country.icode'), 'id' => 0]; ?>
                            <a class="btn btn-success" id="companyFormLink" href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}">{{ t('Edit the Company') }}</a>
                        </div>
                        <?php */ ?>
                    </div>


                    <div class="pb-20 pt-20 mb-20 bb-light-lavender3">

                        <h2 class="bold f-18 lh-18">{{ t('Job\'s Details') }}</h2>
                        <div class="divider"></div>

                        <?php   
                            if(old('gender_type') !== null) { 
                                $gender_type_selected = old('gender_type'); 
                            } 
                            else {
                                $gender_type_selected = isset($post->gender_type_id) ? $post->gender_type_id : '';
                            }
                        ?>

                        <!-- static gender as 9/Male, 10/Female, 2 /Both  -->
                        <div class="input-group <?php echo (isset($errors) and $errors->has('gender_type')) ? 'select-err-invalid' : ''; ?>">
                            {{ Form::label(t('Gender'), t('Gender') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="gender_type" id="gender_type" class="form-control" required >
                                <?php /*
                                   <option value=""
                                            @if (old('gender_type')=='' or old('gender_type')==0)
                                                selected="selected"
                                            @endif
                                    >
                                        {{ t('Select') }}
                                    </option>
                                    <?php */ ?> 
                                
                                <option value="0" {{ ($gender_type_selected == '0') ? 'selected' : '' }}> {{ t("Both") }} </option>

                                @if ($genders->count() > 0)
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->tid }}" {{ (old('gender_type', $gender_type_selected) == $gender->tid) ? 'selected' : '' }} >{{ t($gender->name) }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('parent')) ? 'select-err-invalid' : ''; ?>" id="parent-jq-err">
                            {{ Form::label(t('Category'), t('Category') , ['class' => 'control-label required input-label position-relative']) }}
                            <?php $category_id = array(); if(isset($post->model_category_id)){
                                $category_id = explode(',', $post->category_id);
                            }?>
                            <select name="parent[]" id="parent" class="form-control" multiple="true" required>
                                @if($categories->count() > 0)
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                                @if (in_array($cat->parent_id, old('parent', $category_id)))
                                                    selected="selected"
                                                @endif
                                        >
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
                        </div>

                        <input type="hidden" name="category" id="category" value="{{ $post->category_id }}">

                        <input type="hidden" name="is_baby" id="is_baby" value="{{ old('is_baby') }}">
                        <input type="hidden" name="is_model_category" id="is_model_category" value="{{ old('is_model_category') }}">
                        
                        @if ($post->ismodel)


                            <?php 

                                $modelsCategoryArr = array();
                                    
                                if(isset($post->model_category_id) && !empty($post->model_category_id)){
                                    
                                    $modelsCategoryArr = explode(',', $post->model_category_id);
                                } 
                            ?>
                            
                            <div class="input-group <?php echo (isset($errors) and $errors->has('modelCategory')) ? 'select-err-invalid' : ''; ?>" id="modelcate" style="display: none; ">

                                {{ Form::label(t('Sub-Category'), t('Sub-Category') , ['class' => 'control-label required input-label position-relative']) }}

                                <select name="modelCategory[]" id="modelCategory" class="form-control" multiple="true">
                                    @if($modelCategories->count() > 0)
                                        @foreach ($modelCategories as $key => $cat)
                                            <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                                
                                                @if(old('modelCategory'))
                                                    @if (in_array($cat->parent_id, old('modelCategory')))
                                                        selected="selected"
                                                    @endif
                                                @else
                                                    @if (in_array($cat->parent_id, $modelsCategoryArr))
                                                        selected="selected"
                                                    @endif
                                                @endif

                                            > {{ $cat->name }} </option> 
                                        @endforeach
                                    @endif
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                        @endif
                        
                        @if (!$post->ismodel)
                        <div class="input-group <?php echo (isset($errors) and $errors->has('branch')) ? 'select-err-invalid' : ''; ?>" id="partnercate">
                            {{ Form::label(t('Sub-Category'), t('Sub-Category') , ['class' => 'control-label required input-label position-relative']) }}

                            <?php if(isset($post->partner_category_id)){
                                $partnerCategory = explode(',', $post->partner_category_id);
                            }?>
                            <input type="hidden" name="branch_type" id="branch_type" value="{{ old('branch_type') }}">

                            <select name="branch[]" id="branch" class="form-control" multiple="true" required>
                                @if($branches->count() > 0)
                                    @foreach ($branches as $cat)
                                        <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                                @if (in_array($cat->parent_id, $partnerCategory))
                                                    selected="selected"
                                                @endif
                                        > {{ $cat->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        @endif


                        <div class="input-group <?php echo (isset($errors) and $errors->has('title')) ? 'err-invalid' : ''; ?>" title="{{ t('A great title needs at least 60 characters') }} " id="title-jq-err">
                            {{ Form::label(t('Title'), t('Title'), ['class' => 'position-relative control-label required input-label']) }}
                            {{ Form::text('title', old('title', $post->title), ['class' => 'animlabel', 'id' => 'title' ,  'required', 'placeholder' =>  t('Job\'s Title')]) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('description')) ? 'textarea-err-invalid' : ''; ?>" title="{{ t('Describe what makes your ad unique') }}">
                            <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                            {{ Form::label(t('Description'), t('Description'), ['class' => 'position-relative input-label required']) }}
                            {{ Form::textarea('description', old('description', $post->description), ['class' => 'animlabel"'.$ckeditorClass.'"', 'id' => 'pageContent2']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>


                        <div class="input-group <?php echo (isset($errors) and $errors->has('post_type')) ? 'select-err-invalid' : ''; ?>" id="post_type-jq-err">
                            {{ Form::label(t('Job Type'), t('Job Type') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="post_type" id="post_type" class="form-control" required>
                                @if($postTypes->count() > 0)
                                    @foreach ($postTypes as $postType)
                                        <option is_one_day="{{ $postType->is_one_day }}" value="{{ $postType->tid }}"
                                                @if (old('post_type', $post->post_type_id)==$postType->tid)
                                                    selected="selected"
                                                @endif
                                        >
                                            {{ $postType->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <input type="hidden" id="is_one_day" name="is_one_day" value="0">

                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_min')) ? 'err-invalid' : ''; ?>">
                                <label for="geschlecht" class="control-label input-label position-relative">{{ t('Salary :currency (min)', ['currency' => $currency]) }}</label>
                                <input id="salary_min" name="salary_min" class="animlabel" placeholder="{{ t('Salary Min') }}" type="text" value="{{ old('salary_min', ($post->salary_min != 0)? $post->salary_min : '' ) }}">
                            </div>
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_max')) ? 'err-invalid' : ''; ?>">
                                <label for="geschlecht" class="control-label input-label position-relative">{{ t('Salary :currency (max)', ['currency' => $currency]) }}</label>
                                <input id="salary_max" name="salary_max" class="animlabel" placeholder="{{ t('Salary Max') }}" type="text" value="{{ old('salary_max', ($post->salary_max != 0)? $post->salary_max : '' ) }}">
                            </div>
                        </div>

                        <div class="row custom-checkbox">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_type')) ? 'select-err-invalid' : ''; ?>" id="salary_type-jq-err">
                                <label for="geschlecht" class="control-label required input-label position-relative">{{ t('Salary Pay Range') }}</label>
                                <select name="salary_type" id="salary_type" class="form-control">
                                    @if($salaryTypes->count() > 0)
                                        @foreach ($salaryTypes as $salaryType)
                                            <option value="{{ $salaryType->tid }}"
                                                    @if (old('salary_type', $post->salary_type_id)==$salaryType->tid)
                                                        selected="selected"
                                                    @endif
                                            >
                                                {{ $salaryType->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                           <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('checkbox_field')) ? 'err-invalid' : ''; ?>">
                                <label for="geschlecht" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="negotiable" name="negotiable" value="1" type="checkbox" {{ (old('negotiable', $post->negotiable)=='1') ? 'checked="checked"' : '' }}>
                                <label for="negotiable" class="checkbox-label col-md-6">{{ t('Negotiable') }}</label>
                            </div>
                        </div>

                        <div class="row custom-checkbox">
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label(t('Start Date'), t('Start Date'), ['class' => 'position-relative control-label input-label']) }}
                                {{ Form::text('start_date', old('start_date', $post->start_date), ['class' => 'animlabel', 'id' => 'start_date' , 'placeholder' => t('Start Date'), 'readonly' => true]) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                <label for="geschlecht_1" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="is_date_announce" name="is_date_announce" value="on" type="checkbox">
                                <label for="is_date_announce" class="checkbox-label">{{ t('to be announced') }}</label>
                            </div>
                             
                            <input type="hidden" id="is_date_announce_hidden" name="is_date_announce_hidden" value="{{ old('is_date_announce_hidden', $post->is_date_announce) }}">
                        </div>
                        <div class="row">
                            <div id="end_date_div" class="col-md-6 form-group mb-20">
                                {{ Form::label(t('End Date'), t('End Date'), ['class' => 'position-relative control-label input-label']) }}
                                {{ Form::text('end_date', old('end_date', $post->end_date), ['class' => 'animlabel', 'id' => 'end_date' , 'placeholder' => t('End Date'), 'readonly' => true]) }}
                            </div>
                        </div>
                        <?php /*
                        <div class="input-group  <?php echo (isset($errors) and $errors->has('start_date')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Start Date'), t('Start Date'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('start_date', old('start_date', $post->start_date), ['class' => 'animlabel', 'id' => 'start_date' , 'placeholder' => t('Start Date'), 'readonly' => true]) }}
                        </div>

                        <div id="end_date_div" class="input-group <?php echo (isset($errors) and $errors->has('tend_dateags')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('End Date'), t('End Date'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('end_date', old('end_date', $post->end_date), ['class' => 'animlabel', 'id' => 'end_date' , 'placeholder' => t('End Date'), 'readonly' => true]) }}
                        </div>
                        */ ?>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('experience_type')) ? 'select-err-invalid' : ''; ?>" id="experience_type-jq-err">
                            {{ Form::label(t('Required experience'), t('Required experience') , ['class' => 'control-label input-label position-relative']) }}
                            <select name="experience_type" id="experience_type" class="form-control">
                                <option value=""
                                        @if (old('experience_type')=='' or old('experience_type')==0)
                                            selected="selected"
                                        @endif
                                >
                                    {{ t('Select') }}
                                </option>
                                @if($experienceTypes->count() > 0)
                                    @foreach ($experienceTypes as $type)
                                        <option value="{{ $type->id }}"  {{ ($type->id == $post->experience_type_id) ? 'selected' : '' }} >
                                            {{ t($type->name) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="row custom-checkbox">
                            <div class="col-md-12 form-group mb-20">
                                <label for="is_home_job_label" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="is_home_job" name="is_home_job" value="1" type="checkbox" @if (old('is_home_job') === '1' || $post->is_home_job == 1) checked="checked" @endif>
                                <label for="is_home_job" class="checkbox-label">{{ t('is_home_job') }}</label>
                            </div>
                        </div>


                        <div class="input-group <?php echo (isset($errors) and $errors->has('tfp')) ? 'err-invalid' : ''; ?>" id="tfp-jq-err">
                            {{ Form::label(t("TFP"), t("TFP") , ['class' => 'control-label required input-label position-relative']) }}
                            <div class="input-group custom-radio mt-10">
                                <input type="radio" name="tfp" value="1" class='radio_field' id="Yes" 
                                    @if($post->tfp == 1)
                                        checked="checked"
                                    @endif
                                >

                                {{ Form::label('Yes', t('Yes'), ['class' => 'd-inline-block radio-label col-sm-3']) }}
                                
                                <input type="radio" name="tfp" value="0" class='radio_field' id="No" 
                                    @if($post->tfp == 0)
                                        checked="checked"
                                    @endif
                                >

                                {{ Form::label('No', t('No'), ['class' => 'd-inline-block radio-label col-sm-3']) }}
                            </div>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        
                        @if ($post->ismodel)

                        <!-- Only show model is selected start  -->

                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('height_from')) ? 'select-err-invalid' : ''; ?>" id="height_from-jq-err">
                                <label class="control-label input-label position-relative">{{ t('Body height') }} ( {{ t('from') }} )</label>
                                <select name="height_from" id="height_from" class="form-control">
                                    <option value="">{{  t('Select height')}}</option>

                                    <?php 
                                        
                                        if(count($properties['height']) > 0) {
                                            
                                            foreach($properties['height'] as $key=>$cat){ ?>
                                                
                                                <option value="<?= $key ?>" {{ ( old('height_from' ,$post->height_from) == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php       
                                            } 
                                        } 
                                    ?>
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div> 
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('height_to')) ? 'select-err-invalid' : ''; ?>" id="height_to-jq-err">
                                <label class="control-label input-label position-relative">{{ t('Body height') }} ( {{ t('to') }} )</label>
                                <select name="height_to" id="height_to" class="form-control">
                                    <option value="">{{  t('Select height')}}</option>
                                    <?php 

                                        if(count($properties['height']) > 0) {

                                            foreach($properties['height'] as $key=>$cat){ ?>
                                                
                                                <option value="<?= $key ?>" {{ ( old('height_to', $post->height_to)  == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php   
                                            } 
                                        }
                                    ?>
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('weight_from')) ? 'select-err-invalid' : ''; ?>" id="weight_from-jq-err">
                                <label class="control-label input-label position-relative">{{ t('Body weight') }} ( {{ t('from') }} )</label>
                                <select name="weight_from" id="weight_from" class="form-control">
                                    <option value="">{{  t('Select weight')}}</option>
                                    <?php 
                                        
                                        if(count($properties['weight']) > 0) {

                                            foreach($properties['weight'] as $key=>$cat){ ?>
                                                
                                                <option value="<?= $key ?>" {{ (old('weight_from', $post->weight_from) == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php 
                                            } 
                                        }
                                    ?>
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('weight_to')) ? 'select-err-invalid' : ''; ?>" id="weight_to-jq-err">
                                <label class="control-label input-label position-relative">{{ t('Body weight') }} ( {{ t('to') }} )</label>
                                <select name="weight_to" id="weight_to" class="form-control">
                                    <option value="">{{  t('Select weight')}}</option>
                                    
                                    <?php 
                                        
                                        if(count($properties['weight']) > 0) {
                                            
                                            foreach($properties['weight'] as $key=>$cat){ ?>
                                                
                                                <option value="<?= $key ?>" {{ ( old('weight_to', $post->weight_to) == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php 
                                            } 
                                        }
                                    ?>
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('age_from')) ? 'select-err-invalid' : ''; ?>" id="age_from-jq-err">
                                <label class="control-label required input-label position-relative">{{ t('Age') }} ( {{ t('from') }} )</label>
                                <select name="age_from" id="age_from" class="form-control" required>
                                    <option value="" selected="selected">{{  t('Select age')}}</option>
                                        @if(count($properties['age']) > 0)
                                            @foreach($properties['age'] as $key => $ageFrom)
                                                <option value="{{ $key }}" {{ ( old('age_from', $post->age_from)  == $key ) ? 'selected' : '' }}>{{ $ageFrom }}</option>
                                            @endforeach
                                        @endif
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('age_to')) ? 'select-err-invalid' : ''; ?>" id="age_to-jq-err">
                                <label  class="control-label required input-label position-relative">{{ t('Age') }} ( {{ t('to') }} )</label>
                                <select name="age_to" id="age_to" class="form-control" required>
                                    <option value="" selected="selected">{{  t('Select age')}}</option>
                                        @if(count($properties['age']) > 0)
                                            @foreach($properties['age'] as $key => $ageTo)
                                                <option value="{{ $key }}" {{ ( old('age_to',$post->age_to) == $key ) ? 'selected' : '' }}>{{ $ageTo }}</option>
                                            @endforeach
                                        @endif
                                </select>
                                <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            </div>
                        </div>
                        <?php /*
                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('dressSize_from')) ? 'err-invalid' : ''; ?>">
                                <label class="control-label required input-label position-relative">{{ t('Dress size') }} ( {{ t('from') }} )</label>
                                <select name="dressSize_from" id="dressSize_from" class="form-control" required>
                                    <option value="">{{  t('Select dress size')}}</option>
                                    <?php foreach($properties['dress_size'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>" {{ ( $post->dressSize_from == $key ) ? 'selected' : '' }}><?= $cat ?></option> <?php  } ?>
                                    
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('dressSize_to')) ? 'err-invalid' : ''; ?>">
                                <label class="control-label required input-label position-relative">{{ t('Dress size') }} ( {{ t('to') }} )</label>
                                <select name="dressSize_to" id="dressSize_to" class="form-control" required>
                                    <option value="">{{  t('Select dress size')}}</option>
                                   <?php foreach($properties['dress_size'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>" {{ ( $post->dressSize_to == $key ) ? 'selected' : '' }}><?= $cat ?></option> <?php  } ?>
                                    
                                </select>
                            </div>
                        </div>

                        <?php */ ?>


                        <?php

                           $womenDressSizeArr = array();
                           $menDressSizeArr = array();
                           $babyDressSizeArr = array();


                           if (isset($post->dress_size_women) && !empty($post->dress_size_women)) {

                                $womenDressSizeArr = explode(',', $post->dress_size_women);
                            }

                            if (isset($post->dress_size_men) && !empty($post->dress_size_men)) {

                                $menDressSizeArr = explode(',', $post->dress_size_men);
                            }

                            if (isset($post->dress_size_baby) && !empty($post->dress_size_baby)) {

                                $babyDressSizeArr = explode(',', $post->dress_size_baby);
                            }
                        ?>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="mb-40 bb-light-lavender3" id="women_models_dress_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseWomanDress">
                                            <strong class="lh-18 required">{{t('women_dress_size_lable')}}
                                                <!-- <font class="required-font-tag">*</font> -->
                                            </strong>
                                        </a>
                                    </div>
                                    <div id="collapseWomanDress" class="collapse show" data-parent="#accordion">

                                        <?php 
                                            $is_women_dress_checked = false;
                                            if(isset($womenDressSizeArr) && count($womenDressSizeArr) > 0 && isset($women_dress) && count($women_dress) > 0){
                                                if(count($womenDressSizeArr) == count($women_dress)){
                                                    $is_women_dress_checked = true;
                                                }
                                            }

                                        $checked = ( $is_women_dress_checked || old('dress_women_check_all') == 1)? 'checked="checked"' : '';
                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="dress_women_all" name="dress_women_check_all" value="1" type="checkbox" {{ $checked }}>
                                                <label for="dress_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>

                                        <div class="row custom-checkbox">
                                            @if(count($women_dress) > 0)
                                                @foreach ($women_dress as $key => $val)

                                                    <?php 

                                                        $is_check = in_array($key , $womenDressSizeArr) ? true : false;
                                                    ?>
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('womenDressSize[]',  $key, $is_check , ['class' => 'checkbox_field wds', 'id' => 'womenDressSize_'.($key)]) }}

                                                        {{ Form::label('womenDressSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-40 bb-light-lavender3" id="men_models_dress_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseMenDress">
                                            <strong class="lh-18 required">
                                                {{t('men_dress_size_lable')}}
                                                <!-- <font class="required-font-tag">*</font> -->
                                            </strong>
                                        </a>
                                    </div>
                                    <div id="collapseMenDress" class="collapse show" data-parent="#accordion">

                                        <?php 

                                            $is_men_dress_checked = false;
                                            if(isset($menDressSizeArr) && count($menDressSizeArr) > 0 && isset($men_dress) && count($men_dress) > 0){
                                                if(count($menDressSizeArr) == count($men_dress)){
                                                    $is_men_dress_checked = true;
                                                }
                                            }
                                            $checked = ( $is_men_dress_checked || old('dress_men_check_all') == 1)? 'checked="checked"' : ''; 

                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="dress_men_all" name="dress_men_check_all" value="1" type="checkbox" {{$checked}}>
                                                <label for="dress_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>

                                        <div class="row custom-checkbox">
                                            @if(count($men_dress) > 0)
                                                @foreach ($men_dress as $key => $val)

                                                    <?php 

                                                        $is_check = in_array($key , $menDressSizeArr) ? true : false;
                                                    ?>
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('menDressSize[]',  $key, $is_check, ['class' => 'checkbox_field mds', 'id' => 'menDressSize_'.($key)]) }}

                                                        {{ Form::label('menDressSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-40 bb-light-lavender3" id="baby_models_dress_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseBabyDress">
                                            <strong class="lh-18 required">
                                            {{t('baby_dress_size_lable')}}
                                            <!-- <font class="required-font-tag">*</font> -->
                                            </strong>
                                        </a>
                                    </div>
                                    <div id="collapseBabyDress" class="collapse show" data-parent="#accordion">

                                        <?php 

                                            $is_kid_dress_checked = false;
                                            if(isset($babyDressSizeArr) && count($babyDressSizeArr) > 0 && isset($baby_dress) && count($baby_dress) > 0){
                                                if(count($babyDressSizeArr) == count($baby_dress)){
                                                    $is_kid_dress_checked = true;
                                                }
                                            }

                                            $checked = ( $is_kid_dress_checked || old('dress_kid_check_all') == 1)? 'checked="checked"' : '';
                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="dress_kid_all" name="dress_kid_check_all" value="1" type="checkbox" {{$checked}}>
                                                <label for="dress_kid_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>


                                        <div class="row custom-checkbox">
                                            @if(count($baby_dress) > 0)
                                                @foreach ($baby_dress as $key => $val)
                                                    
                                                    <?php 

                                                        $is_check = in_array($key , $babyDressSizeArr) ? true : false;
                                                    ?>

                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('babyDressSize[]',  $key, $is_check, ['class' => 'checkbox_field bds', 'id' => 'babyDressSize_'.($key)]) }}

                                                        {{ Form::label('babyDressSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        

                        

                        <div class="input-group">
                            <label class="checkbox-label" id="addMore"><a href="javascript:void(0);"><strong>- {{ t('Add more fields') }}</strong></a></label>
                        </div>

                        <span class="addMoreFields mb-40">
                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('chest_from')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Chest') }} ( {{ t('from') }} )</label>
                                    <select name="chest_from" id="chest_from" class="form-control">
                                        <option value="">{{  t('Select chest') }}</option>
                                            @if(count($properties['chest']) > 0)
                                                @foreach($properties['chest'] as $key => $chestFrom)
                                                    <option value="{{ $key }}" {{ ( old('chest_from', $post->chest_from) == $key ) ? 'selected' : '' }}>{{ $chestFrom }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('chest_to')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label  input-label position-relative">{{ t('Chest') }} ( {{ t('to') }} )</label>
                                    <select name="chest_to" id="chest_to" class="form-control">
                                        <option value="">{{  t('Select chest') }}</option>
                                        @if(count($properties['chest']) > 0)
                                            @foreach($properties['chest'] as $key => $chestTo)
                                                <option value="{{ $key }}" {{ (old('chest_to', $post->chest_to)  == $key ) ? 'selected' : '' }}>{{ $chestTo }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('waist_from')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Waist') }} ( {{ t('from') }} )</label>
                                    <select name="waist_from" id="waist_from" class="form-control">
                                        <option value="">{{  t('Select waist')}}</option>
                                            @if(count($properties['waist']) > 0)
                                                @foreach($properties['waist'] as $key => $waistFrom)
                                                    <option value="{{ $key }}" {{ ( old('waist_from', $post->waist_from)  == $key ) ? 'selected' : '' }}>{{ $waistFrom }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('waist_to')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Waist') }} ( {{ t('to') }} )</label>
                                    <select name="waist_to" id="waist_to" class="form-control">
                                        <option value="">{{  t('Select waist')}}</option>
                                        @if(count($properties['waist']) > 0)
                                            @foreach($properties['waist'] as $key => $waistTo)
                                                <option value="{{ $key }}" {{ ( old('waist_to', $post->waist_to) == $key ) ? 'selected' : '' }}>{{ $waistTo }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('hips_from')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Hips') }} ( {{ t('from') }} )</label>
                                    <select name="hips_from" id="hips_from" class="form-control">
                                        <option value="">{{  t('Select hips')}}</option>
                                            @if(count($properties['hips']) > 0)
                                                @foreach($properties['hips'] as $key => $hipsFrom)
                                                    <option value="{{ $key }}" {{ ( old('hips_from', $post->hips_from)  == $key ) ? 'selected' : '' }}>{{ $hipsFrom }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('hips_to')) ? 'select-err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Hips') }} ( {{ t('to') }} )</label>
                                    <select name="hips_to" id="hips_to" class="form-control">
                                        <option value="">{{  t('Select hips')}}</option>
                                            @if(count($properties['hips']) > 0)
                                                @foreach($properties['hips'] as $key => $hipsTo)
                                                    <option value="{{ $key }}" {{ ( old('hips_to', $post->hips_to)  == $key ) ? 'selected' : '' }}>{{ $hipsTo }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                            <?php /*
                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('shoeSize_from')) ? 'err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Shoe size') }} ( {{ t('from') }} )</label>
                                    <select name="shoeSize_from" id="shoeSize_from" class="form-control">
                                        <option value="">{{ t('Select shoe size') }}</option>
                                        <?php foreach($properties['shoe_size'] as $key=>$cat){ ?>
                                            <option value="<?= $key ?>" {{ ( $post->shoeSize_from == $key ) ? 'selected' : '' }}><?= $cat ?></option> <?php  } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('shoeSize_to')) ? 'err-invalid' : ''; ?>">
                                    <label class="control-label input-label position-relative">{{ t('Shoe size') }} ( {{ t('to') }} )</label>
                                    <select name="shoeSize_to" id="shoeSize_to" class="form-control">
                                        <option value="">{{ t('Select shoe size') }}</option>
                                        <?php foreach($properties['shoe_size'] as $key=>$cat){ ?>
                                            <option value="<?= $key ?>" {{ ( $post->shoeSize_to == $key ) ? 'selected' : '' }}><?= $cat ?></option> <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <?php */ ?>
                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'select-err-invalid' : ''; ?>">
                                {{ Form::label(t('Eye color'), t('Eye color') , ['class' => 'control-label  input-label position-relative']) }}
                                <select name="eyeColor" id="eyeColor" class="form-control">
                                   <option value="">{{ t('Select eye color') }}</option>
                                    <?php 
                                        if(count($properties['eye_color']) > 0) {
                                            foreach($properties['eye_color'] as $key=>$cat){ ?>
                                                <option value="<?= $key ?>" {{ (old('eyeColor', $post->eyeColor)  == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php 
                                            }
                                        } 
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('hairColor')) ? 'select-err-invalid' : ''; ?>">
                                {{ Form::label(t('Hair color'), t('Hair color') , ['class' => 'control-label  input-label position-relative']) }}
                                <select name="hairColor" id="hairColor" class="form-control">
                                   <option value="">{{  t('Select hair color')}}</option>
                                    <?php 
                                        if(count($properties['hair_color']) > 0) {
                                            foreach($properties['hair_color'] as $key=>$cat){ ?>
                                                <option value="<?= $key ?>" {{ (old('hairColor', $post->hairColor) == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php 
                                            } 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('skinColor')) ? 'select-err-invalid' : ''; ?>">
                                {{ Form::label(t('Skin color'), t('Skin color') , ['class' => 'control-label  input-label position-relative']) }}
                                <select name="skinColor" id="skinColor" class="form-control">
                                   <option value="">{{ t('Select skin color') }}</option>
                                    <?php 
                                        if(count($properties['skin_color']) > 0) {
                                            foreach($properties['skin_color'] as $key=>$cat){ ?>
                                                <option value="<?= $key ?>" {{ (old('skinColor', $post->skinColor) == $key ) ? 'selected' : '' }}><?= $cat ?></option>
                                                <?php 
                                            } 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php

                           $womenShoeSizeArr = array();
                           $menShoeSizeArr = array();
                           $babyShoeSizeArr = array();


                           if (isset($post->shoe_size_women) && !empty($post->shoe_size_women)) {

                                $womenShoeSizeArr = explode(',', $post->shoe_size_women);
                            }

                            if (isset($post->shoe_size_men) && !empty($post->shoe_size_men)) {

                                $menShoeSizeArr = explode(',', $post->shoe_size_men);
                            }

                            if (isset($post->shoe_size_baby) && !empty($post->shoe_size_baby)) {

                                $babyShoeSizeArr = explode(',', $post->shoe_size_baby);
                            }
                        ?>

                        <div class="panel-group" id="accordionShoes" role="tablist" aria-multiselectable="true">
                            <div class="mb-40 bb-light-lavender3" id="women_models_shoe_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseWomenShoes">
                                            <strong class="lh-18 required">
                                            {{t('women_shoe_size_lable')}}</strong>
                                        </a>
                                    </div>
                                    <div id="collapseWomenShoes" class="collapse show" data-parent="#accordionShoes">

                                        <?php 
                                            
                                            $is_women_shoe_checked = false;
                                            if(isset($womenShoeSizeArr) && count($womenShoeSizeArr) > 0 && isset($women_shoe) && count($women_shoe) > 0){
                                                if(count($womenShoeSizeArr) == count($women_shoe)){
                                                    $is_women_shoe_checked = true;
                                                }
                                            }    

                                            $checked = ($is_women_shoe_checked || old('shoe_women_check_all') == 1)? 'checked="checked"' : '';
                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="shoe_women_all" name="shoe_women_check_all" value="1" type="checkbox" {{$checked}}>
                                                <label for="shoe_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>

                                        <div class="row custom-checkbox">
                                            @if(count($women_shoe) > 0)
                                                @foreach ($women_shoe as $key => $val)
                                                    
                                                    <?php 

                                                        $is_check = in_array($key , $womenShoeSizeArr) ? true : false;
                                                    ?>
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('womenShoeSize[]',  $key, $is_check, ['class' => 'checkbox_field ws', 'id' => 'womenShoeSize_'.($key)]) }}

                                                        {{ Form::label('womenShoeSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-40 bb-light-lavender3" id="men_models_shoe_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseMenShoes">
                                            <strong class="lh-18 required">
                                            {{t('men_shoe_size_lable')}}
                                            </strong>
                                        </a>
                                    </div>
                                    <div id="collapseMenShoes" class="collapse show" data-parent="#accordionShoes">  
                                        <?php 

                                            $is_men_shoe_checked = false;
                                            if(isset($menShoeSizeArr) && count($menShoeSizeArr) > 0 && isset($men_shoe) && count($men_shoe) > 0){
                                                if(count($menShoeSizeArr) == count($men_shoe)){
                                                    $is_men_shoe_checked = true;
                                                }
                                            } 

                                            $checked = ( $is_men_shoe_checked || old('shoe_men_check_all') == 1)? 'checked="checked"' : '';
                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="shoe_men_all" name="shoe_men_check_all" value="1" type="checkbox" {{ $checked }}>
                                                <label for="shoe_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row custom-checkbox">
                                            @if(count($men_shoe) > 0)
                                                @foreach ($men_shoe as $key => $val)
                                                    
                                                    <?php 

                                                        $is_check = in_array($key , $menShoeSizeArr) ? true : false;
                                                    ?>

                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('menShoeSize[]',  $key, $is_check, ['class' => 'checkbox_field ms', 'id' => 'menShoeSize_'.($key)]) }}

                                                        {{ Form::label('menShoeSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-40 bb-light-lavender3" id="baby_models_shoe_size_div" style="display: none;">
                                <div>
                                    <div class="mb-20">
                                        <a class="card-link" data-toggle="collapse" href="#collapseBabyShoes">
                                            <strong class="lh-18 required">{{t('baby_shoe_size_lable')}}</strong>
                                        </a>
                                    </div>
                                    <div id="collapseBabyShoes" class="collapse show" data-parent="#accordionShoes">

                                        <?php 
                                            
                                            $is_kid_shoe_checked = false;
                                            if(isset($babyShoeSizeArr) && count($babyShoeSizeArr) > 0 && isset($baby_shoe) && count($baby_shoe) > 0){
                                                if(count($babyShoeSizeArr) == count($baby_shoe)){
                                                    $is_kid_shoe_checked = true;
                                                }
                                            }

                                            $checked = ( $is_kid_shoe_checked || old('shoe_kid_check_all') == 1)? 'checked="checked"' : ''; 
                                        ?>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                <input class="checkbox_field" id="shoe_kid_all" name="shoe_kid_check_all" value="1" type="checkbox" {{ $checked }}>
                                                <label for="shoe_kid_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                            </div>
                                        </div>

                                        <div class="row custom-checkbox">
                                            @if(count($baby_shoe) > 0)
                                                @foreach ($baby_shoe as $key => $val)
                                                    
                                                    <?php 

                                                        $is_check = in_array($key , $babyShoeSizeArr) ? true : false;
                                                    ?>

                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('babyShoeSize[]',  $key, $is_check, ['class' => 'checkbox_field bs', 'id' => 'babyShoeSize_'.($key)]) }}

                                                        {{ Form::label('babyShoeSize_'.($key), $val, ['class' => 'checkbox-label']) }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="help-block category-error-msg"></p>
                                    </div>
                                </div>
                            </div>



                        </div>
                        

                        

                        
                    </span>

                        @endif

                        <!-- Only show model is selected end -->

                        @if(!Gate::allows('free_country_user', auth()->user()))

                        <div class="input-group <?php echo (isset($errors) and $errors->has('country')) ? 'select-err-invalid' : ''; ?>" id="country-jq-err">

                            {{ Form::label(t('Your Country'), t('Your Country') , ['class' => 'control-label  input-label position-relative required']) }}
                            <select name="country" id="country" class="form-control country-auto-search" required>
                                <option value=""> {{ t('Select a country') }} </option>
                                @if($countries->count() > 0)
                                    @foreach ($countries as $item)
                                        <!-- <option value="{{ $item->get('code') }}" {{ (old('country', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option> -->
                                        <option value="{{ $item->get('code') }}" {{ (old('country', (!empty($post->country_code)) ? $post->country_code : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('city')) ? 'select-err-invalid' : ''; ?>" id="city-jq-err">
                            {{ Form::label(t('City'), t('City') , ['class' => 'control-label required  input-label position-relative']) }}
                            <!-- commented city code -->
                            <!-- <select name="city" id="city" class="form-control city-auto-search" required>
                                <option value="" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
                                    {{ t('Select a city') }}
                                </option>
                            </select> -->
                            {{ Form::text('city', old('city', $post->city), ['class' => 'animlabel', 'id' => 'city' , 'placeholder' => t('City'), 'required' => '']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        
                        @endif


                        <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('contact_name')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Contact Name'), t('Contact Name'), ['class' => 'position-relative control-label input-label']) }}
                                {{ Form::text('contact_name', old('contact_name', $post->contact_name), ['class' => 'animlabel', 'id' => 'contact_name' , 'placeholder' => t('Contact Name')]) }}

                        </div>

                        <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('email')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Contact Email'), t('Contact Email'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('email', old('email', $post->email), ['class' => 'animlabel', 'id' => 'email' , 'readOnly' => 'readonly', 'placeholder' => t('Contact Email')]) }}
                        </div>

                        <?php if (Auth::check()) { 
                            $formPhone = ($user->country_code == config('country.code')) ? $user->phone : '';
                        } else {
                            $formPhone = '';
                        } ?>

                        <?php $phoneNumber = (Auth::check() and isset($user->phone)) ? $user->phone : '';
                            $phoneCode = (Auth::check() and isset($user->phone_code)) ? $user->phone_code : ''; 
                        ?>

                        <div class="row custom-checkbox <?php echo (isset($errors) and $errors->has('phone')) ? 'err-invalid' : ''; ?>">
                            <!-- <div class="col-md-6 form-group mb-20"> -->
                                <div class="input-group pb-20 mb-20">
                            {{ Form::label(t('Phone Number'), t('Phone Number'), ['class' => 'position-relative control-label input-label']) }}

                            {{ Form::text('phone_readonly', $phoneCode." ".phoneFormat(old('phone', $phoneNumber), $formPhone), ['class' => 'animlabel disable-input', 'readOnly' => 'readonly', 'id' => 'phone' , 'placeholder' => t('Phone Number')]) }}
                            <?php /*
                            {{ Form::text('phone', phoneFormat(old('phone', $post->phone), $post->country_code), ['class' => 'animlabel', 'readOnly' => 'readonly', 'id' => 'phone' , 'placeholder' => t('Phone Number')]) }} */ ?>
                            <input type="hidden" name="phone" value="{{$phoneNumber}}">
                            <input type="hidden" name="phone_code" value="{{$phoneCode}}">
                            </div>
                            <?php /*
                            <div class="col-md-6 form-group mb-20">
                                <label for="geschlecht" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="phone_hidden" name="phone_hidden"  value="1" {{ (old('phone_hidden', $post->phone_hidden)=='1') ? 'checked="checked"' : '' }} type="checkbox">
                                <label for="phone_hidden" class="checkbox-label">{{ t('Hide the phone number on this ads') }}</label>
                            </div>
                            */?>
                        </div>

                        @if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
                        <div class="input-group <?php echo (isset($errors) and $errors->has('admin_code')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Location'), t('Location') , ['class' => 'control-label  input-label position-relative']) }}
                            <select name="admin_code" id="adminCode" class="form-control">
                                <option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>{{ t('Select your Location') }}</option>
                            </select>
                        </div>
                        @endif

                        
                        <?php /*
                        <div class="input-group <?php echo (isset($errors) and $errors->has('application_url')) ? 'err-invalid' : ''; ?>" title="{{ t('Candidates will follow this URL address to apply for the job') }}" >
                            {{ Form::label(t('Application URL'), t('Application URL'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('application_url', old('application_url', $post->application_url), ['class' => 'animlabel', 'id' => 'application_url' , 'placeholder' => '']) }}
                        </div> */?>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('end_application')) ? 'err-invalid' : ''; ?>" id="end_application-jq-err">
                            {{ Form::label(t('Application Deadline'), t('Application Deadline'), ['class' => 'position-relative control-label input-label required']) }}
                            {{ Form::text('end_application', old('end_application', $post->end_application), ['class' => 'animlabel','required' => 'required', 'id' => 'end_application' , 'placeholder' => '',  'autocomplete' => 'end_application_arr']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('tags')) ? 'err-invalid' : ''; ?>" title="{{ t('Enter the tags separated by commas') }}">
                            {{ Form::label(t('Tags'), t('Tags'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('tags', old('tags', $post->tags), ['class' => 'animlabel', 'id' => 'tags' , 'placeholder' => '']) }}
                        </div>


                    </div> 
                   
                </div>
               
                @include('childs.bottom-bar-update')
            </div>
            {{ Form::close() }}
        </div>
    </div>
     <script>
        $(document).ready( function(){
            var is_home_job = '<?php echo $is_home_job; ?>';
            if(is_home_job == 1){
                $("#is_home_job").attr('checked', 'checked');
                $('#is_home_job').click( function(){
                    return false;
                });
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#subCatBloc').css("display", "none");
            $('.addMoreFields').css('display', 'block');

            $('#addMore').click( function(){
                if ( $('.addMoreFields').is(':hidden') ) {
                    $('.addMoreFields').css('display', 'block');
                }else{
                    $('.addMoreFields').css('display', 'none');
                }
            });
        });
    </script>
@endsection


@section('after_styles')
    <link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/styles/simditor.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style type="text/css">
        .simditor { 
            width: 100% !important;
        }
        .simditor .simditor-toolbar {
            width: 100% !important;
        }

        .bootstrap-tagsinput {
            width: 100%;
            color: #171717;
            border: none;
            outline: none;
            padding-bottom: 10px;
            line-height: 1;
            border-bottom: solid 1px #a1a1a1;
            background-color: transparent;
            border-radius: 0;
            box-shadow: none !important;
        }
        .dropdown-menu{
            margin: 3.125rem 0 0 !important;
        }

        .bootstrap-tagsinput .tag {
            color: black;
        }
        .extended span {
            display: -webkit-inline-box;
        }
        .tag.extended {
            background-image: none !important;
            padding: 0 15px 12px 15px !important;
        }

        .bootstrap-tagsinput .tag [data-role="remove"] {
            position: relative;
            padding: 0 15px 0 15px;
            background-position: 10px center;
            background-repeat: no-repeat;
            background-image: url(/images/icons/ico-tag-delete.png);
            background-image: -webkit-image-set(url(/images/icons/ico-tag-delete.png) 1x, url(/images/icons/ico-tag-delete@2x.png) 2x, url(/images/icons/ico-tag-delete@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-tag-delete.png) 1x, url(/images/icons/ico-tag-delete@2x.png) 2x, url(/images/icons/ico-tag-delete@3x.png) 3x);
            background-size: 17px;
        }

        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            content: "";
            padding: 0px 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #525252 !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e3eaff;
            border: 1px solid #e3eaff;
            color: #141415;
        }

    </style>
@endsection

@section('after_scripts')
   
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/simditor/scripts/simditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

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
                    defaultImage: "{{ url(config('app.cloud_url') . '/assets/plugins/simditor/images/image.png') }}",
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
                    textarea: $('#pageContent2'),
                    //placeholder: 'Describe what makes your ad unique...',
                    toolbar: toolbar,
                    pasteImage: false,
                    defaultImage: "{{ url(config('app.cloud_url') . '/assets/plugins/simditor/images/image.png') }}",
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

        // var companyId = $("#companyId option:selected").val();

        // alert(companyId);
        
        // if(companyId == 0 ){
        //     $('#newcompany').show();
        //     $('#newCompanyInput').attr('required', 'required');
        //     $('#oldcompany').hide();
        // }


        var postCompanyId = '{{ old('company_id', (isset($postCompany) ? $postCompany->id : 0)) }}';
        getCompany(postCompanyId);

        // var companyId = $("#companyId").find("option:selected").val();
         
         // if(companyId != null || companyId != undefined || companyId != "" && companyId == 0 ){
         //    $("#newcompany").show();
         //    $('#newCompanyInput').attr('required', true);
         //    $('#oldcompany').hide();
         // }

        // commented city code
        // var code = $("#country option:selected").val();
        // getCityByCountryCode(code);

        // var companyId = $("#companyId option:selected").val();
        
        // if(companyId == 0 ){
        //     $('#newcompany').show();
        //     $('#oldcompany').hide();
        //     $('#newCompanyInput').attr('required', true);
        // }


        function getCompany(t) {

            if (t == 0){
              $("#logoField").hide();
              $("#logoFieldValue").html("");
              $("#companyFields").show();

            } else {
                $("#companyFields").hide();
                var e = $("#companyId").find("option:selected").data("logo");
                $("#logoFieldValue").html('<img class="from-img full-width" src="' + e + '">');
                // var i = $("#companyFormLink").attr("href");
                // i = i.replace(/companies\/([0-9]+)\/edit/, "companies/" + t + "/edit"), $("#companyFormLink").attr("href", i), $("#logoField").show()
            }
        }


        $('#companyId').bind('change', function() {
            postCompanyId = $(this).val();
            if(postCompanyId !== '0'){
                // $('.edit-company').show();
                getCompany(postCompanyId);
            }else{
                $('#newcompany').show();
                $('#oldcompany').hide();
                $('#newCompanyInput').attr('required', true);
            }
        });

        var ismodel = '<?php echo $post->ismodel; ?>';

        $('#gender_type').bind('change', function() {
            
            if(ismodel == 1){
                checkBabyCategory();
                dressSizeShowHide();
                shoeSizeShowHide();
            }
        });

        $('#modelCategory').bind('change', function() {

            checkBabyCategory();
            dressSizeShowHide();
            shoeSizeShowHide();
        });

        // after submit selected post type is whole-day, hide end_date div 
        var is_one_day = $('#post_type option:selected').attr('is_one_day');
        if(is_one_day == 1){
            $('#end_date_div').hide();
            $('#is_one_day').val('1');
        }

        // post type change event
        $('#post_type').change( function(){
            var is_one_day = $('#post_type option:selected').attr('is_one_day');
            // if whole-day hide end date.
            if(is_one_day == 1){
                $('#end_date_div').hide();
                $('#is_one_day').val('1');
            }else{
                $('#end_date_div').show();
                $('#is_one_day').val('0');
            }
        });

        // commented city code 
        // $('#country').bind('change', function(e){
        //    var code = $("#country option:selected").val();
        //    if(code !== ''){
        //     getCityByCountryCode(code);
        //    }else{
        //         $("#city").empty().append("<option value=''>{{ t('Select a city') }}</option>");
        //     }
        // });

        

        // function getCityByCountryCode(code){
        //     var siteUrl =  window.location.origin;
        //     if (typeof code !== 'undefined' && code != "" && code != null ) {
        //         var url = "/ajax/citiesByCode/"+code;
        //          $.ajax({
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
        //         });

        //    }
        // }

        var loadLogoFile = function(event) {

            var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            var filename = event.target.files[0].name;
            
            var extension = filename.replace(/^.*\./, '');
            extension = extension.toLowerCase();

            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);

            if($.inArray(extension, ['gif','png','jpg','jpeg']) == -1) {
                $('#error-profile-logo').html('{{ t("invalid_image_type") }}').css("color", "red");
                return false;
            }else{
                $('#error-profile-logo').html('');
            }
            var fileSize = Math.round((event.target.files[0].size / 1024));
            
            if(fileSize > imageSize){
                $('#error-profile-logo').html('{{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
                return false;
            }else{
                $('#error-profile-logo').html('');
            }
        };


         jQuery.noConflict()(function(jQuery){
            var date = new Date();
            date.setDate(date.getDate());

            var siteUrl =  window.location.origin;
            var languageCode = '<?php echo config('app.locale'); ?>';

            jQuery( "#start_date" ).datepicker({
                "startDate":date,
                "autoclose": true,
                "format": 'yyyy-mm-dd'
            });

            jQuery( "#end_date" ).datepicker({
                "startDate":date,
                "autoclose": true,
                "format": 'yyyy-mm-dd'
            });

            jQuery( "#end_application" ).datepicker({
                "startDate":date,
                "autoclose": true,
                "format": 'yyyy-mm-dd'
            });

            jQuery('#tags').tagsinput({
              tagClass: 'extended'
            });

            // var selectedCat = jQuery('select[name=parent[]]').find('option:selected');

            // getSubCategories(siteUrl, languageCode, selectedCat.val(), 0);

            jQuery('#parent').bind('change', function(e) {
                var selectedCat = jQuery('select[name=parent]').find('option:selected');
                jQuery('#category').val(jQuery(this).val());  
                jQuery('#parent_type').val(selectedCat.data('type'));
                // catObj = getSubCategories(siteUrl, languageCode, jQuery(this).val(), 0);
            });

            var lang = {
                'select': {
                    'category': "{{ t('Select a category') }}",
                    'subCategory': "{{ t('Select a sub-category') }}",
                    'country': "{{ t('Select a country') }}",
                    'admin': "{{ t('Select a location') }}",
                    'city': "{{ t('Select a city') }}"
                },
                'price': "{{ t('Price') }}",
                'salary': "{{ t('Salary') }}",
                'nextStepBtnLabel': {
                    'next': "{{ t('Next') }}",
                    'submit': "{{ t('Submit') }}"
                }
            };

            // jQuery('#category').val(jQuery('select[name=parent[]] :selected').val());

            function getSubCategories(siteUrl, languageCode, catId, selectedSubCatId)
            {
                /* Check Bugs */
                if (typeof languageCode === 'undefined' || typeof catId === 'undefined') {
                    return false;
                }

                /* Don't make ajax request if any category has selected. */
                if (catId === 0 || catId === '') {
                    /* Remove all entries from subcategory field. */
                    $('#category').empty().append('<option value="0">' + lang.select.subCategory + '</option>').val('0').trigger('change');
                    return false;
                }
                
                /* Default number of sub-categories */
                var countSubCats = 0;
                var siteUrl = window.location.origin;
                /* Make ajax call */
                $.ajax({
                    method: 'POST',
                    url: siteUrl + '/ajax/category/sub-categories',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'catId': catId,
                        'selectedSubCatId': selectedSubCatId,
                        'languageCode': languageCode
                    },
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                }).done(function(obj)
                {
                    /* init. */
                    $('#category').empty().append('<option value="0">' + lang.select.subCategory + '</option>').val('0').trigger('change');
                    
                    /* error */
                    if (typeof obj.error !== "undefined") {
                        $('#category').find('option').remove().end().append('<option value="0"> '+ obj.error.message +' </option>');
                        $('#category').closest('.form-group').addClass('has-error');
                        return false;
                    } else {
                        /* $('#category').closest('.form-group').removeClass('has-error'); */
                    }
                    
                    if (typeof obj.subCats === "undefined" || typeof obj.countSubCats === "undefined") {
                        return false;
                    }
                    
                    /* Bind data into Select list */
                    if (obj.countSubCats == 1) {
                        $('#subCatBloc').hide();
                        $('#category').empty().append('<option value="' + obj.subCats[0].tid + '">' + obj.subCats[0].name + '</option>').val(obj.subCats[0].tid).trigger('change');
                    } else {
                        $('#subCatBloc').show();
                        $.each(obj.subCats, function (key, subCat) {
                            if (selectedSubCatId == subCat.tid) {
                                $('#category').append('<option value="' + subCat.tid + '" selected="selected">' + subCat.name + '</option>');
                            } else
                                $('#category').append('<option value="' + subCat.tid + '">' + subCat.name + '</option>');
                        });
                    }
                    
                    /* Get number of sub-categories */
                    countSubCats = obj.countSubCats;
                });
                
                /* Get result */
                return {
                    'catId': catId,
                    'countSubCats': countSubCats
                };
            }
        });

        var babyModels_category = '<?php echo json_encode($babyModels_category); ?>';
        var is_baby = false;
        var babyCategoryArr = JSON.parse(babyModels_category);

        if(ismodel == 1){

            checkBabyCategory();
            modelCategoryChangeEvent();
            dressSizeShowHide();
            shoeSizeShowHide(); 
        }

        function modelCategoryChangeEvent(){

            $('#modelcate').show();
            $('#modelCategory').prop('required', true);
            dressSizeShowHide();
            shoeSizeShowHide();
        }


       var CurentSelectedCategoryArr = [];

        function checkBabyCategory(){

            is_baby = false;
            modelCat = false;

            CurentSelectedCategoryArr = $('#modelCategory').val();
            
            if(CurentSelectedCategoryArr != null){
                
                $.each(CurentSelectedCategoryArr, function (key, val) {
                    
                    if(babyCategoryArr[val] != undefined){
                        is_baby = true;
                    }else{
                        modelCat = true;
                    }
                });
            }
            
            return {
                is_baby: is_baby,
                modelCat: modelCat,
            };
        }

        function dressSizeShowHide(){

            var is_men_checkd_all = false;
            var is_women_checkd_all = false;
            var is_kids_checkd_all = false;

            if(is_baby == true){
               
                $('#is_baby').val('1');
                $('#baby_models_dress_size_div').show();

                if($('.bds:checked').length == $('.bds').length){
                    is_kids_checkd_all = true;
                }

            }else{

                $('#is_baby').val('0');
                $('#baby_models_dress_size_div').hide();
            }

            if(modelCat == true && $("#gender_type option:selected").val() == 1){

                $('#is_model_category').val('1');
                $('#men_models_dress_size_div').show();
                $('#women_models_dress_size_div').hide();

                if($('.mds:checked').length == $('.mds').length){
                    is_men_checkd_all = true;
                }
            }
            else if(modelCat == true && $("#gender_type option:selected").val() == 2){

                $('#is_model_category').val('1');
                $('#men_models_dress_size_div').hide();
                $('#women_models_dress_size_div').show();

                if($('.wds:checked').length == $('.wds').length){
                    is_women_checkd_all = true;
                }
            }else{

                if(modelCat == true){

                    $('#is_model_category').val('1');
                    $('#men_models_dress_size_div').show();
                    $('#women_models_dress_size_div').show();

                    if($('.wds:checked').length == $('.wds').length){
                        is_women_checkd_all = true;
                    }

                    if($('.mds:checked').length == $('.mds').length){
                        is_men_checkd_all = true;
                    }
                }else{

                    $('#is_model_category').val('0');
                    $('#men_models_dress_size_div').hide();
                    $('#women_models_dress_size_div').hide();
                }
            }

            $('#dress_women_all').attr('checked', false);
            $('#dress_kid_all').attr('checked', false);
            $('#dress_men_all').attr('checked', false);

            if(is_men_checkd_all == true){

                $('#dress_men_all').prop('checked', true);
            }

            if(is_women_checkd_all == true){

                $('#dress_women_all').prop('checked', true);
            }

            if(is_kids_checkd_all == true){

                $('#dress_kid_all').prop('checked', true);
            }
        }

        function shoeSizeShowHide(){

            if(is_baby == true){

                $('#baby_models_shoe_size_div').show();
            }else{

                $('#baby_models_shoe_size_div').hide();
            }

            if(modelCat == true && $("#gender_type option:selected").val() == 1){

                $('#men_models_shoe_size_div').show();
                $('#women_models_shoe_size_div').hide();
            }
            else if(modelCat == true && $("#gender_type option:selected").val() == 2){

                $('#men_models_shoe_size_div').hide();
                $('#women_models_shoe_size_div').show();
            }else{
                
                if(modelCat == true){
                    
                    $('#men_models_shoe_size_div').show();
                    $('#women_models_shoe_size_div').show();
                }else{

                    $('#men_models_shoe_size_div').hide();
                    $('#women_models_shoe_size_div').hide();
                }
            }
        }

        $('#dress_kid_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#baby_models_dress_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#baby_models_dress_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#dress_women_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#women_models_dress_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#women_models_dress_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#dress_men_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#men_models_dress_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#men_models_dress_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#shoe_kid_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#baby_models_shoe_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#baby_models_shoe_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('#shoe_women_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#women_models_shoe_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#women_models_shoe_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });


    $('#shoe_men_all').bind('click', function(){

        if($(this).prop("checked") == true){
            $('#men_models_shoe_size_div input').each( function(){
                $(this).prop("checked", true);
            });
        }else{
            $('#men_models_shoe_size_div input:checked').each( function(){
                $(this).prop("checked", false);
            });
        }
    });

    $('.mds').change(function(){
        if($(this).prop("checked") == false){
            $('#dress_men_all').prop("checked", false);
        }
    });

    $('.bds').change(function(){
        if($(this).prop("checked") == false){
            $('#dress_kid_all').prop("checked", false);
        }
    });

    $('.wds').change(function(){
        if($(this).prop("checked") == false){
            $('#dress_women_all').prop("checked", false);
        }
    });

    $('.bs').change( function(){
        if($(this).prop("checked") == false){
            $('#shoe_kid_all').prop("checked", false);
        }
    });

    $('.ws').change( function(){
        if($(this).prop("checked") == false){
            $('#shoe_women_all').prop("checked", false);
        }
    });

    $('.ms').change( function(){
        if($(this).prop("checked") == false){
            $('#shoe_men_all').prop("checked", false);
        }
    });
    
    // check hidden input is_date_announce 0 or 1
    if($('#is_date_announce_hidden').val() == '1'){
        $('#is_date_announce').val('1');
        $('#is_date_announce').prop("checked", true);
        $('#start_date').val('');
        $('#end_date').val('');
        $('#start_date').attr("disabled", "disabled");
        $('#end_date').attr("disabled", "disabled");
        $('#start_date').addClass('disable-input');
        $('#end_date').addClass('disable-input');
    }else{
        $('#is_date_announce').val('0');
        $('#is_date_announce').prop("checked", false);
        $('#start_date').removeAttr('disabled');
        $('#end_date').removeAttr('disabled');
        $('#start_date').removeClass('disable-input');
        $('#end_date').removeClass('disable-input');
    }
    
    // change event checkbox is_date_announce, and value change on change event
    $('#is_date_announce').change(function(){
        $('#start_date').removeAttr('disabled');
        $('#end_date').removeAttr('disabled');
        $('#start_date').removeClass('disable-input');
        $('#end_date').removeClass('disable-input');
        if($(this).val() == '1'){
            $(this).val('0');
            $('#is_date_announce_hidden').val('0');
        }else{
            $(this).val('1');
            $('#is_date_announce_hidden').val('1');
            $('#start_date').val('');
            $('#start_date').attr("disabled", "disabled");
            $('#end_date').val('');
            $('#end_date').attr("disabled", "disabled");
            $('#start_date').addClass('disable-input');
            $('#end_date').addClass('disable-input');
        }
    });

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';

    // Safari 3.0+ "[object HTMLElementConstructor]" 
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

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
                    
                    if($(requiredField).attr('name') === "company[name]"){
                        $('#company-name-jq-err').find('.error-text-safari').css('display','block');
                    }else if($(requiredField).attr('name') === "parent[]"){
                        $('#parent-jq-err').find('.error-text-safari').css('display','block');
                    }else{
                        var err_f = $(requiredField).attr('name')+'-jq-err';
                        $('#'+err_f).find('.error-text-safari').css('display','block');
                    }

                    if($("input[name='ismodel']:checked").val() == 1){
                        if($(requiredField).attr('name') === "modelCategory[]"){
                            $('#modelcate').find('.error-text-safari').css('display','block');
                        }
                    }else{
                        if($(requiredField).attr('name') === "branch[]"){
                            $('#partnercate').find('.error-text-safari').css('display','block');
                        }
                    }
                }

                is_validation_true = false;

                return false;
            }

        });

        if(isFirefox || isSafari){
            if($("#companyId option:selected").val() == 0){
                if($('#pageContent').val() == ""){
                    $('#company-description-jq-err').find('.error-text-safari').css('display','block');
                    is_validation_true = false;
                    return false;
                }
            }

            if($('#pageContent2').val() == ""){
                $('#pageContent2-jq-err').find('.error-text-safari').css('display','block');
                is_validation_true = false;
                return false;
            }
        }

        if(is_validation_true){
            $('#postForm').submit();
        }   
                
    });

    // height weight validation
    jQuery.noConflict()(function($){
        
        // model height validation
        $('#height_to').removeAttr('required');
        var height_from = $('#height_from').val();
        
        if(height_from != '' && height_from != 0){

            $('#height_to').prop('required', true);
        }

        // height from change event, if not empty height from required height to.
        $('#height_from').change(function(){
            
            $('#height_to').removeAttr('required');
            
            if($(this).val() != '' && $(this).val() != 0){
                $('#height_to').prop('required', true);
            }else{
                $('#height_to').val('').trigger('change');
            }
        });

        // model weight validation
        $('#weight_to').removeAttr('required');
        var height_from = $('#weight_from').val();
        
        if(height_from != '' && height_from != 0){

            $('#weight_to').prop('required', true);
        }

        // weight from change event, if not empty weight from required weight to.
        $('#weight_from').change(function(){
            
            $('#weight_to').removeAttr('required');
            if($(this).val() != '' && $(this).val() != 0){
                $('#weight_to').prop('required', true);
            }else{
                $('#weight_to').val('').trigger('change');
            }
        });
    });

    </script>
@endsection
 
