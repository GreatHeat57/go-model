@if(isset($modelCategories))
<div class="block {{ isset($class) ? $class : '' }}" id="homecategories" >
    <h2>{{ $title }}</h2>
    <div class="cols-3">
        @foreach($modelCategories as $cat)
            
            <?php $attr = ['countryCode' => config('country.icode'), 'slug' => $cat->slug];?>
            <div class="col">
                <div class="category">

                    <?php /*
                        @if($cat->picture !== "" && file_exists(public_path($cat->picture)))
                            <a href="{{ lurl(trans('routes.v-page-category', $attr), $attr) }}"><img src="{{ URL::to($cat->picture) }}" alt="{{$cat->name}}" /></a>
                        @else
                            <a href="{{ lurl(trans('routes.v-page-category', $attr), $attr) }}">
                                <img class="full-width" src="{{ URL::to('uploads/app/default/categoryPicture.webp') }}" alt="{{$cat->name}}" onerror=this.src='{{ URL::to('uploads/app/default/categoryPicture.jpg') }}'/>
                            </a>
                        @endif 
                    */ ?>
                    
                    <?php
                        if($cat->picture !== "" && file_exists(public_path($cat->picture))) {
                    
                        $img = explode(".", $cat->picture);
                        $altImg = $img[0].".jpg";
                    ?>
                        <a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">
                            <img data-src="{{ URL::to(config('app.cloud_url').$cat->picture) }}" class="lazyload" alt="{{$cat->title}}" onerror=this.src='{{ URL::to(config('app.cloud_url').$altImg) }}' />
                        </a>
                     <?php } else { ?>
                        <a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">
                            <img class="full-width lazyload" data-src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/categoryPicture.webp') }}" alt="{{$cat->title}}" onerror=this.src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/categoryPicture.jpg') }}"/>
                        </a>
                    <?php } ?>
                    <div class="data">
                        <div>
                            <h3><a href="{{ lurl(trans('routes.'.$cat->page_route)) }}">{{$cat->title}}</a></h3>
                            <span>{{$cat->age_range}} {{ trans('frontPage.age') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="btn">
        <a href="{{ lurl(trans('routes.models-category')) }}">{{ trans('frontPage.category_btn_label') }}</a>
    </div>
</div>
@endif