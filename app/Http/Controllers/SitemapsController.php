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

/*
 * Increase PHP page execution time for this controller.
 * NOTE: This function has no effect when PHP is running in safe mode (http://php.net/manual/en/ini.sect.safe-mode.php#ini.safe-mode).
 * There is no workaround other than turning off safe mode or changing the time limit (max_execution_time) in the php.ini.
 */
set_time_limit(0);

use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\Category;
use App\Models\Page;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\City;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Watson\Sitemap\Facades\Sitemap;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Response;
use App\Models\BlogEntry;
use App\Models\ModelCategory;
use App\Models\Branch;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\BlogCategory;
use App\Models\BlogTag;

class SitemapsController extends FrontController
{
    protected $defaultDate = '2015-10-30T20:10:00+02:00';

    /**
     * SitemapsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        // $page_terms = $page_termsclient = array();
        // if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
        //     foreach($this->pages as $page){
        //         if($page->type == "terms"){
        //             $page_terms = $page;
        //         }elseif($page->type == "termsclient") {
        //             $page_termsclient = $page;
        //         }
        //     }
        // }
        // view()->share('page_terms', $page_terms);
        // view()->share('page_termsclient', $page_termsclient);
        
        // Get Countries
        $this->countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
            // get terms and conditions for country code wise
            $this->getTermsConditions();
			return $next($request);
		});
    }

	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		// Set the App Language
		App::setLocale(config('app.locale'));

		// Date : Carbon object
		$this->defaultDate = Carbon::parse(date('Y-m-d H:i'));
		if (config('timezone.id')) {
			$this->defaultDate->timezone(config('timezone.id'));
		}
	}
    
    /**
     * Index Sitemap
     * @return mixed
     */
    public function index()
    {
        foreach ($this->countries as $item) {
            $country = CountryLocalization::getCountryInfo($item->get('code'));
            Sitemap::addSitemap(url($country->get('lang')->get('abbr') . '/' . $country->get('icode') . '/sitemaps.xml'));
        }
        
        return Sitemap::index();
    }
    
    /**
     * Index Sitemap
     * @return mixed
     */
    public function site()
    {
    	if (empty(config('country.code'))) {
    		return false;
		}
		
        Sitemap::addSitemap(url(config('app.locale') . '/' . config('country.icode') . '/sitemaps/pages.xml'));
        Sitemap::addSitemap(url(config('app.locale') . '/' . config('country.icode') . '/sitemaps/categories.xml'));
        Sitemap::addSitemap(url(config('app.locale') . '/' . config('country.icode') . '/sitemaps/cities.xml'));

        $countPosts = Post::verified()->currentCountry()->count();
        if ($countPosts > 0) {
            Sitemap::addSitemap(url(config('app.locale') . '/' . config('country.icode') . '/sitemaps/posts.xml'));
        }
        
        return Sitemap::index();
    }
    
    /**
     * @return mixed
     */
    public function pages()
    {
		if (empty(config('country.code'))) {
			return false;
		}
		
		$queryString = '?d=' . config('country.code');
		
        Sitemap::addTag(lurl('/' . $queryString), $this->defaultDate, 'daily', '1.0');
        $attr = ['countryCode' => config('country.icode')];
        Sitemap::addTag(lurl(trans('routes.v-sitemap', $attr) . $queryString, $attr), $this->defaultDate, 'daily', '0.5');
        Sitemap::addTag(lurl(trans('routes.v-search', $attr) . $queryString, $attr), $this->defaultDate, 'daily', '0.6');
    
        $pages = Cache::remember('pages.' . config('app.locale'), $this->cacheExpiration, function () {
            $pages = Page::trans()->orderBy('lft', 'ASC')->get();
            return $pages;
        });
        
        if ($pages->count() > 0) {
            foreach($pages as $page) {
            	$attr = ['slug' => $page->slug];
                Sitemap::addTag(lurl(trans('routes.v-page', $attr), $attr), $this->defaultDate, 'daily', '0.7');
            }
        }

        Sitemap::addTag(lurl(trans('routes.contact') . $queryString), $this->defaultDate, 'daily', '0.7');
        
        return Sitemap::render();
    }

