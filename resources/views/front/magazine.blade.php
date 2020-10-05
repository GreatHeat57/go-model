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
@extends("layouts.app")

@section('content')

    @if($is_user)
        {{ Html::style(config('app.cloud_url').'/css/magazine.css') }}
    @endif


    <div class="cover"> 
        <picture class="banner-img">
            <source media="(max-width: 480px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_480_320')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image')) }}">

            <source media="(max-width: 768px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_768_595')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image')) }}">

            <source media="(max-width: 1024px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_1024_580')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image')) }}">

            <source media="(max-width: 1200px)" srcset="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_1200_580')) }}" data-image="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image')) }}">

            <img src="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_webp')) }}" class="" alt="Go-Models" onerror="this.src='{{ URL::to(config("app.cloud_url")."/images/covers/".trans("frontPage.magazine_banner_image")) }}'">
        </picture>
        <?php /*
        <!-- <img src="{{ URL::to(config('app.cloud_url').'/images/covers/'.trans('frontPage.magazine_banner_image_webp')) }}" class="" alt="Go-Models" onerror="this.src='{{ URL::to(config("app.cloud_url")."/images/covers/".trans("frontPage.magazine_banner_image")) }}'"> -->
        */ ?>
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h3>{{ trans('frontPage.magazine_banner_inner_section_title') }}</h3>
                    <p>{!! trans('frontPage.magazine_banner_inner_section_content') !!}</p>
                </div>
            </div>
        </div>
    </div>

    @include('childs.magazine_categories')

    @if(isset($recentBlogs) && !empty($recentBlogs))
        <div class="block no-pd-b bd-b-light">
            <div class="cols-3">
                @foreach ($recentBlogs as $recentBlog)
                    <?php  
                        $atl = "";
                        $recentBlog_image = ($recentBlog->picture) ? $recentBlog->picture : '';

                        $recent_cropped_image ="";
                        $recent_cropped_image_webp = '';
                        $recent_cropped_image_current = '';
                        if($recentBlog_image != "")
                        {
                            $image_details= pathinfo(public_path('uploads').'/'.$recentBlog_image); 
                            
                            if(isset($image_details['filename']) && !empty($image_details['filename'])){
                                $atl = $image_details['filename'];
                            }

                            $recent_cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_top_image').'.'.$image_details['extension'];

                            $image_extension = '.'.$image_details['extension'];
                            $recent_cropped_image_without_extension = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_top_image');

                            $recent_cropped_image_webp = $recent_cropped_image_without_extension.'.webp'; 
                            $recent_cropped_image_current = $recent_cropped_image_without_extension.$image_extension;
                        }
                    ?>
                    <?php $r_attr = ['countryCode' => config('country.icode'), 'slug' =>  $recentBlog->slug]; ?>
                    <div class="col">
                        <div class="post emphasized">
                            <a href="{{ lurl(trans('routes.v-magazine', $r_attr), $r_attr) }}">
                                    
                                    <?php /*
                                    @if($recentBlog_image !== "" && file_exists(public_path('uploads').'/'.$recentBlog_image))
                                        <img data-src="{{ \Storage::url($recentBlog_image) }}" alt="Go-models" class="thumb" alt="{{ trans('metaTags.img_modeling_agency') }}" class="lazyload">
                                    @else
                                        <img data-src="{{ URL::to('images/icons/blog_listing_large_default.jpg') }}" alt="" class="thumb lazyload" >
                                    @endif
                                    */ ?>
                                    
                                    @if($recent_cropped_image_current !== "" && file_exists(public_path('uploads').'/'.$recent_cropped_image_current))
                                        <img 
                                            src="{{ url(config('app.cloud_url').'/uploads/'.$recent_cropped_image_webp) }}" 
                                            alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlog->name)) }}" 
                                            class="thumb lazyload"
                                            onerror="this.src='{{ url(config('app.cloud_url').'/uploads/'.$recent_cropped_image_current) }}'">
                                    @elseif($recentBlog_image !== "" && file_exists(public_path('uploads').'/'.$recentBlog_image))
                                        <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$recentBlog_image) }}" alt="{{  ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlog->name)) }}" class="thumb lazyload">
                                    @else
                                        <img data-src="{{ URL::to(config('app.cloud_url').'/images/icons/blog_listing_large_default.jpg') }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlog->name)) }}" class="thumb lazyload" >
                                    @endif
                            </a>
                            @if($recentBlog->category_id > 0)
                                
                                <?php /*
                                    <h6 class="text-center"><a href="{{ lurl('blog-category/'.$recentBlog->category->slug) }}"> 
                                */ ?>
                                
                                <?php $attr = ['countryCode' => config('country.icode'), 'slug' => $recentBlog->category_slug]; ?>

                                <h6 class="text-center"><a href="
                                {{ lurl(trans('routes.v-blog-category', $attr), $attr) }}">
                                    {!! $recentBlog->category_name or '' !!}</a></h6>
                            @endif
                            <h2><a href="{{ lurl(trans('routes.v-magazine', $r_attr), $r_attr) }}">{!! $recentBlog->name !!}</a></h2>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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