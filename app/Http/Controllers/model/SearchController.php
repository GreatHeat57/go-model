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

use App\Helpers\ModelSearch;
use App\Http\Controllers\Model\Traits\PreSearchTrait;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\ModelCategory;
use App\Models\Gender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Models\Country;

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
	public function index($slug = '', Request $request) {

		if (!Gate::allows('list_models', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }
        
		// echo "<pre>"; print_r ($request->all()); echo "</pre>"; exit();
		$rules = $this->returnRules($request->all());

		$validator = Validator::make($request->all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			return \Redirect::back()->withInput()->withErrors($validator->messages());
		}

		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		
		$dataArr = array();

		// view()->share('isIndexSearch', $this->isIndexSearch);

		// view()->share('favourite', false);
		$favourite = false;

		// Pre-Search
		// if (RequestFacade::filled('c')) {
		// 	if (RequestFacade::filled('sc')) {
		// 		$this->getCategory(RequestFacade::input('c'), RequestFacade::input('sc'));
		// 	} else {
		// 		$this->getCategory(RequestFacade::input('c'));
		// 	}
		// }
		// if (RequestFacade::filled('l') || RequestFacade::filled('location')) {
		// 	$city = $this->getCity(RequestFacade::input('l'), RequestFacade::input('location'));
		// }
		// if (RequestFacade::filled('r') && !RequestFacade::filled('l')) {
		// 	$admin = $this->getAdmin(RequestFacade::input('r'));
		// }

		

		$user_type = "";
		$user_id = "";

		if(auth()->user()->user_type_id){
			$user_type = auth()->user()->user_type_id;
			$user_id = auth()->user()->id;
		}


		// Pre-Search values
		$preSearch = [
			//'city' => (isset($city) && !empty($city)) ? $city : null,
			//'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
		];

		$is_search = 0;
		$is_filter = 0;
		$is_category = 0;

		if($request->is_search){
			$is_search = 1;
		}
		if($request->is_filter){
			$is_filter = 1;
		}

		if(isset($request->c)){

			$is_category = $request->c;
			view()->share('uriCategoryId', $is_category);
		}

		$dataArr['is_search'] = $is_search;
		$dataArr['is_filter'] = $is_filter;
		$dataArr['is_category'] = $is_category;


		$req = $request->all();

		 // echo "<pre>"; print_r($req); echo "</pre>"; exit(); 

		$dataArr['selectedDressSizeKids'] = isset($req['dress_size_kids'])? $req['dress_size_kids'] : '';
		$dataArr['selectedDressSizeMen'] = isset($req['dress_size_men'])? $req['dress_size_men'] : '';
		$dataArr['selectedDressSizeWomen'] = isset($req['dress_size_women'])? $req['dress_size_women'] : '';
		$dataArr['selectedShoeSizeKids'] = isset($req['shoe_size_kids'])? $req['shoe_size_kids'] : '';
		$dataArr['selectedShoeSizeMen'] = isset($req['shoe_size_men'])? $req['shoe_size_men'] : '';
		$dataArr['selectedShoeSizeWomen'] = isset($req['shoe_size_women'])? $req['shoe_size_women'] : '';
		
		$dataArr['dress_kids_check_all'] = isset($req['dress_kids_check_all'])? $req['dress_kids_check_all'] : 0;
		$dataArr['dress_men_check_all'] = isset($req['dress_men_check_all'])? $req['dress_men_check_all'] : 0;
		$dataArr['dress_women_check_all'] = isset($req['dress_women_check_all'])? $req['dress_women_check_all'] : 0;
		$dataArr['shoe_kid_check_all'] = isset($req['shoe_kid_check_all'])? $req['shoe_kid_check_all'] : 0;
		$dataArr['shoe_men_check_all'] = isset($req['shoe_men_check_all'])? $req['shoe_men_check_all'] : 0;
		$dataArr['shoe_women_check_all'] = isset($req['shoe_women_check_all'])? $req['shoe_women_check_all'] : 0;

		// $dataArr['minshoeSize'] = isset($req['minShoeSize'])? $req['minShoeSize'] : '';
		// $dataArr['maxshoeSize'] = isset($req['maxShoeSize'])? $req['maxShoeSize'] : '';

		// if( isset($req) && !empty($req['search_content']) ){
		// 	$preSearch['search_content'] = $req['search_content'];
		// }

		// echo $slug; die();

		if($slug === t('favourites')){
			// $preSearch['is_favourite'] = 1; 
			// view()->share('favourite', true);
			$favourite = true;
			view()->share('uriPathPageSlug', t('favourites'));
		}

		//gender list
		view()->share('genders', Gender::trans()->get());

		$favorites_user_ids = array();

		if($user_id && $user_id != ''){
			$favorites_user_ids = Favorite::getFavouriteUsersById($user_id);
		}
		
		$preSearch = $this->preSearchData($slug, $req);


		// check user type
		if(auth()->user()->user_register_type == config('constant.user_type_free')){
			$preSearch['is_premium_partner'] = false;
		}else{
			$preSearch['is_premium_partner'] = true;
		}

		$dataArr['favourites_tab'] = $favourite;

		

		// if favourite model flag is true then return all countries models
		if($favourite && !array_key_exists("countryid", $req)){
			$preSearch['country_code'] = "";
		}

		// Search
		$search = new ModelSearch($preSearch);
		$data = $search->fechAll();

		$this->getBreadcrumb();
		$this->getHtmlTitle();

		// Export Search Result
		$dataArr['count'] = $data['count'];
		$dataArr['paginator'] = $data['paginator'];
		$dataArr['favorites_user_ids'] = $favorites_user_ids;
		$dataArr['favourite'] = $favourite;
		
		if($favourite == true){
			$title = t('meta-Model-list-favourites - :app_name', ['app_name' => config('app.app_name')]);
		}else{
			$title = t('meta-Model-list - :app_name', ['app_name' => config('app.app_name')]);
		}

		$metaArr['title'] = $title;
		
		CommonHelper::gojobMeta($metaArr);
		
		// return view('model.serp');
		$dataArr['modelCategories'] = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();

		$categoryArr = array();
		$categoryArr['models_category'] = array();
		$categoryArr['babyModels_category'] = array();

        $i = 0;

        if(!empty($dataArr['modelCategories']) && $dataArr['modelCategories']->count() > 0){

        	foreach ($dataArr['modelCategories'] as $key => $cat) { 

            	if($cat->is_baby_model == 1){

            		$categoryArr['babyModels_category'][$cat->parent_id] = $cat->name;
            	}else{
            		$categoryArr['models_category'][$cat->parent_id] = $cat->name;
            	} 
            }
        }
		
		view()->share('models_category', $categoryArr['models_category']);
        view()->share('babyModels_category', $categoryArr['babyModels_category']);
		
		$dataArr['pageNo'] = 0;
		$lastPage = 0;
		$is_last_page = 0;

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


		if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {

			if($dataArr['paginator']->is_last_page == 1){
				$is_last_page = 1;
			}
			
			$lastPage = $dataArr['paginator']->lastPage();
			$currentPage =  $dataArr['paginator']->currentPage();
			$dataArr['pageNo'] = $currentPage + 1;
		}

		$dataArr['is_last_page'] = $is_last_page;

		if ($request->ajax()) {
			
			$returnHTML = view('model.inc.posts' , $dataArr)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $dataArr['pageNo'], 'is_last_page' => $dataArr['is_last_page']));
		}
		
		return view('model.find-model', $dataArr);
	}


	public function preSearchData($slug = '', $req = array()){

		$preSearch = array();

		if( isset($req) && !empty($req['search_content']) ){
			$preSearch['search_content'] = $req['search_content'];
		}

		$preSearch['latitude'] = '';
		$preSearch['longitude'] = '';
		$preSearch['gender_id'] = '';
		$preSearch['is_baby_model'] = false;
		$preSearch['tattoo'] = "";

		if( isset($req) && !empty($req['city']) ){


			if(isset($req['radius']) && $req['radius'] > 0){

				if(!empty($req['latitude']) && !empty($req['longitude'])){

					$preSearch['latitude'] = number_format($req['latitude'], 7);
					$preSearch['longitude'] = number_format($req['longitude'], 7);
				}else{
					$latlongArr  = $this->getLatLong($req['city']);
					
					$preSearch['latitude'] = number_format($latlongArr['latitude'], 7);
					$preSearch['longitude'] = number_format($latlongArr['longitude'], 7);
				}
			}else{
	
				//explode and remove country name from the string
				$cityArr = explode(',', $req['city']);
				
				if( isset($cityArr) && count($cityArr) > 0 ){
					$preSearch['city'] = trim($cityArr[0]);
				}

			}
			
		}

		if( isset($req) && !empty($req['gender_id']) ){
			$preSearch['gender_id'] = $req['gender_id'];
		}

		if( isset($req) && !empty($req['category_id']) ){
			// $modelCategory = ModelCategory::find($req['category_id']);

			// if( isset($modelCategory) && !empty($modelCategory) ){
			// 	$preSearch['is_baby_model'] = $modelCategory->is_baby_model;
			// }
		}

		if($slug === t('favourites')){
			$preSearch['is_favourite'] = 1; 
		}


		$preSearch['country_code'] = (isset($req['countryid']) && $req['countryid'] != "")? $req['countryid'] : auth()->user()->country_code;

		if(isset($req) && !empty($req['radius']) && $req['radius'] > 0){

			$preSearch['search_distance'] = $req['radius']; 

			if(empty($req['city']) || ( empty($preSearch['latitude']) && empty($preSearch['longitude']) ) ){
				$preSearch['latitude'] = isset(Auth::user()->latitude)? Auth::user()->latitude : '';
				$preSearch['longitude'] = isset(Auth::user()->longitude)? Auth::user()->longitude : '';
			}

		}

		if( isset($req['tattoo']) && $req['tattoo'] != ""){
			$preSearch['tattoo'] = $req['tattoo'];
		}


		if(isset($req['countryid']) && !empty($req['countryid'])){
			$country = Country::withoutGlobalScopes()->where('code', $req['countryid'])->first();

			if( !empty($country) && isset($country->country_type) ){
				$preSearch['country_type'] = $country->country_type;
			}
		}

		 // echo "<pre>"; print_r($preSearch); echo "</pre>"; exit(); 
		
		return $preSearch;
	}

	public function returnRules($req){
		
		$rules = array();

		if( isset($req['minHeight']) && !empty($req['minHeight']) && isset($req['maxHeight']) && !empty($req['maxHeight']) ){

			$rules['maxHeight'] = 'greater_than_or_qual:minHeight';
		}

		if( isset($req['minWeight']) && !empty($req['minWeight']) && isset($req['maxWeight']) && !empty($req['maxWeight']) ){

			$rules['maxWeight'] = 'greater_than_or_qual:minWeight';
		}

		if( isset($req['minChest']) && !empty($req['minChest']) && isset($req['maxChest']) && !empty($req['maxChest']) ){

			$rules['maxChest'] = 'greater_than_or_qual:minChest';
		}

		if( isset($req['minWaist']) && !empty($req['minWaist']) && isset($req['maxWaist']) && !empty($req['maxWaist']) ){

			$rules['maxWaist'] = 'greater_than_or_qual:minWaist';
		}

		if( isset($req['minHips']) && !empty($req['minHips']) && isset($req['maxHips']) && !empty($req['maxHips']) ){

			$rules['maxHips'] = 'greater_than_or_qual:minHips';
		}

		// if( isset($req['minDressSize']) && !empty($req['minDressSize']) && isset($req['maxDressSize']) && !empty($req['maxDressSize']) ){

		// 	$rules['maxDressSize'] = 'greater_than:minDressSize';
		// }

		if( isset($req['minShoeSize']) && !empty($req['minShoeSize']) && isset($req['maxShoeSize']) && !empty($req['maxShoeSize']) ){

			$rules['maxShoeSize'] = 'greater_than_or_qual:minShoeSize';
		}

		if( isset($req['minAge']) && !empty($req['minAge']) && isset($req['maxAge']) && !empty($req['maxAge']) ){

			$rules['maxAge'] = 'greater_than_or_qual:minAge';
		}

		return $rules;

	}

	public function getLatLong($address){

		$LatLong = array();

		$googleurl=config('app.g_latlong_url');

		$apikey=config('app.latlong_api');

		$formattedAddr = str_replace(' ','+',$address);

		$url = $googleurl . $formattedAddr . '&key=' . $apikey.'&sensor=true';

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        $output= json_decode($data);
        
        if(count($output->results) != 0) {
            $LatLong['latitude']  = str_replace(",", ".", $output->results[0]->geometry->location->lat);
            $LatLong['longitude'] = str_replace(",", ".", $output->results[0]->geometry->location->lng);
        }else{
        	$LatLong['latitude'] = '';
			$LatLong['longitude'] = '';
        }

        return $LatLong;
	}
}
