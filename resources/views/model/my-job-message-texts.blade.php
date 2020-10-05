@extends('layouts.logged_in.app-model')

@section('content')
    <div class="container pt-40 px-0">
        <a href="{{ route('my-job-messages') }}"><span class="text-center mb-20">My job messages /</span></a>
        <h1 class="f-h1 prata text-center mb-0">Für Sportliche Werbekampagne</h1>
        <div class="divider mx-auto"></div>
        <div class="w-xl-1220 mx-xl-auto">
            <div class="bg-white box-shadow mb-40">
                <div class="d-flex justify-content-md-between align-items-center py-sm-20 px-38 bb-md-down-grey2">
                    <div class="d-flex align-items-center">
                        <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-60">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/>
                        </div>
                        <p class="w-112 mb-0">
                            <span class="bold">Wabi Beauty</span>
                            <span>Linz, Austria</span>
                        </p>
                    </div>
                    <div class="d-none d-md-block justify-content-end py-10">
                        <a href="#" class="btn btn-white post_white mini-all mr-20"></a>
                        <a href="#" class="btn btn-white insight mini-all"></a>
                    </div>
                </div>
                <div class="d-flex d-md-none justify-content-center py-10">
                    <a href="#" class="btn btn-white post_white mini-all mr-20"></a>
                    <a href="#" class="btn btn-white insight mini-all"></a>
                </div>
            </div>
            <div class="text-center mb-40"><a href="#" class="btn btn-default refresh">More messages</a></div>

            <div class="date-divider text-center">
                <span>03.09.2018</span>
            </div>
            <div class="msg-texts py-40">
                <div class="d-flex justify-content-start mb-20">
                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-27 img-md-49">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/>
                    </div>
                    <div class="bg-white box-shadow border py-20 px-20 w-75p">
                        <p class="mb-10">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-20">
                    <div class="bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-218">
                        <p class="mb-10">O.K.</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-20">
                    <div class="bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p">
                        <p class="mb-10">Ut enim ad minim veniam? Excepteur sint occaecat cupidatat non proident?</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-20">
                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-27 img-md-49">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/>
                    </div>
                    <div class="bg-white box-shadow border py-20 px-20 w-75p">
                        <p class="mb-10">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start mb-20">
                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-27 img-md-49">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/>
                    </div>
                    <div class="bg-white box-shadow border py-20 px-20 w-75p">
                        <p class="mb-10">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla...</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
            </div>
            <div class="date-divider text-center">
                <span>Today</span>
            </div>
            <div class="msg-texts py-40">
                <div class="d-flex justify-content-start mb-20">
                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex justify-content-center align-items-center img-27 img-md-49">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" class="from-img nopic full-width"/>
                    </div>
                    <div class="bg-white box-shadow border py-20 px-20 w-75p">
                        <p class="mb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-20">
                    <div class="bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p">
                        <p class="mb-10">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia lorem ipsum dolor et?</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-20">
                    <div class="bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p">
                        <p class="mb-10">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <div class="text-right dark-grey2 f-14 lh-15">Mo, 8:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('childs.model-bottom-bar-write-message')
@endsection