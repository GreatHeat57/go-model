<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\LocalizationTrait;
use App\Http\Controllers\Traits\RobotsTxtTrait;
use App\Http\Controllers\Traits\SettingsTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Post;
use App\Models\Page;
use App\Models\UserType;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\Country;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Silber\PageCache\Middleware\CacheResponse;
use Illuminate\Support\Facades\Gate;
use Input;
use App\Http\Controllers\Traits\UserCountTrait;


class FrontController extends Controller
{
	use LocalizationTrait, SettingsTrait, RobotsTxtTrait, UserCountTrait;
	
	public $request;
	public $data = [];
	public $pages = [];
	public $userTypes = [];
	public $defaultLang = [];

	/**
	 * FrontController constructor.
	 */
	public function __construct()
	{
		// From Laravel 5.3.4+
		$this->middleware(function ($request, $next)
		{

			$this->loadLocalizationData();
			$this->checkDotEnvEntries();
			$this->applyFrontSettings();
			$this->calculateUserData();
			$this->checkUserCountryType();
			
			$utm_source 	= 	(Input::get('utm_source')) ? Input::get('utm_source') : '';
			$utm_medium 	= 	(Input::get('utm_medium')) ? Input::get('utm_medium') : '';
			$utm_campaign 	= 	(Input::get('utm_campaign')) ? Input::get('utm_campaign') : '';
			$utm_content 	= 	(Input::get('utm_content')) ? Input::get('utm_content') : '';
			$utm_term 		= 	(Input::get('utm_term')) ? Input::get('utm_term') : ''; 
			$gclid 			= 	(Input::get('gclid')) ? Input::get('gclid') : '';
			$clientId 		= 	(Input::get('clientId')) ? Input::get('clientId') : '';

			if(!empty($utm_source)){ Session::put('utm_source', $utm_source); }
			if(!empty($utm_medium)){ Session::put('utm_medium', $utm_medium); }
			if(!empty($utm_campaign)){ Session::put('utm_campaign', $utm_campaign); }
			if(!empty($utm_content)){ Session::put('utm_content', $utm_content); }
			if(!empty($utm_term)){ Session::put('utm_term', $utm_term); }
			if(!empty($gclid)){ Session::put('gclid', $gclid); }
			if(!empty($clientId)){ Session::put('clientId', $clientId); }
			
			//overwrite robot.txt file
			//$this->checkRobotsTxtFile();

			return $next($request);
		});

		// set default cookies on the page load
		if (!isset($_COOKIE['go_models_loggedin'])) {
			setcookie('go_models_loggedin', 0);
		}
		
		// Pages Menu
		$pages = Cache::remember('pages.' . config('app.locale') . '.menu', $this->cacheExpiration, function () {
			$pages = Page::trans()->where('excluded_from_footer', '!=', 1)->where('active', '=', 1)->orderBy('ordering', 'ASC')->get();
			return $pages;
		});
		view()->share('pages', $pages);
		$this->pages = $pages;

		$userTypes = Cache::remember('userTypes.' . config('app.locale') . '.menu', $this->cacheExpiration, function () {
			$userTypes = UserType::orderBy('id', 'DESC')->get();
			return $userTypes;
		});

		view()->share('userTypes', $userTypes);
		$this->userTypes = $userTypes;

		$countries = Cache::remember('countries', $this->cacheExpiration, function () {
			$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
			return $countries;
		});
		view()->share('countries', $countries);

		$defaultLang = Cache::remember('language.default', $this->cacheExpiration, function () {
			$defaultLang = \App\Models\Language::where('default', 1)->first();
			return $defaultLang;
		});
		view()->share('defaultLang', $defaultLang);
		$this->defaultLang = $defaultLang;

		$modelCategories = \App\Models\ModelCategory::trans()->where('parent_id', 0)->orderBy('ordering')->select('id', 'name', 'slug')->get();
		view()->share('modelCategories', $modelCategories);
	}

	// public function calculateUserData() {
		
	// 	if(\Auth::check() && auth()->user()->user_type_id == 2){

	// 		// My Posts
	// 		$this->myPosts = Post::where('user_id', auth()->user()->id)
	// 			->verified()
	// 			->unarchived()
	// 			->reviewed()
	// 			->with('city')
	// 			->orderByDesc('id');
	// 		view()->share('countMyPosts', $this->myPosts->count());
	// 	}


	// 	$unreadConversation = $unreadMessages = $totalConversations = $totalInvitations = $appliedJobs= 0;

	// 	if(\Auth::check() && auth()->user()->user_type_id == 3){
	// 		$appliedJobs = auth()->user()->appliedJobs->count();
	// 	}

