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

namespace App\Http\Controllers\Auth;

use App\Helpers\CommonHelper;
use App\Helpers\Ip;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\UnitMeasurement;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Controllers\FrontController;
use App\Http\Requests\RegisterRequest;
use App\Mail\UserNotification;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Gender;
use App\Models\ModelBook;
use App\Models\ModelCategory;
use App\Models\Page;
use App\Models\Resume;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserType;
use App\Models\ValidValue;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Response;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Storage;
use Kickbox\Client as KickboxClient;
use App\Models\TimeZone;
use App\Models\Country;
use App\Models\States;
use Exception;
use Illuminate\Support\Facades\Session;
use nickdnk\ZeroBounce\APIError;
use nickdnk\ZeroBounce\Email;
use nickdnk\ZeroBounce\Result;
use nickdnk\ZeroBounce\ZeroBounce;
// use PulkitJalan\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Gate;
use PulkitJalan\GeoIP\GeoIP;

class RegisterController extends FrontController {
	use RegistersUsers, VerificationTrait;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/account';

	/**
	 * @var array
	 */
	public $msg = [];

	/**
	 * RegisterController constructor.
	 */
	public function __construct() {
		parent::__construct();

		// $page_terms = $page_termsclient = array();
  //       if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
  //           foreach($this->pages as $page){
  //               if($page->type == "terms"){
  //                   $page_terms = $page;
  //               }elseif($page->type == "termsclient") {
  //                   $page_termsclient = $page;
  //               }
  //           }
  //       }
  //       view()->share('page_terms', $page_terms);
  //       view()->share('page_termsclient', $page_termsclient);

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			$this->getTermsConditions();

			return $next($request);
		});
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		$this->redirectTo = config('app.locale') . '/account';

		$userTypes = UserType::orderBy('id', 'DESC')->get();
		view()->share('userTypes', $userTypes);


		// $page_terms = Page::where('type', 'terms')->where('active', '1')->trans()->first();
		// $page_termsclient = Page::where('type', 'termsclient')->where('active', '1')->trans()->first();

		//get pages for home page
		// $page_terms = $page_termsclient = array();
		// //get pages from frontcontroller construct
		// if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
		// 	foreach($this->pages as $page){
		// 		if($page->type == "terms"){
		// 			$page_terms = $page;
		// 		}elseif($page->type == "termsclient") {
		// 			$page_termsclient = $page;
		// 		}
		// 	}
		// }

		// if (empty($page_terms) || empty($page_termsclient)) {
		// 	abort(404);
		// }
		// view()->share('page_terms', $page_terms);
		// view()->share('page_termsclient', $page_termsclient);
	}

	/**
	 * Show the form the create a new user account.
	 *
	 * @return View
	 */
	public function showRegistrationForm() {
		$data = [];

		// References
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		$data['genders'] = Gender::trans()->get();
		$data['userTypes'] = UserType::orderBy('id', 'DESC')->get();
		$data['uriPath'] = 'email';
		$data['siteCountryInfo'] = NULL;

		// $page_terms = Page::where('type', 'terms')->where('active', '1')->trans()->first();
		// $page_termsclient = Page::where('type', 'termsclient')->where('active', '1')->trans()->first();
		//get pages for home page
		$page_terms = $page_termsclient = array();
		//get pages from frontcontroller construct
		if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
			foreach($this->pages as $page){
				if($page->type == "terms"){
					$page_terms = $page;
				}elseif($page->type == "termsclient") {
					$page_termsclient = $page;
				}
			}
		}
		if (empty($page_terms) || empty($page_termsclient)) {
			abort(404);
		}
		view()->share('page_terms', $page_terms);
		view()->share('page_termsclient', $page_termsclient);

		// Meta Tags
		// MetaTag::set('title', getMetaTag('title', 'register'));
		// MetaTag::set('description', strip_tags(getMetaTag('description', 'register')));
		// MetaTag::set('keywords', getMetaTag('keywords', 'register'));

		$tags = getAllMetaTagsForPage('register');
		$title = isset($tags['title']) ? $tags['title'] : '';
		$description = isset($tags['description']) ? $tags['description'] : '';
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);

		return view('auth.register.index', $data);
	}

	public function registerDataForm($slug) {
		$data = [];
		
		// get user id from slug
		// $time = substr($slug, 0, 10);
		// $remain_slug = substr($slug, 10);
		// $id = $remain_slug / ($time * 2);

		$user = "";

		if (isset($slug) && !empty($slug)) {
			$user = User::getUserBySlug($slug);
			view()->share('uriPathPageSlug', $slug);
		}

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}

		$country_code = isset($user->country->code) ? $user->country->code : '';

	 	if(empty($country_code)){
		 	$country_code = (config('app.default_units_country')) ? config('app.default_units_country') : config('country.locale');
		}

		$data['company_name'] = "";
		$data['website'] = "";

		// if user is parnter then get the company details
		if(isset($user->user_type_id) && $user->user_type_id == config('constant.partner_type_id')){
			$data['company_name'] = (isset($user->company->name))? $user->company->name : '';
			$data['website'] = (isset($user->company->website))? $user->company->website : '';
		}

		$data['country_code'] = $country_code;
		$data['user'] = $user;
		$data['uriPath'] = 'data';
		$data['slug'] = $slug;
		$data['genders'] = Gender::trans()->get();
		$data['siteCountryInfo'] = NULL;

		if (isset($data['user']) && !empty($data['user'])) {
			if ($data['user']->active) {
				flash(t("You already made signed this contract"))->success();
				return redirect(config('app.locale'));
			}
		}

		// $property = [];
		// $validValues = ValidValue::all();

		// // getting country list
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $data['countries']);

		// foreach ($validValues as $val) {
		// 	$translate = $val->getTranslation(app()->getLocale());
		// 	$property[$val->type][$val->id] = !empty($translate->value) ? $translate->value : '';
		// }


		// $unitArr = UnitMeasurement::getUnitMeasurement();
		// $unitArr = new UnitMeasurement();
		// $unitoptions = $unitArr->getUnit(true);

		// $property = array_merge($property, $unitoptions);
		
		// $data['properties'] = $property;

		// Get ModelCategories
		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('ordering')->get();

			return $modelCategories;
		});

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

		return view('auth.register.data', $data);
	}

	public function registerPhotoForm($slug) {
		$data = [];

		// Code to get user id from slug
		// $time = substr($slug, 0, 10);
		// $remain_slug = substr($slug, 10);
		// $id = $remain_slug / ($time * 2);

		$user = "";
		$modelbook = '';
		$modelCount = 1;

		if (isset($slug) && !empty($slug)) {
			$user = User::getUserBySlug($slug);
			view()->share('uriPathPageSlug', $slug);
		}

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		} else {
			$modelbook = ModelBook::where('user_id', $user->id)->where('active', 1)->get();
			$modelCount = $modelbook->count();
		}
		$data['modelCount'] = $modelCount;
		$data['modelbook'] = $modelbook;
		$data['user'] = $user;
		$data['uriPath'] = 'photo';
		$data['slug'] = $slug;
		$data['siteCountryInfo'] = NULL;

		if (isset($data['user']) && !empty($data['user'])) {
			if ($data['user']->active) {
				flash(t("You already made signed this contract"))->success();
				return redirect(config('app.locale'));
			}
		}

		return view('auth.register.photo', $data);
	}

	/**
	 * Register a new user account.
	 *
	 * @param RegisterRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	
	public function register(Request $request) {
		
		$req = $request->all();
		$user_id = "";
		$userProfileInfo = array();
		
		$rules = (new \App\Http\Requests\RegisterRequest)->rules();
		
		if (isset($req['user_type']) && $req['user_type'] == config('constant.model_type_id')) {
			unset($rules['company_name']);
			unset($rules['website']);
		}

		// if user comes from social login then have user id and only update user type and partner details
		// if (isset($req['user_id']) && $req['user_id'] !== "") {

		// 	$rules['email'] = 'required|max:100|whitelist_email|whitelist_domain|unique:users,email,'.$req['user_id'];
		// 	$user_id = $req['user_id'];

		// 	unset($rules['first_name']);
		// 	unset($rules['last_name']);
		// 	unset($rules['phone']);
		// 	unset($rules['term']);
		// 	unset($rules['g-recaptcha-response']);
			
		// }
		// unset($rules['g-recaptcha-response']);

		$validator = Validator::make($request->all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),

			));
			exit();
		} else {

			/**
			 * Email Verification Block
		 	*/
			if(config('app.env') != 'local') {

				$verifyServicesArray = array();
				if(config('app.kickbox_api_verify') == true || $this->needToCheckWithKickbox($req['email'])) {
					$verifyServicesArray[] = 'kickbox';
				}
				if(config('app.zerobounce_api_verify') == true) {
					$verifyServicesArray[] = 'zerobounce';
				}

				if (sizeof($verifyServicesArray) > 0) {
					$verifyResult = false;
				} else {
					$verifyResult = true;
				}

				foreach ($verifyServicesArray as $verifyService) {
					$functionName = $verifyService . 'EmailVerify';
					$result = $this->$functionName($req['email']);
					if (isset($result['success']) && $result['success'] == true) {
						$verifyResult = true;
					}
				}

				if ($verifyResult == false) {
					return Response::json(array(
						'success' => false,
						'errors' => array('email' => array(trans('global.undeliverable_email_address'))),
					));
					exit();
				}
			}
			$company_name = '';
			$website = '';
			
			if($req['user_type'] == config('constant.partner_type_id')){

				$company_name = $request->input('company_name');
				$website = ($request->input('website')) ? $request->input('website') : '';
					
				if(!empty($website)){
				
					$website = preg_replace('/^(?!https?:\/\/)/', 'http://', $website);
				}
			}
			
			$ipAddress = getIp(true, '');
			$response = CommonHelper::verifyRecaptchaResponse($req['g-recaptcha-response'], $ipAddress);
			\Log::info('verifyRecaptchaResponse', ['verify Recaptcha Response' => $response]);

			if(isset($response) && $response['status'] != true){
				$message = (isset($response['message']) && ($response['message'] !== ""))? array("g-recaptcha-response" => array($response['message'])) : array("g-recaptcha-response" => array(trans('global.Invalid_Google_reCAPTCHA_response')));
				return Response::json(array(
					'success' => false,
					'errors' => $message,
				));
				exit();
			}

			$message = '';

			// Conditions to Verify User's Email or Phone
			$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email');
			$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone');


			// if( isset($req) && isset($req['user_id']) && !empty($req['user_id']) ){

			// 	$userInfo['user_type_id'] = $request->input('user_type');
			// 	$userInfo['email'] = $request->input('email');
			// 	$userInfo['verified_email'] = 1;
			// 	$userInfo['verified_phone'] = 1;
			// 	$userInfo['active'] = 0;
			// 	$userInfo['username'] = '';

			// 	if($req['user_type'] == config('constant.partner_type_id')){
					
			// 		$userProfileInfo['company_name'] = $company_name;
			// 		$userProfileInfo['website_url'] = $website;
			// 	}
			// }else{

				// Store User
				$userInfo = [
					//'country_code' => config('country.code'),
					'gender_id' => $request->input('gender'),
					'name' => $request->input('first_name'),
					'user_type_id' => $request->input('user_type'),
					//'phone' => $request->input('phone'),
					//'phone_code' => $request->input('phone_code'),
					'email' => $request->input('email'),
					'username' => $request->input('username'),
					// 'password'       => bcrypt($request->input('password')),
					'phone_hidden' => $request->input('phone_hidden'),
					'ip_addr' => Ip::get(),
					'verified_email' => 1,
					'verified_phone' => 1,
					'active' => 0,
					'receive_newsletter' => (isset($req['newsletter']) && $req['newsletter'] == 1)? 1 : 0,
				];
			// }
			
			// Email verification key generation
			if ($emailVerificationRequired) {
				$userInfo['email_token'] = md5(microtime() . mt_rand());
				$userInfo['verified_email'] = 0;
			}

			// Mobile activation key generation
			if ($phoneVerificationRequired) {
				$userInfo['phone_token'] = mt_rand(100000, 999999);
				$userInfo['verified_phone'] = 0;
			}

			// Save the User into database
			// if( $user_id != "" ){
			// 	$user = User::withoutGlobalScopes()->find($user_id);

			// 	if(isset($user) && !empty($user)){

			// 		$username  = preg_replace('/[^A-Za-z0-9\-]/', '', $user->name);
			// 		$userInfo['username'] = trim(str_replace(' ',"",  $username.$user->id));

			// 		User::withoutGlobalScopes()->where('id', $user_id)->update($userInfo);
			// 		UserProfile::withoutGlobalScopes()->where('user_id', $user_id)->update($userProfileInfo);

			// 		if ($request->input('user_type') == config('constant.partner_type_id') && !empty($company_name)) {
					
			// 			$companyInfo = array(
			// 				'user_id' => $user_id,
			// 				'name' => $company_name,
			// 				'country_code' => config('country.code'),
			// 				'website' => $website,
			// 			);

			// 			$company = new Company($companyInfo);
			// 			$company->save();
			// 		}

			// 	}else{
			// 		return Response::json(array(
			// 			'success' => false,
			// 			'message' => t("Unknown error, Please try again in a few minutes")
			// 		));exit();
			// 	}
			// // }else{

				$user = new User($userInfo);
				$user->save();
				if (empty($user->username)) {
					// $user->username = $user->name . $user->id;
					$user->username = trim(str_replace(' ',"",  $user->name.$user->id));
				}
				$user->save();

				$profileInfo = array(
					'user_id' => $user->id,
					'first_name' => $request->input('first_name'),
					'last_name' => $request->input('last_name'),
				);

				if($request->input('user_type') == config('constant.partner_type_id')){
					
					$profileInfo['company_name'] = $company_name;
					$profileInfo['website_url'] = $website;
				}

				$profile = new UserProfile($profileInfo);
				$profile->save();
				
				if ($request->input('user_type') == config('constant.partner_type_id') && !empty($company_name)) {
					
					$companyInfo = array(
						'user_id' => $user->id,
						'name' => $company_name,
						'country_code' => config('country.code'),
						'website' => $website,
					);

					$company = new Company($companyInfo);
					$company->save();
				}
				
				// Add Job seekers resume
				if ($request->input('user_type') == config('constant.model_type_id')) {
					if ($request->hasFile('filename')) {
						// Save user's resume
						$resumeInfo = [
							'country_code' => config('country.code'),
							'user_id' => $user->id,
							'active' => 1,
						];
						$resume = new Resume($resumeInfo);
						$resume->save();

						// Upload user's resume
						$resume->filename = $request->file('filename');
						$resume->save();
					}
				} 

				// Send 'lead_create' action to CRM
				// $utm_source   = (Session::has('utm_source')) ? session('utm_source') : '';
	            // $utm_medium   = (Session::has('utm_medium')) ? Session::get('utm_medium') : '';
	            // $utm_campaign = (Session::has('utm_campaign')) ? Session::get('utm_campaign') : '';
	            // $utm_content  = (Session::has('utm_content')) ? Session::get('utm_content') : '';
	            // $utm_term     = (Session::has('utm_term')) ? Session::get('utm_term') : '';
	            // $gclid        = (Session::has('gclid')) ? Session::get('gclid') : '';
	            // $clientId     = (Session::has('clientId')) ? Session::get('clientId') : '';

	            
	            /*
	            // set ip in geoIp
	            GeoIP::setIp($ipAddr);
	            // get GeoIP country code
	            $countryCode = GeoIP::getCountryCode();
	            */

	            // get ip address
	            $ipAddr = Ip::get();
	            
	            // create GeoIp Object
	            $geoip = new GeoIP();

	            // set ip in geoIp
	            $geoip->setIp($ipAddr);

	            // get GeoIP country code
	            $countryCode = $geoip->getCountryCode();
	            if(isset($countryCode) && $countryCode == "GB")
	            	$countryCode = "UK";

				$req_arr = array(
					'action' => 'lead_create',
					'wpusername' => $user->email,
					'locale' => config('app.locale'),
					'country' => !empty($countryCode) ? $countryCode : config('country.code'),
					'verification_link' => config('app.url').'/'.config('app.locale').'/verify/user/email/'.$user->email_token,
					'type' => ($user->user_type_id == config('constant.partner_type_id')) ? 4 : 1,
					'firstname' => $user->profile->first_name,
					'lastname' => $user->profile->last_name,
					'newsletter' => (isset($req['newsletter']) && $req['newsletter'] == 1)? 1 : 0,
					'utm_source' => (Session::has('utm_source')) ? Session::get('utm_source') : '',
					'utm_medium' => (Session::has('utm_medium')) ? Session::get('utm_medium') : '',
					'utm_campaign' => (Session::has('utm_campaign')) ? Session::get('utm_campaign') : '',
					'utm_content' =>  (Session::has('utm_content')) ? Session::get('utm_content') : '',
					'url' => (isset($req['current_url'])) ? $req['current_url'] : '',
					'referer' => (isset($req['referer_url'])) ? $req['referer_url'] : '',
					'useragent' => ($request->header('User-Agent')) ? $request->header('User-Agent') : '',
					'google_gclid' => (Session::has('gclid')) ? Session::get('gclid') : '',
					'google_clientId' => (Session::has('clientId')) ? Session::get('clientId') : '',
					'utm_term' => (Session::has('utm_term')) ? Session::get('utm_term') : '',
					'tel' => "",
					'tel_prefix' => ""
				);
				
				$response = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array', ['Request Array lead_create' => $req_arr]);
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Request Array lead_create' => $json]);
			// }
			
			// Message Notification & Redirection
			// $request->session()->flash('message', t("Your account has been created"));
			$message = t("Your account has been created");
			// $nextUrl = config('app.locale') . '/register/finish';

			$nextUrl = config('app.url').'/'.config('app.locale');
			
			// Send Admin Notification Email
			// if (config('settings.mail.admin_email_notification') == 1) {
			// 	try {
			// 		// Get all admin users
			// 		$admins = User::withoutGlobalScopes()->where('is_admin', 1)->get();
			// 		if ($admins->count() > 0) {
			// 			foreach ($admins as $admin) {

			// 				Mail::send(new UserNotification($user, $admin));
			// 			}
			// 		}
			// 	} catch (\Exception $e) {
			// 		flash()->error($e->getMessage());
			// 	}
			// }

			if(config('app.is_verify_email') == true){

				// Send Email Verification message
				if ($emailVerificationRequired) {

					// $message = $request->session()->flash('message', t("Confirmation email has been sent"));
					$message = t("Confirmation email has been sent");
					// Save the Next URL before verification
					session(['userNextUrl' => $nextUrl]);

					// Send
					$this->sendVerificationEmail($user);

					// Show the Re-send link
					$this->showReSendVerificationEmailLink($user, 'user');
				}

				// Send Phone Verification message
				if ($phoneVerificationRequired) {
					// Save the Next URL before verification
					session(['userNextUrl' => $nextUrl]);

					// Send
					$this->sendVerificationSms($user);

					// Show the Re-send link
					$this->showReSendVerificationSmsLink($user, 'user');

					// Go to Phone Number verification
					$nextUrl = config('app.locale') . '/verify/user/phone/';
				}

				// Redirect to the user area If Email or Phone verification is not required
				if (!$emailVerificationRequired && !$phoneVerificationRequired) {
					if (Auth::loginUsingId($user->id)) {
						//$request->session()->flash('message', t("Your account has been created"));

						return Response::json(array(
							'success' => true,
							'message' => t("Your account has been created"),
							'redirectUrl' => config('app.locale') . '/account',
						));exit();

						// return redirect()->intended(config('app.locale') . '/account');
					}
				}

				// store register user basic details
				// $this->register_api_call("", $user, $request);
				
				$data['redirectUrl'] = $nextUrl;

				// return $data;
				// Redirection
				// return redirect($nextUrl);
				if ($message === "") {
					$message = t("Confirmation email has been sent");
				}
				return Response::json(array(
					'success' => true,
					'message' => $message,
					'redirectUrl' => $nextUrl,
				));
				exit();
			}else{

				$message = t("Confirmation email has been sent");

				$url = config('app.url').'/'.config('app.locale').'/verify/user/email/'.$userInfo['email_token'];
				return Response::json(array(
					'success' => true,
					'message' => $message,
					'redirectUrl' => $url,
					'direct' => true
				));
				exit();
			}
		}
	}

	public function registerData($slug, Request $request) {
		$user_id = '';
		if (isset($request->user_id)) {
			$user_id = $request->user_id;
		}

		if (isset($request->user_type) && $request->user_type == 3) {

			$rules = [
				'cs_birthday_birthDay' => 'required|before:tomorrow',
				'category' => 'required',
				'phone_code' => 'required',
				'phone' => 'required|numeric|mb_between:5,20',
				'country' => 'required',
				'city' => 'required',
				'street' => 'required|street_validate',
				'zip' => 'required|regex:/^[A-Za-z0-9 ]+$/',
				// 'height' => 'required',
				// 'weight' => 'required',
				// 'dressSize' => 'required',
				// 'eyeColor' => 'required',
				// 'hairColor' => 'required',
				// 'shoeSize' => 'required',
				// 'skinColor' => 'required',
				'gender' => 'required',
				'preferred_language' => 'required'
			];

			if (isset($request->age) && $request->age < 18) {
				$rules['fname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
				$rules['lname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
			}
		} else {

			$rules = [
				'category' => 'required',
				'phone_code' => 'required',
				'phone' => 'required|numeric|mb_between:5,20',
				'country' => 'required',
				'city' => 'required',
				'street' => 'required|street_validate',
				'zip' => 'required|regex:/^[A-Za-z0-9]+$/',
				'company_name' => 'required|mb_between:2,200|whitelist_word_title',
				'website' => 'required|web_domain_valid|whitelist_domain|max:100',
				//'gender' => 'required',
				'preferred_language' => 'required'
			];
		}

		// $messages = [
		// 	'cs_birthday_birthDay.required' => t('birthday_required'),
		// 	'fname_parent.required' => t('fname_parent_required'),
		// 	'lname_parent.required' => t('lname_parent_required'),
		// 	'category.required' => t('category_required'),
		// 	'phone_code.required' => t('phone_code_required'),
		// 	'phone.required' => t('phone_required'),
		// 	'phone.integer' => t('phone_invalid'),
		// 	'country.required' => t('country_required'),
		// 	'city.required' => t('city_reruired'),
		// 	'street.required' => t('street_required'),
		// 	'zip.required' => t('postcode_required'),
		// 	'height.required' => t('height_required'),
		// 	'weight.required' => t('weight_required'),
		// 	'dressSize.required' => t('dresssize_required'),
		// 	'eyeColor.required' => t('eyecolor_required'),
		// 	'hairColor.required' => t('haircolor_required'),
		// 	'shoeSize.required' => t('shoesize_required'),
		// 	'skinColor.required' => t('skincolor_required'),
		// 	'gender.required' => t('gender_required'),
		// ];

		$validator = Validator::make($request->all(), $rules);

		$countryname = $request->input('country_name');
		$country_code = $request->input('country');
		// commented city code
		// $cityname = $request->input('city_name');

		// $countryname=$request->input('country_name');
		// commented city code
		// $cityname=$request->input('city_name');
		// $address=$request->input('street').','.$request->input('city_name').','.$request->input('zip').','.$request->input('country_name');
		$cityname=$request->input('city');
		$user = User::find($request->input('user_id'));
		$userdetail = UserProfile::where('user_id', $request->input('user_id'))->first();

		// $latitude = $user->latitude;
		// $longitude = $user->longitude;

		// if($user->profile->street != $request->input('street') || $user->country_code != $request->input('country') || $user->profile->city != $cityname || $user->profile->zip != $request->input('zip') )
		// {
		// 	$address=$request->input('street').','.$request->input('city').','.$request->input('zip').','.$request->input('country_name');
		// 	$googleurl=config('app.g_latlong_url');
		// 	$apikey=config('app.latlong_api');

		// 	$formattedAddr = str_replace(' ','+',$address);
		// 	//Send request and receive json data by address
		// 	// $url = file_get_contents($googleurl.urlencode($address).'&key='.$apikey); 
		// 	// $response = json_decode($url);
			  
		// 	// if ($response->status == 'OK')
		// 	// {
		// 	//     $latitude = str_replace(",", ".", $response->results[0]->geometry->location->lat);
		// 	//     $longitude = str_replace(",", ".", $response->results[0]->geometry->location->lng);
		// 	// } 
		// 	// else
		// 	// {
		// 	//     $latitude = '';
		// 	//     $longitude = '';
		// 	// }
		// 	// $map = [$latitude,$longitude];
		// 	// $map_value=implode(',', $map);

		// 	$url = $googleurl . $formattedAddr . '&key=' . $apikey.'&sensor=true';
		// 	$ch = curl_init();
	 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 //        curl_setopt($ch, CURLOPT_URL, $url);
	 //        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	 //        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	 //        $data = curl_exec($ch);
	 //        curl_close($ch);
	 //        $output= json_decode($data);
	 //        if(count($output->results) != 0) {
	 //            $latitude  = str_replace(",", ".", $output->results[0]->geometry->location->lat);
	 //            $longitude = str_replace(",", ".", $output->results[0]->geometry->location->lng);
	 //        }else{
	 //        	$latitude = '';
		// 		$longitude = '';
	 //        }
	 //    }    
		if ($validator->fails()) {
			return \Redirect::back()->withInput()->withErrors($validator->messages());
		} 

		$country = "";
		$country_type=config('constant.country_premium');
		if(isset($country_code) && !empty($country_code)){
			$country = Country::where('code', $country_code)->first();

			if(isset($country->country_type) && $country->country_type == config('constant.country_free')){
				$country_type=config('constant.country_free');
			}
		}

		 
		
		if ($user->user_type_id == config('constant.partner_type_id')) {
			//in db 2-partner 3-model ------ in crm 1-model 4-partner

			// Call CRM API for action
			$return = $this->register_api_call($slug, $user, $request);

			if ($return['response_status'] == true) {
				if ($return['status'] == true) {
					try
					{
						// $user->latitude = $latitude;
						// $user->longitude = $longitude;
						// Update
						$user->phone_code = $request->input('phone_code');
						$user->phone = $request->input('phone');
						$user->gender_id = $request->input('gender');
						$user->profile->birth_day = ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '';
						$user->profile->fname_parent = $request->input('fname_parent');
						$user->profile->lname_parent = $request->input('lname_parent');
						// $user->profile->phone_code = $request->input('phone_code');
						// $user->profile->phone_number = $request->input('phone');
						$user->profile->street = $request->input('street');
						$user->profile->city = $request->input('city');
						$user->profile->geo_state = $request->input('geo_state');
						// $user->profile->country = $request->input('country');
						$user->country_code = $request->input('country');
						$user->profile->zip = $request->input('zip');
						$user->profile->category_id = $request->input('category') ? $request->input('category') : 0;
						$preferred_language = $request->input('preferred_language') ? $request->input('preferred_language') : config('app.locale');
						$user->profile->preferred_language = $preferred_language;

						//store company details
						$user->company->name = $request->input('company_name') ? $request->input('company_name') : "";
						$user->company->website = $request->input('website') ? $request->input('website') : "";
						
						// $user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
						// $user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
						// $user->profile->size_id = $request->input('dressSize') ? $request->input('dressSize') : 0;
						// $user->profile->hair_color_id = $request->input('hairColor') ? $request->input('hairColor') : 0;
						// $user->profile->skin_color_id = $request->input('skinColor') ? $request->input('skinColor') : 0;
						// $user->profile->eye_color_id = $request->input('eyeColor') ? $request->input('eyeColor') : 0;
						// $user->profile->shoes_size_id = $request->input('shoeSize') ? $request->input('shoeSize') : 0;

						if (!isset($user->profile->contract_link) && empty($user->profile->contract_link)) {

							// $user->profile->contract_link = url('/') . '/' . config('app.locale') . "/contract/?code=" . $slug . '&d=' .$user->country_code. "&id=" . $user->username . "&subid=_access_partner";
							
							// url string
							$string = 'code='.$slug.'&d='.$user->country_code.'&id='.$user->username.'&subid=_access_partner';

							// call encrypt url functions
							$url_res = CommonHelper::dec_enc('encrypt', $string);

							$user->profile->contract_link = url('/') . '/' . $preferred_language . "/contract/?".$url_res;
						}

						$user->is_profile_completed = '1';
						$user->user_register_type = $country_type;
						// Save
						$user->company->save();
						$user->profile->save();
						$user->save();

						//flash(t("Your account profile has updated successfully"))->success();
						$request->session()->flash('success', t("Your profile is under review"));
						// $nextUrl = config('app.locale') . '/register/finish/'.$slug;
						$nextUrl = config('app.locale') . '/' . trans('routes.registerFinish') . '/' . $slug;
					} catch (Exception $e) {
						$user->profile->delete();
						$user->delete();

						// Call CRM API for "deleted" action
						$req_arr = array(
							'action' => 'deleted', //required
							'wpusername' => $user->username, // required api
						);
						$response = CommonHelper::go_call_request($req_arr);
						$responsejson = json_decode($response->getBody());
						Log::info(print_r($responsejson, true));
						$nextUrl = config('app.locale') . '/';
					}
				} else {
					$request->session()->flash('error', $return['message']);
					$nextUrl = config('app.locale') . '/';
				}
			} else {
				// Show error in flash message
				$request->session()->flash('message', t('Something went wrong Please try again'));
				$nextUrl = config('app.locale') . '/';
			}

			/*

				// Call CRM API for "create" action
				$req_arr = array(
					'action' => 'create', //required
					'wpusername' => $user->username, // required api
					'type' => ($user->user_type_id == '2') ? 4 : 1,
					'name' => $user->profile->first_name,
					'lname' => $user->profile->last_name,
					'vp_name' => $request->input('fname_parent'),
					'vp_name_last' => $request->input('lname_parent'),
					'email' => $user->email,
					'street' => $request->input('street'),
					'zip' => $request->input('zip'),
					'city' => $request->input('city'),
					'locale' => config('app.locale'),
					'country' => config('country.code'),
					'tel' => $request->input('carrierCode') . $request->input('phone'),
					'birthday' => $request->input('cs_birthday_birthDay'),
					'under18' => $request->input('cs_under_18'),
					'gender' => $request->input('gender'),
					'user_hash' => $slug,
					'gclid' => ($request->input('gclid_field')) ? $request->input('gclid_field') : '',
				);

				Log::info('Request Array', ['Request Array' => $req_arr]);
				// print_r($req_arr);exit;
				$response = CommonHelper::go_call_request($req_arr);
				if ($response->getStatusCode() == 200) {
					// Valid response
					$json = json_decode($response->getBody());
					Log::info('Create User', ['create_user' => $json]);
					// $json = json_decode($body);

					if (isset($json) && isset($json->code)) {
						// Create record
						try {

							// Update
							// $user->phone = $request->input('carrierCode') . $request->input('phoneNumber');
							$user->phone = $request->input('phone');
							$user->gender_id = $request->input('gender');
							$user->profile->birth_day = $request->input('cs_birthday_birthDay');
							$user->profile->fname_parent = $request->input('fname_parent');
							$user->profile->lname_parent = $request->input('lname_parent');
							$user->profile->phone_number = $request->input('phone');
							$user->profile->street = $request->input('street');
							$user->profile->city = $request->input('city');
							$user->profile->country = $request->input('country');
							$user->country_code = $request->input('country');
							$user->profile->zip = $request->input('zip');
							$user->profile->category_id = $request->input('category') ? $request->input('category') : 0;
							$user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
							$user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
							$user->profile->size_id = $request->input('dressSize') ? $request->input('dressSize') : 0;
							$user->profile->hair_color_id = $request->input('hairColor') ? $request->input('hairColor') : 0;
							$user->profile->skin_color_id = $request->input('skinColor') ? $request->input('skinColor') : 0;
							$user->profile->eye_color_id = $request->input('eyeColor') ? $request->input('eyeColor') : 0;
							$user->profile->shoes_size_id = $request->input('shoeSize') ? $request->input('shoeSize') : 0;
							$user->profile->contract_link = url('/') . '/' . config('app.locale') . "/contract/create/?d=" . config('country.code') . "&code=" . $slug . "&id=" . $user->username . "&subid=_access";
							$go_code = explode('-', $json->code);

							if (count($go_code) > 0) {
								Log::info('Go code', ['Go code' => $go_code]);
								$user->profile->go_code = $go_code[1];
							}

							// Save
							$user->profile->save();
							$user->save();
							$response = CommonHelper::go_call_request($req_arr);
							// if ($response->getStatusCode() == 200) {
							// 	$go_code = (string) $response->getBody();
							// 	//dd($go_code);
							// 	Log::info('Save GO code', ['go_code' => $go_code]);
							// 	$user->profile->go_code = $go_code;
							// 	$user->profile->save();
							// }

							// $request->session()->flash('success', 'Registration done. contract link = '.$user->
							// );

							flash(t("Your account profile has updated successfully"))->success();
							if ($user->user_type_id == 3) {
								$nextUrl = config('app.locale') . '/' . trans('routes.registerPhoto') . '/' . $slug;
							} else {
								$request->session()->flash('success', t("Your profile is under review"));
								$nextUrl = config('app.locale') . '/register/finish';
							}

						} catch (Exception $e) {

							$user->profile->delete();
							$user->delete();

							// Call CRM API for "deleted" action
							$req_arr = array(
								'action' => 'deleted', //required
								'wpusername' => $user->username, // required api
							);
							$response = CommonHelper::go_call_request($req_arr);
							$responsejson = json_decode($response->getBody());
							Log::info(print_r($responsejson, true));
							$nextUrl = config('app.locale') . '/';
						}
					} else {
						// Display error of API
						$user->profile->delete();
						$user->delete();

						// Call CRM API for "deleted" action
						$req_arr = array(
							'action' => 'deleted', //required
							'wpusername' => $user->username, // required api
						);
						$response = CommonHelper::go_call_request($req_arr);
						$responsejson = json_decode($response->getBody());
						Log::info(print_r($responsejson, true));
						$request->session()->flash('error', $responsejson);
						$nextUrl = config('app.locale') . '/';
					}
				} else {
					// Show error in flash message
					$request->session()->flash('message', t('Something went wrong Please try again'));
					$nextUrl = config('app.locale') . '/';
				}
			*/
			return redirect($nextUrl);
		} else {

			// //get the user country and check the free user country
			// $country = Country::withoutGlobalScopes()->where('code', $request->input('country') )->first();


			// Call CRM API for action
			$return = $this->register_api_call($slug, $user, $request);
			
			if ($return['status'] == false) {
				// Show error in flash message
				$request->session()->flash('message', t('Something went wrong Please try again'));
				$nextUrl = config('app.locale') . '/';
			} else {

				// $city = $request->input('city');

				// if(isset($city) && !empty($city)){
				// 	$city = explode(',', $city);
				// 	$city = ( count($city) > 0 && isset($city[0]) )? $city[0] : $request->input('city');
				// }

				// $user->latitude = $latitude;
				// $user->longitude = $longitude;
				$user->phone_code = $request->input('phone_code');
				$user->phone = $request->input('phone');
				$user->gender_id = $request->input('gender');
				$user->profile->birth_day = ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '';
				$user->profile->fname_parent = $request->input('fname_parent');
				$user->profile->lname_parent = $request->input('lname_parent');
				$user->profile->street = $request->input('street');
				$user->profile->city = $request->input('city');
				$user->profile->geo_state = $request->input('geo_state');
				// $user->profile->country = $request->input('country');
				$user->country_code = $request->input('country');
				$user->profile->zip = $request->input('zip');
				$user->profile->category_id = $request->input('category') ? $request->input('category') : 0;
				$user->user_register_type = $country_type;
				$preferred_language = $request->input('preferred_language') ? $request->input('preferred_language') : config('app.locale');
				$user->profile->preferred_language = $preferred_language;
				
				// $user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
				// $user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
				// $user->profile->size_id = $request->input('dressSize') ? $request->input('dressSize') : 0;
				// $user->profile->hair_color_id = $request->input('hairColor') ? $request->input('hairColor') : 0;
				// $user->profile->skin_color_id = $request->input('skinColor') ? $request->input('skinColor') : 0;
				// $user->profile->eye_color_id = $request->input('eyeColor') ? $request->input('eyeColor') : 0;
				// $user->profile->shoes_size_id = $request->input('shoeSize') ? $request->input('shoeSize') : 0;
				

				if (!isset($user->profile->contract_link) && empty($user->profile->contract_link)) {
					// $user->profile->contract_link = url('/') . '/' . config('app.locale') . "/contract/?code=" . $slug .'&d=' .$user->country_code. "&id=" . $user->username . "&subid=_access";

					$subid = '_access';
					if(isset($user->country->country_type) && $user->country->country_type == config('constant.country_free') ){
						$subid = '_access_free';
					}
					
					// url string
					$string = 'code='.$slug.'&d='.$user->country_code.'&id='.$user->username.'&subid='.$subid;

					// call encrypt url functions
					$url_res = CommonHelper::dec_enc('encrypt', $string);

					$user->profile->contract_link = url('/').'/'.$preferred_language."/contract/?".$url_res;
				}



				$user->profile->save();
				$user->save();

				//flash(t("Your account profile has updated successfully"))->success();
				if ($user->user_type_id == 3) {
					$nextUrl = config('app.locale') . '/' . trans('routes.registerPhoto') . '/' . $slug;
				} else {
					$request->session()->flash('success', t('Your profile is under review'));
					// $nextUrl = config('app.locale') . '/register/finish/'.$slug;
					$nextUrl = config('app.locale') . '/' . trans('routes.registerFinish') . '/' . $slug;
				}
			}
			return redirect($nextUrl);
		}

	}

	public function registerPhoto($slug, Request $request) {

		$user = User::find($request->input('user_id'));

		if (isset($request->modelbook) && !empty($request->modelbook)) {

			// Get User
			// if ($request->hasFile('profile.logo')) {
			// 	$rules['profile.logo'] = 'mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000);
			// 	$msg['profile.logo.mimes'] = t('The profile picture must be a file of type: jpg, jpeg, gif, png');
			// 	$this->validate($request, $rules, $msg);
			// }

			if ($request->hasFile('modelbook.filename')) {

				$rules['modelbook.filename.*'] = 'mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000);

				$mobelBookArr = $request->file('modelbook.filename');

				if( isset($mobelBookArr) && !empty($mobelBookArr)  && count($mobelBookArr) > 0 ){
					foreach ($mobelBookArr as $key => $value) {
						$msg['modelbook.filename.'.$key.'.mimes'] = t('model_book_valid_image :key',['key' => ($key+1)]);
					}
				}

				$this->validate($request, $rules, $msg);

				$destination_path = 'uploads/modelbooks/' . $user->id;
				
				if(Storage::exists('modelbooks/'.$user->id)){
					Storage::makeDirectory('modelbooks/'.$user->id , 0775, true);
				}
				
				$i = 0;
				$mobelBookArr = $request->file('modelbook.filename'); 
				if( isset($mobelBookArr) && !empty($mobelBookArr) ){

				 	foreach ($mobelBookArr as $value) {

						if (!empty($value)) {

							$image_file = $value;

							// check image oriantation and correct it
							$filename = $image_file->getPathName();
				            CommonHelper::checkImageOriatation($filename);
				            
							$image_name = $image_file->getClientOriginalName();
							$image = value(function () use ($image_file) {
								$filename = str_random(15) . '.' . $image_file->getClientOriginalExtension();
								return strtolower($filename);
							});

							$value->move($destination_path, $image);

							$filename = str_replace('uploads/', '', $destination_path);

							$filename = $filename . '/' . $image;

							$modelbookInfo[$i] = [
								'country_code' => config('country.code'),
								'user_id' => $user->id,
								'active' => 1,
								'filename' => $filename,
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
							];
							$i++;
						}
					}
					$modelbook = ModelBook::insert($modelbookInfo);
				}
			}

			// if ($request->hasFile('profile.logo')) {
			// 	$user->profile->logo = $request->file('profile.logo');
			// }

			// update
			// $user->profile->save();

			/*
				if ($request->hasFile('modelbook.filename')) {
					$modelbookInfo = [
						'country_code' => config('country.code'),
						'user_id' => $user->id,
						'active' => 1,
					];
					$modelbook = new ModelBook($modelbookInfo);
					$modelbook->save();

					// Save the Resume's File
					$modelbook->filename = $request->file('modelbook.filename');
					$modelbook->save();
				}
			*/



			// if (!empty($user)) {
			// 	// Call CRM API for action
			// 	$return = $this->register_api_call($slug, $user, $request);

			// 	if ($return['response_status'] == true) {
			// 		if ($return['status'] == true) {
			// 			$request->session()->flash('success', t('Your profile is under review'));
			// 			$nextUrl = config('app.locale') . '/register/finish';
			// 		} else {
			// 			$request->session()->flash('error', $return['message']);
			// 			$nextUrl = config('app.locale') . '/';
			// 		}
			// 	} else {
			// 		// Show error in flash message
			// 		$request->session()->flash('message', t('Something went wrong Please try again'));
			// 		$nextUrl = config('app.locale') . '/';
			// 	}
			// }

		}

		// if ($request->hasFile('profile.logo')) {
		// 	$rules['profile.logo'] = 'required|mimes:' . getUploadFileTypes('file') . '|max:' . (int) config('settings.upload.max_file_size', 1000);
		// 	$this->validate($request, $rules);
		// }
		// if ($request->hasFile('modelbook.filename')) {
		// 	$rules['modelbook.filename'] = 'required|mimes:' . getUploadFileTypes('file') . '|max:' . (int) config('settings.upload.max_file_size', 1000);
		// 	$this->validate($request, $rules);
		// }
		// // Get User
		// $user = User::find($request->input('user_id'));
		// if ($request->hasFile('profile.logo')) {
		// 	$user->profile->logo = $request->file('profile.logo');
		// }

		// // update
		// $user->profile->save();

		// if ($request->hasFile('modelbook.filename')) {
		// 	$modelbookInfo = [
		// 		'country_code' => config('country.code'),
		// 		'user_id' => $user->id,
		// 		'active' => 1,
		// 	];
		// 	$modelbook = new ModelBook($modelbookInfo);
		// 	$modelbook->save();

		// 	// Save the Resume's File
		// 	$modelbook->filename = $request->file('modelbook.filename');
		// 	$modelbook->save();
		// }

		$request->session()->flash('success', t('Your profile is under review'));
		$nextUrl = config('app.locale') . '/' . trans('routes.registerFinish') . '/' . $slug;

		// if (!empty($user)) {
		// 	// Call CRM API for action
		// 	$return = $this->register_api_call($slug, $user, $request);

		// 	if ($return['response_status'] == true) {
		// 		if ($return['status'] == true) {
		// 			$request->session()->flash('success', t('Your profile is under review'));
		// 			// $nextUrl = config('app.locale') . '/register/finish/'.$slug;
		// 			$nextUrl = config('app.locale') . '/' . trans('routes.registerFinish') . '/' . $slug;
		// 		} else {
		// 			$request->session()->flash('error', $return['message']);
		// 			$nextUrl = config('app.locale') . '/';
		// 		}
		// 	} else {
		// 		// Show error in flash message
		// 		$request->session()->flash('message', t('Something went wrong Please try again'));
		// 		$nextUrl = config('app.locale') . '/';
		// 	}
		// }
		return redirect($nextUrl);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
	 */
	public function finish($slug) {

		$user = "";

		if (isset($slug) && !empty($slug)) {
			$user = User::getUserBySlug($slug);
			view()->share('uriPathPageSlug', $slug);
		}

		if (empty($user) && $user == '') {
			flash(t("Sorry, we don't recognize that email address"))->error();
			return redirect(config('app.locale'));
		}

		// if user is exists and register flow completed then update is_register_complated flag true
		if (isset($user) && !empty($user)) {
			$user->is_register_complated = 1;
			$user->save();
		}

		

		// Keep Success Message for the page refreshing
		$data = array();
		// MetaTag::set('title', session('message'));
		// MetaTag::set('description', session('message'));

		session()->keep(['success']);
		$data['user'] = $user;
		$data['uriPath'] = 'finish';

		$property = [];
		
		if(isset($user->user_type_id) && $user->user_type_id == config('constant.model_type_id')){
			
			$property = $this->getUnitMeasurementByUser($user);
		}

		$data['properties'] = $property;

		// check user type is free or premium
		$data['is_premium_user'] = true;
		if( isset($user->country->country_type) && in_array($user->country->country_type, ['free']) 
            && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
        ){
            $data['is_premium_user'] = false;
        }
         
		return view('thanks', $data);
	}


	public function register_api_call($slug, $user, $request) {
		$req = $request->all();
		$action = 'create';
		// check username && email exist
		$get_arr = array(
			'action' => 'check_exists', //required
			'wpusername' => $user->username, // required api
			'email' => $user->email,
		);

		$res = CommonHelper::go_call_request($get_arr);

		if ($res->getStatusCode() == 200) {
			$getData = json_decode($res->getBody());
			if (isset($getData) && isset($getData->username) && isset($getData->email)) {
				if ($getData->username == 1 && $getData->email == 1) {
					$action = 'update';
				}
			}
		}

		$country_name = isset($req['country_name'])?$req['country_name'] : '';
		// commented city code
		// $city_name = $request->input('city_name');

		$city_name = isset($req['city'])?$req['city'] : '';
		$fullCityName = isset($req['city'])?$req['city'] : '';
		if(isset($city_name) && !empty($city_name)){
			$city_name = explode(',', $city_name);
			$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $req['city'];
		}

		$street = isset($req['street'])?$req['street'] : '';
		$zip = isset($req['zip'])?$req['zip'] : '';

		// $geo_state = isset($req['geo_state'])?$req['geo_state'] : '';

		// model or parent category based on type
		$category_id = isset($req['category'])?$req['category'] : "";

		// get user type 
		$user_type = isset($req['user_type'])?$req['user_type'] : $user->user_type_id;

		if(empty($category_id) && $category_id == ""){

			if($user_type == 2){
				$category_name = isset($user->profile->partnercategory->slug)? $user->profile->partnercategory->slug : '';
			}else{
				$category_name = isset($user->profile->modelcategory->slug)? $user->profile->modelcategory->slug : "";
			}
		} else {
			$category_name = ($user_type == 2)? Branch::getBranchName($category_id, 'slug') : ModelCategory::getModelCateogryName($category_id, 'slug');
		}

		$fname_parent = $lname_parent = '';
		//if birthday presents in request data then consider parent's detail from request
		if(isset($req['age']) && $req['age'] < 18){
			$fname_parent = $req['fname_parent'];
			$lname_parent = $req['lname_parent'];
		}
		//if birthday not presents in request data then consider parent details stored in db
		elseif(!isset($req['age']) && isset($user->profile)){
			$fname_parent = ($user->profile->fname_parent)? $user->profile->fname_parent : '';
			$lname_parent = ($user->profile->lname_parent)? $user->profile->lname_parent : '';
		}
		
		// if ($action == 'update' && isset($user->profile)) {
		// 	$fname_parent = ($user->profile->fname_parent)? $user->profile->fname_parent : '';
		// 	$lname_parent = ($user->profile->lname_parent)? $user->profile->lname_parent : '';
		// }

		//check gender
		$gender_id = config('constant.crm_female');

		if( isset($req) && !empty($req['gender']) ){
			if($req['gender'] == config('constant.gender_male')){
				$gender_id = config('constant.crm_male');
			}
		}else{
			if($action === 'update'){ 
				$gender_id = ($user->gender_id == config('constant.gender_male'))? config('constant.crm_male') : config('constant.crm_female');
			}
		}

		if(empty($country_name)){
			$country_name = $user->country->name;
		}

		if(empty($city_name)){
			// commented city code
			// $city_name = $user->profile->cities->name;
			$city_name = $user->profile->city;
		}

		if(empty($street)){
			$street = $user->profile->street;
		}

		if(empty($zip)){
			$zip = $user->profile->zip;
		}

		// if(empty($geo_state)){

		// 	$geo_state = $user->profile->geo_state;
		// }

		// $countryname=$request->input('country_name');
		// $cityname=$request->input('city_name');
		
		// get lat long to address. 
		$longlat = array();
		$google_api_key_maps = config('app.latlong_api');

		# Comment working code get lat long by AJ (19-06-2020)
		/*
		$googleurl = config('app.g_latlong_url');
		$google_api_key_maps = config('app.latlong_api');
		$address = $street.", ".$zip.', '.$fullCityName	.', '.$country_name;
		$address = urlencode ($address);
		
		$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$req['country'].'&key='.$google_api_key_maps;

		// call get latitude longitude 
		$longlat = CommonHelper::getLatLong($url);
		
		// if invalid street and zip code, get latlong full city name
		if(empty($longlat)){
			$address = $fullCityName.', '.$country_name;
			$address = urlencode ($address);
			$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$req['country'].'&key='.$google_api_key_maps;
			// call get latlong
			$longlat = CommonHelper::getLatLong($url);

 
		}
 
		$geo_lat    =  isset($longlat[0])? strval($longlat[0]) : '';
        $geo_long   =  isset($longlat[1])? strval($longlat[1]) : '';
        $geo_city   =  isset($longlat[2])? $longlat[2] : '';
        $geo_state  =  isset($longlat[3])? $longlat[3] : '';
        $region 	=  isset($longlat['region'])? $longlat['region'] : '';
        $geo_country = $country_name;
        $geo_full = $street.", ".$zip.', '.$geo_city; 
		# End Comment working code get lat long by AJ (19-06-2020)
		*/
		

		$geo_lat    	=  	'';
        $geo_long   	=  	'';
        $geo_city  	 	=  	$request->input('geo_city');
        $geo_state  	=  	$request->input('geo_state');
        $geo_country 	= 	$request->input('geo_country');
        $geo_full 		= 	$street.", ".$zip.', '.$city_name;
		$latitude 		= 	$request->input('latitude');
    	$longitude 		= 	$request->input('longitude');


        // current timestamps
		$current_timestamp = strtotime("now");
		$dbTimeZoneId = '';
		$timeZoneName = '';
		$is_call_timeZone_api = false;
		
		// get default timeZone in country table  
		$getCountryTimeZone = Country::select('time_zone_id')->where('code', $req['country'])->where('time_zone_id', '>', 0)->first();
		
		// check default time zone exist or not
	    if(empty($getCountryTimeZone)){
			$is_call_timeZone_api = true;
			if(isset($geo_state) && !empty($geo_state)){
				// if default time zone empty, get state wise timeZone in state table
		    	$stateTimeZone = States::where('country_code', $req['country'])->where('state_name', $geo_state)->first();
		    	if(!empty($stateTimeZone)){
					$dbTimeZoneId = $stateTimeZone->timeZone->id;
					$timeZoneName = $stateTimeZone->timeZone->time_zone_id;
					$is_call_timeZone_api = false;
		    	}
			}
	    }else{
	    	$dbTimeZoneId = isset($getCountryTimeZone->timeZone->id)? $getCountryTimeZone->timeZone->id : '';
			$timeZoneName = isset($getCountryTimeZone->timeZone->time_zone_id)? $getCountryTimeZone->timeZone->time_zone_id : '';
	    }
		
		// get user timezone if no change user city 
		if(empty($latitude) && empty($longitude) && !empty($user->profile->timezone) && $user->profile->timezone > 0 && empty($dbTimeZoneId)){
			$dbTimeZone = TimeZone::where('id', $user->profile->timezone)->first();
			$dbTimeZoneId = $dbTimeZone->id;
			$timeZoneName = $dbTimeZone->time_zone_id;
			$is_call_timeZone_api = false;
		}
		
		// call google api to get timezone if not abel to fetch from country and state db table
	    if($is_call_timeZone_api == true){
			// Log::info('google_timezone_api_url url', ['google_timezone_api_url url' => $google_timezone_api_url]);
			$getTimeZone = '';
	    	$is_timezone_api_success = false;
	    	
	    	if(!empty($latitude) && !empty($longitude)){
	    		// Get Google TimeZone Api call url
				$timeZoneUrl = config('app.google_timezone_api_url').$latitude.','.$longitude.'&timestamp='.$current_timestamp.'&key='.$google_api_key_maps;
				// Log::info('Timezone request url', ['Request url' => $timeZoneUrl]);
				// call google maps api, Get TimeZone
				$getTimeZoneApiCall = file_get_contents($timeZoneUrl);
				$getTimeZone = json_decode($getTimeZoneApiCall);
			}
			
			if(!empty($getTimeZone)){
				if(isset($getTimeZone->status)){
					if($getTimeZone->status == 'OK'){
						// get timezone by google time zone id
						$dbTimeZone = TimeZone::where('time_zone_id', $getTimeZone->timeZoneId)->first();
						if(isset($dbTimeZone->id)){
							$is_timezone_api_success = true;
							$dbTimeZoneId = $dbTimeZone->id;
							$timeZoneName = $dbTimeZone->time_zone_id;
							if(isset($geo_state) && !empty($geo_state)){
								// Save new timezone in state table
								$states = array(
									'country_code' => $request->input('country'),
									'state_name' => $geo_state,
									'time_zone_id' => $dbTimeZone->id,
								);
								$statesObj = new States($states);
								$statesObj->save();
							}
						}
					}
				}
			}
			// if timezone api call get error, current selected coutry timezone
			if($is_timezone_api_success == false){
				$dbTimeZone = TimeZone::where('country_code', $request->input('country'))->first();
				$dbTimeZoneId = $dbTimeZone->id;
				$timeZoneName = $dbTimeZone->time_zone_id;
			}
		}

		// $address = $street.','.$city_name.','.$zip.','.$country_name;

		// $googleurl=config('app.g_latlong_url');
		// $apikey=config('app.latlong_api');

		// $formattedAddr = str_replace(' ','+',$address);
		//Send request and receive json data by address
		// $url = file_get_contents($googleurl.urlencode($address).'&key='.$apikey); 
		// $response = json_decode($url);
		  
		// if ($response->status == 'OK')
		// {
		//     $latitude = str_replace(",", ".", $response->results[0]->geometry->location->lat);
		//     $longitude = str_replace(",", ".", $response->results[0]->geometry->location->lng);
		// } 
		// else
		// {
		//     $latitude = '';
		//     $longitude = '';
		// }
		
		// $url = $googleurl . $formattedAddr . '&key=' . $apikey.'&sensor=true';
		// $ch = curl_init();
	  	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  	// curl_setopt($ch, CURLOPT_URL, $url);
	  	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	  	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  	// $data = curl_exec($ch);
	  	// curl_close($ch);
	  	// $output= json_decode($data);
	  	// if(count($output->results) != 0) {
	  	// $latitude  = str_replace(",", ".", $output->results[0]->geometry->location->lat);
	  	// $longitude = str_replace(",", ".", $output->results[0]->geometry->location->lng);
	  	// }else{
	  	// $latitude = '';
		// $longitude = '';
	  	// }
	  	$verify_user_email_url =  config('app.url').'/'.config('app.locale').'/verify/user/email/'.$user->email_token;
	  	 
		if ($action == 'update') {
			$req_arr = array(
				'action' => $action, //required
				'wpusername' => $user->username, // required api
				'type' => ($user->user_type_id == '2') ? 4 : 1,
				'name' => $user->profile->first_name,
				'lname' => $user->profile->last_name,
				'vp_name' => $fname_parent,
				'vp_name_last' => $lname_parent,
				'email' => $user->email,
				'street' => $street,
				'zip' => $zip,
				'city' => $city_name,
				'locale' => ($request->input('preferred_language')) ? $request->input('preferred_language') : config('app.locale'),
				'country' => $user->country_code,
				'latitude' =>  $geo_lat,
				'longitude' => $geo_long,
				'tel' => $request->input('phone'),
				'tel_prefix' => $request->input('phone_code'),
				'birthday' => ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '',
				'under18' => '',
				'gender' => $gender_id,
				'user_hash' => $slug,
				'platform' => $category_name,
				'newsletter' => $user->receive_newsletter,
				'geo_lat' => $geo_lat,
				'geo_long' => $geo_long,

				'verification_link' => $verify_user_email_url,
				'timeZoneId' => $dbTimeZoneId,
				'timeZoneName' => $timeZoneName,
			);


			if(!empty($user->profile->logo) && Storage::exists($user->profile->logo)){
				$req_arr['imglink'] = \Storage::url(trim($user->profile->logo));
			}
			if(!empty($geo_city)){$req_arr['geo_city'] = $geo_city;}
	        if(!empty($geo_state)){$req_arr['geo_state'] = $geo_state;}
	        if(!empty($geo_country)){$req_arr['geo_country'] = $geo_country;}
	        if(!empty($geo_full)){$req_arr['geo_full'] = $geo_full;}

		} else {
			$req_arr = array(
				'action' => $action, //required
				'wpusername' => $user->username, // required api
				'type' => ($user->user_type_id == '2') ? 4 : 1,
				'name' => $user->profile->first_name,
				'lname' => $user->profile->last_name,
				'vp_name' => $fname_parent,
				'vp_name_last' => $lname_parent,
				'email' => $user->email,
				'street' => $request->input('street'),
				'zip' => $request->input('zip'),
				'city' => $city_name,
				'latitude' =>  $geo_lat,
				'longitude' => $geo_long,
				'locale' => ($request->input('preferred_language')) ? $request->input('preferred_language')  : config('app.locale'),
				'country' => $request->input('country'),
				'tel' => $request->input('phone'),
				'tel_prefix' => $request->input('phone_code'),
				'birthday' => ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '',
				'under18' => '',
				'gender' => $gender_id,
				'user_hash' => $slug,
				'platform' => $category_name,
				'newsletter' => $user->receive_newsletter,
				'geo_lat' => $geo_lat,
				'geo_long' => $geo_long,
				'geo_city' => $city_name,
				'geo_state' => $geo_state,
				'geo_country' => $geo_country,
				'geo_full' => $geo_full,
				'verification_link' => $verify_user_email_url,
				'timeZoneId' => $dbTimeZoneId, 
				'timeZoneName' => $timeZoneName,
			);
		}



		if($user->user_type_id == '2'){
			$req_arr['url'] = $user->profile->website_url;
		}
		
		if($action == "create" && isset($req['gclid_field'])){
			$req_arr['gclid'] = $req['gclid_field'];
		}
		// echo "<br>============================<br>";
		// echo '<pre>';print_r($req_arr);die;

		Log::info('Request Array', ['Request Array' => $req_arr]);
		 //print_r($req_arr);exit;
		$response = CommonHelper::go_call_request($req_arr);
		$status = false;
		$response_status = false;
		$message = '';

		if ($response->getStatusCode() == 200) {

			$response_status = true;
			// Valid response
			$json = json_decode($response->getBody());
			
			// print_r($json);
			Log::info('Create User', ['create_user' => $json]);
			// $json = json_decode($body);

			if (isset($json)) {

				if ($action == 'create' && isset($json->code)) {
					// $go_code = explode('-', $json->code);

					// if (count($go_code) > 0) {
					// 	Log::info('Go code', ['Go code' => $go_code]);
					// 	$user->profile->go_code = (isset($go_code[1])) ? $go_code[1] : '';
					// }
					$user->profile->go_code = $json->code;
					$status = true;
				} else if ($action == 'update') {
					$status = true;
				} else {
					$status = false;
				}

				//update newsletter status when new user is created
				if($action == 'create' && $status == true){
					// call CRM api for newsletter subscription
					$req_news = array(
						'action' => 'newsletter_subscription', //required
						'wpusername' => $user->username, // required api
						'newsletter_value' => $user->receive_newsletter,
					);

					Log::info('Create CRM API for newsletter', ['user_status' => $req_news]);

					$resp_newsletter = CommonHelper::go_call_request($req_news);

					if ($resp_newsletter->getStatusCode() == 200) {
						$json = json_decode($response->getBody());
						Log::info('Create User', ['newsletter_subscription' => $json]);
					}else{
						Log::info('Something wrong to call newsletter_subscription', ['user_status' => $req_news]);
					}

					// call CRM api for new registration. This case created call be called only one time when new user registers
					// $user->latitude = $geo_lat;
					// $user->longitude = $geo_long;
					

					$req_arr = array(
						'action' => 'created', //required
						'wpusername' => $user->username, // required api
					);
					$response = CommonHelper::go_call_request($req_arr);
				}

			}
			if ($status == false) {

				$message = 'Unable to update profile information. Please try again later.';

				$response_status = false; 
				/*
				// Call CRM API for "deleted" action
				$req_arr = array(
					'action' => 'deleted', //required
					'wpusername' => $user->username, // required api
				);

				$response = CommonHelper::go_call_request($req_arr);
				$responsejson = json_decode($response->getBody());
				Log::info(print_r($responsejson, true));

				$message = $responsejson;

				// Display error of API
				$user->profile->delete();
				$user->delete();
				*/
			}else{
				$user->profile->timezone = $dbTimeZoneId;
				// Save
				$user->profile->save();
				$user->save();

			}
		}
		$resArr = array(
			'status' => $status,
			'message' => $message,
			'response_status' => $response_status,
		);
		return $resArr;
	}

	public function registerFrom(){

		$returnHTML = view('childs.sign_up')->render();
		return ['status' => true,'html' => $returnHTML ]; exit();
	}

	public function socialRedirect($hash_code){

		if(isset($hash_code) && !empty($hash_code)){

			$user = User::withoutGlobalScopes()->where('hash_code', $hash_code)->first();

			if( isset($user) && !empty($user) ){

				if($user->active == 1){
					flash(t("Your account is already activated"))->error();
					return redirect(config('app.locale'));
				}

				$data['uriPath'] = 'finish';
				$data['user'] = $user;
				$data['userTypes'] = UserType::orderBy('id', 'DESC')->get();

				flash(t("register_user_using_social_media :provider", ['provider' => ucfirst($user->provider)]))->success();
				return view('auth.register.inc.social_redirect_page', $data);	


			}else{
				flash(t("This user no longer exists"))->error();
				return redirect(config('app.locale'));
			}

		}else{

			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}
	}
	// register flow page wise ajax call
	public function funnelApiCallAjax(Request $request){

		$pageName = ($request->page) ? $request->page : '';
		$status = ($request->status) ? $request->status : '';
		$username = ($request->username) ? $request->username : '';
		$verification_link = ($request->verification_link) ? $request->verification_link : '';
		// Send 'funnel' action to CRM
		$req_arr = array(
			'action' => 'funnel',
			'page' => $pageName,
			'wpusername' => $username,
			'status' => $status,
			'verification_link' => $verification_link
		);
		
		$response = CommonHelper::go_call_request($req_arr);
		//Log::info('Request Array', ['Request Array funnel' => $req_arr]);
		$json = json_decode($response->getBody());
		//Log::info('Response Array', ['Request Array funnel' => $json]);
		return Response::json(array(
			'success' => true
		));
		exit();
	}

	public function getUnitMeasurementByUser($user){

		$property = [];
		$validValues = ValidValue::all();
		
		foreach ($validValues as $val) {
			
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = !empty($translate->value) ? $translate->value : '';
		}	
		
		$units = new UnitMeasurement($user->country_code);
		
		if(isset($user->profile->category_id) && !empty($user->profile->category_id) ){
            
            $modelCategory = ModelCategory::select('id','translation_of','is_baby_model')->where('id', $user->profile->category_id)->first();
			
			if(isset($modelCategory->is_baby_model)){

                if($modelCategory->is_baby_model == 1){
                    $units->is_child_unit = true;
                }
            }
        }

		if( isset($user->gender_id) && !empty($user->gender_id) ){
            switch ($user->gender_id) {
                case config('constant.gender_male'):
                    $units->is_men_unit = true;
                    $units->is_women_unit = false;
                    break;
                case config('constant.gender_female'):
                    $units->is_women_unit = true;
                    $units->is_men_unit = false;
                    break;
                default:
                    $units->is_men_unit = $units->is_women_unit = false;
            }
        }
		  
		$unitoptions = $units->getUnit(true);

		return $property = array_merge($property, $unitoptions);
	}
	public function updateProfileInfo(Request $request)
	{	
		$rules = [
			'height' => 'required',
			'weight' => 'required',
			'dressSize' => 'required',
			'breast' => 'required',
			// 'waist' => 'required',
			// 'hip' => 'required',
			'shoeSize' => 'required',
			'eyeColor' => 'required',
			'hairColor' => 'required',
			'skinColor' => 'required',
			'piercing' => 'required',
			'tattoo' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			
			return \Redirect::back()->withInput()->withErrors($validator->messages());
		}

	 	$user_id = isset($request->user_id) ? $request->user_id : '';

	 	if(empty($user_id)){
	 		
	 		flash(t("Something went wrong Please try again"))->error();
	 		return redirect()->back();
	 	}
	 	
	 	$user = User::where('id', $user_id)->first();

	 	if(empty($user)){
	 		
	 		flash(t("Something went wrong Please try again"))->error();
	 		return redirect()->back();
	 	}
		
		// if profile first time fill call 'funnel Api' in CRM
		if($user->is_profile_completed == '0'){
	 		
	 		$apiStatus = false;
	 		// Send 'funnel reg_profile' action to CRM
			$reg_profile_arr = array(
				'action' => 'funnel',
				'page' => 'reg_profile',
				'wpusername' => $user->username,
				'status' => true,
				'verification_link' => ''
			);

			$response = CommonHelper::go_call_request($reg_profile_arr);
			//Log::info('Request Array', ['Request Array funnel reg_profile' => $reg_profile_arr]);
			$json = json_decode($response->getBody());
			//Log::info('Response Array', ['Request Array funnel reg_profile' => $json]);

			if ($response->getStatusCode() == 200) {
				
				// Send 'funnel reg_profile_p' action to CRM
				$funnel_arr = array(
					'action' => 'funnel',
					'page' => 'reg_profile_p',
					'wpusername' => $user->username,
					'status' => true,
					'verification_link' => ''
				);

				$response_reg_profile_p = CommonHelper::go_call_request($funnel_arr);
				//Log::info('Request Array', ['Request Array funnel reg_profile_p' => $funnel_arr]);
				$json = json_decode($response_reg_profile_p->getBody());
				//Log::info('Response Array', ['Request Array funnel reg_profile_p' => $json]);
				
				if($response_reg_profile_p->getStatusCode() == 200){

					$apiStatus = true;
				}
			}
			//  if api call fail return back finish page with error message
			if(!$apiStatus){
				
				flash(t("Unknown error, Please try again in a few minutes"))->error();
	 			return redirect()->back();
			}
	 	}
	 	// End code profile first time fill call 'funnel Api' in CRM.

	 	$user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
		$user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
		$user->profile->size_id = $request->input('dressSize') ? $request->input('dressSize') : 0;
		$user->profile->chest_id = $request->input('breast') ? $request->input('breast') : 0;
		$user->profile->waist_id = $request->input('waist') ? $request->input('waist') : 0;
		$user->profile->hips_id = $request->input('hip') ? $request->input('hip') : 0;
		$user->profile->shoes_size_id = $request->input('shoeSize') ? $request->input('shoeSize') : 0;
		$user->profile->eye_color_id = $request->input('eyeColor') ? $request->input('eyeColor') : 0;
		$user->profile->hair_color_id = $request->input('hairColor') ? $request->input('hairColor') : 0;
		$user->profile->skin_color_id = $request->input('skinColor') ? $request->input('skinColor') : 0;
		$user->profile->piercing = $request->input('piercing') ? $request->input('piercing') : 0;
		$user->profile->tattoo = $request->input('tattoo') ? $request->input('tattoo') : 0;
		$user->is_profile_completed = '1';
		$user->save(); 
		$user->profile->save();

	 	flash(t("Your account profile has updated successfully"))->success();
	 	return redirect()->back();
	}

	public function saveUserPhoneAvailable(Request $request){
		
		$saveDataArr = array();
		$status = false;
		$message = t('some error occurred');

		//  check user id
		if(isset($request->user_id) && !empty($request->user_id)){
			
			if(isset($request->from) && isset($request->to) && count($request->from) > 0 && count($request->to) > 0){
				$i = 0;
				
				// format from time and to time
				foreach ($request->from as $key => $value) {
					
					if(!empty($value)){
						
						if(isset($request->to[$key]) && !empty($request->to[$key])){
							$saveDataArr[$i]['from_time'] = $value;
							$saveDataArr[$i]['to_time'] = $request->to[$key];
							$i ++;
					  	}
					}
				}

				if(count($saveDataArr) > 0){

					$availability_time = json_encode($saveDataArr);

					// get current user
					$user = User::where('id', $request->user_id)->first();
					
					if(!empty($user)){

						// Send 'Available time' action to CRM
						$available_phone_arr = array(
							'action' => 'set_available_phone',
							'wpusername' => $user->username,
							'availPhone' => $availability_time,
						);
						
						$response = CommonHelper::go_call_request($available_phone_arr);
						Log::info('Request Array', ['Request Array set_available_phone' => $available_phone_arr]);
						$json = json_decode($response->getBody());
						Log::info('Response Array', ['Request Array set_available_phone' => $json]);

						$status = true;
						// save available time
					    $user->profile->availability_time = $availability_time;
					    $user->profile->save();
					}
				}
				
				$message = t("Your account profile has updated successfully");
			}
		}
		return Response::json(array( 'status' => $status, 'message' => $message )); exit();
	}

	protected function needToCheckWithKickbox($email) {
		$restrictedArray = array("@gmx.");
		$result = false;
		foreach($restrictedArray as $value) {
			$pos = strpos($email, $value);
			if ($pos === false) {
				$result = false;
			}else{
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Kickbox email verification
	 */
	protected function kickboxEmailVerify($email) {

		$kickboxApiKey = '';
		switch (config('app.env')) {
			case 'live':
				$kickboxApiKey = config('app.kickbox_api_key_live');
				break;
			case 'staging':
				$kickboxApiKey = config('app.kickbox_api_key_staging');
				break;
		}
		$kickboxTimeout = config('app.kickbox_api_timeout');

		$kickboxClient = new KickboxClient($kickboxApiKey);
		$kickbox = $kickboxClient->kickbox();

		$verifyResult = array();
		$verifyResult['service'] = 'kickbox';
		try {
			$kickboxResponse = $kickbox->verify($email, array('timeout' => $kickboxTimeout));
			$verifyResult['result'] = $kickboxResponse->body['result'];
			$verifyResult['reason'] = $kickboxResponse->body['reason'];

			// If Kickbox email verify result is "deliverable" or "risky", return 'success' => true
			// If Kickbox email verify result is "unknown" and reason is "timeout", return 'success'=> true
			if (in_array($verifyResult['result'], array('deliverable', 'risky')) || ($verifyResult['result'] == 'unknown' && $verifyResult['reason'] == 'timeout'))
			{
				$verifyResult['success'] = true;
				if ($verifyResult['result'] == 'unknown' && $verifyResult['reason'] == 'timeout') {
					$output = shell_exec('sh ' . __DIR__ . '/mattermost.sh ALERTS-Server Kickbox-Verify-Timeout "Kickbox email verification for ' . $email . ' is timeout."');
				}

			} else {
				$verifyResult['success'] = false;
				$output = shell_exec('sh ' . __DIR__ . '/mattermost.sh ALERTS-Server Kickbox-Verify-Failed "Kickbox email verification for ' . $email . ' is failed. \n Result:' . $verifyResult['result'] . '\n Reason:' . $verifyResult['reason'] . '"');
			}
		} catch (Exception $e) {
			// echo "Code: " . $e->getCode() . " Message: " . $e->getMessage();
		}
		return $verifyResult;
	}

	/**
	 * Zerobounce Email Verification
	 */
	protected function zerobounceEmailVerify($email) {
		$zerobounceApiKey = '';
		switch (config('app.env')) {
			case 'live':
				$zerobounceApiKey = config('app.zerobounce_api_key_live');
				break;
			case 'staging':
				$zerobounceApiKey = config('app.zerobounce_api_key_staging');
				break;
		}

		$zerobounceTimeout = config('app.zerobounce_api_timeout');

		$zerobounceHandler = new ZeroBounce($zerobounceApiKey, $zerobounceTimeout);
		$emailObject = new Email($email);

		$verifyResult = array();
		$verifyResult['service'] = 'zerobounce';
		$verifyResult['success'] = false;
		
		try {
			$result = $zerobounceHandler->validateEmail($emailObject);
			
			$verifyResult['result'] = $result->getStatus();
			$verifyResult['reason'] = $result->getSubStatus();
			
			if ($result->getStatus() === Result::STATUS_VALID) {

				// Valid email.
				$verifyResult['success'] = true;
				
			} else if ($result->getStatus() === Result::STATUS_DO_NOT_MAIL) {

				// The substatus code will help you determine the exact issue:
				switch ($result->getSubStatus()) {
		
					case Result::SUBSTATUS_GLOBAL_SUPPRESSION:
					case Result::SUBSTATUS_DISPOSABLE:
					case Result::SUBSTATUS_TOXIC:
						// Toxic or disposable.
						$verifyResult['success'] = false;
						break;
					case Result::SUBSTATUS_POSSIBLE_TRAP:
					case Result::SUBSTATUS_ROLE_BASED:
					case Result::SUBSTATUS_ROLE_BASED_CATCH_ALL:
						// admin@, helpdesk@, info@ etc; not a personal email
						$verifyResult['success'] = true;
						break;
					// ... and so on.
				}
		
			} else if ($result->getStatus() === Result::STATUS_INVALID) {
		
				// Invalid email.
				$verifyResult['success'] = false;
		
			} else if ($result->getStatus() === Result::STATUS_SPAMTRAP) {
		
				// Spam-trap.
				$verifyResult['success'] = false;
		
			} else if ($result->getStatus() === Result::STATUS_ABUSE) {
		
				// Abuse.
				$verifyResult['success'] = true;
		
			} else if ($result->getStatus() === Result::STATUS_CATCH_ALL) {
		
				// Address is catch-all; not necessarily a private email.
				$verifyResult['success'] = true;
		
			} else if ($result->getStatus() === Result::STATUS_UNKNOWN) {
		
				// Unknown email status.
				switch ($result->getSubStatus()) {
		
					case Result::SUBSTATUS_ANTISPAM_SYSTEM:
					case Result::SUBSTATUS_EXCEPTION_OCCURRED:
					case Result::SUBSTATUS_FAILED_SMTP_CONNECTION:
					case Result::SUBSTATUS_FAILED_SYNTAX_CHECK:
					case Result::SUBSTATUS_FORCIBLE_DISCONNECT:
					case Result::SUBSTATUS_MAIL_SERVER_DID_NOT_RESPOND:
					case Result::SUBSTATUS_MAIL_SERVER_TEMPORARY_ERROR:
						$verifyResult['success'] = false;
						break;
					case Result::SUBSTATUS_GREYLISTED:
					case Result::SUBSTATUS_TIMEOUT_EXCEEDED:
						$verifyResult['success'] = true;
						break;
				}
			} else {
				$verifyResult['success'] = false;
			}

			$verifyResult['result'] = $result->getStatus();
			$verifyResult['reason'] = $result->getSubStatus();

			if ($verifyResult['success'] == false) {
				$output = shell_exec('sh ' . __DIR__ . '/mattermost.sh ALERTS-Server Zerobounce-Verify-Failed "Zerobounce email verification for ' . $email . ' is failed. \n Result:' . $verifyResult['result'] . '\n Reason:' . $verifyResult['reason'] . '"');
			}

		} catch (APIError  $th) {
			//throw $th;
		}

		return $verifyResult;
	}
}



