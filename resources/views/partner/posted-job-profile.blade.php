@extends('layouts.app-partner')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        @include('partner.posted-job-profile-top')
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members invite position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members signed position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite active mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members applied position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members invited position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite active mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-30 mb-xl-0">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members rejected position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-30 mb-xl-0">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members invite position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members invite position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite active mini-all"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models" />
                    <a href="#" class="btn btn-white members signed position-absolute to-right to-top-20 mini-all"></a>
                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                        <span class="d-block">4158800002</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        <span class="d-block">model</span>
                    </div>
                    <span class="title">Username</span>
                    <span>City-town, County, Country</span>
                    <div class="divider"></div>
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini-all"></a>
                        <a href="#" class="btn btn-white favorite active mini-all"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('children.bottom-bar')
@endsection