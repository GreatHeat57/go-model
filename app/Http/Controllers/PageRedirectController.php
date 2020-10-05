<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use App\Models\ModelCategory;
use App\Models\CountryLanguage;
use Illuminate\Support\Facades\Config;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\Page;
use App\Models\BlogEntry;
use Auth;
use App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Traits\LocalizationTrait;
use App\Http\Controllers\Traits\UserCountTrait;

class PageRedirectController extends Controller
{
	use LocalizationTrait, UserCountTrait;

	public $request;

	public function __construct()
	{
		// From Laravel 5.3.4+
		$this->middleware(function ($request, $next)
		{
			$this->loadLocalizationData();
			$this->calculateUserData();
			return $next($request);
		});
	}

    public function findMatchCategory($code, $slug=null){
		$current_route = \Request::segment(1);
		$is_default_country = 0;

		if(strlen($current_route) <= 2){
			$CountryLanguage = CountryLanguage::where('wp_language', \Request::segment(1))->first();
			if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
				Config::set('app.locale', $CountryLanguage->language_code);
			}

			$current_route = \Request::segment(2);
		}else{
			//changed to default language
			$is_default_country = 1;
		}

		//redirect to matching route page
		switch($current_route)
		{
			case 'baby-models'	: 	$routename = \Lang::get('routes.baby-model-page'); break;
			case 'kindermodels' :	$routename = \Lang::get('routes.child-model-page'); break;
			case 'child-models' :	$routename = \Lang::get('routes.child-model-page'); break;
			case 'models' 		: 	$routename = \Lang::get('routes.model-page'); break;
			case '50plus' 		:	$routename = \Lang::get('routes.senior-model-page'); break;
			case 'plus-size' 	:	$routename = \Lang::get('routes.pluszie-model-page'); break;
			case 'fitnessmodel' : 	$routename = \Lang::get('routes.fitness-model-page'); break;
			default				: 	$routename = \Lang::get('routes.model-page'); break;
		}
		return redirect()->route($routename);
		exit();

