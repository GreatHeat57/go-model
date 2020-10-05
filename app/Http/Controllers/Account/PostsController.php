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

namespace App\Http\Controllers\Account;

use App\Helpers\Arr;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Search;
use App\Helpers\UnitMeasurement;
use App\Http\Controllers\Search\Traits\PreSearchTrait;
use App\Mail\PostDeleted;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Company;
use App\Models\ExperienceType;
use App\Models\Message;
use App\Models\ModelCategory;
use App\Models\Package;
use App\Models\Post;
use App\Models\PostType;
use App\Models\SalaryType;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\ValidValue;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\CommonHelper;
use App\Models\Gender;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use Illuminate\Support\Str;

class PostsController extends AccountBaseController {
	use PreSearchTrait;

	private $perPage = 12;

	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		view()->share('perPage', $this->perPage);

		$this->middleware(function ($request, $next) {
			$this->commonQueries();

			return $next($request);
		});
	}

	/**
	 * @param $pagePath
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
	 */
	public function getPage($pagePath, HttpRequest $request) {

		if (!$request->isMethod('post')) {

			view()->share('pagePath', $pagePath);
			view()->share('genders', Gender::trans()->get());

			switch ($pagePath) {
			case 'my-posts':
				return $this->getMyPosts($pagePath);
				break;
			case 'archived':
				return $this->getArchivedPosts($pagePath);
				break;
			case 'favourite':
				return $this->getFavouritePosts();
				break;
			case 'pending-approval':

				if (!Gate::allows('list_jobs', auth()->user())) {
		            flash("You are not allow to access this page")->error();
					return redirect(config('app.locale'));
		        }
		        
				return $this->getPendingApprovalPosts();
				break;
			default:
				abort(404);
			}

		} else {
			return $this->getMyPosts($pagePath, $request->all());
		}

	}

	/**
	 * @return View
	 */
	public function getMyPosts($pagePath, $requestData = array()) {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$data = [];

		$data = Post::getUserPostById(Auth::User()->id, $pagePath, $this->perPage);
		//view()->share('pagePath', $pagePath);

		$data['pagePath'] = $pagePath;


		// Meta Tags
		MetaTag::set('title', t('My ads - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My ads on :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		return view('partner.my-posted-jobs', $data);
	}

	/**
	 * @param $pagePath
	 * @param null $postId
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
	 */
	public function getArchivedPosts($pagePath, $postId = null) {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		// If repost

		if (Str::contains(URL::current(), $pagePath . '/' . $postId . '/repost')) {
			$res = false;
			if (is_numeric($postId) and $postId > 0) {
				$res = Post::find($postId)->update([
					'archived' => 0,
					'created_at' => Carbon::now(),
				]);
			}
			if (!$res) {
				flash(t("The repost has done successfully"))->success();
			} else {
				flash(t("The repost has failed, Please try again"))->error();
			}

			return redirect(config('app.locale') . '/account/' . $pagePath);
		}

		$data = [];

		$data = Post::getUserPostById(Auth::User()->id, $pagePath, $this->perPage);

		$data['pagePath'] = $pagePath;
		$data['type'] = 'archived';

		// $data['posts'] = $this->archivedPosts->paginate($this->perPage);
		// $data['paginator'] = $this->archivedPosts->paginate($this->perPage);
		// $data['count'] = $this->archivedPosts->count();

		// Meta Tags
		MetaTag::set('title', t('My archived ads - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My archived ads on :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();
		return view('partner.my-posted-jobs', $data);
	}

	/**
	 * @return View
	 */
	public function getFavouritePosts() {
		$data = [];

		$data['posts'] = SavedPost::getMyFavourites(Auth::User()->id, $this->perPage, $count = null);
		$data['paginator'] = SavedPost::getMyFavourites(Auth::User()->id, $this->perPage, $count = null);
		$data['count'] = SavedPost::getMyFavourites(Auth::User()->id, $this->perPage, $count = true);

		// echo "<pre>";
		// print_r($data['posts']);
		// echo "</pre>";
		// Meta Tags
		MetaTag::set('title', t('My favourite jobs'));
		MetaTag::set('description', t('My favourite jobs on :app_name', ['app_name' => config('settings.app.name')]));

		$data['type'] = 'favourite';

		// return view('account.posts', $data);

		return view('model/my-favourite-jobs', $data);
	}

	/**
	 * @return View
	 */
	public function getPendingApprovalPosts() {
		$data = [];
		$data['posts'] = Post::myPendingPosts(Auth::User()->id, $this->perPage, $count = null);
		$data['paginator'] = Post::myPendingPosts(Auth::User()->id, $this->perPage, $count = null);
		$data['count'] = Post::myPendingPosts(Auth::User()->id, $this->perPage, $count = true);
		$data['type'] = 'pending-approval';

		// Meta Tags
		MetaTag::set('title', t('My pending approval ads'));
		MetaTag::set('description', t('My pending approval ads on :app_name', ['app_name' => config('settings.app.name')]));

		return view('partner.my-posted-jobs', $data);
	}

	/**
	 * @param HttpRequest $request
	 * @return View
	 */
	public function getSavedSearch(HttpRequest $request) {
		$data = [];

		// Get QueryString
		$tmp = parse_url(url(Request::getRequestUri()));
		$queryString = (isset($tmp['query']) ? $tmp['query'] : 'false');
		$queryString = preg_replace('|\&pag[^=]*=[0-9]*|i', '', $queryString);

		// CATEGORIES COLLECTION
		$cats = Category::trans()->orderBy('lft')->get();
		$cats = collect($cats)->keyBy('translation_of');
		view()->share('cats', $cats);

		// Search
		$savedSearch = SavedSearch::currentCountry()
			->where('user_id', auth()->user()->id)
			->orderBy('created_at', 'DESC')
			->simplePaginate($this->perPage, ['*'], 'pag');

		if (collect($savedSearch->getCollection())->keyBy('query')->keys()->contains($queryString)) {
			parse_str($queryString, $queryArray);

			// QueryString vars
			$cityId = isset($queryArray['l']) ? $queryArray['l'] : null;
			$location = isset($queryArray['location']) ? $queryArray['location'] : null;
			$adminName = (isset($queryArray['r']) && !isset($queryArray['l'])) ? $queryArray['r'] : null;

			// Pre-Search
			$preSearch = [
				'city' => $this->getCity($cityId, $location),
				'admin' => $this->getAdmin($adminName),
			];

			if ($savedSearch->getCollection()->count() > 0) {
				// Search
				$search = new Search($preSearch);
				$data = $search->fechAll();
			}
		}
		$data['savedSearch'] = $savedSearch;

		// Meta Tags
		MetaTag::set('title', t('My saved search'));
		MetaTag::set('description', t('My saved search on :app_name', ['app_name' => config('settings.app.name')]));

		view()->share('pagePath', 'saved-search');

		return view('account.saved-search', $data);
	}

	/**
	 * @param null $id
	 * @return View
	 */
	public function getApplications($id = null, HttpRequest $request) { 
		
		$req = $request->all();

		$search = '';

		if(isset($req['search'])){
		 	if(!empty($req['search'])){
		 		$search = $req['search'];
		 	}
		}
		 
		$jobs = JobApplication::select('job_applications.post_id as post_id', 'job_applications.user_id as user_id',
				'messages.id as message_id', 'messages.parent_id as message_parent_id', 'from_user_id', 'from_name', 'from_email', 'from_phone', 'to_user_id', 'to_name', 'to_email', 'to_phone', 'subject', 'message', 'filename', 'is_read', 'invitation_status', 'message_type')
				->with('user')
				->with('user.profile')
				->leftjoin('messages', function ($join) {
		            $join->on('messages.post_id', '=', 'job_applications.post_id')
		            	->on(function($join){
		            		$join->whereRaw('messages.from_user_id = job_applications.user_id OR messages.to_user_id = job_applications.user_id');

		            		//->orwhere('messages.to_user_id', 'job_applications.user_id');
		            	})
		            	 // ->on('messages.from_user_id', '=', 'job_applications.user_id')->orOn('messages.to_user_id', '=', 'job_applications.user_id')
		            	 ->whereIn('messages.message_type', ['Job application','Invitation'])
		            	 ->where('messages.invitation_status', '1')
		            	 ->where('messages.parent_id', '=', 0);
		        })
		        ->whereHas('user')
				->where('job_applications.post_id', $id);

		if(!empty($search)){
			$jobs->whereHas('user', function ($query) use ($search) {
                $query->where('username', 'like', '%'.$search.'%');
                    // ->orWhere('posts.title', 'like', '%'.$search.'%');
            });
        }

       	$applications = $jobs->orderby('job_applications.id','DESC')->paginate($this->perPage);

		$data['pageNo'] = 0;
		$lastPage = 0;
		$is_last_page = 0;

		if(!empty($applications) && count($applications) > 0){
		 	
		 	$currentPage = $applications->currentPage();
		 	$lastPage = $applications->lastPage();
		 	
		 	if($lastPage == 1 && $currentPage == 1){
				$is_last_page = 1;
			}

			if($lastPage > 1){
				
				if($currentPage >= $lastPage){
					$data['pageNo'] = $lastPage;
					$is_last_page = 1;
				}else{
					$data['pageNo'] = $currentPage + 1;
				}
			}
		}

		$data['is_last_page'] = $is_last_page;

		// echo $applications->currentPage();
		// echo "<pre>"; print_r($applications->lastPage()); echo "</pre>"; die();

		// $applications = Message::where('post_id', $id)->where('to_user_id', auth()->user()->id)->groupBy('from_user_id')->paginate($this->perPage);

		// $data['paginator'] = $this->pendingPosts->paginate($this->perPage);
		// $data['applications'] = $applications->paginate($this->perPage);
		

		// echo "<pre>"; print_r($applications->lastPage()); echo "</pre>"; die();
		$data['applications'] = $applications;
		$data['pagePath'] = 'cadidates';
		// $data['paginator'] = $applications;

		$post = array();
		$ismodel = 0;
		$postTitle = '';

		// Meta Tags
		MetaTag::set('title', t('Job Applicants'));
		MetaTag::set('description', t('Job Applicants on :app_name', ['app_name' => config('settings.app.name')]));

		if ($request->ajax()) {
				
			$data['ismodel'] = $req['ismodel'];
			$data['postTitle'] = $req['postTitle'];
			
			$returnHTML = view('account.inc.job-application-list' , $data)->render();
			
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['pageNo'], 'is_last_page' => $data['is_last_page']));
		}else{
			
			$post = Post::find($id);
			$ismodel =  isset($post->ismodel) ? $post->ismodel : 0;
			$postTitle =  isset($post->title) ? $post->title : '';
		}

		$data['post'] = $post;
		$data['ismodel'] = $ismodel;
		$data['postTitle'] = $postTitle;

		return view('account.applications', $data);
	}

	/**
	 * @param $pagePath
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($pagePath, $id = null) {

		// Get Entries ID
		$ids = [];
		if (Request::filled('entries')) {
			$ids = Request::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}

		$posts = Post::whereIn('id', $ids)->where('user_id', Auth::user()->id)->get();

		$is_applied_jobs = false;
		$jobs_names = array();
		$jobs_ids = array();
		$completed_count = 0;

		if(isset($ids) && count($ids) > 0 ){
			$jobs_ids = $ids;
		}else{
			flash(t('Please select an item from the list'))->error();
			return redirect(config('app.locale') . '/account/' . $pagePath);
		}

		if( isset($jobs_ids) && count($jobs_ids) > 0 ){
			
			try{
				$deleted_at = \Carbon\Carbon::now();

				SavedPost::whereIn('post_id', $jobs_ids)->delete();
				Post::whereIn('id', $jobs_ids)->update(['deleted_at'=> $deleted_at]);
				$completed_count = count($jobs_ids);

			}catch(\Exception $e){
				flash($e->getMessage())->error();
				return redirect(config('app.locale') . '/account/' . $pagePath);
			}
			
		}

		if($completed_count > 0 ){

			if($completed_count > 1){
				flash(t("Your jobs have been deleted successfully"))->success();
			}else{
				flash(t("Your job has been deleted successfully"))->success();
			}

		}else{
			flash(t("No deletion is done, Please try again"))->error();
		}

		return redirect(config('app.locale') . '/account/' . $pagePath);
	}

	public function getMyPostSearch($pagePath, HttpRequest $request) {

		view()->share('genders', Gender::trans()->get());

		$data['formData'] = [];

		switch ($pagePath) {

		case 'my-posts':

			$query 	= 	Post::select('posts.*')
							->where('user_id', Auth::User()->id)
							->join('jobs_translation as jt', function($q){
	            				$q->on('posts.id', '=', 'jt.job_id');
	            				$q->where('translation_lang', config('app.locale'));
							})
						->where('archived', 0);
			break;

		case 'archived':

			$query 	= 	Post::select('posts.*')
							->where('user_id', Auth::user()->id)
							->join('jobs_translation as jt', function($q){
	            				$q->on('posts.id', '=', 'jt.job_id');
	            				$q->where('translation_lang', config('app.locale'));
							})
						->where('archived', 1);

			break;

		case 'favourite':
			$query = $this->favouritePosts->where('user_id', Auth::user()->id);

			break;

		case 'pending-approval':

			$query = $this->pendingPosts->where('user_id', Auth::user()->id);

			break;

		default:
			abort(404);
		}

		if (count($request->get('search')) > 0) {

			$formData = $request->get('search');

			$company_id = isset($formData['company_id']) ? $formData['company_id'] : '';
			$post_type = isset($formData['post_type']) ? $formData['post_type'] : '';
			$experience_type = isset($formData['experience_type']) ? $formData['experience_type'] : '';
			$gender_type = isset($formData['gender_type']) ? $formData['gender_type'] : '';

			$content = isset($formData['text']) ? $formData['text'] : '';

			if (isset($content) && !empty($content) && $content != "") {
				// $data->where('title','LIKE', '%' .$content. '%')->orwhere('description', 'LIKE', '%' . $content. '%');
				$query->Where(function ($query) use ($content) {
					$query->where('jt.title', 'LIKE', '%' . $content . '%')
						->orwhere('jt.description', 'LIKE', '%' . $content . '%');
				});
			}

			if (isset($company_id) && !empty($company_id) && $company_id > 0) {
				$query->where('company_id', $company_id);
			}

			if (isset($post_type) && !empty($post_type) && $post_type > 0) {
				$query->where('post_type_id', $post_type);
			}

			if (isset($experience_type) && !empty($experience_type) && $experience_type > 0) {
				$query->where('experience_type_id', $experience_type);
			}

			if (isset($gender_type) && !empty($gender_type) && $gender_type !== '') {
				$query->where('gender_type_id', $gender_type);
			}

			$data['formData'] = $formData;
		}

		view()->share('pagePath', $pagePath);

		$data['type'] = $pagePath;
		$data['count'] = $query->count();
		$data['paginator'] = $query->paginate($this->perPage);
		$data['posts'] = $query->orderby('posts.id', 'desc')->paginate($this->perPage);

		// Meta Tags
		MetaTag::set('title', t('My ads - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My ads on :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		if (Auth::User()->user_type_id == 2) {
			return view('partner.my-posted-jobs', $data);
		} else {
			return view('account.posts', $data);
		}
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		// References
		$data = [];

		// Get Countries
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $data['countries']);

		// Get Categories
		$cacheId = 'categories.parentId.0.with.children' . config('app.locale');
		$data['categories'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$categories = Category::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();

			return $categories;
		});
		view()->share('categories', $data['categories']);

		// Get ModelCategories
		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();

			return $modelCategories;
		});
		view()->share('modelCategories', $data['modelCategories']);

		// Get branches
		$cacheId = 'branches.parentId.0.with.children' . config('app.locale');
		$data['branches'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$branches = Branch::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();

			return $branches;
		});
		view()->share('branches', $data['branches']);

		// Experience types
		$data['experienceTypes'] = ExperienceType::all();
		view()->share('experienceTypes', $data['experienceTypes']);

		// properties
		$property = [];
		$validValues = ValidValue::all();
		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = (!empty($translate->value)) ? $translate->value : '';
		}

		//$unitArr = UnitMeasurement::getUnitMeasurement();
		//$property = array_merge($property, $unitArr);

		$unitArr = new UnitMeasurement();
		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);

		$data['properties'] = $property;
		view()->share('properties', $data['properties']);

		// Get Post Types
		$cacheId = 'postTypes.all.' . config('app.locale');
		$data['postTypes'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$postTypes = PostType::trans()->orderBy('lft')->get();

			return $postTypes;
		});
		view()->share('postTypes', $data['postTypes']);

		// Get Salary Types
		$cacheId = 'salaryTypes.all.' . config('app.locale');
		$data['salaryTypes'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$salaryTypes = SalaryType::trans()->orderBy('lft')->get();

			return $salaryTypes;
		});
		view()->share('salaryTypes', $data['salaryTypes']);

		if (Auth::check()) {
			// Get all the User's Companies
			$data['companies'] = Company::where('user_id', Auth::user()->id)->take(100)->orderByDesc('id')->get();
			view()->share('companies', $data['companies']);

			// Get the User's latest Company
			if ($data['companies']->has(0)) {
				$data['postCompany'] = $data['companies']->get(0);
				view()->share('postCompany', $data['postCompany']);
			}
		}

		$allPostCount = Post::where('user_id', Auth::User()->id)->where('archived', 0)->count();

		$allArchivedPosts = Post::where('user_id', Auth::User()->id)->where('archived', 1)->count();

		view()->share('allPostCount', $allPostCount);
		view()->share('allArchivedPosts', $allArchivedPosts);
		view()->share('jobApplied', Post::getAppliedJobs($this->perPage, $search= null, $count = true));
		 
		// Count Packages
		$data['countPackages'] = Package::trans()->applyCurrency()->count();
		view()->share('countPackages', $data['countPackages']);

		// Count Payment Methods
		$data['countPaymentMethods'] = $this->countPaymentMethods;

		// Save common's data
		$this->data = $data;
	}

	public function archivedPost($pagePath, $postId = null) {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		if (Str::contains(URL::current(), $pagePath . '/' . $postId . '/repost')) {

			$res = false;

			if (is_numeric($postId) and $postId > 0) {

				$res = Post::find($postId);

				//temp diable validation to check posts get any invitions or applications
				/*
				if( isset($res->postConversation) && $res->postConversation->count() > 0 && $res->archived == 0 )
				{
					flash(t("Unable to archive the jobs! one or more applications founds"))->error();
					return redirect(config('app.locale') . '/account/' . $pagePath);
				}*/

				if (isset($res) && !empty($res)) {

					if ($res->archived == 0) {
						$res->archived = 1;
					} else {
						$res->archived = 0;
					}

					$res->updated_at = Carbon::now();
					$res->save();
				}
			}

			if ($res) {

				if ($res->archived == 0) {
					flash(t("The repost has done successfully"))->success();
				} else {
					flash(t("The archive has done successfully"))->success();
				}
			} else {
				flash(t("The repost has failed, Please try again"))->error();
			}

			return redirect(config('app.locale') . '/account/' . $pagePath);
		}

	}

	public function getAppliedPosts(){
		$data = [];

		// return my application page from database
		if(Gate::allows('view_my_applications_page', auth()->user())){
			// return to the show page
			return $this->showMyApplicationPage();
		}

		if (!Gate::allows('applied_jobs', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }

		$data['paginator'] = Post::getAppliedJobs($this->perPage, $search= null, $count = false);

		view()->share('jobApplied', Post::getAppliedJobs($this->perPage, $search= null, $count = true));
		view()->share('pagePath', 'job-applied');
		view()->share('genders', Gender::trans()->get());

		// Meta Tags
		MetaTag::set('title', t('Jobs Applied - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('Jobs Applied on :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		return view('partner.my-posted-jobs', $data);
	}

	public function showMyApplicationPage(){

		// Get the Page
		$page = Page::where('slug', 'my-applications')->trans()->first();

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'my-applications');

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
		return view('post.my-application-page');
	}
}
