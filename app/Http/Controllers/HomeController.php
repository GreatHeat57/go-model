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

use App\Helpers\Arr;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Search;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\HomeSection;
use App\Models\Page;
use App\Models\Post;
use App\Models\SubAdmin1;
use App\Models\User;
// use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use SEO;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\ModelCategory;
use App\Models\BlogEntry;

// testing model included
use Illuminate\Http\Request;
use App\Models\UserShoesUnitsOptions;
use App\Models\UserDressSizeOptions;

use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use App\Models\UserProfile;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;
use App\Models\FeatureModels;
use App\Helpers\MaxmindUpdate;


class HomeController extends FrontController {
	/**
	 * HomeController constructor.
	 */
	public function __construct() {
		parent::__construct();


		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->getTermsConditions();

			return $next($request);
		});


		// Check Country URL for SEO
		// $countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
		// view()->share('countries', $countries);

		// $userTypes = UserType::all();
		// view()->share('userTypes', $userTypes);

		// //get pages for home page
		// $page_terms = $page_termsclient = array();
		// //get pages from frontcontroller construct
		// if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
		// 	foreach($this->pages as $page){
		// 		if($page->type == "terms"){
		// 			$page_terms = $page;
		// 		}elseif($page->type == "termsclient") {
		// 			$page_termsclient = $page;
		// 		}
		// 	}
		// }
		// // $page_terms = Page::where('type', 'terms')->where('active', '1')->trans()->first();
		// // $page_termsclient = Page::where('type', 'termsclient')->where('active', '1')->trans()->first();


		// if (empty($page_terms) || empty($page_termsclient)) {
		// 	abort(404);
		// }
		// view()->share('page_terms', $page_terms);
		// view()->share('page_termsclient', $page_termsclient);

		// SEO::setKeywords("go-models.com, Austria, jobs ads, jobs, ads, script, app, premium jobs");

		// abort(500);
	}

	/**
	 * @return View
	 */
	public function index() {

		$data = [];

		// Get all homepage sections
		$data['sections'] = Cache::remember('homeSections', $this->cacheExpiration, function () {
			$sections = HomeSection::orderBy('lft')->get();

			return $sections;
		});

		if ($data['sections']->count() > 0) {
			$last = $data['sections']->count() - 1;
			foreach ($data['sections'] as $key => $section) {
				// Check if method exists
				if (!method_exists($this, $section->method)) {
					continue;
				}

				// Call the method
				try {
					if (isset($section->options)) {
						$this->{$section->method}($section->options);
					} else {
						$this->{$section->method}();
					}
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
					continue;
				}
				if (!Auth::check() and $key != 0 and $key != $last and $section->view != 'home.inc.featured') {
					unset($data['sections'][$key]);
				}
			}
		}

		// Get SEO
		$this->setSeo();

		return view('home.index', $data);
	}

	public function home(Request $request) {

		$data = [];

		// Get all homepage sections
		/*
		$data['sections'] = Cache::remember('homeSections', $this->cacheExpiration, function () {
			$sections = HomeSection::orderBy('lft')->get();

			return $sections;
		});

		if ($data['sections']->count() > 0) {
			$last = $data['sections']->count() - 1;
			foreach ($data['sections'] as $key => $section) {
				// Check if method exists
				if (!method_exists($this, $section->method)) {
					continue;
				}

				// Call the method
				try {
					if (isset($section->options)) {
						$this->{$section->method}($section->options);
					} else {
						$this->{$section->method}();
					}
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
					continue;
				}
				if (!Auth::check() and $key != 0 and $key != $last and $section->view != 'home.inc.featured') {
					unset($data['sections'][$key]);
				}
			}
		}*/

		// $search = new Search();
		// $data = $search->fechAll();

		//get model categories
		// $modelCategories = ModelCategory::trans()->where('translation_lang', config('app.locale'))
		// 				  ->where('country_code', config('country.code'))
		// 				  ->orderBy('ordering')
		// 				  ->get();

		// $modelCategories = ModelCategory::trans()->where('parent_id', 0)
		// 				  ->orderBy('ordering')
		// 				  ->get();
		if($request->ajax()){

			$modelCategories = Cache::rememberForever('modelCategories_'.config('app.locale'), function () {
			    return ModelCategory::trans()->where('parent_id', 0)
							  ->orderBy('ordering')
							  ->get();
			});

			$data['modelCategories'] = $modelCategories;

			$feature_models = FeatureModels::getFeatureModelHome($cat_per_records = 5);
			$data['feature_models'] = $feature_models;

			
			// Export Search Result
			// view()->share('count', $data['count']);
			// view()->share('paginator', $data['paginator']);

			$latestBlogs = Cache::remember('latestBlogs_'.config('app.locale'), 120 * 60, function () {
				return BlogEntry::withoutGlobalScopes()
					->select('blog_entries.*', 'blog_categories.slug as category_slug', 'blog_categories.name as category_name')
					->join('blog_categories', 'blog_categories.id', 'blog_entries.category_id')
					->where('blog_entries.active', 1)
					->where('blog_categories.active', 1)
					->where('blog_entries.deleted_at', NULL)
					->where('blog_categories.deleted_at', NULL)
					->where('blog_entries.translation_lang', config('app.locale'))
					->orderBy('blog_entries.id', 'desc')
					->limit(3)->get();
			});

			$data['userTypes'] = $this->userTypes;
			$data['latestBlogs'] = $latestBlogs;

			$returnHTML = view('home.ajax-home', $data)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML));
		}
		
		// Get SEO
		$this->setSeo();

		// References
		// $data['userTypes'] = UserType::all();
		$data['userTypes'] = $this->userTypes;
		
		//regenerate flash message form ajax flash
		// CommonHelper::setFlashMessages();

		return view('home.home', $data);
	}

	/**
	 * Get search form (Always in Top)
	 *
	 * @param array $options
	 */
	protected function getSearchForm($options = []) {
		view()->share('searchFormOptions', $options);
	}

	/**
	 * Get locations & SVG map
	 *
	 * @param array $options
	 */
	protected function getLocations($options = []) {
		// Get the default Max. Items
		$maxItems = 14;
		if (isset($options['max_items'])) {
			$maxItems = (int) $options['max_items'];
		}

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($options);

		// Modal - States Collection
		$cacheId = config('country.code') . '.home.getLocations.modalAdmins';
		$modalAdmins = Cache::remember($cacheId, $cacheExpiration, function () {
			$modalAdmins = SubAdmin1::currentCountry()->orderBy('name')->get(['code', 'name'])->keyBy('code');

			return $modalAdmins;
		});
		view()->share('modalAdmins', $modalAdmins);

		// Get cities
		$cacheId = config('country.code') . 'home.getLocations.cities';
		$cities = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
			$cities = City::currentCountry()->take($maxItems)->orderBy('population', 'DESC')->orderBy('name')->get();

			return $cities;
		});
		$cities = collect($cities)->push(Arr::toObject([
			'id' => 999999999,
			'name' => t('More cities') . ' &raquo;',
			'subadmin1_code' => 0,
		]));

		// Get cities number of columns
		$nbCol = 4;
		if (file_exists(config('larapen.core.maps.path') . strtolower(config('country.code')) . '.svg')) {
			if (isset($options['show_map']) and $options['show_map'] == '1') {
				$nbCol = 3;
			}
		}

		// Chunk
		$cols = round($cities->count() / $nbCol, 0); // PHP_ROUND_HALF_EVEN
		$cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
		$cities = $cities->chunk($cols);

		view()->share('cities', $cities);
		view()->share('citiesOptions', $options);
	}

	/**
	 * Get sponsored posts
	 *
	 * @param array $options
	 */
	protected function getSponsoredPosts($options = []) {
		// Get the default Max. Items
		$maxItems = 20;
		if (isset($options['max_items'])) {
			$maxItems = (int) $options['max_items'];
		}

		// Get the default orderBy value
		$orderBy = 'random';
		if (isset($options['order_by'])) {
			$orderBy = $options['order_by'];
		}

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($options);

		$sponsored = null;

		// Get Posts
		$posts = $this->getPosts($maxItems, 'sponsored', $cacheExpiration);

		if (!empty($posts)) {
			if ($orderBy == 'random') {
				shuffle($posts);
			}
			$attr = ['countryCode' => config('country.icode')];
			$sponsored = [
				// 'title' => t('Home - Sponsored Jobs'),
				'title' => t('Home - Featured Jobs'),
				'link' => lurl(trans('routes.v-search', $attr), $attr),
				'posts' => $posts,
			];
			$sponsored = Arr::toObject($sponsored);
		}

		view()->share('featured', $sponsored);
		view()->share('featuredOptions', $options);
	}

	/**
	 * Get latest posts
	 *
	 * @param array $options
	 */
	protected function getLatestPosts($options = []) {
		// Get the default Max. Items
		$maxItems = 5;
		if (isset($options['max_items'])) {
			$maxItems = (int) $options['max_items'];
		}

		// Get the default orderBy value
		$orderBy = 'date';
		if (isset($options['order_by'])) {
			$orderBy = $options['order_by'];
		}

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($options);

		$latest = null;

		// Get Posts
		$posts = $this->getPosts($maxItems, 'latest', $cacheExpiration);

		if (!empty($posts)) {
			if ($orderBy == 'random') {
				$posts = Arr::shuffle($posts);
			}
			$attr = ['countryCode' => config('country.icode')];
			$latest = [
				'title' => t('Home - Latest Jobs'),
				'link' => lurl(trans('routes.v-search', $attr), $attr),
				'posts' => $posts,
			];
			$latest = Arr::toObject($latest);
		}

		view()->share('latest', $latest);
		view()->share('latestOptions', $options);
	}

	/**
	 * Get featured ads companies
	 *
	 * @param array $options
	 */
	private function getFeaturedPostsCompanies($options = []) {
		// Get the default Max. Items
		$maxItems = 12;
		if (isset($options['max_items'])) {
			$maxItems = (int) $options['max_items'];
		}

		// Get the default orderBy value
		$orderBy = 'random';
		if (isset($options['order_by'])) {
			$orderBy = $options['order_by'];
		}

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($options);

		$featuredCompanies = null;

		// Get all Companies
		$cacheId = config('country.code') . '.home.getFeaturedPostsCompanies.take.limit.x';
		$companies = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
			$companies = Company::whereHas('posts', function ($query) {
				$query->currentCountry();
			})
				->withCount(['posts' => function ($query) {
					$query->currentCountry();
				}])
				->take($maxItems)
				->orderByDesc('id')
				->get();

			return $companies;
		});

		if ($companies->count() > 0) {
			if ($orderBy == 'random') {
				$companies = $companies->shuffle();
			}
			$attr = ['countryCode' => config('country.icode')];
			$featuredCompanies = [
				'title' => t('Home - Featured Companies'),
				'link' => lurl(trans('routes.v-companies-list', $attr), $attr),
				'companies' => $companies,
			];
			$featuredCompanies = Arr::toObject($featuredCompanies);
		}

		view()->share('featuredCompanies', $featuredCompanies);
		view()->share('featuredCompaniesOptions', $options);
	}

	/**
	 * Get list of categories
	 *
	 * @param array $options
	 */
	protected function getCategories($options = []) {
		// Get the default Max. Items
		$maxItems = 12;
		if (isset($options['max_items'])) {
			$maxItems = (int) $options['max_items'];
		}

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($options);

		$cacheId = 'categories.parents.' . config('app.locale') . '.take.' . $maxItems;
		$categories = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
			$categories = Category::trans()->where('parent_id', 0)->take($maxItems)->orderBy('lft')->get();

			return $categories;
		});

		$cols = round($categories->count() / 3, 0); // PHP_ROUND_HALF_EVEN
		$cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
		$categories = $categories->chunk($cols);

		view()->share('categories', $categories);
	}

	/**
	 * Get mini stats data
	 */
	protected function getStats() {
		// Count posts
		$countPosts = Post::currentCountry()->unarchived()->count();

		// Count cities
		$countCities = City::currentCountry()->count();

		// Count users
		$countUsers = User::count();

		// Share vars
		view()->share('countPosts', $countPosts);
		view()->share('countCities', $countCities);
		view()->share('countUsers', $countUsers);
	}

	/**
	 * Set SEO information
	 */
	protected function setSeo() {
		// $title = getMetaTag('title', 'home');
		// $description = getMetaTag('description', 'home');
		// $keywords = getMetaTag('keywords', 'home');
		$locale = config('country.icode');

		$tags = getAllMetaTagsForPage('home');
		$title = isset($tags['title']) ? $tags['title'] : '';
		$description = isset($tags['description']) ? $tags['description'] : '';
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);

		// Open Graph
		$this->og->title($title)->description($description);
		view()->share('og', $this->og);
	}

	/**
	 * @param int $limit
	 * @param string $type (latest OR featured)
	 * @param int $cacheExpiration
	 * @return mixed
	 */
	private function getPosts($limit = 20, $type = 'latest', $cacheExpiration = 0) {
		$paymentJoin = '';
		$sponsoredCondition = '';
		$sponsoredOrder = '';
		if ($type == 'sponsored') {
			// $paymentJoin .= 'INNER JOIN ' . table('payments') . ' as py ON py.post_id=a.id AND py.active=1' . "\n"; // sponsored jobs //
			$paymentJoin .= 'INNER JOIN ' . table('payments') . ' as py' . "\n"; // for featured jobs //
			$paymentJoin .= 'INNER JOIN ' . table('packages') . ' as p ON p.id=py.package_id' . "\n";
			$sponsoredCondition = ' AND a.featured = 1';
			$sponsoredOrder = 'p.lft DESC, ';
		} else {
			// $paymentJoin .= 'LEFT JOIN ' . table('payments') . ' as py ON py.post_id=a.id AND py.active=1' . "\n";
			$paymentJoin .= 'LEFT JOIN (SELECT MAX(id) max_id, post_id FROM ' . table('payments') . ' WHERE active=1 GROUP BY post_id) mpy ON mpy.post_id = a.id AND a.featured=1' . "\n";
			$paymentJoin .= 'LEFT JOIN ' . table('payments') . ' as py ON py.id=mpy.max_id' . "\n";
			$paymentJoin .= 'LEFT JOIN ' . table('packages') . ' as p ON p.id=py.package_id' . "\n";
		}
		$reviewedCondition = '';
		if (config('settings.single.posts_review_activation')) {
			$reviewedCondition = ' AND a.reviewed = 1';
		}

		$whereProfile = '';
		$bindings1 = [];
		if (auth()->check()) {
			$user = auth()->user();
			if ($user->user_type_id == 3) {
				$whereProfile = '
							AND  a.model_category_id = :model_category_id
							AND  a.height_from <= :height
							AND  a.height_to >= :height
							AND  a.weight_from <= :weight
							AND  a.weight_to >= :weight
							AND  a.age_from <= :age
							AND  a.age_to >= :age
							AND  a.dressSize_from <= :dressSize
							AND  a.dressSize_to >= :dressSize
							';

				$current_year = date("Y");
				$year = date("Y", strtotime($user->profile->birth_day));
				$age = $current_year - $year;

				$bindings1 = [
					'model_category_id' => $user->profile->category_id,
					'height' => $user->profile->height_id,
					'weight' => $user->profile->weight_id,
					'age' => $age,
					'dressSize' => $user->profile->size_id,
				];
			}
		}

		$sql = 'SELECT DISTINCT a.*, py.package_id as py_package_id' . '
                FROM ' . table('posts') . ' as a
                INNER JOIN ' . table('categories') . ' as c ON c.id=a.category_id AND c.active=1
                ' . $paymentJoin . '
                WHERE a.country_code = :countryCode
                	AND (a.verified_email=1 AND a.verified_phone=1)
                	AND a.archived!=1 ' . $reviewedCondition . $sponsoredCondition . $whereProfile . '
                GROUP BY a.id
                ORDER BY ' . $sponsoredOrder . 'a.created_at DESC
                LIMIT 0,' . (int) $limit;
		$bindings = [
			'countryCode' => config('country.code'),
		];
		$bindings = array_merge($bindings, $bindings1);

		$cacheId = config('country.code') . '.home.getPosts.' . $type;
		$posts = Cache::remember($cacheId, $cacheExpiration, function () use ($sql, $bindings) {
			$posts = DB::select(DB::raw($sql), $bindings);

			return $posts;
		});

		// Append the Posts 'uri' attribute
		$posts = collect($posts)->map(function ($post) {
			$post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);

			return $post;
		})->toArray();

		return $posts;
	}

	/**
	 * @param array $options
	 * @return int
	 */
	private function getCacheExpirationTime($options = []) {
		// Get the default Cache Expiration Time
		$cacheExpiration = 0;
		if (isset($options['cache_expiration'])) {
			$cacheExpiration = (int) $options['cache_expiration'];
		}

		return $cacheExpiration;
	}



	// this function testing shoes size unit
	public function getShoesSizeUnitTest(Request $request){
		
		$category = $request->category;
	 	$gender =  $request->gender;
	 	// $country =  $request->country;

	 	// if($gender == 1){
	 	// 	$unit_code = $country.'_unit_men';
	 	// }else{
	 	// 	$unit_code = $country.'_unit_women';
	 	// }



	 	$data['tableKey'] = array('Germany', 'UK', 'US');

 	 	if($category == 4 || $category == 2){


 	 		// $unit_code = $country.'_unit_kids';
			$query = UserShoesUnitsOptions::select('standard_unit', 'uk_unit_kids', 'us_unit_kids');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_kids');
                $q->whereNotNull('us_unit_kids');
			});

			$result = $query->get();


			$data['valueKey'] = array('standard_unit', 'uk_unit_kids', 'us_unit_kids');
			$data['title'] = "K-I-D-S";
		}

		if($gender == 1 && $category != 4 && $category != 2){


			$query = UserShoesUnitsOptions::select('standard_unit', 'uk_unit_men', 'us_unit_men');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_men');
                $q->whereNotNull('us_unit_men');
			});

			$result = $query->get();


			$data['valueKey'] = array('standard_unit', 'uk_unit_men', 'us_unit_men');
			$data['title'] = "M-E-N";
		}


		if($gender == 2 && $category != 4 && $category != 2){


			$query = UserShoesUnitsOptions::select('standard_unit', 'uk_unit_women', 'us_unit_women');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_women');
                $q->whereNotNull('us_unit_women');
			});

			$result = $query->get();

			
			$data['valueKey'] = array('standard_unit', 'uk_unit_women', 'us_unit_women');
			$data['title'] = "W-O-M-E-N";
		}

		$data['selected_category'] = $category;
 	 	$data['selected_gender'] = $gender;
 	 	$data['result'] = $result;

	 	return view('shoe-size-units', $data);
	}

	public function getDressSizeUnitTest(Request $request){
		
		
		$category = $request->category;
	 	$gender =  $request->gender;

	 	$data['tableKey'] = array('Germany', 'UK', 'US');

 	 	if($category == 4 || $category == 2){


 	 		// $unit_code = $country.'_unit_kids';
			$query = UserDressSizeOptions::select('standard_unit', 'uk_unit_kids', 'us_unit_kids');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_kids');
                $q->whereNotNull('us_unit_kids');
			});

			$result = $query->get();


			$data['valueKey'] = array('standard_unit', 'uk_unit_kids', 'us_unit_kids');
			$data['title'] = "K-I-D-S";
		}

		if($gender == 1 && $category != 4 && $category != 2){


			$query = UserDressSizeOptions::select('standard_unit', 'uk_unit_men', 'us_unit_men');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_men');
                $q->whereNotNull('us_unit_men');
			});

			$result = $query->get();


			$data['valueKey'] = array('standard_unit', 'uk_unit_men', 'us_unit_men');
			$data['title'] = "M-E-N";
		}


		if($gender == 2 && $category != 4 && $category != 2){


			$query = UserDressSizeOptions::select('standard_unit', 'uk_unit_women', 'us_unit_women');

			$query->where(function ($q) {
				$q->whereNotNull('uk_unit_women');
                $q->whereNotNull('us_unit_women');
			});

			$result = $query->get();

			
			$data['valueKey'] = array('standard_unit', 'uk_unit_women', 'us_unit_women');
			$data['title'] = "W-O-M-E-N";
		}

 	 	$data['selected_category'] = $category;
 	 	$data['selected_gender'] = $gender;
 	 	$data['result'] = $result;

	 	return view('dress-size-units', $data);
	}

	// profile pic croping
	public function cropProfileImage(Request $request){
		
		$message = t('some error occurred');
		$imagename='';

		if(isset($request->image) && !empty($request->image)){

			$user_id = $request->user_id;

			// get user details
			$user = User::where('id', $user_id)->first();
			$image_array_1 = explode(";", $request->image);

	 	 	$extentionString = $image_array_1[0];

	 	 	$extentionArr = explode("/", $extentionString);

	 	 	$imageType = "png";
	 	 	
	 	 	// get extention Array
	 	 	if(isset($extentionArr[1])){

	 	 		$imageType = $extentionArr[1];
	 	 	}
	 	 	
	 	 	$image_array_2 = explode(",", $image_array_1[1]);
		 	
		 	$data = base64_decode($image_array_2[1]);

		 	// check image path is exist
		 	if(!Storage::exists('profile/logo/' . $user_id)){
				
				// create image directory
				Storage::makeDirectory('profile/logo/' . $user_id , 0775, true);
			}
			
			// set image name
			$imageName = 'profile/logo/'.$user_id.'/'.md5(microtime() . mt_rand()). '.'.$imageType;

			$old_image = $user->profile->logo;
			
			$user->profile->logo = $imageName;
			$user->profile->logo_updated_at = \Carbon\Carbon::now();
			$user->profile->save();

			$user->is_profile_pic_approve = 0;
			$user->save();
			
			// save image in folder 
			file_put_contents('uploads/'.$imageName, $data);

			// check old image exist
			if (isset($old_image) && $old_image !== "") {
				
				// already image exist unlink
				if (Storage::exists($old_image)) {
					
					unlink(public_path('uploads/'.$old_image));
				}
			}

			$req_arr = array(
				'action' => 'update', //required
				'wpusername' => $user->username, // required api
				'imglink' => \Storage::url(trim($user->profile->logo)),
			);

			// call crm Api
			$response = CommonHelper::go_call_request($req_arr);
			\Log::info('Request Array update', ['Request Array' => $req_arr]);
			
			$status = true;
			$message = t('profile picture has been uploaded successfully');

			$returnHTML = '<img id="output-partner-logo" src="'.Storage::url($imageName).'" alt="user" width="75%">';

			return response()->json(array('success' => true, 'html'=> $returnHTML, 'message' => $message,'imagename'=>$imageName));
		}else{
			
			$returnHTML = '<img id="output-partner-logo" src=""'.url(config('app.cloud_url').'/images/user.jpg').'" alt="user" >';
	 		
	 		return response()->json(array('success' => false, 'html'=> $returnHTML, 'error' => $message));
	 	}
	}

	// render flash messages with ajax request
	public function ajaxFlashMessage(){
		$returnHTML = view('ajax-flash-notifications')->render();
		return response()->json(array('success' => true, 'html'=> $returnHTML));
	}

	public function getRestrictPopup(Request $request){
		view()->share('is_ajax_request', true);
		$returnHTML = view('childs.premium-country-model')->render();
		return response()->json(array('success' => true, 'html'=> $returnHTML));
	}

	public function getGoRestrictPopup(Request $request){
		view()->share('is_ajax_request', true);
		$returnHTML = view('childs.premium')->render();
		return response()->json(array('success' => true, 'html'=> $returnHTML));
	}

	public function updatemaxminddb() {
		$maxmind_config =  config('geoip.maxmind');

		$config = [
		    'driver' => 'maxmind_database',
		    'maxmind' => [
		        'database' => $maxmind_config['database'],
		        'license_key' => $maxmind_config['license_key']
		    ],
		];
		// try{
		// 	(new GeoIPUpdater($config))->update();
		// }catch(Exception $e){
		// 	echo '<pre>';echo $e->getMessage();
		// }
		// the download URL for Maxmind database file

		$updMax = new MaxmindUpdate();
		$updMax->save_maxmind();

		echo "finish";
	}


	// public function getHeaderCountry(){

	// 	$data['country_code'] = (Auth::check() && isset( auth()->user()->country_code))? strtolower(auth()->user()->country_code) : config('country.icode');
	// 	$data['country_name'] = config('country.name');

	// 	$returnHTML = view('header_country', $data)->render();
	// 	return response()->json(array('success' => true, 'html'=> $returnHTML));
	// }

	public function getHeaderCountryListPopup(){
		
		$returnHTML = view('layouts/inc/modal/mfp-change-country')->render();
		return response()->json(array('success' => true, 'html'=> $returnHTML));
	}
}