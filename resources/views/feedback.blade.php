@extends('layouts.out_of_app')

@section('content')
    <div class="d-flex align-items-center container out_of_app px-0 mw-970">
        <div class="bg-white box-shadow full-width">
            <div class="d-flex justify-content-center py-sm-20 py-md-30 bb-grey">
                <img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                     src="/images/img-logo.png" alt="{{ trans('metaTags.Go-Models') }}" class="logo"/>
            </div>
            <div class="text-center pt-40 pb-60">
                <div class="d-block mx-auto feedback-check bg-grey2 mb-40"></div>
                <span class="title f20">You've successfully activated your account!</span>
            </div>
        </div>
    </div>
@endsection