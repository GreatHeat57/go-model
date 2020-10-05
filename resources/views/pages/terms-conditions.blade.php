@extends('layouts.app')
@section('content')
    <div class="subcover colored-light-blue">
        @if(isset($is_free_country) && $is_free_country == true)

            <?php if($is_model_terms_conditions == true){ ?>
                        <h1>{{ t('Terms of Use for free Models') }} ({{strtoupper(config('country.code'))}})</h1>
                <?php }else{ ?>
                        <h1>{!! $pageTitle !!}</h1>
            <?php } ?>

        @else
            <h1>{{ $pageTitle}}</h1>
        @endif
    </div>
    <div class="block">
        <div class="form">
            <div class="inner-page-content">
                <?php if($is_model_terms_conditions == true){ ?>
                        {!! $page_terms !!}
                <?php }else{ ?>
                        {!! $page_termsclient !!}
            <?php } ?>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
{{ Html::style(config('app.cloud_url').'/css/bladeCss/table-blade.min.css') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/page-blade.js') }}
@endsection