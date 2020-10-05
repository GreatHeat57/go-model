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

    <div class="subcover colored-very-light-blue">
        <h1 class="text-center prata">{{ t('Go-models Magazine') }}</h1>
    </div>
    @include('childs.magazine_categories')
    @if(!empty($blogDetail))
    <div class="block no-pd-b">
        <div class="magazine magazine_details">
            <div class="posts blog-detail">
                <div class="read">
                    <?php $cat_attr = ['countryCode' => config('country.icode'), 'slug' => $blogDetail->category->slug]; ?>
                    <h3 class="text-center"><a href="
                                {{ lurl(trans('routes.v-blog-category', $cat_attr), $cat_attr) }}">{!! $blogDetail->category->name !!}</a></h3>
                    <h1>{!! $blogDetail->name !!}</h1>

                    @if($blogDetail->picture != "" && file_exists(public_path('uploads').'/'.$blogDetail->picture))

                    <?php $alt = pathinfo($blogDetail->picture, PATHINFO_FILENAME); ?>
                        <img class="lazyload" data-src="{{ \Storage::url($blogDetail->picture) }}" alt="{{ $alt }}" />
                    @else
                        <img data-src="{{ URL::to(config('app.cloud_url').'/images/icons/blog_default.jpg') }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$blogDetail->name)) }}" class="thumb lazyload" >
                    @endif

                    <div class="text magazin-read">
                        
                            <div class="blog-author col-md-12">
                                
                                    <div>
                                        @if(!empty($blogDetail->post_author) && isset($blogDetail->user) && !empty($blogDetail->user))
                                        @if (!empty($blogDetail->user->profile->logo) && Storage::exists($blogDetail->user->profile->logo))
                                            <img class="lazyload" data-src="{{ \Storage::url($blogDetail->user->profile->logo) }}" alt="{{ trans('metaTags.Go-Models-Author') }}">
                                         
                                        @elseif (!empty($gravatar))
                                            <img class="lazyload" data-src="{{ $gravatar }}" alt="{{ trans('metaTags.Go-Models-Author') }}">
                                        @else
                                            <img class="lazyload" data-src="{{ url(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models-Author') }}"> 
                                        @endif

                                        <span> <?=ucfirst($blogDetail->user->name)?></span>
                                
                                        @endif
                                    </div>
                                    <label class="float-right blog-date"><a href="{{ lurl(trans('routes.magazine')) }}">{!! App\Helpers\CommonHelper::getFormatedDate($blogDetail->start_date) !!}</a></label>
                                
                            </div>
                            <?php
                                $blog_detail = $blogDetail->long_text;
                                $blog_detail = str_replace('<p></p>', '', $blog_detail);

                                $blog_detail = preg_replace('#(<br */?>\s*)+#i', '<br />', preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>|<p><\/p>/", '', $blog_detail));
                                $blog_detail = str_replace('<br><br>', '<br>', $blog_detail);
                                $blog_detail = str_replace('<br /><br />', '<br>', $blog_detail);
                            ?>
                        <div class="blog-contents">
                            <p class="lead">{!! $blog_detail !!}</p> 
                        </div>
                    </div>

                    @if(count($blogTags) > 0)
                        <div class="tags">
                            <div>
                                @foreach ($blogTags as $tag)
                                    <a href="{{ route('magazine') }}">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="share">
                        <h4 class="title">{{ t('Share this Article') }}</h4>
                        <ul>
                            <?php $r_attr = ['countryCode' => config('country.icode'), 'slug' =>  $blogDetail->slug]; 
                                 
                               $share_url =  lurl(trans('routes.v-magazine', $r_attr), $r_attr);
                            ?>
                            <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url.'&src=sdkpreparse';?>" class="facebook facebook-share-link" title="{{ t('Share on Facebook') }}">Facebook</a></li>

                            <?php /*
                            <!-- <li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $share_url;?>" class="instagram instagram-share-link" title="{{ t('Share on Instagram') }}">Instagram</a></li> -->
                            */ ?>

                            <li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $share_url;?>" class="twitter twitter-share-link" title="{{ t('Share on Twitter') }}">Twitter</a></li>

                            <?php /*
                            <!-- <li><a target="_blank" href="https://www.youtube.com/premium" class="youtube youtube-share-link" title="Share on Youtube">Youtube</a></li> -->
                            <!-- <li><a href="#" class="pinterest">Pinterest</a></li>
                            <li><a href="" class="other">Other</a></li> -->
                            */ ?>

                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ $share_url }}" target="_blank" class="linkedIn linkedIn-share-link" title="{{ t('Share on LinkedIn') }}">
                                  LinkedIn
                                </a></li>
                            
                        </ul>
                    </div>
                    <?php /*
                    <div class="comments">
                        <h4 class="title no-mg-b"><a href="#">Kommentare (1)</a></h4>
                    </div>
                    <?php */ ?>
                </div>
            </div>

            <?php /*
            <!-- <aside class="pb-25">
                @if (count($allTags) > 0)
                    <div class="most-popular">
                        <h4>{{ t('Blog Tags') }}</h4>
                        <div class="tagcloud">
                            @foreach ($allTags as $blogTag)
                            <?php $p_attr = ['countryCode' => config('country.icode'), 'slug' =>  $blogTag->slug]; ?>
                            
                               <a href="{{ lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr) }}">{!! $blogTag->tag !!}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside> -->
            */ ?>
            @include('front.inc.magazine_right_section')
            
        </div>
    </div>
    @endif
    
    <div class="block no-pd-b related-blog">
        @if (count($moreBlogs) > 0)
        <h2>{{ t('Related blogs') }}</h2>
        <div class="cols-3">
                @foreach ($moreBlogs as $v)
                <?php $m_attr = ['countryCode' => config('country.icode'), 'slug' =>  $v->slug]; 
                    $relatedBlog_image = ($v->picture) ? $v->picture : '';

                        $related_cropped_image ="";
                        if($relatedBlog_image != "")
                        {
                            $image_details= pathinfo(public_path('uploads').'/'.$relatedBlog_image); 
                            $related_cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_top_image').'.'.$image_details['extension'];
                        }
                ?>
                    <div class="col">
                        <div class="post emphasized">
                            <a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">

                                <?php /*
                                    <!-- <img src="{{ url(config('app.cloud_url').'/uploads/'.$v->picture) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" /> -->
                                */ ?>

                                    @if($related_cropped_image !== "" && file_exists(public_path('uploads').'/'.$related_cropped_image))
                                        <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$related_cropped_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload">
                                    @elseif($relatedBlog_image !== "" && file_exists(public_path('uploads').'/'.$relatedBlog_image))
                                        <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$relatedBlog_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload">
                                    @else
                                        <img data-src="{{ URL::to(config('app.cloud_url').'/images/icons/blog_listing_large_default.jpg') }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload" >
                                    @endif

                            </a>
                            @if($v->category_id > 0)
                                <?php $c_attr = ['countryCode' => config('country.icode'), 'slug' =>  $v->category_slug]; ?>
                                <h6 class="text-center"><a href="{{ lurl(trans('routes.v-blog-category', $c_attr), $c_attr) }}">{!! $v->category->name or '' !!}</a></h6>
                            @endif
                            <h2><a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">{!! $v->name !!}</a></h2>
                        </div>
                    </div>
                @endforeach
        </div>
        @endif
    </div>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/magazine-blade.js') }}
@endsection