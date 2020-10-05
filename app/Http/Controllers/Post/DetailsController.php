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

namespace App\Http\Controllers\Post;

use App\Events\PostWasVisited;
use App\Helpers\Arr;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Http\Controllers\FrontController;
use App\Http\Requests\SendMessageRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Message;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Resume;
use App\Models\SalaryType;
use App\Models\ExperienceType;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\ValidValue;
use App\Notifications\EmployerContacted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Jenssegers\Date\Date;
use Torann\LaravelMetaTags\Facades\MetaTag;

use Illuminate\Support\Facades\Validator;
use Response;

use App\Helpers\UnitMeasurement;
use App\Helpers\Search;
use App\Models\SavedPost;
use App\Models\JobApplication;
use App\Models\ReportType;
use App\Models\ModelCategory;
use Illuminate\Support\Facades\Gate;
// use App\Models\UserDressSizeOptions;

class DetailsController extends FrontController {
	/**
	 * Post expire time (in months)
	 *
	 * @var int
	 */
	public $expireTime = 24;

	/**
	 * DetailsController constructor.
	 */
	public function __construct() {
		parent::__construct();

		// $page_terms = $page_termsclient = array();
		// if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
		// 	foreach($this->pages as $page){
		// 		if($page->type == "terms"){
		// 			$page_terms = $page;
		// 		}elseif($page->type == "termsclient") {
		// 			$page_termsclient = $page;
		// 		}
		// 	}
		// }
		// view()->share('page_terms', $page_terms);
		// view()->share('page_termsclient', $page_termsclient);
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();

			return $next($request);
		});
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		// Check Country URL for SEO
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $countries);
	}

	/**
	 * Show Post's Details.
	 *
	 * @param $postId
	 * @return View
	 */
	public function index($postId) {

		
		
		$data = [];

		$prev_url = Request::server('HTTP_REFERER'); 

		if(empty($prev_url)){
			$prev_url = lurl(trans('routes.search', ['countryCode' => config('app.locale')]), ['countryCode' => config('app.locale')]);
		}else{

			$lastSegment = substr($prev_url, strrpos($prev_url, '/') + 1);

			if($lastSegment == t('create') || $lastSegment == t('edit')){
				$prev_url = lurl(trans('routes.search', ['countryCode' => config('app.locale')]), ['countryCode' => config('app.locale')]);
			}
		}

		session(['prev_url' => $prev_url]);

		// Get and Check the Controller's Method Parameters
		$parameters = Request::route()->parameters();

		// Show 404 error if the Post's ID is not numeric
		if (!isset($parameters['id']) || empty($parameters['id']) || !is_numeric($parameters['id'])) {
			abort(404);
		}

		// Set the Parameters
		$postId = $parameters['id'];
		if (isset($parameters['slug'])) {
			$slug = $parameters['slug'];
		}

		// $is_partner = Post::withoutGlobalScopes()->withTrashed()->where('user_id', Auth::user()->id)->where('id', $postId)->count();

		$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', $postId)->with(['user', 'pictures'])->first();

		$attr = ['countryCode' => config('app.locale')];

		if(empty($post)){
			//job does not exists. redirect back to job listing
			flash(t("This job is no longer available"))->error();
			return redirect(lurl(trans('routes.search', $attr), $attr));
		}
		
		if(isset($post) && $post->archived == 1 && $post->user_id != Auth::user()->id){
			//job does not exists. redirect back to job listing
			flash(t("This job is no longer available"))->error();
			return redirect(lurl(trans('routes.search', $attr), $attr));
		}

		if ($post->user_id != Auth::user()->id && Auth::user()->user_type_id == config('constant.model_type_id')  && Gate::allows('free_country_user', Auth::user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }


		$is_partner = 0;
		$is_invite_user = 0;

		if($post->user_id == Auth::user()->id){
			//post is added by logged in user
			$is_partner = 1;
		}

	 	if($is_partner == 0){

	 		$preSearch = app('App\Http\Controllers\Search\SearchController')->preSearchData('', '', $postId);

	        // Search
			$search = new Search($preSearch);
			$data = $search->fechAll();

			// Export Search Result
			$count = json_decode($data['count']);
			
			$user_id = Auth::user()->id;

			$is_invite_user = Message::where(function($query) use($user_id){
                return $query->where('from_user_id', $user_id)
                    ->orWhere('to_user_id', $user_id);
            })->where('post_id', $postId)->count();

			if(isset($count->all)){
				if($count->all == 0 && $is_invite_user == 0){
					return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
					// return abort(404);
				}
			}
	 	}

	 	$data['is_deleted'] = false;
	 	$data['application_is_closed'] = false;
 		if(isset($post->end_application) && !empty($post->end_application) && $post->end_application != ""){

			$deadline_date=$post->end_application;

			if(strtotime($deadline_date) < strtotime(date('Y-m-d')))
			{	
				$data['application_is_closed'] = true;
				flash(trans('validation.application_is_closed'))->error();
			}
		}

		// GET POST'S DETAILS
		if (Auth::check()) {
			// Get post's details even if it's not activated and reviewed
			// $cacheId = 'post.withoutGlobalScopes.with.user.city.pictures.' . $postId;
			// $post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($postId) {
			// 	$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();

			// 	return $post;
			// });

			// $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();


			// If the logged user is not an admin user...
			if (Auth::user()->is_admin != 1) {
				// Then don't get post that are not from the user
				if (!empty($post) && $post->user_id != Auth::user()->id) {

					// query repeat multipal times
					// $cacheId = 'post.with.user.city.pictures.' . $postId;
					// $post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($postId) {
					// 	$post = Post::unarchived()->where('id', $postId)->with(['user', 'pictures'])->first();

					// 	return $post;
					// });

					// If user is not invited then check the ismodel condition
					if(!$is_invite_user){

						if(Auth::user()->user_type_id == 3){
							if(isset($post->ismodel) && $post->ismodel == 0){
								return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
							}
						}

						if(Auth::user()->user_type_id == 2){
							if(isset($post->ismodel) && $post->ismodel == 1){
								return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
							}
						}
					}

				}
			}

			// Get the User's Resumes
			$limit = config('larapen.core.selectResumeInto', 5);
			$cacheId = 'resumes.take.' . $limit . '.where.user.' . Auth::user()->id;
			$resumes = Cache::remember($cacheId, $this->cacheExpiration, function () use ($limit) {
				$resumes = Resume::where('user_id', Auth::user()->id)->take($limit)->orderByDesc('id')->get();

				return $resumes;
			});
			view()->share('resumes', $resumes);

			// Get the User's latest Resume
			if ($resumes->has(0)) {
				$lastResume = $resumes->get(0);
				view()->share('lastResume', $lastResume);
			}
		} else {
			// $cacheId = 'post.with.user.city.pictures.' . $postId;
			// $post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($postId) {
			// 	$post = Post::withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();

			// 	return $post;
			// });
			// $post = Post::withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();
		}


		// query repeat multipal times
		// Preview the Post after activation
		// if (Request::filled('preview') && Request::input('preview') == 1) {
		// 	// Get post's details even if it's not activated and reviewed
		// 	$post = Post::withoutGlobalScopes()->where('id', $postId)->with(['user', 'pictures'])->first();
		// }

		// Post not found
		if (empty($post) && empty($post->city)) {
			// abort(404, t('Post not found'));
			return back()->withErrors(['error' => t("Post not found")]);
		}

		
		$post->preventAttrSet = true;
		$data['is_deleted'] = false;

		// check if post is archived or deleted then show the servie not availble message
		if ( $post->archived == 1 || $post->deleted_at != "" ) {
			flash(t("This job is no longer available"))->error();
			// check user is model or is a partner and not created user then redirect back  the page
			if( (Auth::user()->user_type_id == 2 && $post->user_id != Auth::user()->id) || Auth::user()->user_type_id == 3 ){
				return redirect()->back();
			}

			if($post->deleted_at != ""){
				$data['is_deleted'] = true;
			}
		}

		// Share post's details
		view()->share('post', $post);

		$property = [];

		$men_dress = '';
		$women_dress = '';
		$baby_dress = '';

		$men_shoe = '';
		$women_shoe = '';
		$baby_shoe = '';


		$is_dress_size = false;
		$is_shoe_size = false;
		
		 
		if($post->ismodel == 1){


			$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('ordering')->get();

			$categoryArr = array();
			$categoryArr['models_category'] = array();
			$categoryArr['babyModels_category'] = array();
			
			$i = 0;

	        if(!empty($modelCategories) && $modelCategories->count() > 0){

	        	foreach ($modelCategories as $key => $c) { 

	            	if($c->is_baby_model == 1){

	            		$categoryArr['babyModels_category'][$c->parent_id] = $c->name;
	            	}else{
	            		$categoryArr['models_category'][$c->parent_id] = $c->name;
	            	} 
	            }
	        }

	        $data['modelCategories'] = $modelCategories;
	        $data['is_models_category'] = $categoryArr['models_category'];
	        $data['is_babyModels_category'] = $categoryArr['babyModels_category'];


			$validValues = ValidValue::all();

			foreach ($validValues as $val) {
				$translate = $val->getTranslation(app()->getLocale());
				$property[$val->type][$val->id] = $translate->value;
			}

			$unitArr = new UnitMeasurement(Auth::user()->country_code);
			$unitoptions = $unitArr->getUnit(true);

			$dress_Size = $unitArr->getDressSizeByPost();
			$shoe_Size = $unitArr->getShoeSizeByPost();

			$property = array_merge($property, $unitoptions);

			// get baby dress size
			if(!empty($post->dress_size_baby)){
				
				$dress_size_baby = explode(',', $post->dress_size_baby);

				if(count($dress_Size['baby_dress']) > 0){

					foreach ($dress_size_baby as $key => $val) {

						if(array_key_exists($val, $dress_Size['baby_dress'])){

							$baby_dress .= $dress_Size['baby_dress'][$val].', ';
						}
					}
				}
			}

			// dress men size array
			if(!empty($post->dress_size_men)){
				
				$dress_size_men = explode(',', $post->dress_size_men);

				if(count($dress_Size['men_dress']) > 0){

					foreach ($dress_size_men as $key => $val) {

						if(array_key_exists($val, $dress_Size['men_dress'])){

							$men_dress .= $dress_Size['men_dress'][$val].', ';
						}
					}
				}
			}

			// get women dress size
			if(!empty($post->dress_size_women)){
				
				$dress_size_women = explode(',', $post->dress_size_women);
				
				if(count($dress_Size['women_dress']) > 0){
					 
					foreach ($dress_size_women as $key => $val) {

						if(array_key_exists($val, $dress_Size['women_dress'])){

							$women_dress .= $dress_Size['women_dress'][$val].', ';
						}
					}
				}
			}

			if(!empty($baby_dress) || !empty($men_dress) || !empty($women_dress)){
				$is_dress_size = true;
			}

			// get baby shoe size
			if(!empty($post->shoe_size_baby)){
				
				$shoe_size_baby = explode(',', $post->shoe_size_baby);

				if(count($shoe_Size['baby_shoe']) > 0){

					foreach ($shoe_size_baby as $key => $val) {

						if(array_key_exists($val, $shoe_Size['baby_shoe'])){

							$baby_shoe .= $shoe_Size['baby_shoe'][$val].', ';
						}
					}
				}
			}

			$modelCatArr = array();
         	
         	if(!empty($post->model_category_id)){
         		$modelCatArr = explode(',', $post->model_category_id);
         	}
			
			$is_model_cat = false;
     	 	$is_baby_model_cat = false;

     	 	if(count($modelCatArr) > 0){
     			
     			foreach ($modelCatArr as $key => $val) {
     				
     				if(isset($data['is_babyModels_category'][$val])){
     					$is_baby_model_cat = true;
     				}else{
     					$is_model_cat = true;
     				}
     			}
     		}

			if( empty($baby_shoe) && $is_baby_model_cat == true){
				$baby_shoe = t('All');
			}
			
			// get men shoe size
			if(!empty($post->shoe_size_men)){
				
				$shoe_size_men = explode(',', $post->shoe_size_men);

				if(count($shoe_Size['men_shoe']) > 0){

					foreach ($shoe_size_men as $key => $val) {

						if(array_key_exists($val, $shoe_Size['men_shoe'])){

							$men_shoe .= $shoe_Size['men_shoe'][$val].', ';
						}
					}
				}
			}

			// if($post->is_baby_model != 1 && empty($men_shoe) && ($post->gender_type_id == config('constant.gender_male') || $post->gender_type_id == config('constant.gender_both'))) {
			// 	$men_shoe = t('All');
			// }

			if($is_model_cat == true && empty($men_shoe) && ($post->gender_type_id == config('constant.gender_male') || $post->gender_type_id == config('constant.gender_both'))) {
				$men_shoe = t('All');
			}

			// get women shoe size
			if(!empty($post->shoe_size_women)){
				
				$shoe_size_women = explode(',', $post->shoe_size_women);

				if(count($shoe_Size['women_shoe']) > 0){

					foreach ($shoe_size_women as $key => $val) {

						if(array_key_exists($val, $shoe_Size['women_shoe'])){

							$women_shoe .= $shoe_Size['women_shoe'][$val].', ';
						}
					}
				}
			}

			// if($post->is_baby_model != 1 && empty($women_shoe) && ($post->gender_type_id == config('constant.gender_female') || $post->gender_type_id == config('constant.gender_both'))) {
			// 	$women_shoe = t('All');
			// }
			if($is_model_cat == true && empty($women_shoe) && ($post->gender_type_id == config('constant.gender_female') || $post->gender_type_id == config('constant.gender_both'))) {
				$women_shoe = t('All');
			}

			if(!empty($baby_shoe) || !empty($men_shoe) || !empty($women_shoe)){
				$is_shoe_size = true;
			}

			if ($post->height_from > 0 && $post->height_to > 0) {
				if (!empty($property['height'][$post->height_from]) && !empty($property['height'][$post->height_to])) {
					$data['height'] = $property['height'][$post->height_from] . ' - ' . $property['height'][$post->height_to];
				}
			}

			if (isset($post->weight_from) && $post->weight_from > 0 && isset($post->weight_to) && $post->weight_to > 0) {
				if (!empty($property['weight'][$post->weight_from]) && !empty($property['weight'][$post->weight_to])) {
					$data['weight'] = $property['weight'][$post->weight_from] . ' - ' . $property['weight'][$post->weight_to];
				}

			}

			//get dress size according to partner country
			/*if(isset(Auth::user()->country) && isset(Auth::user()->country->dress_size_unit)) {
	            $dress_unit = Auth::user()->country->dress_size_unit;
	        }
	        $data['dressSize'] = $post->dressSizeOption_from[$dress_unit.'_unit'] . ' - ' . $post->dressSizeOption_to[$dress_unit.'_unit'];
	        */

			if ($post->dressSize_from > 0 && $post->dressSize_to > 0) {
				if (!empty($property['dress_size'][$post->dressSize_from]) && !empty($property['dress_size'][$post->dressSize_to])) {
					$data['dressSize'] = $property['dress_size'][$post->dressSize_from] . ' - ' . $property['dress_size'][$post->dressSize_to];
				}
			}

			if ($post->age_from > 0 && $post->age_to > 0) {
				if (!empty($post->age_from) && !empty($post->age_to)) {
					
					// age from label, month or year
					if($post->age_from == 1){
						$age_from_label = t('year');
					}else if($post->age_from == 0.01){
						$age_from_label = t('month');
					}else if ($post->age_from > 1) {
						$age_from_label = t('years');
					}else{
						$age_from_label = t('months');
					}

					// age to label, month or year
					if($post->age_to == 1){
						$age_to_label = t('year');
					}else if($post->age_to == 0.01){
						$age_to_label = t('month');
					}else if ($post->age_to > 1) {
						$age_to_label = t('years');
					}else{
						$age_to_label = t('months');
					}

					$from_age = $post->age_from;
					$to_age = $post->age_to;
					
					if($from_age == 0.1){$from_age = number_format($from_age, 2);}
					if($to_age == 0.1){$to_age = number_format($to_age, 2);}

					$from_age = ltrim(substr($from_age, strpos($from_age, '.')), ".0");
					$to_age = ltrim(substr($to_age, strpos($to_age, '.')), ".0");
					$data['age'] = $from_age .' '. $age_from_label . ' - ' . $to_age . ' '.$age_to_label;
				}
			}

			if (isset($post->chest_from) && $post->chest_from > 0 && isset($post->chest_to) && $post->chest_to > 0) {
				if (!empty($property['chest'][$post->chest_from]) && !empty($property['chest'][$post->chest_to])) {
					$data['chest'] = $property['chest'][$post->chest_from] . ' - ' . $property['chest'][$post->chest_to];
				}
			}

			if (isset($post->waist_from) && $post->waist_from > 0 && isset($post->waist_to) && $post->waist_to > 0) {
				if (!empty($property['waist'][$post->waist_from]) && !empty($property['waist'][$post->waist_to])) {
					$data['waist'] = $property['waist'][$post->waist_from] . ' - ' . $property['waist'][$post->waist_to];
				}
			}

			if (isset($post->hips_from) && $post->hips_from > 0 && isset($post->hips_to) && $post->hips_to > 0) {
				if (!empty($property['hips'][$post->hips_from]) && !empty($property['hips'][$post->hips_to])) {
					$data['hips'] = $property['hips'][$post->hips_from] . ' - ' . $property['hips'][$post->hips_to];
				}
			}


			/*if($post->chest_from > 0 || $post->chest_to){
				$chest = '';

				if($post->chest_from > 0 ){
					$chest .= $post->chest_from;
				}

				if($post->chest_from > 0 && $post->chest_to > 0 ){
					$chest .= ' - '.$post->chest_to;
				}else{
					$chest .= $post->chest_to;
				}

				$data['chest'] = $chest;
			}*/

			/*if($post->waist_from > 0 || $post->waist_to){
				$waist = '';

				if($post->waist_from > 0 ){
					$waist .= $post->waist_from;
				}

				if($post->waist_from > 0 && $post->waist_to > 0 ){
					$waist .= ' - '.$post->waist_to;
				}else{
					$waist .= $post->waist_to;
				}

				$data['waist'] = $waist;
			}*/

			/*if($post->hips_from > 0 || $post->hips_to){
				$hips = '';

				if($post->hips_from > 0 ){
					$hips .= $post->hips_from;
				}

				if($post->hips_from > 0 && $post->hips_to > 0 ){
					$hips .= ' - '.$post->hips_to;
				}else{
					$hips .= $post->hips_to;
				}

				$data['hips'] = $hips;
			}*/

			if($post->shoeSize_from > 0 || $post->shoeSize_to){
				$shoeSize = '';

				if($post->shoeSize_from > 0 ){
					$shoeSize .= $post->shoeSize_from;
				}

				if($post->shoeSize_from > 0 && $post->shoeSize_to > 0 ){
					$shoeSize .= ' - '.$post->shoeSize_to;
				}else{
					$shoeSize .= $post->shoeSize_to;
				}

				$data['shoeSize'] = $shoeSize;
			}
		}

		$data['men_shoe'] = $men_shoe;
		$data['women_shoe'] = $women_shoe;
		$data['baby_shoe'] = $baby_shoe;

		$data['men_dress'] = $men_dress;
		$data['women_dress'] = $women_dress;
		$data['baby_dress'] = $baby_dress;

		$data['is_dress_size'] = $is_dress_size;
		$data['is_shoe_size'] = $is_shoe_size;
		
		// Get category details
		$getCategory = array();
		if(isset($post->category_id) && !empty($post->category_id)){
			$cat_ids = explode(',',$post->category_id);

			if(count($cat_ids) > 0 ){
				foreach ($cat_ids as $kid => $vid) {
					
					$cacheId = 'category.' . $vid . '.' . config('app.locale');
					$getCategory = Cache::remember($cacheId, $this->cacheExpiration, function () use ($vid) {
						$cat = Category::transById($vid);
						return $cat;
					});
					if(!empty($getCategory))
						$cat[] = $getCategory;
				}
			}
		}

		// if(count($cat) > 0 ){
		// 	$parentCat = array();
		// 	foreach ($cat as $key => $value) {
		// 		$parentCat[] = $value->name;
		// 	}
		// 	if(count($parentCat) > 0 ){
		// 		$parentCat = implode(',', $parentCat);
		// 	}
		// }

		// Get experience type details
		// properties
		// $property = [];
		// $validValues = ValidValue::all();
		// foreach ($validValues as $val) {
		// 	$translate = $val->getTranslation(app()->getLocale());
		// 	$property[$val->type][$val->id] = (!empty($translate->value)) ? $translate->value : '';
		// }

		//$unitArr = UnitMeasurement::getUnitMeasurement();
		//$property = array_merge($property, $unitArr);

		// $unitArr = new UnitMeasurement();
		// $unitoptions = $unitArr->getUnit(true);
		// $property = array_merge($property, $unitoptions);

		$data['properties'] = $property;

		// echo "<pre>"; print_r ($property); echo "</pre>"; exit();
		$experienceType = '';
		$experienceTypeDetail = ExperienceType::where('id', $post->experience_type_id)->first();
		if (!empty($experienceTypeDetail)) {
			$experienceType = $experienceTypeDetail->name;
		}
		view()->share('experienceType', $experienceType);

		view()->share('cat', $cat);
		
		// Get post type details
		$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
		$postType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
			$postType = PostType::transById($post->post_type_id);

			return $postType;
		});
		view()->share('postType', $postType);

		// Get the Post's Salary Type
		$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
		$salaryType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
			$salaryType = SalaryType::transById($post->salary_type_id);

			return $salaryType;
		});
		view()->share('salaryType', $salaryType);

		// Require info
		
		if (empty($cat)) {
			$message = t("Something went wrong Please try again");
			if($post->user_id == Auth::user()->id){
				$message = t("Please update your job categories");
			}
			return back()->withErrors(['error' => $message]);
		}

		if (empty($postType)) {
			$message = t("Something went wrong Please try again");
			if($post->user_id == Auth::user()->id){
				$message = t("Please update your post type");
			}
			return back()->withErrors(['error' => $message]);
		}

		// Get package details
		$package = null;
		if ($post->featured == 1) {
			$payment = Payment::where('post_id', $post->id)->orderBy('id', 'DESC')->first();
			if (!empty($payment)) {
				$package = Package::transById($payment->package_id);
			}
		}
		view()->share('package', $package);

		// Get ad's user decision about comments activation
		$commentsAreDisabledByUser = false;
		// Get possible ad's user
		if (isset($post->user_id) && !empty($post->user_id)) {
			$possibleUser = User::find($post->user_id);
			if (!empty($possibleUser)) {
				if ($possibleUser->disable_comments == 1) {
					$commentsAreDisabledByUser = true;
				}
			}
		}
		view()->share('commentsAreDisabledByUser', $commentsAreDisabledByUser);

		// GET PARENT CATEGORY
		// if ($cat->parent_id == 0) {
		// 	$parentCat = $cat;
		// } else {
		// 	$parentCat = Category::transById($cat->parent_id);
		// }

		// if($parentCat == ''){
		// 	$parentCat = "";
		// }

		// view()->share('parentCat', $parentCat);

		// Increment Post visits counter
		Event::dispatch(new PostWasVisited($post));

		// GET SIMILAR POSTS
		// $featured = $this->getCategorySimilarPosts($cat, $post->id);
		// $featured = $this->getLocationSimilarPosts($post->city, $post->id);
		// $data['featured'] = $featured;

		// SEO
		$post_city = '';
		if(isset($post->city) && !empty($post->city)){
			$post_city = $post->city;
		}
		$title = $post->title . ', ' . $post_city;
		$description = str_limit(str_strip(strip_tags($post->description)), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		if (!empty($post->tags)) {
			MetaTag::set('keywords', str_replace(',', ', ', $post->tags));
		}

		// Open Graph
		// $this->og->title($title)
		// 	->description($description)
		// 	->type('article')
		// 	->image(Storage::url('/images/img-logo.png'));
		// 	// ->article(['author' => config('settings.social_link.facebook_page_url')]);
		// 	// ->article(['publisher' => config('settings.social_link.facebook_page_url')]);
		// if (!$post->pictures->isEmpty()) {
		// 	if ($this->og->has('image')) {
		// 		$this->og->forget('image')->forget('image:width')->forget('image:height');
		// 	}
		// 	foreach ($post->pictures as $picture) {
		// 		$this->og->image(resize($picture->filename, 'large'), [
		// 			'width' => 600,
		// 			'height' => 600,
		// 		]);
		// 	}
		// }
		// view()->share('og', $this->og);

		$data['og_seo_tags'] = array(
								'og:title' => $title,
								'og:description' => $description,
								'og:type' => 'article',
								'og:image' => url('/images/logo-fb.png'),
								'og:image:alt' => config('app.app_name')
							);
		// Check post is expired or not
		$data['is_expired'] = false;

		if(isset($post->end_application) && !empty($post->end_application) && $post->deleted_at === "" && $post->archived == 0){
			
			$current_date = new \DateTime('Today');
			$expire_date = new \DateTime($post->end_application);

			
			if ($current_date > $expire_date) {
			   flash(t("Warning! This ad has expired, The product or service is not more available (may be)"))->error();
			   $data['is_expired'] = true;
			}
		}

		// Expiration Info
		$today_dt = Date::now(config('timezone.id'));
		// if ($today_dt->gt($post->created_at->addMonths($this->expireTime))) {
		// 	flash(t("Warning! This ad has expired, The product or service is not more available (may be)"))->error();
		// }



		$data['userCountry'] = CountryLocalization::getCountryNameByCode($post->user->country_code);

		// $data['is_applyed']

		// $JobApplicationCount = JobApplication::where('post_id', $post->id)->where('user_id', Auth::user()->id)->count();

		/*$data['is_applyed'] = Post::SELECT('posts.*')
                ->leftjoin('job_applications', 'job_applications.post_id','posts.id')
                ->where('job_applications.user_id', Auth::User()->id)
                ->where('job_applications.post_id', $post->id)->count();*/


        // check in message to user applied for job
        $data['is_applyed'] = $data['userinvitaiton'] = '';

        $is_applied = Message::where('post_id', $post->id)->where('from_user_id', Auth::User()->id)->where('message_type', 'Job application')->first();

        $data['message_url'] = "";

        if( isset($is_applied) && !empty($is_applied) && $is_applied->count() > 0){
        	$data['is_applyed'] = 1;
        	$data['message_url'] = lurl('account/conversations/'.$is_applied->id.'/messages');
        }
		
		$userinvitaiton = Message::wherehas('post', function($query){
                				$query->where('archived', 0);
            				})
							->where('post_id', $post->id)
							->where('to_user_id', Auth::user()->id)
							->where('message_type','Invitation')
							->whereIn('invitation_status', ['0','1'])->first();

		$data['is_invited'] = 0;
		$data['invitation'] = "";

		if(isset($userinvitaiton) && !empty($userinvitaiton)){
			$data['is_invited'] = 1;
			$data['invitation'] = $userinvitaiton;

			// if invitation is accepted 
			if($userinvitaiton->invitation_status == 1){ 
				$data['message_url'] = lurl('account/conversations/'.$userinvitaiton->id.'/messages');
			}
		}

		$data['is_advertising'] = false;
		if (\App\Models\Advertising::where('slug', 'top')->count() > 0) {
			$data['is_advertising'] = true;
		}
		
		$is_save_Post = 0;
		 
		if($post->user_id != auth()->user()->id){
			$is_save_Post =  SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count();
		} 


		// Get Report abuse types
		$reportTypes = ReportType::trans()->get();
		$data['reportTypes'] = $reportTypes;
		$data['title'] = t('Report for :title', ['title' => ucfirst($post->title)]);
		$description = t('Send a report for :title', ['title' => ucfirst($post->title)]);

		$data['is_save_Post'] = $is_save_Post;
		// $data['is_contract_expire'] = $is_contract_expire;
		// View

		view()->share('uriPathPageId', $postId);
		
		return view('post.details', $data);
	}
	public function sharePostDetail($postId,$slug)
	{
		$data = [];

		// Get and Check the Controller's Method Parameters
		$parameters = Request::route()->parameters();
		
		// Show 404 error if the Post's ID is not numeric
		if (!isset($parameters['id']) || empty($parameters['id']) || !is_numeric($parameters['id'])) {
			abort(404);
		}

		// Set the Parameters
		$postId = $parameters['id'];
		if (isset($parameters['slug'])) {
			$slug = $parameters['slug'];
		}

		$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', $postId)->with(['user', 'pictures'])->first();

		$attr = ['countryCode' => config('app.locale')];

		if(empty($post)){

			//job does not exists. redirect back to job listing
			flash(t("This job is no longer available"))->error();
			return redirect(lurl(trans('routes.search', $attr), $attr));
		}
		if(Auth::check())
		{
			return redirect(lurl($post->uri));
		}
		if($post->archived)
		{
			flash(t("This job is no longer available"))->error();
			return redirect(config('app.locale'));
		}

	 	$data['is_deleted'] = false;
	 	$data['application_is_closed'] = false;
 		if(isset($post->end_application) && !empty($post->end_application) && $post->end_application != ""){

			$deadline_date=$post->end_application;

			if(strtotime($deadline_date) < strtotime(date('Y-m-d')))
			{	
				$data['application_is_closed'] = true;
				flash(trans('validation.application_is_closed'))->error();
			}
		}
		$data['is_advertising'] = false;
		if (\App\Models\Advertising::where('slug', 'top')->count() > 0) {
			$data['is_advertising'] = true;
		}

		// Post not found
		if (empty($post) && empty($post->city)) {
			// abort(404, t('Post not found'));
			return back()->withErrors(['error' => t("Post not found")]);
		}

		
		$post->preventAttrSet = true;
		$data['is_deleted'] = false;

		// check if post is archived or deleted then show the servie not availble message
		if ( $post->archived == 1 || $post->deleted_at != "" ) {
			flash(t("This job is no longer available"))->error();
			if($post->deleted_at != ""){
				$data['is_deleted'] = true;
			}
		}

		// Share post's details
		view()->share('post', $post);

		
		
		// Get category details
		$getCategory = array();
		if(isset($post->category_id) && !empty($post->category_id)){
			$cat_ids = explode(',',$post->category_id);

			if(count($cat_ids) > 0 ){
				foreach ($cat_ids as $kid => $vid) {
					
					$cacheId = 'category.' . $vid . '.' . config('app.locale');
					$getCategory = Cache::remember($cacheId, $this->cacheExpiration, function () use ($vid) {
						$cat = Category::transById($vid);
						return $cat;
					});
					if(!empty($getCategory))
						$cat[] = $getCategory;
				}
			}
		}


		view()->share('cat', $cat);
		
		// Get post type details
		$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
		$postType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
			$postType = PostType::transById($post->post_type_id);

			return $postType;
		});
		view()->share('postType', $postType);

		// Get the Post's Salary Type
		$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
		$salaryType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
			$salaryType = SalaryType::transById($post->salary_type_id);

			return $salaryType;
		});
		view()->share('salaryType', $salaryType);

		// Require info
		
		if (empty($cat)) {
			$message = t("Something went wrong Please try again");
			return back()->withErrors(['error' => $message]);
		}

		if (empty($postType)) {
			$message = t("Something went wrong Please try again");
			return back()->withErrors(['error' => $message]);
		}


		// SEO
		$post_city = '';
		if(isset($post->city) && !empty($post->city)){
			$post_city = $post->city;
		}
		$title = $post->title . ', ' . $post_city;
		$description = str_limit(str_strip(strip_tags($post->description)), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		if (!empty($post->tags)) {
			MetaTag::set('keywords', str_replace(',', ', ', $post->tags));
		}

		// Open Graph
		// $this->og->title($title)
		// 	->description($description)
		// 	->type('article');
		// 	// ->article(['author' => config('settings.social_link.facebook_page_url')]);
		// 	// ->article(['publisher' => config('settings.social_link.facebook_page_url')]);
		// if (!$post->pictures->isEmpty()) {
		// 	if ($this->og->has('image')) {
		// 		$this->og->forget('image')->forget('image:width')->forget('image:height');
		// 	}
		// 	foreach ($post->pictures as $picture) {
		// 		$this->og->image(resize($picture->filename, 'large'), [
		// 			'width' => 600,
		// 			'height' => 600,
		// 		]);
		// 	}
		// }
		// view()->share('og', $this->og);
		$data['og_seo_tags'] = array(
								'og:title' => $title,
								'og:description' => $description,
								'og:type' => 'article',
								'og:image' => url('/images/logo-fb.png'),
								'og:image:alt' => config('app.app_name')
							);

		// Check post is expired or not
		$data['is_expired'] = false;

		if(isset($post->end_application) && !empty($post->end_application) && $post->deleted_at === "" && $post->archived == 0){
			
			$current_date = new \DateTime('Today');
			$expire_date = new \DateTime($post->end_application);

			
			if ($current_date > $expire_date) {
			   flash(t("Warning! This ad has expired, The product or service is not more available (may be)"))->error();
			   $data['is_expired'] = true;
			}
		}

		// Expiration Info
		$today_dt = Date::now(config('timezone.id'));

		$data['userCountry'] = CountryLocalization::getCountryNameByCode($post->user->country_code);
		
		// View
		return view('post.shareDetails', $data);
	
	}

	/**
	 * @param $postId
	 * @param SendMessageRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendMessage($postId, Request $request) {

		$rules = (new \App\Http\Requests\SendMessageRequest)->rules();

		$validator = Validator::make($request::all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails())
		{
		    return array(
		        'success' => false,
		        'errors' => $validator->getMessageBag()->toArray()

		    );
		    exit();
		}

		$this->middleware('auth', ['only' => ['sendMessage']]);

		// Get the Post
		$post = Post::unarchived()->findOrFail($postId);
		
		if(!empty($post))
		{

			//check if application is expired or not
			if(isset($post->end_application) && !empty($post->end_application) && $post->end_application != ""){

				$deadline_date=$post->end_application;

				if(strtotime($deadline_date) < strtotime(date('Y-m-d')))
				{
					return array(
				        'success' => false,
				        'errors' => trans('validation.application_is_closed')
				    );
				    exit();
					 
				}
			}
			
			$is_invited = Message::where('post_id', $post->id)->where('to_user_id', Auth::user()->id)->whereIn('invitation_status', ['0', '1'])->first();

			if( isset($is_invited) && !empty($is_invited) ){

				// Invitation is not accepted
				if( $is_invited->invitation_status === '0' ){

					$accept_url = '<a href="'.url("/account/invtresp/1/$is_invited->id").'">'.trans('Accept').'</a>';
					$reject_url = '<a href="'.url("/account/invtresp/2/$is_invited->id").'">'.trans('Reject').'</a>';

					$msg = trans('You are already invited for this job').' <br /> '.t('Click here to :accept or :reject the invitation', ['accept' => $accept_url, 'reject' => $reject_url]);

					

					return array('success' => true,'message' => $msg, 'invitation_id' => $is_invited->id); exit();
				}

				// If Inviation is already accepted
				if( $is_invited->invitation_status === '1' ) {

					// Invitation is accepted
					return array(
				        'success' => false,
				        'errors' => trans('You have accepted the invitation')
				    );
				    exit();

				}
			}


			//check if user already apply for the same job
			$is_applied = Message::where('post_id', $post->id)->where('from_user_id', Auth::user()->id)->where('invitation_status', '1')->first();

			if( isset($is_applied) && !empty($is_applied) ){
				return array('success' => false,'errors' => trans('You have already applied for this job') );
			    exit();
			}
		}

		// comment code file upload in mail send
		// if (!empty($request::file())) {
		
		// 	$Path = 'specials/' . Auth::user()->id;
		// 	Storage::makeDirectory($Path);
		// 	$destinationPath = 'uploads/' . $Path;
		// 	$attach = $Path . '?';
		// 	$time = date('ymdhis');

		// 	for ($i = 0; $i < 5; $i++) {
		// 		$filename = 'special.filename' . $i;
		// 		$file = $request::file($filename);
		// 		if ($file) {
		// 			$fname = $time.$file->getClientOriginalName();
		// 			$file->move($destinationPath, $fname);
		// 			$attach .= 'img' . $i . '=' . $fname . '&';
		// 		}
		// 	}
		// 	$filedata = lurl($attach);
		// } else {
		// 	$filedata = null;
		// }

		$filedata = null;

		// Store Message
		$message = new Message([
			'post_id' => $post->id,
			'from_user_id' => Auth::check() ? Auth::user()->id : 0,
			'from_name' => $request::input('name'),
			'from_email' => $request::input('email'),
			'from_phone_code' => $request::input('phone_code'),
			'from_phone' => $request::input('phone'),
			'to_user_id' => $post->user_id,
			'to_name' => (isset($post->user->profile))? $post->user->profile->full_name : $post->contact_name,
			'to_email' => $post->email,
			'to_phone_code' => $post->phone_code,
			'to_phone' => $post->phone,
			// 'subject' => $post->title,
			'subject' => trans('mail.apply_for_job'),
			'message' => $request::input('message')
			. '<br><br>'
			. t('Related to the ad')
			. ': <a href="' . lurl($post->uri) . '">' . t('Click here to see') . '</a>',
			'filename' => "",
			'message_type' => 'Job application',
			'invitation_status' => '1'
		]);
		$message->save();

		// added message on apply job
		$newMessage = [
			'post_id' => $post->id,
			'parent_id' => $message->id,
			'from_user_id' => Auth::check() ? Auth::user()->id : 0,
			'from_name' => $request::input('name'),
			'from_email' => $request::input('email'),
			'from_phone_code' => $request::input('phone_code'),
			'from_phone' => $request::input('phone'),
			'to_user_id' => $post->user_id,
			'to_name' => (isset($post->user->profile))? $post->user->profile->first_name : $post->contact_name,
			'to_email' => $post->email,
			'to_phone_code' => $post->phone_code,
			'to_phone' => $post->phone,
			'subject' => trans('mail.apply_for_job'),
			'message' => $request::input('message'),
			'message_type' => 'Conversation',
			'filename' => $filedata

		];
		$add_message = new Message($newMessage);
		$add_message->save();

		//create entry in job_applications table
		$jobApplication = New JobApplication();
		$jobApplication->post_id = $post->id;
		$jobApplication->user_id = Auth::check() ? Auth::user()->id : 0;
		$jobApplication->status = 1;
		$jobApplication->save();

		
		$partnername = (isset($post->user->username))? $post->user->username : $post->user->profile->full_name;
		// Send a message to publisher
		try {
			$post->notify(new EmployerContacted($post, $add_message));

			//$msg = t("Your message has sent successfully to :contact_name", ['contact_name' => $post->contact_name]);

			$msg = t('Your application has sent successfully');
			$url = lurl('account/conversations/'.$message->id.'/messages');
			
			return array('success' => true,'message' => $msg, 'url' => $url); exit();
			
		} catch (\Exception $e) {
			flash($e->getMessage())->error();

			return array(
		        'success' => false,
		        'errors' => $e->getMessage()

		    );
		    exit();
		}

		return redirect(config('app.locale') . '/' . $post->uri);
	}

	/**
	 * Get similar Posts (Posts in the same Category)
	 *
	 * @param $cat
	 * @param int $currentPostId
	 * @return array|null|\stdClass
	 */
	private function getCategorySimilarPosts($cat, $currentPostId = 0) {
		$limit = 20;
		$featured = null;

		// Get the sub-categories of the current ad parent's category
		$similarCatIds = [];

		if (!empty($cat)) {

			if( count($cat) > 0 ){
				foreach ($cat as $key => $cat) {
					
					if ($cat->tid == $cat->parent_id) {
						$similarCatIds[] = $cat->tid;
					} else {
						if (!empty($cat->parent_id)) {
							$similarCatIds = Category::trans()->where('parent_id', $cat->parent_id)->get()->keyBy('id')->keys()->toArray();
							$similarCatIds[] = (int) $cat->parent_id;
						} else {
							$similarCatIds[] = (int) $cat->tid;
						}
					}
				}
			}
		}

		// Get ads from same category
		$posts = [];
		if (!empty($similarCatIds)) {
			if (count($similarCatIds) == 1) {
				$similarPostSql = 'AND a.category_id=' . ((isset($similarCatIds[0])) ? (int) $similarCatIds[0] : 0) . ' ';
			} else {
				$similarPostSql = 'AND a.category_id IN (' . implode(',', $similarCatIds) . ') ';
			}
			$reviewedPostSql = '';
			if (config('settings.single.posts_review_activation')) {
				$reviewedPostSql = ' AND a.reviewed = 1';
			}
			$sql = 'SELECT a.* ' . '
				FROM ' . table('posts') . ' as a
				WHERE a.country_code = :countryCode ' . $similarPostSql . '
					AND (a.verified_email=1 AND a.verified_phone=1)
					AND a.archived!=1
					AND a.deleted_at IS NULL ' . $reviewedPostSql . '
					AND a.id != :currentPostId
				ORDER BY a.id DESC
				LIMIT 0,' . (int) $limit;
			$bindings = [
				'countryCode' => config('country.code'),
				'currentPostId' => $currentPostId,
			];

			$cacheId = 'posts.similar.category.' . $cat->tid . '.post.' . $currentPostId;
			$posts = Cache::remember($cacheId, $this->cacheExpiration, function () use ($sql, $bindings) {
				try {
					$posts = DB::select(DB::raw($sql), $bindings);
				} catch (\Exception $e) {
					return [];
				}

				return $posts;
			});
		}

		if (count($posts) > 0) {
			// Append the Posts 'uri' attribute
			$posts = collect($posts)->map(function ($post) {
				$post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);

				return $post;
			})->toArray();

			// Randomize the Posts
			$posts = collect($posts)->shuffle()->toArray();

			// Featured Area Data
			$featured = [
				'title' => t('Similar Jobs'),
				'link' => qsurl(config('app.locale') . '/' . trans('routes.v-search', ['countryCode' => config('country.icode')]), array_merge(Request::except('c'), ['c' => $cat->tid])),
				'posts' => $posts,
			];
			$featured = Arr::toObject($featured);
		}

		return $featured;
	}

	/**
	 * Get Posts in the same Location
	 *
	 * @param $city
	 * @param int $currentPostId
	 * @return array|null|\stdClass
	 */
	private function getLocationSimilarPosts($city, $currentPostId = 0) {
		$distance = 50; // km
		$limit = 20;
		$carousel = null;

		if (!empty($city)) {
			// Get ads from same location (with radius)
			$reviewedPostSql = '';
			if (config('settings.single.posts_review_activation')) {
				$reviewedPostSql = ' AND a.reviewed = 1';
			}
			$sql = 'SELECT a.*, 3959 * acos(cos(radians(' . $city->latitude . ')) * cos(radians(a.lat))'
			. '* cos(radians(a.lon) - radians(' . $city->longitude . '))'
			. '+ sin(radians(' . $city->latitude . ')) * sin(radians(a.lat))) as distance
				FROM ' . table('posts') . ' as a
				INNER JOIN ' . table('categories') . ' as c ON c.id=a.category_id AND c.active=1
				WHERE a.country_code = :countryCode
					AND (a.verified_email=1 AND a.verified_phone=1)
					AND a.archived!=1
					AND a.deleted_at IS NULL ' . $reviewedPostSql . '
					AND a.id != :currentPostId
				HAVING distance <= ' . $distance . '
				ORDER BY distance ASC, a.id DESC
				LIMIT 0,' . (int) $limit;
			$bindings = [
				'countryCode' => config('country.code'),
				'currentPostId' => $currentPostId,
			];

			$cacheId = 'posts.similar.city.' . $city->id . '.post.' . $currentPostId;
			$posts = Cache::remember($cacheId, $this->cacheExpiration, function () use ($sql, $bindings) {
				try {
					$posts = DB::select(DB::raw($sql), $bindings);
				} catch (\Exception $e) {
					return [];
				}

				return $posts;
			});

			if (count($posts) > 0) {
				// Append the Posts 'uri' attribute
				$posts = collect($posts)->map(function ($post) {
					$post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);

					return $post;
				})->toArray();

				// Randomize the Posts
				$posts = collect($posts)->shuffle()->toArray();

				// Featured Area Data
				$carousel = [
					'title' => t('More jobs at :distance :unit around :city', [
						'distance' => $distance,
						'unit' => unitOfLength(config('country.code')),
						'city' => $city->name,
					]),
					'link' => qsurl(config('app.locale') . '/' . trans('routes.v-search', ['countryCode' => config('country.icode')]), array_merge(Request::except(['l', 'location']), ['l' => $city->id])),
					'posts' => $posts,
				];
				$carousel = Arr::toObject($carousel);
			}
		}

		return $carousel;
	}

	public function showImages($id) {
		$data = [];
		$data['images'] = [];
		foreach ($_GET as $name => $value) {
			$data['images'][] .= $value;
		}
		$data['id'] = Request::segment(3);
		return view('post.showImage', $data);
	}

	public function showImages1($id) {
		$data = [];
		$data['images'] = [];
		foreach ($_GET as $name => $value) {
			$data['images'][] .= $value;
		}
		$data['id'] = $id;
		return view('post.showImage', $data);
	}

}
