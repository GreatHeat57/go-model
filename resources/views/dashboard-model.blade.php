@extends('layouts.app-model')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30">
            <h1>Welcome back</h1>
            <div class="divider mx-auto"></div>
        </div>
        <div class="row grid">
            <div class="col-lg-6 pb-40 grid-item">
                <div class="mb-30 text-center">
                    <h2 class="position-relative prata d-inline-block">Invitations<span
                                class="msg-num dashboard">7</span></h2>
                    <div class="divider mx-auto"></div>
                </div>
                @for($i=0;$i<3;$i++)
                    <div class="row mx-0 bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-40 pl-30 mb-20">
                        <span class="flag to-left-30 to-top-0 ongoing"></span>
                        <div class="col-md-6 pt-40 pb-20 px-0 bordered">
                            <span class="title">Action to job</span>
                            <span>Job name</span>
                            <div class="divider"></div>
                            <span class="posted">Date</span>
                        </div>
                        <div class="col-md-6 px-0 pt-40 pl-md-4">
                            <span class="dark-grey2 posted mb-10">From</span>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="from-img-holder mr-20 rounded-circle border bg-lavender d-flex justify-content-center align-items-center">
                                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                         src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"
                                         class="from-img full-width"/>
                                </div>
                                <span class="title">Partner</span>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="text-center"><a href="#" class="btn btn-white no-bg">All invitations</a></div>
            </div>
            <div class="col-lg-6 pb-40 grid-item">
                <div class="mb-30 text-center">
                    <h2 class="position-relative prata d-inline-block">Messages<span class="msg-num dashboard">5</span>
                    </h2>
                    <div class="divider mx-auto"></div>
                </div>
                @for($i=0;$i<3;$i++)
                    <div class="row mx-0 bg-white box-shadow position-relative pt-40 pb-30 pl-30 pr-20 mb-20">
                        <div class="mr-md-40 mb-lg-30 mb-xl-0">
                            <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">
                                <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"
                                     class="from-img full-width"/>
                            </div>
                        </div>
                        <div>
                            <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                <span class="d-block">id number</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                <span class="d-block">kategoria</span>
                            </div>
                            <span class="title">Jobname</span>
                            <div class="modelcard-top">
                                <span class="d-inline-block">Partner</span>
                                <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>
                                <span class="d-inline-block">Name of contact person</span>
                            </div>
                            <div class="divider"></div>
                            <p>Message text lorem ipsum dolor et sit amet</p>
                            <div class="d-flex justify-content-start align-items-center">
                                <span class="rounded-circle bg-green card-appointment-number bold mr-10">1</span>
                                <span class="bold">Date, Appointment</span>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="text-center"><a href="#" class="btn btn-white no-bg">All messages</a></div>
            </div>
            <div class="col-lg-6 pb-40 grid-item">
                <div class="mb-30 text-center">
                    <h2 class="position-relative prata d-inline-block">Latest jobs near you<span
                                class="msg-num dashboard">23</span></h2>
                    <div class="divider mx-auto"></div>
                </div>
                @for($i=0;$i<3;$i++)
                    <div class="bg-white box-shadow pt-40 pr-20 pb-20 pl-30 mb-20">
                        <div class="position-relative">
                            <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                <span class="d-block f-12">id number</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                <span class="d-block f-12">kategoria</span>
                            </div>
                            <span class="title">Jobname lorem ipsum dolor et sit amet ante id molestie</span>
                            <span>Jobart, Jobart</span>
                            <div class="divider"></div>
                            <p class="mb-20">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                                velcongueligula
                                eroset t accumsan quam feugiat y vulputatetus.</p>
                            <span class="info city mb-20">City-Town, County, Country</span>
                            <span class="info appointment mb-20">Date, Appointment</span>
                            <span class="info partner mb-20">Partner</span>
                            <span class="info posted">posted 1 day ago</span>
                            <div class="d-flex corner-btn justify-content-end"><a href="#"
                                                                                  class="btn btn-white favorite active align-self-end mini-all"></a>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="text-center"><a href="{{ route('find-work') }}" class="btn btn-white no-bg">Find work</a>
                </div>
            </div>
            <div class="col-lg-6 pb-40 grid-item">
                <div class="text-center">
                    <h2 class="position-relative prata d-inline-block">Now on gomodels</h2>
                    <div class="divider mx-auto"></div>
                </div>
                <div class="row grid">
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-20 grid-item">
                        <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                        </div>
                        <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                            <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                <span class="d-block">id number</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                <span class="d-block">kategoria</span>
                            </div>
                            <span class="title">Username</span>
                            <span>City-town, County, Country</span>
                            <div class="divider"></div>
                            <p class="mb-30">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                                velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big facebook rounded-circle mr-20"></div>
                                <span class="d-inline-block">facebook.com/<br/>modeljana1998</span>
                            </div>
                            <span class="info posted">posted 1 day ago</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-20 grid-item">
                        <div class="box-shadow bg-white">
                            <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                                <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                         {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                         {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                            </div>
                            <div class="pt-40 pr-20 pb-20 pl-30">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="social-big instagram rounded-circle mr-20"></div>
                                    <span>instagram.com/<br/>@gomodels</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-20 grid-item">
                        <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                            <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                 src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                        </div>
                        <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                            <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                                <span class="d-block">id number</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                                <span class="d-block">kategoria</span>
                            </div>
                            <span class="title">Username</span>
                            <span>City-town, County, Country</span>
                            <div class="divider"></div>
                            <p class="mb-30">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                                velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                            <div class="d-flex justify-content-start align-items-center mb-30">
                                <div class="social-big facebook rounded-circle mr-20"></div>
                                <span class="d-inline-block">facebook.com/<br/>modeljana1998</span>
                            </div>
                            <span class="info posted">posted 1 day ago</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6 mb-20 grid-item">
                        <div class="box-shadow bg-white">
                            <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                                <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                             {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                             {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                            </div>
                            <div class="pt-40 pr-20 pb-20 pl-30">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="social-big instagram rounded-circle mr-20"></div>
                                    <span>instagram.com/<br/>@gomodels</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center full-width"><a href="{{ route('find-work') }}" class="btn btn-white no-bg">More
                        post</a></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.grid').imagesLoaded(function(){
            $('.grid').masonry({
                itemSelector : '.grid-item',
            });
        });
    </script>
@endpush