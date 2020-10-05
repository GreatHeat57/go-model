@extends('layouts.logged_in.app-model')

@section('content')
<style>
    span.required:after {
        position: static;
        display: inline;
    }
</style> 
   
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords(t('My account')) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>

        <?php
            
            $attr = ['countryCode' => config('country.icode')];
            $tabs = array();
            
            $tabs[lurl(trans('routes.my-data', $attr), $attr)] = t('Personal Info');
            $tabs[lurl(trans('routes.work-settings', $attr), $attr)] = t('Work Settings');
        ?>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-block">
                <li><a href="{{ lurl(trans('routes.my-data', $attr), $attr) }}" class="" data-id="1">{{ t('Personal Info') }}</a></li>
                <li><a href="{{ lurl(trans('routes.work-settings', $attr), $attr) }}" class="active" data-id="2">{{ t('Work Settings') }}</a></li>
            </ul>
        </div>
        <p class="text-center w-lg-596 mx-lg-auto">{{t('work settings subtitle')}}</p>
        
        <!--   <h1 class="text-center prata">{{t('Work Settings')}}</h1>
        <div class="divider mx-auto"></div>
        <p class="text-center mb-30 w-lg-596 mx-lg-auto">{{t('work settings subtitle')}}</p> -->

        <?php /*
        @include('flash::message')
        @if (isset($errors) and $errors->any())
            <div class="alert alert-danger w-lg-750 w-xl-970 mx-auto">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></h5>
                <ul class="list list-check">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        */ ?>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">

            {{ Form::open(array('url' => lurl(trans('routes.work-settings-edit')) , 'method' => 'post', 'id'=>'edit-job-settings-form')) }}
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="px-38 px-lg-0">
                    
                    <?php 
                        $parent_categories = array();
                        if (!empty($user->profile->parent_category)) {
                           $parent_categories = explode(',', $user->profile->parent_category);
                        } 
                    ?>
                
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 required">{{t('categories')}}</h2>
                        <div class="divider"></div>
                        
                        <div class="row custom-checkbox checkboxall">
                            
                            @foreach ($categories as $cat)

                                <?php 
                                    
                                    $selected_cat = $cat->id;
                                    
                                    if($cat->translation_of > 0) {
                                        $selected_cat = $cat->parent_id;
                                    } 

                                    $is_true = in_array($selected_cat , $parent_categories) ? true : false;
                                ?>

                                <div class="col-md-6 col-xl-3 col-sm-12 mb-10">

                                    {{ Form::checkbox('job_categories[]',  $cat->parent_id, $is_true, ['class' => 'checkbox_field', 'id' => 'parent_'.($cat->id)]) }}

                                    {{ Form::label('parent_'.($cat->id), $cat->name, ['class' => 'checkbox-label']) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{t('work status')}}</h2>
                        <div class="divider"></div>

                        <div class="col-md-12 form-group custom-radio work-settings-radio">                            
                            <input type="radio" @if(old('work_status')==='1') checked="checked" 
                                        @elseif($work_status === '1') checked="checked" @endif name="work_status" class="radio_field" id='available' value="1" required="required">
                            {{ Form::label('available', t('Yes, I am available'), ['class' => 'radio-label work-setting-radio-label']) }}

                            <input type="radio" @if(old('work_status')==='0') checked="checked" 
                                        @elseif($work_status === '0') checked="checked" @endif name="work_status" class="radio_field" id='not_available' value="0">
                            {{ Form::label('not_available', t('No, I am not available'), ['class' => 'radio-label']) }}

                             <small class="errors">{!!$errors->first('work_status')!!}  </small>
                        </div>
                    </div>
                    <!-- <div class="pb-40 mb-40">
                        <h2 class="bold f-18 lh-18">{{t('hourly rate')}}</h2>
                        <div class="divider"></div>
                        <p>{{t('hourly rate subtitle')}}</p>
                        <div class="input-group mb-0">
                            {{ Form::Text('hourly_rate', $hourly_rate,['class' => 'animlabel form-content active','required'=>'required']) }}
                            {{ Form::label('hourly_rate', t(':EUR / hr', ['EUR' => $currency_code]), ['class' => 'required']) }}
                        </div>
                         <small class="errors">{!! $errors->first('hourly_rate')!!}  </small>

                    </div>-->
                    <!-- <div class="pb-40 mb-40 bb-light-lavender3"> -->
                        <div class="pb-40 mb-40 bb-light-lavender3">
                            <?php /*
                            <h2 class="bold f-18 lh-18">{{t('job distance')}}</h2>
                            <div class="divider"></div>
                            {!! t('job distance subtitle') !!}
                            <div class="row mb-40 pt-20">
                                <div class="col-md-6 input-group col-xl-4">
                                    <?php   
                                        if(old('job_distance_type') !== null) { 
                                            $job_distance_type_option = old('job_distance_type'); 
                                        } 
                                        else {
                                            $job_distance_type_option = isset($job_distance_type) ? $job_distance_type : '';
                                        }
                                    ?>

                                    <select class="form-content" name="job_distance_type" id="distance_type" required="true">
                                        <option value="" @if($job_distance_type_option=='') selected="selected" @endif>{{ t('distance_type') }}</option>
                                        <option value="km_radius" @if($job_distance_type_option=='km_radius') selected="selected" @endif>{{ t('km_radius') }}</option>
                                        <option value="whole_country" @if($job_distance_type_option=='whole_country') selected="selected" @endif>{{ t('whole_country') }}</option>
                                        <option value="international" @if($job_distance_type_option=='international') selected="selected" @endif>{{ t('international') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-6 input-group" id="km_distance">
                                    <input  type="text" name="job_distance" value="{{ old('job_distance', $job_distance) }}" class="required" id="job_distance" / placeholder="0 - 100 km"><br/>
                                    <small class="errors">{!!$errors->first('job_distance')!!}  </small>
                                </div>
                            </div> 
                            */ ?>
                        <div class="pb-40">
                            <h2 class="bold f-18 lh-18">{{t('job time')}}</h2>
                            <div class="divider"></div>
                            {!! t('job time subtitle') !!}
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('monday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">

                                    <?php   
                                        if(old('from_hrs.0') !== null) { 
                                            $from_hrs_0 = old('from_hrs.0'); 
                                        } 
                                        else {
                                            $from_hrs_0 = isset($fromhrs[0]) ? $fromhrs[0] : '';
                                        }
                                        if(old('to_hrs.0') !== null) { 
                                            $to_hrs_0 = old('to_hrs.0'); 
                                        } 
                                        else {
                                            $to_hrs_0 = isset($tohrs[0]) ? $tohrs[0] : '';
                                        }
                                    ?>
                                    <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_0==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_0==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                  
                                    {{ Form::hidden('day[]', 'monday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('tuesday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.1') !== null) { 
                                            $from_hrs_1 = old('from_hrs.1'); 
                                        } 
                                        else {
                                            $from_hrs_1 = isset($fromhrs[1]) ? $fromhrs[1] : '';
                                        }
                                        if(old('to_hrs.1') !== null) { 
                                            $to_hrs_1 = old('to_hrs.1'); 
                                        } 
                                        else {
                                            $to_hrs_1 = isset($tohrs[1]) ? $tohrs[1] : '';
                                        }
                                    ?>

                                     <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_1==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_1==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'tuesday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('wednesday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.2') !== null) { 
                                            $from_hrs_2 = old('from_hrs.2'); 
                                        } 
                                        else {
                                            $from_hrs_2 = isset($fromhrs[2]) ? $fromhrs[2] : '';
                                        }
                                        if(old('to_hrs.2') !== null) { 
                                            $to_hrs_2 = old('to_hrs.2'); 
                                        } 
                                        else {
                                            $to_hrs_2 = isset($tohrs[2]) ? $tohrs[2] : '';
                                        }
                                    ?>
                                     <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_2==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_2==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'wednesday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('thursday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.3') !== null) { 
                                            $from_hrs_3 = old('from_hrs.3'); 
                                        } 
                                        else {
                                            $from_hrs_3 = isset($fromhrs[3]) ? $fromhrs[3] : '';
                                        }
                                        if(old('to_hrs.3') !== null) { 
                                            $to_hrs_3 = old('to_hrs.3'); 
                                        } 
                                        else {
                                            $to_hrs_3 = isset($tohrs[3]) ? $tohrs[3] : '';
                                        }
                                    ?>
                                    <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_3==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_3==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'thursday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('friday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.4') !== null) { 
                                            $from_hrs_4 = old('from_hrs.4'); 
                                        } 
                                        else {
                                            $from_hrs_4 = isset($fromhrs[4]) ? $fromhrs[4] : '';
                                        }
                                        if(old('to_hrs.4') !== null) { 
                                            $to_hrs_4 = old('to_hrs.4'); 
                                        } 
                                        else {
                                            $to_hrs_4 = isset($tohrs[4]) ? $tohrs[4] : '';
                                        }
                                    ?>
                                     <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_4==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_4==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'friday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('saturday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.5') !== null) { 
                                            $from_hrs_5 = old('from_hrs.5'); 
                                        } 
                                        else {
                                            $from_hrs_5 = isset($fromhrs[5]) ? $fromhrs[5] : '';
                                        }
                                        if(old('to_hrs.5') !== null) { 
                                            $to_hrs_5 = old('to_hrs.5'); 
                                        } 
                                        else {
                                            $to_hrs_5 = isset($tohrs[5]) ? $tohrs[5] : '';
                                        }
                                    ?>
                                     <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_5==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($to_hrs_5==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'saturday') }}
                                </div>
                            </div>
                            <div class="row mb-30">
                                <span class="bold col-md-3 col-xl-2">{{t('sunday')}}</span>
                                <div class="d-flex col-md-6 col-xl-4">
                                    <?php   
                                        if(old('from_hrs.6') !== null) { 
                                            $from_hrs_6 = old('from_hrs.6'); 
                                        } 
                                        else {
                                            $from_hrs_6 = isset($fromhrs[6]) ? $fromhrs[6] : '';
                                        }
                                        if(old('to_hrs.6') !== null) { 
                                            $to_hrs_6 = old('to_hrs.6'); 
                                        } 
                                        else {
                                            $to_hrs_6 = isset($tohrs[6]) ? $tohrs[6] : '';
                                        }
                                    ?>
                                    <select class="form-content" name="from_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option @if($from_hrs_6==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                   
                                    <span class="mx-20"> - </span>
                                    <select class="form-content" name="to_hrs[]">
                                        @for($i=config('constant.JOB_TIME_START'); $i< config('constant.JOB_TIME_END'); $i++)
                                        <option  @if($to_hrs_6==$i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                    {{ Form::hidden('day[]', 'sunday') }}
                                </div>
                            </div>
                            @include('childs.bottom-bar-save')
                        </div>

                        
                        <!-- Add new fields for the newsletters -->
                        <div class="pb-40 mb-40">

                            <h2 class="bold f-18 lh-18">{{t('newsletter')}}</h2>
                            <div class="divider"></div>
                            
                            <div class="row custom-checkbox">
                                <div class="col-md-12 col-sm-12">
                                    {{ Form::checkbox('newsletter',  1, old('newsletter',(!empty($user->receive_newsletter))? $user->receive_newsletter:'' ), ['class' => 'checkbox_field', 'id' => 'newsletter']) }}

                                    {{ Form::label('newsletter', t('Job-Newsletters'), ['class' => 'checkbox-label']) }}
                                </div>
                            </div>
                        </div>
                        <!-- Add new fields for the newsletters -->
                        
                    </div>
                <!-- </div> -->
              
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(document).ready( function(){
            $('#km_distance').hide();
            var option = $("#distance_type option:selected").val();

            if(option === 'km_radius'){
                $('#km_distance').show();
                $( "input[name='job_distance']" ).prop('required',true);
            }

            $('#distance_type').on('change', function(){
                var selected_distance = $(this).val();

                if(selected_distance === 'km_radius'){
                    $('#km_distance').show();
                    $( "input[name='job_distance']" ).prop('required',true);
                }else{
                    $('#job_distance').val('');
                    $('#km_distance').hide();
                    $( "input[name='job_distance']" ).prop('required',false);
                }
            });


        })
    </script>

    
    @if(!Gate::check('update_profile', $user))
        <script>
            $(document).ready( function(){
                $(".checkboxall input:checkbox").attr("disabled", "disabled");
                $(".custom-radio input:radio").attr("disabled", "disabled").css({"pointer-events": "none", "opacity": "0.5"});
                $('select').attr('disabled', true);
            });
        </script>
        <style type="text/css">
            .custom-radio input[type=radio].radio_field:disabled+label.radio-label { color: #a7a7a7; }
        </style>
    @endif

@endsection