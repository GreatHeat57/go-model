 <?php /*
<!-- <div class="modal fade" id="termPartner" tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
<div class="modal-dialog  modal-sm">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">
<span aria-hidden="true">&times;</span>
<span class="sr-only">{{ t('Close') }}</span>
</button>
@if (empty($page_termsclient->picture))
<h1 class="text-center title-1" style="color: {!! $page_termsclient->name_color !!};"><strong>{{ $page_termsclient->name }}</strong></h1>
<hr class="center-block small text-hr" style="background-color: {!! $page_termsclient->name_color !!};">
@endif
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12 page-content">
@if (empty($page_termsclient->picture))
<h3 style="text-align: center; color: {!! $page_termsclient->title_color !!};">{{ $page_termsclient->title }}</h3>
@endif
<div class="text-content text-left from-wysiwyg">
{!! $page_termsclient->content !!}
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">{{ t('OK') }}</button>
</div>
</div>
</div>
</div>
-->
 */?><?php /*
<div class="white-popup-block mfp-hide" id="mfp-partner-terms">
<button title="%title%" type="button" class="mfp-close" id="partner-terms-close">&#215;</button>
<div class="modal-dialog  modal-sm">
<div class="modal-content">
<div class="modal-header">
<!-- <button type="button" class="close" data-dismiss="modal">
<span aria-hidden="true">&times;</span>
<span class="sr-only">{{ t('Close') }}</span>
</button> -->
@if (empty($page_termsclient->picture))
<h1 class="text-center title-1" style="color: {!! $page_termsclient->name_color !!};"><strong>{{ $page_termsclient->name }}</strong></h1>
<hr class="center-block small text-hr" style="background-color: {!! $page_termsclient->name_color !!};">
@endif
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12 page-content">
@if (empty($page_termsclient->picture))
<h3 style="text-align: center; color: {!! $page_termsclient->title_color !!};">{{ $page_termsclient->title }}</h3>
@endif
<div class="text-content text-left from-wysiwyg">
{!! $page_termsclient->content !!}
</div>
</div>
</div>
</div>
<!-- <div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">{{ t('OK') }}</button>
</div> -->
</div>
</div>
</div>
 */
$pageTitle = t('Terms of Use for Clients'). ' ('.strtoupper(config('country.code')).')';
?>

<div class="white-popup-block term-condition-popup-ajax" id="mfp-partner-terms">
    <div class="content static_page_content margin-10">
        <div class="" wfd-id="40">
            <div class="inner" wfd-id="42">
                <h2 class="smaller" style="text-align: center; color: ">{{ $pageTitle }}</h2>
                {!! $page_termsclient !!}
                <div class="text-center pt-20"><a href="javascript:void(0)" class="btn btn-white delete close-popup-button" style="text-decoration: none !important;">{{ t('Close') }}</a></div>
            </div>
        </div>
    </div>
</div>

 
<?php /*
<div class="white-popup-block mfp-hide" id="mfp-partner-terms">
	 <!-- <a title="Back" type="button" class="btn btn-success btn-back">{{t('Back')}}</a> -->

    @if (empty($page_termsclient->picture))
    	<!-- <h2 class="smaller" style="color: {!! $page_termsclient->name_color !!};">{{ $page_termsclient->name }}</h2> -->
    @endif

    <div class="content static_page_content margin-10">
	    <!-- <div class="block bd-b mg-b" wfd-id="40"> -->
        <div class="" wfd-id="40">
            <div class="inner" wfd-id="42">
            	@if (empty($page_termsclient->picture))
            		<!-- <h2 class="smaller" style="text-align: center; color: {!! $page_termsclient->title_color !!};">{{ $page_termsclient->title }}</h2> -->
            	@endif
                @if (!empty($page_termsclient) && !empty($page_termsclient->title)) 
                    <h2 class="smaller" style="text-align: center; color: @if (!empty($page_termsclient) && !empty($page_termsclient->title_color)) {!! $page_termsclient->title_color !!}; @endif">{{ $page_termsclient->title }}</h2>

                    {!! $page_termsclient->content !!} 
                @endif
               
            </div>
            <button class="mobile-popup-btn" title="Go to top">x</button>
	    </div>
  	</div>
</div>

<?php */ ?>

<style type="text/css">
    .mobile-popup-btn {display: none; position: fixed; top: 50px; left: 3%; z-index: 99; border: none; outline: none;background-color: #233553; color: white; cursor: pointer; font-size: 18px; cursor: pointer !important; padding-top: 8px; padding-right: 11px; padding-bottom: 8px; padding-left: 11px; }

    .mobile-popup-btn:hover { background-color: #233553; }
    .margin-10 { margin-top: 10px !important; }

    @media only screen and (max-width: 600px) {
        .mobile-popup-btn {display: block !important; }
    }
    #mfp-partner-terms a {
        text-decoration: underline !important;
    }
    .read {
      overflow: auto;
      height: 600px;
      border: 1px solid #000;
    }
    @media only screen and (max-width: 576px) {
      .read {
        height: 400px;
      }
    }

    table {
     margin: auto;
      border-collapse: collapse;
      /*overflow-x: auto;
      display: block;
      width: fit-content;*/
      max-width: 100%;
      box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1);
    }

    td, th {
      border: solid rgb(200, 200, 200) 1px;
      padding: .5rem;
    }

    th {
      text-align: center;
      /*background-color: rgb(190, 220, 250);*/
      text-transform: uppercase;
      padding-top: 1rem;
      padding-bottom: 1rem;
      border-bottom: rgb(50, 50, 100) solid 2px;
      border-top: none;
    }

    td {
      white-space: wrap;
      border-bottom: none;
      color: rgb(20, 20, 20);
    }

    td:first-of-type, th:first-of-type {
      border-left: none;
    }

    td:last-of-type, th:last-of-type {
      border-right: none;
    }
    .table tr{
      border-left: 1px solid #dee2e6;
      border-right: 1px solid #dee2e6;
      border-bottom: 1px solid #dee2e6;
    }
    @media screen and (max-width: 600px) {
        td {
          white-space: nowrap;
        }
        table {
            overflow-x: auto;
            display: block;
            width: fit-content;
        }
        th {
         text-align: left;
        }
    }
</style>

 

