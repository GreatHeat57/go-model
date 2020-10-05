<div class="modal fade" id="invitation-state" role="dialog" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>
            <div class="container pt-20  px-0">
                <h2 class="text-center prata px-38">{{ t('Invited for Job') }}</h2>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>
                <div class="bg-white ">
                    <div class="px-38">
                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                        <div class="alert alert-success print-success-msg" style="display:none"></div>
                    </div>
                </div>

                <div class="bg-white report-form-div">
                   
                    <input type="hidden" name="invitationid" value="{{ isset($invitation->id)? $invitation->id : ''}}" id="invitation-id">

                    <div class="text-center mb-20">
                        <a href="#" class="btn btn-success mr-20 register position-relative invit-accept">{{ t('Accept') }}</a>
                        <button type="submit" class="btn btn-white delete report-submit invit-reject">{{ t('Reject') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


	           
@section('after_styles')
    @parent
    <link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url(config('app.cloud_url') . '/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
    @endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
    </style>
@endsection

@section('after_scripts')
    @parent
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