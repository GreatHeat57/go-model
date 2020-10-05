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
use App\Helpers\ModelSearch;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\JobRequest;
use App\Mail\FormSent;
use App\Mail\FeedbackSent;
use App\Mail\JobSent;
use App\Models\BlogCategory;
use App\Models\BlogEntry;
use App\Models\BlogTag;
use App\Models\Page;
use App\Models\ModelCategory;
use App\Models\Branch;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
// use Spatie\Backup\Notifications\Senders\Mail;
use Illuminate\Support\Facades\Storage;
use Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Post;
use DB;
use Log;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\Gate;

class PageController extends FrontController {
	/**
	 * @param $slug
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */

	private $perPage = 12;
	public $pagePath = 'magazin';
	private $popularBlogsLimit = 6;
	private $recentBlogsLimit = 3;
	private $recentBlogsCategoryLimit = 4;

	public function __construct() {

		parent::__construct();
		$this->popularBlogsLimit = (is_numeric(config('app.popular_blogs_limit'))) ? config('app.popular_blogs_limit') : $this->popularBlogsLimit;

		$this->recentBlogsLimit = (is_numeric(config('app.recent_blogs_limit'))) ? config('app.recent_blogs_limit') : $this->recentBlogsLimit;

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		$this->recentBlogsCategoryLimit = (is_numeric(config('app.recent_Blogs_category_limit'))) ? config('app.recent_Blogs_category_limit') : $this->recentBlogsCategoryLimit;

		view()->share('perPage', $this->perPage);

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			// get terms and conditions for country code wise
			$this->getTermsConditions();

			return $next($request);
		});

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
	}

	public function index($slug) {
		$slug = strtolower($slug);
		//check if slug is old wordpress locale
		if($slug == "at" || $slug == "li" || $slug == "ch"){
			return redirect("/de");
		}

		// Get the Page
		$slug = str_replace(config('app.locale').'/', '', $slug);
		$page = Page::where('slug', $slug)->trans()->first();

		// echo "<pre>"; print_r ($page); echo "</pre>"; exit();

		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();

		$data = array();
		$data['is_featured'] = false;

		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}
		
		if($slug === 'book-a-model' || $slug === 'model-buchen'){


			$preSearch = ['is_featured' => 1];

			// Search
			$search = new ModelSearch($preSearch);
			$data = $search->fechAll();

			$modelCategories = ModelCategory::trans()->where('parent_id', 0)
							  ->orderBy('ordering')
							  ->get();

			$data['modelCategories'] = $modelCategories;
			$data['is_featured'] = true;

			// Export Search Result
			view()->share('count', $data['count']);
			view()->share('paginator', $data['paginator']);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', $slug);

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		// Meta Tags
		// MetaTag::set('title', getMetaTag('title', $page->slug));
		// MetaTag::set('description', strip_tags(getMetaTag('description', $page->slug)));
		// MetaTag::set('keywords', getMetaTag('keywords', $page->slug));

		$tags = getAllMetaTagsForPage($page->slug);
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		CommonHelper::ogMeta();
		// $title = $page->title;
		// $description = str_limit(str_strip($page->content), 200);

		// // Meta Tags
		// MetaTag::set('title', $title);
		// MetaTag::set('description', $description);

		// // Open Graph
		// $this->og->title($title)->description($description);
		// if (!empty($page->picture)) {
		// 	if ($this->og->has('image')) {
		// 		$this->og->forget('image')->forget('image:width')->forget('image:height');
		// 	}
		// 	$this->og->image(Storage::url($page->picture), [
		// 		'width' => 600,
		// 		'height' => 600,
		// 	]);
		// }
		// view()->share('og', $this->og);


		return view('pages.index', $data);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function contact() {
		// Get the Country's largest city for Google Maps
		// $city = City::currentCountry()->orderBy('population', 'desc')->first();
		// view()->share('city', $city);
		$countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $countries);
		$page = Page::where('slug', 'contact_us')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();

		view()->share('page', $page);

		// Meta Tags
		$tags = getAllMetaTagsForPage('contact_us');
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		CommonHelper::ogMeta();
		
		// MetaTag::set('title', getMetaTag('title', 'contact'));
		// MetaTag::set('description', strip_tags(getMetaTag('description', 'contact')));
		// MetaTag::set('keywords', getMetaTag('keywords', 'contact'));

		// return view('pages.contact');
		return view('front.contact');

	}

	/**
	 * @param ContactRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function contactPost(Request $request) {

		$rules = (new \App\Http\Requests\ContactRequest)->rules();
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),
			));
			exit();
		}

		// echo "in here";exit;
		// Store Contact Info
		$phone_number ="";
		if(!empty($request->input('phone'))){
			$phone_number = $request->input('phone_code')." ".$request->input('phone');
		}

		// check google recaptcha response
		$req = $request->all();

		$ipAddress = getIp(true, '');
		if(isset($req) && isset($res['g-recaptcha-response']) && !empty($req['g-recaptcha-response']) ){

			$response = CommonHelper::verifyRecaptchaResponse($req['g-recaptcha-response'], $ipAddress);
			\Log::info('verifyRecaptchaResponse', ['verify Recaptcha Response' => $response]);

			// if recaptcha response is invalide then redirect to the home page
			if(isset($response) && $response['status'] != true){				
				$message = (isset($response['message']) && ($response['message'] !== ""))? array("g-recaptcha-response" => $response['message']) : array("g-recaptcha-response" => trans('global.Invalid_Google_reCAPTCHA_response'));
				return Response::json(array(
					'success' => false,
					'message' => $message,
				));
				exit();
				// flash($message)->success();
				// return redirect(config('app.locale') . '/' . trans('routes.contact'));
			}
		}

		$contactForm = [
			'country_code' => config('country.code'),
			'country' => config('country.name'),
			'first_name' => $request->input('first_name'),
			'company_name' => $request->input('company_name'),
			'email' => $request->input('email'),
			'message' => $request->input('message'),
			'phone' => $phone_number
		];
		$contactForm = Arr::toObject($contactForm);

		// Send Contact Email

		try {
			if (config('settings.app.email')) {
				$recipient = [
					'email' => config('app.conatct_receiver_email'),
					'name' => config('app.contact_receiver_name'),
				];
				$recipient = Arr::toObject($recipient);
				\Mail::send(new FormSent($contactForm, $recipient));
			} else {
				$admins = User::where('is_admin', 1)->get();
				if ($admins->count() > 0) {
					foreach ($admins as $admin) {
						\Mail::send(new FormSent($contactForm, $admin));
					}
				}
			}
			// flash(t("Your message has been sent to our moderators, Thank you"))->success();
			
			return Response::json(array(
					'success' => true,
					'message' => t("Your message has been sent to our moderators, Thank you")
			));
			exit();
		} catch (\Exception $e) {
			return Response::json(array(
					'success' => false,
					'message' => $e->getMessage()
			));
			exit();
			// flash($e->getMessage())->error();
		}

		// return redirect(config('app.locale') . '/' . trans('routes.contact'));

	}
	public function feedback() {
		// 
		// $page = Page::where('slug', 'contact_us')->trans()->first();
		// // $page = Page::where('type', $slug)->where('active', '1')->trans()->first();

		// view()->share('page', $page);

		// Meta Tags
		// MetaTag::set('title', getMetaTag('title', 'feedback'));
		// MetaTag::set('description', strip_tags(getMetaTag('description', 'feedback')));
		// MetaTag::set('keywords', getMetaTag('keywords', 'feedback'));

		$tags = getAllMetaTagsForPage('feedback');
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		// return view('pages.contact');
		return view('front/feedback');
	}
	/**
	 * @param ContactRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function feedbackPost(Request $request) {

		$rules = (new \App\Http\Requests\FeedbackRequest)->rules();
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),
			));
			exit();
		}

		// echo "in here";exit;
		// Store Contact Info
		$feedbackForm = [
			'country_code' => config('country.code'),
			'country' => config('country.name'),
			'subject' => trans("mail.new_feedback_title"),
			'first_name' => $request->input('first_name'),
			'email' => $request->input('email'),
			'message' => $request->input('message'),
		];

		// check google recaptcha response
		$req = $request->all();
		if(isset($req) && isset($res['g-recaptcha-response']) && !empty($req['g-recaptcha-response']) ){

			$ipAddress = getIp(true, '');
			$response = CommonHelper::verifyRecaptchaResponse($req['g-recaptcha-response'], $ipAddress);
			\Log::info('verifyRecaptchaResponse', ['verify Recaptcha Response' => $response]);

			// if recaptcha response is invalide then redirect to the home page
			if(isset($response) && $response['status'] != true){
				
				$message = (isset($response['message']) && ($response['message'] !== ""))? array("g-recaptcha-response" => $response['message']) : array("g-recaptcha-response" => trans('global.Invalid_Google_reCAPTCHA_response'));

				// flash($message)->success();
				// return redirect(config('app.locale') . '/' . trans('routes.feedback'));
				return Response::json(array(
					'success' => false,
					'message' => $message,
				));
				exit();
			}
		}

		// echo "<pre>"; print_r ($feedbackForm); echo "</pre>"; exit();
		$feedbackForm = Arr::toObject($feedbackForm);

		// Send Contact Email
		try {
			// if (config('settings.app.email')) {
			// 	$recipient = [
			// 		'email' => config('settings.app.email'),
			// 		'name' => config('settings.app.name'),
			// 	];

			// 	$recipient = Arr::toObject($recipient);
			// 	\Mail::send(new FormSent($feedbackForm, $recipient));
			// } else {
			// 	$admins = User::where('is_admin', 1)->get();
			// 	if ($admins->count() > 0) {
			// 		foreach ($admins as $admin) {
			// 			\Mail::send(new FormSent($feedbackForm, $admin));
			// 		}
			// 	}
			// }
			$recipient = [
					'email' => config('app.feedback_receiver_email'),
					'name' => config('app.feedback_receiver_name'),
				];
			$recipient = Arr::toObject($recipient);
			\Mail::send(new FeedbackSent($feedbackForm, $recipient));

			// flash(t("Thank you for submitting your valuable feedback"))->success();
			return Response::json(array(
				'success' => true,
				'message' => t("Thank you for submitting your valuable feedback")
			));
			exit();
		} catch (\Exception $e) {

			return Response::json(array(
				'success' => false,
				'message' => $e->getMessage()
			));
			exit();

			// flash($e->getMessage())->error();
		}

		// return redirect(config('app.locale') . '/' . trans('routes.feedback'));

	}
	public function ourVision() {


		// Get the Page
		$page = Page::where('slug', 'our-vision')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();
		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'faq');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		$title = $page->title;
		$description = str_limit(str_strip($page->content), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);

		// Open Graph
		$this->og->title($title)->description($description);
		if (!empty($page->picture)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image(Storage::url($page->picture), [
				'width' => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);


		// return view('pages.contact');
		return view('front/our_vision');
	}
	public function benefits() {

		// Get the Page
		$page = Page::where('slug', 'benefits')->orwhere('slug', 'vorteile')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();
		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'faq');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		$title = $page->title;
		$description = str_limit(str_strip($page->content), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);

		// Open Graph
		$this->og->title($title)->description($description);
		if (!empty($page->picture)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image(Storage::url($page->picture), [
				'width' => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);


		// return view('pages.contact');
		return view('front/benefit');
	}

	public function videos() {


		// Get the Page
		$page = Page::where('slug', 'videos')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();
		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'faq');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		$title = $page->title;
		$description = str_limit(str_strip($page->content), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);

		// Open Graph
		$this->og->title($title)->description($description);
		if (!empty($page->picture)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image(Storage::url($page->picture), [
				'width' => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);


		// return view('pages.contact');
		return view('front/video');
	}

	public function bookModel() {
		$preSearch = [
			'city' => (isset($city) && !empty($city)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
			'is_featured' => 1,
		];
		// Search
		$search = new ModelSearch($preSearch);
		$data = $search->fechAll();
		$page = Page::where('slug', 'book-a-model')->trans()->first();

		$modelCategories = ModelCategory::trans()->where('parent_id', 0)
						  ->orderBy('ordering')
						  ->get();

		$data['modelCategories'] = $modelCategories;
		$data['page'] = $page;

		// Export Search Result
		view()->share('count', $data['count']);
		view()->share('paginator', $data['paginator']);

		return view('front/book_a_model', $data);
	}

	public function aboutUs() {
		// Get the Page
		$page = Page::where('slug', 'about-us')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();
		
		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'about-us');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}
		// SEO
		// MetaTag::set('title', getMetaTag('title', $page->slug));
		// MetaTag::set('description', strip_tags(getMetaTag('description', $page->slug)));
		// MetaTag::set('keywords', getMetaTag('keywords', $page->slug));

		$tags = getAllMetaTagsForPage($page->slug);
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		CommonHelper::ogMeta();
		// $title = $page->title;
		// $description = str_limit(str_strip($page->content), 200);

		// // Meta Tags
		// MetaTag::set('title', $title);
		// MetaTag::set('description', $description);

		// // Open Graph
		// $this->og->title($title)->description($description);
		// if (!empty($page->picture)) {
		// 	if ($this->og->has('image')) {
		// 		$this->og->forget('image')->forget('image:width')->forget('image:height');
		// 	}
		// 	$this->og->image(Storage::url($page->picture), [
		// 		'width' => 600,
		// 		'height' => 600,
		// 	]);
		// }
		// view()->share('og', $this->og);

		return view('front/about');
	}

	public function premiumMembership() {
			
		$title = t(':full_name meta-tour-page - :app_name', ['full_name' => config('settings.app.name'), 'app_name' => config('app.app_name')] );
		$description= trans("metaTags.meta_description_go_premium");
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		CommonHelper::ogMeta();

		return view('front/premium_membership');
	}

	public function categories() {
		//get model categories
		/*$modelCategories = ModelCategory::where('translation_lang', config('app.locale'))
						  ->where('country_code', config('country.code'))
						  ->orderBy('ordering')
						  ->paginate($this->model_categories_perPage);*/

		$modelCategories = ModelCategory::trans()->where('parent_id', 0)
						  ->orderBy('ordering')
						  ->get();

		$data['modelCategories'] = $modelCategories;
		 
		// Meta Tags
		// MetaTag::set('title',  t('meta-model-categories - :app_name', ['app_name' => config('app.app_name')] ));
		// MetaTag::set('title', trans('metaTags.meta-title-model_category - :app_name', ['app_name' => config('app.app_name')] ));
		// MetaTag::set('description', trans('metaTags.meta-description-model_category - :app_name :domain_name', ['app_name' => config('app.app_name'),'domain_name' => config('app.domain_name')] ));

		$tags = getAllMetaTagsForPage('modeling-categories');
		$title = isset($tags['title']) ? $tags['title'] : '';
		$description = isset($tags['description']) ? $tags['description'] : '';
		// $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		// MetaTag::set('keywords', $keywords);

		CommonHelper::ogMeta();
		return view('front/models', $data);
	}

	public function postJob() {

		$page = Page::trans()
					->where('slug', trans('routes.post-a-job'))
					->first();

		$content = '';
		
		if(isset($page->content)){
			$content = $page->content;
		}
		
		$data['pageContent'] = $content;

		$tags = getAllMetaTagsForPage('find-models');
		$title = isset($tags['title']) ? $tags['title'] : trans('metaTags.meta-title-post-job - :app_name', ['app_name' => config('app.app_name')] );
		$description = isset($tags['description']) ? $tags['description'] : trans('metaTags.meta-description-post-job - :app_name :domain_name', ['app_name' => config('app.app_name'),'domain_name' => config('app.domain_name')] );
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);

		// trans("metaTags.meta_description_blog")
		// MetaTag::set('title', trans('metaTags.meta-title-post-job - :app_name', ['app_name' => config('app.app_name')] ));
		// MetaTag::set('description', trans('metaTags.meta-description-post-job - :app_name :domain_name', ['app_name' => config('app.app_name'),'domain_name' => config('app.domain_name')] ));

		return view('front/post_a_job', $data);
	}
	public function submitJob(Request $request) {
		
		$rules = (new \App\Http\Requests\JobRequest)->rules();
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),
			));
			exit();
		}

		// Store job Info for guest user
		// echo "hel,lo";exit;
		try {
			// $companyName = $request->input('company');

			// $companyInfo = array('name' => $companyName);
			// if (!isset($companyInfo['country_code']) || empty($companyInfo['country_code'])) {
			// 	$companyInfo += ['country_code' => config('country.code')];
			// }
			// // Logged Users
			// if (Auth::check()) {
			// 	if (!isset($companyInfo['user_id']) || empty($companyInfo['user_id'])) {
			// 		$companyInfo += ['user_id' => Auth::user()->id];
			// 	}

			// 	// Store the User's Company
			// 	$company = new Company($companyInfo);
			// 	$company->save();
			// } else {
			// 	// Guest Users
			// 	$company = Arr::toObject($companyInfo);
			// }
			// $postInfo = [
			// 	'username' => $request->input('name'),
			// 	'email' => $request->input('email'),
			// 	'company_id' => (isset($company->id)) ? $company->id : 0,
			// 	'company_name' => (isset($company->name)) ? $company->name : null,
			// 	'company_description' => (isset($company->description)) ? $company->description : null,
			// ];
			// $post = new Post($postInfo);
			// $post->save();
			$jobForm = [
				'country_code' => config('country.code'),
				'country' => config('country.name'),
				'subject' => trans("mail.new_job_request_title"),
				'first_name' => $request->input('name'),
				'email' => $request->input('email'),
				'company_name' => $request->input('company'),
				'message' => $request->input('message'),
			];

			$jobForm = Arr::toObject($jobForm);


			$recipient = [
					'email' => config('app.job_request_receiver_email'),
					'name' => config('app.job_request_receiver_name'),
				];
			$recipient = Arr::toObject($recipient);
			\Mail::send(new JobSent($jobForm, $recipient));

			// flash(t("Thank you for showing your interest in Go-Models, We will get back to you soon"))->success();

			return Response::json(array(
				'success' => true,
				'message' => t("Thank you for showing your interest in Go-Models, We will get back to you soon")
			));
			exit();

		} catch (\Exception $e) {

			return Response::json(array(
				'success' => false,
				'message' => $e->getMessage()
			));
			exit();

			// flash($e->getMessage())->error();
		}

		return redirect(config('app.locale') . '/' . trans('routes.post-a-job'));

	}

	public function magazine(Request $request) {
		
		// DB::connection()->enableQueryLog();
		// get record all blogs
		$blogs = BlogEntry::withoutGlobalScopes()
				// ->with('user.profile')
				->select('blog_entries.*','blog_categories.slug as category_slug', 'blog_categories.name as category_name',
						'users.name as username', 'user_profile.logo as user_profile_logo')
				->join('blog_categories', 'blog_categories.id', 'blog_entries.category_id')
				->join('users', 'users.id', 'blog_entries.post_author')
				->join('user_profile', 'user_profile.user_id', 'users.id')
				->where('blog_entries.active', 1)
				->where('blog_categories.active', 1)
				->where('blog_entries.translation_lang', config('app.locale'))
				->where('blog_entries.deleted_at', NULL)
				->where('blog_categories.deleted_at', NULL)
				->orderBy('blog_entries.start_date', 'desc')
				->paginate($this->perPage);

		$currentPage = 1;
		$lastPage = 1;
		$isLastPage = 0;
		$nextPage = 1;

		
		if(isset($blogs) and $blogs->getCollection()->count() > 0){
			
			$currentPage = $blogs->currentPage();
			$lastPage = $blogs->lastPage();
			$nextPage = $currentPage + 1;

			if($currentPage >= $lastPage){
				$isLastPage = 1;
			}
		}else{
			$isLastPage = 1;
		}

		$data['currentPage'] = $currentPage;
		$data['lastPage'] = $lastPage;
		$data['is_last_page'] = $isLastPage;
		$data['nextPage'] = $nextPage;
		$data['blogs'] = $blogs;

		if ($request->ajax()) {
			
			$returnHTML = view('front.inc.magazine-list' , $data)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['nextPage'], 'is_last_page' => $data['is_last_page']));
		}
		
		$recentBlogs = array();
		if(count($blogs) > 0){
			$index = 0;
			foreach($blogs as $blog){				
				$recentBlogs[] = $blog;
				$index++;
				if($this->recentBlogsLimit == $index) break;
			}
			$recentBlogs = Arr::toObject($recentBlogs);
		}		
		
		/**
		 * Show all tags in Magazine page.
		 */
		
		$allBlogTags = BlogTag::withoutGlobalScopes()
		->select('blog_tags.*')
		->join('blog_tags_to_entries', 'blog_tags.id', 'blog_tags_to_entries.tag_id')
		->join('blog_entries', 'blog_entries.id', 'blog_tags_to_entries.entry_id')
		->where('blog_entries.translation_lang', config('app.locale'))
		->where('blog_entries.active', 1)
		->where('blog_entries.deleted_at', NULL)
		->where('blog_tags.deleted_at', NULL)
		->groupBy('blog_tags.tag')
		->get();

		/**
		 * All blogs tags.
		 */
		$data['allTags'] = $allBlogTags;
		

		// get record most popular blogs
		$popularBlogs = BlogEntry::trans()->orderBy('view_count', 'desc')->orderBy('id', 'desc')->limit($this->popularBlogsLimit)->get();

		// get record recent blogs post
		// $recentBlogs = BlogEntry::trans()->orderBy('id', 'desc')->limit($this->recentBlogsLimit)->get();
		// get category latest blog 
		$latestBlogsCategory = BlogCategory::withoutGlobalScopes()
								->select('blog_categories.*')
								->join('blog_entries', 'blog_categories.id', 'blog_entries.category_id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_categories.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_categories.deleted_at', NULL)
								->where('blog_categories.active', 1)
								->groupBy('blog_categories.id')
								->orderBy('blog_entries.updated_at', 'desc')
								->limit($this->recentBlogsCategoryLimit)
								->get();
		
		$data['popularBlogs'] = $popularBlogs;
		$data['recentBlogs'] = $recentBlogs;
		$data['blogCategory'] = $latestBlogsCategory;
		// echo "<pre>"; print_r ($blogs); echo "</pre>"; exit();
		// Meta Tags

		$tags = getAllMetaTagsForPage('magazine');
		$title = isset($tags['title']) ? $tags['title'] : trans('metaTags.meta-title-blog - :app_name', ['app_name' => config('app.app_name')] );
		$description = isset($tags['description']) ? $tags['description'] : trans("metaTags.meta_description_blog - :app_name :domain_name", ['app_name' => config('app.app_name'), 'domain_name' => config('app.domain_name')]);
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		// MetaTag::set('title', trans('metaTags.meta-title-blog - :app_name', ['app_name' => config('app.app_name')] ));
		// MetaTag::set('description', trans("metaTags.meta_description_blog - :app_name :domain_name", ['app_name' => config('app.app_name'), 'domain_name' => config('app.domain_name')]));
		CommonHelper::ogMeta();

		// $queries = DB::getQueryLog();
		// echo '<pre>';
		// print_r($queries);die;

		return view('front/magazine', $data);
	}

	public function academy(Request $request) {
		$data = array();
		return view('front/academy', $data);
	}

	public function category_magazine($slug = null, Request $request) {
		// get record all blogs of category
		// $category_detail = BlogCategory::where('slug',$slug)->trans()->first();
		
		// $blogs = BlogEntry::whereHas('category', function ($query) use ( $slug) {
        //$query->where('slug',$slug);
        //})->trans()->paginate($this->perPage);
		
		$blogs = BlogEntry::withoutGlobalScopes()
				->select('blog_entries.*', 'blog_categories.slug as category_slug',
					'blog_categories.name as category_name',
					'users.name as username', 'user_profile.logo as user_profile_logo')
				->join('blog_categories', 'blog_categories.id', 'blog_entries.category_id')
				->join('users', 'users.id', 'blog_entries.post_author')
				->join('user_profile', 'user_profile.user_id', 'users.id')
				->where('blog_entries.active', 1)
				->where('blog_categories.active', 1)
				->where('blog_categories.slug', $slug)
				->where('blog_entries.translation_lang', config('app.locale'))
				->where('blog_entries.deleted_at', NULL)
				->where('blog_categories.deleted_at', NULL)
				->orderBy('blog_entries.updated_at', 'desc')
				->paginate($this->perPage);

		view()->share('uriPathPageSlug', $slug);

		$currentPage = 1;
		$lastPage = 1;
		$isLastPage = 0;
		$nextPage = 1;

		
		if(isset($blogs) and $blogs->getCollection()->count() > 0){
			
			$currentPage = $blogs->currentPage();
			$lastPage = $blogs->lastPage();
			$nextPage = $currentPage + 1;

			if($currentPage >= $lastPage){
				$isLastPage = 1;
			}
		}else{
			$isLastPage = 1;
		}

		$data['currentPage'] = $currentPage;
		$data['lastPage'] = $lastPage;
		$data['is_last_page'] = $isLastPage;
		$data['nextPage'] = $nextPage;
		$data['blogs'] = $blogs;

		if ($request->ajax()) {
			
			$returnHTML = view('front.inc.magazine-list' , $data)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['nextPage'], 'is_last_page' => $data['is_last_page']));
		}

		// get category latest blog 
		$latestBlogsCategory = BlogCategory::withoutGlobalScopes()
								->select('blog_categories.*')
								->join('blog_entries', 'blog_categories.id', 'blog_entries.category_id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_categories.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_categories.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_categories.deleted_at', NULL)
								->groupBy('blog_categories.id')
								->orderBy('blog_entries.updated_at', 'desc')
								// ->limit($this->recentBlogsCategoryLimit)
								->get();
								
		//get selected category from all categories
		$index = 0;
		$data['blogCategory'] = array();
		if(count($latestBlogsCategory) > 0) {
			foreach($latestBlogsCategory as $cat){
				if($index < $this->recentBlogsCategoryLimit){
					$data['blogCategory'][] = $cat;
					$index++;					
				}
				if($cat->slug == $slug){
					$category_detail = $cat;
				}
			}
		}
		// $data['blogCategory'] = $latestBlogsCategory;
		$data['blogs'] = $blogs;
		$data['category_slug'] = $slug;

		if(!empty($category_detail)){

			// Meta Tags
			MetaTag::set('title', t('meta-blog-categories - :category_name - :app_name', ['category_name' => ucwords($category_detail->name), 'app_name' => config('app.app_name')] ));

			MetaTag::set('title', str_replace('{app_name}',config('app.app_name') , $category_detail->meta_title));
			MetaTag::set('description', $category_detail->meta_description);
			MetaTag::set('keywords', str_replace(['{app_name}', '{country}'], [config('app.app_name'), config('country.name')], $category_detail->meta_keywords));

			CommonHelper::ogMeta();

			if(isset($category_detail->parent_id) && !empty($category_detail->parent_id)){
				view()->share('uriCategoryId', $category_detail->parent_id);
			}

		}

		// $data['pageNo'] = 0;
		// $lastPage = 0;
		// $is_last_page = 0;

		// if (isset($data['blogs']) && count($data['blogs'])  > 0) {
			
		// 	$lastPage = $data['blogs']->lastPage();
		// 	$currentPage =  $data['blogs']->currentPage();

		// 	if($lastPage == 1 && $currentPage == 1){
		// 		$is_last_page = 1;
		// 	}
		// 	if($lastPage > 1){
				
		// 		if($currentPage >= $lastPage){
		// 			$data['pageNo'] = $lastPage;
		// 			$is_last_page = 1;
		// 		}else{
		// 			$data['pageNo'] = $currentPage + 1;
		// 		}
		// 	}
		// }else{
		// 	$is_last_page = 1;
		// }

		// $data['is_last_page'] = $is_last_page;

		// get record most popular blogs
		$data['popularBlogs'] = BlogEntry::trans()->orderBy('view_count', 'desc')->orderBy('id', 'desc')->limit($this->popularBlogsLimit)->get();

		// get all category 
		$data['allCategories'] = BlogCategory::withoutGlobalScopes()
								->select('blog_categories.*')
								->join('blog_entries', 'blog_entries.category_id', 'blog_categories.id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_categories.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_categories.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_categories.deleted_at', NULL)
								->orderBy('blog_categories.name', 'asc')
								->groupBy('blog_categories.name')
								->get();
														
		// if ($request->ajax()) {
			
		// 	$returnHTML = view('front.inc.posts' , $data)->render();
		// 	return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['pageNo'], 'is_last_page' => $data['is_last_page']));
		// }

		return view('front/magazine_category', $data);
	}
	public function tag_magazine($slug = null, Request $request) {
		
		// get record all blogs of category
		$blogTag = BlogTag::where('slug', $slug)->trans()->first();

		$data['blogs'] = array();

		$data['pageNo'] = 0;
		$lastPage = 0;
		$is_last_page = 0;
		$meta_title = '';
		$meta_description = '';

		if (!empty($blogTag)) {
		 	
		 	// $data['blogs'] = $blogTag->blogs()->trans()->paginate($this->perPage);

			$data['blogs'] = BlogEntry::withoutGlobalScopes()
				->select('blog_entries.*', 'blog_categories.slug as category_slug',
					'blog_categories.name as category_name',
					'users.name as username', 'user_profile.logo as user_profile_logo')
				->join('blog_categories', 'blog_categories.id', 'blog_entries.category_id')
				->join('blog_tags_to_entries', 'blog_tags_to_entries.entry_id', 'blog_entries.id')
				->join('blog_tags', 'blog_tags.id', 'blog_tags_to_entries.tag_id')
				->join('users', 'users.id', 'blog_entries.post_author')
				->join('user_profile', 'user_profile.user_id', 'users.id')
				->where('blog_entries.active', 1)
				->where('blog_categories.active', 1)
				->where('blog_entries.deleted_at', NULL)
				->where('blog_categories.deleted_at', NULL)
				->where('blog_tags.slug', $slug)
				->where('blog_entries.translation_lang', config('app.locale'))
				->orderBy('blog_entries.updated_at', 'desc')
				->paginate($this->perPage);
			// Meta Tags
			// MetaTag::set('title', t('meta-blog-tags - :tag_name - :app_name', ['tag_name' => ucwords($blogTag->tag), 'app_name' => config('app.app_name')] ));


			// MetaTag::set('title', str_replace('{app_name}',config('app.app_name') , $blogTag->meta_title));
			// MetaTag::set('description', $blogTag->meta_description);
			// MetaTag::set('keywords', str_replace(['{app_name}', '{country}'], [config('app.app_name'), config('country.name')], $blogTag->meta_keywords));

			// CommonHelper::ogMeta();

			$meta_title = str_replace('{app_name}',config('app.app_name') , $blogTag->meta_title);
			$meta_description = $blogTag->meta_description;

			view()->share('uriPathPageSlug', $slug);
			if(isset($blogTag->parent_id) && !empty($blogTag->parent_id)){
				view()->share('uriCategoryId', $blogTag->parent_id);
			}
		}
		
		// if (isset($data['blogs']) && count($data['blogs'])  > 0) {
			
		// 	$lastPage = $data['blogs']->lastPage();
		// 	$currentPage =  $data['blogs']->currentPage();

		// 	if($lastPage == 1 && $currentPage == 1){
		// 		$is_last_page = 1;
		// 	}
		// 	if($lastPage > 1){
				
		// 		if($currentPage >= $lastPage){
		// 			$data['pageNo'] = $lastPage;
		// 			$is_last_page = 1;
		// 		}else{
		// 			$data['pageNo'] = $currentPage + 1;
		// 		}
		// 	}
		// }

		
		$currentPage = 1;
		$lastPage = 1;
		$isLastPage = 0;
		$nextPage = 1;

		$blogs = $data['blogs'];
		if(isset($blogs) && !empty($blogs) && $blogs->getCollection()->count() > 0){
			
			$currentPage = $blogs->currentPage();
			$lastPage = $blogs->lastPage();
			$nextPage = $currentPage + 1;

			if($currentPage >= $lastPage){
				$isLastPage = 1;
			}
		}else{
			$isLastPage = 1;
		}

		$data['currentPage'] = $currentPage;
		$data['lastPage'] = $lastPage;
		$data['is_last_page'] = $isLastPage;
		$data['nextPage'] = $nextPage;
		// $data['blogs'] = $blogs;

		if ($request->ajax()) {
			
			$returnHTML = view('front.inc.magazine-list' , $data)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['nextPage'], 'is_last_page' => $data['is_last_page']));
		}



		// get category latest blog
		$latestBlogsCategory = BlogCategory::withoutGlobalScopes()
								->select('blog_categories.*')
								->join('blog_entries', 'blog_categories.id', 'blog_entries.category_id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_categories.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_categories.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_categories.deleted_at', NULL)
								->groupBy('blog_categories.id')
								->orderBy('blog_entries.updated_at', 'desc')
								->limit($this->recentBlogsCategoryLimit)
								->get();
		$data['blogCategory'] = $latestBlogsCategory;
		
		// get record most popular blogs
		$data['popularBlogs'] = BlogEntry::trans()->orderBy('view_count', 'desc')->orderBy('id', 'desc')->limit($this->popularBlogsLimit)->get();

		// get all tags
		$data['allTags'] = BlogTag::withoutGlobalScopes()
								->select('blog_tags.*')
								->join('blog_tags_to_entries', 'blog_tags.id', 'blog_tags_to_entries.tag_id')
								->join('blog_entries', 'blog_entries.id', 'blog_tags_to_entries.entry_id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_tags.deleted_at', NULL)
								->groupBy('blog_tags.tag')
								// ->orderBy('blog_tags.tag', 'asc')
								->get();

		// if ($request->ajax()) {
			
		// 	$returnHTML = view('front.inc.posts' , $data)->render();
		// 	return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['pageNo'], 'is_last_page' => $data['is_last_page']));
		// }

		if( empty($meta_title) ){
			if( !empty($blogTag->tag) ){
				$meta_title = trans('metaTags.meta_tag_title', ['tag_name' => $blogTag->tag, 'app_name' => config('app.app_name')]);
			}
		}

		if( empty($meta_description) ){
			if( !empty($blogTag->tag) ){
				$meta_description = trans('metaTags.meta_tag_description', ['tag_name' => $blogTag->tag]);
			}
		}


		MetaTag::set('title', $meta_title);
		MetaTag::set('description', $meta_description);
		
		CommonHelper::ogMeta();

		return view('front/tag_magazine', $data);
	}
	public function magazine_read($slug = null) {

		if($slug == null || $slug == ''){
			flash(t("No blog found"))->error();
			return redirect(config('app.locale') . '/' . trans('routes.magazine'));
		}
		$tags = array();
		$allTags = array();

		// get blog details by blog id
		// $blogDetails = BlogEntry::where('id', $id)->firstOrFail();
		$blogDetails = BlogEntry::select('id','name','picture','slug','long_text','translation_of', 'category_id','post_author','updated_at','meta_title','meta_description','start_date')->where('slug', $slug)->trans()->first();

		//check if blog exists
		if(empty($blogDetails) || $blogDetails == null){
			$blogDetails = BlogEntry::select('id','name','picture','slug','long_text','translation_of','category_id','post_author','updated_at','start_date')->where('slug', $slug)->first();
		}

		//if blog not found
		if(empty($blogDetails) || $blogDetails == null){
			flash(t("No blog found"))->error();
			return redirect(config('app.locale') . '/' . trans('routes.magazine'));
		}
		
		// get record most popular blogs
		$data['popularBlogs'] = BlogEntry::trans()->orderBy('view_count', 'desc')->orderBy('id', 'desc')->limit($this->popularBlogsLimit)->get();

		// get more blogs
		// $moreBlogs = BlogEntry::where('id', '!=', $id)->trans()->limit(6)->get();
		// $moreBlogs = BlogEntry::where('slug', '!=', $slug)->trans()->limit(6)->get();
		$moreBlogs = BlogEntry::withoutGlobalScopes()
				->select('blog_entries.*', 'blog_categories.slug as category_slug',
					'blog_categories.name as category_name')
				->join('blog_categories', 'blog_categories.id', 'blog_entries.category_id')
				->where('blog_entries.active', 1)
				->where('blog_categories.active', 1)
				->where('blog_entries.slug', '!=' ,$slug)
				->where('blog_entries.translation_lang', config('app.locale'))
				->where('blog_entries.category_id', $blogDetails->category_id)
				->where('blog_entries.deleted_at', NULL)
				->where('blog_categories.deleted_at', NULL)
				->orderBy('blog_entries.updated_at', 'desc')
				->limit(6)
				->get();

		view()->share('uriPathPageSlug', $slug);
		
		// get category latest blog 
		$latestBlogsCategory = BlogCategory::withoutGlobalScopes()
								->select('blog_categories.*')
								->join('blog_entries', 'blog_categories.id', 'blog_entries.category_id')
								->where('blog_entries.translation_lang', config('app.locale'))
								->where('blog_categories.translation_lang', config('app.locale'))
								->where('blog_entries.active', 1)
								->where('blog_categories.active', 1)
								->where('blog_entries.deleted_at', NULL)
								->where('blog_categories.deleted_at', NULL)
								->groupBy('blog_categories.id')
								->orderBy('blog_entries.updated_at', 'desc')
								->limit($this->recentBlogsCategoryLimit)
								->get();
		$data['blogCategory'] = $latestBlogsCategory;

		if(isset($blogDetails->parent_id) && !empty($blogDetails->parent_id)){
			view()->share('uriCategoryId', $blogDetails->parent_id);
		}

		if(isset($blogDetails) && isset($blogDetails->tags)){
			$allTags = $blogDetails->tags;
		}
		// check tag exist or not
		// if (isset($blogDetails->tags) && !empty($blogDetails->tags)) {
		// 	$tags = explode(",", $blogDetails->tags);
		// }
		// echo "<pre>"; print_r ($blogDetails->tags); echo "</pre>"; exit();
		$data['blogDetail'] = $blogDetails;
		$data['moreBlogs'] = $moreBlogs;
		$data['blogTags'] = $tags;
		$data['allTags'] = $allTags;

		// if (!empty($blogDetails)) {
		// 	// blog view count increment
		// 	$blogDetails->timestamps = false;
		// 	$blogDetails->view_count = $blogDetails->view_count + 1;
		// 	$blogDetails->save();
		// }
		if(!empty($blogDetails->meta_title) && !empty($blogDetails->meta_description))
		{
			$blog_meta_title = str_replace(['{app_name}', '{domain_name}'], [config('app.app_name'), config('app.domain_name')] , $blogDetails->meta_title);
			$blog_meta_desc = $blogDetails->meta_description;
		}
		else
		{
			$blog_meta_title = $blogDetails->name.' - '.config('app.app_name');
			$blog_meta_desc = str_limit(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '',html_entity_decode ( html_entity_decode ( strCleaner($blogDetails->long_text )) )), config('constant.description_limit'));
		}
		
		$data['og_seo_tags'] = array(
								'og:title' => $blog_meta_title,
								'og:description' => $blog_meta_desc,
								'og:image' => Storage::url($blogDetails->picture),
								// 'og:image:secure_url' => str_replace('http://', 'https://',\Storage::url($blogDetails->picture)),
								'og:image:alt' => trans('metaTags.img_modeling_agency')
							);
		$data['twitter_seo_tags'] = array(
								'twitter:image' => \Storage::url($blogDetails->picture),
								'twitter:image:alt' => trans('metaTags.img_modeling_agency')
							);

		MetaTag::set('title', $blog_meta_title );
		MetaTag::set('description', $blog_meta_desc);

		return view('front/magazine_read', $data);
	}

	// public function magazine(){
	//     $blogs = BlogEntry::trans()->paginate($this->perPage);
	//     $data['blogs'] = $blogs;
	//     return view('front/magazine', $data);
	// }

	// public function magazine_read($id = null){

	//     $blogDetails = BlogEntry::where('id', $id)->firstOrFail();
	//     $moreBlogs = BlogEntry::where('id', '!=' , $id)->trans()->limit(6)->get();
	//     $tags = array();
	//     if(isset($blogDetails->tags) && !empty($blogDetails->tags)){
	//        $tags =  explode(",", $blogDetails->tags);
	//     }
	//     $data['blogDetail'] = $blogDetails;
	//     $data['moreBlogs'] = $moreBlogs;
	//     $data['blogTags'] = $tags;

	//     return view('front/magazine_read', $data);
	// }

	public function packages() {
		MetaTag::set('title', trans('metaTags.meta-title-pricing - :app_name', ['app_name' => config('app.app_name')] ));
		MetaTag::set('description', trans('metaTags.meta-description-pricing - :app_name', ['app_name' => config('app.app_name'), 'domain_name' => config('app.domain_name')] ));
		return view('front/pricing');
	}

	public function faq() {
		// Get the Page
		$page = Page::where('slug', 'faq')->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();

		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'faq');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		$title = $page->title;
		$description = str_limit(str_strip($page->content), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);

		// Open Graph
		$this->og->title($title)->description($description);
		if (!empty($page->picture)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image(Storage::url($page->picture), [
				'width' => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);

		return view('front/faq');
	}

	// public function contactUs() {
	// 	return view('front/contact');
	// }

	public function professionals() {
		//get partner categories
		// $partnerCategories = Branch::where('translation_lang', config('app.locale'))
		// 				  ->where('country_code', config('country.code'))
		// 				  ->orderBy('id')
		// 				  ->paginate($this->partner_categories_perPage);

		$partnerCategories = Branch::trans()->where('parent_id', 0)
						  ->orderBy('lft')
						  ->get();

		$data['partnerCategories'] = $partnerCategories;

		// Meta Tags
		// MetaTag::set('title',  t('meta-partner-categories - :app_name', ['app_name' => config('app.app_name')] ));
		MetaTag::set('title', trans('metaTags.meta-title-professionals - :app_name :domain_name', ['app_name' => config('app.app_name'), 'domain_name' => config('app.domain_name')] ));
		MetaTag::set('description', trans('metaTags.meta-description-professionals - :app_name :domain_name', ['app_name' => config('app.app_name'), 'domain_name' => config('app.domain_name')] ));

		return view('front/professionals', $data);
	}

	public function agreement() {
		return view('front/nutzervereinbarung');
	}

	public function agreementPartner() {
		return view('front/nutzervereinbarung_partner');
	}

	public function security() {
		return view('front/datenschutz');
	}

	public function modelCategoryPage() {
		$modelCategorySlug = Route::currentRouteName();
		//get page detail from flag
		$page = Page::where('slug', $modelCategorySlug)->trans()->first();
		// $page = Page::where('type', $slug)->where('active', '1')->trans()->first();

		if (empty($page)) {
			view()->share('is_page', "1");
			abort(404);
		}

		view()->share('page', $page);
		view()->share('uriPathPageSlug', $modelCategorySlug);

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		// SEO
		$title = $page->title;
		$description = str_limit(str_strip($page->content), 200);

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);

		// Open Graph
		$this->og->title($title)->description($description);
		if (!empty($page->picture)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image(Storage::url($page->picture), [
				'width' => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);

		return view('pages.index');
	}

	public function setupImageRoutes($plugin, $filename) {
		$path = plugin_path($plugin, 'public/images/' . $filename);
	    if (\File::exists($path)) {
	        $file = \File::get($path);
	        $type = \File::mimeType($path);

	        $response = \Response::make($file, 200);
	        $response->header("Content-Type", $type);

	        return $response;
	    }

	    abort(404);
	}

	public function setupAssetsRoutes($plugin, $type, $file){
		$path = plugin_path($plugin, 'public/assets/' . $type . '/' . $file);
        if (\File::exists($path)) {
            //return response()->download($path, "$file");
            if ($type == 'js') {
                return response()->file($path, array('Content-Type' => 'application/javascript'));
            } else {
                return response()->file($path, array('Content-Type' => 'text/css'));
            }
        }

        abort(404);
	}

	public function jobInfo() {
		// Get the Page
		$page = Page::where('slug', 'job-info')->trans()->first();

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'job-info');

		if (!Gate::allows('info_jobs', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }

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
		return view('post.job-info');
	}

	// get terms conditions model and Clients
	public function getTerms(Request $request){

		$pageTitle = t('Terms of Use for Models'). ' ('.strtoupper(config('country.code')).')';
		$is_model_terms_conditions = true;

		// if route call to clients terms-conditions
		if($request->route()->getName() == 'terms-conditions-client'){
			$pageTitle = t('Terms of Use for Clients'). ' ('.strtoupper(config('country.code')).')';
			$is_model_terms_conditions = false;
		}
		
		$data['pageTitle'] = $pageTitle;
		$data['is_model_terms_conditions'] = $is_model_terms_conditions;

		// Meta Tags
        MetaTag::set('title', $pageTitle);
        MetaTag::set('description', $pageTitle);
        MetaTag::set('keywords', $pageTitle);

		CommonHelper::ogMeta();

		return view('pages.terms-conditions', $data);
	}

	// get terms conditions model and Clients in ajax 
	public function getTermsAjax(Request $request){ 

		if(isset($request->userType) &&  $request->userType == 2){
			
			$returnHTML = view('layouts.inc.modal.partner.term')->render();
		}else{
			
			$returnHTML = view('layouts.inc.modal.model.term')->render();
		}

		return ['status' => true,'html' => $returnHTML ]; exit();
	}

	//image upload from simditor common function
	public function pageImageUploads(Request $request){

		$req = $request->all();
		$original_filename = '';

		if( isset($req) && isset($req['upload_file']) ){

			if(isset($req['original_filename']) && !empty($req['original_filename']) ){
				$original_filename = $req['original_filename'];
			}
			
			$response = CommonHelper::pageImageUploads($request, 'upload_file', 'page-images');
			
			if(isset($response) && $response['status'] = true ){
				
				echo json_encode([
					'success' => true,
					'msg' => t($response['message']),
					'file_path' => url(config('filesystems.default') . '/' .$response['path'])
				]); exit();
			}

		}else{
			echo json_encode([
				'success' => false,
				'msg' => t('Something went wrong Please try again'),
				'file_path' => ''
			]); exit();
		}
		
	}
}
