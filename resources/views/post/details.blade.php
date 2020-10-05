@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
{!! csrf_field() !!}
<input type="hidden" id="post_id" value="{{ $post->id }}">

<?php
// Phone
// $phone = TextToImage::make($post->phone, IMAGETYPE_PNG, ['backgroundColor' => 'rgba(0,0,0,0.0)', 'color' => '#FFFFFF']);
// $phoneLink = 'tel:' . $post->phone;
// $phoneLinkAttr = '';
// if (!auth()->check()) {
//  if (config('settings.single.guests_can_apply_jobs') != '1') {
//      $phone = t('Click to see');
//      $phoneLink = '#quickLogin';
//      $phoneLinkAttr = 'data-toggle="modal"';
//  }
// }

// Contact Recruiter URL
$applyJobURL = '#applyJob';
$applyLinkAttr = 'data-toggle="modal"';

if (!empty($post->application_url)) {
	$applyJobURL = $post->application_url;
	$applyLinkAttr = '';
}

if (!auth()->check()) {
	if (config('settings.single.guests_can_apply_jobs') != '1') {
		$applyJobURL = '#quickLogin';
		$applyLinkAttr = 'data-toggle="modal"';
	}
}
?>
    <?php if ($is_advertising) {?>
        @include('layouts.inc.advertising.top')
    <?php }?>

    <div class="container pt-40 pb-60 px-0">
        @include('partner.posted-job-profile-top')
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>

        <div class="box-shadow bg-white py-60 px-38 px-lg-0 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                @include('post.job_detail_section')
                <!-- Tags -->
                @if (!empty($post->tags))
                    <?php $tags = explode(',', $post->tags);?>
                    @if (!empty($tags))
                        <div class="bb-light-lavender3 mb-40 pb-40">
                            <span class="title">{{ t('Tags') }}</span>
                            <div class="divider"></div>
                            @foreach($tags as $iTag)
                            <?php $attr = ['countryCode' => config('country.icode'), 'tag' => $iTag]; ?>
                                <span class="tag mr-2 mb-2">{{ $iTag }}</span>
                                <?php /*
                                <a href="{{ lurl(trans('routes.v-search-tag', $attr), $attr) }}"><span class="tag mr-2 mb-2">{{ $iTag }}</span></a>
                                <?php */ ?>
                            @endforeach
                        </div>
                    @endif
                @endif

                <!-- <div class="bb-light-lavender3 mb-40 pb-40">
                    <span class="title">Requred skills</span>
                    <div class="divider"></div>
                    <a href="#"><span class="tag mr-2 mb-2">Dance</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Hostess</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Verlässlichkeit</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Humorvoll</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Models</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Anpassungsfähigkeit</span></a>
                </div> -->


                <?php /*  <div class="mb-40">
                    <span class="title">{{t('Posted by')}}</span>
                    <div class="divider"></div>
                    <div class="border">
                        <div class="img-holder mini d-flex align-items-center justify-content-center">

                            @if($post->user->profile->cover !== NULL && file_exists(public_path('uploads').'/'.$post->user->profile->cover))
                                <img src="{{ \Storage::url($post->user->profile->cover) }}" alt="Go Models"/>
                            @else
                                <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="/images/img-logo.png" alt="Go Models"/>
                            @endif

                        </div>
                        <div class="row mx-0 pt-60 px-20 pb-30 position-relative">

                            @if($post->user->profile->logo !== NULL && file_exists(public_path('uploads').'/'.$post->user->profile->logo))
                                <img src="{{ \Storage::url($post->user->profile->logo) }}" class="rounded-circle posted_by-img border" alt="user">&nbsp;
                            @else
                                <img class="rounded-circle posted_by-img border" src="{{ url('images/user.jpg') }}" alt="user">
                            @endif

                            --commented<div class="col-md-12 col-xl-12 mb-30">
                                <span class="title">{{ $post->user->name}}</span>
                                <span>{{ $userCountry }}</span>
                                <span class="f-12">{{ count($post->user->posts) }} {{ t('jobs posted') }}</span> -->
                                <!-- <span class="f-12">Member since Oct 26, 2015</span> -->
                                <!-- <span class="f-12">{{ t('Member since') }} {{ date("M d, Y", strtotime($post->user->created_at)) }}</span>
                            </div>--commented
                            <div class="col-md-12 col-xl-12">
                                <span class="title mb-10">{{ t('Description') }}</span>
                                <p class="mb-0" style="text-align: justify;"><?php echo transformDescription(stripslashes($post->user->profile->description)) ?></p>
                            </div>
                        </div>
                    </div>
                </div> */?>

                <?php /* @if (isset($post->company) and !empty($post->company))

                <div class="mb-40">
                    <span class="title">{{ t('Company Information') }}</span>
                    <div class="divider"></div>
                    <div class="border">
                        @if (config('settings.single.show_post_on_googlemap'))
                        <div class="align-items-center">
                            <div class="ads-googlemaps">
                                <iframe id="googleMaps" width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                            </div>
                        </div>
                        @endif
                        <div class="row mx-0 pt-30 px-20 pb-30 position-relative">
                            <div class="col-md-12 col-xl-12 mb-30">
                                <span class="title">{{ $post->company->name}}</span>

                                <?php //$attr = ['countryCode' => config('country.icode'), 'city' => slugify($post->city->name), 'id' => $post->city->id];?>

                                <span><a href="{!! lurl(trans('routes.v-search-city', $attr), $attr) !!}">{{ $post->city->name }}</a></span>
                                
                                @if ($post->user and !empty($post->user->created_at_ta))
                                <span class="f-12">{{ t('Joined') }} {{ $post->user->created_at_ta }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 col-xl-12">
                                <span class="title mb-10">{{ t('Description') }}</span>
                                <p class="mb-0" style="text-align: justify;"><?php //echo stripslashes(strip_tags($post->company->description)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                @endif */?>
                <?php /*
                @if (isVerifiedPost($post))
                <div class="pb-20 pt-40 bb-light-lavender3">
                    <h2 class="bold f-18 lh-18">{{ t('Share on Social Networks') }}</h2>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex  mb-30">
                                <!-- <div class="sharethis-inline-share-buttons"></div> -->
                                <?php
                                    $share_job_url = lurl(trans('routes.v-share-post', [
                                            'slug' => slugify($post->title),
                                            'id'   => $post->id,
                                        ]));
                                ?>

                                <a href="http://www.facebook.com/sharer.php?u={{ $share_job_url }}" target="_blank" class="facebook-share-link">
                                   <div class="social-big facebook rounded-circle mr-20 share s_facebook" title="Facebook"></div>
                                </a>
                                <a href="https://twitter.com/share?url={{ $share_job_url }}/&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank" class="twitter-share-link">
                                    <div class="social-big twitter rounded-circle mr-20 share s_twitter" title="Twitter"></div>
                                </a>
                                <!-- <a href="https://plus.google.com/share?url={{-- url($post->uri) --}}" target="_blank">
                                   <div class="social-big wix rounded-circle mr-20 share s_plus" title="google"></div>
                                </a> -->

                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ $share_job_url }}" target="_blank" class="linkedIn-share-link">
                                  <div class="social-big linkedin rounded-circle mr-20 share s_linkedin" title="Linkedin"></div>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                */ ?>

                <?php /* 
                @if (auth()->user()->id != $post->user_id)
                    <div class="pb-20 pt-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">{{ t('Tips for candidates') }}</h2>
                        <div class="divider"></div>
                        <div class="row mx-0 position-relative">
                            <div class="col-md-12">
                                <div class="d-flex ">
                                    <ul class="list-check">
                                        <li> {{ t('Check if the offer matches your profile') }} </li>
                                        <li> {{ t('Check the start date') }} </li>
                                        <li> {{ t('Meet the employer in a professional location') }} </li>
                                    </ul>
                                    <?php $tipsLinkAttributes = getUrlPageByType('tips');?>
                                    @if (!\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href="#"') and !\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href=""'))
                                    <p>
                                        <a class="btn btn-white edit_grey" {!! $tipsLinkAttributes !!} >{{ t('Know more') }}</a>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                */ ?>

                <div class="text-center mb-30 pt-30 position-relative">

                    @if (auth()->check())
                        @if (auth()->user()->id == $post->user_id)
                            @if($is_deleted == false)
                                <?php // $attrId['id'] = $post->id;  ?>

                                <?php 
                                    $attr = ['countryCode' => config('country.icode'), 'id' => $post->id];
                                ?> 
                                <a class="btn btn-white edit_grey mini-mobile mb-20" href="{{ lurl(trans('routes.v-post-edit', $attr), $attr) }}">{{ t('Edit') }}</a>
                            @endif
                        @else

                            <?php
                                if(!empty($post->email)){ ?>
                                    @if($is_invited > 0)

                                        @if($invitation->invitation_status)
                                            <label class="btn mb-20 btn-white label-color accepted-invt pointer-disable applied" title="" >{{ t('Invitation accepted') }}</label>
                                        @else
                                            <?php /* <a  data-toggle="modal" href="#invitation-state" class="btn post_white mb-20 btn-white invited-job" title="{{ t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]) }}">{{ t('Invited for Job') }}</a> */ ?>

                                            <?php $titleinvted = t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]);?>
                                            {!! App\Helpers\CommonHelper::createLink('invited_jobs', t('Invited for Job'), '#invitation-state', 'btn post_white mb-20 btn-white invited-job', '', $titleinvted, 'data-toggle="modal"' ) !!}

                                        @endif

                                    @elseif($is_applyed > 0)
                                        <label class="btn mb-20 btn-white label-color applied pointer-disable">{{ t('Applied') }}</label>
                                    @else

                                        @if($is_expired || $application_is_closed)
                                            
                                            <?php $title= ($is_expired)? t('Expired') : t('application is closed'); ?>

                                            {!! App\Helpers\CommonHelper::createLink('apply_jobs', t('Apply Online'), '#', 'btn btn-white edit_grey mb-20 is_expired', '', $title, $applyLinkAttr ) !!}

                                        @else
                                            {{-- <a class="btn btn-white edit_grey mb-20 apply-online" {!! $applyLinkAttr !!} href="{{ $applyJobURL }}">{{ t('Apply Online') }}</a> --}}
                                            {!! App\Helpers\CommonHelper::createLink('apply_jobs', t('Apply Online'), $applyJobURL, 'btn btn-white edit_grey mb-20 apply-online', '','', $applyLinkAttr ) !!}
                                        @endif
                                    @endif
                                    <?php
                                }
                            ?>
                        @endif
                    @else
                        @if ($post->email != '')
                            @if($is_invited > 0)

                                @if($invitation->invitation_status)
                                    <label class="btn mb-20 btn-white label-color applied accepted-invt pointer-disable" title="">{{ t('Invitation accepted') }}</label>
                                @else
                                    <?php /* <a data-toggle="modal" href="#invitation-state" class="btn post_white mb-20 btn-white invited-job" title="{{ t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]) }}">{{ t('Invited for Job') }}</a> */ ?>

                                    <?php $titleinvted = t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]);?>
                                    {!! App\Helpers\CommonHelper::createLink('invited_jobs', t('Invited for Job'), '#invitation-state', 'btn post_white mb-20 btn-white invited-job', '', $titleinvted, 'data-toggle="modal"' ) !!}

                                @endif
                            @elseif($is_applyed > 0)
                                <label class="btn mb-20 btn-white label-color applied pointer-disable" >{{ t('Applied') }}</label>
                            @else
                                @if($is_expired || $application_is_closed)
                                    {{-- <a class="btn btn-white edit_grey mb-20 is_expired" href="#" title="{{ ($is_expired)? t('Expired') : t('application is closed') }}">{{ t('Apply Online') }}</a> --}}

                                    <?php $title= ($is_expired)? t('Expired') : t('application is closed'); $applyLinkAttr = 'title="$title"'; ?>
                                    {!! App\Helpers\CommonHelper::createLink('apply_jobs', t('Apply Online'), '#', 'btn btn-white edit_grey mb-20 is_expired', '', '', $applyLinkAttr ) !!}
                                @else
                                    {{-- <a class="btn btn-white edit_grey mb-20 apply-online" {!! $applyLinkAttr !!} >{{ t('Apply Online') }}</a> --}}
                                    {!! App\Helpers\CommonHelper::createLink('apply_jobs', t('Apply Online'), '#', 'btn btn-white edit_grey mb-20 apply-online', '','', $applyLinkAttr ) !!}
                                @endif
                            @endif
                        @endif
                    @endif

                    <!-- Defalut hidden button to replace applied label -->
                    <label class="btn mb-20 btn-white label-color applied pointer-disable-hiden" style="display: none" >{{ t('Applied') }}</label>

                    {{-- <a class="btn btn-white edit_grey mb-20 apply-online"  data-toggle="modal" href="#applyJob" style="display: none">{{ t('Apply Online') }}</a> --}}
                     {!! App\Helpers\CommonHelper::createLink('apply_jobs', t('Apply Online'), '#applyJob', 'btn btn-white edit_grey mb-20 apply-online', '', '', 'data-toggle="modal" style="display: none"' ) !!}

                    <label class="btn mb-20 btn-white label-color accepted-invt pointer-disable applied" style="display: none;" title="">{{ t('Invitation accepted') }}</label>

                    <?php /* <a data-toggle="modal" href="#invitation-state" class="btn post_white mb-20 btn-white invited-job" style="display: none" title="{{ t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]) }}">{{ t('Invited for Job') }}</a> */ ?>

                    <?php $titleinvted = t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]);?>
                    {!! App\Helpers\CommonHelper::createLink('invited_jobs', t('Invited for Job'), '#invitation-state', 'btn post_white mb-20 btn-white invited-job', '', $titleinvted, 'data-toggle="modal" style="display: none" ' ) !!}
                    
                    @if (auth()->check())
                        @if ($is_save_Post > 0)
                           <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini active mb-20">{{ t('Saved Job') }}</a>
                        @else
                            @if (auth()->user()->id != $post->user_id)
                                <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini mb-20">{{ t('Save Job') }} </a>
                            @endif
                        @endif
                    @else
                        @if (auth()->user()->id != $post->user_id)
                            <a href="javascript:void(0);" id="{{ $post->id }}" class="make-favorite btn btn-white favorite mini mb-20">{{ t('Saved Job') }} </a>
                        @endif
                    @endif

                    @if(auth()->user()->id != $post->user_id)
                        <a class="btn btn-white draft mb-20" data-toggle="modal" href="#reportAbuse"  >{{ t('Report abuse') }}</a>
                    @endif

                    @if (auth()->check())
                        @if (auth()->user()->id !== $post->user_id)
                            @if(isset($message_url) && $message_url != "")
                                <div class="mb-40 details-desc" >
                                    <a href='{{ $message_url }}' class="link-message mb-40">{{ t('click here') }}
                                    </a>
                                    <span class="d-inline-block mr-1">{{ t('to send a Message') }}</span>
                                </div>
                            @endif
                        @endif
                    @endif
                    <div class="mb-40 details-desc conversation-div" style="display: none;">
                        <a href='{{ $message_url }}' class="link-message mb-40" id="conversation-link">{{ t('click here') }}
                        </a>
                        <span class="d-inline-block mr-1">{{ t('to send a Message') }}</span>

                    </div>

                    @if($is_invited > 0)
                        @if(!$invitation->invitation_status)
                            <div class="mb-40 details-desc" id="invt-label">
                                <span>{{ t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]) }}</span>
                            </div>
                        @endif
                    @else
                        <div class="mb-40 details-desc" id="invt-label" style="display: none;">
                            <span>{{ t('Click :here to accept or reject the inviation', ['here' => t('Invited for Job')]) }}</span>
                        </div>
                    @endif

                    
                </div>


               <?php /*<!-- @include('home.inc.featured', ['firstSection' => false]) --> */ ?>
            </div>
        </div>
        
    </div>

    @include('childs.bottom-bar')
    @include('post.inc.invitation-state')
    @include('post.inc.compose-message')
    @include('post.report')
    
