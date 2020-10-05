@extends('layouts.app')

@section('content')
    <div class="subcover colored-very-light-blue">
        <h1 class="text-center prata">{{ t('Go-models Magazine') }}</h1>
    </div>
    
    <?php /*
    @include('childs.magazine_categories')
    @include('front.inc.posts') */?>
    
    @include('childs.magazine_categories')
    <div class="block no-pd mb-40">
        <div class="magazine">
            <div class="posts mb-30">
                @include('front.inc.magazine-list')
            </div>
            @include('front.inc.magazine_right_section')
        </div>
    </div>

    <?php /*
        <!--  <div class="buttons more-post-div">
            <div class="text-center btn">
                <a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('more magazin') }}</a>
            </div>
        </div> -->
    */ ?>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/magazine-blade.js') }}
@endsection