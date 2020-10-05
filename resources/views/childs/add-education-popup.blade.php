<!-- <style type="text/css">
    #education_from fieldset.birthdayPicker {
        box-shadow: none !important;
    }
    #education_to fieldset.birthdayPicker {
        box-shadow: none !important;
    }
    .education_form span.select2.select2-container.select2-container--default {
        width: 33% !important;
        padding-right: 10px !important;
    }
</style> -->
<div id="add-language-popup">
    <!-- <div class="w-lg-720"> -->
        <span class="bold f-20 lh-28">{{ $pagePath }}</span>
        <div class="divider"></div>
<?php

use Jenssegers\Date\Date;
$action = 'add';
$is_edit = false;
$title = '';
$institute = '';
$description = '';
if (isset($id) && $id !== false) {
	$is_edit = true;
	$action = 'update';
}
if (isset($education) && !empty($education)) {
	$title = $education['title'];
	$institute = $education['institute'];
	$description = $education['description'];
}
?>
        <!-- <div class="col-lg-12"> -->
        <div class="error-msg mb-30 py-2 d-none alert alert-danger"></div>
        <div class="success-msg mb-30 py-2 d-none alert alert-success"></div>
        <!-- </div> -->

        <form name="education_form" id="education_form" class="education_form form-horizontal" role="form" method="POST" action="{{ lurl('account/profile/education') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="action" value="{{ $action }}">
            <!-- education.title -->
            <div class="input-group">

                {{ Form::label(t('Title'), t('Title'), ['class' => 'position-relative required control-label input-label']) }}

                <input class="{{!empty($title)? 'noanimlabel':'animlabel'}}" id="title" name="title" type="text" value="{{$title}}">
            </div>

            <?php /*
            <!-- education.start -->
            <div class="mb-40">
                {{ Form::label(t('From'), t('From'), ['class' => 'position-relative required control-label input-label']) }}

                <!-- <div id="education_from"></div> -->
            </div>

            <!-- education.end -->
            <div class="mb-40">

                {{ Form::label(t('To'), {{t('To')}}, ['class' => 'position-relative required control-label input-label']) }}

                <div id="education_to"></div>
            </div>
            <?php */ ?>

            <div class="row" id="education_from" data-label="{{ t('From') }}"></div>
            <div class="row" id="education_to" data-label="{{ t('To') }}"></div>

            <div class="input-group custom-checkbox">

                <?php
                    $checked = '';
                    if(isset($education['up_to_date']) && $education['up_to_date'] == '1'){
                        $checked = 'checked="checked"';
                    }
                ?>

                <input type="checkbox"  class="checkbox_field" name="up_to_date" id="up_to_date" value="1" {{ $checked }} >
                
                <?php /*
                <input type="checkbox"  class="checkbox_field" name="up_to_date" id="up_to_date" value="1" <?php if (isset($education['up_to_date']) && $education['up_to_date'] == 1) { echo 'checked="checked"'; } ?> >

                 */ ?>

                <label for="up_to_date" class="checkbox-label checked-lbl">{{ t('up to today') }}</label>
            </div>

            <!-- education.institute -->
            <div class="input-group <?php echo (isset($errors) and $errors->has('education.institute')) ? 'has-error' : ''; ?>">

                {{ Form::label(t('Institute'), t('Institute'), ['class' => 'position-relative required control-label input-label']) }}

                <input name="institute" id="institute" type="text" class="{{!empty($institute)? 'noanimlabel':'animlabel'}}" value="{{$institute}}">
            </div>

            <!-- education.description -->
            <div class="input-group <?php echo (isset($errors) and $errors->has('education.description')) ? 'has-error' : ''; ?>">

                {{ Form::label(t('Description'), t('Description'), ['class' => 'position-relative required control-label input-label']) }}

                <textarea id="education_description" name="description" class="pt-10 px-10 pb-10 h-md-130" cols="50" rows="10" required placeholder="{{ t('Description') }}">{{$description}}</textarea>

            </div>

            <!-- Button -->
            <div class="">
                <div class="d-flex">
                    <button name="create" type="button" class="btn btn-success save mr-20 btn-addEducation">{{ t('Submit') }}</button>
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
    $(document).ready(function(){

        jQuery("#education_from").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday col-md-3",
        });

        jQuery("#education_to").birthdayPicker({
            dateFormat: "littleEndian",
            sizeClass: "form-control custom_birthday to_education_birthdate col-md-3",
        });

        $(".custom_birthday").select2({
            minimumResultsForSearch: 5,
            width: '100%'
        });
    });
</script>
<script type="text/javascript">

    
    
    // if(up_date == 1){
    //     $('.checked-lbl').addClass('custom-checked');
    // }

    function set_date_from($date_from){

        if ($date_from != '') {
            var DOB = new Date($date_from);
            $('[name="education_from_birth[year]"]').val(DOB.getFullYear()).trigger('change');
            $('[name="education_from_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
            $('[name="education_from_birth[day]"]').val(DOB.getDate()).trigger('change');
        }
        //else{
        //    var DOB = new Date();
        //}

        $('[name="education_from_birthDay"]').val(formatDate(DOB));
    }

    function set_date_to($date_to){
        if ($date_to != '') {
            var DOB = new Date($date_to);
            $('[name="education_to_birth[year]"]').val(DOB.getFullYear()).trigger('change');
            $('[name="education_to_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
            $('[name="education_to_birth[day]"]').val(DOB.getDate()).trigger('change');
        }
        // else{
        //    var DOB = new Date();
        // }
        $('[name="education_to_birthDay"]').val(formatDate(DOB));
    }

    function formatDate(d) {

        // var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    }
    $(document).ready(function (){

        var up_date = '<?php echo (isset($education['up_to_date']) && $education['up_to_date'] == '1')? 1 : 0; ?>';


        var from_date = '<?php if (!empty($selected_from_date)) {echo $selected_from_date;}?>';
        var to_date = '<?php if (!empty($selected_to_date)) {echo $selected_to_date;}?>';
        if(from_date !=''){
            set_date_from('<?php if (!empty($selected_from_date)) {echo $selected_from_date;}?>');
        }
        if(to_date != ''){
            if(up_date != 1){
                set_date_to('<?php if (!empty($selected_to_date)) {echo $selected_to_date;}?>');
            }
        }

        $('#up_to_date').on('change',function(e){
            // $('.checked-lbl').removeClass('custom-checked');
            e.stopPropagation();
            if($(this).prop('checked') == true){
                var DOB = new Date();
                $('[name="education_to_birthDay"]').val('');
                $('[name="education_to_birth[day]"]').select2('destroy');
                $('[name="education_to_birth[day]"]').val('').select2();
                $('[name="education_to_birth[month]"]').select2('destroy');
                $('[name="education_to_birth[month]"]').val('').select2();
                $('[name="education_to_birth[year]"]').select2('destroy');
                $('[name="education_to_birth[year]"]').val('').select2();
                $('#education_form #up_to_date').val('1');
            }
        });

        $(document).on('change','.to_education_birthdate',function(){
            $('#education_form #up_to_date').prop('checked',false);
        });
    });
</script>
