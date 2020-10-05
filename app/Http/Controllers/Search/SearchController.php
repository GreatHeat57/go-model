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

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Http\Controllers\Search\Traits\PreSearchTrait;
use Illuminate\Support\Facades\Request as RequestFacade;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\SavedPost;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\CommonHelper;
use App\Models\ModelCategory;
use App\Models\PostType;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;


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

		view()->share('isIndexSearch', $this->isIndexSearch);

		if(!empty($slug)){
			view()->share('uriPathPageSlug', $slug);
		}
		if (RequestFacade::filled('l') || RequestFacade::filled('location')) {
			$city = $this->getCity(RequestFacade::input('l'), RequestFacade::input('location'));
		}
		if (RequestFacade::filled('r') && !RequestFacade::filled('l')) {
			$admin = $this->getAdmin(RequestFacade::input('r'));
		}

		$user_type = auth()->user()->user_type_id;

		//get user profile completed value
		$is_profile_completed = auth()->user()->is_profile_completed;

		$favourite_posts = $dataArr = array();
		$favourite_posts = SavedPost::getFavouritePostsById(auth()->user()->id);
		$req = $request->all();

		$is_favourites = 0;

		if($slug == t('favourites'))
		{
		 	$is_favourites = 1;
		}


		if ($user_type == config('constant.model_type_id') && !Gate::allows('view_jobs', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }
 
		// return favourites page from database
		if($user_type == config('constant.model_type_id') && $is_favourites == true && Gate::allows('view_favourites_jobs_page', auth()->user())){
			// return to the show page
			return $this->showShortlistPage();
		}

		$preSearch = $this->preSearchData($req, $is_favourites);

		//get all post_type	 
		$post_type = PostType::trans()->pluck('name','translation_of')->toArray();
		$dataArr['post_type'] = $post_type;

		$data = array();


		
		// if logged in user is free user then do not allow to see any jobs
		if(!CommonHelper::checkUserType(config('constant.country_free')) && isset(auth()->user()->user_register_type) && auth()->user()->country->country_type !== config('constant.user_type_free') && $user_type == config('constant.model_type_id')){
			//check if model update their profile then show the job list
			if($is_profile_completed === '1'){
				// Search
				$search = new Search($preSearch);
				$data = $search->fechAll();
			}
		}else if($user_type == config('constant.partner_type_id')){
			
			$search = new Search($preSearch);
			$data = $search->fechAll();
		}


		// get all active Country , cities 
		// $city = Country::getAllActiveCountryCity();

		// Export Search Result
		$dataArr['count'] = isset($data['count'])? $data['count'] : 0;
		$dataArr['paginator'] = isset($data['paginator'])? $data['paginator'] : [];
		$dataArr['favourite_posts'] = $favourite_posts;
		$dataArr['favourites_tab'] = $is_favourites;
		// view()->share('cities', $city);
		// Get Titles
		$user_type = 0;
		if(isset($preSearch['user_type'])){
			if($preSearch['user_type'] == 3){
				$user_type = 3;
				if($is_favourites == 1){
					$title = t('meta-model-job-list-favourite - :app_name', ['app_name' => config('app.app_name')]);
				}else{
					$title = t('meta-model-job-list - :app_name', ['app_name' => config('app.app_name')]);
				}
			}
		}
		if($user_type !== 3){
			if($is_favourites == 1){
				$title = t('meta-job-list-favourite - :app_name', ['app_name' => config('app.app_name')]);
			}else{
				$title = t('meta-job-list - :app_name', ['app_name' => config('app.app_name')]);
			}
		}

		// $title .= $this->getTitle();

		$metaArr['title'] = $title;
		
		CommonHelper::gojobMeta($metaArr);
		
		$this->getBreadcrumb();
		$this->getHtmlTitle();

		// Meta Tags
		MetaTag::set('title', $title);
		// MetaTag::set('description', $descripeion);

		$dataArr['pageNo'] = 1;
		$lastPage = 0;
		$is_last_page = 0;


		if (isset($dataArr['paginator']) && count($dataArr['paginator'])  > 0) {

			if($dataArr['paginator']->is_last_page == 1){
				$is_last_page = 1;
			}
			
				$lastPage = $dataArr['paginator']->lastPage();
				$currentPage =  $dataArr['paginator']->currentPage();

				// if($lastPage == 1 && $currentPage == 1){
				// 	$is_last_page = 1;
				// }
				// if($lastPage > 1){
				// 	if($currentPage >= $lastPage){
				// 		$dataArr['pageNo'] = $lastPage;
				// 		$is_last_page = 1;
				// 	}else{
						$dataArr['pageNo'] = $currentPage + 1;
					// }
				// }
		}

		$dataArr['is_last_page'] = $is_last_page;

		if ($request->ajax()) {
			
			$returnHTML = view('search.inc.posts' , $dataArr)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $dataArr['pageNo'], 'is_last_page' => $dataArr['is_last_page']));
		}

		
		// echo "<pre>"; print_r ($dataArr); echo "</pre>"; exit();
		return view('search.search', $dataArr);
		//return view('model/find-work');
	}
	
	public function preSearchData($req = array(), $is_favourites = 0, $postId = null){
		
		$user_type = auth()->user()->user_type_id;

		// Pre-Search values
		$preSearch = [
			
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
			'user_type' => (isset($user_type) && !empty($user_type)) ? $user_type : null,
		];

		if(is_array($req)){
			$preSearch['search_content'] = (isset($req['search_content']) && !empty($req['search_content'])) ? $req['search_content'] : null;
		}

		$preSearch['is_baby_model'] = false;

		if( $user_type == 3 ){
			
			$preSearch['height_id'] = (auth()->user()->profile->height_id)? auth()->user()->profile->height_id : '';

			$preSearch['weight_id'] = (auth()->user()->profile->weight_id)? auth()->user()->profile->weight_id : '';

			$preSearch['size_id'] = (auth()->user()->profile->size_id)? auth()->user()->profile->size_id : '';

			$preSearch['chest_id'] = (auth()->user()->profile->chest_id)? auth()->user()->profile->chest_id : '';

			$preSearch['waist_id'] = (auth()->user()->profile->waist_id)? auth()->user()->profile->waist_id : '';

			$preSearch['hips_id'] = (auth()->user()->profile->hips_id)? auth()->user()->profile->hips_id : '';
			
			$preSearch['shoes_size_id'] = (auth()->user()->profile->shoes_size_id)? auth()->user()->profile->shoes_size_id : '';

			$preSearch['eye_color_id'] = (auth()->user()->profile->eye_color_id)? auth()->user()->profile->eye_color_id : '';

			$preSearch['hair_color_id'] = (auth()->user()->profile->hair_color_id)? auth()->user()->profile->hair_color_id : '';

			$preSearch['skin_color_id'] = (auth()->user()->profile->skin_color_id)? auth()->user()->profile->skin_color_id : '';
			
			$preSearch['model_category_id'] = (auth()->user()->profile->category_id)? auth()->user()->profile->category_id : '';

			$preSearch['category_id'] = (auth()->user()->profile->parent_category)? auth()->user()->profile->parent_category : '';

			if(auth()->user()->profile->birth_day && !empty(auth()->user()->profile->birth_day) 
				&& auth()->user()->profile->birth_day != null 
				&& auth()->user()->profile->birth_day != '0000-00-00')
			{
				// $now = time();
				// $dob = strtotime(auth()->user()->profile->birth_day);
				// $age = "";
				// $difference = $now - $dob;
				// $age = floor($difference / 31556926);
                
                $from = new \DateTime(auth()->user()->profile->birth_day);
                $to = new \DateTime('today');
                    
                if($from->diff($to)->y >= 1 ){
                	// years
                    $y = $from->diff($to)->y;
                    $age =  ($y) ? ($y > 1 ) ? $y : $y : '';
                }else{
                	// months
                    $m = $from->diff($to)->m;
                    if($m > 0){
	                    $age =  ($m)? ($m > 1 )? $m : $m : '';
						$age = number_format($age/100, 2);
                    }
				} 
				
				if($age && $age > 0 ){
					$preSearch['age'] = trim($age);
				}
			}

			if( isset($preSearch['model_category_id']) && !empty($preSearch['model_category_id']) ){
				$modelCategory = ModelCategory::find($preSearch['model_category_id']);

				if( isset($modelCategory) && !empty($modelCategory) ){
					$preSearch['is_baby_model'] = $modelCategory->is_baby_model;
				}
			}


		} else {
			$preSearch['partner_category_id'] = (auth()->user()->profile->category_id)? auth()->user()->profile->category_id : '';
		}

		$preSearch['gender_id'] = (auth()->user()->gender_id)? auth()->user()->gender_id : '';
		
		if(is_array($req)){
			if(isset($req['category_id']) && !empty($req['category_id'])){
				$preSearch['category_id'] = $req['category_id'];
			}
		}
		
		if($is_favourites == 1)
		{	
		 	$preSearch['is_favourites'] = 1;
		}

		if(!is_array($req)){
			$preSearch['post_id'] = $postId;
		}

		return $preSearch;
	}

	public function showShortlistPage(){

		// Get the Page
		$page = Page::where('slug', 'short-list')->trans()->first();

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
		return view('post.shortlist');
	}
}