    /**
     * @return mixed
     */
    public function categories()
    {
		if (empty(config('country.code'))) {
			return false;
		}
		
        // Categories
        $cacheId = 'categories.' . config('app.locale') . '.all';
        $cats = Cache::remember($cacheId, $this->cacheExpiration, function () {
            $cats = Category::trans()->orderBy('lft')->get();
            return $cats;
        });

        if ($cats->count() > 0) {
            $cats = collect($cats)->keyBy('translation_of');
            $cats = $subCats = $cats->groupBy('parent_id');
            $cats = $cats->get(0);
            $subCats = $subCats->forget(0);

           if(isset($cats) && !empty($cats)){
                foreach ($cats as $cat) { echo "<pre>"; 
                	$attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug];
                    Sitemap::addTag(lurl(trans('routes.v-search-cat', $attr), $attr), $this->defaultDate, 'daily', '0.8');
                    if ($subCats->get($cat->id)) {
                        foreach ($subCats->get($cat->id) as $subCat) {
                        	$attr = [
    							'countryCode' => config('country.icode'),
    							'catSlug'     => $cat->slug,
    							'subCatSlug'  => $subCat->slug
    						];
                            Sitemap::addTag(lurl(trans('routes.v-search-subCat', $attr), $attr), $this->defaultDate, 'weekly', '0.5');
                        }
                    }
                }
           }

        }

