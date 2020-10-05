<!-- <?php //print_r($package); ?> -->
@if(isset($package) && count($package) > 0 )
<div class="plan subscribed">
	<div class="box-shadow bg-white text-center pt-40 pb-30 px-30 position-relative">
	    <?php $doc = new DOMDocument(); if ($package->features) { $doc->loadHTML($package->features); ?>
                               <?php } 
                if(isset($package->features) && !empty($package->features)){
                    $features = explode('-', strip_tags($package->features));
                }?>
	    <div class="mb-40 pb-40 bb-light-lavender3">
        <?php foreach ($features as $key => $value) {  if( !empty(trim($value))){?>
	        <div class="checks text-left mx-auto  w-md-373">
	            <!-- <span class="checked bold pl-30 mb-20">Apply for unlimited jobs</span>
	            <span class="checked bold pl-30 mb-20">Get contacts</span> -->
	            <span class="checked bold pl-30">{{ $value }}</span>
	        </div>
        <?php } }?>
	    </div>
	</div>
</div>
@endif
<style type="text/css">
	.plan .checks {
    	height: 60px !important;
	}
</style>