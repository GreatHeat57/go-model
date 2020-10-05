@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')
<?php $attr = ['countryCode' => config('country.icode')]; ?>

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords(t('Invitations')) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>
    
        @include('childs.notification-message')
       
        <div class="box-shadow bg-white w-xl-1220 mx-xl-auto">
            <div class="mx-auto">
                @if(isset($page) && !empty($page))
                    {!! $page->content !!}
                @endif
            </div>
        </div>
       
    </div>
    @include('childs.bottom-bar')
    {{ Html::style(config('app.cloud_url').'/css/bladeCss/static-inner-page.css') }}
@endsection