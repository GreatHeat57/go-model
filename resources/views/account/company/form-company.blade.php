@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60 w-xl-1220">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">
                    @if (isset($company) and !empty($company))
                        {{ t('Edit the Company') }}
                    @else 
                        {{ t('Create a new company') }}
                    @endif
                </h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0">
                <a  href="{{ lurl(trans('routes.account-companies')) }}" class="btn btn-default arrow_left mini-mobile">{{ t('My companies') }}</a>
            </div>
             @include('childs.notification-message')
        </div>


        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            @if (isset($company) and !empty($company))
                {{ Form::open(array('url' =>  lurl(trans('routes.account-companies').'/' . $company->id) , 'method' => 'put', 'files' => true, 'id' => 'company-form')) }}
            @else 
                {{ Form::open(array('url' =>  lurl(trans('routes.account-companies-create')) , 'method' => 'post', 'files' => true, 'id' => 'company-form')) }}            
            @endif
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pt-40 px-38 px-lg-0">

                    <div class="pb-40 mb-40 bb-light-lavender3 ">
                        <h2 class="bold f-18 lh-18">{{ t('Logo') }}</h2>
                        <div class="divider"></div>

                        <div class="w-lg-750 w-xl-970 mx-auto upload-zone">
                            <div class="pt-40 px-38 px-lg-0">
                                <div class="pb-40 mb-40 d-md-flex">

                                    <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                                        
                                        @if (isset($company) and !empty($company))
                                            <?php $logo = ($company->logo)? $company->logo : ''; ?>

                                            @if($logo !== "")
                                                <img id="output-partner-logo" src="{{ \Storage::url($company->logo) }}" alt="{{ trans('metaTags.User') }}" data-action="zoom">&nbsp;
                                            @else
                                                <img id="output-partner-logo" src="{{ url('uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.User') }}" data-action="zoom">
                                            @endif
                                        @else
                                            <img id="output-partner-logo" src="{{ url(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.User') }}" data-action="zoom">
                                        @endif 
                                    </div>
                                    <div class="d-md-inline-block">
                                        <!-- <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)" class="upload_white mb-20"> -->
                                        <div class="upload-btn-wrapper">
                                          <a href="#" class="btn btn-white upload_white upload-picture mb-20">{{ t('select photo')}}</a>
                                          <input id="logo" name="company[logo]" type="file" onchange="loadLogoFile(event)"  accept="image/x-png,image/gif,image/jpeg,image/jpg"/>
                                        </div>
                                        <p class="w-lg-460 pt-20">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
                                        <p id="error-profile-logo" class=""></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Company details') }}</h2>
                        <div class="divider"></div>
                        
                        <div class="input-group">
                            {{ Form::label(t('Company Name'), t('Company Name'), ['class' => 'position-relative required input-label']) }}
                            {{ Form::text('company[name]', (isset($company->name) ? $company->name : ''), ['class' => 'animlabel', 'placeholder' => t('Company Name'), 'required' => true]) }}
                        </div>

                        <div class="input-group">
                            {{ Form::label('description', t('Description'), ['class' => 'position-relative input-label required']) }}
                            {{ Form::textarea('company[description]', isset($company->description) ? stripslashes($company->description) : '' , ['class' => 'animlabel textarea-description', 'id' => 'pageContent', 'maxlength' => '1000', 'minlength' => '100']) }}
                        </div>

                    </div>

                   
                    
                    <div class="pb-40 mb-40  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Contact Information') }}</h2>
                        <div class="divider"></div>

                       <div class="pb-40">
                            {{ Form::label(t('Country'), t('Country'), ['class' => 'position-relative  input-label']) }}
                            <select name="company[country_code]" id="country" class="form-control">
                                <option value="">{{ t('Select a country') }}</option>
                                @foreach ($countries as $item)
                                    <option value="{{ $item->get('code') }}" {{ (old('company.country_code', (isset($company->country_code) ? $company->country_code : ((!empty(config('country.code'))) ? config('country.code') : 0)))==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pb-40">
                            {{ Form::label(t('City'), t('City'), ['class' => 'position-relative  input-label']) }}
                            <input type="text" name="company[city]" id="city" placeholder="{{ t('City') }}" class="animlabel" value="{{ (isset($company->city))? $company->city : old('company.city') }}">
                        </div>


                        <div class="pb-40">
                            {{ Form::label(t('Address'), t('Address'), ['class' => 'position-relative input-label']) }}
                            <span>{{ Form::text('company[address]', (isset($company->address) ? $company->address : ''), ['class' => 'animlabel', 'placeholder' => t('Address')]) }}</span>
                        </div>

                        <div class="pb-40">
                            {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative input-label']) }}
                            <span>{{ Form::text('company[phone]', (isset($company->phone) ? $company->phone : ''), ['class' => 'animlabel', 'placeholder' => t('Phone'), 'maxlength' => 20, 'minlength' => 5]) }}</span>
                        </div>

                         <div class="pb-40">
                            {{ Form::label(t('Fax'), t('Fax'), ['class' => 'position-relative input-label']) }}
                            <span>{{ Form::text('company[fax]', (isset($company->fax) ? $company->fax : ''), ['class' => 'animlabel', 'placeholder' => t('Fax')]) }}</span>
                        </div>


                        <div class="pb-40">
                            {{ Form::label( t('Email'),  t('Email'), ['class' => 'position-relative input-label']) }}
                            <span>{{ Form::email('company[email]', (isset($company->email) ? $company->email : ''), ['class' => 'animlabel', 'placeholder' => t('Email')]) }}</span>
                        </div>


                        <div class="pb-40">
                            {{ Form::label( t('Website'),  t('Website'), ['class' => 'position-relative input-label']) }}
                            <span>{{ Form::text('company[website]', (isset($company->website) ? $company->website : ''), ['class' => 'animlabel', 'placeholder' => t('Website')]) }}</span>
                        </div>
                        
                    </div>

                    <div class="pb-40 mb-40  bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Website & Social Networks') }}</h2>
                        <div class="divider"></div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start align-items-center mb-30 ">
                                    <!-- <div class="social-big facebook rounded-circle mr-20"></div> -->
                                    {{ Form::text('company[facebook]', (isset($company->facebook) ? $company->facebook : ''), ['class' => 'animlabel', 'placeholder' => 'Facebook']) }}
                                </div>
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    <!-- <div class="social-big twitter rounded-circle mr-20"></div> -->
                                    {{ Form::text('company[twitter]', (isset($company->twitter) ? $company->twitter : ''), ['class' => 'animlabel', 'placeholder' => 'Twitter']) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                
                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    <!-- <div class="social-big linkedin rounded-circle mr-20"></div> -->
                                    {{ Form::text('company[linkedin]', (isset($company->linkedin) ? $company->linkedin : ''), ['class' => 'animlabel', 'placeholder' => 'Linkedin']) }}
                                </div>

                                <div class="d-flex justify-content-start align-items-center mb-30">
                                    <!-- <div class="social-big pinterest rounded-circle mr-20"></div> -->
                                    {{ Form::text('company[pinterest]', (isset($company->pinterest) ? $company->pinterest : ''), ['class' => 'animlabel', 'placeholder' => 'Pinterest']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    
                </div>
                @include('childs.bottom-bar-save')
            </div>
            {{ Form::close() }}
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
    </style>
@endsection

@section('after_scripts')
<script src="{{ url(config('app.cloud_url').'/js/zoom.js') }}"></script>
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
                    defaultImage: "{{ url(config('app.cloud_url').'/assets/plugins/simditor/images/image.png') }}",
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
        $.noConflict()(function($){
            
            $('#country').on('change', function(){

                var country = $(this).val();

                if(country != null && country != "" && country != undefined){
                        var getUrl = window.location.origin;
                        var url = getUrl+"/ajax/countries/"+country+"/cities";
                        var select = $('#city');
                        
                        $.ajax({
                        url: url,
                        type: 'get',
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success: function(data){

                            if(data.success == 'true'){
                                var option = "";
                                data.data.forEach(function(item) {
                                    option += "<option value="+item.id+">"+item.name+"</option>";
                                });

                                if(option != ''){
                                    select.empty().append(option);
                                }
                            }

                        },
                        error: function(err){
                            console.log(err);
                        }
                    });
                   
                }
            })
        });

    </script>
   <script>
      // var loadCoverFile = function(event) {
      //   var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
      //   var fileSize = Math.round((event.target.files[0].size / 1024));
      //   var filename = event.target.files[0].name;

      //   if(fileSize > imageSize){
      //       $('#error-profile-logo').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
      //       return false;
      //   }else{
      //       $('#error-profile-cover').html('');
      //   }

      //   var reader = new FileReader();
      //   reader.onload = function(){
      //     var output = document.getElementById('output-partner-cover');
      //     output.src = reader.result;
      //   };
      //   reader.readAsDataURL(event.target.files[0]);
      // };

        var loadLogoFile = function(event) {

            var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            var fileSize = Math.round((event.target.files[0].size / 1024));
            var filename = event.target.files[0].name;
            var reader = new FileReader();
            
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);

            // if(fileSize > imageSize){
            //     $('#error-profile-logo').html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
            //     return false;
            // }else{
            //     $('#error-profile-logo').html('');
            // }
        };

      $('#company-form').submit(function(event){

            var ele = document.getElementById('logo');
            var maxUploadImageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            var currentUploadImageCount = parseInt(ele.files.length);

            if(currentUploadImageCount > 0){
                
                var imageType = ele.files[0].type.toLowerCase();
                var imageSize = ele.files[0].size;
                var fileSize = Math.round((imageSize / 1024));
                
                var extension = imageType.split('/');
                //check image extension  
                if($.inArray(extension[1], ['gif','png','jpg','jpeg']) == -1) {
                    $('#error-profile-logo').html('{{ t("invalid_image_type") }} ').css("color", "red");
                    return false;   
                } 

                if(fileSize > maxUploadImageSize){

                     $('#error-profile-logo').html('{{ t("File") }} "'+ele.files[0].name+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+maxUploadImageSize+' KB.').css("color", "red");

                    return false;
                }
            }
             
            $('#error-profile-logo').html('');
            return true;
        });
    </script>
@endsection
 