<?php
    $imageTitle = t('Photo view full size');
    if(isset($title)){
        if(!empty($title)){
            $imageTitle = $title;
        }
    }
?>
<div id="img-zoom-popup">
    <div class="pt-40 pb-60 px-38 px-lg-0 w-lg-720">
        <span class="bold f-20 lh-28">{{ $imageTitle }}</span>
        <div class="divider"></div>
        <div class="owl-carousel">
        	@if (isset($album) && !empty($album))
                @if($album->cropped_image !== "" && $album->cropped_image !== null &&  Storage::exists($album->cropped_image))
                    <img class="full-width" src="{{ \Storage::url($album->cropped_image) }}" alt="{{ trans('metaTags.User') }}">
                @elseif ($album->filename !== "" && Storage::exists($album->filename))
                    <img class="full-width" src="{{ \Storage::url($album->filename) }}" alt="{{ trans('metaTags.User') }}" width="100%" height="100%">
                @else
                    <img class="full-width" src="{{ URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                @endif
            @endif
        </div>
    </div>
</div>
<script>
    jQuery.noConflict()(function(jQuery){
        jQuery('.owl-carousel').owlCarousel({
            margin: 20,
            items: 1
        });
    });
</script>