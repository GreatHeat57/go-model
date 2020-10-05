@extends('layouts.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">Notifications</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white search mini-under-desktop">Search</a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-md-auto">
                {{ Form::open() }}
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => 'Search project or ID...']) }}
                {{ Form::submit('Keresés') }}
                {{ Form::close() }}
            </div>
        </div>

        <div class="custom-tabs mb-20 mb-xl-30">
            <?
            $options = [
                1 => 'Applications',
                2 => 'Invites',
                3 => 'Rejected'
            ]
            ?>
            {{ Form::select('tabs',[0 => 'All']+$options,null) }}
            <ul class="d-none d-md-flex justify-content-center">
                <li><a href="#" class="active" data-id="0">All</a></li>
                <li><a href="#" data-id="1" class="position-relative">Applications<span class="msg-num tab applied">3</span></a></li>
                <li><a href="#" data-id="2" class="position-relative">Invited<span class="msg-num tab invited">3</span></a></li>
                <li><a href="#" data-id="3" class="position-relative">Rejected<span class="msg-num tab rejected">15</span></a></li>
            </ul>
        </div>
        <div class="row mx-0 justify-content-md-center">
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification unreaded">
                <span class="flag to-left-30 to-top-0 applied"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification unreaded">
                <span class="flag to-left-30 to-top-0 invited"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification">
                <span class="flag to-left-30 to-top-0 rejected"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification">
                <span class="flag to-left-30 to-top-0 ongoing"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification unreaded">
                <span class="flag to-left-30 to-top-0 closed"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
            <div class="bg-white box-shadow position-relative d-md-flex justify-content-md-between pt-xs-40 pb-xs-40 py-md-20 pr-20 pl-30 mb-20 notification">
                <span class="flag to-left-30 to-top-0 draft"></span>
                <div class="col-md-6 pt-40 pb-20 pb-md-0 px-0 bordered">
                    <span class="title">Action to job</span>
                    <span>Job name</span>
                    <div class="divider"></div>
                    <span class="posted mb-md-0">Date</span>
                </div>
                <div class="col-md-6 px-0 pt-40 pl-md-4">
                    <span class="dark-grey2 posted mb-10">From</span>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"
                                 class="from-img full-width"/>
                        </div>
                        <span class="title">Partner</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('children.bottom-bar')
@endsection