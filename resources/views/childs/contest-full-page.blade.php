@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')
<?php $attr = ['countryCode' => config('country.icode')]; ?>

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <h1 class="text-center prata">{{ ucWords(t('Jobs')) }}</h1>
        <div class="text-center mb-30 position-relative">
            <div class="divider mx-auto"></div>
        </div>
    
        <?php
    
            $favAttr = ['countryCode' => config('country.icode'), 'slug' => t('favourites')];
            $tabs = array();

            $tabs[lurl(trans('routes.search', $attr), $attr)] = t('Latest jobs Portal');
            $tabs[lurl(trans('routes.v-search', $favAttr), $favAttr)] = t('Favorite jobs');

            if(Auth::user()->user_type_id == config('constant.model_type_id')){
                $tabs[lurl(trans('routes.job-info'))] = t('Job Info');
            }
           
        ?>
    
        <div class="custom-tabs mb-20 mb-xl-30">

            {{ Form::select('tabs', $tabs , url()->current(),['id' => 'tab-menu','class' =>'select2-hidden-accessible']) }}

            <ul class="d-none d-md-block">

                <li><a href="{{ lurl(trans('routes.search', $attr), $attr) }}" class="" data-id="1">{{ t('Latest jobs Portal') }}</a></li>

                <li><a href="{{ lurl(trans('routes.v-search', $favAttr), $favAttr) }}" class="" data-id="2">{{ t('Favorite jobs') }}</a></li>

                
                @if(Auth::user()->user_type_id == config('constant.model_type_id'))
                    <li><a href="{{ lurl(trans('routes.job-info')) }}" class="active" data-id="2">{{ t('Job Info') }}</a></li>
                @endif
              
            </ul>
        </div>
        
        @include('childs.notification-message')
       
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            <div class="mx-auto">
                @if(isset($page) && !empty($page))
                    {!! $page->content !!}
                @endif
            </div>
        </div>
       
    </div>
    @include('childs.bottom-bar')
@endsection