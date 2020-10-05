@if($data && $data->count() > 0 )
    @foreach($data as $key => $album)
    <div class="card-to-sort col-md-6 col-xl-3 mb-30">
        <div class="img-holder position-relative">
            <a href="#" data-featherlight="{{ route('album-img-zoom-popup',['id' => $album->id]) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>

            <a href="{{ lurl('account/album/'.$album->id.'/delete') }}" class="position-absolute to-bottom-0 to-right-0 btn btn-primary trash mini-all delete-btn"></a>

                 <?php if($album->cropped_image ==""){ ?>
                    <img src="{{ \Storage::url('/album/'.$album->filename) }}" width="100%" height="100%">
                <?php } else { ?>
                    <img src="<?php echo url(config('filesystems.default').'/'.str_replace("uploads", "", $album->cropped_image)); ?>" width="100%" height="100%">
                <?php } ?>
        </div>
        <div class="box-shadow bg-white py-40 px-30">
            <span class="mb-30">{{ str_limit($album->name, config('constant.title_limit')) }}</span>
            <div class="d-flex justify-content-between">
                <!-- <a href="#" class="btn btn-white sort mini-all"></a> -->
                <a href="{{ lurl('account/album/' . $album->id . '/edit') }}" class="btn btn-success edit mini-all"></a>
            
            <span class="mb-30">
                <div class="col-md-6 form-group custom-checkbox mb-30">
                    <input class="checkbox_field" id="studio_{{$key}}" name="entries[]" type="checkbox" value="{{ $album->id }}">
                    <label for="studio_{{$key}}" class="checkbox-label">{{ t('Delete') }}</label>
                </div>
            </span>
            </div>
        </div>
    </div>
    @endforeach
@endif
        