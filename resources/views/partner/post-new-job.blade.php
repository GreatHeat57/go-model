@extends('layouts.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ t('Post a new job') }}</h1>
        <div class="divider mx-auto"></div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            {{ Form::open() }}
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="w-lg-750 pt-40 px-38 px-lg-0">
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">Post job for</h2>
                        <div class="divider"></div>
                        <div class="form-group custom-radio">
                            <div class="mb-20">
                                {{ Form::radio('post_job_for', null, 1, ['class' => 'radio_field', 'id' => 'mannlich']) }}
                                <label class="radio-label mb-0 h-auto post_job_for gb-active" for="mannlich">
                                    <span class="bold">Model</span>
                                    <p class="mb-0">Vivamus sit amet orci purus. Fusce sodales ex non eros aliquam ultrices. Phasellus vel sapien libero. Proin purus ante, tristique sed pharetra nullam.</p>
                                </label>
                            </div>
                            <div class="mb-20">
                                {{ Form::radio('post_job_for', null, 0, ['class' => 'radio_field', 'id' => 'job_service_project']) }}
                                <label class="radio-label mb-0 h-auto post_job_for" for="job_service_project">
                                    <span class="bold">Job service project</span>
                                    <p class="mb-0">Vivamus sit amet orci purus. Fusce sodales ex non eros aliquam ultrices. Phasellus vel sapien libero. Proin purus ante, tristique sed pharetra nullam.</p>
                                </label>
                            </div>
                            <div class="mb-20">
                                {{ Form::radio('post_job_for', null, 0, ['class' => 'radio_field', 'id' => 'partner']) }}
                                <label class="radio-label mb-0 h-auto post_job_for" for="partner">
                                    <span class="bold">Partner</span>
                                    <p class="mb-0">Vivamus sit amet orci purus. Fusce sodales ex non eros aliquam ultrices. Phasellus vel sapien libero. Proin purus ante, tristique sed pharetra nullam.</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">Job details</h2>
                        <div class="divider"></div>
                        <div class="input-group">
                            {{ Form::text('username', null,['class' => 'animlabel']) }}
                            {{ Form::label('username', 'Username', ['class' => 'required']) }}
                        </div>
                        <div class="custom-textarea input-group">
                            {{ Form::label('introduction', 'Introduction') }}
                            {{ Form::textarea('introduction', null, ['class' => 'pt-40 px-20 pb-20 h-md-130']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::text('username', null,['class' => 'animlabel']) }}
                            {{ Form::label('username', 'Username', ['class' => 'required']) }}
                        </div>
                        <div class="mb-30">
                            <div class="form-group mb-20">
                                {{ Form::label('geburtstag' , 'Geburtstag', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('geburtstag', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('geschlecht' , 'Geschlecht', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('geschlecht', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <a href="#" class="btn btn-white add_locale">Add Locale</a>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">Model details</h2>
                        <div class="divider"></div>
                        <span class="bold mb-30">Model Categories</span>
                        <div class="row">
                            <div class="col-md-6 input-group">
                                {{ Form::label('korpergrosse' , 'Körpergröße (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('korpergrosse', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 input-group">
                                {{ Form::label('brust' , 'Brust (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('brust', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 input-group mb-0">
                                {{ Form::label('taille' , 'Taille (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('taille', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <a href="#" class="btn btn-success add_new h-40 mini-all"></a>
                        </div>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <span class="bold mb-30">Bezahlung</span>
                        <div class="input-group mb-0">
                            {{ Form::text('bezahlung', null,['class' => 'animlabel']) }}
                            {{ Form::label('bezahlung', 'EUR / hr', ['class' => 'required']) }}
                        </div>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <span class="bold mb-30">Erfordliche Erfahrung</span>
                        <div class="d-md-flex form-group custom-checkbox">
                            <div class="mb-20 mb-md-0 mr-20">
                                {{ Form::checkbox('anfanger', null, 1, ['class' => 'checkbox_field', 'id' => 'anfanger']) }}
                                {{ Form::label('anfanger', 'Anfänger', ['class' => 'checkbox-label mb-0']) }}
                            </div>
                            <div class="mb-20 mb-md-0 mr-md-20">
                                {{ Form::checkbox('bereits_erfahrung', null, 1, ['class' => 'checkbox_field', 'id' => 'bereits_erfahrung']) }}
                                {{ Form::label('bereits_erfahrung', 'bereits Erfahrung', ['class' => 'checkbox-label mb-0']) }}
                            </div>
                            <div>
                                {{ Form::checkbox('profi', null, 1, ['class' => 'checkbox_field', 'id' => 'profi']) }}
                                {{ Form::label('profi', 'Profi', ['class' => 'checkbox-label mb-0']) }}
                            </div>
                        </div>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <span class="bold mb-30">Geschlecht</span>
                        <div class="d-md-flex form-group custom-radio">
                            <div class="mb-20 mb-md-0 mr-20">
                                {{ Form::radio('geschlecht', null, 1, ['class' => 'radio_field', 'id' => 'mannlich']) }}
                                {{ Form::label('mannlich', 'männlich', ['class' => 'radio-label mb-0']) }}
                            </div>
                            <div class="mb-20 mb-md-0 mr-md-20">
                                {{ Form::radio('geschlecht', null, 1, ['class' => 'radio_field', 'id' => 'weiblich']) }}
                                {{ Form::label('weiblich', 'weiblich', ['class' => 'radio-label mb-0']) }}
                            </div>
                            <div>
                                {{ Form::radio('geschlecht', null, 1, ['class' => 'radio_field', 'id' => 'beides']) }}
                                {{ Form::label('beides', 'beides', ['class' => 'radio-label mb-0']) }}
                            </div>
                        </div>
                    </div>

                    <div class="pb-40 bb-light-lavender3">
                        <span class="bold mb-30">More settings</span>
                        <div class="row mb-30">
                            <span class="bold col-md-3 col-xl-2">Distance</span>
                            <div class="d-flex col-md-6 col-xl-4">
                                {{ Form::text('from-km', null, ['placeholder' => 'from (km)']) }}
                                <span class="mx-20"> - </span>
                                {{ Form::text('to-km', null, ['placeholder' => 'to (km)']) }}
                            </div>
                        </div>
                        <div class="row mb-30">
                            <span class="bold col-md-3 col-xl-2">Model height</span>
                            <div class="d-flex col-md-6 col-xl-4">
                                {{ Form::text('from-cm', null, ['placeholder' => 'from (cm)']) }}
                                <span class="mx-20"> - </span>
                                {{ Form::text('to-cm', null, ['placeholder' => 'to (cm)']) }}
                            </div>
                        </div>
                        <div class="row mb-30">
                            <span class="bold col-md-3 col-xl-2">Age</span>
                            <div class="d-flex col-md-6 col-xl-4">
                                {{ Form::text('from-yrs', null, ['placeholder' => 'from (yrs.)']) }}
                                <span class="mx-20"> - </span>
                                {{ Form::text('to-yrs', null, ['placeholder' => 'to (yrs.)']) }}
                            </div>
                        </div>
                        <div class="row mb-30">
                            <span class="bold col-md-3 col-xl-2">Dress size</span>
                            <div class="d-flex col-md-6 col-xl-4">
                                {{ Form::text('from-eu', null, ['placeholder' => 'from (EU)']) }}
                                <span class="mx-20"> - </span>
                                {{ Form::text('to-eu', null, ['placeholder' => 'to (EU)']) }}
                            </div>
                        </div>
                    </div>

                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <span class="bold mb-30">Skills</span>
                        <div class="d-flex justify-content-between mb-20">
                            {{ Form::text('search_for_skill', null, ['placeholder' => 'Search for skill', 'class' => 'mr-20']) }}
                            <a href="#" class="btn btn-success add_new mini-all h-40"></a>
                        </div>
                        <div>
                            <a href="#" class="tag extended">Dance</a>
                            <a href="#" class="tag extended">Hostess</a>
                            <a href="#" class="tag extended">Verlässlichkeit</a>
                        </div>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <span class="bold mb-30">TFP</span>
                        <div class="form-group custom-checkbox">
                            {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                            {{ Form::label('option_1', 'I take TFP jobs', ['class' => 'checkbox-label mb-0']) }}
                        </div>
                    </div>

                    <div class="pb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18">Locale</h2>
                        <div class="divider"></div>
                        <div class="input-group">
                            {{ Form::text('country', null,['class' => 'animlabel']) }}
                            {{ Form::label('country', 'Country', ['class' => 'required']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::text('county', null,['class' => 'animlabel']) }}
                            {{ Form::label('county', 'County', ['class' => 'required']) }}
                        </div>
                        <div class="input-group">
                            {{ Form::text('city', null,['class' => 'animlabel']) }}
                            {{ Form::label('city', 'City, town', ['class' => 'required']) }}
                        </div>
                        <div class="input-group mb-0">
                            {{ Form::text('street', null,['class' => 'animlabel']) }}
                            {{ Form::label('street', 'Street, Square...', ['class' => 'required']) }}
                        </div>
                    </div>
                    <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10743.8640937907!2d16.5904287!3d47.685079800000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1shu!2shu!4v1540469343574" width="100%" height="346" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                @include('children.bottom-bar-save')
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('body').on('click', '.post_job_for', function () {
            $('.post_job_for').removeClass('gb-active');
            if(!$(this).is(':checked'))
                $(this).addClass('gb-active');
        });
    </script>
@endpush