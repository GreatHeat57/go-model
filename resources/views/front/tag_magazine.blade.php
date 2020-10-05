<?php
    if(isset(Auth::User()->user_type_id)){
        if(Auth::User()->user_type_id == '2'){
            $is_user = true;
        }else {
            $is_user = true;
        }
    }else{
        $is_user = false;
    }
?>
@extends('layouts.app')
@section('content')
	@if($is_user)
        {{ Html::style(config('app.cloud_url').'/css/magazine.css') }}
        
    @endif
	    <div class="subcover colored-very-light-blue">
	        <h1 class="text-center prata">{{ t('Go-models Magazine') }}</h1>
	    </div>
    @include('childs.magazine_categories')
    <div class="block no-pd mb-40">
        <div class="magazine">
            <div class="posts mb-30">
                @include('front.inc.magazine-list')
            </div>
            @include('front.inc.magazine_right_section')
        </div>
    </div>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/magazine-blade.js') }}
@endsection