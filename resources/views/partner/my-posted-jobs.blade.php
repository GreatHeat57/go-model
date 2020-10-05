@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

<?php
    $fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
    $tmpExplode = explode('?', $fullUrl);
    $fullUrlNoParams = current($tmpExplode);
?>

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>

                @if(Auth::User()->user_type_id === '2')

                    @if ($pagePath=='my-posts')
                    <h1 class="text-center prata"> {{ ucWords(t('My ads')) }} </h2>

                    @elseif ($pagePath=='archived')
                        <h1 class="prata">{{ ucWords(t('Archived ads')) }} </h2>

                    @elseif ($pagePath=='favourite')
                        <h1 class="prata">{{ ucWords(t('Favourite jobs')) }} </h2>

                    @elseif ($pagePath=='pending-approval')
                        <h1 class="prata">{{ ucWords(t('Pending approval')) }} </h2>
                    @endif

                @endif

                @if ($pagePath=='job-applied')
                    <h1 class="prata">{{ ucWords(t('Jobs Applied')) }} </h2>
                @endif
                <div class="divider mx-auto"></div>
            </div>

            <!-- Hide filter from job applied page -->
            @if ($pagePath !== 'job-applied')
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="javascript:void(0);" class="btn btn-white filters mr-20 mini-all" title="{{ t('Filter Result') }}"></a>
                <a href="javascript:void(0);" class="btn btn-white search mini-under-desktop">{{ t('Search') }}</a>
            </div>
            @endif
            <!-- Hide filter from job applied page -->

        </div>
         @include('childs.mypost-filter')

        <?php
            $tabs = array();
            if(Auth::User()->user_type_id === '2'){
                $tabs[ lurl('account/my-posts') ] = t('All');
                $tabs[ lurl('account/archived') ] = t('Archived ads');
                $tabs[ lurl(trans('routes.job-applied')) ] = t('Jobs Applied');
            }else{
                $tabs[ lurl(trans('routes.job-applied')) ] = t('Jobs Applied');
            }
        ?>
        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="d-none d-md-block">
                @if(Auth::User()->user_type_id === '2')
                <li>
                    <a href="{{ lurl('account/my-posts') }}" class="{{ ($pagePath=='my-posts') ? 'active' : '' }} position-relative" title="{{ t('View detail') }}">{{ t('All') }}
                        @if(isset($allPostCount) && $allPostCount > 0)

                            <?php if( $allPostCount > config('app.num_counter') ){ ?>
                                <span class="msg-num tab ongoing">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num tab ongoing">{{ $allPostCount }}</span>
                            <?php } ?>
                        @endif
                    </a>
                    
                </li>
                
                <li>
                    <a href="{{ lurl('account/archived') }}" class="{{ ($pagePath=='archived') ? 'active' : '' }} position-relative">{{ t('Archived ads') }}
                        @if(isset($allArchivedPosts) && $allArchivedPosts > 0)
                           
                            <?php if( $allArchivedPosts > config('app.num_counter') ){ ?>
                                <span class="msg-num tab drafted">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num tab drafted">{{ $allArchivedPosts }}</span>
                            <?php } ?>
                        @endif
                    </a>
                </li>

                @endif
                <li>
                    <a href="{{ lurl(trans('routes.job-applied')) }}" class="{{ ($pagePath=='job-applied') ? 'active' : '' }} position-relative">{{ t('Jobs Applied') }}
                        @if(isset($jobApplied) && $jobApplied > 0)
                            <?php if( $jobApplied > config('app.num_counter') ){ ?>
                                <span class="msg-num tab">{{ config('app.num_counter').'+' }}</span>
                            <?php } else { ?>
                                <span class="msg-num tab">{{ $jobApplied }}</span>
                            <?php } ?>
                        @endif
                    </a>
                </li>
                
            </ul>
        </div>
        
               
        <div class="mx-auto">
            @include('childs.notification-message')
        </div>
        
        <?php  /*
        <!-- Hide filter from job applied page -->
        @if ($pagePath !== 'job-applied')
            <div class="position-relative mx-xl-auto pb-20 ">
            @if (isset($paginator) and $paginator->getCollection()->count() > 0 )
            
                <form name="listForm" method="POST" action="{{ lurl('account/'.$pagePath.'/delete') }}">
                    {!! csrf_field() !!}
                    <div class="row listForm-deleteAll-container">
                        <div class="col-md-6 col-6 form-group custom-checkbox middle-checkbox">
                            <input class="checkbox_field" id="checkAll" name="entries" type="checkbox">
                            <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }} </label>
                        </div>
                        <div class="col-md-6 col-6 form-group custom-checkbox text-right">
                            <button type="submit"  class="btn btn-white trash_white delete-btn">{{ t('Delete') }}</button>
                        </div>
                    </div>        
            @endif
            </div>
        @endif
        <!-- Hide filter from job applied page -->
        */ ?>

        @if (isset($paginator) and $paginator->getCollection()->count() > 0 )
            <div class="row mb-40" id="append-posts"> 
            @foreach ($paginator->getCollection() as $k => $post)
                <?php $postUrl = lurl($post->uri);


                    if (in_array($pagePath, ['pending-approval', 'archived'])) {
                        $postUrl = $postUrl . '?preview=1';
                    }

                    $city = ($post->city) ? $post->city : '';
                    $country = ($post->country_name) ? $post->country_name : '';

                    $show_city_country = '';
                    
                    if(!empty($city)){
                        $city_name = explode(',', $city);
                         $show_city_country = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $city;
                        // $show_city_country = $city;
                    }

                    if(!empty($city) && !empty($country)){
                        $show_city_country .= ', ';
                    }

                    $show_city_country .= $country;

                    $iconPath  ='';

                    //$currency_symbol = isset($post->currency->html_entity)? $post->currency->html_entity : isset($post->currency->font_arial)? $post->currency->font_arial : config('currency.symbol');

                    if(isset($post->currency->html_entity)){
                        $currency_symbol = $post->currency->html_entity;
                    }else{
                        if(isset($post->currency->font_arial)){
                            $currency_symbol = $post->currency->font_arial;
                        }else{
                            $currency_symbol = config('currency.symbol');
                        }
                    }

                ?>
                        
                        <div class="col-md-6 mb-20">
                            <div class="box-shadow bg-white pt-20 pr-20 pb-20 pl-30 position-relative">
                                
                                <a href="{{ $postUrl }}" title="{{ t('View detail') }}">
                                    @if(isset($post->is_home_job) && $post->is_home_job == 1)
                                        <span class="user-h to-left-30 to-top-0 home"></span>
                                    @else
                                        <span class="flag to-left-30 to-top-0 ongoing"></span>
                                    @endif
                                </a>


                                <div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender company-img-holder">
                                    <a href="javascript:void(0);" style="cursor: default;">
                                        @if(isset($post->company->logo) && $post->company->logo !== "" && Storage::exists($post->company->logo))

                                            <img src="{{ \Storage::url($post->company->logo) }}" alt="{{$post->company->name }}">
                                        @else
                                            <img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                                    {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                                    {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png@3x') }} 3x"
                                                    src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.User') }}" class="from-img nopic"/>
                                        @endif
                                    </a>
                                </div>
                                
                                <?php /*
                                <!-- Hide filter from job applied page -->
                                @if ($pagePath !== 'job-applied')
                                    <div class="col-md-6 col-xl-3 mt-20 position-absolute to-top-0" style="right: 5px;">
                                        <div class="custom-checkbox position-absolute to-top-0 to-right-0">
                                            <input class="checkbox_field delete-chk" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $post->id }}" title="{{ t('Select') }}">
                                            <label for="studio_{{$k}}" title="{{ t('Select') }}" class="checkbox-label"><strong>&nbsp;</strong></label>
                                        </div>
                                    </div>
                                @endif
                                */ ?>

                                <a href="{{ $postUrl }}" title="{{ mb_ucfirst($post->title) }}"><span class="title pt-40">{{ mb_ucfirst($post->title) }}</span></a>
        
                                <span>{{ isset($post->postType->name)? $post->postType->name : '' }}</span>
                                <div class="divider"></div>
                                <p class="mb-30 overflow-wrap">{{ str_limit(strip_tags($post->description), config('constant.description_limit')) }}</p>
                         
                                <?php 
                                    $salary_min = (isset($post->salary_min) && $post->salary_min > 0)? $post->salary_min : '';
                                    $salary_max = (isset($post->salary_max) && $post->salary_max > 0)? $post->salary_max : '';
                                ?>

                                @if(isset($post->is_home_job) && $post->is_home_job == 1)
                                    <span class="info home-job mb-10">{{ t('home_modeling_job') }}</span>
                                @endif

                                @if($salary_max !== '' || $salary_min !== '')
                                    <span class="info currency mb-10"> 
                                        
                                        @if($salary_min != "")
                                            {{ \App\Helpers\Number::money($salary_min, $currency_symbol) }} 
                                        @endif
                                        @if($salary_min != "" && $salary_max != "")
                                            - 
                                        @endif
                                        @if($salary_max != "")
                                            {{ \App\Helpers\Number::money($salary_max, $currency_symbol) }}
                                        @endif
                                        
                                        @if($post->negotiable)
                                            {{ t('Negotiable') }}
                                        @endif
                                    </span>
                                @else
                                   <!--  <span>&nbsp;</span> -->
                                @endif

                                @if($salary_max == '' && $salary_min == '' && $post->negotiable)
                                    <span class="info currency mb-10">{{ \App\Helpers\Number::money('') }} - {{ t('Negotiable') }}</span>
                                @endif
                                <span class="info city mb-10">
                                    {{ $show_city_country }}
                                </span>

                                <!-- Hide filter from job applied page -->
                                @if ($pagePath !== 'job-applied')

                                    <span class="info partner mb-10">
                                        @if($post->jobApplicationsCount->count() > 0)
                                        <a href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">{{ $post->jobApplicationsCount->count() }} {{ t('applications') }}</a>
                                        @else
                                        {{ $post->jobApplicationsCount->count() }} {{ t('applications') }}
                                        @endif
                                    </span>
                                    <span class="info partner mb-10">
                                        @if($post->postInviations->count() > 0)
                                        <a href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">{{ $post->postInviations->count() }} {{ t('invitations') }}</a>
                                        @else
                                        {{ $post->postInviations->count() }} {{ t('invitations') }}
                                        @endif
                                    </span>
                                    <span class="info partner mb-10">
                                       {{ $post->jobVisits->count()}} {{ t('Visitors') }} 
                                    </span>

                                    <?php /*
                                    @if( isset($post->end_application) && !empty($post->end_application))
                                    <span class="info appointment mb-10">
                                        {{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }}
                                    </span>
                                    @endif */?>

                                @endif
                                <!-- Hide filter from job applied page -->
                             
                                <span class="info posted">{{ t('Posted On') }} <strong>{{ \App\Helpers\CommonHelper::getFormatedDate($post->created_at) }}</strong></span>
                                
                                <!-- Hide filter from job applied page -->
                                @if ($pagePath !== 'job-applied')
                                    <div class="d-flex justify-content-end">
                                        <div class="position-relative">
                                            <a href="#" class="btn btn-success more mr-20 mini-all dropdown-main"  data-content="more-dropdown-{{$k}}" title="{{ t('More Actions') }}"></a>
                                            <div class="bg-white box-shadow py-10 px-30 dropdown-content" data-content="more-dropdown-{{$k}}">

                                                @if ($post->user_id == Auth::User()->id and $post->archived==0)
                                                    <?php 
                                                    // $attrId['id'] = $post->id; 

                                                    $attr = ['countryCode' => config('country.icode'), 'id' => $post->id];

                                                    ?>
                                                    <a href="{{ lurl(trans('routes.v-post-edit', $attr), $attr) }}" class="d-block f-15 pb-10 mb-10 bb-grey2">{{ t('Edit') }}</a>
                                                @endif
                                                @if ($post->user_id == Auth::User()->id and $post->archived==1)
                                                 <a class="d-block f-15 pb-10 mb-10 bb-grey2" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">{{ t('Repost') }}</a>
                                                @endif
                                                @if ($post->user_id == Auth::User()->id and $post->archived==0)
                                                 <a class="d-block f-15 pb-10 mb-10" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">{{ t('Archive ads') }}</a>
                                                @endif
                                            </div>
                                            <?php /*  
                                            <a href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/delete') }}" class="btn btn-white mini-all trash_white delete-btn" title="{{ t('Delete Job') }}">{{ t('Delete') }}</a>
                                            */?>
                                        </div>
                                    </div>
                                @endif
                                <!-- Hide filter from job applied page -->

                            </div>
                        </div>

            @endforeach
            </div>
        @else
            <div class="bg-white text-center box-shadow position-relative mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                <h5 class="prata">{{ t('No records found') }}</h5>
            </div>
        @endif


        <div class="text-cente pt-40 mb-30 position-relative">
            @include('customPagination')
        </div>
    </div>
    @include('childs.bottom-bar')
@endsection

@section('after_styles')
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
@endsection

@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script>


        $.noConflict();
            jQuery(document).ready(function($) {
            // $(document).ready( function(){
                $('#clear-all').click(function(){
                    $('#postForm2').find(".select-2").val('').trigger('change');
                    $('#postForm2').find(".remove-focus").css({ 'box-shadow':'none' });
                    return true;
                });
                
            });

        $(document).ready( function(){
            $('#checkAll').click( function(){
                checkAll(this);
            });

            $('a.delete-btn, button.delete-btn').click(function(e)
            {   
                
                
                e.preventDefault(); /* prevents the submit or reload */
                var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
                
                if (confirmation) {
                    if( $(this).is('a') ){

                        var url = $(this).attr('href');
                        if (url !== 'undefined') {
                            window.location.href = url;
                        }
                    } else {

                        var is_checked = false;
                        var chkinput = document.getElementsByTagName('input');
                        for (var i = 0; i < chkinput.length; i++) {
                            if (chkinput[i].type == 'checkbox') {
                                if($('#'+chkinput[i].id).prop("checked") == true){
                                   is_checked = true;
                                }
                            }
                        }

                        if(is_checked == false){
                           alert('{{ t("Please select an item from the list") }}');
                           return false; 
                        }
                        
                        $('form[name=listForm]').submit();
                    }
                    
                }
                
                return false;
            });





            $('#load-more').click( function(){

                var flag = $('#offset').val();

                    var company_id = ($('#company_id option:selected').val() == undefined)? '' : $('#company_id option:selected').val();
                    var post_type = ($('#post_type option:selected').val() == undefined)? '' : $('#post_type option:selected').val();
                    var experience_type = ($('#experience_type option:selected').val() == undefined)? '' : $('#experience_type option:selected').val();
                    var gender_type = ($('#userType option:selected').val() == undefined)? '' : $('#userType option:selected').val();
                    var searchtext = ($('#searchtext').val() == undefined)? '' : $('#searchtext').val();


                    var search = {
                        company_id : company_id,
                        post_type : post_type,
                        experience_type : experience_type,
                        gender_type : gender_type,
                        text : searchtext
                    }

                    var url = '<?php echo $fullUrlNoParams.'/ajaxpage'; ?>';

                    var formdata = {
                        'offset': flag,
                        'limit': <?php echo $perPage; ?>,
                        "_token": "{{ csrf_token() }}",
                        "search_status" : true,
                        'search': search
                    };

                    $.ajax({
                        url: url,
                        type: 'post',
                        data: formdata,
                        beforeSend: function(msg){
                            $("#load-more").addClass("btn-success");
                          },
                        success: function(data){
                            if(data.error){
                                $('#more-btn').css('display', 'block');
                            }else{
                                $('#append-posts').append(data);
                                $('#offset').val(parseInt($('#offset').val()) + 6);
                            }
                            $("#load-more").removeClass("btn-success");
                        },
                        error: function(err){
                            console.log(err);
                        }
                    });
            });


             // $('#submit-filter').click( function(e){
             //    e.preventDefault();

             //    var url = window.location.origin + "/account/<?php //echo $type; ?>";

             //    var comapnyid = ($('#company_id option:selected').val() == undefined)? '' : $('#company_id option:selected').val();
             //    var post_type = ($('#post_type option:selected').val() == undefined)? '' : $('#post_type option:selected').val();
             //    var experience_type = ($('#experience_type option:selected').val() == undefined)? '' : $('#experience_type option:selected').val();
             //    var userType = ($('#userType option:selected').val() == undefined)? '' : $('#userType option:selected').val();

             //    var formdata = {
             //        search : true,
             //        _token : "{{ csrf_token() }}",
             //        company_id : comapnyid ,
             //        post_type : post_type,
             //        experience_type : experience_type,
             //        userType : userType,
             //    };


             //    $.ajax({
             //        url: url,
             //        type: 'post',
             //        data: formdata,
             //        dataType: 'json',
             //        beforeSend: function(msg){
             //            $("#load-more").addClass("btn-success");
             //          },
             //        success: function(data){
             //            console.log(data);
             //        },
             //        error: function(err){
             //            console.log(err);
             //        }
             //    });

             // });

        });

        function checkAll(bx) {
            var chkinput = document.querySelectorAll('input.delete-chk');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }

        jQuery.noConflict()(function(jQuery){

            var date = new Date();
            date.setDate(date.getDate());
            var siteUrl =  window.location.origin;

            jQuery( "#start_date" ).datepicker({
                "startDate":date,
                "autoclose": true
            });

            jQuery( "#end_date" ).datepicker({
                "startDate":date,
                "autoclose": true
            });
        });


    </script>
@endsection