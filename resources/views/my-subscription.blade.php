@extends('layouts.logged_in.app-model')

@section('content')
    <div class="container px-0 pt-40 pb-30">
        <h1 class="text-center prata">My subscription</h1>
        <div class="divider mx-auto"></div>
        <div class="owl-carousel mb-60">
            <div class="plan">
                <div class="box-shadow bg-white text-center pt-40 pb-30 px-30">
                    <div class="mb-40 pb-40 bb-light-lavender3">
                        <h3 class="prata f-h2">Free</h3>
                        <div class="divider mx-auto"></div>
                        <div class="d-flex justify-content-center mb-40"><span class="bold f-h2">0 &euro;</span><span> / year</span></div>
                        <p class="w-md-373 mx-auto text-center mb-40">See how go models works. Nullam mauris nunc, hendrerit ut placerat quis.</p>
                        <div class="checks text-left mx-auto w-md-212">
                            <span class="checked bold pl-30 mb-20">Register and make your profile</span>
                            <span class="checked bold pl-30">Register and make your profile</span>
                        </div>
                    </div>
                    <div class="text-center"><a href="#" class="btn btn-white no-bg">Upgrade plan</a></div>
                </div>
            </div>
            <div class="plan subscribed">
                <div class="box-shadow bg-white text-center pt-40 pb-30 px-30 position-relative">
                    <span class="flag applied to-right-20 to-top-0"></span>
                    <div class="mb-40 pb-40 bb-light-lavender3">
                        <h3 class="prata f-h2">Premium</h3>
                        <div class="divider mx-auto"></div>
                        <div class="d-flex justify-content-center mb-40"><span class="bold f-h2">132 &euro;</span><span> / year</span></div>
                        <p class="w-md-558 mx-auto text-center mb-40">Use go models at its full potential. Apply for jobs. Vivamus mi ipsum, ultrices scelerisque felis at, posuere mattis lectus.</p>
                        <div class="checks text-left mx-auto w-md-212">
                            <span class="checked bold pl-30 mb-20">Apply for unlimited jobs</span>
                            <span class="checked bold pl-30 mb-20">Get contacts</span>
                            <span class="checked bold pl-30">Chat with professionals and companies</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn btn-success no-bg mb-20 mb-md-0 mr-md-20">Renew now</a>
                        <a href="#" class="btn btn-white no-bg">Cancel plan</a>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="bold f-20">Your contracts</h2>
        <div class="divider"></div>
        <div class="d-md-flex justify-content-between box-shadow bg-white py-20 px-38 position-relative mb-30">
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3 flex-md-grow-1">
                <span class="d-block dark-grey2 f-12">ID</span>
                <span>#00000289</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3 flex-md-grow-1">
                <span class="d-block dark-grey2 f-12">Date</span>
                <span>07.04.2017</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3 flex-md-grow-1">
                <span class="d-block dark-grey2 f-12">Description</span>
                <span>Model contract between you and go models</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Status</span>
                <span class="text-uppercase cancelled">cancelled</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Contract</span>
                <span class="ico-draft"></span>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.owl-carousel').owlCarousel({
            dots: false,
            margin: 20,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                979:{
                    items: 2
                }
            }
        })
    </script>
@endpush