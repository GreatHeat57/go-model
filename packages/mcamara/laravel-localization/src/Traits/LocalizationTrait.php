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

namespace Larapen\LaravelLocalization;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use App\Models\BlogCategory;
use App\Models\BlogEntry;
use App\Models\JobsTranslation;
use Illuminate\Support\Str;

trait LocalizationTrait
{
	/**
	 * Get URL through the current Controller
	 *
	 * @param null $locale
	 * @param array $attributes
	 * @return null|string
	 * @throws Exceptions\SupportedLocalesNotDefined
	 */
	public function getUrlThroughCurrentController($locale = null, $attributes = [])
	{
		$url = null;
		
		if (empty($locale)) {
			$locale = $this->getCurrentLocale();
		}
		
		// Get the Query String
		$queryString = (request()->all() ? ('?' . httpBuildQuery(request()->all())) : '');
		
		// Get the Country Code
		$countryCode = $this->getCountryCode($attributes);
		
		// Get the Locale Path
		$localePath = $this->getLocalePath($locale);
		
		// Search: Category
		if (Str::contains(Route::currentRouteAction(), 'Search\CategoryController@index')) {
			// Get category or sub-category translation
			if (isset($attributes['catSlug'])) {
				// Get Category
				$cat = self::getCategoryBySlug($attributes['catSlug'], $locale);
				if (!empty($cat)) {
					$routePath = '';
					if (isset($attributes['subCatSlug']) && !empty($attributes['subCatSlug'])) {
						$subCat = self::getSubCategoryBySlug($cat->tid, $attributes['subCatSlug'], $locale);
						if (!empty($subCat)) {
							// Get the Route Path
							$routePath = trans('routes.v-search-subCat', [
								'countryCode' => $countryCode,
								'catSlug'     => $cat->slug,
								'subCatSlug'  => $subCat->slug,
							], $locale);
						}
					} else {
						// Get the Route Path
						$routePath = trans('routes.v-search-cat', [
							'countryCode' => $countryCode,
							'catSlug'     => $cat->slug,
						], $locale);
					}
					
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}
			}
		} // Search: Location - Laravel Routing doesn't support PHP rawurlencode() function
		else if (Str::contains(Route::currentRouteAction(), 'Search\CityController@index')) {
			// Get the Route Path
			if (isset($attributes['city'])) {
				$routePath = trans('routes.v-search-city', [
					'countryCode' => $countryCode,
					'city'        => $attributes['city'],
					'id'          => $attributes['id'],
				], $locale);
				
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		} // Pages
		else if (Str::contains(Route::currentRouteAction(), 'PageController@index')) {
			if (isset($attributes['slug'])) {
				$page = self::getPageBySlug($attributes['slug'], $locale);
				if (!empty($page)) {
					// Get the Route Path
					$routePath = trans('routes.v-page', ['slug' => $page->slug], $locale);
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}
			}
		} // Search: Index
		else if (Str::contains(Route::currentRouteAction(), 'Search\SearchController@index')) {
			// Get the Route Path
			if(isset($attributes['slug'])){
				$routePath = trans('routes.v-search', ['countryCode' => $countryCode,'slug' => $attributes['slug']], $locale);
			}else{
				$routePath = trans('routes.search', ['countryCode' => $countryCode], $locale);
			} 
			$url = app('url')->to($localePath . $routePath) . $queryString;
		} else if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\CategoryController@load')) {
			if(isset($attributes['category_id']) && !empty($attributes['category_id'])){
				$modelCat = self::getModelCategoryBySlug($attributes['category_id'], $locale);
				$routePath = '';
				if(!empty($modelCat)){
					$routePath = trans('routes.v-page-category', [
							'countryCode' => $countryCode,
							'slug'     => $modelCat->slug,
						], $locale);
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}else{
					$url = url()->current();
				}
			}else{
				$url = url()->current();
			}
		}	// Details: page slug translate
		else if (Str::contains(Route::currentRouteAction(), 'DetailsController@index')) {

			// set default url
			$routePath = trans('routes.search', ['countryCode' => $countryCode], $locale);
			
			// Get the Route Path
			if(isset($attributes['attrId'])){
				
				// get jobsTranslation table title.
				$post = JobsTranslation::select('title', 'job_id')->where('translation_lang', $locale)->where('job_id', $attributes['attrId'])->first();
				
				if(!empty($post)){
					
					if(isset($post->title) && !empty($post->title)){
						
						$routePath = trans('routes.v-post', [
				            'slug' => slugify($post->title),
				            'id'   => $attributes['attrId'],
				        ]);
					}
				} 
			}
			 
			$url = app('url')->to($localePath . $routePath) . $queryString;
		}
		  // Notifications
		else if (Str::contains(Route::currentRouteAction(), 'ConversationsController@getnotification')) {
			if (isset($attributes['slug']) && !empty($attributes['slug'])) 
			{	
				$routePath = trans('routes.v-notifications', [
							'countryCode' => $countryCode,
							'status'     => $attributes['slug'],
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		}// Model Search: Index
		else if (Str::contains(Route::currentRouteAction(), 'Model\SearchController@index')) {
			// Get the Route Path
			if(isset($attributes['slug'])){
				$routePath = trans('routes.v-model-list', ['countryCode' => $countryCode,'slug' => $attributes['slug']], $locale);
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
			else{
				$routePath = trans('routes.model-list', ['countryCode' => $countryCode], $locale);
				$url = app('url')->to($localePath . $routePath) . $queryString;
			} 

			// if(isset($attributes['category_id'])){
			// 	$url = app('url')->to($localePath . $routePath) . $queryString;
			// }else{
			// 	$url = app('url')->to($localePath . $routePath);
			// }
			// echo $url = app('url')->to($localePath . $routePath) . $queryString;
		}else if (Str::contains(Route::currentRouteAction(), 'PageController@category_magazine')) {
			
			if(isset($attributes['category_id']) && !empty($attributes['category_id'])){
				
				$blogCat =  self::getBlogCategoryBySlug($attributes['category_id'], $locale);
				$routePath = '';

				if(!empty($blogCat)){
					$routePath = trans('routes.v-blog-category', [
							'countryCode' => $countryCode,
							'slug'     => $blogCat->slug,
						], $locale);
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}else{
					
					$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
					$url = app('url')->to($localePath . $routePath);
				}
			}else{
				
				$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath);
			}

		}
		else if (Str::contains(Route::currentRouteAction(), 'PageController@magazine_read')) {

			if(isset($attributes['category_id']) && !empty($attributes['category_id'])){
				
				$blog =  self::getBlogBySlug($attributes['category_id'], $locale);
				$routePath = '';

				if(!empty($blog)){
					$routePath = trans('routes.v-magazine', [
							'countryCode' => $countryCode,
							'slug'     => $blog->slug,
						], $locale);
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}else{
					
					$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
					$url = app('url')->to($localePath . $routePath);
				}
			}else{
				
				$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath);
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'PageController@tag_magazine')) { 

			if(isset($attributes['category_id']) && !empty($attributes['category_id'])){ 

				$blogTag = self::getBlogTagBySlug($attributes['category_id'], $locale);
				$routePath = '';

				if(!empty($blogTag)){
					$routePath = trans('routes.v-magazine-tag', [
							'countryCode' => $countryCode,
							'slug'     => $blogTag->slug,
						], $locale);
					$url = app('url')->to($localePath . $routePath) . $queryString;
				}else{
					
					$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
					$url = app('url')->to($localePath . $routePath);
				}
			}else{
				
				$routePath = trans('routes.magazine', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath);
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'CompanyController@edit')) {

			if(isset($attributes['attrId']) && !empty($attributes['attrId'])){
				$routePath = trans('routes.v-account-companies-edit', [
							'countryCode' => $countryCode,
							'id'     => $attributes['attrId'],
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'RegisterController@registerDataForm')) { 
			
			if(isset($attributes['slug']) && !empty($attributes['slug'])){

				$stringSlug =  '/'.$attributes['slug'];
				$routePath = trans('routes.registerData', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $stringSlug;
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'RegisterController@registerPhotoForm')) { 
			
			if(isset($attributes['slug']) && !empty($attributes['slug'])){

				$stringSlug =  '/'.$attributes['slug'];
				$routePath = trans('routes.registerPhoto', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $stringSlug;
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'RegisterController@finish')) { 
			
			if(isset($attributes['slug']) && !empty($attributes['slug'])){

				$stringSlug =  '/'.$attributes['slug'];
				$routePath = trans('routes.registerFinish', [
							'countryCode' => $countryCode
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $stringSlug;
			}
		}else if (Str::contains(Route::currentRouteAction(), 'Auth\ResetPasswordController@showResetForm')) {

			if (isset($attributes['token']) && !empty($attributes['token'])) 
			{	
				$routePath = trans('routes.v-password-reset', [
							'countryCode' => $countryCode,
							'token'     => $attributes['token'],
						], $locale);

				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		}
		else if (Str::contains(Route::currentRouteAction(), 'EditController@getForm')) {

			if(isset($attributes['attrId']) && !empty($attributes['attrId'])){
				$routePath = trans('routes.v-post-edit', [
							'countryCode' => $countryCode,
							'id'     => $attributes['attrId'],
						], $locale);
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		}

		else {
			$url = null;
		}
		
		return $url;
	}
	
	
	/**
	 * Get URL through entered Route (Or through entered URL)
	 *
	 * @param null $locale
	 * @param null $url
	 * @param array $attributes
	 * @return null|string
	 * @throws Exceptions\SupportedLocalesNotDefined
	 */
	public function getUrlThroughEnteredRoute($locale = null, $url = null, $attributes = [])
	{
		if (empty($locale)) {
			$locale = $this->getCurrentLocale();
		}
		
		// Don't capture RAW urls
		if (Str::contains($url, '{')) {
			return $url;
		}
		
		// Get the Query String
		$queryString = '';
		$parts = mb_parse_url($url);
		if (isset($parts['query'])) {
			$queryString = '?' . (is_array($parts['query']) || is_object($parts['query'])) ? httpBuildQuery($parts['query']) : $parts['query'];
		}
		
		// Get the Country Code
		$countryCode = $this->getCountryCode($attributes);
		
		// Get the Locale Path
		$localePath = $this->getLocalePath($locale);
		
		// Work with URL Path (without URL Protocol & Host)
		$url = $this->getUrlPath($url, $locale);
		
		// Search: Category
		if (
			Str::contains($url, trans('routes.t-search-cat'))
			&& isset($attributes['catSlug'])
		) {
			// Get Category
			$cat = self::getCategoryBySlug($attributes['catSlug'], $locale);
			if (!empty($cat)) {
				$routePath = '';
				if (isset($attributes['subCatSlug']) && !empty($attributes['subCatSlug'])) {
					// Get Sub-category
					$subCat = self::getSubCategoryBySlug($cat->tid, $attributes['subCatSlug'], $locale);
					if (!empty($subCat)) {
						// Get the Route Path
						$routePath = trans('routes.v-search-subCat', [
							'countryCode' => $countryCode,
							'catSlug'     => $cat->slug,
							'subCatSlug'  => $subCat->slug,
						], $locale);
					}
				} else {
					// Get the Route Path
					$routePath = trans('routes.v-search-cat', [
						'countryCode' => $countryCode,
						'catSlug'     => $cat->slug,
					], $locale);
				}
				
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
		} // Search: Location - Laravel Routing don't support PHP rawurlencode() function
		else if (
			Str::contains($url, trans('routes.t-search-city'))
			&& isset($attributes['city'])
			&& isset($attributes['id'])
		) {
			// Get the Route Path
			$routePath = trans('routes.v-search-city', [
				'countryCode' => $countryCode,
				'city'        => $attributes['city'],
				'id'          => $attributes['id'],
			], $locale);
			
			$url = app('url')->to($localePath . $routePath) . $queryString;
		} // Pages
		else if (
			Str::contains($url, trans('routes.page'))
			&& isset($attributes['slug'])
		) {
			// Get Page
			$page = self::getPageBySlug($attributes['slug'], $locale);
			if (!empty($page)) {
				// Get the Route Path
				$routePath = trans('routes.v-page', ['slug' => $page->slug], $locale);
				
				$url = app('url')->to($localePath . $routePath) . $queryString;
			}
			
		} // Search: Index
		else if (
			Str::contains($url, trans('routes.t-search'))
			&& !Str::contains($url, trans('routes.t-search-cat'))
		) {
			// Get the Route Path
			$routePath = trans('routes.v-search', ['countryCode' => $countryCode], $locale);
			
			$url = app('url')->to($localePath . $routePath) . $queryString;
		} else {
			$url = '###' . $url . '###';
		}
		
		return $url;
	}
	
	/**
	 * Get the Locale Path (i.e. Language Path)
	 *
	 * @param null $locale
	 * @return string
	 * @throws Exceptions\SupportedLocalesNotDefined
	 */
	public function getLocalePath($locale = null)
	{
		if (empty($locale)) {
			$locale = $this->getCurrentLocale();
		}
		
		$path = '';
		if (!currentLocaleShouldBeHiddenInUrl($locale)) {
			$path = $locale . '/';
		}
		
		return $path;
	}
	
	/**
	 * Get the URL Path (without URL Protocol & Host)
	 *
	 * @param $url
	 * @param null $locale
	 * @return mixed
	 * @throws Exceptions\SupportedLocalesNotDefined
	 */
	public function getUrlPath($url, $locale = null)
	{
		// Get Locale path
		$localePath = $this->getLocalePath($locale);
		
		if (Str::contains($url, 'http://') || Str::contains($url, 'https://')) {
			$basePath = '/' . $localePath;
			$baseUrl = url('/') . preg_replace('#/+#ui', '/', $basePath);
			$url = str_replace($baseUrl, '', $url);
		}
		
		return $url;
	}
	
	/**
	 * Get the Country Code
	 *
	 * @param array $attributes
	 * @return mixed|null|string
	 */
	public function getCountryCode($attributes = [])
	{	
		$countryCode = null;
		
		// Get the default Country
		// NOTE: The current method is generally called from views links, so all the settings are already set.
		$countryCode = strtolower(config('country.code'));
		
		// Get the Country
		if (empty($countryCode)) {
			if (isset($attributes['countryCode']) && !empty($attributes['countryCode'])) {
				$countryCode = $attributes['countryCode'];
			}
		}
		if (empty($countryCode)) {
			if (request()->filled('d')) {
				$countryCode = strtolower(request()->input('d'));
			}
		}
		
		return $countryCode;
	}

	public function getCountryCodeData($locale = null){

		$countryCodeName = null;

		if (!empty($locale)) {
			if($locale == 'en'){
				$countryCodeName = 'US';
			}
			else if($locale == 'de'){
				$countryCodeName = 'DE';
			}
		}
		return $countryCodeName;
	}
	
	/**
	 * Get Category by Slug
	 *
	 * @param $slug
	 * @param $locale
	 * @return null
	 */
	public static function getCategoryBySlug($slug, $locale)
	{
		$cat = null;
		
		if ($slug == '' || $locale == '') {
			return $cat;
		}
		
		$tmpCat = Category::transIn(config('app.locale'))->where('slug', 'LIKE', $slug)->first();
		if (!empty($tmpCat)) {
			$cat = Category::transById($tmpCat->tid, $locale);
		}
		
		return $cat;
	}

	/**
	 * Get model Category parent id by Slug
	 *
	 * @param $id
	 * @param $locale
	 * @return null
 	*/

	public static function getModelCategoryBySlug($id, $locale)
	{
		return $category = \App\Models\ModelCategory::where(function($q) use ($id) {
                    $q->where('id', $id)
                    ->orWhere('translation_of', $id);
                })
                ->where('translation_lang', $locale)
                ->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang','slug')
                ->first();
	}


	/**
	 * Get Blog Tags parent id by Slug
	 *
	 * @param $id
	 * @param $locale
	 * @return null
 	*/

	public static function getBlogTagBySlug($id, $locale)
	{	
		return $tag = \App\Models\BlogTag::where(function($q) use ($id) {
                    $q->where('id', $id)
                    ->orWhere('translation_of', $id);
                })
                ->where('translation_lang', $locale)
				->select('id', 'tag', 'translation_of', 'translation_lang','slug')
                ->first();
	}

	
	/**
	 * Get Sub-category by the Category translated's ID and by Sub-category's Slug
	 *
	 * @param $parentTid
	 * @param $slug
	 * @param $locale
	 * @return null
	 */
	public static function getSubCategoryBySlug($parentTid, $slug, $locale)
	{
		$subCat = null;
		
		if ($slug == '' || $locale == '') {
			return $subCat;
		}
		
		$tmpSubCat = Category::transIn(config('app.locale'))->where('parent_id', $parentTid)->where('slug', 'LIKE', $slug)->first();
		if (!empty($tmpSubCat)) {
			$subCat = Category::transById($tmpSubCat->tid, $locale);
		}
		
		return $subCat;
	}
	
	/**
	 * Get Page by Slug
	 *
	 * @param $slug
	 * @param $locale
	 * @return null
	 */
	public static function getPageBySlug($slug, $locale)
	{
		$page = null;
		
		if ($slug == '' || $locale == '') {
			return $page;
		}
		
		$tmpPage = Page::transIn(config('app.locale'))->where('slug', 'LIKE', $slug)->first();
		if (!empty($tmpPage)) {
			$page = Page::transById($tmpPage->tid, $locale);
		}
		
		return $page;
	}
	
	/**
	 * Don't translate these path or folders
	 *
	 * @return bool
	 */
	public function exceptRedirectionPath()
	{
		// Use url() for this paths
		if (in_array($this->request->segment(1), [
			'_debugbar',
			'assets',
			'css',
			'js',
			'pic',
			'ajax',
			'api',
			'script',
			'tools',
			'images',
			'admin',
			'home',
		])) {
			return true;
		}
		
		return false;
	}

	public function getBlogCategoryBySlug($id, $locale)
	{	
		
		// $CountryCodeName = $this->getCountryCodeData($locale);
		
		return $blogCategory = \App\Models\BlogCategory::where(function($q) use ($id) {
                    $q->where('id', $id)
                    ->orWhere('translation_of', $id);
                })
                ->where('translation_lang', $locale)
                // ->where('country_code', $CountryCodeName)
                ->select('id', 'country_code', 'translation_of', 'translation_lang','slug','name', 'active')
                ->first();
	}

	public function getBlogBySlug($id, $locale)
	{	
		// $CountryCodeName = $this->getCountryCodeData($locale);
		
		return $blogCategory = \App\Models\BlogEntry::where(function($q) use ($id) {
                    $q->where('id', $id)
                    ->orWhere('translation_of', $id);
                })
                ->where('translation_lang', $locale)
                // ->where('country_code', $CountryCodeName)
                ->select('id', 'country_code', 'translation_of', 'translation_lang','slug','name', 'active')
                ->first();
	}
}
