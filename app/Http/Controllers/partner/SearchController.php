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

namespace App\Http\Controllers\Partner;

use App\Helpers\PartnerSearch;
use App\Http\Controllers\Partner\Traits\PreSearchTrait;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\ModelCategory;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use Torann\LaravelMetaTags\Facades\MetaTag;



class SearchController extends BaseController {
	use PreSearchTrait;

	public $isIndexSearch = true;

	protected $cat = null;
	protected $subCat = null;
	protected $city = null;
	protected $admin = null;

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request) {

		
		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}


		// return favourites page from database
		if(Gate::allows('view_partner_page', auth()->user())){
			// return to the show page
			return $this->showPartnerPage('your-client-list');
		}

		$dataArr = array();
		$dataArr['isfavorite'] = 0;

		view()->share('isIndexSearch', $this->isIndexSearch);

		$user_type = auth()->user()->user_type_id;
		//get user profile completed value
		$is_profile_completed = auth()->user()->is_profile_completed;

		// get favorite Partners by user id
		$favoritePartners = Favorite::select('id', 'fav_user_id')->where('user_id', Auth::user()->id)->get()->toArray();

		$dataArr['favoritePartners'] = $favoritePartners;

		$preSearch = $this->preSearchData();

		// echo "<pre>"; print_r ($preSearch); echo "</pre>"; exit();
		$data = array();

		// if logged in user is free user then do not allow to see any partner
		
		if(!CommonHelper::checkUserType(config('constant.country_free')) && isset(auth()->user()->user_register_type) && auth()->user()->user_register_type !== config('constant.user_type_free')){

			//check if model update their profile then show the job list
			if($is_profile_completed === '1'){
				// Search
				$search = new PartnerSearch($preSearch);
				$data = $search->fechAll();
			}
		}

		// Export Search Result
		$dataArr['count'] = isset($data['count'])? $data['count'] : 0;

		$dataArr['paginator'] = isset($data['paginator'])? $data['paginator'] : [];

		$metaArr = [
			'title' => t('meta-profi-liste - :app_name', ['app_name' => config('app.app_name')]),
		];
		CommonHelper::goPartnerMeta(auth()->user(), $metaArr); 

		// return view('model.serp');
		$dataArr['partnerCategories'] = Branch::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();
		
		$dataArr['pageNo'] = 0;
		$lastPage = 0;
		$is_last_page = 0;


		if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {

			if($dataArr['paginator']->is_last_page == 1){
				$is_last_page = 1;
			}
			
			$lastPage = $dataArr['paginator']->lastPage();
			$currentPage =  $dataArr['paginator']->currentPage();
			$dataArr['pageNo'] = $currentPage + 1;
		}

		// if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {
			
		// 	$lastPage = $dataArr['paginator']->lastPage();
		// 	$currentPage =  $dataArr['paginator']->currentPage();

		// 	if($lastPage == 1 && $currentPage == 1){
		// 		$is_last_page = 1;
		// 	}
		// 	if($lastPage > 1){
				
		// 		if($currentPage >= $lastPage){
		// 			$dataArr['pageNo'] = $lastPage;
		// 			$is_last_page = 1;
		// 		}else{
		// 			$dataArr['pageNo'] = $currentPage + 1;
		// 		}
		// 	}
		// }

		$dataArr['is_last_page'] = $is_last_page;

		if ($request->ajax()) {
			
			$returnHTML = view('model.inc.partner-list' , $dataArr)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $dataArr['pageNo'], 'is_last_page' => $dataArr['is_last_page']));
		}

		// return view('partner.serp');
		return view('model.find-partner', $dataArr);
	}

	public function favoritePartners(Request $request) {

		view()->share('isfavorite', 1);

		if (auth()->user()->user_type_id != 3) {
			return redirect(config('app.locale'));
		}

		// return favourites page from database
		if(Gate::allows('view_fav_partner_page', auth()->user())){
			// return to the show page
			return $this->showPartnerPage('shortlisted-client-list');
		}

		view()->share('isIndexSearch', $this->isIndexSearch);

		// Pre-Search
		if (RequestFacade::filled('c')) {
			if (RequestFacade::filled('sc')) {
				$this->getCategory(RequestFacade::input('c'), RequestFacade::input('sc'));
			} else {
				$this->getCategory(RequestFacade::input('c'));
			}
		}
		if (RequestFacade::filled('l') || RequestFacade::filled('location')) {
			$city = $this->getCity(RequestFacade::input('l'), RequestFacade::input('location'));
		}
		if (RequestFacade::filled('r') && !RequestFacade::filled('l')) {
			$admin = $this->getAdmin(RequestFacade::input('r'));
		}

		$preSearch = $this->preSearchData();

		$preSearch['is_favourite'] = 1;

		//get user profile completed value
		$is_profile_completed = auth()->user()->is_profile_completed;
		$dataArr = array();
		// if logged in user is free user then do not allow to see any partner
		if(!CommonHelper::checkUserType(config('constant.country_free')) && isset(auth()->user()->user_register_type) && auth()->user()->user_register_type !== config('constant.user_type_free')){
			//check if model update their profile then show the job list
			if($is_profile_completed === '1'){
			
				// Search
				$search = new PartnerSearch($preSearch);
				$dataArr = $search->fechAll();
			}
		}

		$metaArr = [
			'title' => t('meta-profi-liste-favourites - :app_name', ['app_name' => config('app.app_name')]),
		];
		CommonHelper::goPartnerMeta(auth()->user(), $metaArr);

		// return view('model.serp');
		$dataArr['partnerCategories'] = Branch::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();

		$dataArr['pageNo'] = 0;
		$lastPage = 0;
		$is_last_page = 0;

		if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {

			if($dataArr['paginator']->is_last_page == 1){
				$is_last_page = 1;
			}
			
				$lastPage = isset($dataArr['paginator'])? $dataArr['paginator']->lastPage() : 0;
				$currentPage =  isset($dataArr['paginator'])? $dataArr['paginator']->currentPage() : 0;
				$dataArr['pageNo'] = $currentPage + 1;
		}

		// if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {
			
		// 	$lastPage = $dataArr['paginator']->lastPage();
		// 	$currentPage =  $dataArr['paginator']->currentPage();

		// 	if($lastPage == 1 && $currentPage == 1){
		// 		$is_last_page = 1;
		// 	}
		// 	if($lastPage > 1){
				
		// 		if($currentPage >= $lastPage){
		// 			$dataArr['pageNo'] = $lastPage;
		// 			$is_last_page = 1;
		// 		}else{
		// 			$dataArr['pageNo'] = $currentPage + 1;
		// 		}
		// 	}
		// }

		$dataArr['is_last_page'] = $is_last_page;

		if ($request->ajax()) {
			
			$returnHTML = view('model.inc.partner-list' , $dataArr)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $dataArr['pageNo'], 'is_last_page' => $dataArr['is_last_page']));
		}

		return view('model.find-partner', $dataArr);
	}


	public function preSearchData(){

		$user_type = auth()->user()->user_type_id;

		// Pre-Search values
		$preSearch = [
			//'city' => (isset($city) && !empty($city)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
			'user_type' => (isset($user_type) && !empty($user_type)) ? $user_type : null,
		];

		if ($user_type == 3) {
			
			$preSearch['height_id'] = (auth()->user()->profile->height_id) ? auth()->user()->profile->height_id : '';
			$preSearch['weight_id'] = (auth()->user()->profile->weight_id) ? auth()->user()->profile->weight_id : '';
			$preSearch['size_id'] = (auth()->user()->profile->size_id) ? auth()->user()->profile->size_id : '';
			
			$preSearch['chest_id'] = (auth()->user()->profile->chest_id)? auth()->user()->profile->chest_id : '';
			$preSearch['waist_id'] = (auth()->user()->profile->waist_id)? auth()->user()->profile->waist_id : '';
			$preSearch['hips_id'] = (auth()->user()->profile->hips_id)? auth()->user()->profile->hips_id : '';
			
			$preSearch['shoes_size_id'] = (auth()->user()->profile->shoes_size_id) ? auth()->user()->profile->shoes_size_id : '';
			$preSearch['eye_color_id'] = (auth()->user()->profile->eye_color_id) ? auth()->user()->profile->eye_color_id : '';
			$preSearch['hair_color_id'] = (auth()->user()->profile->hair_color_id) ? auth()->user()->profile->hair_color_id : '';
			$preSearch['skin_color_id'] = (auth()->user()->profile->skin_color_id) ? auth()->user()->profile->skin_color_id : '';
			
			//$preSearch['piercing'] = (auth()->user()->profile->piercing)? auth()->user()->profile->piercing : '';
			// $preSearch['tattoo'] = (auth()->user()->profile->tattoo)? auth()->user()->profile->tattoo : '';
			
			$preSearch['model_category_id'] = (auth()->user()->profile->category_id) ? auth()->user()->profile->category_id : '';
			$preSearch['category_id'] = (auth()->user()->profile->parent_category) ? auth()->user()->profile->parent_category : '';

			$preSearch['gender_id'] = (auth()->user()->gender_id)? auth()->user()->gender_id : '';

			if(auth()->user()->profile->birth_day && !empty(auth()->user()->profile->birth_day) 
				&& auth()->user()->profile->birth_day != null 
				&& auth()->user()->profile->birth_day != '0000-00-00') {
				$now = time();

				$dob = strtotime(auth()->user()->profile->birth_day);

				$difference = $now - $dob;

				$age = floor($difference / 31556926);

				if ($age && $age > 0) {
					$preSearch['age'] = $age;
				}

			}

			//check model is baby model or not
			$preSearch['is_baby_model'] = false;

			if( isset($preSearch['model_category_id']) && !empty($preSearch['model_category_id']) ){
				$modelCategory = ModelCategory::find($preSearch['model_category_id']);

				if( isset($modelCategory) && !empty($modelCategory) ){
					$preSearch['is_baby_model'] = $modelCategory->is_baby_model;
				}
			}

			return $preSearch;
		}
	}


	public function showPartnerPage($page){

		// Get the Page
		$page = Page::where('slug', $page)->trans()->first();

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'short-list');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		$tags = getAllMetaTagsForPage($page->slug);
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		// CommonHelper::ogMeta();
		return view('post.client-list');
	}
}
