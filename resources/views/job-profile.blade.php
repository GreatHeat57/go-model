@extends('layouts.logged_in.app-model')

@section('content')
    <div class="container px-0 py-40">
        <a href="{{ route('find-work') }}"><span class="text-center mb-20">Find work /</span></a>
        <h1 class="f-h1 prata text-center mb-0">Athletic Male Models Wanted Experience Not Essential</h1>
        <div class="divider mx-auto"></div>
        <div class="box-shadow bg-white py-60 px-38 px-lg-0 mb-40 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <span class="title f-20">Hauptinformationen</span>
                <div class="divider"></div>
                <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
                    <div class="col-md-6">
                        <p><span class="bold d-inline-block mr-1">Jobart:</span><span class="d-inline-block">Innenaufnahmen</span></p>
                        <p><span class="bold d-inline-block mr-1">Locale:</span><span class="d-inline-block">Linz, Austria</span></p>
                        <p class="mb-0"><span class="bold d-inline-block mr-1">Job ID number:</span><span class="d-inline-block">2158864535</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><span class="bold d-inline-block mr-1">Date:</span><span class="d-inline-block">18.08.2018</span></p>
                        <p><span class="bold d-inline-block mr-1">Bewerbung(en):</span><span class="d-inline-block">3</span></p>
                    </div>
                </div>
                <div class="bb-light-lavender3 mb-40">
                    <span class="title f-20">Details</span>
                    <div class="divider"></div>
                    <p class="mb-40">Wir suchen ein Model für unsere Firmen Startseite!</p>
                </div>
                <span class="title f-20">Looking for</span>
                <div class="divider"></div>
                <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
                    <div class="col-md-6">
                        <p><span class="bold d-inline-block mr-1">Kategorie:</span><span class="d-inline-block">Models (15-50 Jahre)</span></p>
                        <p><span class="bold d-inline-block mr-1">Bezahlung:</span><span class="d-inline-block">0-100 EUR</span></p>
                        <p><span class="bold d-inline-block">Erforderliche Erfahrung:</span><span class="d-inline-block">Bereits Erfahrung</span></p>
                        <p><span class="bold d-inline-block mr-1">Geschlecht:</span><span class="d-inline-block">Geschlecht</span></p>
                        <p><span class="bold d-inline-block mr-1">TFP-Shooting:</span><span class="d-inline-block">Nein</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><span class="bold d-inline-block mr-1">Körpergröße:</span><span class="d-inline-block">163 - 195 cm</span></p>
                        <p><span class="bold d-inline-block mr-1">Alter:</span><span class="d-inline-block">18 - 39 Jahre</span></p>
                        <p><span class="bold d-inline-block mr-1">Kleidergröße:</span><span class="d-inline-block">32 - 38 EU</span></p>
                        <p class="mb-0"><span class="bold d-inline-block mr-1">Language:</span><span class="d-inline-block">German</span></p>
                    </div>
                </div>
                <div class="bb-light-lavender3 mb-40 pb-40">
                    <span class="title f-20">Required skills</span>
                    <div class="divider"></div>
                    <a href="#"><span class="tag mr-2 mb-2">Dance</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Hostess</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Verlässlichkeit</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Humorvoll</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Models</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Anpassungsfähigkeit</span></a>
                </div>
                <div>
                    <span class="title f-20">Posted by</span>
                    <div class="divider"></div>
                    <div class="border">
                        <div class="img-holder mini d-flex align-items-center justify-content-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="/images/img-logo.png" alt="{{ trans('metaTags.Go-Models') }}"/>
                        </div>
                        <div class="row mx-0 pt-60 px-20 pb-30 position-relative">
                            <img srcset="{{ URL::to('images/icons/ico-company-sample.png') }},
                                 {{ URL::to('images/icons/ico-company-sample@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-company-sample@3x.png') }} 3x"
                                 src="/images/img-logo.png" alt="{{ trans('metaTags.Go-Models') }}" class="rounded-circle posted_by-img border"/>
                            <div class="col-md-5 col-xl-3 mb-30">
                                <span class="title">Wabi Beauty</span>
                                <span>Linz, Austria</span>
                                <span class="f-12">54 jobs posted, 6 open jobs</span>
                                <span class="f-12">Member since Oct 26, 2015</span>
                            </div>
                            <div class="col-md-7 col-xl-9">
                                <span class="title mb-10">About</span>
                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-shadow bg-white py-60 px-38 w-xl-1220 mx-xl-auto">
            <div class="w-md-468 w-lg-596 w-xl-720 mx-auto">
                <span class="title f-20" id="bewerbung">Bewerbung</span>
                <div class="divider"></div>
                <span class="mb-10">Message</span>
                {{ Form::textarea('message', null, ['placeholder' => 'If you want to leave a message type it here', 'class' => 'p-20 mb-30']) }}
                <span class="mb-10">Question 1 (Do you have tattoos, where?)</span>
                {{ Form::textarea('message', null, ['placeholder' => 'Answer to question 1', 'class' => 'p-20 mb-30']) }}
                <span class="mb-10">Question 2 (Requested a picture)</span>
                <div class="upload-zone py-30 px-38">
                    <div class="text-center">
                        <button href="#" class="btn btn-white mini-mobile upload_white">Upload picture</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('childs.bottom-bar-action')
@endsection