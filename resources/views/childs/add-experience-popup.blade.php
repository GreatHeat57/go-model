<style type="text/css">
    #experience_from fieldset.birthdayPicker {
        box-shadow: none !important;
    }
    #experience_to fieldset.birthdayPicker {
        box-shadow: none !important;
    }
    .experience_form span.select2.select2-container.select2-container--default {
        width: 100% !important;
        padding-right: 10px !important;
    }

</style>
<div id="add-language-popup" class="add-exp-popup">
    <div class=""> <!-- w-lg-720 -->
        <span class="bold f-20 lh-28">{{ $pagePath }}</span>
        <div class="divider"></div>
        <?php
$action = 'add';
$title = '';
$company = '';
$description = '';
if (isset($id) && $id !== false) {
	$action = 'update';
}

if (isset($experience) && !empty($experience)) {
	$title = $experience['title'];
	$company = $experience['company'];
	$description = $experience['description'];
}
?>
       <!--  <div class="col-lg-12">
            <div class="error-message mb-30 py-2 d-none"></div>
            <div class="success-message mb-30 py-2 d-none"></div>
        </div> -->

        <!-- <div class="col-lg-12"> -->
        <div class="error-msg mb-30 py-2 d-none alert alert-danger"></div>
        <div class="success-msg mb-30 py-2 d-none alert alert-success"></div>
        <!-- </div> -->

        <form name="experience_form" class="form-horizontal experience_form" id="experience_form" role="form" method="POST"  enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="action" value="{{ $action }}">
            <!-- education.title -->
            <div class="input-group">

                {{ Form::label(t('Title'), t('Title'), ['class' => 'position-relative required control-label input-label']) }}

                <input class="{{!empty($title) ?'noanimlabel':'animlabel'}}" id="title" name="title" type="text" value="{{$title}}">
                
            </div>
            <?php /*
            <!-- education.start -->
            <div class="mb-20">
                {{ Form::label(t('From'), t('From'), ['class' => 'position-relative required control-label input-label']) }}
                <div id = "experience_from"></div>
            </div>

            <!-- education.end -->
            <div class="mb-20">
                {{ Form::label(t('To'), t('To'), ['class' => 'position-relative required control-label input-label']) }}
                <div id = "experience_to"></div>
            </div>
            */?>
            <!-- education.start -->
            <div class="row" id="experience_from" data-label="{{ t('From') }}"></div>
            <!-- education.end -->
            <div class="row" id="experience_to" data-label="{{ t('To') }}"></div>
            <div class="input-group custom-checkbox">
                
                <?php
                    $checked = '';
                    if(isset($experience['up_to_date']) && $experience['up_to_date'] == '1'){
                        $checked = 'checked="checked"';
                    }
                ?>
                <input class="checkbox_field" id="up_to_date" name="up_to_date" value="1" type="checkbox" {{ $checked }}>

                <?php /*
                <input type="checkbox"  class="checkbox_field" name="up_to_date" id="up_to_date" value="1" <?php if (isset($experience['up_to_date']) && $experience['up_to_date'] == '1') {  echo 'checked="checked"'; } ?>> 

                */?>

                <label for="up_to_date" id="checked-lbl" class="checkbox-label checked-lbl">{{ t('up to today') }}</label>
            </div>

            <!-- experience.company -->
            <div class="input-group <?php echo (isset($errors) and $errors->has('experience.company')) ? 'has-error' : ''; ?>">

                {{ Form::label(t('Company'), t('Company'), ['class' => 'position-relative required control-label input-label']) }}

                <input name="company" type="text" class="{{!empty($company) ?'noanimlabel':'animlabel'}}" id="company" value="{{ old('company', $company) }}" required>
            </div>

            <!-- experience.description -->
            <div class="input-group  <?php echo (isset($errors) and $errors->has('experience.description')) ? 'has-error' : ''; ?>">
                {{ Form::label(t('Description'), t('Description'), ['class' => 'position-relative required control-label input-label']) }}
                <textarea id="experience_description" name="description" class="pt-10 px-10 pb-10 h-md-130" cols="50" rows="10" required>{!! $description !!}</textarea>
                
            </div>

            <!-- Button -->
            <div class="">
                <div class="d-flex">
                    <button name="create" type="button" class="btn btn-success btn-addExperience save mr-20">{{ t('Submit') }}</button>
                    <button type="button" class="btn btn-white no-bg">{{ t('Cancel') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/module.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/uploader.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/assets/plugins/simditor/scripts/simditor.js') }}"></script>
<script>

    jQuery("#experience_from").birthdayPicker({
        dateFormat: "littleEndian",
        sizeClass: "form-control custom_birthday col-md-3",
    });

    jQuery("#experience_to").birthdayPicker({
        dateFormat: "littleEndian",
        sizeClass: "form-control custom_birthday col-md-3 to_experience_birthdate",
    });

    $(".custom_birthday").select2({
        minimumResultsForSearch: 5,
        width: '100%'
    });

    function set_date_from($date){

        if ($date != '') {
           var DOB = new Date($date);
            $('[name="experience_from_birth[year]"]').val(DOB.getFullYear()).trigger('change');
            $('[name="experience_from_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
            $('[name="experience_from_birth[day]"]').val(DOB.getDate()).trigger('change');
        }
        //else{
         //  var DOB = new Date();
        //}

        $('[name="experience_from_birthDay"]').val(formatDate(DOB));
    }

    function set_date_to($date){
        if ($date != '') {
           var DOB = new Date($date);
            $('[name="experience_to_birth[year]"]').val(DOB.getFullYear()).trigger('change');
            $('[name="experience_to_birth[month]"]').val(DOB.getMonth() + 1).trigger('change');
            $('[name="experience_to_birth[day]"]').val(DOB.getDate()).trigger('change');
        }
        $('[name="experience_to_birthDay"]').val(formatDate(DOB));
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
</script>
<script>

    $(document).ready(function (){

        var up_date = '<?php echo (isset($experience['up_to_date']) && $experience['up_to_date'] == '1')? 1 : 0; ?>';

    
        // if(up_date == 1){

           
        //     // $('#checked-lbl').click();
            
        //     // $('#up_to_date').val('1');


        //     // var DOB = new Date();
        //     // $('[name="experience_to_birthDay"]').val('');
        //     // $('[name="experience_to_birth[day]"]').select2('destroy');
        //     // $('[name="experience_to_birth[day]"]').val('').select2();
        //     // $('[name="experience_to_birth[month]"]').select2('destroy');
        //     // $('[name="experience_to_birth[month]"]').val('').select2();
        //     // $('[name="experience_to_birth[year]"]').select2('destroy');
        //     // $('[name="experience_to_birth[year]"]').val('').select2();

        //     // $('[name="experience_to_birth[year]"]').val('').trigger('change');
        //     // $('[name="experience_to_birth[month]"]').val('').trigger('change');
        //     // $('[name="experience_to_birth[day]"]').val('').trigger('change');
        // }
        // else{
        //     $('#up_to_date').val('');
        // }

         

        //$('#experience_to select').prop('required',false);
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

            if($(this).prop('checked') == true){

                var DOB = new Date();
                $('[name="experience_to_birthDay"]').val('');
                $('[name="experience_to_birth[day]"]').select2('destroy');
                $('[name="experience_to_birth[day]"]').val('').select2();
                $('[name="experience_to_birth[month]"]').select2('destroy');
                $('[name="experience_to_birth[month]"]').val('').select2();
                $('[name="experience_to_birth[year]"]').select2('destroy');
                $('[name="experience_to_birth[year]"]').val('').select2();
                $('#experience_form [name="up_to_date"]').val('1');
            }
        });

        $(document).on('change','.to_experience_birthdate',function(){
            $('#experience_form [name="up_to_date"]').prop('checked', false);
        });
    });

    // $('.save').on('click',function(e){

    //     e.preventDefault();

    //     var is_to_date_valid = false;

    //     if($("#up_to_date").is(':checked')) {
    //         is_to_date_valid = false;

    //         var DOB = new Date();
    //         $('[name="experience_to_birthDay"]').val(formatDate(DOB));

    //         $('#up_to_date').val('1');
    //     }else{
    //         $('#up_to_date').val('0');
    //         if($('[name="experience_to_birth[day]"]').val() == null || $('[name="experience_to_birth[month]"]').val() == null || $('[name="experience_to_birth[year]"]').val() == null){
    //             is_to_date_valid = true;
    //         }
    //     }

    //     if($('#title').val().length == 0){
    //         $('.error-message').removeClass('d-none');
    //         $('.error-message').html('Please enter title');
    //     }
    //     else if($('[name="experience_from_birth[day]"]').val() == null || $('[name="experience_from_birth[month]"]').val() == null || $('[name="experience_from_birth[year]"]').val() == null){
    //         $('.error-message').removeClass('d-none');
    //         $('.error-message').html('Please select from date');
    //     }else if(is_to_date_valid == true ){
    //         $('.error-message').removeClass('d-none');
    //         $('.error-message').html('Please select to date');
    //     }
    //     else if($('#company').val().length == 0){
    //         $('.error-message').removeClass('d-none');
    //         $('.error-message').html('Please enter company');
    //     }
    //     else if($('#experience_description').val().length == 0){
    //         $('.error-message').removeClass('d-none');
    //         $('.error-message').html('Please enter description');
    //     }else{
    //         $('.error-message').addClass('d-none');
    //         $.ajax({
    //             method: "POST",
    //             url: $('.experience_form').attr('action'),
    //             data: new FormData($('.experience_form')[0]),
    //             enctype: 'multipart/form-data',
    //             contentType: false,
    //             processData: false,
    //             success: function (data) {
    //                 window.location.reload();
    //             }, error: function (a, b, c) {
    //                 console.log('error');
    //             }
    //         });
    //     }
    // });
</script>