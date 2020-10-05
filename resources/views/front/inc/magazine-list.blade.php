<input type="hidden" id="pageNo" value="<?php echo isset($nextPage) ? $nextPage : 1 ?>"/>
<input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>

@if (count($blogs) > 0)
    <div class="posts append-data">
        @foreach ($blogs as $v)
            <?php  
                $atl = "";
                $blog_image = ($v->picture) ? $v->picture : '';
                $cropped_image ="";
                if($blog_image != "")
                {
                    $image_details= pathinfo(public_path('uploads').'/'.$blog_image);

                    if(isset($image_details['filename']) && !empty($image_details['filename'])){
                        $atl = $image_details['filename'];
                    }

                    $cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_bottom_image').'.'.$image_details['extension'];
                }
            ?>
            <?php $m_attr = ['countryCode' => config('country.icode'), 'slug' =>  $v->slug]; ?>
            <div class="post">
                <a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">
                    
                    <?php /*
                        @if($blog_image !== "" && file_exists(public_path('uploads').'/'.$blog_image))
                            <img src="{{ \Storage::url($v->picture) }}" alt="{{ trans('metaTags.img_modeling_agency') }}" class="thumb">
                        @else
                            <img src="{{ URL::to('images/icons/blog_listing_large_default.jpg') }}" alt="" class="thumb" >
                        @endif
                    */ ?>

                    @if($cropped_image !== "" && file_exists(public_path('uploads').'/'.$cropped_image))
                        <img data-src="{{ url(config('app.cloud_url') . '/uploads/'.$cropped_image) }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload">
                    @elseif($blog_image !== "" && file_exists(public_path('uploads').'/'.$blog_image))
                        <img data-src="{{ url(config('app.cloud_url') . '/uploads/'.$v->picture) }}" alt="{{ ($atl)? $atl : str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload">
                    @else
                        <img data-src="{{ URL::to(config('app.cloud_url') . '/images/icons/blog_listing_large_default.jpg') }}" alt="{{ ($atl)? $atl :str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$v->name)) }}" class="thumb lazyload" >
                    @endif
                </a>
                <div class="text">
                    @if($v->category_id > 0)
                        
                        <?php $attr = ['countryCode' => config('country.icode'), 'slug' => $v->category_slug]; ?>

                        <h6 class="text-center"><a href="{{ lurl(trans('routes.v-blog-category', $attr), $attr) }}">{!! $v->category_name or '' !!}</a></h6>
                    @endif
                        <h2><a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">“{!! $v->name !!}”</a></h2>
                        
                    <p>{!! str_limit($v->short_text , 50) !!}</p>
                    <div class="author">
                        <div>
                            @if(!empty($v->post_author))
                                @if (!empty($v->user_profile_logo) && Storage::exists($v->user_profile_logo))
                                    <img class="lazyload" data-src="{{ \Storage::url($v->user_profile_logo) }}" alt="{{ trans('metaTags.Go-Models-Author') }}">
                                @elseif (!empty($gravatar))
                                    <img class="lazyload" data-src="{{ $gravatar }}" alt="{{ trans('metaTags.Go-Models-Author') }}">
                                @else
                                    <img class="lazyload" data-src="{{ url(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models-Author') }}"">
                            @endif
                                <span> <?=ucfirst($v->username)?></span>  
                            @endif
                        </div>
                        <label class="float-right blog-date">{{ App\Helpers\CommonHelper::getFormatedDate($v->start_date) }}</label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <?php /* @include('customPagination', ['paginator' => $blogs]) */ ?>
    <div class="buttons more-post-div">
        <div class="text-center btn">
            <a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('more magazin') }}</a>
        </div>
    </div>
@else
    <div class="pos text-centert pt-40">
        <h1>{{ t('No records found') }}</h1>
    </div>
@endif
<script type="text/javascript">
    var currentUrl = '<?php echo url()->current(); ?>'+'/ajax';
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/magazine_list-blade.js') }}


