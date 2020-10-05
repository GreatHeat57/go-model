@extends('layouts.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">Messages</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white search mini-under-desktop">Search</a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-md-auto">
                <form name="listForm" method="POST" action="{{ lurl('account/'.$pagePath.'/delete') }}">
                                {!! csrf_field() !!}
                <!-- {{ Form::open() }} -->
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => 'Search project or ID...','id'=> 'filter']) }}
                <!-- {{ Form::submit('Keresés') }}
                {{ Form::close() }} -->

                </form>
            </div>
        </div>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs',[1 => 'Ongoing', 2 => 'Archive'],null) }}
            <ul class="d-none d-md-block">
                <li><a href="#" class="active" data-id="1">Ongoing</a></li>
                <li><a href="#" data-id="2">Archive</a></li>
            </ul>
        </div>

        <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20 unreaded w-lg-750 w-xl-1220">
            <div class="mr-md-40 mb-lg-30 mb-xl-0">
                <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
                    <a href="{{ route('model-message-details') }}"><img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
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
                <a href="{{ route('model-message-details') }}"><span class="title">Jobname</span></a>
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
    @include('children.bottom-bar')
@endsection