@endsection
@section('page-script')
<style type="text/css">
        .details-desc p { text-align: justify; }
        .pointer-disable  { pointer-events: none; }
        .pointer-disable-hiden { pointer-events: none; }
        .label-color { /*color: #06c67b !important;*/ }
        .link-message { /*color: #06c67b !important;*/ text-decoration: underline !important;}
        .btn.applied {
            background-image: url(/images/icons/ico-feedback.png);
            background-image: -webkit-image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-feedback.png) 1x, url(/images/icons/ico-feedback@2x.png) 2x, url(/images/icons/ico-feedback@3x.png) 3x);
        }
        .is_expired { box-shadow:none; -webkit-box-shadow: none;}
        .is_expired:hover { -webkit-box-shadow:none !important; box-shadow: none !important; }
        .is_expired:focus { -webkit-box-shadow:none !important; box-shadow: none !important; }
        .is_expired:active { -webkit-box-shadow:none !important; box-shadow: none !important; }
    </style>

   <script>
        /*
        var loadCVFile = function(event) {
            console.log(event);
            if(event.target.files && event.target.files != undefined && event.target.files != ""){
                $('#image_name_0').html(event.target.files[0].name);
            }
        };

        var loadCVFile1 = function(event) {
            
            if(event.target.files && event.target.files != undefined && event.target.files != ""){
                $('#image_name_1').html(event.target.files[0].name);
            }
        };
        */
        $(document).ready(function(){
            jQuery.noConflict()(function($){
                //disable is_expired class button action
                $('.is_expired').attr('disabled', 'disabled');
                 $('.is_expired').attr('href', '');
                $('.is_expired').css('cursor', 'not-allowed');
                $('.is_expired').on('click', function(){
                    return false;
                });

                $('.make-favorite').on('click',function(){

                    var id = $(this).attr('id');
                    var attr = $(this);
                    var siteUrl =  window.location.origin;

                    $.ajax({
                        method: "POST",
                        url: siteUrl + "/ajax/save/post",
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        data: {
                            postId: id,
                            _token: $("input[name=_token]").val()
                        }
                    }).done(function(e) {
                        if(attr.hasClass( "active" )){
                            $(".make-favorite").text("{{ t('Save Job') }}");
                            attr.removeClass('active');
                        }else{
                            attr.addClass('active');
                            $(".make-favorite").text("{{ t('Saved Job') }}");
                        }
                    });
                });

                // var int = 0;
                // $('#add_line').click( function(){
                //     $('#image-warning').html("");
                //     $('#image-warning').hide();
                //     if (int < 2) {
                //         var html = "<div class='input-group'><div class='upload-btn-wrapper'><a href='#' class='btn btn-white upload_white upload-picture '>{{ t('select photo') }}</a><input type='file' id='partnerprofileLogo"+int+"' name='special[filename"+int+"]' onchange='loadLogoFile(event, "+int+")' /><span id='image_name_"+int+"'></span><label id='error-profile-logo-"+int+"' class=''></label></div></div>";

                //         $('#append-image').append(html);

                //     } else {
                //         $('#image-warning').html("{{ 'You can upload maximum 2 images' }}");
                //         $('#image-warning').show();
                        
                //         // setTimeout(function(){
                //         //     $('#image-warning').html("");
                //         //     $('#image-warning').hide();
                //         // }, 3000);
                //     }
                //     int++;
                // });

                
                $('#form_apply').submit( function(e){
                    e.preventDefault();

                    var formData = new FormData($(this)[0]);
                    // remove error of image limit
                    // $('#image-warning').html("").hide();
                    $.ajax({
                        url: $('#form_apply').attr('action'),
                        type: 'POST',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success: function (response) {

                            if( response != undefined && response.success == false ){
                                $(".print-success-msg").html('').hide();
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

                                // setTimeout(function(){
                                //     $(".print-error-msg").css('display','none');
                                // }, 10000);
                            } else {
                           
                                if( response.message != undefined && response.message !== ""){
                                    $(".print-success-msg").html(response.message);
                                    $(".print-success-msg").css('display','block');
                                    $("div").removeClass('invalid-input');
                                    $(".print-error-msg").html('').css('display','none');
                                    $('.apply-online').hide();

                                    if( response.url != "" && response.url != undefined && response.url != null ){
                                        $('#conversation-link').attr('href', response.url);
                                        $('.conversation-div').show();
                                    }
                                }

                                if(response.invitation_id != "" && response.invitation_id != undefined && response.invitation_id != null){
                                    $('.invited-job').show();
                                    $('#invt-label').show();
                                    $('#invitation-id').val(response.invitation_id);
                                }else{
                                     $('.pointer-disable-hiden').show();
                                }
                            }
                        }
                    });

                });

                $('.invit-accept').click( function(e){
                    e.preventDefault();

                    var inviationid = $('#invitation-id').val();
                    inviationstate(inviationid, 'accepted');
                });

                $('.invit-reject').click( function(e){
                    e.preventDefault();
                    var inviationid = $('#invitation-id').val();
                    inviationstate(inviationid, 'rejected');
                });

                // accept or reject the inviation function
                function inviationstate(inviationid, status){
                    
                    var invt_status = 1;
                    
                    if(status === 'rejected' ){
                        invt_status = 0;
                    }

                    $.ajax({
                        method: "get",
                        url: siteUrl + "/account/invtresp/"+invt_status+"/"+inviationid,
                        beforeSend: function(){
                            $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        }
                    }).done(function(response) {

                        $(".print-error-msg").html('');
                        $(".print-success-msg").html('');
                        $(".print-success-msg").css('display','none');
                        $(".print-error-msg").css('display','none');

                        if(response.status == true){

                            $(".print-success-msg").css('display','block');
                            $(".print-success-msg").append('<p>'+response.msg+'</p>');

                            // if inviation is accepted
                            if(response.invitation_status != undefined && response.invitation_status == "1"){
                                // If inviation is rejected then show job applied button
                                if(response.invitation_status === '1'){
                                    $('.invited-job').hide();
                                    $('#invt-label').hide();
                                    $('.accepted-invt').show();
                                }

                                if( response.url != "" && response.url != undefined && response.url != null ){
                                    $('#conversation-link').attr('href', response.url);
                                    $('.conversation-div').show();
                                }
                            }

                            // if inviation is rejected
                            if(response.invitation_status != undefined && response.invitation_status == "2"){
                                // If inviation is rejected then show job applied button
                                if(response.invitation_status === '2'){
                                    $('.invited-job').hide();
                                    $('#invt-label').hide();
                                    $('.apply-online').show();
                                }
                            }

                            setTimeout(function(){
                                $(".print-error-msg").html('');
                                $(".print-success-msg").html('');
                                $('#invitation-state').modal('hide');
                            }, 5000);
                             
                        } else {
                            $(".print-error-msg").css('display','block');
                            
                            if (typeof response.msg == "string") {
                                $(".print-error-msg").append('<p>'+response.msg+'</p>');

                            } else {
                                $.each( response.msg, function( key, value ) {
                                    $('#'+key).addClass('invalid-input');
                                    $(".print-error-msg").append('<p>'+value[0]+'</p>');
                                });
                            }

                            setTimeout(function(){
                                $(".print-error-msg").html('');
                                $(".print-success-msg").html('');
                                $('#invitation-state').modal('hide');
                            }, 5000);
                           
                        }
                    });
                }

                $('#invitation-state').on('hidden.bs.modal', function () {
                    clearMessage();
                });

                $('#applyJob').on('hide.bs.modal', function () {
                    $('#form_apply')[0].reset();
                    // $('#form_apply').find("#phone_code").val({{(auth()->check()) ? auth()->user()->phone_code : ''}}).trigger('change');
                    $(".form-input-applyJob").find('.invalid-input').removeClass('invalid-input');
                    // removed added file upload element on click of add new image and set default html
                    int=0;
                    // $('#append-image .input-group').val('');
                    clearMessage();
                });

                //  model close event
                $('#reportAbuse').on('hide.bs.modal', function () {
                    $('#reportAbuse-form')[0].reset();
                    $('#reportAbuse-form').find("#report_type").val('').trigger('change');
                    $(".form-input-report").find('.invalid-input').removeClass('invalid-input');
                    $(".print-error-msg-report").html('');
                    $(".print-error-msg-report").css('display','none');
                    $(".print-success-msg-report").html('');
                    $(".print-success-msg-report").css('display','none');
                });

                

            });
        });
        // clear all the messages after model is closed
            function clearMessage(){

                $(".print-error-msg").html('');
                $(".print-error-msg").css('display','none');
                $(".print-success-msg").html('');
                $(".print-success-msg").css('display','none');
             }
        var loadLogoFile = function(event, i) {

            var imageSize = "{{ (int)config('settings.upload.max_file_size', 1000) }}";
            var fileSize = Math.round((event.target.files[0].size / 1024));
            var filename = event.target.files[0].name;

            $('#image_name_'+i).html(filename);
            if(fileSize > imageSize){
                $('#error-profile-logo-'+i).html('{{ t("File") }} "'+filename+'" ('+fileSize+' KB) {{ t("exceeds maximum allowed upload size of")}} '+imageSize+' KB.').css("color", "red");
                return false;
            }else{
                $('#error-profile-logo-'+i).html('');
            }

            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output-partner-logo-'+i);
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>


    @if (config('services.googlemaps.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script>
    @endif

    <script>
        $(document).ready(function () {
            $('.facebook-share-link').click(function(e) {
                e.preventDefault();
                window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
                return false;
            });

            $('.twitter-share-link, .linkedIn-share-link').click(function(e) {
                e.preventDefault();
                window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ',');
                return false;
            });
            jQuery.noConflict()(function($){
                $(".phone-code-search").select2({
                    minimumResultsForSearch: 5,
                    width: '100%',
                    dropdownParent: $("#applyJob"),
                    templateResult: formatState,
                    templateSelection: formatState
                });
            });
            @if (config('settings.single.show_post_on_googlemap'))
                /* Google Maps */
                getGoogleMaps(
                '{{ config('services.googlemaps.key') }}',
                '{{ (isset($post->city) and !empty($post->city)) ? addslashes($post->lon) . ',' . addslashes($post->lat) : config('country.name') }}',
                '{{ config('app.locale') }}'
                );
            @endif
        });

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
        }

        function getGoogleMaps(t, e, i) {
            if (void 0 === e) var n = encodeURIComponent($("#address").text());
            else var n = encodeURIComponent(e);
            if (void 0 === i) var i = "en";
            var s = "https://www.google.com/maps/embed/v1/place?key=" + t + "&q=" + n + "&language=" + i + '&zoom=9';
            $("#googleMaps").attr("src", s)
        }

    </script>
@endsection

