@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">{{ t('Post a Job') }}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <?php /*
            <!-- <div class="custom-tabs mb-20 mb-xl-30">
                @include('post.inc.wizard_new')
            </div> --> */ ?>
            <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
            </div>
        </div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto" id="box-shadow">
            
            {{ Form::open(array('url' => url()->current(), 'method' => 'post', 'files' => true, 'id' => 'postForm', 'autocomplete' => 'off' )) }}
          
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pt-40 px-38 px-lg-0">
                    
                        <div class="pb-20 mb-20 bb-light-lavender3" id="newcompany" style="display: none;">
                                <h2 class="bold f-18 lh-18">{{ t('Company details') }}</h2>
                                <div class="divider"></div>
                                <div class="input-group <?php echo (isset($errors) and $errors->has('company.name')) ? 'err-invalid' : ''; ?>" id="company-name-jq-err">
                                    {{ Form::label(t('Company Name'), t('Company Name'), ['class' => 'input-label position-relative required']) }}
                                    {{ Form::text('company[name]', old('company[name]'), ['class' => 'animlabel', 'minlength' => '2', 'maxlength' => '200', 'placeholder' => '', 'id'=>'newCompanyInput']) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                <div class="input-group <?php echo (isset($errors) and $errors->has('company.description')) ? 'err-invalid' : ''; ?>" id="company-description-jq-err">
                                    {{ Form::label(t('Company Description'), t('Company Description'), ['class' => 'input-label position-relative required']) }}
                                    {{ Form::textarea('company[description]', old('company[description]'), ['class' => 'animlabel textarea-description', 'id' => 'pageContent']) }}
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                
                                <?php /*
                                   <!--  <div class="input-group">
                                            <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)" class="upload_white mb-20" >
                                            <label id="error-profile-logo" class=""></label>
                                    </div> --> 
                                */ ?>

                                <div class="pb-40 mb-40 ">
                                    <h2 class="bold f-18 lh-18">{{ t('Logo') }}</h2>
                                    <div class="divider"></div>

                                    <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                                        <div class="pt-40 px-38 px-lg-0">
                                            <div class="pb-20 mb-20 d-md-flex">
                                                <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                                    
                                                    <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.User') }}">

                                                </div>
                                                <div class="d-md-inline-block">
                                                    <?php /*
                                                    <!-- <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)" class="upload_white mb-20"> --> */ ?>
                                                    
                                                    <div class="upload-btn-wrapper">
                                                      <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo') }}</a>
                                                      <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)"  />
                                                    </div>

                                                    <p class="w-lg-460">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                                    <p id="error-profile-logo" class=""></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </div>

                    <div class="pb-20 mb-20 bb-light-lavender3" id="oldcompany">
                        <h2 class="bold f-18 lh-18">{{ t('Company Information') }}</h2>
                        <div class="divider"></div>
                        <div class="input-group <?php echo (isset($errors) and $errors->has('company_id')) ? 'select-err-invalid' : ''; ?>" id="companyId-jq-err">
                            {{ Form::label('company', t('Select a Company') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="company_id" id="companyId" class="form-control">
                                <option value="0">{{ '[+]' }} {{ t('New Company') }}</option>
                                @if (isset($companies) and $companies->count() > 0)
                                @foreach ($companies as $item)
                                    <option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}" @if (old('company_id', (isset($postCompany) ? $postCompany->id : 0))==$item->id)
                                                                        selected="selected"
                                                                    @endif > {{ $item->name }} </option>
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
                        <div class="input-group edit-company">
                            <?php $attr = ['countryCode' => config('country.icode'), 'id' => 0]; ?>
                            <a class="btn btn-success" id="companyFormLink" href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}">{{ t('Edit the Company') }}</a>
                        </div> */ ?>
                    </div>

                    <div class="pb-20 mb-20 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Job\'s Details') }}</h2>
                        <div class="divider"></div>
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('parent')) ? 'select-err-invalid' : ''; ?>" id="parent-jq-err">
                            {{ Form::label(t('Category'), t('Category') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="parent[]" id="parent" class="form-control" multiple="true" required>
                                @if( isset($categories) && count($categories) > 0 )
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                            @if(old('parent'))
                                                @if (in_array($cat->parent_id, old('parent')))
                                                    selected="selected"
                                                @endif
                                            @endif
                                    > {{ $cat->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
                        </div>
                        <?php /*
                        <!-- <div class="input-group <?php //echo (isset($errors) and $errors->has('category')) ? 'err-invalid' : ''; ?>" id="subCatBloc">
                            {{ Form::label(t('Sub-Category'), t('Sub-Category') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="category" id="category" class="form-control">
                                <option value="0" @if (old('category')=='' or old('category')==0) selected="selected" @endif > {{ t('Select a sub-category') }} </option>
                            </select>
                        </div> --> */ ?>

                        <div class="input-group"> 
                            {{ Form::label(t("I'm looking for"), t("I'm looking for") , ['class' => 'control-label required input-label position-relative']) }}
                            <div class="input-group custom-radio mt-10 mb-10 <?php echo (isset($errors) and $errors->has('ismodel')) ? 'err-invalid' : ''; ?>" id="ismodel-jq-err">

                                <input type="radio" name="ismodel" value="1" class='radio_field' id="Model" @if (old('ismodel')=='' or old('ismodel')==1) checked="checked" @endif  checked="checked" >

                                {{ Form::label('Model', t('Model'), ['class' => 'd-inline-block radio-label col-sm-3']) }}

                                <input type="radio" name="ismodel" value="0" class='radio_field' id="Partner" @if (old('ismodel')=="0")  checked="checked"  @endif>

                                {{ Form::label('Partner', t('Client'), ['class' => 'd-inline-block radio-label col-sm-3']) }}
                            </div>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <input type="hidden" name="is_baby" id="is_baby" value="{{ old('is_baby') }}">
                        <input type="hidden" name="is_model_category" id="is_model_category" value="{{ old('is_model_category') }}">

                        <!-- static gender as 9/Male, 10/Female, 2 /Both  -->
                        <div class="input-group <?php echo (isset($errors) and $errors->has('gender_type')) ? 'select-err-invalid' : ''; ?>" id="gender_type-jq-err">
                            {{ Form::label(t('Gender'), t('Gender') , ['class' => 'control-label required input-label position-relative']) }}

                            <select name="gender_type" id="gender_type" class="form-control" required>
                               <option value=""
                                        @if (old('gender_type')=='' or old('gender_type')==0)
                                            selected="selected"
                                        @endif
                                >
                                    {{ t('Select') }}
                                </option>
                                <option value="0" {{ (old('gender_type') == '0') ? 'selected' : '' }}>{{ t("Both") }} </option>

                                @if (isset($genders) && $genders->count() > 0)
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->tid }}" {{ (old('gender_type') == $gender->tid) ? 'selected' : '' }} >{{ t($gender->name) }} </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>


                        <div class="input-group <?php echo (isset($errors) and $errors->has('modelCategory')) ? 'select-err-invalid' : ''; ?>" id="modelcate" style="display: none;">

                            {{ Form::label(t('Sub-Category'), t('Sub-Category') , ['class' => 'control-label required input-label position-relative']) }}

                            <select name="modelCategory[]" id="modelCategory" class="form-control" multiple="true">
                                @if(isset($modelCategories) && $modelCategories->count() > 0 )
                                    @foreach ($modelCategories as $cat)
                                        <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                                @if(old('modelCategory'))
                                                    @if (in_array($cat->parent_id, old('modelCategory')))
                                                        selected="selected"
                                                    @endif
                                                @endif
                                        > {{ $cat->name }} </option> 
                                    @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class=" input-group <?php echo (isset($errors) and $errors->has('branch')) ? 'select-err-invalid' : ''; ?>" id="partnercate">
                            {{ Form::label(t('Sub-Category'), t('Sub-Category') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="branch[]" id="branch" class="form-control" multiple="true">
                                @if(isset($branches) && count($branches) > 0)
                                @foreach ($branches as $cat)
                                    <option value="{{ $cat->parent_id }}" data-type="{{ $cat->type }}"
                                            @if(old('branch'))
                                                @if (in_array($cat->parent_id, old('branch')))
                                                    selected="selected"
                                                @endif
                                            @endif
                                    > {{ $cat->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                            <input type="hidden" name="branch_type" id="branch_type" value="{{ old('branch_type') }}">
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('title')) ? 'err-invalid' : ''; ?>" title="{{ t('A great title needs at least 60 characters') }}" id="title-jq-err">
                            {{ Form::label(t('Title'), t('Title'), ['class' => 'position-relative control-label required input-label']) }}
                            {{ Form::text('title', old('title'), ['class' => 'animlabel', 'id' => 'title' ,'required','placeholder' =>  t('Job\'s Title')]) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('description')) ? 'textarea-err-invalid' : ''; ?>" title="{{ t('Describe what makes your ad unique') }}" id="pageContent2-jq-err">
                            <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                            {{ Form::label(t('Job Description'), t('Job Description'), ['class' => 'position-relative input-label required']) }}
                            {{ Form::textarea('description', old('description'), ['class' => 'animlabel"'.$ckeditorClass.'"', 'id' => 'pageContent2']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('post_type')) ? 'select-err-invalid' : ''; ?>" id="post_type-jq-err">
                            {{ Form::label(t('Job Type'), t('Job Type') , ['class' => 'control-label required input-label position-relative']) }}
                            <select name="post_type" id="post_type" class="form-control" required>
                                @if(isset($postTypes) && count($postTypes) > 0)
                                @foreach ($postTypes as $postType)
                                <option is_one_day = "{{ $postType->is_one_day }}" value="{{ $postType->tid }}"
                                        @if (old('post_type')==$postType->tid)
                                            selected="selected"
                                        @endif
                                > {{ $postType->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                        <input type="hidden" id="is_one_day" name="is_one_day" value="0">

                        <div class="row">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_min')) ? 'err-invalid' : ''; ?>">
                                <label for="geschlecht" class="control-label input-label position-relative">{{ t('Salary :currency (min)', ['currency' => $currency]) }}</label>
                                <input id="salary_min" name="salary_min" class="animlabel" placeholder="{{ t('Salary Min') }}" type="text" value="{{ old('salary_min') }}">
                            </div>
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_max')) ? 'err-invalid' : ''; ?>">
                                <label for="geschlecht" class="control-label input-label position-relative">{{ t('Salary :currency (max)', ['currency' => $currency]) }}</label>
                                <input id="salary_max" name="salary_max" class="animlabel" placeholder="{{ t('Salary Max') }}" type="text" value="{{ old('salary_max') }}">
                            </div>
                            <input type="hidden" name="currency_code" value="{{ ($currency_code)? $currency_code : '' }}">
                        </div>

                        <div class="row custom-checkbox">
                            <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('salary_type')) ? 'select-err-invalid' : ''; ?>" id="salary_type-jq-err">
                                <label for="geschlecht" class="control-label required input-label position-relative">{{ t('Salary Pay Range') }}</label>
                                <select name="salary_type" id="salary_type" class="form-control" required>
                                    @if(isset($salaryTypes) && count($salaryTypes) > 0)
                                    @foreach ($salaryTypes as $salaryType)
                                        <option value="{{ $salaryType->tid }}"
                                                @if (old('salary_type')==$salaryType->tid)
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
                           <div class="col-md-6 form-group mb-20">
                                <label for="geschlecht" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="negotiable" name="negotiable" value="1" type="checkbox" @if (old('negotiable') === '1') checked="checked" @endif>
                                <label for="negotiable" class="checkbox-label col-md-6">{{ t('Negotiable') }}</label>
                            </div>
                        </div>

                        <?php 
                            $start_date_error_class = '';
                            $end_date_error_class = '';
                            
                            if(isset($errors) && $errors->has('start_date')){
                                $start_date_error_class = 'invalid';
                            }

                            if(isset($errors) && $errors->has('end_date')){
                                $end_date_error_class = 'invalid';
                            } 
                        ?>

                        <div class="row custom-checkbox">
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label(t('Start Date'), t('Start Date'), ['class' => 'position-relative control-label input-label']) }}
                                {{ Form::text('start_date', old('start_date', date('Y-m-d')), ['class' => $start_date_error_class, 'id' => 'start_date' , 'placeholder' => t('Start Date'), 'readonly' => true]) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                <label for="is_date_announce" class="control-label input-label position-relative"></label>
                                <input class="checkbox_field" id="is_date_announce" name="is_date_announce" value="0" type="checkbox" @if (old('is_date_announce') === '1') checked="checked" @endif>
                                <label for="is_date_announce" class="checkbox-label">{{ t('to be announced') }}</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div id="end_date_div" class="col-md-6 form-group mb-20">
                                {{ Form::label(t('End Date'), t('End Date'), ['class' => 'position-relative control-label input-label']) }}
                                {{ Form::text('end_date', old('end_date', date('Y-m-d')), ['class' => $end_date_error_class, 'id' => 'end_date' , 'placeholder' => t('End Date'), 'readonly' => true]) }}
                            </div>
                        </div>

                        <?php /*
                        <div class="input-group <?php echo (isset($errors) and $errors->has('start_date')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Start Date'), t('Start Date'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('start_date', old('start_date', date('Y-m-d')), ['class' => 'animlabel', 'id' => 'start_date' , 'placeholder' => t('Start Date'), 'readonly' => true]) }}
                        </div>

                        <div id="end_date_div" class="input-group <?php echo (isset($errors) and $errors->has('end_date')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('End Date'), t('End Date'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('end_date', old('end_date', date('Y-m-d')), ['class' => 'animlabel', 'id' => 'end_date' , 'placeholder' => t('End Date'), 'readonly' => true]) }}
                        </div>
                        */ ?>
                        <div class="input-group <?php echo (isset($errors) and $errors->has('experience_type')) ? 'select-err-invalid' : ''; ?>" id="experience_type-jq-err">
                            {{ Form::label(t('Experience'), t('Experience') , ['class' => 'control-label input-label position-relative']) }}
                            <select name="experience_type" id="experience_type" class="form-control">
                                <option value=""
                                        @if (old('experience_type')=='' or old('experience_type')==0)
                                            selected="selected"
                                        @endif
                                >
                                    {{ t('Select') }}
                                </option>
                                @if(isset($experienceTypes) && count($experienceTypes) > 0)
                                @foreach ($experienceTypes as $type)
                                    <option value="{{ $type->id }}" {{ ($type->id == old('experience_type')) ? 'selected' : '' }}>
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
                                <input class="checkbox_field" id="is_home_job" name="is_home_job" value="1" type="checkbox">
                                <label for="is_home_job" class="checkbox-label">{{ t('is_home_job') }}</label>
                            </div>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('tfp')) ? 'err-invalid' : ''; ?>" id="tfp-jq-err">
                            {{ Form::label(t("TFP"), t("TFP") , ['class' => 'control-label required input-label position-relative']) }}
                            <div class="input-group custom-radio mt-10">
                                <input type="radio" name="tfp" value="1" class='radio_field' id="Yes" @if (old('tfp')=='' or old('tfp')==1) checked="checked" @endif>

                                {{ Form::label('Yes', t('Yes'), ['class' => 'd-inline-block radio-label col-sm-3']) }}
                                
                                <input type="radio" name="tfp" value="0" class='radio_field' id="No" @if (old('tfp') == 0) checked="checked" @endif>

                                {{ Form::label('No', t('No'), ['class' => 'd-inline-block radio-label col-sm-3']) }}
                            </div>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>
                    <div id="input-valid">    
                        <div id="showModelFields" style="display: none;"> 
                            <!-- Only show model is selected start  -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('height_from')) ? 'select-err-invalid' : ''; ?>" id="height_from-jq-err">
                                    <label class="control-label input-label position-relative">{{ t('Body height') }} ( {{ t('from') }} )</label>
                                    <select name="height_from" id="height_from" class="form-control">
                                        <option value="">{{  t('Select height')}}</option>
                                        @if(isset($properties['height']) && count($properties['height']) > 0 )
                                        <?php foreach($properties['height'] as $key=>$cat){ ?>
                                            <option value="{{$key}}" @if (old('height_from')== $key)
                                                selected="selected"
                                            @endif>{{ $cat }}</option><?php } ?>
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('height_to')) ? 'select-err-invalid' : ''; ?>" id="height_to-jq-err">
                                    <label class="control-label input-label position-relative">{{ t('Body height') }} ( {{ t('to') }} )</label>
                                    <select name="height_to" id="height_to" class="form-control">
                                        <option value="">{{  t('Select height')}}</option>
                                        @if(isset($properties['height']) && count($properties['height']) > 0 )
                                        <?php foreach($properties['height'] as $key=>$cat){ ?>
                                            <option value="{{$key}}" @if (old('height_to')== $key)
                                                selected="selected" @endif>{{$cat}}</option><?php } ?>
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('weight_from')) ? 'select-err-invalid' : ''; ?>" id="weight_from-jq-err">
                                    <label class="control-label input-label position-relative">{{ t('Body weight') }} ( {{ t('from') }} )</label>
                                    <select name="weight_from" id="weight_from" class="form-control">
                                        <option value="">{{  t('Select weight')}}</option>
                                        @if(isset($properties['weight']) && count($properties['weight']) > 0 )
                                        <?php foreach($properties['weight'] as $key=>$cat){ ?>
                                            <option value="{{$key}}" @if (old('weight_from')== $key)
                                                selected="selected" @endif >{{$cat}}</option><?php } ?>
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('weight_to')) ? 'select-err-invalid' : ''; ?>" id="weight_to-jq-err">
                                    <label class="control-label input-label position-relative">{{ t('Body weight') }} ( {{ t('to') }} )</label>
                                    <select name="weight_to" id="weight_to" class="form-control">
                                        <option value="">{{  t('Select weight')}}</option>
                                        @if(isset($properties['weight']) && count($properties['weight']) > 0 )
                                        <?php foreach($properties['weight'] as $key=>$cat){ ?>
                                            <option value="{{ $key }}" @if (old('weight_to')== $key)
                                                selected="selected" @endif>{{ $cat }}</option><?php } ?>
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('age_from')) ? 'select-err-invalid' : ''; ?>" id="age_from-jq-err">
                                    <label class="control-label required input-label position-relative">{{ t('Age') }} ( {{ t('from') }} )</label>
                                    <select name="age_from" id="age_from" class="form-control">
                                        <option value="" selected="selected">{{  t('Select age')}}</option>
                                        @if(isset($properties['age']) && count($properties['age']) > 0 )
                                        @foreach($properties['age'] as $key =>  $ageFrom)
                                            <option value="{{ $key }}" @if (old('age_from') == $key)
                                                selected="selected" @endif >{{ $ageFrom }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('age_to')) ? 'select-err-invalid' : ''; ?>" id="age_to-jq-err">
                                    <label  class="control-label required input-label position-relative">{{ t('Age') }} ( {{ t('to') }} )</label>
                                    <select name="age_to" id="age_to" class="form-control">
                                        <option value="" selected="selected">{{  t('Select age')}}</option>
                                        @if(isset($properties['age']) && count($properties['age']) > 0 )
                                        @foreach($properties['age'] as $key => $ageTo)
                                             <option value="{{ $key }}" @if (old('age_to') == $key)
                                                selected="selected" @endif>{{ $ageTo }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                                </div>
                            </div>
                            <?php
                                /* $dress_unit = "standard";
                                if(isset(Auth::user()->country) && isset(Auth::user()->country->dress_size_unit)) {
                                    $dress_unit = Auth::user()->country->dress_size_unit;
                                } */
                            ?>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="mb-40 bb-light-lavender3" id="women_models_dress_size_div" style="display: none;">
                                    <div>
                                        <div class="mb-20">
                                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseWomanDress">
                                                <strong class="lh-18 required">{{t('women_dress_size_lable')}}
                                                    <!-- <font class="required-font-tag">*</font> -->
                                                </strong>
                                            </a>
                                        </div>
                                        <div id="collapseWomanDress" class="collapse" data-parent="#accordion">
                                            <?php $checked = (old('dress_women_check_all') == 1)? 'checked="checked"' : ''; ?>
                                            <div class="row custom-checkbox">
                                                <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                    <input class="checkbox_field" id="dress_women_all" name="dress_women_check_all" value="1" type="checkbox" {{ $checked }}>
                                                    <label for="dress_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                </div>
                                            </div>
                                            
                                            <div class="row custom-checkbox">
                                                @if(isset($women_dress) && count($women_dress) > 0 )
                                                @foreach ($women_dress as $key => $val)
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('womenDressSize[]',  $key, 0 , ['class' => 'checkbox_field wds', 'id' => 'womenDressSize_'.($key)]) }}

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
                                        <div  class="mb-20">
                                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseMenDress">
                                                <strong  class="lh-18 required">        
                                                    {{t('men_dress_size_lable')}}
                                                    <!-- <font class="required-font-tag">*</font> -->
                                                </strong>
                                            </a>
                                        </div>
                                        <div id="collapseMenDress" class="collapse" data-parent="#accordion">
                                        <?php $checked = (old('dress_men_check_all') == 1)? 'checked="checked"' : ''; ?>
                                            <div class="row custom-checkbox">
                                                <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                    <input class="checkbox_field" id="dress_men_all" name="dress_men_check_all" value="1" type="checkbox" {{$checked}}>
                                                    <label for="dress_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                </div>
                                            </div>

                                            <div class="row custom-checkbox">
                                                @if(isset($men_dress) && count($men_dress) > 0 )
                                                @foreach ($men_dress as $key => $val)
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('menDressSize[]',  $key, 0 , ['class' => 'checkbox_field mds', 'id' => 'menDressSize_'.($key)]) }}

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
                                        <div  class="mb-20">
                                            <a class="card-link collapsed" data-toggle="collapse" href="#collapseBabyDress">
                                                <strong class="lh-18 required">{{t('baby_dress_size_lable')}}
                                                    <!-- <font class="required-font-tag">*</font> -->
                                                </strong>
                                            </a>
                                        </div>
                                        <div id="collapseBabyDress" class="collapse" data-parent="#accordion">
                                        <?php $checked = (old('dress_kid_check_all') == 1)? 'checked="checked"' : ''; ?>
                                            <div class="row custom-checkbox">
                                                <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                    <input class="checkbox_field" id="dress_kid_all" name="dress_kid_check_all" value="1" type="checkbox" {{$checked}}>
                                                    <label for="dress_kid_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                </div>
                                            </div>

                                            <div class="row custom-checkbox">
                                                @if(isset($baby_dress) && count($baby_dress) > 0 )
                                                @foreach ($baby_dress as $key => $val)
                                                    
                                                    <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                        {{ Form::checkbox('babyDressSize[]',  $key, 0 , ['class' => 'checkbox_field bds', 'id' => 'babyDressSize_'.($key)]) }}

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

                            

                            

                             
                            <?php /*

                            <div class="row">
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('dressSize_from')) ? 'err-invalid' : ''; ?>">
                                    <label class="control-label required input-label position-relative">{{ t('Dress size') }} ( {{ t('from') }} )</label>
                                    <select name="dressSize_from" id="dressSize_from" class="form-control">
                                        <option value="">{{  t('Select dress size')}}</option>
                                        <?php  foreach($properties['dress_size'] as $key=>$cat){ ?>
                                            <option value="{{ $key }}" @if (old('dressSize_from')== $key)
                                                selected="selected" @endif >{{ $cat }} </option> <?php  } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('dressSize_to')) ? 'err-invalid' : ''; ?>">
                                    <label class="control-label required input-label position-relative">{{ t('Dress size') }} ( {{ t('to') }} )</label>
                                    <select name="dressSize_to" id="dressSize_to" class="form-control">
                                        <option value="">{{  t('Select dress size')}}</option>
                                       <?php foreach($properties['dress_size'] as $key=>$cat){ ?>
                                            <option value="{{$key}}" @if (old('dressSize_to')== $key)
                                                selected="selected" @endif >{{$cat}}</option> <?php  } ?>
                                    </select>
                                </div>
                            </div>

                            <?php */ ?>

                            <div class="input-group">
                                <label class="checkbox-label" id="addMore"><a href="javascript:void(0);"><strong>+ {{ t('Add more fields') }}</strong></a></label>
                            </div>

                            <?php 
                                $style = 'display:none;';

                                if(isset($errors) &&  ( $errors->has('chest_to') || $errors->has('chest_from') || $errors->has('waist_to') || $errors->has('waist_from') || $errors->has('hips_to') || $errors->has('hips_from') || $errors->has('shoeSize_to') || $errors->has('shoeSize_from') )){
                                    $style = 'display:block;';
                                }


                             ?>
                            <span class="addMoreFields mb-40" style="{{ $style }}">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('chest_from')) ? 'select-err-invalid' : ''; ?>">
                                        <label class="control-label input-label position-relative">{{ t('Chest') }} ( {{ t('from') }} )</label>
                                        <select name="chest_from" id="chest_from" class="form-control">
                                            <option value="">{{  t('Select chest') }}</option>
                                            @if(isset($properties['chest']) && count($properties['chest']) > 0 )
                                            @foreach($properties['chest'] as $key => $chestFrom)
                                                <option value="{{ $key }}" @if (old('chest_from')== $key)
                                                selected="selected" @endif >{{ $chestFrom }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('chest_to')) ? 'select-err-invalid' : ''; ?>">
                                        <label class="control-label  input-label position-relative">{{ t('Chest') }} ( {{ t('to') }} )</label>
                                        <select name="chest_to" id="chest_to" class="form-control">
                                            <option value="">{{ t('Select chest') }}</option>
                                            @if(isset($properties['chest']) && count($properties['chest']) > 0 )
                                            @foreach($properties['chest'] as $key => $chestTo)
                                                <option value="{{ $key }}" @if (old('chest_to')== $key)
                                                selected="selected" @endif>{{ $chestTo }}</option>
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
                                            @if(isset($properties['waist']) && count($properties['waist']) > 0 )
                                            @foreach($properties['waist'] as $key => $waistFrom)
                                                <option value="{{ $key }}" @if (old('waist_from')== $key)
                                                selected="selected" @endif>{{ $waistFrom }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('waist_to')) ? 'select-err-invalid' : ''; ?>">
                                        <label class="control-label input-label position-relative">{{ t('Waist') }} ( {{ t('to') }} )</label>
                                        <select name="waist_to" id="waist_to" class="form-control">
                                            <option value="">{{  t('Select waist')}}</option>
                                            @if(isset($properties['waist']) && count($properties['waist']) > 0 )
                                            @foreach($properties['waist'] as $key => $waistTo)
                                                <option value="{{ $key }}" @if (old('waist_to')== $key)
                                                selected="selected" @endif>{{ $waistTo }}</option>
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
                                            @if(isset($properties['hips']) && count($properties['hips']) > 0 )
                                            @foreach($properties['hips'] as $key => $hipsFrom)
                                                <option value="{{ $key }}" @if (old('hips_from')== $key)
                                                selected="selected" @endif>{{ $hipsFrom }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('hips_to')) ? 'select-err-invalid' : ''; ?>">
                                        <label class="control-label input-label position-relative">{{ t('Hips') }} ( {{ t('to') }} )</label>
                                        <select name="hips_to" id="hips_to" class="form-control">
                                            <option value="">{{  t('Select hips')}}</option>
                                            @if(isset($properties['hips']) && count($properties['hips']) > 0 )
                                            @foreach($properties['hips'] as $key => $hipsTo)
                                                <option value="{{ $key }}" @if (old('hips_to')== $key)
                                                selected="selected" @endif>{{ $hipsTo }}</option>
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
                                            <option value="">{{  t('Select shoe size')}}</option>
                                            <?php foreach($properties['shoe_size'] as $key=>$cat){ ?>
                                                <option value="{{$key}}" @if (old('shoeSize_from')== $key)
                                                selected="selected" @endif>{{$cat}}</option> <?php  } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('shoeSize_to')) ? 'err-invalid' : ''; ?>">
                                        <label class="control-label input-label position-relative">{{ t('Shoe size') }} ( {{ t('to') }} )</label>
                                        <select name="shoeSize_to" id="shoeSize_to" class="form-control">
                                            <option value="">{{  t('Select shoe size')}}</option>
                                            <?php foreach($properties['shoe_size'] as $key=>$cat){ ?>
                                                <option value="{{ $key }}" @if (old('shoeSize_to')== $key)
                                                selected="selected" @endif>{{ $cat }}</option> <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php */ ?>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'select-err-invalid' : ''; ?>">
                                        {{ Form::label(t('Eye color'), t('Eye color') , ['class' => 'control-label  input-label position-relative']) }}
                                        <select name="eyeColor" id="eyeColor" class="form-control">
                                           <option value="">{{ t('Select eye color') }}</option>
                                            @if(isset($properties['eye_color']) && count($properties['eye_color']) > 0 )
                                            <?php foreach($properties['eye_color'] as $key=>$cat){ ?>
                                                <option value="{{ $key }}" @if (old('eyeColor')== $key)
                                                        selected="selected" @endif>{{$cat}}</option><?php } ?>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('hairColor')) ? 'select-err-invalid' : ''; ?>">
                                        {{ Form::label(t('Hair color'), t('Hair color') , ['class' => 'control-label  input-label position-relative']) }}
                                        <select name="hairColor" id="hairColor" class="form-control">
                                           <option value="">{{  t('Select hair color')}}</option>
                                            @if(isset($properties['hair_color']) && count($properties['hair_color']) > 0 )
                                            <?php foreach($properties['hair_color'] as $key=>$cat){ ?>
                                                <option value="{{$key}}" @if (old('hairColor')== $key)
                                                        selected="selected" @endif>{{$cat}}</option><?php } ?>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-20 <?php echo (isset($errors) and $errors->has('skinColor')) ? 'select-err-invalid' : ''; ?>">
                                        {{ Form::label(t('Skin color'), t('Skin color') , ['class' => 'control-label  input-label position-relative']) }}
                                        <select name="skinColor" id="skinColor" class="form-control">
                                           <option value="">{{ t('Select skin color') }}</option>
                                            @if(isset($properties['skin_color']) && count($properties['skin_color']) > 0 )
                                            <?php foreach($properties['skin_color'] as $key=>$cat){ ?>
                                                <option value="{{$key}}" @if (old('skinColor')== $key)
                                                        selected="selected" @endif>{{$cat}}</option><?php } ?>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="panel-group" id="accordionShoes" role="tablist" aria-multiselectable="true">
                                    <div class="mb-40 bb-light-lavender3" id="women_models_shoe_size_div" style="display: none;">
                                        <div>
                                            <div class="mb-20">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseWomenShoes">
                                                    <strong class="lh-18 required">{{t('women_shoe_size_lable')}}</strong>
                                                </a>
                                            </div>
                                            <div id="collapseWomenShoes" class="collapse" data-parent="#accordionShoes">
                                                <?php $checked = (old('shoe_women_check_all') == 1)? 'checked="checked"' : ''; ?>
                                                <div class="row custom-checkbox">
                                                    <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                        <input class="checkbox_field" id="shoe_women_all" name="shoe_women_check_all" value="1" type="checkbox" {{$checked}}>
                                                        <label for="shoe_women_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="row custom-checkbox">
                                                    @if(isset($women_shoe) && count($women_shoe) > 0 )
                                                    @foreach ($women_shoe as $key => $val)
                                                        
                                                        <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                            {{ Form::checkbox('womenShoeSize[]',  $key, 0 , ['class' => 'checkbox_field ws', 'id' => 'womenShoeSize_'.($key)]) }}

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
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseMenShoes">
                                                    <strong class="lh-18 required">{{t('men_shoe_size_lable')}}</strong>
                                                </a>
                                            </div>
                                            <div id="collapseMenShoes" class="collapse" data-parent="#accordionShoes">
                                                <?php $checked = (old('shoe_men_check_all') == 1)? 'checked="checked"' : ''; ?>
                                                <div class="row custom-checkbox">
                                                    <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                        <input class="checkbox_field" id="shoe_men_all" name="shoe_men_check_all" value="1" type="checkbox" {{ $checked }}>
                                                        <label for="shoe_men_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                    </div>
                                                </div>

                                                <div class="row custom-checkbox">
                                                    @if(isset($men_shoe) && count($men_shoe) > 0 )
                                                    @foreach ($men_shoe as $key => $val)
                                                        
                                                        <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                            {{ Form::checkbox('menShoeSize[]',  $key, 0 , ['class' => 'checkbox_field ms', 'id' => 'menShoeSize_'.($key)]) }}

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
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseBabyShoes">
                                                    <strong class="lh-18 required">{{t('baby_shoe_size_lable')}}</strong>
                                                </a>
                                            </div>
                                            <div id="collapseBabyShoes" class="collapse" data-parent="#accordionShoes">
                                                <?php $checked = (old('shoe_kid_check_all') == 1)? 'checked="checked"' : ''; ?>
                                                <div class="row custom-checkbox">
                                                    <div class="col-md-12 col-xl-12 col-sm-12 mb-10">
                                                        <input class="checkbox_field" id="shoe_kid_all" name="shoe_kid_check_all" value="1" type="checkbox" {{ $checked }}>
                                                        <label for="shoe_kid_all" class="checkbox-label col-sm-2" >{{ t('Select') }}: {{ t('All') }}</label>
                                                    </div>
                                                </div>

                                                <div class="row custom-checkbox">

                                                    @if(isset($baby_shoe) && count($baby_shoe) > 0 )
                                                    @foreach ($baby_shoe as $key => $val)
                                                        
                                                        <div class="col-md-2 col-xl-3 col-sm-12 mb-10">

                                                            {{ Form::checkbox('babyShoeSize[]',  $key, 0 , ['class' => 'checkbox_field bs', 'id' => 'babyShoeSize_'.($key)]) }}

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
                        </div>
                    </div>

                        @if(!Gate::allows('free_country_user', auth()->user()))

                        <!-- Only show model is selected end -->
                        <div class="input-group <?php echo (isset($errors) and $errors->has('country')) ? 'select-err-invalid' : ''; ?>" id="country-jq-err">

                            {{ Form::label(t('Your Country'), t('Your Country') , ['class' => 'control-label  input-label position-relative required']) }}
                            <select name="country" id="country" class="form-control country-auto-search" required>
                                <option value=""> {{ t('Select a country') }} </option>
                                @foreach ($countries as $item)

                                    <option value="{{ $item->get('code') }}" {{ (old('country', ($country_code) ? $country_code : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>

                                @endforeach
                            </select>
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group <?php echo (isset($errors) and $errors->has('city')) ? 'err-invalid' : ''; ?>" id="city-jq-err">
                            {{ Form::label(t('City'), t('City') , ['class' => 'control-label required input-label position-relative']) }}
                            <?php /*
                            <!-- commented city code -->
                            <!-- <select name="city" id="city" class="form-control city-auto-search" required>
                                <option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
                                    {{ t('Select a city') }}
                                </option>
                            </select> --> 
                            */ ?>
                            {{ Form::text('city', ($city)? $city : old('city'), ['class' => 'animlabel', 'id' => 'city' , 'placeholder' => t('City'), 'required' => '']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        @endif


                        <div class="input-group  <?php echo (isset($errors) and $errors->has('contact_name')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Contact Name'), t('Contact Name'), ['class' => 'position-relative control-label input-label']) }}
                            @if (Auth::check())
                                {{ Form::text('contact_name', $user->name, ['class' => 'animlabel', 'id' => 'contact_name' , 'placeholder' => t('Contact Name')]) }}
                            @else
                                {{ Form::text('contact_name', old('contact_name'), ['class' => 'animlabel', 'id' => 'contact_name' , 'placeholder' => t('Contact Name')]) }}
                            @endif
                        </div>

                        <div class="input-group  <?php echo (isset($errors) and $errors->has('email')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Contact Email'), t('Contact Email'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('email', old('email', ((Auth::check() and isset($user->email)) ? $user->email : '')), ['class' => 'animlabel', 'id' => 'email' ,'readOnly' => 'readonly', 'placeholder' => t('Contact Email')]) }}
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

                            <?php /* <!-- <div class="col-md-6 form-group mb-20"> --> */ ?>
                            <div class="input-group">
                            {{ Form::label(t('Phone Number'), t('Phone Number'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('phone_readonly', $phoneCode." ".phoneFormat(old('phone', $phoneNumber), $formPhone), ['class' => 'animlabel disable-input', 'readOnly' => 'readonly', 'id' => 'phone' , 'placeholder' => t('Phone Number')]) }}
                            <input type="hidden" name="phone_code" value="{{$phoneCode}}">
                            <input type="hidden" name="phone" value="{{$phoneNumber}}">
                            </div>
                            <?php /*
                                <div class="col-md-4 form-group mb-20">
                                    <label for="geschlecht" class="control-label input-label position-relative"></label>
                                    <input class="checkbox_field" id="phone_hidden" name="phone_hidden"  value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }} type="checkbox">
                                    <label for="phone_hidden" class="checkbox-label">{{ t('Hide the phone number on this ads') }}</label>
                                </div>
                            */ ?>
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
                        <div class="input-group  <?php echo (isset($errors) and $errors->has('application_url')) ? 'err-invalid' : ''; ?>" title="{{ t('Candidates will follow this URL address to apply for the job') }}">
                            {{ Form::label(t('Application URL'), t('Application URL'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('application_url', old('application_url'), ['class' => 'animlabel', 'id' => 'application_url' , 'placeholder' => '']) }}
                        </div> */ ?>

                        <div class="input-group  <?php echo (isset($errors) and $errors->has('end_application')) ? 'err-invalid' : ''; ?>" id="end_application-jq-err">
                            {{ Form::label(t('Application Deadline'), t('Application Deadline'), ['class' => 'position-relative control-label input-label required']) }}
                            {{ Form::text('end_application', old('end_application', date('Y-m-d')), ['class' => 'animlabel', 'required' => 'required', 'id' => 'end_application' , 'placeholder' => '', 'autocomplete' => 'end_application_arr']) }}
                            <span class="error-text-safari" style="display: none;">{{ t("required_field") }}</span>
                        </div>

                        <div class="input-group  <?php echo (isset($errors) and $errors->has('tags')) ? 'err-invalid' : ''; ?> " title="{{ t('Enter the tags separated by commas') }}">
                            {{ Form::label(t('Tags'), t('Tags'), ['class' => 'position-relative control-label input-label']) }}
                            {{ Form::text('tags', old('tags'), ['class' => 'animlabel', 'id' => 'tags' , 'placeholder' => '']) }}
                        </div>
                        <?php /*
                        <div class="input-group">
                            <span class="a-text-decoration" style="color: red;">{!! t('By continuing on this website, you accept our <a :attributes>Terms of Use</a>', ['attributes' => 'href="#termPopup" data-toggle="modal"']) !!}</span>
                        </div>
                        <?php */ ?>

                    </div> 
                </div>
                <?php /* (@include('layouts.inc.modal.term') */ ?>
                @include('childs.bottom-bar-save')
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#subCatBloc').css("display", "none");
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
        .dropdown-menu{
            margin: 3.125rem 0 0 !important;
        }

    </style>
    <!-- <style type="text/css">
        .err-invalid { color: #fa4754; }
    </style> -->
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
        
        $('#showModelFields').show();
        var ismodel = $("input[name='ismodel']:checked").val();
        $('#gender_type').change(function(){
            
            if($("input[name='ismodel']:checked").val() == 1){
                
                dressSizeShowHide();
                shoeSizeShowHide();
            }
        });

        var babyModels_category = '<?php echo json_encode($babyModels_category); ?>';

        var is_baby = false;
        var babyCategoryArr = JSON.parse(babyModels_category);
        
        if(ismodel == 1){

            checkBabyCategory();
            modelCategoryChangeEvent();
        } 
        else {
            partnerCategoryChangeEvent();
        }

        $('#Partner').click( function(){
            partnerCategoryChangeEvent();
        });

        $('#Model').click( function(){
            modelCategoryChangeEvent();
        });
        
        var CurentSelectedCategoryArr = [];
        // model category change event
        $('#modelCategory').change( function(){
            var cat = checkBabyCategory();
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
        
        function modelCategoryChangeEvent(){

            $('#showModelFields').show();
            $('#modelcate').show();
            $('#modelCategory').prop('required', true);
            $("#Partner").prop("checked", false);
            $("#Model").prop("checked", true);
            $('#partnercate').hide();
            $('#branch').prop('required', false);

            dressSizeShowHide();
            shoeSizeShowHide();

            // required html property set
            var status = true;
            validationInHtml(status);
        }

        function partnerCategoryChangeEvent(){
            var status = false;
            // required html property set
            validationInHtml(status);
            $("#Model").prop("checked", false);

            $('#baby_models_dress_size_div').hide();
            $('#men_models_dress_size_div').hide();
            $('#women_models_dress_size_div').hide();


            $("#Partner").prop("checked", true);
            $('#showModelFields').hide();
            $('#modelcate').hide();
            $('#partnercate').show();
            $('#branch').prop('required', true);
            $('#modelCategory').prop('required', false);
        }

        function dressSizeShowHide(){

            var is_men_checkd_all = false;
            var is_women_checkd_all = false;
            var is_kids_checkd_all = false;

            // baby/kids model category selected showing baby/kids model DerssSize
            if(is_baby == true){

                $('#is_baby').val('1');
                $('#baby_models_dress_size_div').show();

                // All checkbox checkd for baby/kids DressSize or not
                if($('.bds:checked').length == $('.bds').length){
                    is_kids_checkd_all = true;
                }
            }else{

                $('#is_baby').val('0');
                $('.bds').attr('checked', false);
                $('#baby_models_dress_size_div').hide();
            }

            // model category selected && gender is women showing men DerssSize
            if(modelCat == true && $("#gender_type option:selected").val() == 1){
                
                $('#is_model_category').val('1');
                $('.wds').attr('checked', false);
                $('#men_models_dress_size_div').show();
                $('#women_models_dress_size_div').hide();

                // All checkbox checkd for men models DressSize or not
                if($('.mds:checked').length == $('.mds').length){
                    is_men_checkd_all = true;
                }
            }
            // model category selected && gender is women showing men DerssSize
            else if(modelCat == true && $("#gender_type option:selected").val() == 2){

                $('#is_model_category').val('1');
                $('.mds').attr('checked', false);
                $('#men_models_dress_size_div').hide();
                $('#women_models_dress_size_div').show();

                // All checkbox checkd for women DerssSize models or not
                if($('.wds:checked').length == $('.wds').length){
                    is_women_checkd_all = true;
                }
            }else{

                // model category selected, showing men and women DerssSize otherwise not showing
                if(modelCat == true){
                    
                    $('#is_model_category').val('1');
                    $('#men_models_dress_size_div').show();
                    $('#women_models_dress_size_div').show();

                    // All checkbox checkd for women models DressSizeor not
                    if($('.wds:checked').length == $('.wds').length){
                        is_women_checkd_all = true;
                    }

                    // All checkbox checkd for men models DressSizeor not
                    if($('.mds:checked').length == $('.mds').length){
                        is_men_checkd_all = true;
                    }
                }else{

                    $('#is_model_category').val('0');
                    $('#men_models_dress_size_div').hide();
                    $('#women_models_dress_size_div').hide();
                }
            }

            // uncheck select all checkbox men, women and baby/kids DressSize
            $('#dress_women_all').attr('checked', false);
            $('#dress_kid_all').attr('checked', false);
            $('#dress_men_all').attr('checked', false);

            // DressSize baby/kids model already all check, checked select all baby/kids model DressSize 
            if(is_men_checkd_all == true){
                $('#dress_men_all').prop('checked', true);
            }

            // DressSize women already all check, checked select all women model DressSize
            if(is_women_checkd_all == true){
                $('#dress_women_all').prop('checked', true);
            }

            // DressSize men already all check, checked select all men model DressSize
            if(is_kids_checkd_all == true){
                $('#dress_kid_all').prop('checked', true);
            }
        }

        function shoeSizeShowHide(){
            
            var is_shoe_men_checkd_all = false;
            var is_shoe_women_checkd_all = false;
            var is_shoe_kids_checkd_all = false;

            // baby/kids model category selected showing baby/kids model shoesize
            if(is_baby == true){

                $('#baby_models_shoe_size_div').show();

                // All checkbox checkd for baby/kids shoesize or not 
                if($('.bs:checked').length == $('.bs').length){
                    
                    is_shoe_kids_checkd_all = true;
                }
            }else{

                $('.bs').attr('checked', false);
                $('#baby_models_shoe_size_div').hide();
            }

            // model category selected && gender is women showing men shoesize
            if(modelCat == true && $("#gender_type option:selected").val() == 1){

                $('.ws').attr('checked', false);
                $('#men_models_shoe_size_div').show();
                $('#women_models_shoe_size_div').hide();

                // All checkbox checkd for men models shoesize or not
                if($('.ms:checked').length == $('.ms').length){
                    is_shoe_men_checkd_all = true;
                }
            }
            // model category selected && gender is female showing women shoesize
            else if(modelCat == true && $("#gender_type option:selected").val() == 2){

                $('.ms').attr('checked', false);
                $('#men_models_shoe_size_div').hide();
                $('#women_models_shoe_size_div').show();

                // All checkbox checkd for women shoesize models or not
                if($('.ws:checked').length == $('.ws').length){
                    is_shoe_women_checkd_all = true;
                }
            }else{
                
                // model category selected, showing men and women shoesize otherwise not showing
                if(modelCat == true){
                    $('#men_models_shoe_size_div').show();
                    $('#women_models_shoe_size_div').show();

                    // All checkbox checkd for men shoesize models or not
                    if($('.ms:checked').length == $('.ms').length){
                        is_shoe_men_checkd_all = true;
                    }

                    // All checkbox checkd for women shoesize models or not
                    if($('.ws:checked').length == $('.ws').length){
                        is_shoe_women_checkd_all = true;
                    }
                }
                // model category not selected, hide men and women shoesize 
                else{

                    $('#men_models_shoe_size_div').hide();
                    $('#women_models_shoe_size_div').hide();
                }
            }

            // uncheck select all checkbox men, women and baby/kids shoesize
            $('#shoe_kid_all').attr('checked', false);
            $('#shoe_women_all').attr('checked', false);
            $('#shoe_men_all').attr('checked', false);

            // shoesize baby/kids model already all check, checked select all baby/kids model shoesize 
            if(is_shoe_kids_checkd_all == true){
                $('#shoe_kid_all').prop('checked', true);
            }

            // shoesize women already all check, checked select all women model shoesize
            if(is_shoe_women_checkd_all == true){
                $('#shoe_women_all').prop('checked', true);
            }

            // shoesize men already all check, checked select all men model shoesize
            if(is_shoe_men_checkd_all == true){
                $('#shoe_men_all').prop('checked', true);
            }
        }


        var siteUrl =  '<?php echo lurl('/'); ?>';

        function validationInHtml($status){ 
            // required html class applay
            // $('#showModelFields #height_from').prop('required', $status);
            // $('#showModelFields #height_to').prop('required', $status);
            // $('#showModelFields #weight_from').prop('required', $status);
            // $('#showModelFields #weight_to').prop('required', $status);
            $('#showModelFields #age_from').prop('required', $status);
            $('#showModelFields #age_to').prop('required', $status);
            return true;
        }

        // height weight validation
        jQuery.noConflict()(function($){
            
            // model height validation
            $('#showModelFields #height_to').removeAttr('required');
            var height_from = $('#showModelFields #height_from').val();
            
            if(height_from != '' && height_from != 0){

                $('#showModelFields #height_to').prop('required', true);
            }

            // height from change event, if not empty height from required height to.
            $('#showModelFields #height_from').change(function(){
                
                $('#showModelFields #height_to').removeAttr('required');
                
                if($(this).val() != '' && $(this).val() != 0){
                    $('#showModelFields #height_to').prop('required', true);
                }else{
                    $('#showModelFields #height_to').val('').trigger('change');
                }
            });

            // model weight validation
            $('#showModelFields #weight_to').removeAttr('required');
            var height_from = $('#showModelFields #weight_from').val();
            
            if(height_from != '' && height_from != 0){

                $('#showModelFields #weight_to').prop('required', true);
            }

            // weight from change event, if not empty weight from required weight to.
            $('#showModelFields #weight_from').change(function(){
                
                $('#showModelFields #weight_to').removeAttr('required');
                if($(this).val() != '' && $(this).val() != 0){
                    $('#showModelFields #weight_to').prop('required', true);
                }else{
                    $('#showModelFields #weight_to').val('').trigger('change');
                }
            });
        

            var companyId = $("#companyId option:selected").val();
            
            if(companyId == 0 ){
                $('#newcompany').show();
                $('#newCompanyInput').attr('required', 'required');
                $('#oldcompany').hide();
            }
            

            var postCompanyId = '{{ old('company_id', (isset($postCompany) ? $postCompany->id : 0)) }}';
            getCompany(postCompanyId);

            // commented city code
            // var code = $("#country option:selected").val();
            // getCityByCountryCode(code);
            
            function getCompany(t) {
                if (0 == t) $("#logoField").hide(), $("#logoFieldValue").html(""), $("#companyFields").show();
                else {
                    $("#companyFields").hide();
                    var e = $("#companyId").find("option:selected").data("logo");
                    $("#logoFieldValue").html('<img class="from-img full-width" src="' + e + '">');
                }
            }


            $('#companyId').bind('change', function() {
                postCompanyId = $(this).val();
                if(postCompanyId !== '0'){
                    getCompany(postCompanyId);
                }else{
                    $('#newcompany').show();
                    $('#oldcompany').hide();
                    $('#newCompanyInput').attr('required', 'required');
                }
            });

        });
        // commented city code
        // $('#country').bind('change', function(e){
        //    var code = $("#country option:selected").val();
        //    if(code !== ''){
        //     getCityByCountryCode(code);
        //    }else{
        //     $("#city").empty().append("<option value=''>{{ t('Select a city') }}</option>");
        //    }

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

        // if($.inArray(extension, ['gif','png','jpg','jpeg']) == -1) {
        //     $('#error-profile-logo').html('{{ t("invalid_image_type") }}').css("color", "red");
        //     return false;
        // }else{
        //     $('#error-profile-logo').html('');
        // }

        var fileSize = Math.round((event.target.files[0].size / 1024));
        if(fileSize > imageSize){
            //$('#error-profile-logo').html('{{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");

            $('#error-profile-logo').html('{{ t("File") }} "'+event.target.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");

            return false;
        }else{
            $('#error-profile-logo').html('');
        }

        
      };


         jQuery.noConflict()(function(jQuery){
            var date = new Date();
            date.setDate(date.getDate());
            var siteUrl =  window.location.origin;

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

            var end_application = '<?php echo old('end_application'); ?>';

            if(end_application != '' && end_application != null && end_application != undefined){
                
                $('#end_application').val(end_application); 
            }else{
                
                $('#end_application').val('');
            }

            jQuery('#tags').tagsinput({
              tagClass: 'extended'
            });

            jQuery('#parent').bind('change', function(e) {
                var selectedCat = jQuery('select[name=parent]').find('option:selected');
                jQuery('#category').val(jQuery(this).val());  
                jQuery('#parent_type').val(selectedCat.data('type'));
                var languageCode = '<?php echo config('app.locale'); ?>';
                // catObj = getSubCategories(siteUrl, languageCode, jQuery(this).val(), 0);
            });


            jQuery('#category').val(jQuery('select[name=parent] :selected').val()); 

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
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'catId': catId,
                        'selectedSubCatId': selectedSubCatId,
                        'languageCode': languageCode
                    }
                }).done(function(obj)
                {
                    /* init. */
                    $('#category').empty().append('<option value="0">' + lang.select.subCategory + '</option>').val('0').trigger('change');
                    
                    /* error */
                    if (typeof obj.error !== "undefined") {
                        $('#category').find('option').remove().end().append('<option value="0"> '+ obj.error.message +' </option>');
                        $('#category').closest('.form-group').addClass('err-invalid');
                        return false;
                    } else {
                        /* $('#category').closest('.form-group').removeClass('err-invalid'); */
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
    
    var is_date_announce = '<?php echo old('is_date_announce'); ?>';

    if(is_date_announce != '' && is_date_announce != null && is_date_announce != undefined){
        
        $('#is_date_announce').val('1');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#start_date').attr("disabled", "disabled");
        $('#end_date').attr("disabled", "disabled");
        $('#start_date').addClass('disable-input');
        $('#end_date').addClass('disable-input');
    }else{
        $('#is_date_announce').val('0');
        $('#start_date').removeAttr('disabled');
        $('#end_date').removeAttr('disabled');
        $('#start_date').removeClass('disable-input');
        $('#end_date').removeClass('disable-input');
    }

    $('#is_date_announce').change(function(){
        $('#start_date').removeAttr('disabled');
        $('#end_date').removeAttr('disabled');
        $('#start_date').removeClass('disable-input');
        $('#end_date').removeClass('disable-input');
        if($(this).val() == '1'){
            $(this).val('0');
        }else{
            $(this).val('1');
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
</script>

@endsection
 
