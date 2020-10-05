@extends( Auth::User()->user_type_id == config('constant.partner_type_id')  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content') 
    @include('partner.public-profile-top')
    <div class="container pt-40 px-0">
        <div class="custom-tabs mb-20">
            <?php
            $tabs = array();

            if($user->id == Auth::User()->id){
                $tabs[lurl('user')] = t('Details');
                $tabs[lurl('partner-public-portfolio')] = t('Portfolio');

            }else{
                $tabs[lurl(trans('routes.user').'/'.$user->username)] = t('Details');
                $tabs[lurl('partner-public-portfolio/'.$user->id)] = t('Portfolio');

                if(Auth::check() && Auth::User()->user_type_id == config('constant.model_type_id') && Auth::User()->user_register_type != config('constant.user_type_free')){
                    $attr = ['countryCode' => config('country.icode'), 'user_id' => $user->id];
                    $tabs[lurl(trans('routes.job-match-profile', $attr), $attr)] = t('Latest jobs Portal');
                }               
            }
               
            ?>
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-flex justify-content-center">
                @if(isset($user))
                    @if($user->id == Auth::User()->id)
                        <li><a href="{{ lurl('partner-public-portfolio') }}" >{{ t('Portfolio') }}</a></li>
                        <li><a href="{{ lurl('user') }}" class="active">{{ t('Details') }}</a></li>
                    @else
                        <li><a href="{{ lurl('partner-public-portfolio/'.$user->id) }}" >{{ t('Portfolio') }}</a></li>
                        <li><a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class="active">{{ t('Details') }}</a></li>

                        
                        @if( Auth::User()->user_type_id == config('constant.model_type_id') && Auth::User()->user_register_type != config('constant.user_type_free'))

                            <?php $attr = ['countryCode' => config('country.icode'), 'user_id' => $user->id]; ?>
                            <li>
                                <a href="{{ lurl(trans('routes.job-match-profile', $attr), $attr) }}" class="position-relative">{{ t('Latest jobs Portal') }}
                                    <span class="msg-num tab rejected ">{{ isset($matchCount)? $matchCount : '0' }}</span>
                                </a>
                            </li>
                        @endif

                    @endif
                @endif
            </ul>
        </div>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white py-60 px-38 px-lg-0 mb-40 w-xl-1220 mx-xl-auto section-word-break">
            <div class="w-lg-750 w-xl-970 mx-auto">
                
                <div class="pb-10 mb-20 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Profile Details') }}</h2>
                    <div class="divider"></div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('Company Name') }}</label>
                        <span>{{  ($profile->company_name)? $profile->company_name : '' }}</span>
                    </div>
                     
                    <div class="pb-10 mb-20 {{ ($user->id == Auth::User()->id)? 'bb-pale-grey' : '' }}">
                        <label class="position-relative input-label">{{ t('Branch') }}</label>
                        @foreach ($branches as $key => $cat)
                            <span>{{ $cat->name }}</span>
                        @endforeach
                    </div>

                    @if($user->id == Auth::User()->id)
                        <div class="pb-10 mb-20">
                            <label class="position-relative input-label">{{ t('Allow in search?') }}</label>
                            <span><?php echo ($profile->allow_search == 1)? t('Yes') : t('No'); ?></span>
                        </div>
                    @endif

                </div>

                <div class="pb-10 mb-20  bb-light-lavender3">
                    <span class="title">{{t('About Me')}}</span>
                    <div class="divider"></div>
                    <p class=""><?php echo ($profile->description)? stripslashes($profile->description) : ''; ?></p>
                </div>

                <div class="pb-10 mb-20  bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('TFP Information') }}</h2>
                    <div class="divider"></div>
                    <div class="col-md-6 px-0">
                        <label class="position-relative input-label">{{ t('TFP') }}</label> 
                        <span><?php echo ($profile->tfp == 1)? t('Yes') : t('No'); ?></span>
                    </div>
                </div>

                <div class="pb-40 mb-40 bb-light-lavender3 social-filled-icons">
                    <h2 class="bold f-18 lh-18">{{ t('Website & Social Networks') }}</h2>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-12 link-underline"> 
                            
                            @if(isset($profile->facebook) && $profile->facebook != '')
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big facebook rounded-circle mr-20"></div>
                                <span><a target="_blank" href="{{ $profile->facebook }}">{{ $profile->facebook }}</a></span>
                            </div>
                            @endif

                             

                            @if(isset($profile->instagram) && $profile->instagram != '')
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big instagram rounded-circle mr-20"></div>
                                <span><a target="_blank" href="{{ $profile->instagram }}">{{ ($profile->instagram)? $profile->instagram : '' }}</a></span>
                            </div>
                            @endif

                            <?php /*
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big wix rounded-circle mr-20"></div>
                                <span><label class="position-relative input-label">{{ t('Google Plus') }}</label><br/>{{ ($profile->google_plus)? $profile->google_plus : '' }}</span>
                            </div>
                            */?>

                            @if(isset($profile->twitter) && $profile->twitter != '')
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big twitter rounded-circle mr-20"></div>
                                <span><a target="_blank" href="{{ $profile->twitter }}">{{ ($profile->twitter)? $profile->twitter : '' }}</a></span>
                            </div>
                            @endif

                            @if(isset($profile->linkedin) && $profile->linkedin != '')
                            <div class="d-flex justify-content-start align-items-center mb-30  ">
                                <div class="social-big linkedin rounded-circle mr-20"></div>
                                <span><a target="_blank" href="{{ $profile->linkedin }}">{{ ($profile->linkedin)? $profile->linkedin : '' }}</a></span>
                            </div>
                            @endif

                            @if(isset($profile->pinterest) && $profile->pinterest != '')
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big pinterest rounded-circle mr-20"></div>
                                <span><a target="_blank" href="{{ $profile->pinterest }}">{{ ($profile->pinterest)? $profile->pinterest : '' }}</a></span>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>

                @if($user->id == Auth::User()->id)
                <div class="pb-10 mb-20  bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Contact Information') }}</h2>
                    <div class="divider"></div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('Phone') }}</label>
                        <span><?php echo ($user->phone)? $user->phone_code." ".phoneFormat($user->phone) : ''; ?></span>
                    </div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('Email Address') }}</label>
                        <span>{{ ($user->email)? $user->email : '' }}</span>
                    </div>
                    <div class="pb-10 mb-20 bb-pale-grey link-underline">
                        <label class="position-relative input-label">{{ t('Website') }}</label>
                        @if(isset($profile->website_url) && $profile->website_url != '')
                        <span><a target="_blank" href="{{ ($profile->website_url)? $profile->website_url : '' }}">{{ ($profile->website_url)? $profile->website_url : '' }}</a></span>
                        @endif
                    </div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('Street') }}</label>
                        <span>{{ ($profile->street)? $profile->street : '' }}</span>
                    </div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('City') }}</label>
                        <span>{{ ($city)? $city : '' }}</span>
                    </div>
                    <div class="pb-10 mb-20 bb-pale-grey">
                        <label class="position-relative input-label">{{ t('Country') }}</label>
                        <span>{{ ($country)? $country : '' }}</span>
                    </div>
                    <div class="pb-10">
                        <label class="position-relative input-label">{{ t('Zip') }}</label>
                        <span>{{  ( $profile->zip )? $profile->zip : '' }}</span>
                    </div>
                </div>
                @endif
                <!-- <div class="bb-light-lavender3 pb-40 mb-40">
                    <span class="title">skills</span>
                    <div class="divider"></div>
                    <a href="#"><span class="tag mr-2 mb-2">Dance</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Hostess</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Verlässlichkeit</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Humorvoll</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Models</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Anpassungsfähigkeit</span></a>
                </div>
                <div class="pb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">Languages</h2>
                    <div class="divider"></div>
                    <div class="pb-40 mb-40 bb-pale-grey">
                        <p class="title">English</p>
                        <span>Converational: I write and speak this language well</span>
                    </div>
                    <div>
                        <p class="title">English</p>
                        <span>Converational: I write and speak this language well</span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    @include('childs.bottom-bar')
    <?php /* @include('partner.inc.send-message') */ ?>
    @include('direct-message')
