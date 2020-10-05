<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelCategory;
use App\Helpers\CommonHelper;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\ModelSearch;
use App\Models\Post;
use App\Models\FeatureModels;

class CategoryController extends FrontController {

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
			// get terms and conditions for country code wise
			$this->getTermsConditions();

			return $next($request);
		});
	}

	/* new function that loads model category page based on url */
	public function load() {
		// $slug = "model";
		$page = request()->route()->getName();
		$category = collect(request()->segments())->last();
		// $category = \Request::segment(1);
		// if(strtolower($category) == strtolower(config('app.locale'))){
		// 	$category = \Request::segment(2);
		// }
		switch($page)
		{	
			case 'baby-model-page'		: 	$slug = "baby-model"; break;
			case 'kid-model-page' 	:	$slug = "kid-model"; break;
			case 'model-page' 			: 	$slug = "model"; break;
			case 'senior-model-page' 			:	$slug = "50plus-model"; break;
			case 'pluszie-model-page' 			:	$slug = "plus-size-model"; break;
			case 'fitness-model-page' 	: 	$slug = "fitness-model"; break;
			case 'tattoo-model-page' 	: 	$slug = "tattoo-model"; break;
			case 'male-model-page' 	: 	$slug = "male-model"; break;

			// case 'become-a-baby-model'		: 	$slug = "baby-model"; break;
			// case 'become-a-child-model' 	:	$slug = "kid-model"; break;
			// case 'become-a-model' 			: 	$slug = "model"; break;
			// case 'senior-models' 			:	$slug = "50plus-model"; break;
			// case 'plus-size-model' 			:	$slug = "plus-size-model"; break;
			// case 'become-a-fitness-model' 	: 	$slug = "fitness-model"; break;

			// case 'jetzt-babymodel-werden'	: 	$slug = "baby-model"; break;
			// case 'kindermodel-werden' 		:	$slug = "kid-model"; break;
			// case 'jetzt-model-werden' 		: 	$slug = "model"; break;
			// case '50plus-model-werden' 		:	$slug = "50plus-model"; break;
			// case 'plus-size-model-werden' 	:	$slug = "plus-size-model"; break;
			// case 'fitnessmodel-werden' 		: 	$slug = "fitness-model"; break;

			default 						: 	$slug = "model"; break;
		}
		
		if(!empty($slug)){
			view()->share('uriPathPageSlug', $slug);

			$feature_models = FeatureModels::getFeatureModels(config('country.code'), $model_category = $slug, $orderby = 'go_code', $limit = 20);
			view()->share('feature_models', $feature_models);
		}
		if(config('app.locale') != "en"){
			$slug = $slug."-".config('app.locale');
		}
		
		$catObj = ModelCategory::where('slug', $slug)->trans()->first();

		if(empty($catObj)){
			
			return	redirect(lurl(trans('routes.models-category')));
		}
		
		if(isset($catObj->parent_id) && !empty($catObj->parent_id)){
			view()->share('uriCategoryId', $catObj->parent_id);
		}


		if(isset($catObj->footer_text) && !empty($catObj->footer_text)){
			view()->share('footer_text', $catObj->footer_text);
		}

		$metaDescription = '';
		
		if(!empty($catObj) && isset($catObj->description)){
			$metaDescription = $catObj->description;
		}

		$data['selectedCategory'] = $catObj;
		$data['modelCategories'] = ModelCategory::trans()->where('parent_id', 0)
						  ->orderBy('ordering')
						  ->get();


		// get featured models
		$preSearch = [
			'city' => (isset($city) && !empty($city)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
			'is_featured' => 1,
		];
		// Search
		$search = new ModelSearch($preSearch);
		$featured_data = $search->fechAll();
		
		$data['latestJobs'] = Post::where('archived','0')
							->where('verified_email','1')
							->where('verified_phone','1')
							->where('ismodel','1')
							->whereRaw('FIND_IN_SET('.$catObj->id.',model_category_id)')
							->limit(6)->orderBy('id', 'DESC')->get();
		if(count($data['latestJobs'] ) == 0)
		{
			$data['latestJobs'] = Post::where('archived','0')
							->where('verified_email','1')
							->where('verified_phone','1')
							->where('ismodel','1')
							->limit(6)->orderBy('id', 'DESC')->get();
		}					
			 // echo "<pre>";  print_r($data['latestJobs']);  "</pre>"; exit(); 
		// Export Search Result
		view()->share('count', $featured_data['count']);
		view()->share('paginator', $featured_data['paginator']);
		
		$title = $slug.' - '.config('app.app_name');
		// Meta Tags
		// MetaTag::set('title',  $title);
		// MetaTag::set('description',  $metaDescription);
		
		MetaTag::set('title', $catObj->meta_title);
		MetaTag::set('description', $catObj->meta_description);
		MetaTag::set('keywords', $catObj->meta_keywords);
		CommonHelper::ogMeta();
		return view('categories.baby', $data);
	}
	
	/* old function that works on model category slug */
	public function load_old($slug) {

		if(!empty($slug)){
			view()->share('uriPathPageSlug', $slug);
		}
		
		$cat = ModelCategory::where('slug', $slug)->get();
		$catObj = '';

		if(isset($cat[0])){
			$catObj = (object) $cat[0];
		}
		if(isset($catObj->parent_id) && !empty($catObj->parent_id)){
			view()->share('uriCategoryId', $catObj->parent_id);
		}

		$metaDescription = '';
		
		if(!empty($catObj) && isset($catObj->description)){
			$metaDescription = $catObj->description;
		}

		$data['modelCategories'] = $cat;
		
		$title = $slug.' - '.config('app.app_name');
		// Meta Tags
		MetaTag::set('title',  $title);
		MetaTag::set('description',  $metaDescription);
		CommonHelper::ogMeta();
		return view('categories.baby', $data);
	}

	// public function childs($slug) {
	// 	return view('categories.childs');
	// }

	// public function models($slug) {
	// 	return view('categories.models');
	// }

	// public function fitness() {
	// 	return view('categories.fitness');
	// }

	// public function plussize() {
	// 	return view('categories.plussize');
	// }

	// public function plus50() {
	// 	return view('categories.plus50');
	// }
}
