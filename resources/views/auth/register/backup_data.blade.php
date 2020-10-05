@extends('layouts.logged_in.out_of_app')
<script src="{{ url('assets/js/jquery/jquery-latest.js') }}"></script>

@section('content')
    

    <div class="d-flex align-items-center container out_of_app px-0 mw-970">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20">
                <img srcset="{{ URL::to('images/img-logo.png') }},
                                 {{ URL::to('images/img-logo@2x.png') }} 2x,
                                 {{ URL::to('images/img-logo@3x.png') }} 3x"
                     src="/images/img-logo.png" alt="Go Models" class="logo"/>
            </div>
            <div class="d-flex justify-content-center">
                <div class="flex-grow-1 mw-720 py-20 px-30">
                    
                    <div class="text-center mb-30 position-relative">
                        <div class="custom-tabs mb-20 mb-xl-30" >
                            @include('auth.register.inc.wizard_new')
                        </div>
                        @include('childs.notification-message')
                    </div>

                    <div class="position-relative">
                    <!-- <div class="divider mx-auto"></div> -->
                        <p class="text-center mb-30 w-lg-596 mx-lg-auto title">{{ t('Create your account, Its free') }}</p>
                        <!-- <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0"><a href="{{ route('model-public-profile') }}" class="btn btn-default insight mini-mobile">Ansicht</a></div> -->
                    </div>
                    
                    <form name="asd" class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}">
                    {!! csrf_field() !!}
                    <input name="user_id" type="hidden" value="{{ old('id', $user->id) }}">

                    @if ($user->user_type_id == 3)
                    <!-- birthday -->
                    <div class="input-group">
                        {{ Form::label('birthday', t('Birthday'), ['class' => 'position-relative control-label select-label']) }}
                        <div class="col-md-12" id="cs_birthday" style="padding-top: 10px;"></div>
                    </div>

                    <div class="parent-fields" style="display: none;">
                        <!-- Parent fname -->
                        <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('fname_parent')) ? 'invalid-input' : ''; ?>">
                            {{ Form::label(t('fname_parent'), t('fname_parent'), ['class' => 'position-relative control-label select-label']) }}

                            {{ Form::text('fname_parent', old('fname_parent', $user->profile->fname_parent), ['class' => 'animlabel', 'id' => 'fname_parent', 'placeholder' => '' ]) }}
                           
                        </div>

                        <!-- Parent lname -->
                        <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('lname_parent')) ? 'invalid-input' : ''; ?>">
                            {{ Form::label(t('lname_parent'), t('lname_parent'), ['class' => 'position-relative control-label select-label']) }}

                            {{ Form::text('lname_parent', old('lname_parent', $user->profile->lname_parent), ['class' => 'animlabel', 'id' => 'lname_parent', 'placeholder' => '' ]) }}
                        </div>

                    </div>
                    
                    <!-- Category -->
                    <div class="input-group <?php echo (isset($errors) and $errors->has('category')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Select a category'), t('Select a category'), ['class' => 'control-label  select-label position-relative']) }}

                        <select name="category" id="category" class="form-control form-select2" >
                            <option value="">{{ t('Select a category') }}</option>
                            @foreach ($modelCategories as $cat)
                                <option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"  {{ ($user->profile->category_id == $cat->tid) ? 'selected' : '' }}> {{ $cat->name }} </option>
                            @endforeach
                        </select>
                    </div>



                    <!-- <div class="input-group custom-checkbox mb-40">
                        <select  name="minAge" id="minAge" class="form-control">
                            <option value=""> {{ t('age_min') }} </option>
                            @for($i = 1; $i < 101; $i++)
                                <option value="{{ $i }}" {{ (Request::get('minAge')==$i) ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div> -->

                    <!-- email -->
                    <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('email')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Email'), t('Email'), ['class' => 'position-relative control-label select-label']) }}
                        {{ Form::email('email', old('email', $user->email), ['class' => 'animlabel', 'id' => 'email', 'placeholder' => '' ]) }}
                    </div>
                    @endif


                    @if ($user->user_type_id == 2)
                    <!-- Branch -->
                    <div class="input-group <?php echo (isset($errors) and $errors->has('category')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Select a branch'), t('Select a branch'), ['class' => 'control-label  select-label position-relative']) }}

                        <select name="category" id="category" class="form-control form-select2" required>
                            <option value="">{{ t('Select a branch') }}</option>
                            @foreach ($branches as $key=>$cat)
                                <option value="{{ $cat->tid }}" data-type="{{ $cat->type }}" {{ ($user->profile->category_id == $key) ? 'selected' : '' }}> {{ $cat->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    @endif


                    <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('street')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative control-label select-label']) }}

                        {{ Form::text('phone', old('phone', $user->profile->street), ['class' => 'animlabel', 'id' => 'phone', 'placeholder' => '' ]) }}
                        
                    </div>

                    <div class="input-group <?php echo (isset($errors) and $errors->has('country')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Select a country'), t('Select a country'), ['class' => 'control-label  select-label position-relative']) }}

                        <select id="country" name="country" class="form-control form-select2" required>
                            <option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                            @foreach ($countries as $item)
                                <option value="{{ $item->get('code') }}" {{ (old('country', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$user->country->code) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group <?php echo (isset($errors) and $errors->has('city')) ? 'err-invalid' : ''; ?>">
                        {{ Form::label(t('Select a city'), t('Select a city'), ['class' => 'control-label  select-label position-relative']) }}

                        <select name="city" id="city" class="form-control form-select2">
                            <option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}>
                                {{ t('Select a city') }}
                            </option>
                        </select>
                    </div>

                    <!-- street -->
                    <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('street')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Street'), t('Street'), ['class' => 'position-relative control-label select-label']) }}

                        {{ Form::text('street', old('street', $user->profile->street), ['class' => 'animlabel', 'id' => 'street', 'placeholder' => '' ]) }}
                        
                    </div>

                    <!-- zip -->
                    <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('zip')) ? 'invalid-input' : ''; ?>">
                        {{ Form::label(t('Zip'), t('Zip'), ['class' => 'position-relative control-label select-label']) }}

                        {{ Form::text('zip', old('zip', $user->profile->zip), ['class' => 'animlabel', 'id' => 'zip', 'placeholder' => '' ]) }}
                    </div>

                    @if ($user->user_type_id == 3)
                        <!-- Body Height -->
                       
                        <div class="input-group <?php echo (isset($errors) and $errors->has('height')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select height'), t('Select height'), ['class' => 'control-label  select-label position-relative']) }}
                            <select name="height" id="height" class="form-control form-select2">
                                <option value="">{{ t('Select height') }}</option>
                                    <?php foreach($properties['height'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->height_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <!-- Body Weight -->
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('weight')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select height'), t('Select height'), ['class' => 'control-label  select-label position-relative']) }}
                            <select name="weight" id="weight" class="form-control form-select2">
                                <option value="">{{ t('Select height') }}</option>
                                    <option value="">{{ t('Select weight') }}</option>
                                    <?php foreach($properties['weight'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->weight_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <!-- Dress size -->
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('dressSize')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select dress size'), t('Select dress size'), ['class' => 'control-label  select-label position-relative']) }}
                            <select name="dressSize" id="dressSize" class="form-control form-select2">
                                <option value="">{{ t('Select dress size') }}</option>
                                    <?php foreach($properties['dress_size'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->size_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <!-- Eye color -->
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('eyeColor')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select eye color'), t('Select eye color'), ['class' => 'control-label  select-label position-relative']) }}

                            <select  name="eyeColor" id="eyeColor" class="form-control form-select2">
                                <option value="">{{ t('Select eye color') }}</option>
                                    <?php foreach($properties['eye_color'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->eye_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>


                        <!-- Hair color -->
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('hairColor')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select hair color'), t('Select hair color'), ['class' => 'control-label  select-label position-relative']) }}

                            <select  name="hairColor" id="hairColor" class="form-control form-select2">
                                <option value="">{{ t('Select hair color') }}</option>
                                    <?php foreach($properties['hair_color'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->hair_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <!-- Shoe size -->
                        
                        <div class="input-group <?php echo (isset($errors) and $errors->has('shoeSize')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Select shoe size'), t('Select shoe size'), ['class' => 'control-label  select-label position-relative']) }}
                            <select  name="shoeSize" id="shoeSize" class="form-control form-select2">
                                <option value="">{{ t('Select shoe size') }}</option>
                                    <?php foreach($properties['shoe_size'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->shoes_size_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <!-- Skin color -->

                        <div class="input-group <?php echo (isset($errors) and $errors->has('skinColor')) ? 'err-invalid' : ''; ?>">
                            {{ Form::label(t('Skin color'), t('Skin color'), ['class' => 'control-label  select-label position-relative']) }}
                            <select  name="skinColor" id="skinColor" class="form-control form-select2">
                                <option value="">{{ t('Select skin color') }}</option>
                                    <?php foreach($properties['skin_color'] as $key=>$cat){ ?>
                                        <option value="<?= $key ?>"  {{ ($user->profile->skin_color_id == $key) ? 'selected' : '' }} ><?= $cat ?></option>
                                    <?php } ?>
                            </select>
                        </div>


                    @endif
                    <!-- gender -->
                    <div class="col-md-6 px-0 ">
                        {{ Form::label(t('Gender'), t('Gender') , ['class' => 'control-label required select-label position-relative']) }}
                        <div class="input-group custom-radio mb-20 <?php echo (isset($errors) and $errors->has('gender')) ? 'invalid-input' : ''; ?>" style="padding-top : 10px;">

                            @if ($genders->count() > 0)
                                @foreach ($genders as $gender)
                                    {{ Form::radio('gender', $gender->tid, (old('gender', $user->gender_id)==$gender->tid) ? 'true' : 'false', ['class' => 'radio_field', 'id' => t($gender->name)]) }}
                                    {{ Form::label(t($gender->name), t($gender->name), ['class' => 'd-inline-block radio-label col-sm-6']) }}
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="text-center"><button type="submit" class="d-inline-block btn btn-success register mb-40">{{ t('Submit') }}</button></div>
                    <!-- <div class="text-center"><span>Already have an account? <a href="{{ route('login') }}" class="d-inline-block bold bb-black lh-15">Login</a></span></div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<style type="text/css">
    <style type="text/css">
    .invalid-input { color: #fa4754; border-bottom: 1px solid #fa4754;}
    .form-select { display: block; width: 100%; height: 36px; outline: none;  resize: none; -webkit-appearance: none; border-radius: 0; border: 0; border-bottom: 1px solid #d0d0d0; font-family: work_sansregular,arial,tahoma; font-size: 16px;padding: 0;margin: 0; }
    .birthdayPicker { display: inline-block !important; width: 100%; }
    .select2-container { width: 100% !important; }
    .cs_birthday-drop { width: 28% !important; }
    </style>
</style>

@if(Lang::locale()=='de')
<script src="{{ url('assets/plugins/jquery-birthday-picker/jquery-birthday-picker-de.min.js') }}" type="text/javascript"></script>
@else
<script src="{{ url('assets/plugins/jquery-birthday-picker/jquery-birthday-picker.min.js') }}" type="text/javascript"></script>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<script>
    var userType = "<?php echo old('user_type', \Illuminate\Support\Facades\Request::input('type')); ?>";
    

    $(document).ready( function(){
        
        var userType = "<?php echo $user->user_type_id ?>";
        
        if (userType == 2) {
            $('.for-employer').show();
            $('.for-model').hide();
        }
        
        if (userType == 3) {
            $('.for-employer').hide();      
            $('.for-model').show();     
        }

        var code = $("#country option:selected").val();
        getCityByCountryCode(code);

        $('#country').bind('change', function(e){
           var code = $("#country option:selected").val();
           getCityByCountryCode(code);
        });

        function getCityByCountryCode(code){
            var siteUrl =  window.location.origin;
            if (typeof code !== 'undefined' && code != "" && code != null ) {
                var url = "/ajax/citiesByCode/"+code+'/true';
                 $.ajax({
                    method: "GET",
                    url: siteUrl + url
                }).done(function(e) {
                    $("#city").empty().append(e);
                });

           }
        }
    
    });



</script>
<script>
    $(document).ready( function(){
        $("#cs_birthday").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday cs_birthday-drop",
            callback: selected_date
        });

        function selected_date($date) {
            var selected_date = $date;
            var DOB = new Date(selected_date);
            var today = new Date();
            var age = today.getTime() - DOB.getTime();

            age = Math.floor(age / (1000 * 60 * 60 * 24 * 365.25));


            if (age < 18) {
                jQuery(".parent-fields").css("display", "block");
            } else {
                jQuery(".parent-fields").css("display", "none");
            }
        }

        function set_date($date){
            if ( $date != '' ) {
                var DOB = new Date($date);
                $('select.birthYear').val(DOB.getFullYear());
                $('select.birthMonth').val(DOB.getMonth() + 1);
                $('select.birthDate').val(DOB.getDate());

                $('[name="cs_birthday_birthDay"]').val($date);
                selected_date($date);
            }
        }

        set_date('<?php echo $user->profile->birth_day ?>');

         $('.form-select2').select2({
            closeOnSelect: true,
            minimumResultsForSearch: Infinity
         });

    })
        
    </script>