		if( isset($current_route) && !empty($current_route) ){

			$pageSlug = ModelCategory::trans()
					->where('parent_id', 0)
					->where('page_slug', $current_route)
					->first();

			$trans_catgeory= strtolower(\Lang::get('routes.category', [] , strtolower(config('app.locale') ) ) );
			if( isset($pageSlug) && !empty($pageSlug) && !empty($pageSlug->slug) ){
				if($is_default_country){
					return redirect($trans_catgeory.'/'.$pageSlug->slug);
				}else{
					return redirect(config('app.locale') . '/' . $trans_catgeory.'/'.$pageSlug->slug);
				}

			}else{
				return redirect(config('app.locale') . '/' . trans('routes.models-category'));
			}

		} else {
			return redirect(config('app.locale') . '/' . trans('routes.models-category'));
		}
	}

	public function aboutUsRedirection($code, $slug=null){
		
		$current_route = \Request::segment(1);

		if(strlen($current_route) <= 2){
			$CountryLanguage = CountryLanguage::where('wp_language', \Request::segment(1))->first();
			if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
				Config::set('app.locale', $CountryLanguage->language_code);
			}

			$current_route = \Request::segment(3);
		}else{
			$current_route = \Request::segment(2);
		}

		
		if(isset($current_route) && !empty($current_route)){

			//redirect if page is for registration
			if($current_route === 'apply-as-professional' || $current_route === 'jetzt-registrieren'){
				$register_route = '/#'.trans('routes.register');
				return redirect($register_route);
			}

			$pageSlug = Page::trans()
						->where(function ($query){
							$query->where('parent_id', 0)
          					->orWhereNull('parent_id');
						})
						->where(function ($query) use($current_route) {
							$query->where('page_slug', $current_route)
          					->orWhere('slug', $current_route);
						})
						->first();

			if(isset($pageSlug) && !empty($pageSlug) && isset($pageSlug->slug)){
				$t_page = \Lang::get('routes.t-page', [] , config('app.locale'));
				return redirect(config('app.locale').'/'.$t_page.'/'.$pageSlug->slug);
			}else{
				return redirect(config('app.locale'));
			}			
		}else{
			return redirect(config('app.locale'));
		}

		
	}

	public function aboutUsPageRedirection($code, $slug=null){

		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		$current_route = \Request::segment(2);

		if(isset($current_route) && !empty($current_route)){
			$slug = 'unsere-vision';
			return redirect(config('app.locale').'/'.$current_route.'/'.$slug);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function loginPageRedirection($code, $slug=null){

		$current_route = \Request::segment(1);

		$this->changeLocale($current_route);

		$current_route = \Request::segment(2);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.login', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function feedbackPageRedirection($code, $slug=null){

		$current_route = \Request::segment(1);
		$this->changeLocale($current_route);

		$current_route = \Request::segment(2);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.feedback', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function registerPageRedirection($code, $slug=null){

		$current_route = \Request::segment(1);
		$this->changeLocale($current_route);

		return redirect('/#'.trans('routes.register'));
	}

	public function jobPageRedirection(){
		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.search', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function partnerlistRedirection(){
		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.partner-list', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function findMatchBlog($slug) {

		$status = true;
		$explodeArr = array();
		$country_code = 'en';

		// all valid language code array
		$langcode = array('at','li','ch','de','en','gb');

		// de language code array
		$deLanguageCodeArr = array('at','li','ch','de');
		
		// slug string to array, get language code purpose 
		if(!empty($slug)){

			$explodeArr = explode('/', $slug);
			$blogSlug = $explodeArr[0];
		}

		// get country code in slug
		if(count($explodeArr) > 1){
			
			$country_code = $explodeArr[0];
			$blogSlug = $explodeArr[1];
		}

		// check get valid country code
		if(in_array(strtolower($country_code), $langcode)){
			
			// check get language code is de or en
			if(in_array(strtolower($country_code), $deLanguageCodeArr)){
				Config::set('app.locale', 'de');
			}else{
				Config::set('app.locale', 'en');
			}
		}else{
			$status = false;
		}
		
		if(!$status){ 
			return redirect('/');
		}

		// get blog by slug
		$pageSlug = BlogEntry::where('slug', $blogSlug)->first();

		if(isset($pageSlug) && !empty($pageSlug)){
			
			$attr = ['countryCode' => config('app.locale'), 'slug' =>  $blogSlug];
			// redirect to magazine
			return redirect(lurl(trans('routes.v-magazine', $attr), $attr));
		}
		else{
			return redirect('/');
		}
		
		// old code
		//  comented on 12-06-2019
		/*
		$current_route = \Request::segment(1);
		$is_default_country = 0;



		if(strlen($current_route) <= 2){
			$CountryLanguage = CountryLanguage::where('wp_language', \Request::segment(1))->first();
			if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
				Config::set('app.locale', $CountryLanguage->language_code);
			}

			$current_route = \Request::segment(2);

		}else{
			//changed to default language
			$is_default_country = 1;
		}

		$pageSlug = BlogEntry::where('slug', $slug)->first();

		if( isset($pageSlug) && !empty($pageSlug) ){
			$pageparentSlug = BlogEntry::trans()
			->where('translation_of', $pageSlug->translation_of)
			->orwhere('id', $pageSlug->translation_of)->first();
		}

		if(isset($pageparentSlug) && !empty($pageparentSlug)){
			$slug = $pageparentSlug->slug;
		}

		$t_page = \Lang::get('routes.magazine', [] , config('app.locale'));

		if($is_default_country){
			return redirect($t_page. '/' .$slug);
		}else{
			return redirect(config('app.locale').'/'.$t_page. '/' .$slug);
		}
		*/
	}

	public function modelDashboardRedirection(){
 		$current_route = \Request::segment(1);


		$this->changeLocale($current_route);
		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.model-dashboard', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function modelCategoryRedirection(){
		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.models-category', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function sedcardRedirection(){
		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.sedcard-generator', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function modellistRedirection(){
		$current_route = \Request::segment(1);
		
		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.model-list', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	public function benefitsRedirection(){
		$current_route = \Request::segment(1);

		$this->changeLocale($current_route);

		if(isset($current_route) && !empty($current_route)){
			$t_page = \Lang::get('routes.benefits', [] , config('app.locale'));
			return redirect(config('app.locale').'/'.$t_page);
		}else{
			return redirect(config('app.locale'));
		}
	}

	//change config local based on url lanuage
	public function changeLocale($current_route){
		if(strlen($current_route) <= 2){
			$CountryLanguage = CountryLanguage::where('wp_language', $current_route)->first();
			if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
				Config::set('app.locale', $CountryLanguage->language_code);
			}
		}
	}

	public function blogCategoryRedirection($slug) {
		return redirect(trans('routes.blogcategory').'/'.$slug);
	}

	public function blogCategoryRedirectionV2($local='', $slug){
		$blogcategory = \App\Models\BlogCategory::where('slug', $slug)->first();
		
		$fallback_locale = config('app.fallback_locale');

		if(isset($blogcategory) && !empty($blogcategory)){

			$this->changeLocale($blogcategory->translation_lang);

			if(isset($blogcategory->slug) && !empty($blogcategory->slug)){
				
				$t_page = \Lang::get('routes.blogcategory', [] , config('app.locale'));
				
				if($fallback_locale === config('app.locale')){
					
					return redirect($t_page. '/' .$blogcategory->slug);
				}

				return redirect(config('app.locale').'/'.$t_page. '/' .$blogcategory->slug);
			}else{
				return redirect(config('app.locale'));
			}
		}
	}

	public function blogTagRedirection($slug){
		$p_attr = ['countryCode' => config('app.locale') , 'slug' =>  $slug];
		return redirect(lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr));
	}

	public function blogTagRedirectionV2($locale, $slug){
		$langcode = array('at','li','ch','de');
		
		if(in_array(strtolower($locale), $langcode)){
			App::setLocale('de');
		}else{
			App::setLocale('en');
		}
		
		$p_attr = ['countryCode' => config('app.locale') , 'slug' =>  $slug];

		return redirect(lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr));
	}

	public function redirectPremium(){
		$page = Page::where('name', 'Go Tour')->trans()->first();

		if(isset($page) && !empty($page)){
			return redirect(config('app.locale').'/'.$page->slug);
		}else{
			abort(404);
		}
	}

	public function getHeaderCountry(){

		$data['country_code'] = (Auth::check() && isset( auth()->user()->country_code))? strtolower(auth()->user()->country_code) : config('country.icode');
		$data['country_name'] = config('country.name');

		$returnHTML = view('header_country', $data)->render();
		return response()->json(array('success' => true, 'html'=> $returnHTML, 'unreadMessages' => $this->unreadMessages, 'totalInvitations' => $this->totalInvitations));
	}
}
