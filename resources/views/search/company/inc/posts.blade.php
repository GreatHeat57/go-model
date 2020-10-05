<div class="row tab_content mb-40">
<?php
if (!isset($cacheExpiration)) {
	$cacheExpiration = (int) config('settings.other.cache_expiration', 3600);
}
?>

@if (isset($data) and $data->getCollection()->count() > 0) 

		@foreach ($data->getCollection() as $k => $post)
                <?php $postUrl = lurl($post->uri);

                	$pagePath	= 'my-posts';

                    if ($post->city) {
                        $city = $post->city->name;
                    } else {
                        $city = '-';
                    }

                    ?>
                        
                        <div class="col-md-6 mb-20">
                            <div class="box-shadow bg-white pt-20 pr-20 pb-20 pl-30 position-relative">
                                <div class="col-md-6 col-xl-3 mt-20 position-absolute to-top-0" style="right: 5px;">
                                </div>

                                <a href="{{ $postUrl }}"><span class="title">{{ str_limit($post->title, config('constant.title_limit')) }}</span></a>
                                <?php 
                                    $salary_min = (isset($post->salary_min))? $post->salary_min : '';
                                    $salary_max = (isset($post->salary_max))? $post->salary_max : '';
                                ?>

                                @if($salary_max !== '' || $salary_min !== '')
                                    <span> {{ \App\Helpers\Number::money($salary_min) }} - {{ \App\Helpers\Number::money($salary_max) }}

                                        @if($post->negotiable)
                                            {{ t('Negotiable') }}
                                        @endif 
                                    </span>
                                @else
                                    <span>&nbsp;</span>
                                @endif

                                @if($salary_max == '' && $salary_min == '' && $post->negotiable)
                                    <span>{{ \App\Helpers\Number::money('') }} - {{ t('Negotiable') }}</span>
                                @endif
                                <div class="divider"></div>
                                <p class="mb-30">{{ str_limit(strip_tags($post->description), config('constant.description_limit')) }}</p>
                                <span class="info city mb-10">{{ $city }} </span>
                                <!-- <span class="info appointment mb-10">18.08.2018, 10:00</span> -->
                                <?php $applications = \App\Models\Message::where('post_id', $post->id)->where('to_user_id', auth()->user()->id)->groupBy('from_user_id')->get();?>
                                <span class="info partner mb-10">
                                    @if(count($applications) > 0)
                                    <a href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">{{ count($applications) }} {{ t('applications') }}</a>
                                    @else
                                    {{ count($applications) }} {{ t('applications') }}
                                    @endif
                                </span>
                                <span class="info partner mb-10">
                                    {{ t('Visitors') }} {{ $post->visits or 0 }}
                                </span>

                                <span class="info posted">{{ t('Posted On') }} <strong>{{ $post->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</strong></span>
                                
                                 <div class="d-flex justify-content-end">
                                    <div class="position-relative">
                                        <a href="#" class="btn btn-success more mr-20 mini-all dropdown-main"  data-content="more-dropdown-{{$k}}"></a>
                                        <div class="bg-white box-shadow py-10 px-30 dropdown-content" data-content="more-dropdown-{{$k}}">

                                            @if ($post->user_id == Auth::User()->id and $post->archived==0)
                                                <?php $attrId['id'] = $post->id; ?>
                                                <a href="{{ lurl(trans('routes.post-edit', $attrId), $attrId) }}" class="d-block f-15 pb-10 mb-10 bb-grey2">{{ t('Edit') }}</a>
                                            @endif
                                            @if ($post->user_id == Auth::User()->id and $post->archived==1)
                                             <a class="d-block f-15 pb-10 mb-10 bb-grey2" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">{{ t('Repost') }}</a>
                                            @endif
                                            @if ($post->user_id == Auth::User()->id and $post->archived==0)
                                             <a class="d-block f-15 pb-10 mb-10" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">{{ t('Archive ads') }}</a>
                                            @endif
                                        </div>
                                        <a href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/delete') }}" class="btn btn-white mini-all trash_white">{{ t('Delete') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

            @endforeach
@else
	<div class="text-center mb-30 position-relative">
		@if (\Illuminate\Support\Str::contains(\Route::currentRouteAction(), 'Search\CompanyController'))
			<p>{{ t('No jobs were found for this company') }}</p>
		@else
			<p>{{ t('No result, Refine your search using other criteria') }}</p>
		@endif
	</div>
@endif
</div>
<div class="text-cente pt-40 mb-30 position-relative">
    @include('customPagination')
</div>

@section('modal_location')
	@parent
	@include('layouts.inc.modal.send-by-email')
@endsection

@section('page-script')
	@parent
	<script>
		/* Favorites Translation */
		var lang = {
			labelSavePostSave: "{!! t('Save Job') !!}",
			labelSavePostRemove: "{{ t('Saved Job') }}",
			loginToSavePost: "{!! t('Please log in to save the Ads') !!}",
			loginToSaveSearch: "{!! t('Please log in to save your search') !!}",
			confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
			confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
			confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
			confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
		};

		$(document).ready(function ()
		{
			/* Get Post ID */
			$('.email-job').click(function(){
				var postId = $(this).attr("data-id");
				$('input[type=hidden][name=post]').val(postId);
			});

			@if (isset($errors) and $errors->any())
				@if (old('sendByEmailForm')=='1')
					$('#sendByEmail').modal();
				@endif
			@endif

			
            $('.make-favorite').on('click',function(){

                var id = $(this).attr('id');
                var attr = $(this);
                var siteUrl =  window.location.origin;

                $.ajax({
                    method: "POST",
                    url: siteUrl + "/ajax/save/post",
                    data: {
                        postId: id,
                        _token: $("input[name=_token]").val()
                    }
                }).done(function(e) {
                    if(attr.hasClass( "active" )){
                        attr.removeClass('active');
                    }else{
                        attr.addClass('active');
                    }
                });
            });
        
		})
	</script>
@endsection
