<div class="modal fade" id="applyJob" tabindex="-1" role="dialog" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">

            <?php /*
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
                <!-- <h4 class="modal-title"><i class=" icon-mail-2"></i> {{ t('Contact Employer') }} </h4> -->
            </div>
            <?php */ ?>
            <div class="container pt-20  px-0">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="pr-20">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
                <h2 class="text-center prata">{{ t('Contact Employer') }}</h2>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>
                
                <div class="bg-white ">
                    <form role="form" method="POST" action="{{ lurl('posts/' . $post->id . '/contact') }}" id="form_apply" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="py-30 px-38 form-input-applyJob">

                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                        <!-- phone_code -->
                        <input  name="phone_code" type="hidden" value="{{ (auth()->user()->phone_code)? auth()->user()->phone_code : '' }}">

                        <!-- phone -->
                        <input  name="phone" type="hidden" value="{{ (auth()->user()->phone)? auth()->user()->phone : '' }}" >

                        <!-- username -->
                        <input  name="name" type="hidden" value="{{ (auth()->user()->name)? auth()->user()->name : '' }}" >


                        <?php /*
                        
                        @if (!auth()->check())
                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                            @if (!empty(auth()->user()->email))
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            @else
                                <!-- email -->
                                <div id="email" class="input-group  <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                    @if (!isEnabledField('phone'))
                                        {{ Form::label(t('E-mail'), t('E-mail'), ['class' => 'position-relative control-label input-label required']) }}
                                    @else
                                        {{ Form::label(t('E-mail'), t('E-mail'), ['class' => 'position-relative control-label input-label required']) }}
                                    @endif
                                    <input  name="email" type="text" placeholder="" class="animlabel disable-input" value="{{ old('email', auth()->user()->email) }}" readonly>
                                </div>
                            @endif

                        @else

                            <!-- name -->
                            <div id="name" class="input-group <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                                {{ Form::label(t('Name'), t('Name'), ['class' => 'position-relative control-label input-label required']) }}
                                <input  name="name" class="animlabel disable-input" placeholder="" type="text" value="{{ (auth()->user()->name)? auth()->user()->name : old('name') }}" required="true" readonly>
                            </div>
                                    
                                <!-- email -->
                            <div id="email" class="input-group <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                @if (!isEnabledField('phone'))
                                    {{ Form::label(t('E-mail'), t('E-mail'), ['class' => 'position-relative control-label input-label required']) }}
                                @else
                                    {{ Form::label(t('E-mail'), t('E-mail'), ['class' => 'position-relative control-label input-label required']) }}
                                @endif
                                <input name="email" type="text" placeholder="" class="animlabel disable-input" value="{{ (auth()->user()->name)? auth()->user()->email : old('email') }}" required="true" readonly>
                            </div>
                            
                        @endif

                        <!-- phone -->
                        <div class="row">
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone_code') ? 'has-error' : ''}}">
                                {{ Form::label(t('Select a phone code'), t('Select a phone code'), ['class' => 'control-label required  input-label position-relative']) }}
                                <?php

                                    // get old phone code value   
                                        $phone_code_option = (auth()->check()) ? auth()->user()->phone_code : '';
                                        $phoneIcon = "";
                                    ?>
                                <input type="hidden" name="phone_code" value="{{ $phone_code_option }}">
                                <select id="phone_code" name="select_phone_code" class="phone-code-search" required disabled="">
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
                            <div id="phone" class="col-md-6 col-sm-12 input-group <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                @if (!isEnabledField('email'))
                                    {{ Form::label(t('Phone Number'), t('Phone Number'), ['class' => 'position-relative control-label input-label required']) }}
                                @else
                                    {{ Form::label(t('Phone Number'), t('Phone Number'), ['class' => 'position-relative control-label input-label required']) }}
                                @endif
                                <input  name="phone" type="text" placeholder="{{ t('Phone Number') }}" class="animlabel disable-input" value="{{ old('phone', (auth()->check()) ? auth()->user()->phone : '') }}" required="true" maxlength = '10' minlength = '10' onkeypress = "return isNumber(event)" readonly>
                            </div>
                        </div>

                        <?php */ ?>
                        <!-- message -->
                        <div id="message" class="input-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
                            {{ Form::label(t('Message (upto 500 letters)'), t('Message (upto 500 letters)'), ['class' => 'position-relative control-label input-label required']) }}
                            <textarea  name="message" class="animlabel textarea-description" placeholder="" rows="5" minlength = '20' maxlength="500" required="true">{{ old('message') }}</textarea>
                        </div>

                       <?php /*
                        <span id="append-image">
                            <div class='input-group pb-0 mb-0'>
                                <div class='upload-btn-wrapper'>
                                    <a href='#' class='btn btn-white upload_white upload-picture '>{{ t('select photo 1') }}</a>
                                    <input type='file' id='partnerprofileLogo0' name='special[filename0]' onchange="loadCVFile(event)"/>
                                    <span id='image_name_0' class=""></span>
                                    <label id='error-profile-logo-0' class=''></label>
                                </div>
                            </div>
                            <div class='input-group pb-0 mb-0 pt-20'>
                                <div class='upload-btn-wrapper'>
                                    <a href='#' class='btn btn-white upload_white upload-picture '>{{ t('select photo 2') }}</a>
                                    <input type='file' id='partnerprofileLogo1' name='special[filename1]' onchange="loadCVFile1(event)"/>
                                    <span id='image_name_1' class=""></span>
                                    <label id='error-profile-logo-1' class=''></label>
                                </div>
                            </div>
                        </span>
                        <span id="image-warning" class="alert alert-danger" style="display: none;"></span>
                        */ ?>
                        
                        <!-- <div class="input-group">
                            <a  class="d-inline-block btn btn-success" id="add_line">+ {{ t('Add new picture') }}</a>
                        </div> -->

                        <!-- recaptcha -->
                        <?php /* 
                        @if (config('settings.security.recaptcha_activation'))
                            <div class="input-group <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
                                <label class="position-relative control-label input-label" for="g-recaptcha-response">{{ t('We do not like robots') }}</label>
                                <div>
                                    {!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
                                </div>
                            </div>
                        @endif
                        */?>

                        <input type="hidden" name="country" value="{{ config('country.code') }}">
                        <input type="hidden" name="post" value="{{ $post->id }}">
                        <input type="hidden" name="messageForm" value="1">

                    </div>
                    <div class="text-center mb-20">
                        <a href="#" class="btn btn-white mini-mobile arrow_left position-relative" data-dismiss="modal">{{ t('Cancel') }}</a>
                        <button type="submit" class="btn btn-success register">{{ t('Send message') }}</button>
                    </div>
                    <div class="bg-white ">
                        <div class="px-38">
                            <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            <div class="alert alert-success print-success-msg" style="display:none"></div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('after_styles')
    @parent
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
    @endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
    </style>
@endsection

@section('after_scripts')
    @parent
    
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
    @endif
    <script>        
        $(document).ready(function () {
            @if (isset($errors) and $errors->any())
                @if ($errors->any() and old('messageForm')=='1')
                    $('#applyJob').modal();
                @endif
            @endif
        });
    </script>
@endsection