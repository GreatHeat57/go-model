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

namespace App\Http\Controllers\Model;

use App\Helpers\Arr;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\UnitMeasurement;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Model\Traits\TitleTrait;
use App\Http\Requests\SendPostByEmailRequest;
use App\Mail\PostSentByEmail;
use App\Models\City;
use App\Models\ModelCategory;
use App\Models\Post;
use App\Models\SubAdmin1;
use App\Models\ValidValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class BaseController extends FrontController {
	use TitleTrait;

	public $request;
	public $countries;

	/**
	 * All Types of Search
	 * Variables declaration required
	 */
	public $isIndexSearch = false;
	public $isCatSearch = false;
	public $isSubCatSearch = false;
	public $isCitySearch = false;
	public $isAdminSearch = false;
	public $isUserSearch = false;
	public $isCompanySearch = false;
	public $isTagSearch = false;

	private $cats;

	/**
	 * SearchController constructor.
	 *
	 * SearchController constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request) {
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

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();

			// get terms and conditions for country code wise
			$this->getTermsConditions();

			return $next($request);
		});

		 

		$this->request = $request;
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		$this->countries = $countries;
		view()->share('countries', $countries);

		// echo "<pre>"; print_r ($countries); echo "</pre>"; exit();

		// Get all model_categories
		$cacheId = 'model_categories.all.' . config('app.locale');
		$cats = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$cats = ModelCategory::trans()->orderby('ordering', 'asc')->orderBy('lft')->get();
			return $cats;
		});

		if ($cats->count() > 0) {
			$cats = collect($cats)->keyBy('tid');
		}
		view()->share('cats', $cats);
		$this->cats = $cats;

		// LEFT MENU VARS
		// Count model_categories Posts
		/*$sql = 'SELECT sc.id, c.parent_id, count(*) as total' . '
            FROM ' . table('posts') . ' as a
            INNER JOIN ' . table('model_categories') . ' as sc ON sc.id=a.category_id AND sc.active=1
            INNER JOIN ' . table('model_categories') . ' as c ON c.id=sc.parent_id AND c.active=1
            WHERE a.country_code = :countryCode AND (a.verified_email=1 AND a.verified_phone=1) AND a.archived!=1 AND a.deleted_at IS NULL
            GROUP BY sc.id';
		$bindings = [
			'countryCode' => config('country.code'),
		];
		$countSubCatPosts = DB::select(DB::raw($sql), $bindings);
		$countSubCatPosts = collect($countSubCatPosts)->keyBy('id');
		view()->share('countSubCatPosts', $countSubCatPosts);*/

		// Count Parent model_categories Posts
		/*$sql1 = 'SELECT c.id as id, count(*) as total' . '
            FROM ' . table('posts') . ' as a
            INNER JOIN ' . table('model_categories') . ' as c ON c.id=a.category_id AND c.active=1
            WHERE a.country_code = :countryCode AND (a.verified_email=1 AND a.verified_phone=1) AND a.archived!=1 AND a.deleted_at IS NULL
            GROUP BY c.id';
		$sql2 = 'SELECT c.id as id, count(*) as total' . '
            FROM ' . table('posts') . ' as a
            INNER JOIN ' . table('model_categories') . ' as sc ON sc.id=a.category_id AND sc.active=1
            INNER JOIN ' . table('model_categories') . ' as c ON c.id=sc.parent_id AND c.active=1
            WHERE a.country_code = :countryCode AND (a.verified_email=1 AND a.verified_phone=1) AND a.archived!=1 AND a.deleted_at IS NULL
            GROUP BY c.id';
		$sql = 'SELECT cat.id, SUM(total) as total' . '
            FROM ((' . $sql1 . ') UNION ALL (' . $sql2 . ')) cat
            GROUP BY cat.id';
		$bindings = [
			'countryCode' => config('country.code'),
		];
		$countCatPosts = DB::select(DB::raw($sql), $bindings);
		$countCatPosts = collect($countCatPosts)->keyBy('id');
		view()->share('countCatPosts', $countCatPosts);*/

		// Get the 100 most populate Cities
		$limit = 100;
		$cacheId = config('country.code') . '.cities.take.' . $limit;
		$cities = Cache::remember($cacheId, $this->cacheExpiration, function () use ($limit) {
			$cities = City::currentCountry()->take($limit)->orderBy('population', 'DESC')->orderBy('name')->get();
			return $cities;
		});
		view()->share('cities', $cities);

		// Get all values
		$property = [];
		$validValues = ValidValue::all();

		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = (isset($translate->value)) ? $translate->value : '';
		}
		
		//$unitArr = UnitMeasurement::getUnitMeasurement();

		//$property = array_merge($property, $unitArr);

		if( \Auth::check() ){
			$country = auth()->user();
			$country_code = config('app.default_units_country');
			if( isset($country->country->code) && !empty($country->country->code) ){
				$country_code = $country->country->code;
			}

		}
		
		$unitArr = new UnitMeasurement($country_code);
		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);

		$dress_Size = $unitArr->getDressSizeByPost();
		$shoe_Size = $unitArr->getShoeSizeByPost();

		$property['dress_unit_kids'] = [];
		$property['dress_unit_men'] = [];
		$property['dress_unit_women'] = [];

		$property['shoe_unit_kids'] = [];
		$property['shoe_unit_men'] = [];
		$property['shoe_unit_women'] = [];

		if(isset($shoe_Size['baby_shoe']) && count($shoe_Size['baby_shoe']) > 0){
			$property['shoe_unit_kids'] = $shoe_Size['baby_shoe'];
		}
		
		if(isset($shoe_Size['men_shoe']) && count($shoe_Size['men_shoe']) > 0){
			$property['shoe_unit_men'] = $shoe_Size['men_shoe'];
		}

		if(isset($shoe_Size['women_shoe']) && count($shoe_Size['women_shoe']) > 0){
			$property['shoe_unit_women'] = $shoe_Size['women_shoe'];
		}

		if(isset($dress_Size['baby_dress']) && count($dress_Size['baby_dress']) > 0){
			$property['dress_unit_kids'] = $dress_Size['baby_dress'];
		}
		
		if(isset($dress_Size['men_dress']) && count($dress_Size['men_dress']) > 0){
			$property['dress_unit_men'] = $dress_Size['men_dress'];
		}

		if(isset($dress_Size['women_dress']) && count($dress_Size['women_dress']) > 0){
			$property['dress_unit_women'] = $dress_Size['women_dress'];
		}


		view()->share('properties', $property);
		view()->share('eyeColors', $property['eye_color']);
		view()->share('skinColors', $property['skin_color']);
		view()->share('hairColors', $property['hair_color']);

		// Get Date Ranges
		$dates = Arr::toObject([
			'2' => '24 ' . t('hours'),
			'4' => '3 ' . t('days'),
			'8' => '7 ' . t('days'),
			'31' => '30 ' . t('days'),
		]);
		$this->dates = $dates;
		view()->share('dates', $dates);
		// END - LEFT MENU VARS

		// Get the Country first Administrative Division
		$cacheId = config('country.code') . '.subAdmin1s.all';
		$modalAdmins = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$modalAdmins = SubAdmin1::currentCountry()->orderBy('name')->get(['code', 'name'])->keyBy('code');
			return $modalAdmins;
		});
		view()->share('modalAdmins', $modalAdmins);

		// Check and load Reviews plugin
		$reviewsPlugin = load_installed_plugin('reviews');
		view()->share('reviewsPlugin', $reviewsPlugin);
	}

	/**
	 * @param SendPostByEmailRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendByEmail(SendPostByEmailRequest $request) {
		// Get Post
		$post = Post::find($request->input('post'));
		if (!empty($post)) {
			// Store data
			$mailData = [
				'post_id' => $post->id,
				'sender_email' => $request->input('sender_email'),
				'recipient_email' => $request->input('recipient_email'),
				'message' => $request->input('message'),
			];

			// Send the Post by email
			try {
				Mail::send(new PostSentByEmail($post, $mailData));
				flash(t("Your message has sent successfully"))->success();
			} catch (\Exception $e) {
				flash($e->getMessage())->error();
			}
		}

		return redirect(URL::previous());
	}
}
