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

namespace App\Http\Controllers\Account;

use App\Helpers\Arr;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Http\Controllers\FrontController;
use App\Models\Company;
use App\Models\Message;
use App\Models\ModelBook;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Resume;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\Sedcard;
use App\Models\ValidValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Helpers\UnitMeasurement;


abstract class AccountBaseController extends FrontController {
	public $countries;
	public $myPosts;
	public $archivedPosts;
	public $favouritePosts;
	public $pendingPosts;
	public $conversations;
	public $transactions;
	public $companies;
	public $resumes;

	private $cats;

	/**
	 * AccountBaseController constructor.
	 */
	public function __construct() {
		parent::__construct();

		// $page_terms = $page_termsclient = array();
  //       if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
  //           foreach($this->pages as $page){
  //               if($page->type == "terms"){
  //                   $page_terms = $page;
  //               }elseif($page->type == "termsclient") {
  //                   $page_termsclient = $page;
  //               }
  //           }
  //       }
  //       view()->share('page_terms', $page_terms);
  //       view()->share('page_termsclient', $page_termsclient);
        
		$this->middleware(function ($request, $next) {
			$this->leftMenuInfo();
			$this->searchModelProperties();
			// get terms and conditions for country code wise
			$this->getTermsConditions();
			return $next($request);
		});

		view()->share('pagePath', '');
	}

	public function leftMenuInfo() {
		// Get & Share Countries
		$this->countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $this->countries);

		// Share User Info
		// view()->share('user', auth()->user());

		
		if(\Auth::check() && auth()->user()->user_type_id == 2){

			// My Posts
			$this->myPosts = Post::where('user_id', auth()->user()->id)
				->verified()
				->unarchived()
				->reviewed()
				->with('city')
				->orderByDesc('id');
			view()->share('countMyPosts', $this->myPosts->count());

			// Archived Posts
			// $this->archivedPosts = Post::where('user_id', auth()->user()->id)
			// 	->archived()
			// 	->with('city')
			// 	->orderByDesc('id');
			// view()->share('countArchivedPosts', $this->archivedPosts->count());

			// Favourite Posts
			// $this->favouritePosts = SavedPost::whereHas('post', function ($query) {
			// 	$query->currentCountry();
			// })
			// 	->where('user_id', auth()->user()->id)
			// 	->with('post.city')
			// 	->orderByDesc('id');
			// view()->share('countFavouritePosts', $this->favouritePosts->count());

			// Pending Approval Posts
			/*$this->pendingPosts = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->currentCountry()
				->where('user_id', auth()->user()->id)
				->unverified()
				->with('city')
				->orderByDesc('id');
			view()->share('countPendingPosts', $this->pendingPosts->count());*/

			// Companies
			// $this->companies = Company::where('user_id', auth()->user()->id)->orderByDesc('id');
			// view()->share('countCompanies', $this->companies->count());
		}

		// Save Search
		// $savedSearch = SavedSearch::where('user_id', auth()->user()->id)
		// 	->orderByDesc('id');
		// view()->share('countSavedSearch', $savedSearch->count());

		// Conversations
		// $this->conversations = Message::whereHas('post', function($query) {
		// 		$query->currentCountry();
		// 	})->where(function($query) {
		// 		$query->where('to_user_id', auth()->user()->id)->orWhere('from_user_id', auth()->user()->id);
		// 	})
		// 	->where('parent_id', 0)
		// 	->where(function($query) {
		// 		$query->where('deleted_by', '!=', auth()->user()->id)->orWhereNull('deleted_by');
		// 	})
		//     ->orderByDesc('id');

		// $this->notifications = Message::where(function ($query) {
		// 	$query->where('to_user_id', auth()->user()->id);
		// })
		// 	->where('parent_id', 0)
		// 	->where('is_read', 0)
		// 	->where(function ($query) {
		// 		$query->where('deleted_by', '!=', auth()->user()->id)->orWhereNull('deleted_by');
		// 	})
		// 	->orderBy('is_read');
		// view()->share('countNotifications', $this->notifications->count());

		// Payments
		// $this->transactions = Payment::whereHas('post', function ($query) {
		// 	$query->currentCountry()->whereHas('user', function ($query) {
		// 		$query->where('user_id', auth()->user()->id);
		// 	});
		// })
		// 	->with(['post', 'paymentMethod'])
		// 	->orderByDesc('id');
		// view()->share('countTransactions', $this->transactions->count());


		// if(\Auth::check() && auth()->user()->user_type_id == 3){
		// 	// Resumes
		// 	$this->resumes = Resume::where('user_id', auth()->user()->id)->orderByDesc('id');
		// 	view()->share('countResumes', $this->resumes->count());

		// 	// Sedcard
		// 	$this->sedcards = Sedcard::where('user_id', auth()->user()->id)->orderByDesc('id');
		// 	view()->share('countSedcards', $this->sedcards->count());

		// 	// ModelBooks
		// 	$this->modelbooks = ModelBook::where('user_id', auth()->user()->id)->orderByDesc('id');
		// 	view()->share('countModelBooks', $this->modelbooks->count());
		// }

		// $unreadConversation = $unreadMessages = $totalConversations = 0;

		// if( Auth::check() ){
		// 	$unreadConversation = Auth()->User()->totalunreadConversation;
		// 	$unreadMessages = Auth()->User()->totalUnreadMsg;
		// 	// $totalConversations = Auth()->User()->totalConversation;
		// }
		// // count all conversation
		// $totalConversations = Message::getConversations(auth()->user()->id,null);
		
		// view()->share('unreadConversation', count($unreadConversation));
		// view()->share('unreadMessages', count($unreadMessages));
		// view()->share('totalConversations', count($totalConversations));
		
	}

	public function searchModelProperties() {

		// Get all values
		$property = [];
		$validValues = ValidValue::all();

		// print_r($validValues);exit;
		if (!empty($validValues)) {

			foreach ($validValues as $val) {

				$translate = $val->getTranslation(app()->getLocale());
				$property[$val->type][$val->id] = (!empty($translate->value)) ? $translate->value : '';
			}


			//$unitArr = UnitMeasurement::getUnitMeasurement();
			//$property = array_merge($property, $unitArr);

			$unitArr = new UnitMeasurement();
			$unitoptions = $unitArr->getUnit(true);
			$property = array_merge($property, $unitoptions);

			$eye_color = isset($property['eye_color']) ? $property['eye_color'] : array();
			$skin_color = isset($property['skin_color']) ? $property['skin_color'] : array();
			$hair_color = isset($property['hair_color']) ? $property['hair_color'] : array();

			view()->share('properties', $property);
			view()->share('eyeColors', $eye_color);
			view()->share('skinColors', $skin_color);
			view()->share('hairColors', $hair_color);

			// Get Date Ranges
			$dates = Arr::toObject([
				'2' => '24 ' . t('hours'),
				'4' => '3 ' . t('days'),
				'8' => '7 ' . t('days'),
				'31' => '30 ' . t('days'),
			]);
			$this->dates = $dates;
		}
		view()->share('dates', $dates);
	}
}
