
    <input type="hidden" id="myurl" url="{{ url()->current() }}" />
    <input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
    <input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>
    <div class="block no-pd mb-40">
        <div class="magazine">
            <div class="posts mb-30">
            @if(count($blogs) > 0)
            <div class="posts append-data">
            @foreach ($blogs as $blog)
                <?php  
                             
                    $blog_image = ($blog->picture) ? $blog->picture : '';
                    $cropped_image ="";
                    if($blog_image != "")
                    {
                        $image_details= pathinfo(public_path('uploads').'/'.$blog_image);

                        $cropped_image = str_replace('uploads/','',substr($image_details['dirname'] , strpos($image_details['dirname'], 'uploads/')))."/".$image_details['filename'].'-'.config('app.blog_bottom_image').'.'.$image_details['extension'];
                    }
                ?>
                    <div class="post">
                        <?php $m_attr = ['countryCode' => config('country.icode'), 'slug' =>  $blog->slug]; ?>
                            <a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">
                            {{-- @if($blog_image !== "" && file_exists(public_path('uploads').'/'.$blog_image))
                                    <img src="{{ \Storage::url($blog_image) }}" alt="Go-models" class="thumb">
                            @else
                                <img src="{{ URL::to('images/icons/ico-nopic.png') }}" alt="" class="thumb" >
                            @endif --}}


                            @if($cropped_image !== "" && file_exists(public_path('uploads').'/'.$cropped_image))
                                    <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$cropped_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$blog->name)) }}" class="thumb lazyload">
                            @elseif($blog_image !== "" && file_exists(public_path('uploads').'/'.$blog_image))
                                    <img data-src="{{ url(config('app.cloud_url').'/uploads/'.$blog_image) }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$blog->name)) }}" class="thumb lazyload">
                            @else
                                <img data-src="{{ URL::to(config('app.cloud_url').'/images/icons/blog_listing_large_default.jpg') }}" alt="{{ str_replace(' ', '-',preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',$blog->name)) }}" class="thumb lazyload" >
                            @endif
                        </a>
                        <div class="text">
                            @if($blog->category_id > 0)
                                <?php $attr = ['countryCode' => config('country.icode'), 'slug' =>  $blog->category_slug]; ?>
                                <h6 class="text-center"><a href="{{ lurl(trans('routes.v-blog-category', $attr), $attr) }}">{!! $blog->category_name or '' !!}</a></h6>
                            @endif
                            <h2><a href="{{ lurl(trans('routes.v-magazine', $m_attr), $m_attr) }}">{!! $blog->name !!}</a></h2>
                            <p>{!! str_limit($blog->short_text , 50) !!}</p>
                            <div class="author">
                                <!-- April 1, 2018 -->
                                <div>
                                    @if(!empty($blog->post_author))
                                        @if (!empty($blog->user_profile_logo) && Storage::exists($blog->user_profile_logo))
                                            <img data-src="{{ \Storage::url($blog->user_profile_logo) }}" alt="{{ trans('metaTags.Go-Models-Author') }}" class="lazyload" />
                                        @elseif (!empty($gravatar))
                                            <img data-src="{{ $gravatar }}" alt="{{ trans('metaTags.Go-Models-Author') }}" class="lazyload" />
                                        @else
                                            <img data-src="{{ url(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models-Author') }}" class="lazyload">
                                        @endif
                                        <!-- <img src="{{ URL::to(config('app.cloud_url').'/images/author1.jpg') }}" alt="Go-Models-Author" /> -->
                                        
                                    
                                        <span> <?=ucfirst($blog->username)?></span>  
                                    @endif
                                    <!-- <span>by Kathi</span> --> 
                                </div>
                                <label class="float-right blog-date"><a href="{{ lurl(trans('routes.magazine')) }}">{!! App\Helpers\CommonHelper::getFormatedDate($blog->created_at) !!}</a></label>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
        <div class="text-center mb-10"><a href="javascript:void(0);" id="more-blogs" class="btn_load_more btn-white refresh more-blogs">{{ t('more magazin') }}</a></div>
        @else
            <h1>{{ t('No records found') }}</h1>
        @endif
        
    </div>
        
        @include('front.inc.magazine_right_section')
    </div>
    </div>
    
    


   
    <script>
        
        $(document).ready(function ()
        {   
            var postData = '';
            if($("#is_last_page").val() == 1){
                $("#more-blogs").addClass("disabled");
            }

            $('.more-blogs').click(function(){
                var url = $("#myurl").attr("url");
                var pageNo = $("#pageNo").val(); 
                var formData = 'page=' + pageNo;
                var type = 'get';
                // return;
                var is_last_page = $("#is_last_page").val();

                if (is_last_page == 1) {
                    alert("On the last record page");
                    return false;
                }
                
                var data = formData;
                $.ajax({
                    url: url,
                    type : type,
                    dataType :'json',
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    data : data,
                    success : function(res){
                        var append = $(res.html).find(".append-data").html();
                        $("#pageNo").val(res.pageNo);
                        
                        if(res.is_last_page == 1){
                            $("#is_last_page").val(res.is_last_page);
                            $("#more-blogs").addClass("disabled");
                        }

                        $('.append-data').append(append);

                    }
                });
            });
        })
    </script>