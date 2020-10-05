<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" style="z-index: 99999 !important;">
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
                    <div class="px-38">
                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                        <div class="alert alert-success print-success-msg" style="display:none"></div>
                    </div>
                </div>

                <div class="bg-white ">
                    <form role="form" method="POST" action="{{ lurl('user-sendmail') }}" id="send-message" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="py-30 px-38 form-input-applyJob">

                        <!-- name -->
                        <input  name="name" type="hidden" value="{{ (auth()->user()->profile->first_name)? auth()->user()->profile->first_name : old('name') }}">

                        <!-- phone_code -->
                        <input  name="phone_code" type="hidden" value="{{ (auth()->user()->phone_code)? auth()->user()->phone_code : '' }}">

                        <!-- phone -->
                        <input  name="phone" type="hidden" value="{{ (auth()->user()->phone)? auth()->user()->phone : '' }}" >

                        <!-- email -->
                        <input name="email" type="hidden" placeholder="" value="{{ (auth()->user()->name)? auth()->user()->email : '' }}">

                        <input type="hidden" name="country" value="{{ config('country.code') }}">
                        <input type="hidden" name="id" value="<?php echo isset($user->id)? $user->id : '' ?>">

                        <?php /*
                      
                        <div id="name" class="input-group <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                            {{ Form::label(t('Name'), t('Name'), ['class' => 'position-relative control-label input-label required']) }}
                            <input  name="name" class="animlabel" placeholder="" type="hidden" value="{{ (auth()->user()->profile->first_name)? auth()->user()->profile->first_name : old('name') }}" required="true">
                        </div>

                        
                        <div class="row">
                            <div class="input-group col-md-6 col-sm-12 {{ $errors->has('phone_code') ? 'has-error' : ''}}">
                                {{ Form::label(t('Select a phone code'), t('Select a phone code'), ['class' => 'control-label required  input-label position-relative']) }}
                                <?php $phone_code_option = auth()->user()->phone_code; 
                                        $phoneIcon = "";
                                ?>

                                <select id="phone_code" name="phone_code" class="phone-code-search" required>
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
                            <div id="phone" class="input-group col-md-6 col-sm-12 <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                {{ Form::label(t('Phone Number'), t('Phone Number'), ['class' => 'position-relative control-label input-label required']) }}
                                <input  name="phone" class="animlabel" placeholder="" type="hidden" value="{{ (auth()->user()->phone)? auth()->user()->phone : old('phone') }}" required="true" maxlength = '10' minlength = '10' onkeypress = "return isNumber(event)">
                            </div>
                        </div>    
                            <!-- email -->
                        <div id="email" class="input-group <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>" >
                                {{ Form::label(t('E-mail'), t('E-mail'), ['class' => 'position-relative control-label input-label required']) }}
                            <input name="email" type="hidden" placeholder="" class="animlabel" value="{{ (auth()->user()->name)? auth()->user()->email : old('email') }}" required="true">
                        </div>
                        
                        <!-- message -->
                        <div id="message" class="input-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
                            {{ Form::label(t('Message'), t('Message'), ['class' => 'position-relative control-label input-label required']) }}
                            <textarea  name="message" class="animlabel textarea-description" placeholder="" rows="5" required="true" minlength = '100'>{{ old('message') }}</textarea>
                        </div>

                        <?php */ ?>

                        <!-- <input type="hidden" name="country" value="{{ config('country.code') }}">
                        <input type="hidden" name="id" value="<?php //echo isset($user->id)? $user->id : '' ?>"> -->

                        <!-- message -->
                        <div id="message" class="input-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
                            {{ Form::label(t('Message'), t('Message'), ['class' => 'position-relative control-label input-label required']) }}
                            <textarea  name="message" class="animlabel textarea-description" placeholder="" rows="5" required="true" minlength = '100'>{{ old('message') }}</textarea>
                        </div>

                    </div>
                    <div class="text-center mb-20">
                        <a href="#" class="btn btn-white mini-mobile arrow_left position-relative" data-dismiss="modal">{{ t('Cancel') }}</a>
                        <button type="submit" class="btn btn-success register send-message">{{ t('Send message') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>