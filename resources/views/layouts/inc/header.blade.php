<?php
// Search parameters
$queryString = (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.other.cache_expiration', 3600);
// $defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
// 	$defaultLang = \App\Models\Language::where('default', 1)->first();
// 	return $defaultLang;
// });

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
	if (!empty(config('country.code'))) {
		// if (\App\Models\Country::where('active', 1)->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		// }
	}
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
	$logoLabel = config('settings.app.name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
}
if (auth()->check()) {

	//get user's unread messages
	// $new_message = App\Models\Message::where([
	// 	['to_user_id', Auth::user()->id],
	// 	['is_read', '0'],

	// ])->count();
	// $personalchat = App\Models\Message::where([
	// 	['to_user_id', Auth::user()->id],
	// 	['is_read', '0'],
	// 	['invitation_status', '3'],
	// ])->count();

	$new_message = Auth::user()->unread_userMessages();

	//get invitation count from unread messages
	$personalchat = 0;
	if(count($new_message)>0){
		foreach($new_message as $msg){
			if($msg->invitation_status == 3){
				$personalchat++;
			}
		}
	}
}
?>

<div class="header">
	<nav class="navbar navbar-site navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				{{-- Toggle Nav --}}
				<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				{{-- Country Flag (Mobile) --}}
				@if (getSegment(1) != trans('routes.countries'))
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path().'/images/flags/24/'.config('country.icode').'.png'))
								<button class="flag-menu country-flag visible-xs btn btn-default hidden" href="#selectCountry" data-toggle="modal" >
									<img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;" alt="{{ config('country.icode').'.png' }}">
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif

				{{-- Logo --}}
				<a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
					<img src="{{ \Storage::url(config('settings.app.logo')) . getPictureVersion() }}"
						 alt="{{ strtolower(config('settings.app.name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
						 data-toggle="tooltip"
						 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
				</a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					{{-- Country Flag --}}
					@if (getSegment(1) != trans('routes.countries'))
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path().'/images/flags/32/'.config('country.icode').'.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal">
                                            @if (isset( auth()->user()->country_code))
												<img class="flag-icon" src="{{ url('images/flags/32/'.auth()->user()->country_code.'.png') . getPictureVersion() }}" style="float: left;" alt="{{ auth()->user()->country_code.'.png' }}">
											@else
                                            	<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;" alt="{{ config('country.icode').'.png' }}">
											@endif
                                                <span class="caret hidden-sm"></span>
											</a>
										@else
											</a>
										<a style="cursor: default;">
												<img class="flag-icon" src="{{ url('images/flags/32/'.config('country.icode').'.png') . getPictureVersion() }}" style="float: left;" alt="{{ config('country.icode').'.png' }}">
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
					@if (auth()->check())
					<li>
						<?php $attr = ['countryCode' => config('country.icode')];?>
						<a href="{{ lurl(trans('routes.v-search', $attr), $attr) }}">
							<i class="icon-th-list-2 hidden-sm"></i>
							{{ t('Browse Jobs') }}
						</a>
					</li>
					@endif
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (!auth()->check())
						<li>
							@if (config('settings.security.login_open_in_modal'))
								<a href="#quickLogin" data-toggle="modal"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@else
								<a href="{{ lurl(trans('routes.login')) }}"><i class="icon-user fa"></i> {{ t('Log In') }}</a>
							@endif
						</li>
						<li><a href="{{ lurl(trans('routes.register')) }}" rel="nofollow"><i class="icon-user-add fa"></i> {{ t('Register') }}</a></li>
						<li class="postadd">
							@if (config('settings.single.guests_can_post_ads') != '1')
								<a class="btn btn-block btn-post btn-add-listing" href="#quickLogin" data-toggle="modal">
									<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
								</a>
							@else
								<a class="btn btn-block btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
									<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
								</a>
							@endif
						</li>
					@else
						<li>
							@if (app('impersonate')->isImpersonating())
								<a href="{{ route('impersonate.leave') }}">
									<i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
								</a>
							@else
								<a href="{{ lurl(trans('routes.logout')) }}">
									<i class="glyphicon glyphicon-off hidden-sm"></i> {{ t('Log Out') }}
								</a>
							@endif
						</li>
						@if (in_array(auth()->user()->user_type_id, [1, 2]))
							<li><a href="{{ url('model-list') }}">
									<i class="icon-search"></i> {{ t('model_search') }}
								</a>
							</li>
						@endif
						@if (in_array(auth()->user()->user_type_id, [3]))
						<?php $attr = ['countryCode' => config('country.icode')];?>
						<li><a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}">
									<i class="icon-list"></i> {{ t('Partners') }}
								</a>
						</li>
						@endif

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-user fa hidden-sm"></i>
								<span>{{ auth()->user()->name }}</span>
								<i class="icon-down-open-big fa hidden-sm"></i>
							</a>
							<ul class="dropdown-menu user-menu">
								<li class="active"><a href="{{ lurl('account') }}"><i class="icon-home"></i> {{ t('Personal Home') }}</a></li>
								<li><a href="{{ lurl('account/social') }}"><i class="icon-layout"></i> {{ t('Social') }}</a></li>
								@if (in_array(auth()->user()->user_type_id, [1, 2]))
									<li>
										<a href="{{ lurl(trans('routes.account-companies')) }}"><i class="icon-town-hall"></i> {{ t('My companies') }}</a>
									</li>
									<li><a href="{{ lurl('account/my-posts') }}"><i class="icon-th-thumb"></i> {{ t('My ads') }} </a></li>
									<li><a href="{{ lurl('account/pending-approval') }}"><i class="icon-hourglass"></i> {{ t('Pending approval') }} </a></li>
									<li><a href="{{ lurl('account/archived') }}"><i class="icon-folder-close"></i> {{ t('Archived ads') }}</a></li>
									<li><a href="{{ lurl('account/conversations') }}"><i class="icon-mail-1"></i> {{ t('Message') }} @if($new_message>0)<span class="badge">{{$new_message}}</span>@endif</a></li>


									<li><a href="{{ lurl('account/personalchat') }}"><i class="icon-mail-1"></i> {{ t('personal_chat') }} @if($personalchat>0)<span class="badge">{{$personalchat}}</span>@endif</a></li>
									<!--------------this is for personal chat system------------>
									<li><a href="{{ lurl('account/transactions') }}"><i class="icon-money"></i> {{ t('Transactions') }}</a></li>
									<!--------------this is for personal chat system------------>
								@endif
								@if (in_array(auth()->user()->user_type_id, [1, 3]))
									<li><a href="{{ lurl('account/resumes') }}"><i class="icon-attach"></i> {{ t('My resumes') }} </a></li>
									<li><a href="{{ lurl('account/favourite') }}"><i class="icon-heart"></i> {{ t('Favourite jobs') }} </a></li>
									<li><a href="{{ lurl('account/saved-search') }}"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </a></li>
									@if (in_array(auth()->user()->user_type_id, [3]))
										<li><a href="{{ lurl('account/conversations') }}"><i class="icon-mail-1"></i> {{ t('Message') }} @if($new_message>0)<span class="badge">{{$new_message}}</span>@endif</a></li>
										<!--------------this is for personal chat system------------>
										<li><a href="{{ lurl('account/personalchat') }}"><i class="icon-mail-1"></i> {{ t('personal_chat') }} @if($personalchat>0)<span class="badge">{{$personalchat}}</span>@endif</a></li>
										<!--------------this is for personal chat system------------>

									@endif
								@endif
							</ul>
						</li>
						@if (in_array(auth()->user()->user_type_id, [1, 2]))
						<li class="postadd">
							<a class="btn btn-block btn-post btn-add-listing" href="{{ lurl('posts/create') }}">
								<i class="fa fa-plus-circle"></i> {{ t('Create a Job ad') }}
							</a>
						</li>
						@endif
					@endif

					@if (count(LaravelLocalization::getSupportedLocales()) > 1)
					<!-- Language selector -->
					<li class="dropdown lang-menu">
						<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
							{{ strtoupper(config('app.locale')) }}
							<span class="caret hidden-sm"> </span>
						</button>
						<ul class="dropdown-menu" role="menu">
							@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
								@if (strtolower($localeCode) != strtolower(config('app.locale')))
									<?php
// Controller Parameters
$attr = [];
$attr['countryCode'] = config('country.icode');
if (isset($uriPathCatSlug)) {
	$attr['catSlug'] = $uriPathCatSlug;
	if (isset($uriPathSubCatSlug)) {
		$attr['subCatSlug'] = $uriPathSubCatSlug;
	}
}
if (isset($uriPathCityName) && isset($uriPathCityId)) {
	$attr['city'] = $uriPathCityName;
	$attr['id'] = $uriPathCityId;
}
if (isset($uriPathPageSlug)) {
	$attr['slug'] = $uriPathPageSlug;
}

// Default
// $link = LaravelLocalization::getLocalizedURL($localeCode, null, $attr);
$link = lurl(null, $attr, $localeCode);
$localeCode = strtolower($localeCode);
?>
									<li>
										<a href="{{ $link }}" tabindex="-1" rel="alternate" hreflang="{{ ($properties['locale'])? str_replace('_','-', $properties['locale']) : $localeCode }}">
											{{{ $properties['native'] }}}
										</a>
									</li>
								@endif
							@endforeach
						</ul>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
</div>
