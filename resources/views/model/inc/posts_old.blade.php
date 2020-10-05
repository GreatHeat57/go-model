<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration', 3600);
}
?>
@if (isset($paginator) and $paginator->getCollection()->count() > 0)
	<?php
    if (!isset($cats)) {
        $cats = collect([]);
    }
    
	foreach($paginator->getCollection() as $key => $user):
		$profile = \App\Models\UserProfile::where('user_id', $user->id)->get();
		$profile = $profile[0] ? $profile[0] : array();

		?>
		<?php
		if(isset($_GET['gender_id']))
		{
			
			if($user->gender_id === $_GET['gender_id'] || $user->gender_id==='2')
			{
				?>
				<div class="item-list job-item">
					<div class="col-sm-1 col-xs-2 no-padding photobox">
						<div class="add-image">
							<a href="{{ lurl( 'account/user/'.$user->id ) }}">
								@if (!empty($profile->logo))
									<img class="userImg" src="{{ \Storage::url($profile->logo) }}" alt="user">&nbsp;
								@elseif (!empty($gravatar))
									<img class="userImg" src="{{ $gravatar }}" alt="user">&nbsp;
								@else
									<img class="userImg" src="{{ url('images/user.jpg') }}" alt="user">
								@endif
							</a>
						</div>
					</div>
					<!--/.photobox-->
					<div class="col-sm-10 col-xs-10 add-desc-box">
						<div class="add-details jobs-item">
							<span class="info-row">
								<div class="col-md-12 col-xs-12 col-xxs-12">
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
									<?php
										date_default_timezone_set(config('timezone.id'));
										$start  = date_create($user->last_login_at);
										$end 	= date_create();
										
										$diff  	= date_diff( $start, $end );
										
										echo t('Last Activity');
										echo ': ';
										if ($diff->y) {
											echo  $diff->y . ' ' . (($diff->y == 1) ? t('year ago'): t('years ago'));
										}
										else if ($diff->m) {
											echo  $diff->m . ' ' . (($diff->m == 1) ? t('month ago'): t('months ago'));
										}
										else if ($diff->d) {
											echo  $diff->d . ' ' . (($diff->d == 1) ? t('day ago'): t('days ago'));
										}
										else if ($diff->h) {
											echo  $diff->h . ' ' . (($diff->h == 1) ? t('hour ago'): t('hours ago'));
										}
										else if ($diff->i) {
											echo  $diff->i . ' ' . (($diff->i == 1) ? t('minute ago'): t('minutes ago'));
										}
										else if ($diff->s) {
											echo  $diff->s . ' ' . (($diff->s == 1) ? t('second ago'): t('seconds ago'));
										}
										else {
											echo t('never seen');
										}	
									?>
									</span>
								</div>
							</span>
						</div>
					</div>
				</div>
				<?php
			}
		}
		else
		{
			?>
				<div class="item-list job-item">
					<div class="col-sm-1 col-xs-2 no-padding photobox">
						<div class="add-image">
							<a href="{{ lurl( 'account/user/'.$user->id ) }}">
								@if (!empty($profile->logo))
									<img class="userImg" src="{{ \Storage::url($profile->logo) }}" alt="user">&nbsp;
								@elseif (!empty($gravatar))
									<img class="userImg" src="{{ $gravatar }}" alt="user">&nbsp;
								@else
									<img class="userImg" src="{{ url('images/user.jpg') }}" alt="user">
								@endif
							</a>
						</div>
					</div>
					<!--/.photobox-->
					<div class="col-sm-10 col-xs-10 add-desc-box">
						<div class="add-details jobs-item">
							<span class="info-row">
								<div class="col-md-12 col-xs-12 col-xxs-12">
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
									<?php
										date_default_timezone_set(config('timezone.id'));
										$start  = date_create($user->last_login_at);
										$end 	= date_create();
										
										$diff  	= date_diff( $start, $end );
										
										echo t('Last Activity');
										echo ': ';
										if ($diff->y) {
											echo  $diff->y . ' ' . (($diff->y == 1) ? t('year ago'): t('years ago'));
										}
										else if ($diff->m) {
											echo  $diff->m . ' ' . (($diff->m == 1) ? t('month ago'): t('months ago'));
										}
										else if ($diff->d) {
											echo  $diff->d . ' ' . (($diff->d == 1) ? t('day ago'): t('days ago'));
										}
										else if ($diff->h) {
											echo  $diff->h . ' ' . (($diff->h == 1) ? t('hour ago'): t('hours ago'));
										}
										else if ($diff->i) {
											echo  $diff->i . ' ' . (($diff->i == 1) ? t('minute ago'): t('minutes ago'));
										}
										else if ($diff->s) {
											echo  $diff->s . ' ' . (($diff->s == 1) ? t('second ago'): t('seconds ago'));
										}
										else {
											echo t('never seen');
										}	
									?>
									</span>
								</div>
							</span>
						</div>
					</div>
				</div>

			<?php
		}
		?>
		<!--/.job-item-->
	<?php endforeach; ?>
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
