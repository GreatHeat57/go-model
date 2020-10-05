        <div class="row justify-content-md-between searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">

                <form method="POST" action="{{ url()->current() }}" accept-charset="UTF-8" id="search-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="search_status" value="true">
                    <input type="hidden" name="search_page" value="{{ $pagePath }}">
                    <div class="input-bar">
                        <div class="input-bar-item width100">
                            <div class="form-group">
                                {{ Form::text('search[text]', null, ['id' => 'searchtext', 'class' => 'width100', 'placeholder' => t('Search'), 'autofocus'=>'autofocus', 'required'=> 'required']) }}
                            </div>
                        </div>
                        <div class="input-bar-item">
                            <input type="button" class="btn btn-white search no-bg" value="" id="mypost-search-submit">
                        </div>
                    </div>
                </form>

                <?php /*
                {{ Form::open(array('url' =>  url()->current(), 'method' => 'post', 'files' => true, 'id' => 'postForm1')) }}
                <input type="hidden" name="search_status" value="true">
                <input type="hidden" name="search_page" value="{{ $pagePath }}">
                {{ Form::text('search[text]', null, ['id' => 'searchtext', 'class' => 'search', 'placeholder' => t('Search'),'autofocus'=>'autofocus']) }}
                {{ Form::submit( t('Search') ) }}
                {{ Form::close() }}
                <?php */ ?>
            </div>
        </div>

        {{ Form::open(array('url' =>  url()->current(), 'method' => 'post', 'files' => true, 'id' => 'postForm2')) }}
        <input type="hidden" name="search_status" value="true">
        <input type="hidden" name="search_page" value="{{ $pagePath }}">

        <div class="row bg-white box-shadow filter-area py-30 px-38 mb-40 mx-0">
            
            <div class="row">
                <div class="col-md-6 input-group remove-focus">
                    <select  name="search[company_id]" id="company_id" class="form-control select-2" >
                        <option value="" selected="selected">{{ t('Select a Company') }}</option>
                        @if (isset($companies) and $companies->count() > 0)
                            @foreach ($companies as $item)
                                <option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}" @if (old('company_id', (isset($formData['company_id']) ? $formData['company_id'] : 0))==$item->id)
                                                                    selected="selected"
                                                                @endif > {{ $item->name }}</option>
                            @endforeach
                            @endif
                    </select>
                </div>

                <div class="col-md-6 input-group remove-focus">
                    <select name="search[post_type]" id="post_type" class="form-control select-2" >
                        <option value="" selected="selected">{{ t('Job Type') }}</option>
                        @foreach ($postTypes as $postType)
                                
                            <option value="{{ $postType->tid }}" @if ( ( isset($formData['post_type']) ?  $formData['post_type'] : 0 ) == $postType->tid) selected="selected" @endif>
                                    {{ $postType->name }}
                                </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 input-group remove-focus">
                    <select  name="search[experience_type]" id="experience_type" class="form-control select-2" >
                        <option value="" selected="selected">{{ t('Required experience') }}</option>
                        @foreach ($experienceTypes as $types)
                            <option value="{{ $types->id }}" @if ( ( isset($formData['experience_type']) ?  $formData['experience_type'] : 0 ) == $types->id) selected="selected" @endif>
                                    {{ t($types->name) }}
                                </option>
                        @endforeach
                    </select>
                </div>

                <?php 

                   $selected_gender = '';
                   $both_selected = '';

                    if(isset($formData['gender_type'])){
                        $selected_gender = $formData['gender_type'];
                    } 
                    if($selected_gender == '0'){
                        $both_selected = 'selected';
                    }
                ?>

                <div class="col-md-6 input-group remove-focus">
                    <select name="search[gender_type]" id="userType" class="form-control select-2" >
                        <option value="" selected="selected">{{ t('Gender') }}</option>
                            @if ($genders->count() > 0)
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->tid }}" 
                                        {{ ( $gender->tid == $selected_gender)? 'selected' : '' }}
                                >{{ t($gender->name) }} </option>
                                    @endforeach
                                @endif
                        <option value="0" {{ $both_selected }}>{{ t("Both") }} </option>
                    </select>
                </div>
            </div>

            <div class="d-lg-flex justify-content-xl-star">
                <button type="submit" id="submit-filter" class="btn btn-success white-search mini-under-desktop mr-20">{{ t('Search') }}</button>

                <a href="javascript:void(0);" id="clear-all" class="bold text-decoration-underline btn-clear mini-under-desktop">{{ t('Clear all') }}</a>
            </div>
        </div>

        <?php /*

        <div class="row bg-white box-shadow filter-area py-30 px-10 mb-40 mx-0">
            <div class="table-responsive">
                <!-- comapny name and post type -->
                <div class="col-md-12 form-group custom-radio pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
                    <div class="d-flex col-md-12 col-xl-12">
                        <div class="col-md-6 col-xs-6 remove-focus">
                            <!-- <span class="title">{{ t('Select a Company') }}</span> -->
                            <select  name="search[company_id]" id="company_id" class="form-control select-2" >
                                <option value="0" selected="selected">{{ t('Select a Company') }}</option>
                                @if (isset($companies) and $companies->count() > 0)
                                @foreach ($companies as $item)
                                    <option value="{{ $item->id }}" data-logo="{{ resize($item->logo, 'small') }}" @if (old('company_id', (isset($formData['company_id']) ? $formData['company_id'] : 0))==$item->id)
                                                                        selected="selected"
                                                                    @endif > {{ $item->name }} </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- <span class="mx-20"> - </span> -->
                        <div class="col-md-6 col-xs-6 remove-focus">
                            <!-- <span class="title"> {{ t('Job Type') }} </span> -->
                            <select name="search[post_type]" id="post_type" class="form-control select-2" >
                                <option value="0" selected="selected">{{ t('Job Type') }}</option>
                                @foreach ($postTypes as $postType)
                                
                                <option value="{{ $postType->tid }}" @if ( ( isset($formData['post_type']) ?  $formData['post_type'] : 0 ) == $postType->tid) selected="selected" @endif>
                                    {{ $postType->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- comapny name and post type -->
                <div class="col-md-12 form-group custom-radio pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
                    <div class="d-flex col-md-12 col-xl-12">
                        <div class="col-md-6 col-xs-6 remove-focus">
                            <!-- <span class="title">{{ t('Required experience') }}</span> -->
                            <select  name="search[experience_type]" id="experience_type" class="form-control select-2" >
                                <option value="0" selected="selected">{{ t('Required experience') }}</option>
                                @foreach ($experienceTypes as $types)
                                <option value="{{ $types->id }}" @if ( ( isset($formData['experience_type']) ?  $formData['experience_type'] : 0 ) == $types->id) selected="selected" @endif>
                                    {{ t($types->name) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <span class="mx-20"> - </span> -->
                        <div class="col-md-6 col-xs-6 remove-focus">
                            <!-- <span class="title"> {{ t('Gender') }} </span> -->
                            
                            <?php 

                               $selected_gender = '';
                               $both_selected = '';

                                if(isset($formData['gender_type'])){
                                    $selected_gender = $formData['gender_type'];
                                } 
                                if($selected_gender == '0'){
                                    $both_selected = 'selected';
                                }
                            ?>

                            <select name="search[gender_type]" id="userType" class="form-control select-2" >
                                <option value="" selected="selected">{{ t('Gender') }}</option>
                                @if ($genders->count() > 0)
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender->tid }}" 
                                        {{ ( $gender->tid == $selected_gender)? 'selected' : '' }}
                                >{{ t($gender->name) }} </option>
                                    @endforeach
                                @endif
                                <option value="0" {{ $both_selected }}>{{ t("Both") }} </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-10 d-lg-flex justify-content-xl-start">
                <button type="submit" id="submit-filter" class="btn btn-success white-search mini-under-desktop mr-20">{{ t('Search') }}</button>
                <a href="javascript:void(0);" id="clear-all" class="bold text-decoration-underline btn-clear mini-under-desktop">{{ t('Clear all') }}</a>
            </div>
        </div>

        <?php */ ?>

        {{ Form::close() }}

@section('after_scripts')
<script>
    $.noConflict();
    jQuery(document).ready(function($) {

        $('#mypost-search-submit').click( function(e){
            e.preventDefault();
            $("#search-form").submit();
        });

        $('#clear-all').click(function(){
            $('#postForm2').find(".select-2").val('').trigger('change');
            $('#postForm2').find(".remove-focus").css({ 'box-shadow':'none' });
            return true;
        });
    });
</script>
@endsection

        