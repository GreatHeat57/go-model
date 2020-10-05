<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration', 3600);
}
?>
@if (isset($paginator) and $paginator->getCollection()->count() > 0 and auth()->user()->user_type_id=='3')
	<?php
    if (!isset($cats)) {
        $cats = collect([]);
    }
    
	foreach($paginator->getCollection() as $key => $user):

		$model_id  = \Auth::user()->id;
        $modeldata = \App\Models\UserProfile::where('user_id',$model_id)->first();
        $gender =\Auth::user()->gender_id;
        $parent_category = explode(',',$modeldata->parent_category);
        $count_match = DB::table('posts')->where(
			[
				['user_id',$user->id],
				['model_category_id',$modeldata->category_id],
				['ismodel','1'],
				['gender_type_id',$gender],
				['height_from','<=',$modeldata->height_id],
				['height_to','>=',$modeldata->height_id],
				['weight_from','<=',$modeldata->weight_id],
				['weight_to','>=',$modeldata->weight_id],
				['dressSize_from','<=',$modeldata->size_id],
				['dressSize_to','>=',$modeldata->size_id],
				['verified_email','1'],
			]
			)->orWhere(
			[
				['user_id',$user->id],
				['model_category_id',$modeldata->category_id],
				['ismodel','1'],
				['gender_type_id','2'],
				['height_from','<=',$modeldata->height_id],
				['height_to','>=',$modeldata->height_id],
				['weight_from','<=',$modeldata->weight_id],
				['weight_to','>=',$modeldata->weight_id],
				['dressSize_from','<=',$modeldata->size_id],
				['dressSize_to','>=',$modeldata->size_id],	
				['verified_email','1'],		
			]);

			$count=$count_match->whereIN('category_id',$parent_category)->count();
		                    

		 if($count>0)
        { 			                    

			$profile = \App\Models\UserProfile::where('user_id', $user->id)->get();
			$profile = $profile[0] ? $profile[0] : array();
			?>
			<div class="item-list job-item">
				<div class="col-sm-1 col-xs-2 no-padding photobox">
					<div class="add-image">
						<a href="{{ lurl( 'account/user/'.$user->id ) }}">
							@if (!empty($profile->logo))
								<img class="userImg" src="{{ \Storage::url($profile->logo) }}" alt="{{ trans('metaTags.User') }}">&nbsp;
							@elseif (!empty($gravatar))
								<img class="userImg" src="{{ $gravatar }}" alt="{{ trans('metaTags.User') }}">&nbsp;
							@else
								<img class="userImg" src="{{ url('images/user.jpg') }}" alt="{{ trans('metaTags.User') }}">
							@endif
						</a>
					</div>
				</div>
				<!--/.photobox-->
				<div class="col-sm-10 col-xs-10 add-desc-box">
					<div class="add-details jobs-item">
						<span class="info-row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
								<a href="{{ lurl( 'account/user/'.$user->id ) }}">
									<h3 class="no-padding text-center-480 useradmin">
										{{ $user->name }}
									</h3>
								</a>
								<span>
									<strong><i class="fa fa-map-marker"></i></strong> {{ $profile->city }}
									<img src="{{ url('images/flags/16/' . strtolower($user->country_code) . '.png') }}" data-toggle="tooltip" title="{{ $user->country_code }}" alt="{{ strtolower($user->country_code) . '.png' }}">
								</span>
								<br>
								<span>
									<?php $company = \App\Models\Company::where('user_id', $user->id)->get();?>
									@foreach ($company as $com)
										<a href="">
											{{ mb_ucfirst($com->name) }}
										</a>
										<br>
										{{ $com->description }}
									@endforeach
								</span>
							</div>
						</span>
					</div>
				</div>
			</div>
			<!--/.job-item-->
		<?php 
		}

		endforeach; ?>
@else
	<div class="item-list">
		@if (\Illuminate\Support\Str::contains(\Route::currentRouteAction(), 'Search\CompanyController'))
			{{ t('No jobs were found for this company') }}
		@else
			{{ t('No result, Refine your search using other criteria') }}
		@endif
	</div>
@endif

@section('modal_location')
	@parent
	@include('layouts.inc.modal.send-by-email')
@endsection

@section('after_scripts')
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
		})
	</script>
@endsection
