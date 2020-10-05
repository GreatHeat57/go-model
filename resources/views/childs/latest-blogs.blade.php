@if(isset($latestBlogs))
<div class="block">
            <h2>{{ $title }}</h2>
            <div class="cols-3">
                @foreach ($latestBlogs as $recentBlogs)
                    <?php  
                          
                        $recentBlog_image = ($recentBlogs->picture) ? $recentBlogs->picture : '';

                        $recent_cropped_image ="";
                        if($recentBlog_image != "")
                        {
                            $image_details= pathinfo(public_path('uploads').'/'.$recentBlog_image); 
                            $recent_cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_top_image').'.'.$image_details['extension'];
                        }
                    ?>
                    <?php $r_attr = ['countryCode' => config('country.icode'), 'slug' =>  $recentBlogs->slug]; ?>
                    <div class="col">
                        <div class="post emphasized">
                            <a href="{{ lurl(trans('routes.v-magazine', $r_attr), $r_attr) }}">
                                <?php /*
                                    @if($recentBlog_image !== "" && file_exists(public_path('uploads').'/'.$recentBlog_image))
                                        <img src="{{ \Storage::url($recentBlog_image) }}" alt="Go-models" class="thumb" alt="{{ trans('metaTags.img_modeling_agency') }}">
                                    @else
                                        <img src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="" class="thumb" >
                                    @endif
                                */ ?>

                                    @if($recent_cropped_image !== "" && file_exists(public_path('uploads').'/'.$recent_cropped_image))
                                        <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$recent_cropped_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlogs->name)) }}" class="thumb lazyload">
                                    @elseif($recentBlog_image !== "" && file_exists(public_path('uploads').'/'.$recentBlog_image))
                                        <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$recentBlog_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlogs->name)) }}" class="thumb lazyload">
                                    @else
                                        <img data-src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic_350x210.png') }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$recentBlogs->name)) }}" class="thumb lazyload" >
                                    @endif
                            </a>
                            @if($recentBlogs->category_id > 0)
                                
                                <?php /* <h6 class="text-center"><a href="{{ lurl('blog-category/'.$recentBlogs->category->slug) }}"> */ ?>
                                
                                <?php $attr = ['countryCode' => config('country.icode'), 'slug' => $recentBlogs->category_slug]; ?>

                                <h6 class="text-center"><a href="
                                {{ lurl(trans('routes.v-blog-category', $attr), $attr) }}">
                                    {!! $recentBlogs->category_name or '' !!}</a></h6>
                            @endif
                            <h2><a href="{{ lurl(trans('routes.v-magazine', $r_attr), $r_attr) }}">{!! $recentBlogs->name !!}</a></h2>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="btn">
                <a href="{{ lurl(trans('routes.magazine')) }}" class="">{{ t('View More Articles') }}</a>
            </div>
        </div>
@endif