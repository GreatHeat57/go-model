@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')
<?php $attr = ['countryCode' => config('country.icode')]; ?>

<?php

// Keywords
$keywords = rawurldecode(Request::input('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : Request::input('c');

// Location
if (isset($city) and !empty($city)) {
    $qLocationId = (isset($city->id)) ? $city->id : 0;
    $qLocation = $city->name;
    $qAdmin = Request::input('r');
} else {
    $qLocationId = Request::input('l');
    $qLocation = (Request::input('r')) ? t('area:') . rawurldecode(Request::input('r')) : Request::input('location');
    $qAdmin = Request::input('r');
}
?>
<?php 
    $attr = ['countryCode' => config('country.icode')];

    if (isset($isfavorite) && $isfavorite == 1) {
        $favoriteClass = 'active';
        $partnerClass = '';
        $pageTitle = t('Favorite partner');
    } else {
        $favoriteClass = '';
        $partnerClass = 'active';
        $pageTitle = t('find partner');
    }
?>

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords($pageTitle) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>
        <?php
            $tabs = array();
            $tabs[lurl(trans('routes.partner-list', $attr), $attr)] = t('all partners');
            $tabs[ lurl(trans('routes.partner-list-favourites', $attr), $attr)] = t('Favorites');
        ?>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}
            <ul class="tabs d-none d-md-block">
                <li><a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}" class="{{ $partnerClass }}">{{ t('all partners') }}</a></li>
                <li><a href="{{ lurl(trans('routes.partner-list-favourites', $attr), $attr) }}" class="{{ $favoriteClass }}">{{ t('Favorites') }}</a></li>
            </ul>
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