@extends('layouts.app')

@section('content')
  
  @if(!empty($modelCategories))
    {!! $selectedCategory->description !!}
  @endif
  
  @include('childs.featured-models')
  
  @include('childs.categories',['title' => t('Is your baby also a go baby model?'), 'class' => ''])
  
  @if(!empty($selectedCategory->faq_text))
    {!! $selectedCategory->faq_text !!}
  @endif
<?php /*
    @if($modelCategories[0]->slug == 'baby-models')
      @include('childs.categories',['title' => t('Is your baby also a go baby model?'), 'class' => 'colored-light'])
     @endif

     @if($modelCategories[0]->slug == 'kinder-models')
      @include('childs.categories',['title' => t('Become a go-kids model too!'), 'class' => 'colored-light'])
     @endif

     @if($modelCategories[0]->slug == 'models')
      @include('childs.categories',['title' => t('Become a go-kids model too!'), 'class' => 'colored-light'])
     @endif

     @if($modelCategories[0]->slug == 'fitness-models')
      @include('childs.categories',['title' => t('Become a go-fitness model now!'), 'class' => 'colored-light'])
     @endif

     @if($modelCategories[0]->slug == 'plus-size-models')
      @include('childs.categories',['title' => t('Become a go-plus size model now!'), 'class' => 'colored-light'])
     @endif

     @if($modelCategories[0]->slug == 'plus50-models')
      @include('childs.categories',['title' => t('Become a go-50plus model now!'), 'class' => 'colored-light'])
    @endif
  */ ?>
  <?php /* 
  @include('childs.jobs')
  @include('childs.featured')
  */
  ?>
@endsection
@section('page-script')
    <script type="text/javascript">
      jQuery.noConflict()(function($){
        $(document).ready( function(){
          @if(auth()->check())
            $(".model_registration").removeClass("mfp-register-form");
            $(".model_registration").addClass("disabled disabled_opacity");
            $(".model_registration").attr("href","javascript:void(0);");
          @endif
        });
      });
    </script>
    @if(!empty($selectedCategory->faq_script))
      {!! $selectedCategory->faq_script !!}
    @endif
@endsection