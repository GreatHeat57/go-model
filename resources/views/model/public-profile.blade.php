@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

@section('content')
    @include('model.public-profile-top')
    

    <div class="container pt-40 px-0">

        <div class="custom-tabs mb-20 mb-xl-30">
            <?php
            $tabs = array();
            $tabs[route('model-sedcard',['id' => $user_id])] = t('Sedcard');
            $tabs[route('model-portfolio',['id' => $user_id])] = t('Model Book');
                if(Auth::user()->user_type_id == 2){
                    $tabs[lurl(trans('routes.user').'/'.$user_name)] = t('Details');
                }else{
                    $tabs[lurl('user')] = t('Details');
                }
            ?>

            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-flex justify-content-center">
                <li><a href="{{ route('model-sedcard',['id' => $user_id]) }}">{{ t('Sedcard') }}</a></li>
                <li><a href="{{ route('model-portfolio',['id' => $user_id]) }}"> {{ t('Model Book') }}</a></li>
                @if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id == $user->id)
                    <li><a href="{{ lurl('user') }}" class="active">{{ t('Details') }}</a></li>
                @else
                    <li><a href="{{ lurl(trans('routes.user').'/'.$user_name) }}" class="active">{{ t('Details') }}</a></li>
                @endif
            </ul>
        </div>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white py-60 px-38 px-lg-0 mb-40 w-xl-1220 mx-xl-auto">

            @if(\Auth::user()->user_type_id == config('constant.model_type_id')  && Gate::check('premium_country_free_user', \Auth::user()))
                <div class="w-lg-750 w-xl-970 mx-auto">
                    
                    <span class="title d-flex justify-content-between">
                        {{ t('Profile Type')}}
                    </span>
                    
                    <div class="divider"></div>
                    
                    <p>{{ t('Profile Type Description') }}</p>
                    
                    <div class="d-flex justify-content-center align-items-center container px-0">
                        <a href="#" data-toggle="modal" data-target="#go-premium" class="btn btn-white no-bg mb-20">{{ t('Learn more') }}</a>
                    </div>

                </div>
            @endif


            <div class="w-lg-750 w-xl-970 mx-auto">
                <span class="title d-flex justify-content-between">
                    {{ t('Profile Details')}}
                </span>
                <div class="divider"></div>
                <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
                    <div class="col-md-6 pl-0">
                        <p><span class="bold d-inline-block mr-1">{{ t('Height') }}:</span><span class="d-inline-block">{{ $height }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Chest') }}:</span><span class="d-inline-block">{{ $chest }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Waist') }}:</span><span class="d-inline-block">@if($waist > 0) {{ $waist }} @else --  @endif</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Hips') }}:</span><span class="d-inline-block">@if($hip > 0) {{ $hip }} @else --  @endif</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Dress size') }}:</span><span class="d-inline-block">{{ $dress_size }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Shoe size') }}:</span><span class="d-inline-block">{{ $shoe_size }}</span></p>
                    </div>
                    <div class="col-md-6 pr-0 pl-0">
                        <p><span class="bold d-inline-block mr-1">{{ t('Weight') }}:</span><span class="d-inline-block">{{ $weight }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Eye color') }}:</span><span class="d-inline-block">{{ $eye_color }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Hair color') }}:</span><span class="d-inline-block">{{ $hair_color }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Skin color') }}:</span><span class="d-inline-block">{{ $skin_color }}</span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Piercing') }}:</span><span class="d-inline-block">
                            <?php 
                            if($piercing == 1){
                                ?>
                                {{ t('Yes') }}
                            <?php
                            } else if($piercing == 2) { ?>
                                {{ t('No') }}
                            <?php
                            }else{ ?>
                                {{ t('No') }}
                            <?php
                            }
                            ?>
                        </span></p>
                        <p><span class="bold d-inline-block mr-1">{{ t('Tattoo') }}:</span><span class="d-inline-block">
                            <?php 
                            if($tattoo == 1){
                                ?>
                                {{ t('Yes') }}
                            <?php
                            } else if($tattoo == 2) { ?>
                                {{ t('No') }}
                            <?php
                            } else{ ?>
                                {{ t('No') }}
                            <?php
                            }
                            ?>
                        </span></p>
                    </div>
                    <div class="col-md-6 pr-0 pl-0">
                        <a href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}" class="btn btn-white download mr-4 mb-20">{{ t('Download Sedcard') }}</a>
                    </div>
                    <div class="col-md-6 pr-0 pl-0">
                        <a href="{{ lurl('account/'.$user->id.'/downloadmbook') }}" class="btn btn-white download mb-20">{{ t('Download Modelbook') }} </a>
                    </div>
                </div>

                <div class="bb-light-lavender3 pb-40 mb-40 description-table">
                    <span class="title">{{t('About Me')}}</span>
                    <div class="divider"></div>
                    <p class=""><?php echo ($profile->description)? stripslashes($profile->description) : ''; ?></p>
                </div>

                <?php
                    $resume_file = '';
                    if (isset($resume) && !empty($resume)) {
                        $resume_file = \Storage::url($resume);
                    }
                ?>
                @if(!empty($resume_file))
                    <div class="bb-light-lavender3 pb-40 mb-40">
                        <span class="title">{{t('Download CV')}}</span>
                        <div class="divider"></div>
                        <a href="{{ $resume_file }}" class="btn btn-white download mb-20"  target="_blank" download><i class="fa fa-download"></i> {{ t('Download CV') }}</a>
                    </div>
                @endif
                @if(!empty($talent))
                    <div class="bb-light-lavender3 pb-40 mb-40">
                        <span class="title">{{t('Skills')}}</span>
                        <div class="divider"></div>
                        @foreach($talent as $key => $tal)
                         <span class="tag mr-2 mb-2">{{$tal['title']}}</span>
                        @endforeach
                    </div>
                @endif
                <?php if (isset($language) && count($language) > 0): ?>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Languages') }}</h2>
                    <div class="divider"></div>
                    <?php
                        $i = 0;
                        // $last_ele = end($language);
                        $total_language=count($language);

                        foreach ($language as $key => $lang):
                            $i++;
                            
                            if (!empty($lang['language_name']) && array_key_exists($lang['language_name'], $language_list)){
                                
                                $language = trans('language.'.$language_list[$lang['language_name']]);

                            } else {
                                $language = '';
                            }

                            $proficiency_level = '';
                            if (!empty($lang['proficiency_level'])) {
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
                        <div class="@if($i != $total_language) pb-20  mb-20  @endif">
                            <p class="">{{$language}} - {{ $proficiency_level }}</p>
                            <span>{!! !empty($lang['description']) ? $lang['description'] : '' !!}</span>
                        </div>
                        <?php endforeach;?>   
                </div>
                <?php endif;?>

                <?php if (isset($experience) && sizeof($experience) > 0): ?>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('Experience in Model Business')}}</h2>
                    <div class="divider"></div>
                    <?php
                        $i = 0;
                        foreach ($experience as $key => $exp):
                        $i++;
                        if (!isset($exp['up_to_date']) || $exp['up_to_date'] == '1') {
                            $to_date = date('Y-m-d');
                        } else {
                            $to_date = $exp['to'];
                        }
                   ?>
                        <!-- <div class="@if($i != count($experience) || $i==1)pb-40 mb-40 bb-pale-grey @endif"> -->
                        <div class="@if($i != count($experience))pb-40 mb-40 bb-pale-grey @endif">
                           <p>{{$exp['title']}}</p>
                           <span>{{$exp['company']}} {{date("Y", strtotime($exp['from']))}} - {{date("Y", strtotime($to_date))}}</span>
                        </div>
                        <?php endforeach;?>
                </div>
                <?php endif;?>

                <?php 
                if (isset($awards) && sizeof($awards) > 0): ?>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Experience / Reference') }}</h2>
                    <div class="divider"></div>
                        <?php
                            $i = 0;
                            foreach ($awards as $key => $ref):
                               $i++;
                       ?>
                        <div class="@if($i != count($awards))pb-40 mb-40 bb-pale-grey @endif">
                            <p>{{$ref['title']}}</p>
                            <span>{{date("Y", strtotime($ref['date']))}}</span>
                        </div>
                        <?php endforeach;?>
                </div>
                <?php endif;?>

                <?php if (isset($education) && sizeof($education) > 0): ?>
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Education') }}</h2>
                    <div class="divider"></div>
                        <?php
                            $i = 0;
                            foreach ($education as $key => $edu):
	                           $i++;
                            	if (!isset($edu['up_to_date']) || $edu['up_to_date'] == '1') {
                            		$to_date = date('Y-m-d');
                            	} else {
                            		$to_date = $edu['to'];
                            	}
	                   ?>
						<div class="@if($i != count($education))pb-40 mb-40 bb-pale-grey @endif">
						    <p>{{$edu['title']}} <span class="d-inline-block bullet bg-lavender rounded-circle mx-1"></span> {{$edu['institute']}}</p>
						    <span>{{date("Y", strtotime($edu['from']))}} - {{date("Y", strtotime($to_date))}} </span>
						</div>
						<?php endforeach;?>
                </div>
                <?php endif;?>

                    <!-- <div>
                        <p>Applied Graphuc Art <span class="d-inline-block bullet bg-lavender rounded-circle mx-1"></span> Győr School of Art</p>
                        <span>1996-2000</span>
                    </div> -->
                <!-- </div> -->
                @if(!empty($website_url) || !empty($google_plus) || !empty($instagram) || !empty($facebook) || !empty($linkedin) || !empty($twitter))
                <div class="pb-40 mb-40 bb-light-lavender3 social-filled-icons">
                    <h2 class="bold f-18 lh-18">{{ t('Website & Social Networks') }}</h2>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-12 link-underline">
                            @if(!empty($website_url))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big wix rounded-circle mr-20"></div>
                                <!-- <span>gomodels.com/<br/>amelie6212</span> -->
                                <span><a href="{{ $website_url}}" target="_blank">{{ $website_url}}</a></span>
                            </div>
                            @endif
                            <?php /*
                            @if(!empty($google_plus))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big wix rounded-circle mr-20"></div>
                                <!-- <span>gomodels.com/<br/>amelie6212</span> -->
                                <span>{{ $google_plus}}</span>
                            </div>
                            @endif
                            */?>
                            @if(!empty($instagram))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big instagram rounded-circle mr-20"></div>
                                <!-- <span>instagram.com/<br/>{{ $instagram}}</span> -->
                                <span><a href="{{ $instagram}}" target="_blank" >{{ $instagram}}</a></span>
                            </div>
                            @endif
                            @if(!empty($facebook))
                            <div class="d-flex justify-content-start align-items-center mb-30 ">
                                <div class="social-big facebook rounded-circle mr-20"></div>
                                <!-- <span>facebook.com/<br/>{{ $facebook}}</span> -->
                                <span><a href="{{ $facebook}}" target="_blank">{{ $facebook}}</a></span>
                            </div>
                            @endif
                       
                            @if(!empty($linkedin))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big linkedin rounded-circle mr-20"></div>
                                <!-- <span>linkedin.com/<br/>amelie6212</span> -->
                                <span><a href="{{ $linkedin}}" target="_blank">{{ $linkedin}}</a></span>
                            </div>
                            @endif
                            @if(!empty($twitter))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big twitter rounded-circle mr-20"></div>
                                <!-- <span>twitter.com/<br/>amelie6212</span> -->
                                <span><a href="{{ $twitter}}" target="_blank">{{ $twitter}}</a></span>
                            </div>
                            @endif
                            @if(!empty($pinterest))
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big pinterest rounded-circle mr-20"></div>
                                <!-- <span>twitter.com/<br/>amelie6212</span> -->
                                <span><a href="{{ $pinterest}}" target="_blank">{{ $pinterest}}</a></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="pb-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{t('job time')}}</h2>
                    <div class="divider"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered availble_hours_table">
                            <tr>
                                <td class="text-center">{{t('Time of day')}}</td>
                                <td class="text-center"><?php echo substr(t('monday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('tuesday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('wednesday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('thursday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('friday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('saturday'),0,2); ?></td>
                                <td class="text-center"><?php echo substr(t('sunday'),0,2); ?></td>
                            </tr>
                            <?php 
                                $k = 0;   
                                $arrText = ['0-6','6-9','9-12','12-15','15-18','18-21','21-24'];
                                $arr_1 = [0,1,2,3,4,5,6];
                                $arr_2 = [6,7,8,9];
                                $arr_3 = [9,10,11,12];
                                $arr_4 = [12,13,14,15];
                                $arr_5 = [15,16,17,18];
                                $arr_6 = [18,19,20,21];
                                $arr_7 = [21,22,23,24];

                                $a_1 = [];
                                for ($i=$fromhrs[0]; $i <=$tohrs[0] ; $i++) { 
                                    array_push($a_1, $i);
                                }
                                $a_2 = [];
                                for ($i=$fromhrs[1]; $i <=$tohrs[1] ; $i++) { 
                                    array_push($a_2, $i);
                                }
                                $a_3 = [];
                                for ($i=$fromhrs[2]; $i <=$tohrs[2] ; $i++) { 
                                    array_push($a_3, $i);
                                }
                                $a_4 = [];
                                for ($i=$fromhrs[3]; $i <=$tohrs[3] ; $i++) { 
                                    array_push($a_4, $i);
                                }
                                $a_5 = [];
                                for ($i=$fromhrs[4]; $i <=$tohrs[4] ; $i++) { 
                                    array_push($a_5, $i);
                                }
                                $a_6 = [];
                                for ($i=$fromhrs[5]; $i <=$tohrs[5] ; $i++) { 
                                    array_push($a_6, $i);
                                }
                                $a_7 = [];
                                for ($i=$fromhrs[6]; $i <=$tohrs[6] ; $i++) { 
                                    array_push($a_7, $i);
                                }
                            ?>
                            <?php foreach ($arrText as $value): 
                                 $k++;
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $value; ?></td>
                                    <?php 
                                       $var = "arr_".$k;
                                       $mon = false;
                                        foreach ($a_1 as $v) {
                                           if(in_array($v, $$var)){
                                                $mon = true;
                                           }
                                        }
                                        if($mon == true){
                                            $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html = '';
                                        }
                                    ?> 
                                    <td class="text-center <?php if($mon == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html; ?>
                                    </td>
                                    <?php 
                                       $var = "arr_".$k;
                                       $tue = false;
                                        foreach ($a_2 as $v) {
                                           if(in_array($v, $$var)){
                                               $tue =true;
                                           }
                                        }
                                        if($tue == true){
                                            $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html = '';
                                        }
                                    ?> 
                                    <td class="text-center <?php if($tue == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html; ?>
                                    </td>
                                    <?php 
                                       $var = "arr_".$k;
                                       $wed = false;
                                        foreach ($a_3 as $v) {
                                           if(in_array($v, $$var)){
                                                $wed = true;
                                           }
                                        }
                                        if($wed == true){
                                           $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html ="";
                                        }
                                    ?> 
                                    <td class="text-center <?php if($wed == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html; ?>
                                    </td>
                                    <?php 
                                       $var = "arr_".$k;
                                       $thu = false;
                                        foreach ($a_4 as $v) {
                                           if(in_array($v, $$var)){
                                                $thu = true;
                                           }
                                        }
                                        if($thu == true){
                                            $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html = "";
                                        }
                                    ?> 
                                    <td class="text-center <?php if($thu == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html; ?>
                                    </td>
                                    <?php 
                                        $var = "arr_".$k;
                                        $fri = false;
                                        foreach ($a_5 as $v) {
                                           if(in_array($v, $$var)){
                                                $fri = true;
                                           }
                                        }
                                        if($fri == true){
                                            $html =  '<b><i class="icon-ok"></i></b>';
                                        }
                                        else{
                                            $html = "";
                                        }
                                    ?> 
                                    <td class="text-center <?php if($fri == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html;?>
                                    </td>
                                    <?php 
                                        $var = "arr_".$k;
                                        $sat = false;
                                        foreach ($a_6 as $v) {
                                           if(in_array($v, $$var)){
                                              $sat = true;
                                           }
                                        }
                                        if($sat == true){
                                            $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html ="";
                                        }
                                    ?> 
                                    <td class="text-center <?php if($sat == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html;?>
                                    </td>
                                    <?php 
                                       $var = "arr_".$k;
                                       $sun = false;
                                        foreach ($a_7 as $v) {
                                            if(in_array($v, $$var)){
                                                $sun = true;
                                            }
                                        }
                                        if($sun == true){
                                            $html = '<b><i class="icon-ok"></i></b>';
                                        } else {
                                            $html = "";
                                        }
                                    ?> 
                                    <td class="text-center <?php if($sun == true){ echo 'avail_hours';} ?>">
                                        <?php echo $html;?>
                                    </td>
                                </tr>                         
                            <?php endforeach ?>
                        </table>
                    </div>
                    <?php
                        /**
                         * Add contry code for work-settings.
                         */
                        $attr = ['countryCode' => config('country.icode')];
                    ?>

                    @if(Auth::user()->user_type_id !== config('constant.partner_type_id') && Auth::user()->id == $profile->user_id)
                        <!-- Add job setting button -->
                        <div class="d-flex justify-content-center align-items-center container px-0">
                            <a href="{{ lurl(trans('routes.work-settings', $attr), $attr) }}" class="btn btn-white edit_grey  mb-20">{{ t('Work Settings') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('childs.bottom-bar')
    @include('direct-message')
    
@endsection
@section('page-script')
<style type="text/css">
    .availble_hours_table th, .availble_hours_table td{
        padding:0px !important;
    }
</style>
<link rel="stylesheet" href="{{ url(config('app.cloud_url').'/assets/plugins/font-awesome/css/font-awesome.min.css') }}">
<script type="text/javascript">
    $(document).ready(function(){

        $('.tabs').on('change',function(){
            if($(this).val() == 0){
                window.location = '{{ route('model-sedcard',['id' => $user_id]) }}';
            }
            if($(this).val() == 1){
                window.location = '{{ route('model-portfolio',['id' => $user_id]) }}';
            }
        });

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
    });


    jQuery.noConflict()(function($){
        $(document).on('hide.bs.modal','#inviteJob', function () {
            $('.print-error-msg').hide();
            $('#invit_form').find('#job-id').val(null).trigger('change');
        });

        // $('#directMessage').on('hidden.bs.modal', function () {
        $(document).on('hide.bs.modal','#directMessage', function () {
            $('.textarea-description').val('');
            $('#direct-message')[0].reset();
            clearDirectMessage();
        });
    });
    // clear all the messages after model is closed
    function clearDirectMessage(){
        $(".print-success-msg").html('');
        $(".print-error-msg").html('');
        $(".print-success-msg").css('display','none');
        $(".print-error-msg").css('display','none');
    }

</script>
{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
@endsection