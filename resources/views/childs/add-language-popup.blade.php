<div id="">
    <!-- <div class="w-lg-720"> -->
        <span class="bold f-20 lh-28">{{ $pagePath }}</span>
        <div class="divider"></div>
        <?php
        $action = 'add';
        $language_name = '';
        $proficiency_level = '';
        $description = '';

        if (isset($id) && $id !== false) {
        	$action = 'update';
        }
        if (isset($language) && !empty($language)) {
        	$language_name = $language['language_name'];
        	$proficiency_level = $language['proficiency_level'];
        	$description = $language['description'];
        }
        $lang_arr = array();
        foreach ($languages as $language) {
        	//$lang_arr = $lang_arr + array("0" => t('Select Language'), $language->id => t($language->name));
        }
        // 'url' => lurl('account/profile/language'),'id'=>'language_form',
        ?>
        <!-- <div class="col-lg-12"> -->
        <div class="error-msg mb-30 py-2 d-none alert alert-danger"></div>
        <div class="success-msg mb-30 py-2 d-none alert alert-success"></div>
        <!-- </div> -->

        {{ Form::open(array('id'=>'language_form','name'=>'language_form', 'method' => 'post')) }}

            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="action" value="{{ $action }}">
            <div class="form-group mb-20">
                {{ Form::label('language' , t('Language'), ['class' => 'control-label required select-label position-relative']) }}

                {{ Form::select('language', $languages, $language_name, ['class' => 'form-control custom_select language_select']) }}
            </div>
            <div class="form-group mb-10">
                 {{ Form::label('proficiency_level' , t('Proficiency Level'), ['class' => 'control-label required select-label position-relative']) }}
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group custom-radio">
                            <?php /* {{ Form::radio('pradio', 'beginner', $proficiency_level == 'beginner', ['class' => 'radio_field pradio', 'id' => 'pradio_1']) }}
                            {{ Form::label('pradio_1', t('Beginner'), ['class' => 'radio-label']) }}
                            {{ Form::radio('pradio', 'elementary', $proficiency_level == 'elementary', ['class' => 'radio_field pradio', 'id' => 'pradio_2']) }}
                            {{ Form::label('pradio_2', t('Elementary'), ['class' => 'radio-label']) }}
                            {{ Form::radio('pradio', 'intermediate', $proficiency_level == 'intermediate', ['class' => 'radio_field pradio', 'id' => 'pradio_3']) }}
                            {{ Form::label('pradio_3', t('Intermediate'), ['class' => 'radio-label']) }} */ ?>

                            {{ Form::radio('pradio', 'native_language', $proficiency_level == 'native_language', ['class' => 'radio_field pradio', 'id' => 'pradio_1']) }}
                            {{ Form::label('pradio_1', t('Native Language'), ['class' => 'radio-label']) }}

                            {{ Form::radio('pradio', 'perfect', $proficiency_level == 'perfect', ['class' => 'radio_field pradio', 'id' => 'pradio_2']) }}
                            {{ Form::label('pradio_2', t('Perfect'), ['class' => 'radio-label']) }}

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group custom-radio">

                            {{ Form::radio('pradio', 'basic_knowledge', $proficiency_level == 'basic_knowledge', ['class' => 'radio_field pradio', 'id' => 'pradio_3']) }}
                            {{ Form::label('pradio_3', t('Basic Knowledge'), ['class' => 'radio-label']) }}

                            {{ Form::radio('pradio', 'advanced', $proficiency_level == 'advanced', ['class' => 'radio_field pradio', 'id' => 'pradio_4']) }}
                            {{ Form::label('pradio_4', t('Advanced'), ['class' => 'radio-label']) }}

                            <?php /*{{ Form::radio('pradio', 'upper_intermediate', $proficiency_level == 'upper_intermediate', ['class' => 'radio_field pradio', 'id' => 'pradio_4']) }}
                            {{ Form::label('pradio_4', t('Upper Intermediate'), ['class' => 'radio-label']) }}
                            {{ Form::radio('pradio', 'advanced', $proficiency_level == 'advanced', ['class' => 'radio_field pradio', 'id' => 'pradio_5']) }}
                            {{ Form::label('pradio_5', t('Advanced'), ['class' => 'radio-label']) }}
                            {{ Form::radio('pradio', 'proficient', $proficiency_level == 'proficient', ['class' => 'radio_field pradio', 'id' => 'pradio_6']) }}
                            {{ Form::label('pradio_6', t('Proficient'), ['class' => 'radio-label']) }} */ ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-20">

                {{ Form::label(t('Description'), t('Description'), ['class' => 'position-relative control-label input-label']) }}

                {!! Form::textarea('description',$description, ['id'=> 'description1','class' => 'pt-10 px-10 pb-10 h-md-130']) !!}
            </div>
            <div class="d-flex">
                <button name="create" type="button" class="btn btn-success btn-addlanguage save mr-20">{{ t('Save') }}</button>
                <button class="btn btn-white no-bg" data-dismiss="modal">{{ t('Cancel') }}</button>
            </div>
        {{ Form::close() }}
    <!-- </div> -->
</div>
<script type="text/javascript">
    $(document).ready(function (){
        $(".custom_select").select2({
            minimumResultsForSearch: 5,
            width: '100%'
        });
    });
</script>