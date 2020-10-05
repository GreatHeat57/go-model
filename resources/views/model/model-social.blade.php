@extends('layouts.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">Now on gomodels</h1>
                <div class="divider mx-auto"></div>
                <span>Look around what lorem ipsum dolor sit amet</span>
            </div>
        </div>
        <div class="custom-tabs mb-20">
            <?
            $social = [
                1 => 'Facebook',
                2 => 'Instagram',
                3 => 'Twitter',
                4 => 'Youtube',
                5 => 'Pinterest'
             ];
            ?>
            {{ Form::select('tabs',[0 => 'All']+$social,null) }}
            <ul class="d-none d-md-flex justify-content-center">
                <li><a href="#" class="active" data-id="0">All</a></li>
                <li><a href="#" data-id="1">Facebook</a></li>
                <li><a href="#" data-id="2">Instagram</a></li>
                <li><a href="#" data-id="3">Twitter</a></li>
                <li><a href="#" data-id="4">Youtube</a></li>
                <li><a href="#" data-id="5">Pinterest</a></li>
            </ul>
        </div>
        <div class="row grid mb-40">
            @for($i=0;$i<2;$i++)
                <div class="col-md-6 col-xl-3 grid-item mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"/>
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
                <div class="col-md-6 col-xl-3 grid-item mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"/>
                    </div>
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                        <div class="d-flex justify-content-start align-items-center mb-30">
                            <div class="social-big instagram rounded-circle mr-20"></div>
                            <span class="d-inline-block">instagram.com/<br/>@modeljana1998</span>
                        </div>
                        <span class="info posted">posted 1 day ago</span>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 grid-item mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"/>
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
                            <div class="social-big pinterest rounded-circle mr-20"></div>
                            <span class="d-inline-block">pinterest.com/<br/>@modeljana1998</span>
                        </div>
                        <span class="info posted">posted 1 day ago</span>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 grid-item mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="Go Models"/>
                    </div>
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                        <div class="d-flex justify-content-start align-items-center mb-30">
                            <div class="social-big twitter rounded-circle mr-20"></div>
                            <span class="d-inline-block">twitter.com/<br/>@modelJana_1998</span>
                        </div>
                        <span class="info posted">posted 1 day ago</span>
                    </div>
                </div>
            @endfor
        </div>
        <div class="text-center"><a href="#" class="btn btn-white refresh">More posts</a></div>
    </div>
    @include('children.bottom-bar')
@endsection