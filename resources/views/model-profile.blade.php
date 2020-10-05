@extends('layouts.app-model')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center f-h2 prata">Model profile</h1>
        <div class="divider mx-auto"></div>
        <p class="text-center f-14 mb-30">Your username, name, bio and links appear on your model profile.</p>
        <div class="text-center mb-30"><a href="#" class="btn btn-default insight mini-mobile">Ansicht</a></div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <div class="pb-40 px-20 px-xl-0 text-center">
                    <div class="prog mb-20">
                        <div class="bar position-relative">
                            <div class="prog-bg position-absolute" style="width: 65%"></div>
                            <span class="number box-shadow position-absolute" style="left: calc(65% - 30px);">65%</span>
                        </div>
                    </div>
                    <p class="f-15 lh-14 dark-grey2 mb-0">Gib einen Wert für "Lebenslauf" ein um dein Profil um 35% zu verbessern!</p>
                </div>
                {{ Form::open() }}
                <div class="pt-40 px-38 px-lg-0">
                    <div class="pb-40 mb-40 bb-light-lavender3 d-md-flex">
                        <div class="profile-photo dm-md-inline-block position-relative mr-md-30 d-flex align-items-center justify-content-center mb-sm-30">
                            <img srcset="{{ URL::to('images/avatars/avatar-photo-upload.png') }},
                                     {{ URL::to('images/avatars/avatar-photo-upload@2x.png') }} 2x,
                                     {{ URL::to('images/avatars/avatar-photo-upload@3x.png') }} 3x"
                                 src="{{ URL::to('images/avatars/avatar-photo-upload.png') }}" alt="Go Models"/>
                            <a href="#" class="btn btn-primary zoom mini-all position-absolute to-top-0 to-right-0"></a>
                            <a href="#" class="btn btn-primary trash mini-all position-absolute to-bottom-0 to-right-0"></a>
                            <span class="btn save position-absolute photo-saved">Photo saved</span>
                        </div>
                        <div class="d-md-inline-block">
                            <a href="#" class="btn btn-white upload_white upload-picture mb-20">Upload picture</a>
                            <p>Maximale Dateigröße ist 1MB, mini-mobilemales Maß: 270x210 und
                                geeignete Dateiarten sind .jpg & .png</p>
                        </div>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Model categories</h2>
                        <div class="divider"></div>
                        <div class="row custom-checkbox">
                            <div class="col-md-6">
                                {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                                {{ Form::label('option_1', 'Option 1', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_2', null, 0, ['class' => 'checkbox_field', 'id' => 'option_2']) }}
                                {{ Form::label('option_2', 'Option 2', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_3', null, 0, ['class' => 'checkbox_field', 'id' => 'option_3']) }}
                                {{ Form::label('option_3', 'Option 3', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_4', null, 0, ['class' => 'checkbox_field', 'id' => 'option_4']) }}
                                {{ Form::label('option_4', 'Option 4', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_5', null, 0, ['class' => 'checkbox_field', 'id' => 'option_5']) }}
                                {{ Form::label('option_5', 'Option 5', ['class' => 'checkbox-label col-md-6 mb-lg-0']) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::checkbox('option_6', null, 0, ['class' => 'checkbox_field', 'id' => 'option_6']) }}
                                {{ Form::label('option_6', 'Option 6', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_7', null, 0, ['class' => 'checkbox_field', 'id' => 'option_7']) }}
                                {{ Form::label('option_7', 'Option 7', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_8', null, 0, ['class' => 'checkbox_field', 'id' => 'option_8']) }}
                                {{ Form::label('option_8', 'Option 8', ['class' => 'checkbox-label col-md-6']) }}
                                {{ Form::checkbox('option_9', null, 0, ['class' => 'checkbox_field', 'id' => 'option_9']) }}
                                {{ Form::label('option_9', 'Option 9', ['class' => 'checkbox-label col-md-6 mb-lg-0']) }}
                            </div>
                        </div>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Profile data</h2>
                        <div class="divider"></div>
                        <div class="input-group">
                            {{ Form::text('username', null,['class' => 'animlabel']) }}
                            {{ Form::label('username', 'Username', ['class' => 'required']) }}
                        </div>
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
                        <div class="row">
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('geburtstag' , 'Geburtstag', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('geburtstag', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('geschlecht' , 'Geschlecht', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('geschlecht', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="custom-textarea">
                            {{ Form::label('introduction', 'Introduction') }}
                            {{ Form::textarea('introduction', null, ['class' => 'pt-40 px-20 pb-20 h-md-130']) }}
                        </div>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Persönliche Informationen</h2>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-6 input-group">
                                {{ Form::label('korpergrosse' , 'Körpergröße (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('korpergrosse', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 input-group">
                                {{ Form::label('brust' , 'Brust (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('brust', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 input-group">
                                {{ Form::label('taille' , 'Taille (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('taille', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 input-group">
                                {{ Form::label('hufte' , 'Hüfte (cm)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('hufte', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('kleidergrosse' , 'Kleidergröße (EU)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('kleidergrosse', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('schuhgrosse' , 'Schuhgröße', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('schuhgrosse', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('gewicht' , 'Gewicht (kg)', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('gewicht', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('augenfarbe' , 'Augenfarbe', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('augenfarbe', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('haarfarbe' , 'Haarfarbe', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('haarfarbe', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('piercing' , 'Piercing', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('piercing', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group mb-20">
                                {{ Form::label('tattoo' , 'Tattoo', ['class' => 'control-label required select-label position-relative']) }}
                                {{ Form::select('tattoo', [0 => 'Wählen Sie...',1,2,3,4,5], null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Skills</h2>
                        <div class="divider"></div>
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
                        <h2 class="bold f-18 lh-18 pl-35">Languages</h2>
                        <div class="divider"></div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <span class="title">English</span>
                                <p class="mb-md-0">Converational: I write and speak this language well</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <span class="title">German</span>
                                <p class="mb-md-0">Native of Bilingual: I write and speak this language perfectly, including colloquialisms</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success add_new">Add new</a>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Erfahrungen im Model Business</h2>
                        <div class="divider"></div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <p>Theater @ Aufführung im Schultheater</p>
                                <p>2006-2012</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success add_new">Add new</a>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Experiences / Referenzen</h2>
                        <div class="divider"></div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <p>Peer mediator</p>
                                <p>2018</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <p>Model</p>
                                <p>2016-2017</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success add_new">Add new</a>
                    </div>
                    <div class="pb-40 mb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Education</h2>
                        <div class="divider"></div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <div class="mb-40 mb-md-0">
                                    <span class="d-md-inline-block">Mast of Arts (M.A.), </span>
                                    <span class="d-md-inline-block">Industrial Design, </span>
                                    <span class="d-md-inline-block">Packaging Design, </span>
                                    <span class="d-md-inline-block">Univesity of West Hungary, </span>
                                    <span class="d-md-inline-block">Institute of Applied Arts</span>
                                </div>
                                <p>2001-2006</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <div class="pb-40 mb-40 bb-pale-grey row">
                            <div class="col-md-9">
                                <p>
                                    Applied Graphic Art
                                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2 mb-1"></span>
                                    Győr School of Art</p>
                                <p>1996-2000</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-md-end">
                                <a href="#" class="btn btn-white edit_grey mr-20 mini-all"></a>
                                <a href="#" class="btn btn-white trash_white mini-all"></a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success add_new">Add new</a>
                    </div>
                    <div class="pb-40 bb-light-lavender3">
                        <h2 class="bold f-18 lh-18 pl-35">Website & Soziale Netzwerke</h2>
                        <div class="divider"></div>
                        {{ Form::text('personal_website', null, ['placeholder' => 'Personal website', 'class' => 'mb-30']) }}
                        {{ Form::text('instagram', null, ['placeholder' => 'Instagram', 'class' => 'mb-30']) }}
                        {{ Form::text('facebook', null, ['placeholder' => 'Facebook', 'class' => 'mb-30']) }}
                        {{ Form::text('linkedin', null, ['placeholder' => 'LinkedIn', 'class' => 'mb-30']) }}
                        {{ Form::text('twitter', null, ['placeholder' => 'Twitter']) }}
                    </div>
                </div>
                @include('children.bottom-bar-save')
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection