
<?php
$image_path = '';
if (!empty($sedcard)) {
	//print_r($sedcard);
	if ($sedcard['cropped_image'] == "") {
		$image_path = \Storage::url($sedcard['filename']);
	} elseif ($sedcard['filename'] != "") {
		$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $sedcard['cropped_image']));
	}
}

if (!empty($modelbook)) {
	if ($modelbook['cropped_image'] == "") {
		$image_path = \Storage::url($modelbook['filename']);
	} elseif ($modelbook['filename'] != "") {
		$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook['cropped_image']));
	}
}

if (!empty($userprofile)) {
	if ($type == 'logo') {
		if (!empty($userprofile->logo)) {
			$image_path = \Storage::url($userprofile->logo);
		}
	}
	if ($type == 'cover') {
		if (!empty($userprofile->cover)) {
			$image_path = \Storage::url($userprofile->cover);
		}
	}

}
if(isset($show_title)) {
	$title = $show_title;
}else{
	$title = t('Photo view full size');
}
?>
<div id="img-zoom-popup">
    <div class="pt-40 pb-60 px-38 px-lg-0 w-lg-720">
        <span class="bold f-20 lh-28"><?php echo $title; ?></span>
        <div class="divider"></div>
        <div class="owl-carousel">
            <img srcset="{{ $image_path }},
                 {{ $image_path }} 2x,
                 {{ $image_path }} 3x"
                 src="{{ $image_path }}" alt="{{ trans('metaTags.Go-Models') }}"/>
        </div>
    </div>
</div>
<script>
    jQuery.noConflict()(function($){
        $('.owl-carousel').owlCarousel({
            margin: 20,
            items: 1
        });
    });
</script>