	// 	if( Auth::check() ){
	// 		$unreadConversation = count(Auth()->User()->totalunreadConversation);
	// 		$unreadMessages = (count(Auth()->User()->totalUnreadMsg) + count(Auth()->User()->totalDirectUnreadMsg));
	// 		// $totalConversations = Auth()->User()->totalConversation;
	// 		$totalConversations = count(Auth()->User()->totalunreadConversation);

	// 		if(auth()->user()->user_type_id == 2){
	// 			$totalInvitations = Message::select('messages.*','posts.title','posts.description','users.user_type_id')
	// 							->join('users', 'users.id', '=', 'messages.from_user_id')
	// 	 						->join('posts', 'posts.id', '=', 'messages.post_id')
	// 							->where('from_user_id', Auth::user()->id)
	// 							->where('parent_id', '0')
	// 							->where('invitation_status', '0')
	// 							->where('message_type', 'Invitation')
	// 							->where('posts.archived', 0)
	// 							->count();
	// 		}else{
	// 			$totalInvitations = Message::select('messages.*','posts.title','posts.description','users.user_type_id')			->join('users', 'users.id', '=', 'messages.to_user_id')
	// 	 						->join('posts', 'posts.id', '=', 'messages.post_id')
	// 							->where('to_user_id', Auth::user()->id)
	// 							->where('parent_id', '0')
	// 							->where('invitation_status', '0')
	// 							->where('message_type', 'Invitation')
	// 							->where('posts.archived', 0)
	// 							->count();
	// 		}
	// 	}
	// 	// count all conversation
		
	// 	$modelCategories = \App\Models\ModelCategory::trans()->where('parent_id', 0)
	// 					  ->orderBy('ordering')
	// 					  ->select('id', 'name', 'slug')
	// 					  ->get();
		

	// 	if( \Auth::check() ){
	// 		if(auth()->user()->user_type_id ==  config('constant.model_type_id') && Gate::allows('premium_country_free_user', auth()->user())){
	// 			$unreadConversation = $totalConversations = $totalInvitations = 0;
	// 		}
	// 	}


	// 	view()->share('unreadConversation', $unreadConversation);
	// 	view()->share('unreadMessages', $unreadMessages);
	// 	view()->share('totalConversations', $totalConversations);
	// 	view()->share('totalInvitations', $totalInvitations);
	// 	view()->share('appliedJobs', $appliedJobs);
	// 	view()->share('modelCategories', $modelCategories);
	// }

	// set terms conditions country code wise in view share
	public function getTermsConditions() {
		
		// get country code
		if(!empty(config('country.code'))){
			$terms_country_code = config('country.code');
		}else{
			$terms_country_code = config('settings.geo_location.default_country_code');
		}
		
		// get terms conditions model and client.
		$termsConditions = Country::select('id', 'code', 'terms_conditions_model', 'terms_conditions_client', 'terms_conditions_free_model', 'country_type')->where('code', strtoupper($terms_country_code))->first();

		if($termsConditions->country_type == config('constant.country_premium') && (empty($termsConditions->terms_conditions_model) || empty($termsConditions->terms_conditions_client))){
			// get terms conditions model and client.
			$termsConditions = Country::select('id', 'code', 'terms_conditions_model', 'terms_conditions_client', 'terms_conditions_free_model', 'country_type')->where('code', strtoupper(config('settings.geo_location.default_country_code')))->first();
		}
		
		$page_terms = '';
		$page_termsclient  = '';

		// set terms conditions model.
		if($termsConditions->count() > 0 && !empty($termsConditions->terms_conditions_model) && $termsConditions->country_type == config('constant.country_premium')){
			$page_terms = $termsConditions->terms_conditions_model;
			$is_free_country = false;
		}else{
			$is_free_country = true;
			$page_terms = isset($termsConditions->terms_conditions_free_model)? $termsConditions->terms_conditions_free_model : $termsConditions->terms_conditions_model;
		}

		// set terms conditions Clients.
		if($termsConditions->count() > 0 && !empty($termsConditions->terms_conditions_client)){
			
			$page_termsclient = $termsConditions->terms_conditions_client;
		}

		view()->share('page_terms', $page_terms);
		view()->share('page_termsclient', $page_termsclient);
		view()->share('is_free_country', $is_free_country);
		return true;
	}

	// set user country type
	public function checkUserCountryType(){
		\Config::set('app.user_country_type', 'premium');
		if(\Auth::check()){
			$user = \Auth()->user();
			if(isset($user) && !empty($user) && isset($user->country->country_type)){
				\Config::set('app.user_country_type', 'free');
			}
		}
	}
}