@endsection

@section('page-script')
<style type="text/css">
    .select2-container {
        z-index: 99999 !important;
    }
</style>
<script>
    function formatState (opt) {
             if (!opt.id) {
                return opt.text;
            } 

            var optimage = $(opt.element).attr('data-image'); 
            if(!optimage){
               return opt.text;
            } else {                    
                var $opt = $(
                   '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
                );
                return $opt;
            }    
        };

    $(document).ready( function(){
            
            jQuery.noConflict()(function($){

                $('#direct-message').submit( function(e){
                    e.preventDefault();
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: $('#direct-message').attr('action'),
                        type: 'POST',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        beforeSend: function(){
                            $(".loading-process").show();
                            clearDirectMessage();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success: function (response) {

                            if( response != undefined && response.success == false ){
                                
                                $(".print-error-msg").html('');
                                $(".print-error-msg").css('display','block');
                                $.each( response.message, function( key, value ) {
                                    $(".print-error-msg").append('<p>'+value[0]+'</p>');
                                });
                            }else{
                                $('#direct-message')[0].reset();
                                $(".print-success-msg").html(response.message);
                                $(".print-success-msg").css('display','block');
                            } 
                        }
                    });
                });

                $('#directMessage').on('hidden.bs.modal', function () {
                    $('.textarea-description').val('');
                    $('#direct-message')[0].reset();
                    clearDirectMessage();
                });

                // clear all the messages after model is closed
                function clearDirectMessage(){
                    $(".print-success-msg").html('');
                    $(".print-error-msg").html('');
                    $(".print-success-msg").css('display','none');
                    $(".print-error-msg").css('display','none');
                }

                // $(".phone-code-search").select2({
                //     // minimumResultsForSearch: 5,
                //     minimumResultsForSearch: 5,
                //     width: '100%',
                //     dropdownParent: $("#sendMessage"),
                //     templateResult: formatState,
                //     templateSelection: formatState
                // });
                $('#send-message').submit( function(e){
 

                    e.preventDefault();

                    var formData = new FormData($(this)[0]);

                    $.ajax({
                        url: $('#send-message').attr('action'),
                        type: 'POST',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        beforeSend: function(){
                            $(".loading-process").show();
                            clearMessage();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success: function (response) {

                            if( response != undefined && response.success == false ){

                                $(".print-error-msg").html('');
                                $(".print-error-msg").css('display','block');
                                $("div").removeClass('invalid-input');

                                if (typeof response.errors == "string") {
                                    $(".print-error-msg").append('<p>'+response.errors+'</p>');

                                } else {
                                    $.each( response.errors, function( key, value ) {
                                        $('#'+key).addClass('invalid-input');
                                        $(".print-error-msg").append('<p>'+value[0]+'</p>');
                                    });
                                }
                                
                            } else {
                           
                                if( response.message != undefined && response.message !== ""){
                                    $(".print-success-msg").html(response.message);
                                    $(".print-success-msg").css('display','block');
                                }
                            }
                        }
                    });

                });

                $('#sendMessage').on('hidden.bs.modal', function () {
                    $('.textarea-description').val('');
                    $('#send-message').find('.input-group').removeClass("invalid-input");
                    $('#send-message')[0].reset();
                    $('#send-message').find("#phone_code").val({{(auth()->check()) ? auth()->user()->phone_code : ''}}).trigger('change');
                    clearMessage();
                });
            });    
            // clear all the messages after model is closed
            function clearMessage(){

                $(".print-error-msg").html('');
                $(".print-error-msg").css('display','none');
                $(".print-success-msg").html('');
                $(".print-success-msg").css('display','none');
             }
    });
</script>
@endsection