        return Sitemap::render();
    }
    
    /**
     * @return mixed
     */
    public function cities()
    {
		if (empty(config('country.code'))) {
			return false;
		}
		
        $limit = 1000;
        $cacheId = config('country.code') . '.cities.take.' . $limit;
        $cities = Cache::remember($cacheId, $this->cacheExpiration, function () use($limit) {
            $cities = City::currentCountry()->take($limit)->orderBy('population', 'DESC')->orderBy('name')->get();
            return $cities;
        });

        if ($cities->count() > 0) {
            foreach($cities as $city) {
                $city->name = trim(head(explode('/', $city->name)));
                $attr = [
					'countryCode' => config('country.icode'),
					'city'        => slugify($city->name),
					'id'          => $city->id
				];
                Sitemap::addTag(url(trans('routes.v-search-city', $attr), $attr), $this->defaultDate, 'weekly', '0.7');
            }
        }
        
        return Sitemap::render();
    }
    
    /**
     * @return mixed
     */
    public function posts()
    {
		if (empty(config('country.code'))) {
			return false;
		}
		
        $limit = 50000;
        $cacheId = config('country.code') . '.sitemaps.posts.xml';
        $posts = Cache::remember($cacheId, $this->cacheExpiration, function () use($limit) {
            $posts = Post::verified()->currentCountry()->take($limit)->orderBy('created_at', 'DESC')->get();
            return $posts;
        });
        
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                Sitemap::addTag(lurl($post->uri), $post->created_at, 'daily', '0.6');
            }
        }
        
        return Sitemap::render();
    }

    public function generateXml(Request $request){

        Log::info('cron start to generate the pages, blogs, categories sitemap.xml', ['started at' => Carbon::parse(date('Y-m-d H:i'))]);

        // function call to get pages and generated xml content
        $pageContent = $this->pagesXML();

        if( isset($pageContent) && !empty($pageContent)){
            
            try{
              \File::put(public_path().'/pages.xml', $pageContent);
            }
            catch(\Exception $e){
              Log::info('error while generate page xml', ['error' => $e->getMessage()]);
            }
        }

        // function call to get blogs and generated xml content
        $blogContent = $this->blogsXML();

        if( isset($blogContent) && !empty($blogContent) ){
            
            try{
              \File::put(public_path().'/blogs.xml', $blogContent);
            }
            catch(\Exception $e){
              Log::info('error while generate blogs xml', ['error' => $e->getMessage()]);
            }
        }

        // function call to get model cateogry and generated xml content
        $modelCategoryContent = $this->categoriesXML();
        if( isset($modelCategoryContent) && !empty($modelCategoryContent) ){
            
            try{
              \File::put(public_path().'/categories.xml', $modelCategoryContent);
            }
            catch(\Exception $e){
              Log::info('error while generate categories xml', ['error' => $e->getMessage()]);
            }
        }

        Log::info('cron generated the pages, blogs, categories sitemap.xml', ['Ended at' => Carbon::parse(date('Y-m-d H:i'))]);

        // echo json_encode(['status' => true]); exit();
        return json_encode(['status' => true]);
    }
    
    public function pagesXML(){
        Log::info('start to generate page xml', ['Started at' => Carbon::parse(date('Y-m-d H:i'))]);

        // get all pages and create sitemap xml
        $pages = Page::withoutGlobalScopes()->where('active', 1)->whereNull('deleted_at')->orderBy('translation_lang')->get();
        $pageContent = "";

        if (isset($pages) && $pages->count() > 0) {
            $pageArr = array();

            foreach($pages as $key => $page) {
                // set locale based in page translation
                App::setLocale($page->translation_lang);
                
                //generate url from page slug                
                $attr = ['slug' => $page->slug];

                if(lurl(trans('routes.v-page', $attr), $attr)){
                    $pageArr[$key]['loc'] = lurl(trans('routes.v-page', $attr), $attr);
                    $pageArr[$key]['lastmod'] = $page->updated_at;
                    $pageArr[$key]['priority'] = '0.8';
                    $pageArr[$key]['changefreq'] = 'daily';
                }
            }

            $view = \View::make('sitemap.xmls', ['xmls' => $pageArr]);
            $pageContent = $view->render();
        }

        Log::info('end to generate page xml', ['counts' => count($pageArr)]);

        return $pageContent;
    }

    public function blogsXML(){

        Log::info('start to generate blog xml', ['Started at' => Carbon::parse(date('Y-m-d H:i'))]);
        
        $blogArr = $blogcatArr = $blogtagArr = array();

        // get all blogs and create sitemap xml
        $blogs = BlogEntry::withoutGlobalScopes()->where('active', 1)->whereNull('deleted_at')->orderBy('translation_lang')->get();
        $blogsContent = "";

        if (isset($blogs) && $blogs->count() > 0) {
            $blogArr = array();
            
            foreach($blogs as $key => $blog) {

                // set locale based in page translation
                App::setLocale($blog->translation_lang);
                
                //generate url from page slug                
                $attr = ['slug' => $blog->slug];

                if(lurl(trans('routes.v-magazine', $attr), $attr)){
                    $blogArr[$key]['loc'] = lurl(trans('routes.v-magazine', $attr), $attr);
                    $blogArr[$key]['lastmod'] = ($blog->updated_at)? $blog->updated_at : Carbon::parse(date('Y-m-d H:i'));
                    $blogArr[$key]['priority'] = '0.8';
                    $blogArr[$key]['changefreq'] = 'daily';
                }
            }
        }

        //get all blogs categories and create sitemap xml.
        $blogcategories = BlogCategory::withoutGlobalScopes()->where('active', 1)->whereNull('deleted_at')->orderBy('translation_lang')->get();

        if( isset($blogcategories) && !empty($blogcategories) ){
            foreach ($blogcategories as $key => $blogcat) {
                
                // set locale based in page translation
                App::setLocale($blogcat->translation_lang);

                //generate url from page slug                
                $catattr = ['slug' => $blogcat->slug];

                if(lurl(trans('routes.v-blog-category', $catattr), $catattr)){
                    $blogcatArr[$key]['loc'] = lurl(trans('routes.v-blog-category', $catattr), $catattr);
                    $blogcatArr[$key]['lastmod'] = ($blogcat->updated_at)? $blogcat->updated_at : Carbon::parse(date('Y-m-d H:i'));
                    $blogcatArr[$key]['priority'] = '0.8';
                    $blogcatArr[$key]['changefreq'] = 'daily';
                }
            }
        }

        /*
        // disable tags into the google sitemap xmls
        //get all blogs tags and create sitemap xml.
        $blogtags = BlogTag::withoutGlobalScopes()->whereNull('deleted_at')->orderBy('translation_lang')->get();

        if( isset($blogtags) && !empty($blogtags) ){
            foreach ($blogtags as $key => $blogtag) {
                
                // set locale based in page translation
                App::setLocale($blogtag->translation_lang);

                //generate url from page slug                
                $tagattr = ['slug' => $blogtag->slug];

                if(lurl(trans('routes.v-magazine-tag', $tagattr), $tagattr)){
                    $blogtagArr[$key]['loc'] = lurl(trans('routes.v-magazine-tag', $tagattr), $tagattr);
                    $blogtagArr[$key]['lastmod'] = ($blogtag->updated_at)? $blogtag->updated_at : Carbon::parse(date('Y-m-d H:i'));
                    $blogtagArr[$key]['priority'] = '0.8';
                    $blogtagArr[$key]['changefreq'] = 'daily';
                }
            }
        }
        */

        //merge all blogs, blogs category and blogs tags urls and generate single file
        // $mergeResult = array_merge($blogArr, $blogcatArr, $blogtagArr);
        $mergeResult = array_merge($blogArr, $blogcatArr);

        if(isset($mergeResult) && !empty($mergeResult) ){
            $view = \View::make('sitemap.xmls', ['xmls' => $mergeResult]);
            $blogsContent = $view->render();
        }

        Log::info('end to generate blog xml', ['counts' => count($mergeResult)]);
        return $blogsContent;
    }

    public function categoriesXML(){
        
        Log::info('start to generate cateogry xml', ['Started at' => Carbon::parse(date('Y-m-d H:i'))]);

        $modelCategories = ModelCategory::withoutGlobalScopes()->where('active', 1)->whereNull('deleted_at')->orderBy('translation_lang')->get();

        $modelcatArr = $categoryContent = array();

        if( isset($modelCategories) && $modelCategories->count() > 0 ){
            
           foreach($modelCategories as $key => $modelcat) {

                // set locale based in page translation
                App::setLocale($modelcat->translation_lang);

                if(lurl(trans('routes.'.$modelcat->page_route))){
                    $modelcatArr[$key]['loc'] = lurl(trans('routes.'.$modelcat->page_route));
                    $modelcatArr[$key]['lastmod'] = Carbon::parse(date('Y-m-d H:i'));
                    $modelcatArr[$key]['priority'] = '0.8';
                    $modelcatArr[$key]['changefreq'] = 'daily';
                }
            }

            $view = \View::make('sitemap.xmls', ['xmls' => $modelcatArr]);
            $categoryContent = $view->render();
        }

        Log::info('end to generate category xml', ['counts' => count($modelcatArr)]);
        return $categoryContent;
    }

    public function xmlCron()
    {
        // Get current Date.
        $date = new \DateTime();
        $date->modify('-1 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');

        Log::info('Hourly cron started', ['Started at' => Carbon::parse(date('Y-m-d H:i'))]);

        $message = 'nothing change in one last one hour';
        $status = false;
        
        /**
         * If BlogEntry update within one hour update xmls.
         */
        $lastOneHourUpdateBlogs = BlogEntry::withoutGlobalScopes()->where('updated_at', '>=',$formatted_date)->orderBy('updated_at', 'desc')->count();
        // ->whereRaw('DATE_FORMAT("updated_at","%H:%i:%s") >= DATE_SUB(NOW(), INTERVAL 1 HOUR)')

        /**
         * If BlogCategory update within one hour update xmls.
         */
        $lastOneHourUpdateBlogCategories = BlogCategory::withoutGlobalScopes()->where('updated_at', '>=',$formatted_date)->orderBy('updated_at', 'desc')->count();

        /**
         * If BlogTag update within one hour update xmls.
         */
        //$lastOneHourUpdateBlogtags = BlogTag::withoutGlobalScopes()->where('updated_at', '>=',$formatted_date)->orderBy('updated_at', 'desc')->count();
       
        if($lastOneHourUpdateBlogs > 0 || $lastOneHourUpdateBlogCategories > 0 ){

            // function call to get blogs and generated xml content
            $blogContent = $this->blogsXML();

            if( isset($blogContent) && !empty($blogContent) ){
                
                try{
                    
                    \File::put(public_path().'/blogs.xml', $blogContent);

                    $message = "Successfully generate xml";
                    $status = true;
                }
                catch(\Exception $e){

                    $message = "Some error to generate xml";
                    $status = false;

                    Log::info('error while generate blogs xml', ['error' => $e->getMessage()]);
                }
            }
        }

        /**
         * If Page update within one hour update xmls.
         */
        $lastOneHourUpdatePages = Page::withoutGlobalScopes()->where('updated_at', '>=',$formatted_date)->orderBy('updated_at', 'desc')->count();

        if($lastOneHourUpdatePages > 0){

            // function call to get pages and generated xml content
            $pageContent = $this->pagesXML();

            if( isset($pageContent) && !empty($pageContent)){
                
                try{

                    \File::put(public_path().'/pages.xml', $pageContent);

                    $message = "Successfully generate xml";
                    $status = true;
                }
                catch(\Exception $e){

                    $message = "Some error to generate xml";
                    $status = false;

                    Log::info('error while generate page xml', ['error' => $e->getMessage()]);
                }
            }
        }

        /**
         * If ModelCategory update within one hour update xmls.
         */
        $lastOneHourUpdateModelCategories = ModelCategory::withoutGlobalScopes()->where('updated_at', '>=',$formatted_date)->orderBy('updated_at', 'desc')->count();

        if($lastOneHourUpdateModelCategories > 0){

            // function call to get model cateogry and generated xml content
            $modelCategoryContent = $this->categoriesXML();

            if( isset($modelCategoryContent) && !empty($modelCategoryContent) ){
                
                try{

                    \File::put(public_path().'/categories.xml', $modelCategoryContent);

                    $message = "Successfully generate xml";
                    $status = true;
                }
                catch(\Exception $e){

                    $message = "Some error to generate xml";
                    $status = false;

                    Log::info('error while generate categories xml', ['error' => $e->getMessage()]);
                }
            }
        }

        Log::info('Hourly cron ended', ['Ended at' => Carbon::parse(date('Y-m-d H:i'))]);
        echo json_encode( array('status' => $status,'message' => $message ));
        exit(); 
    }
}
