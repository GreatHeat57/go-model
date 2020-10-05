<div class="modal fade" id="directMessage" tabindex="-1" role="dialog" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
             
            <div class="container pt-20  px-0">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="pr-20">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>
            <div class="container px-0">

                <h2 class="text-center prata">{{ ucfirst(t('Message')) }}</h2>
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
                    <form role="form" method="POST" action="{{ lurl('direct-message') }}" id="direct-message" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="py-30 px-38 form-input-applyJob">
                        
                        <input type="hidden" name="to_user_id" value="<?php echo isset($user->id)? $user->id : '' ?>">

                        <!-- name -->
                        <input  name="to_user_name" type="hidden" value="{{ ($user->profile->first_name)? $user->profile->first_name : $user->profile->first_name }}">

                        <!-- phone_code -->
                        <input  name="to_user_phone_code" type="hidden" value="{{ ($user->phone_code)? $user->phone_code : '' }}">

                        <!-- phone -->
                        <input  name="to_user_phone" type="hidden" value="{{ ($user->phone)? $user->phone : '' }}" >

                        <!-- email -->
                        <input name="to_user_email" type="hidden" placeholder="" value="{{ ($user->email)? $user->email : '' }}">


                        <!-- message -->
                        <div id="message" class="input-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
                            {{ Form::label(t('Message'), t('Message'), ['class' => 'position-relative control-label input-label required']) }}
                            <textarea  name="message" class="animlabel textarea-description" placeholder="" rows="5" required="true">{{ old('message') }}</textarea>
                        </div>

                    </div>
                    <div class="text-center mb-20">
                        <a href="#" class="btn btn-white mini-mobile arrow_left position-relative" data-dismiss="modal">{{ t('Cancel') }}</a>
                        <button type="submit" class="btn btn-success register direct-message">{{ t('Send message') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>