@extends('layouts.logged_in.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        @include('model.my-job-profile-top')

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 unreaded w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span class="d-xl-inline-block rounded-circle bg-green card-appointment-number bold mr-10">1</span>
                    <span class="bold">Yesterday, 10:02</span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 unreaded w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                        src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span class="d-xl-inline-block rounded-circle bg-green card-appointment-number bold mr-10">22</span>
                    <span class="bold">Yesterday, 10:02</span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                        src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span>W, 10:02</span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                        src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span>Th, 10:02</span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                        src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span>M, 10:02</span>
                </div>
            </div>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('my-job-message-texts') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                        src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/></a>
                </div>
            </div>
            <div>
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <a href="{{ route('my-job-message-texts') }}"><span class="title">Jobname</span></a>
                <div class="modelcard-top">
                    <span class="d-inline-block">Partner</span>
                    <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                    <span class="d-inline-block">Name of contact person</span>
                </div>
                <div class="divider"></div>
                <p>Message text lorem ipsum dolor et sit amet</p>
                <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                    <span>T, 10:02</span>
                </div>
            </div>
        </div>
    </div>
    @include('childs.bottom-bar')
@endsection