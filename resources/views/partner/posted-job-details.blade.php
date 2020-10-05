@extends('layouts.app-partner')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        @include('partner.posted-job-profile-top')
        <div class="box-shadow bg-white py-60 px-38 px-lg-0 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                <span class="title">Hauptinformationen</span>
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
                    <span class="title">Details</span>
                    <div class="divider"></div>
                    <p class="mb-40">Wir suchen ein Model für unsere Firmen Startseite!</p>
                </div>
                <span class="title">Looking for</span>
                <div class="divider"></div>
                <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
                    <div class="col-md-6">
                        <p><span class="bold d-inline-block mr-1">Kategorie:</span><span class="d-inline-block">Models (15-50 Jahre)</span></p>
                        <p><span class="bold d-inline-block mr-1">Bezahlung:</span><span class="d-inline-block">0-100 EUR</span></p>
                        <p><span class="bold d-inline-block">Erforderliche Erfahrung:</span><span class="d-inline-block">Bereits Erfahrunk</span></p>
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
                    <span class="title">Requred skills</span>
                    <div class="divider"></div>
                    <a href="#"><span class="tag mr-2 mb-2">Dance</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Hostess</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Verlässlichkeit</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Humorvoll</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Models</span></a>
                    <a href="#"><span class="tag mr-2 mb-2">Anpassungsfähigkeit</span></a>
                </div>
                <div>
                    <span class="title">Posted by</span>
                    <div class="divider"></div>
                    <div class="border">
                        <div class="img-holder mini d-flex align-items-center justify-content-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="/images/img-logo.png" alt="Go Models"/>
                        </div>
                        <div class="row mx-0 pt-60 px-20 pb-30 position-relative">
                            <img srcset="{{ URL::to('images/icons/ico-company-sample.png') }},
                                 {{ URL::to('images/icons/ico-company-sample@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-company-sample@3x.png') }} 3x"
                                 src="/images/img-logo.png" alt="Go Models" class="rounded-circle posted_by-img border"/>
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
    </div>
    @include('children.bottom-bar')
@endsection