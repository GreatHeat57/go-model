<style type="text/css">
        #reference_date fieldset.birthdayPicker {
            box-shadow: none !important;
        }
    </style>
<div id="add-language-popup">
    <!-- <div class="w-lg-720"> -->
        <span class="bold f-20 lh-28">{{ $pagePath }}</span>
        <div class="divider"></div>
<?php
// check call edit or create
$action = 'add';
$is_edit = false;
if (isset($id) && $id !== false) {
	$is_edit = true;
	$action = 'update';
}

if (!empty($reference)) {
	$title = $reference['title'];
	$description = $reference['description'];
} else {
	$title = '';
	$description = '';
}
?>
        <?php /*
        @if (Session::has('flash_notification'))
            <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                <div class="row">
                    <div class="col-lg-12">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        @endif

        */?>

         
        <div class="error-msg mb-30 py-2 d-none alert alert-danger"></div>
        <div class="success-msg mb-30 py-2 d-none alert alert-success"></div>
         

        <form name="reference_form" class="form-horizontal reference_form" id="reference_form" role="form" method="POST" action="{{ lurl('account/profile/reference') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <input type="hidden" name="id" value="{{ $id }}">

            <input type="hidden" name="action" value="{{ $action }}">
            <!-- reference.title -->
            <div class="input-group  mb-40<?php echo (isset($errors) and $errors->has('reference.title')) ? 'has-error' : ''; ?>">

                {{ Form::label(t('Title'), t('Title'), ['class' => 'position-relative required control-label input-label']) }}

                <input name="title" type="text" class="{{!empty($title) ? 'noanimlabel':'animlabel'}}" value="{{ old('title',$title) }}" id="title" required>
            </div>
            <?php /*
            <!-- reference.date -->
            <div class="mb-40">
                {{ Form::label(t('Date'), t('Date'), ['class' => 'position-relative required control-label input-label']) }}
                <div id = "reference_date"></div>
            </div>
            */ ?>
            <!-- reference.date -->
            <div class="row" id="reference_date" data-label="{{ t('Date') }}"></div>

            <!-- reference.description -->
            <div class="input-group mb-40 <?php echo (isset($errors) and $errors->has('reference.description')) ? 'has-error' : ''; ?>">

                {{ Form::label(t('Description'), t('Description'), ['class' => 'position-relative required control-label input-label']) }}

                <textarea id="reference_description" name="description" class="pt-10 px-10 pb-10 h-md-130" cols="50" rows="10" required >{{ old('description',$description) }}</textarea>
            </div>

            <!-- Button -->
            <div class="">
                <div class="d-flex">
                    <button name="create" type="button" class="btn btn-success save mr-20 btn-addReference">{{ t('Submit') }}</button>
                    <button type="button" class="btn btn-white no-bg featherlight-close">{{ t('Cancel') }}</button>
                </div>
            </div>

        </form>
    <!-- </div> -->
</div>

<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>

<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>

<script>
    $(document).ready(function (){
    jQuery("#reference_date").birthdayPicker({
        dateFormat: "littleEndian",
        sizeClass: "form-control custom_birthday col-md-3 required",
    });

    $(".custom_birthday").select2({
        minimumResultsForSearch: 5,
        width: '100%'
    });

    function set_date($date){

        if ($date != '') {
            var DOB = new Date($date);
            $("select.birthYear").val(DOB.getFullYear()).trigger('change');
            $("select.birthMonth").val(DOB.getMonth() + 1).trigger('change');
            $("select.birthDate").val(DOB.getDate()).trigger('change');
        }else{
           var DOB = new Date();
        }

        // $('[name="reference_date[year]"]').val(DOB.getFullYear());
        // $('[name="reference_date[month]"]').val(DOB.getMonth() + 1);
        // $('[name="reference_date[day]"]').val(DOB.getDate());
        // $('[name="reference_date"]').val(formatDate());
        $('[name="reference_date"]').val(formatDate());
    }

    function formatDate() {
        var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    }

    set_date('<?php if (!empty($selected_date)) {echo $selected_date;}?>');
});

</script>
