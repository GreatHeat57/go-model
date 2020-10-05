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
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Payment as PaymentHelper;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Post\Traits\PaymentTrait;
use App\Http\Requests\PackageRequest;
use App\Models\Gender;
use App\Models\Package;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Scopes\FromActivatedCategoryScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Validator;
use App;
use Response;
use App\Models\TimeZone;
use Stripe\Charge;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\Source;
use Stripe\Stripe;
use App\Models\States;
use App\Models\paymentLog;
use App\Plugins\stripecard\app\Mail\PaymentNotification;
use Stripe\Customer;
use App\Models\StripeUserDetails;
use Illuminate\Support\Facades\Auth;

class ContractController extends FrontController {
	use PaymentTrait;

	public $request;
	public $data;
	public $msg = [];
	public $uri = [];
	public $packages;
	public $paymentMethods;

	/**
	 * @var array
	 */

	/**
	 * ContractController constructor.
	 */
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
			$this->request = $request;
			$this->commonQueries();

			return $next($request);
		});

		view()->share('is_footer_showing', false);

		view()->share('hide_header', true);
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		// Messages
		if (getSegment(2) == 'create') {
			$this->msg['post']['success'] = '';
		} else {
			$this->msg['post']['success'] = '';
		}
		$this->msg['checkout']['success'] = t("We have received your payment");
		$this->msg['checkout']['cancel'] = t("We have not received your payment, Payment cancelled");
		$this->msg['checkout']['error'] = t("We have not received your payment, An error occurred");

		// Set URLs
		if (getSegment(2) == 'create') {
			$this->uri['previousUrl'] = config('app.locale') . '/contract/create/#entryToken/payPackages';
			$this->uri['nextUrl'] = config('app.locale') . '/contract/create/#entryToken/#postId/finish';
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/contract/create/#entryToken/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/contract/create/#entryToken/payment/success');
			$this->uri['paymentCheckUrl'] = url(config('app.locale') . '/contract/create/#entryToken/payment/check');
		} else {
			$this->uri['previousUrl'] = config('app.locale') . '/contract/#entryId/packages';
			// $this->uri['nextUrl'] = config('app.locale') . '/' . trans('routes.v-post', ['slug' => '#title', 'id' => '#entryId']);
			$this->uri['nextUrl'] = config('app.locale') . '/contract/#entryToken/#postId/finish';
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/contract/#entryId/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/contract/#entryId/payment/success');
			$this->uri['paymentCheckUrl'] = url(config('app.locale') . '/contract/#entryId/payment/check');
		}

		// Payment Helper init.
		PaymentHelper::$country = collect(config('country'));
		PaymentHelper::$lang = collect(config('lang'));
		PaymentHelper::$msg = $this->msg;
		PaymentHelper::$uri = $this->uri;

		// Get Packages
		// $this->packages = Package::where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		$this->packages = Package::where('user_type_id', 3)->where('country_code', config("country.code"))->applyCurrency()->with('currency')->orderBy('lft')->get();
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

	}

	/**
	 * Show the form the create a new user account.
	 *
	 * @return View
	 */

	public function redirectLink($locale = 'en', Request $request) {
		// Log::info('checkcontract', ['In condition redirect' => 'redirect']);

		if(!in_array($localeCode, config('lang.supportedLanguage'))){
			
			$CountryLanguage = \App\Models\CountryLanguage::where('wp_language', $locale)->first();
			
			if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
				
				App::setLocale($CountryLanguage->language_code);
			}
			
			$code = $request->input('code');
			$id = $request->input('id');
			$subid = $request->input('subid');
			// $query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '&subid=' . $subid;
			$query = '?code=' . $code . '&d='. strtoupper($locale) .'&id=' . $id . '&subid=' . $subid;
			
			return redirect($CountryLanguage->language_code . '/contract' . $query);
		}


		// if(in_array($locale, ['en', 'de'])){
		// 	$code = $request->input('code');
		// 	$id = $request->input('id');
		// 	$subid = $request->input('subid');
		// 	$locale = strtoupper($locale);
		// 	// $query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '$subid=' . $subid;
		// 	$query = '?code=' . $code . '&d='. $locale .'&id=' . $id . '$subid=' . $subid;

		// 	return redirect(config('app.locale') . '/contract' . $query);
		// }else{
		// 	$CountryLanguage = \App\Models\CountryLanguage::where('wp_language', $locale)->first();
		// 	if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
		// 		// App::set('app.locale', $CountryLanguage->language_code);
		// 		App::setLocale($CountryLanguage->language_code);
		// 	}
		// 	$code = $request->input('code');
		// 	$id = $request->input('id');
		// 	$subid = $request->input('subid');
		// 	$query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '$subid=' . $subid;
		// 	return redirect($CountryLanguage->language_code . '/contract' . $query);
		// }

		// if (in_array($locale, ['at', 'ch', 'li'])) { // add all language code here 
		// 	//get matchign locale from laravel db
		// 	$CountryLanguage = \App\Models\CountryLanguage::where('wp_language', $locale)->first();
		// 	if(isset($CountryLanguage) && !empty($CountryLanguage->language_code)){
		// 		Config::set('app.locale', $CountryLanguage->language_code);
		// 	}
		// 	$code = $request->input('code');
		// 	$id = $request->input('id');
		// 	$subid = $request->input('subid');
		// 	$query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '$subid=' . $subid;
		// 	return redirect($CountryLanguage->language_code . '/contract/create' . $query);
			
		// } else {
		// 	//echo 'Something went wrong';
		// 	$code = $request->input('code');
		// 	$id = $request->input('id');
		// 	$subid = $request->input('subid');
		// 	$locale = strtoupper($locale);
		// 	$query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '$subid=' . $subid;

		// 	return redirect(config('app.locale') . '/contract' . $query);
		// }
	}

	/*
	* first step of contract page to sign contract
	* displays contract page
	* redirects to payment page if already contract
	* redirects to home page if already paid
	*/
	public function showProfileForm($localeCode = 'en', Request $request) {

		\Log::info("============here in showProfileForm===================", ['inside' => 'showProfileForm']);

		//logout the user before send to the contract page
		if(\Auth::check()){
			\Auth::logout();
		}

		$is_old_Contract_link = true;
		if(isset($request->code)){
			$country 	= 	isset($request->d)? $request->d : '';
			$slug 		= 	isset($request->code)? $request->code : '';
			$renew 		= 	isset($request->renew)? $request->renew : '';
			$subid 		= 	isset($request->subid)? $request->subid : '';
			// id is username.
			$id 		= 	isset($request->id)? $request->id : '';
			$upgrade 	= 	isset($request->upgrade)? $request->upgrade : '';

		}else{
			$is_old_Contract_link = false;
			$fullUrl = $request->fullUrl();
			$query_str = parse_url($fullUrl, PHP_URL_QUERY); 
			// call decrypt url functions
			$url_res = CommonHelper::dec_enc('decrypt', $query_str);
			if(empty($url_res)){ 
				flash(t("Unknown error, Please try again in a few minutes"))->error(); 
				return redirect(config('app.locale')); 
			}
			// url string to Array convert
			parse_str($url_res, $query_params); 
			if(empty($query_params)){ 
				flash(t("Unknown error, Please try again in a few minutes"))->error(); 
				return redirect(config('app.locale')); 
			} 
			
			$country 	= 	isset($query_params['d'])? $query_params['d'] : '';
			$slug 		= 	isset($query_params['code'])? $query_params['code'] : '';
			$renew 		= 	isset($query_params['renew'])? $query_params['renew'] : '';
			$subid 		= 	isset($query_params['subid'])? $query_params['subid'] : '';
			// id is username.
			$id 		= 	isset($query_params['id'])? $query_params['id'] : '';
			$upgrade 		= 	isset($query_params['upgrade'])? $query_params['upgrade'] : '';
		}

		$contractLinkArr['country'] 	=  $country;
		$contractLinkArr['slug'] 	=  $slug;
		$contractLinkArr['renew'] 	=  $renew;
		$contractLinkArr['subid'] 	=  $subid;
		$contractLinkArr['upgrade'] 	=  $upgrade;
		
		// set session contract link old or new
		Session::put('is_old_Contract_link', $is_old_Contract_link);
		
		if(!in_array($localeCode, config('lang.supportedLanguage'))){

			// Log::info('checkcontract', ['In condition 1' => '1']);
			$CountryLanguage = \App\Models\CountryLanguage::where('wp_language', $localeCode)->first();
			$redirectLocale = 'en';
			if(isset($CountryLanguage) && !empty($CountryLanguage) && isset($CountryLanguage->language_code)){
				$redirectLocale = $CountryLanguage->language_code;
			}
			App::setLocale($redirectLocale);
			// $code = $request->input('code');
			// $id = $request->input('id');
			// $subid = $request->input('subid');

			// $renew = !empty($request->get('renew')) ? $request->get('renew') : '';

			// $query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '&subid=' . $subid;
			$query = 'code='.$slug.'&d='.strtoupper($localeCode).'&id='.$id.'&subid='.$subid;
			
			if(!empty($renew)){
				$query .= '&renew=1';
				Session::put('is_renew', 1);
			}
			
			if($is_old_Contract_link == true){
				return redirect($redirectLocale . '/contract/?' . $query);
			}else{
				// call encrypt url functions
				$url_res = CommonHelper::dec_enc('encrypt', $query);
				return redirect($redirectLocale.'/contract/?'.$url_res);
			}
		}
		elseif($localeCode == "en") {
			App::setLocale('en');
		}
		elseif($localeCode == "de") {
			App::setLocale('de');
		}else{

			if(in_array($localeCode, config('lang.supportedLanguage')) ){
				App::setLocale(strtolower($localeCode));
			}
		}

		$user = "";
		if (isset($slug) && !empty($slug)) {
			$user = User::getUserBySlug($slug);
		}

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}

		//redirect if user is blocked
		if (isset($user) && $user->blocked == 1) {
			flash(t("user_account_suspened"))->error();
			return redirect(config('app.locale'));
		}

		//if country not set in url or country is not from default country list
		// $country = $request->input('d');
		$default_countries = \App\Models\Country::pluck('code')->toArray();

		if(($country == "" || !in_array($country, $default_countries))  && $localeCode == "en"){
			$country = "UK";
		}
		else if(($country == "" || !in_array($country, $default_countries)) && $localeCode == "de"){
			$country = "AT";
		}
		
		$user = "";
		if (isset($slug) && !empty($slug)) { $user = User::getUserBySlug($slug); }
		
		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}


		//redirect if user is blocked
		if (isset($user) && $user->blocked == 1) {
			flash(t("user_account_suspened"))->error();
			return redirect(config('app.locale'));
		}

		$is_free_country = false;
		if(isset($user->country->country_type) && $user->country->country_type == config('constant.country_free') ){
			$is_free_country = true;
		}

		// if empty user latitude and longitude empty crm update lat long
		if(empty($user->latitude) && empty($user->longitude)){
			
			$googleurl 		= config('app.g_latlong_url');
			$google_api_key_maps 		= config('app.latlong_api');
			$cityname 		= isset($user->profile->city)? $user->profile->city : '';
			$fullCityName 	= isset($user->profile->city)? $user->profile->city : '';
			$country_name 	= isset($user->country->asciiname)? $user->country->asciiname : '';
			$geo_state 		= isset($user->profile->geo_state)? $user->profile->geo_state : '';

			if(isset($cityname) && !empty($cityname)){
				$cityname = explode(',', $cityname);
				$cityname = ( count($cityname) > 0 && isset($cityname[0]) )? $cityname[0] : $req['city'];
			}
			$address  = $user->profile->street.", ".$user->profile->zip.', '.$cityname.', '.$geo_state.', '.$country_name;
			$address 		= urlencode ($address);
			$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$user->country_code.'&key='.$google_api_key_maps;
			// call get latitude longitude 
			$longlat = CommonHelper::getLatLong($url);
			// if invalid street and zip code, get latlong full city name
			if(empty($longlat)){
				$address = $user->profile->city;
				if(!empty($address)){
					$address = urlencode ($address);
					$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$user->country_code.'&key='.$google_api_key_maps;
					// call get latlong
					$longlat = CommonHelper::getLatLong($url);
				}
			}

 			if(!empty($longlat)){

 				$geo_lat    =  isset($longlat['latitude'])? strval($longlat['latitude']) : '';
		        $geo_long   =  isset($longlat['longitude'])? strval($longlat['longitude']) : '';
		        $geo_city   =  isset($longlat['geo_city'])? $longlat['geo_city'] : $cityname;
		        $geo_state  =  isset($longlat['geo_state'])? $longlat['geo_state'] : $geo_state;
		        $geo_country = isset($longlat['geo_country'])? $longlat['geo_country'] : $country_name;
		        $geo_full = $user->profile->street.", ".$user->profile->zip.', '.$geo_city;
				
				$req_arr = array(
					'action' => 'update', //required
					'wpusername' => $user->username, // required api
				 	'latitude' =>  $geo_lat,
					'longitude' => $geo_long,
					'geo_lat' => $geo_lat,
					'geo_long' => $geo_long,
					'geo_city' => $geo_city,
					'geo_state' => $geo_state,
					'geo_country' => $geo_country,
					'geo_full' => $geo_full,
				);
				
				$response = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array update', ['Request Array' => $req_arr]);
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array update' => $json]);

				$user->latitude = $geo_lat;
				$user->longitude = $geo_long;
				$user->profile->geo_state = $geo_state;
				$user->save();
				$user->profile->save();
 			}
 		}

 		//check s=user from free country and register user thype is free
		// $is_user_free_country = false;
		// if(isset($user->user_register_type) && $user->user_register_type == config('constant.user_type_free') &&  isset($user->country->country_type) && $user->country->country_type == config('constant.country_free') ){
		// 	$is_user_free_country = true;
		// }

		// if user country type is free then is_premium_couyntry is false
		$is_premium_country = true;
		if(isset($user->country->country_type) && $user->country->country_type == config('constant.country_free') ){
			$is_premium_country = false;
		}

		$checkPayment  = '';
		// Get post
		$checkPost = Post::withoutGlobalScopes()->where('user_id', $user->id)->where('package' , '!=' , '')->where('package' , '>' , 0)->orderBy('id', 'desc')->first();
		
		/*
		* user type model
		* free country
		* call create_sub, activate, generate pw
		* user registration type free and subscription type free
		*/
		if($is_premium_country == false && $user->user_type_id == config('constant.model_type_id') && !in_array($user->provider, ['google','facebook'])){
			
			//check if already active contract - if opening contract link again
			if($user->subscribed_payment == 'complete'){
				// show success message
				$nextUrl = config('app.locale') . '/';
				flash(t("sign_contract_link"))->success();
				return redirect($nextUrl);
			}
			else{
				//call create_sub, activate, generate pw
				// $res = $this->callFreeCountryCrmApi($user, $contractLinkArr, $request);
				// if($res == true){
				
				// 	flash(t("You already made signed this contract"))->success();
				// }else{
				// 	flash(t("Unknown error, Please try again in a few minutes"))->error();
				// }
				// $nextUrl = config('app.locale') . '/';
				// return redirect($nextUrl);
			}	
		}
		/*
		* User type partner
		* Free country or premium country
		*/
		else if($user->user_type_id == config('constant.partner_type_id')){

			//check if already active contract - if opening contract link again
			if($user->subscribed_payment == 'complete'){
				// show success message
				$nextUrl = config('app.locale') . '/';
				flash(t("sign_contract_link"))->success();
				return redirect($nextUrl);
			}
			else{

				if(!in_array($user->provider, ['google','facebook'])){
					// activate partner
					//call create_sub, activate, generate pw
					$res = $this->callFreeCountryCrmApi($user, $contractLinkArr, $request);

					if($res == true){
						$data['is_premium_country'] = $is_premium_country;
						flash(t("You already made signed this contract"))->success();
						return view('contract.free_finish', $data);
						// return redirect($nextUrl);
					}else{
						flash(t("Unknown error, Please try again in a few minutes"))->error();
					}
					$nextUrl = config('app.locale') . '/';
					return redirect($nextUrl);						
				}else{
					// update social user if he/she is a partner and active account
					$user->active = 1;
					$user->is_register_complated = 1;
					$user->subscribed_payment = 'complete';
					$user->subscription_type = 'free';
					// $user->profile->status = 'ACTIVE';
					$user->profile->save();
					$user->save();
					$nextUrl = config('app.locale') . '/';
					flash(t("You already made signed this contract"))->success();
					return redirect($nextUrl);
				}
			}
		}
		/*
		* check user type model
		* check user registration type premium
		* check premium country
		* check new payment or renew contract
		*/
		else if($is_premium_country == true && $user->user_type_id == config('constant.model_type_id') && ($user->user_register_type == config('constant.user_type_premium') || (isset($checkPost) && $checkPost->subscription_type == 'paid') )){
			// if first time payment for renew
			if ($renew == 1) {

				// if URL not has transactionId, call API to get CRM transactionId
				$req_arr = array(
					'action' => 'renew_transaction_get_payment_details', //required
					'wpusername' => $user->username, // required
				);

				// call to CRM api get renew transaction id
				$response = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array renew_transaction_get_payment_details', ['Request Array' => $req_arr]);
				$transactionDetails = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array renew_transaction_get_payment_details' => $transactionDetails]);

				if($response->getStatusCode() == 200){
					if(isset($transactionDetails->id)){
						// Check already paid, redirect back with success message
						if($transactionDetails->paid_status == 1){
							// redirect to home 
							flash(t("You already have active contract with go-models"))->success();
							return redirect(config('app.locale'));
						}
						$crm_transaction_id = $transactionDetails->id;
					}else{
						// error
						flash(t("Unknown error, Please try again in a few minutes"))->error();
						return redirect(config('app.locale'));
					}
				}else{
					// error
					flash(t("Unknown error, Please try again in a few minutes"))->error();
					return redirect(config('app.locale'));
				}
				// if exist than select post record from database
				$getPostByCrmTransactionId = Post::withoutGlobalScopes()->where('crm_transaction_id', $crm_transaction_id)->orderBy('id', 'desc')->first();

				if(empty($getPostByCrmTransactionId)){
					// if not exist than create new post
					$tmp_token = md5(microtime() . mt_rand(100000, 999999));
					// Post Data
					$postInfo = [
						'country_code' => $user->country_code,
						'user_id' => $user->id,
						'category_id' => 0,
						'title' => '',
						'description' => '',
						'contact_name' => '',
						'city_id' => 0,
						'email' => $user->email,
						'tmp_token'	=> $tmp_token,
						'code_token' => md5($slug),
						'verified_email' => 1,
						'verified_phone' => 1,
						'username' => $checkPost->username,
						'package' => $checkPost->package,
						'subid' => $checkPost->subid,
						'code_without_md5' => $slug,
						'currency_code' => $checkPost->currency_code,
						'crm_transaction_id' => $crm_transaction_id,
						'subscription_type' => 'paid',
					];
					$post = new Post($postInfo);
					$post->save();
				}else{
					$post = $getPostByCrmTransactionId;
				}
				$checkPost = $post;

				// Call CRM API update transaction id
				$req_arr = array(
					'action' => 'update_renew_contract_transaction_id', //required
					'wpusername' => ($user->username) ? $user->username : '', // required
					'transactionid' =>  $post->id,
					'crm_transaction_id' => $post->crm_transaction_id,
				);
						
				$response = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array update_renew_contract_transaction_id', ['Request Array' => $req_arr]);
				$body = (string) $response->getBody();
				Log::info('Response Array update_renew_contract_transaction_id', ['Response Array' => $body]);
				
				if ($response->getStatusCode() == 200) {
					if($body != true){

						flash(t("Some issue found while create contract, Please contact administrator"))->error();
						return redirect(config('app.locale'));
					}
				}else{

					flash(t("Some issue found while create contract, Please contact administrator"))->error();
					return redirect(config('app.locale'));
				}
			}

			// get payment
			if(!empty($checkPost) && isset($checkPost->id)){
				$checkPayment = \DB::table('payments')->where('post_id', $checkPost->id)->orderBy('id', 'desc')->first();
			}
			
			if((!empty($checkPost) && empty($checkPayment)) || (!empty($checkPayment) && $checkPayment->transaction_status == 'cancelled')){

				// Log::info('checkcontract', ['In condition 2' => '2']);
				$tmp_token = md5(microtime() . mt_rand(100000, 999999));
				$checkPost->tmp_token = $tmp_token;
				$checkPost->save();
				session(['tmpPostId' => $checkPost->id]);
				// url string
				$string = 'code='.$slug.'&d='.$user->country_code.'&id='.$checkPost->username.'&subid='.$checkPost->subid.'&package='.$checkPost->package.'&pid='.$checkPost->id;

				// check contract is renew, added renew 1 in contract url
				if($renew == 1){
					$string .='&renew=1';
				}
				
				// check contract link new or old
				if($is_old_Contract_link == true){
					return redirect(config('app.locale').'/contract/'.$tmp_token.'/packages/?'.$string);
				}else{
					// call encrypt url functions
					$url_res = CommonHelper::dec_enc('encrypt', $string);
					return redirect(config('app.locale').'/contract/'.$tmp_token.'/packages/?'.$url_res);
				}
			}
			
			//check if payment method is sepa then redirect to home page
			else if (!empty($checkPayment) && ($checkPayment->payment_method_id == 5 || $checkPayment->gateway == 'sepa') && $checkPayment->transaction_status === 'pending') {
				
				if ($renew == 1 && $checkPayment->payment_method_id == 5) {
					flash(t("You have selected offline payment"))->success();
				}else if($checkPayment->payment_method_id == 5){
					flash(t("offline_payment_selected"))->success();
				}
				else if($checkPayment->gateway == 'sepa'){
					flash(t("your payment request is under processing"))->success();
				}
				return redirect(config('app.locale') . '/');
			}

			//check user type is model the check the contract subscription status paid and payment completed
			else if ($user->subscribed_payment == 'complete' && $user->subscription_type == 'paid') {
				$nextUrl = config('app.locale') . '/';
				flash(t("sign_contract_link"))->success();
				return redirect($nextUrl);
			}
		}

		/* comment old code AJ #15/07/2020

		// $checkPaymentStatus  = false;
		$checkPayment  = '';
		// Get post
		$checkPost = Post::withoutGlobalScopes()->where('user_id', $user->id)->where('package' , '!=' , '')->where('package' , '>' , 0)->orderBy('id', 'desc')->first();
 		
 		// if first time payment for renew
		if ($renew == 1) {

			// if URL not has transactionId, call API to get CRM transactionId
			$req_arr = array(
				'action' => 'renew_transaction_get_payment_details', //required
				'wpusername' => $user->username, // required
			);

			// call to CRM api get renew transaction id
			$response = CommonHelper::go_call_request($req_arr);
			Log::info('Request Array renew_transaction_get_payment_details', ['Request Array' => $req_arr]);
			$transactionDetails = json_decode($response->getBody());
			Log::info('Response Array', ['Response Array renew_transaction_get_payment_details' => $transactionDetails]);

			if($response->getStatusCode() == 200){
				if(isset($transactionDetails->id)){
					// Check already paid, redirect back with success message
					if($transactionDetails->paid_status == 1){
						// redirect to home 
						flash(t("You already have active contract with go-models"))->success();
						return redirect(config('app.locale'));
					}
					$crm_transaction_id = $transactionDetails->id;
				}else{
					// error
					flash(t("Unknown error, Please try again in a few minutes"))->error();
					return redirect(config('app.locale'));
				}
			}else{
				// error
				flash(t("Unknown error, Please try again in a few minutes"))->error();
				return redirect(config('app.locale'));
			}
			// if exist than select post record from database
			$getPostByCrmTransactionId = Post::withoutGlobalScopes()->where('crm_transaction_id', $crm_transaction_id)->orderBy('id', 'desc')->first();

			if(empty($getPostByCrmTransactionId)){
				// if not exist than create new post
				$tmp_token = md5(microtime() . mt_rand(100000, 999999));
				// Post Data
				$postInfo = [
					'country_code' => $user->country_code,
					'user_id' => $user->id,
					'category_id' => 0,
					'title' => '',
					'description' => '',
					'contact_name' => '',
					'city_id' => 0,
					'email' => $user->email,
					'tmp_token'	=> $tmp_token,
					'code_token' => md5($slug),
					'verified_email' => 1,
					'verified_phone' => 1,
					'username' => $checkPost->username,
					'package' => $checkPost->package,
					'subid' => $checkPost->subid,
					'code_without_md5' => $slug,
					'currency_code' => $checkPost->currency_code,
					'crm_transaction_id' => $crm_transaction_id
				];
				$post = new Post($postInfo);
				$post->save();
			}else{
				$post = $getPostByCrmTransactionId;
			}
			$checkPost = $post;

			// Call CRM API update transaction id
			$req_arr = array(
				'action' => 'update_renew_contract_transaction_id', //required
				'wpusername' => ($user->username) ? $user->username : '', // required
				'transactionid' =>  $post->id,
				'crm_transaction_id' => $post->crm_transaction_id,
			);
					
			$response = CommonHelper::go_call_request($req_arr);
			Log::info('Request Array update_renew_contract_transaction_id', ['Request Array' => $req_arr]);
			$body = (string) $response->getBody();
			Log::info('Response Array update_renew_contract_transaction_id', ['Response Array' => $body]);
			
			if ($response->getStatusCode() == 200) {
				if($body != true){

					flash(t("Some issue found while create contract, Please contact administrator"))->error();
					return redirect(config('app.locale'));
				}
			}else{

				flash(t("Some issue found while create contract, Please contact administrator"))->error();
				return redirect(config('app.locale'));
			}
		}



		// get payment
		if(!empty($checkPost) && isset($checkPost->id)){
			$checkPayment = \DB::table('payments')->where('post_id', $checkPost->id)->orderBy('id', 'desc')->first();
		}
		
		if((!empty($checkPost) && empty($checkPayment)) && $is_premium_country == true && $user->user_register_type == config('constant.user_type_premium') || (!empty($checkPayment) && $checkPayment->transaction_status == 'cancelled')){

			// Log::info('checkcontract', ['In condition 2' => '2']);
			$tmp_token = md5(microtime() . mt_rand(100000, 999999));
			$checkPost->tmp_token = $tmp_token;
			$checkPost->save();
			session(['tmpPostId' => $checkPost->id]);
			// url string

			$string = 'code='.$slug.'&d='.$user->country_code.'&id='.$checkPost->username.'&subid='.$checkPost->subid.'&package='.$checkPost->package.'&pid='.$checkPost->id;

			// check contract is renew, added renew 1 in contract url
			if($renew == 1){
				$string .='&renew=1';
			}

			
			// check contract link new or old
			if($is_old_Contract_link == true){
				return redirect(config('app.locale').'/contract/'.$tmp_token.'/packages/?'.$string);
			}else{
				// call encrypt url functions
				$url_res = CommonHelper::dec_enc('encrypt', $string);
				return redirect(config('app.locale').'/contract/'.$tmp_token.'/packages/?'.$url_res);
			}
			
			// return redirect(config('app.locale') . '/contract/' . $tmp_token . '/packages?' .'&code=' . $slug . '&d='. $user->country_code .'&id=' . $checkPost->username . '&subid=' . $checkPost->subid . '&package=' . $checkPost->package);
		}

		//check if payment method is sepa then redirect to home page
		else if (!empty($checkPayment) && ($checkPayment->payment_method_id == 5 || $checkPayment->gateway == 'sepa') && $checkPayment->transaction_status === 'pending') {
			if ($renew == 1 && $checkPayment->payment_method_id == 5) {
				flash(t("You have selected offline payment"))->success();
			}else if($checkPayment->payment_method_id == 5){
				flash(t("offline_payment_selected"))->success();
			}
			else if($checkPayment->gateway == 'sepa'){
				flash(t("your payment request is under processing"))->success();
			}
			return redirect(config('app.locale') . '/');
		}

		
		// check if user type is partner and password is null and not social user
		if ( ($user->user_type_id == config('constant.partner_type_id') || ($user->user_type_id == config('constant.model_type_id') && $is_user_free_country == true) ) && $user->password == null && (!in_array($user->provider, ['google','facebook']) ) ) {

			$usertype = 'client';
			$is_api_call_true = true;
			if($user->user_type_id == config('constant.model_type_id') && $is_user_free_country == true ){
				$usertype = 'model';
				$is_api_call_true = false;
			}

			// CRM api failed send email details
			$crmApiFailedArr = [
				'gocode' => isset($user->profile->go_code) ? $user->profile->go_code : '',
                'username' => isset($user->username) ? $user->username : '',
                'email' => isset($user->email) ? $user->email: '',
                'subject' => t('Payment process error'),
                'message' => t('Some error occurred while processing payment please find below details'),
            ];

			$package = Package::where('price', 0.00)->where('user_type_id', $user->user_type_id)->where('country_code', $user->country->code)->applyCurrency()->with('currency')->orderBy(
				'lft')->first();
			
			if($user->user_type_id == config('constant.model_type_id') && !empty($package)){
				
				$postInfo = [
					'country_code' => config('country.code'),
					'user_id' => $user->id,
					'category_id' => 0,
					'title' => '',
					'description' => '',
					'contact_name' => '',
					'city_id' => 0,
					'email' => $user->email,
					'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
					'code_token' => md5($slug),
					'verified_email' => 1,
					'verified_phone' => 1,
					'username' => $user->username,
					'package' => $package->id,
					'subid' => $subid,
					'code_without_md5' => $slug,
					'currency_code' => ''
				];


				$post = new Post($postInfo);
				$post->save();
				if($post->id){
					$is_api_call_true = true;
				}
			}
			$is_contract_success = false;
			if ($is_api_call_true == true){

				$user_post_id = '';
				$user_currency_code = 'free for partner';
				$description = 'free for partner';
				$user_sub_id = '_access_free';
				
				if($user->user_type_id == config('constant.model_type_id')){
					$user_post_id = $post->id;
					$user_currency_code = isset($package->currency_code) ? $package->currency_code : '';
					$description = isset($package->name) ? $package->name : '';
					$user_sub_id = $subid;
				}


				// get user client ip
				$id_address = \Request::getClientIp(true);
				// Start call api for create subscription
				$req_arr = array(
					'action' => 'create_sub', //required
					'wpusername' => $user->username,
					'transactionid' => $user_post_id,
					'gateway' => ($user->user_type_id == config('constant.model_type_id')) ? '' : 'free for partner',
					'type' => '',
					'currency' => $user_currency_code,
					'description' => $description,
					'uid' => $user_sub_id,
					'rescission' => '',
					'ip' => $id_address,
					'agent' => ($request->header('User-Agent')) ? $request->header('User-Agent') : '',
				);

				Log::info('Request Array create_sub', ['Request Array' => $req_arr]);
				

				try{
					$response = CommonHelper::go_call_request($req_arr);
	            }catch(\Exception $e){
	                \Log::error("============ Error failed create_sub CRM api call ===================");
	                $crmApiFailedArr['messageDetails'] = $e->getMessage();
	                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
	            }
				
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array create_sub' => $json]);
				// End call create subscription api

				if ($response->getStatusCode() == 200) {
					
					// check user is model and have free access then check the payment is completed
					if ( $user->user_type_id == config('constant.model_type_id')) {
						$json = json_decode($response->getBody());
						$crm_transaction_id = intval($json);
						$post->crm_transaction_id = $crm_transaction_id;
						$post->save();
					}

					// Start generate Password api call in crm
					$req_arr = array(
						'action' => 'generate_pw', //required
						'wpusername' => $user->username, // required
						'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
					);
					Log::info('Request Array generate_pw '.$usertype, ['Request Array' => $req_arr]);
					try{
		                $response = CommonHelper::go_call_request($req_arr);
		            }catch(\Exception $e){
		                \Log::error("============ Error failed generate_pw CRM api call ===================");
		                $crmApiFailedArr['messageDetails'] = $e->getMessage();
		                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
		                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
		            }

					$json = json_decode($response->getBody());
					Log::info('Response Array', ['Response Array generate_pw '.$usertype => $response->getBody()]);
					// End code generate password api


					if ($response->getStatusCode() == 200) {
						
						$body = (string) $response->getBody();
						$user->password = bcrypt($body);

						// Start code activate user api call in crm
						$req_arr = array(
							'action' => 'activate', //required
							'wpusername' => $user->username, // required
						);
						Log::info('Request Array activate '.$usertype, ['Request Array' => $req_arr]);
						try{
							$res = CommonHelper::go_call_request($req_arr);
			            }catch(\Exception $e){
			                \Log::error("============ Error failed activate CRM api call ===================");
			                $crmApiFailedArr['messageDetails'] = $e->getMessage();
			                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
			                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			            }
						
						$json = json_decode($response->getBody());
						Log::info('Response Array', ['Response Array activate '.$usertype => $json]);
						if ($res->getStatusCode() == 200) {
							
							$user->active = 1;
							$user->is_register_complated = 1;
							$user->subscribed_payment = 'complete';
							$user->subscription_type = 'free';
							$user->profile->status = 'ACTIVE';
							$user->profile->save();
							$is_contract_success = true;
						}
						$user->save();
					}
					// End code activate user api call in crm
				}
				if($is_contract_success == true){
					
					flash(t("You already made signed this contract"))->success();
				}else{
					flash(t("Unknown error, Please try again in a few minutes"))->error();
				}
				$nextUrl = config('app.locale') . '/';
				return redirect($nextUrl);	
			}
		}
		
		//check user type is model the check the contract subscription status paid and payment completed
		if ( ($user->user_type_id == config('constant.model_type_id') || $user->user_type_id == config('constant.partner_type_id')) && $user->subscribed_payment == 'complete' && $user->subscription_type == 'paid' && $is_premium_country == true) {
			$nextUrl = config('app.locale') . '/';
			flash(t("sign_contract_link"))->success();
			return redirect($nextUrl);
		}


		//check user type is client the check the contract subscription status free and payment completed
		if ( ($user->user_type_id == config('constant.partner_type_id') || $user->user_type_id == config('constant.model_type_id')) && $user->subscribed_payment == 'complete' && $user->subscription_type == 'free' && $is_premium_country == false) {
			$nextUrl = config('app.locale') . '/';
			flash(t("sign_contract_link"))->success();
			return redirect($nextUrl);
		}
		// user register using provider like google or facebook update field and redirect with massage
		if($user->user_type_id === config('constant.partner_type_id') && !empty($user->provider)){
			
			// update social user if he/she is a partner and active account
			$user->active = 1;
			$user->is_register_complated = 1;
			$user->subscribed_payment = 'complete';
			$user->subscription_type = 'free';
			$user->profile->status = 'ACTIVE';
			$user->profile->save();
			$user->save();
			$nextUrl = config('app.locale') . '/';
			flash(t("You already made signed this contract"))->success();
			return redirect($nextUrl);
		}

		if($user->user_type_id === config('constant.partner_type_id')){
			$nextUrl = config('app.locale') . '/';
			flash(t("You already made signed this contract"))->success();
			return redirect($nextUrl);
		}

		*/

	 	$page = '';
		$is_user_premium_country_free_access = false;
		$is_free_access_user = false;
		$show_payment_link = true;
		if(isset($user->country_code) && !empty($user->country_code)){
		 	if($subid == '_access_free' && $user->user_type_id == config('constant.model_type_id')){
		 		$is_user_premium_country_free_access = true;
		 		$is_free_access_user = true;
		 		$show_payment_link = false;
		 		$pageContent = Country::select('id', 'code', 'terms_conditions_free_model as terms_conditions_model')->where('code', $user->country_code)->first();
		 	}else{
		 		$pageContent = Country::select('id', 'code', 'terms_conditions_model')->where('code', $user->country_code)->first();
		 	}
			if($pageContent->count() > 0){
		 		$page = $pageContent->terms_conditions_model;
		 	}
	 	}

		// $page = Page::where('type', 'terms')->where('active', '1')->trans()->first();
		
		// if (empty($page)) {
		// 	abort(404);
		// }
		view()->share('page', $page);

		$contract_content = Page::where('slug', 'contract')->where('active', '1')->trans()->first();
		view()->share('contract_content', $contract_content);

		
		
		//show package based on user's country code

		// $country = config("country.code");
		//remove transaltion of condition from package selection
		if ($subid == '_access_free') {
			// $this->packages = Package::where('price', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('price', 0.00)->where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($subid == '_access') {
			// $this->packages = Package::where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($subid == '_access_both') {
			// $this->packages = Package::where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} else {
			return redirect(config('app.locale') . '/');
		}
		 
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

		$data = [];
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		$data['user'] = $user;
		$data['uriPath'] = 'yourContract';
		$data['code'] = $slug;
		$data['id'] = $id;
		$data['subid'] = $subid;
		$data['genders'] = Gender::trans()->get();
		$data['countPackages'] = count($this->packages);
		$data['is_user_premium_country_free_access'] = $is_user_premium_country_free_access;
		$data['is_free_access_user'] = $is_free_access_user;
		$data['show_payment_link'] = $show_payment_link;
		$data['siteCountryInfo'] = NULL;

		// Log::info('checkcontract', ['In condition contract profile' => 'contract.profile']);
		return view('contract.profile', $data);
	}

	/*
	* call CRM to update contract date
	* when user clicks on obligation button from contract page
	*/
	public function updateConratctDate(Request $request){
		
		$response_status = false;
		$username = ($request->username) ? $request->username :''; 
		$timeStamp =  strtotime(date('Y-m-d H:i:s'));
		$receive_newsletter = $request->receive_newsletter;
		$userId = $request->userId;

		if(!empty($username)){
			
			$req_arr = array(
				'action' => 'update',
				'wpusername' => $username,
				'date_contract' => $timeStamp
			);

			// Not is already rewsletter subscription, added newsletter key in update CRM API calls.
			if($receive_newsletter > 0){
				
				$req_arr['newsletter'] = $receive_newsletter;
			}

			$response = CommonHelper::go_call_request($req_arr);

			Log::info('Request Array update', ['Request Array' => $req_arr]);

			if ($response->getStatusCode() == 200) {
				// Valid response
				$json = json_decode($response->getBody());

				if(isset($json)){

					$response_status = true;
					
					// call newsletter_subscription CRM API calls, if checkbox checked newslatter and not already subscription 
					if($receive_newsletter > 0){

						$req_news = array(
							'action' => 'newsletter_subscription', //required
							'wpusername' => $username, // required api
							'newsletter_value' => $receive_newsletter,
						);
						
						Log::info('Create CRM API for newsletter', ['user_status' => $req_news]);
						$resp_newsletter = CommonHelper::go_call_request($req_news);

						if ($resp_newsletter->getStatusCode() == 200) {
							
							$json_newslatter = json_decode($response->getBody());
							Log::info('Create User', ['newsletter_subscription' => $json_newslatter]);
							// get user 
							$user = User::find($userId);
							$user->receive_newsletter = $receive_newsletter;
							$user->save();
							$response_status = true;
						}else{
							
							Log::info('Something wrong to call newsletter_subscription', ['user_status' => $req_news]);
							$response_status = false;
						}
					}
				}
			}
		}
		return ['status' => $response_status];
	}

	/*
	* when user makes contract by clicking obligation button
	* create user subscription in CRM
	* create user post in laravel
	*/
	public function makeContract(Request $request){

		$is_old_Contract_link = false;
		if (Session::has('is_old_Contract_link')) {  
			if(session('is_old_Contract_link') == 1){
				$is_old_Contract_link = true;
			}
		} 

		$package = $request->input('package');
		$code = $request->input('code');
		$currency_code = $request->input('currency_code');

		$packageObj = array();

		if( isset($package) && !empty($package) ){
			$packageObj = Package::find($package);
		}

		// $time = substr($code, 0, 10);
		// $remain_code = substr($code, 10);
		// $id = $remain_code / ($time * 2);

		$user = "";

		if (isset($code) && !empty($code)) {
			$user = User::getUserBySlug($code);
		}

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}

		if( isset($user) && !empty($user->id) ){

			// check user contract is activated or not.
			// DO NOT CHECK CONTRACT ACTIVE HERE
			// if(!empty($user->contract_expire_on) && $user->contract_expire_on != null){

			// 	$curdate = strtotime(date("Y-m-d"));
			// 	$contract_expire_on = strtotime($user->contract_expire_on);

			// 	if($contract_expire_on > $curdate)
			// 	{
					
			// 		flash(t("sign_contract_link"))->success();
			// 		return redirect(config('app.locale') . '/');
			// 	}
			// }

			$checkPost = Post::withoutGlobalScopes()->where('user_id', $user->id)->where('Package' , '!=' , '')->where('package' , '>' , 0)->orderBy('id', 'desc')->first();
		}

		if( isset($checkPost) && !empty($checkPost) ){

			// check payment
			$checkPayment = \DB::table('payments')->where('post_id', $checkPost->id)->orderBy('id', 'desc')->first();
			
			if( $checkPayment && !empty($checkPayment) ){
				
				// check payment status and if it is approved then redirect to the home page
				if($checkPayment->transaction_status === 'approved'){
					
					flash(t("sign_contract_link"))->success();
					return redirect(config('app.locale') . '/');
				}
			}
		}

		$username = $request->input('id');
		$subid = $request->input('subid');
		// $user = User::find($id);

		// $browser_detail = "";
		// Function to get the client IP address
		$id_address = \Request::getClientIp(true);

		$is_free_user = false;

		if(isset($checkPost->subscription_type) && $checkPost->subscription_type == 'free'){
			$is_free_user = true;			
		}

		//check if post is exists and not paid then do not create any new post
		if($is_free_user == true || empty($checkPost)){
			
			// Post Data
			$postInfo = [
				'country_code' => config('country.code'),
				'user_id' => $user->id,
				'category_id' => 0,
				'title' => '',
				'description' => '',
				'contact_name' => '',
				'city_id' => 0,
				'email' => $user->email,
				'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
				'code_token' => md5($code),
				'verified_email' => 1,
				'verified_phone' => 1,
				'username' => $username,
				'package' => $package,
				'subid' => isset($packageObj->package_uid) ? $packageObj->package_uid : $subid,
				'code_without_md5' => $code,
				'currency_code' => $currency_code,
				'subscription_type' => 'paid',
			];

			$post = new Post($postInfo);
			$post->save();
			
			//on successfull entry call create_sub crm api
			if( $post->id ){

				$req_arr = array(
					'action' => 'create_sub', //required
					// 'wpusername' => auth()->user() ? auth()->user()->username : '', // required
					'wpusername' => isset($username) ? $username : '',
					'transactionid' => $post->id,
					'gateway' => '',
					'type' => '',
					'currency' => isset($packageObj->currency_code) ? $packageObj->currency_code : '',
					'description' => isset($packageObj->name) ? $packageObj->name : '',
					'uid' => isset($packageObj->package_uid) ? $packageObj->package_uid : $subid,
					'rescission' => '',
					'ip' => $id_address,
					'agent' => ($request->header('User-Agent')) ? $request->header('User-Agent') : '',
				);
				Log::info('Request Array ', ['Request Array create_sub' => $req_arr]);

				try{
                    $response = CommonHelper::go_call_request($req_arr);
                }catch(\Exception $e){
                    \Log::error("============ Error failed create_sub CRM api call ===================");
					// CRM api failed send email details
					$crmApiFailedArr = [
		                'gocode' => isset($user->profile->go_code) ? $user->profile->go_code : '',
		                'username' => isset($user->username) ? $user->username : '',
		                'email' => isset($user->email) ? $user->email: '',
		                'subject' => t('Payment process error'),
		                'message' => 'Some error occurred in create_sub API call',
		                'messageDetails' => $e->getMessage(),
		            ];
                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
                }
				
				// if subscription is created successsfully then make user active but password not generated.
				if ($response->getStatusCode() == 200) { 

					$json = json_decode($response->getBody());
					$crm_transaction_id = intval($json);
					Log::info('Response Array', ['Response Array create_sub' => $json]);
					
					$user->active = 1;
					$user->save();
					$post->crm_transaction_id = $crm_transaction_id;
					$post->save();
				}else{

					$user->active = 0;
					$user->save();
					$post->forceDelete();
					flash(t("Some issue found while create contract, Please contact administrator"))->error();
					return redirect($user->profile->contract_link);
				}
				
				// url string
				$string = 'code='.$code.'&d='.$user->country_code.'&id='.$username.'&subid='.$subid.'&package='.$package.'&pid='.$post->id;

				// Save ad Id in session (for next steps)
				session(['tmpPostId' => $post->id]);
				
				if($is_old_Contract_link == true){
					return redirect(config('app.locale').'/contract/'.$post->tmp_token.'/packages/?'.$string);
				}else{
					// call encrypt url functions
					$url_res = CommonHelper::dec_enc('encrypt', $string);
					return redirect(config('app.locale').'/contract/'.$post->tmp_token.'/packages/?'.$url_res);
				}
				// return redirect(config('app.locale') . '/contract/' . $post->tmp_token . '/packages?' .'&code=' . $code . '&d='. $user->country_code . '&id=' . $username . '&subid=' . $subid . '&package=' . $package);
			}
		} else{

			// Save ad Id in session (for next steps)
			session(['tmpPostId' => $checkPost->id]);
			// url string
			$string = 'code='.$code.'&d='.$user->country_code.'&id='.$username.'&subid='.$subid.'&package='.$package.'&pid='.$checkPost->id;
			if($is_old_Contract_link == true){

				return redirect(config('app.locale').'/contract/'.$checkPost->tmp_token.'/packages/?'.$string);
			}else{
				// call encrypt url functions
				$url_res = CommonHelper::dec_enc('encrypt', $string);
				return redirect(config('app.locale').'/contract/'.$checkPost->tmp_token.'/packages/?'.$url_res);
			}
			// return redirect(config('app.locale') . '/contract/' . $checkPost->tmp_token . '/packages?' .'&code=' . $code . '&d='. $user->country_code . '&id=' . $username . '&subid=' . $subid . '&package=' . $package);
		}
	}

	/*
	* second steps of contract page to make payment
	* displays payment option
	*/
	public function showPackagesForm($postIdOrToken, Request $request) { 

		$is_old_Contract_link = true;
		// check contract link old or new
		if(isset($request->code)){
			$slug 		= isset($request->code)? $request->code : '';
		 	$subid 		= isset($request->subid)? $request->subid : '';
		 	$country 	= isset($request->d)? $request->d : '';
		 	$seleted_package_id 	= isset($request->package)? $request->package : '';
		 	$user_name 	= isset($request->id)? $request->id : '';
		 	$post_id 	= isset($request->pid)? $request->pid : '';
		 	$is_renew 	= isset($request->renew)? $request->renew : 0;
		}else{
			$is_old_Contract_link = false;
			$fullUrl = $request->fullUrl();
			$query_str = parse_url($fullUrl, PHP_URL_QUERY);
			// call decrypt url functions
			$url_res = CommonHelper::dec_enc('decrypt', $query_str);
			if(empty($url_res)){ 
				flash(t("Unknown error, Please try again in a few minutes"))->error(); 
				return redirect(config('app.locale')); 
			}
			// url string to Array convert
			parse_str($url_res, $query_params);
			if(empty($query_params)){ 
				flash(t("Unknown error, Please try again in a few minutes"))->error(); 
				return redirect(config('app.locale')); 
			}
		 	$slug 		= isset($query_params['code'])? $query_params['code'] : '';
		 	$subid 		= isset($query_params['subid'])? $query_params['subid'] : '';
		 	$country 	= isset($query_params['d'])? $query_params['d'] : '';
		 	$seleted_package_id 	= isset($query_params['package'])? $query_params['package'] : '';
		 	$user_name 	= isset($query_params['id'])? $query_params['id'] : '';
		 	$post_id 	= isset($query_params['pid'])? $query_params['pid'] : '';
		 	$is_renew 	= isset($query_params['renew'])? $query_params['renew'] : 0;
		}
		$user = User::getUserBySlug($slug);
		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}

		//redirect if user is blocked
		if (isset($user) && $user->blocked == 1) {
			flash(t("user_account_suspened"))->error();
			return redirect(config('app.locale'));
		}

		// check user contract is activated or not.
		// DO NOT CHECK CONTRACT ACTIVE HERE
		// if(!empty($user->contract_expire_on) && $user->contract_expire_on != null){

		// 	$curdate = strtotime(date("Y-m-d"));
		// 	$contract_expire_on = strtotime($user->contract_expire_on);

		// 	if($contract_expire_on > $curdate)
		// 	{
				
		// 		flash(t("sign_contract_link"))->success();
		// 		return redirect(config('app.locale') . '/');
		// 	}
		// }
		
		Session::put('redirectTopackages', $request->fullUrl());
		$data = $request->session()->all();
		
		$post = "";
		// check that post_id and tem_token is match with the given contract link
		if(isset($post_id) && !empty($post_id)){
			
			$post = Post::withoutGlobalScopes()->where('id', $post_id)->where('tmp_token', $postIdOrToken)->first();

			// check user already paid
			$currentPayment = Payment::withoutGlobalScopes()->where('post_id', $post_id)->orderBy('created_at', 'DESC')->first();
			if (!empty($currentPayment)) {
				if ($currentPayment->transaction_status == "approved") {
					flash(t("You already made signed this contract"))->success();
					return redirect(config('app.locale') . '/');
				}
			}

			//check if payment method is sepa then redirect to home page
			if (!empty($currentPayment) && ($currentPayment->payment_method_id == 5 || $currentPayment->gateway == 'sepa') && $currentPayment->transaction_status === 'pending') {

				if($currentPayment->payment_method_id == 5){
					flash(t("offline_payment_selected"))->success();
				}
				else if($currentPayment->gateway == 'sepa'){
					flash(t("your payment request is under processing"))->success();
				}
				return redirect(config('app.locale') . '/');
				exit;
			}
		}
		// if post id not found then redirect to the contract page and return to the payment page with post_id
		if (isset($post_id) && empty($post) && $post == '') {
			$string = 'code=' . $slug . '&d='. $country .'&id=' . $user_name . '&subid=' . $subid;
			$url_res = CommonHelper::dec_enc('encrypt', $string);
			return redirect(config('app.locale').'/contract/?'.$url_res);
		}


		// if (Session::has('tmpPostId')) {
		// 	$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		// }
		
		//$postsql = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->toSql();
		//dd($post);
		
		$currentPayment = null;
		if (isset($post)) {
			view()->share('post', $post);
		}
		//if country not set in url or country is not from default country list
		// $country = $request->input('d');
		//$country = isset($query_params['d'])? $query_params['d'] : '';
		$default_countries = \App\Models\Country::pluck('code')->toArray();
		if(($country == "" || !in_array($country, $default_countries))  && config("app.locale") == "en"){
			$country = "UK";
		}
		else if(($country == "" || !in_array($country, $default_countries)) && config("app.locale") == "de"){
			$country = "AT";
		}

		//hide offline payment for selected countries
		$is_hide_offline_payment = false;
		$hide_offline_payment = (config('constant.HIDE_OFFLINE_PAYMENT') && config('constant.HIDE_OFFLINE_PAYMENT') != "")? config('constant.HIDE_OFFLINE_PAYMENT') : '';
		if(isset($country) && $country != ""){
			if(in_array(strtolower($country), $hide_offline_payment)){
				$is_hide_offline_payment = true;
			}
		}


		if ($subid == '_access_free') {
			// $this->packages = Package::where('translation_of', $request->get('package'))->where('price', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('price', 0.00)->where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($subid == '_access') {
			// $this->packages = Package::where('translation_of', $request->get('package'))->where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($subid == '_access_both') {
			// $this->packages = Package::where('translation_of', $request->get('package'))->where('user_type_id', 3)->where('country_code', config("country.code"))->applyCurrency()->with('currency')->orderBy('lft')->get();
			$this->packages = Package::where('user_type_id', 3)->where('country_code', $country)->applyCurrency()->with('currency')->orderBy('lft')->get();
		} else {
			return redirect(config('app.locale') . '/');
		}
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

		// Get current Payment
		if (isset($post) && $post->featured == 1) {
			$currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)
				->where('post_id', $post->id)
				->orderBy('created_at', 'DESC')
				->first();

			view()->share('currentPayment', $currentPayment);

			// Get the package of the current payment (if exists)
			if (isset($currentPayment) && !empty($currentPayment)) {
				$currentPaymentPackage = Package::transById($currentPayment->package_id);
				view()->share('currentPaymentPackage', $currentPaymentPackage);
			}
		}
		
		// call api get Payment with Fees
		$req_arr = array(
			'action' => 'transaction_get_unpaid', //required
			'wpusername' => $user->username, // required api 
		);

		$response = CommonHelper::go_call_request($req_arr);
		Log::info('Request Array transaction_get_unpaid', ['Request Array' => $req_arr]);
		$getPaymentFees = json_decode($response->getBody());
		Log::info('Response Array transaction_get_unpaid', ['Response Array update' => $getPaymentFees]);
		$summaryPayFees 	= array();
		$reminderFeesArr 	= array();
		if(isset($getPaymentFees->line_items)){
			array_shift($getPaymentFees->line_items);
			$reminderFeesArr = $getPaymentFees->line_items;
		} 
		if(isset($getPaymentFees->summary)){
			$summaryPayFees = $getPaymentFees->summary; 
		}

		// Call api for coupon list for payment
		$req_arr = [
			'action' => 'coupon_list',
			'wpusername' => $user->username
		];
		$response = CommonHelper::go_call_request($req_arr);
		Log::info('Request Array coupon_list', ['Request Array' => $req_arr]);
		$couponPaymentList = json_decode($response->getBody());
		Log::info('Response Array coupon_list', ['Response Array update' => $couponPaymentList]);

		// $couponPaymentList = $this->couponPaymentListDummyArray();
		$couponPaymentListArr = array();
		$currentDate = date("Y-m-d");
		$paymentMethodNames = config('constant.PAYMENT_METHODS');
		
		if(!empty($couponPaymentList) && count($couponPaymentList) > 0){
			
			foreach ($couponPaymentList as $key => $val) {
				$is_discount_coupon_allowed = 1;
				$expiredDate = $val->expiry_date;

				// check discount greater than 0
				if(isset($val->discount) && abs($val->discount) <= 0){ 
				 	$is_discount_coupon_allowed = 0;
				}
				
				// check active or not
				if($val->active != 1){
					$is_discount_coupon_allowed = 0;
				}

				// check coupon is not expired
				if(strtotime($currentDate) > strtotime($expiredDate)) {
				 	$is_discount_coupon_allowed = 0;
				}
				
				// check country 
				if(!empty($val->countries)){
				  	$countries = explode(',', $val->countries);
				  	if(!in_array($user->country_code, $countries)){
			  	 		$is_discount_coupon_allowed = 0;
			  	 	}
				}

				$type_symbol = isset($val->type_symbol) ? $val->type_symbol : '';
				if($is_discount_coupon_allowed == 1){
					
					if(isset($paymentMethodNames[$val->payment_types])){
						
						// if($val->payment_types == 'cc'){
						// 	$val->payment_types = 'sofort';
						// }
						$couponPaymentListArr[$paymentMethodNames[$val->payment_types]] =  $val;

					 	if(!isset($val->type_symbol)){
					 		
					 		$couponPaymentListArr[$paymentMethodNames[$val->payment_types]]->type_symbol =  '';
						}else{
					 		
					 		$couponPaymentListArr[$paymentMethodNames[$val->payment_types]]->discount_text =  $val->discount.$type_symbol.' '.t('discount');
					 	}
					}else{

						$couponPaymentListArr[$val->payment_types] =  $val;

						if(!isset($val->type_symbol)){
					 		
					 		$couponPaymentListArr[$val->payment_types]->type_symbol =  '';
						}else{

							$couponPaymentListArr[$val->payment_types]->discount_text = $val->discount.$type_symbol.' '.t('discount');
						}
					}
				}
			}
		} 
		// echo "<pre>"; print_r ($couponPaymentListArr); echo "</pre>"; exit();
		// $time = substr($slug, 0, 10);
		// $remain_slug = substr($slug, 10);
		// $id = $remain_slug / ($time * 2);
		$data = [];
		$data['user'] = $user;
		$data['uriPath'] = 'payment';
		$data['siteCountryInfo'] = NULL;
		// $data['code'] = $request->get('code');
		// $data['id'] = $request->get('id');
		// $data['subid'] = $request->get('subid');
		// $data['seleted_package_id'] = ($request->get('package')) ? $request->get('package') : '';
		$data['code'] = $slug;
		$data['id'] = $user_name;
		$data['subid'] = $subid;
		$data['post_id'] = $post_id;
		$data['is_renew'] = $is_renew;
		$data['seleted_package_id'] = $seleted_package_id;
		$data['countPackages'] = count($this->packages);
		$data['reminderFeesArr'] = $reminderFeesArr;
		$data['summaryPayFees'] = $summaryPayFees;
		$data['couponPaymentListArr'] = $couponPaymentListArr;
		$data['paymentMethodName'] = config('constant.PAYMENT_METHODS');
		$data['show_payment_link'] = true;
		$data['is_hide_offline_payment'] = $is_hide_offline_payment;
		 // echo "<pre>"; print_r($data); echo "</pre>"; exit(); 
		return view('contract.packages', $data);
	}

	/*
	* when user submit form after selecting any payment method 
	*/
	public function postPackages($postIdOrToken, PackageRequest $request) {


		// Get Post pre
		Log::info('postPackages Package id', ['Package id' => $request->input('package')]);
		Log::info('postPackages Payment Method', ['Payment Method' => $request->input('payment_method')]);

		$couponDiscountArray = json_decode($request->input('coupon_discount_array'));
		$paymentMethodDiscountArray = json_decode($request->input('payment_method_discount_array'));
		$code = $request->input('code');
		// $time = substr($code, 0, 10);
		// $remain_code = substr($code, 10);
		// $id = $remain_code / ($time * 2);

		$user = "";

		if (isset($code) && !empty($code)) {
			$user = User::getUserBySlug($code);
		}

		// Log::info('postPackages Userdetail', [$user]);

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			return redirect(config('app.locale'));
		}

		$username = $request->input('id');
		$subid = $request->input('subid');
		$post_id = $request->input('post_id');
		// $user = User::find($id);

		Session::put('user_id', $user->id);
		Session::save();

		Log::info('postPackages tmpPostId', [session('tmpPostId')]);

		$post = '';
		// Get Post

		if(isset($post_id) && !empty($post_id)){
			$post = Post::withoutGlobalScopes()->where('id', $post_id)->where('tmp_token', $postIdOrToken)->with('user.profile')->first();
		}
		
		// if (Session::has('tmpPostId')) { 
		// 	$post = Post::withoutGlobalScopes()->where('id', session('tmpPostId'))->with('user.profile')->first();
		// }

		// $arrayName = array('post_id' => $post->id, 'User_id' => $post->user_id);

		// Log::info('postPackages postDetail', ['post_id' => $post->id, 'User_id' => $post->user_id]);

		// print_r(Session::all());
		// echo "<pre>";
		// print_r($post);exit;
		// MethodAKE A PAYMENT (IF NEEDED)

		// Check if the selected Package has been already paid for this Post
		$alreadyPaidPackage = false;
		
		if (!empty($post)) {
			
			$currentPayment = Payment::withoutGlobalScopes()->where('post_id', $post->id)->orderBy('created_at', 'DESC')->first();


			if (!empty($currentPayment)) {
				if ($currentPayment->package_id == $request->input('package') && $currentPayment->transaction_status == "approved") {
					$alreadyPaidPackage = true;
				}

				$payment_id = $request->input('payment_method');
				$paymentMethods = array();

				if(isset($payment_id) && !empty($payment_id)){
					$paymentMethods = PaymentMethod::find($payment_id);
				}

				// if(isset($paymentMethods) && !empty($paymentMethods) && $paymentMethods->name == 'offlinepayment' && $currentPayment->transaction_status === 'pending'){
				// 	flash(t("offline_payment_selected"))->success();
				// 	return redirect(config('app.locale') . '/');
				// }

				if(isset($currentPayment) && $currentPayment->transaction_status === 'approved'){
					flash(t("sign_contract_link"))->success();
					return redirect(config('app.locale') . '/'); exit();
				}

				//check if payment method is sepa then redirect to home page
				if (!empty($currentPayment) && ($currentPayment->payment_method_id == 5 || $currentPayment->gateway == 'sepa') && $currentPayment->transaction_status === 'pending') {
					if($currentPayment->payment_method_id == 5){
						flash(t("offline_payment_selected"))->success();
					}
					else if($currentPayment->gateway == 'sepa'){
						flash(t("your payment request is under processing"))->success();
					}
					return redirect(config('app.locale') . '/'); exit();
				}

				// check user contract is activated or not.
				// DO NOT CHECK CONTRACT ACTIVE HERE
				/*if(!empty($user->contract_expire_on) && $user->contract_expire_on != null){

					$curdate = strtotime(date("Y-m-d"));
					$contract_expire_on = strtotime($user->contract_expire_on);

					if($contract_expire_on > $curdate)
					{
						
						flash(t("sign_contract_link"))->success();
						return redirect(config('app.locale') . '/');
					}
				}*/
			}

			// for get ip address and browser details
			// When you call the detect function you will get a result object, from the current user's agent.
			//$browser_detail = \Browser::detect1($_SERVER['HTTP_USER_AGENT']);
			//$browser_detail = '';

			// Function to get the client IP address
			//$id_address = \Request::getClientIp(true);
			//  for get ip address and browser details

			// Check if Payment is required
			$package = Package::find($request->input('package'));
			$paymentMethods = PaymentMethod::find($request->input('payment_method'));

			Session::put('offlinepaymentmsg', 'no');
			
			if(isset($paymentMethods->name) && !empty($paymentMethods->name)){
				if($paymentMethods->name == 'offlinepayment'){
					Session::put('offlinepaymentmsg', 'yes');
				}
			}

			if (!empty($package) && $package->price > 0 && $request->filled('payment_method') && !$alreadyPaidPackage) {

				if ($subid == '_access' || $subid == '_access_both') {
					
					// create_sub api call when make order in obligations.
					/*
					$req_arr = array(
						'action' => 'create_sub', //required
						// 'wpusername' => auth()->user() ? auth()->user()->username : '', // required
						'wpusername' => isset($user->username) ? $user->username : '',
						'transactionid' => $post->id,
						'gateway' => $paymentMethods->name,
						'type' => $request->get('accept_method'),
						'currency' => $package->currency_code,
						'description' => $package->name,
						'uid' => $subid,
						'rescission' => '',
						'ip' => $id_address,
						'agent' => $browser_detail,
					);

					$response = CommonHelper::go_call_request($req_arr);
					*/

					/*if($response->getStatusCode() == 200){
						return $this->sendPayment($request, $post);
					*/

					//if ($request->input('payment_method') != '5') {
						/*mail system*/
						//	Mail::to($user->email)->send(new PaymentNotificationAfterSuccess($user));
						/*end mail system*/
					//}

					// store payment request log for payment process
					try{

						$accept_method = $request->get('accept_method');
						$payment_sub_method = $request->get('payment_sub_method');

						$method_name = (isset($payment_sub_method) && !empty($payment_sub_method))? $payment_sub_method : $accept_method;

						if($request->input('payment_method') == 5){
							$method_name = "offline";
						}

						$data = $request->all();
						PaymentHelper::logResponse($request->get('email'), $post->id, $request->get('payment_method'), $method_name, $data, 'pay');
					}catch(\Exception $e){
						Log::error("Error in store payment request : ". $e->getMessage());
					}

					//if ($response->getStatusCode() == 200) { 
					return $this->sendPayment($request, $post);

					//}

				}
				
			} else {

				if ($subid == '_access_free' || $subid == '_access_both') {
					$req_arr = array(
						'action' => 'generate_pw', //required
						'wpusername' => $user->username, // required
						'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
					);
					$response = CommonHelper::go_call_request($req_arr);
					Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

					$json = json_decode($response->getBody());
					Log::info('Response Array', ['Response Array generate_pw' => $json]);

					if ($response->getStatusCode() == 200) {
						$body = (string) $response->getBody();
						Log::info('Response Array password', ['Response password' => $body]);

				
						if(!in_array($user->provider, ['google','facebook'])){
							$user->password = bcrypt($body);
						}

						$req_arr = array(
							'action' => 'activate', //required
							'wpusername' => $user->username, // required
						);
						$res = CommonHelper::go_call_request($req_arr);
						Log::info('Request Array activate', ['Request Array' => $req_arr]);
						$json = json_decode($response->getBody());
						Log::info('Response Array', ['Response Array activate' => $json]);
						if ($res->getStatusCode() == 200) {
							$user->active = 1;
							$user->is_register_complated = 1;
							$user->subscribed_payment = 'complete';
							$user->subscription_type = ( $user->user_type_id == config('constant.model_type_id') )? 'paid' : 'free';
							// $user->profile->status = 'ACTIVE';
							// $user->profile->save();
						}

						$user->save();

						// $post->ismade = 1;
						// $post->save();

						return redirect(config('app.locale').'/contract/'.$postIdOrToken.'/'.$post->id.'/finish');
					}
				}
			}
		}

		if (!Session::has('tmpPostId')) {
			flash(t("The session has expired after a longtime, Please try again"))->error();
		}else{
			flash(t("Something went wrong Please try again"))->error();
		}

		// Get the next URL
		$nextStepUrl = config('app.locale') . '/';

		// Redirect
		return redirect($nextStepUrl);
	}

	/*
	* for new payment option excel Paypal, Strip and Offline payment
	* when user submit form after selecting any payment method 
	*/
	public function postPackagesAjax($postIdOrToken, PackageRequest $request) { 
		// Get Post pre
		Log::info('postPackages Package id', ['Package id' => $request->input('package')]);
		Log::info('postPackages Payment Method', ['Payment Method' => $request->input('payment_method')]);

		$code = $request->input('code');

		$user = "";

		if (isset($code) && !empty($code)) {
			$user = User::getUserBySlug($code);
		}

		// Log::info('postPackages Userdetail', [$user]);

		if (empty($user) && $user == '') {
			flash(t("Unknown error, Please try again in a few minutes"))->error();
			$data['result'] = "error";
			$data['redirect_url'] = '/' . config('app.locale') . '/';
			echo json_encode($data);
			exit;	//return redirect(config('app.locale'));
		}

		$couponDiscountArray = isset($request->coupon_discount_array) ? json_decode($request->coupon_discount_array) : [];
		$paymentMethodDiscountArray = isset($request->payment_method_discount_array) ? json_decode($request->payment_method_discount_array) : []; 
		
		$username = $request->input('id');
		$subid = $request->input('subid');
		$post_id = $request->input('post_id');
		// $user = User::find($id);

		//Session::put('user_id', $user->id);
		//Session::save();

		//Log::info('postPackages tmpPostId', [session('tmpPostId')]);

		// Get Post
		if (isset($post_id) && !empty($post_id)) { 
			$post = Post::withoutGlobalScopes()->where('id', $post_id)->with('user.profile')->first();
		}

		//Log::info('postPackages postDetail', ['post_id'=>$post->id, 'User_id'=>$post->user_id]);

		// print_r(Session::all());
		// echo "<pre>";
		// print_r($post);exit;
		// MethodAKE A PAYMENT (IF NEEDED)

		// Check if the selected Package has been already paid for this Post
		$alreadyPaidPackage = false;
		
		if (!empty($post)) {
			
			$currentPayment = Payment::withoutGlobalScopes()->where('post_id', $post->id)->orderBy('created_at', 'DESC')->first();

			if (!empty($currentPayment)) {
				// if ($currentPayment->package_id == $request->input('package')) {
				// 	$alreadyPaidPackage = true;
				// }
				if ($currentPayment->package_id == $request->input('package') && $currentPayment->transaction_status == "approved") {
					$alreadyPaidPackage = true;
				}
				
				$payment_id = $request->input('payment_method');
				$paymentMethods = array();

				if(isset($payment_id) && !empty($payment_id)){
					$paymentMethods = PaymentMethod::find($payment_id);
				}

				if(isset($currentPayment) && $currentPayment->transaction_status === 'approved'){
					$data['result'] = 'approved';
					$data['message'] = t("sign_contract_link");
					$data['url'] = config('app.url').'/'.config('app.locale');
					flash(t("sign_contract_link"))->success();
					echo json_encode($data);
					exit;
					// flash(t("sign_contract_link"))->success();
					// return redirect(config('app.locale') . '/');
				}

				//check if payment method is sepa then redirect to home page
				if (!empty($currentPayment) && ($currentPayment->payment_method_id == 5 || $currentPayment->gateway == 'sepa') && $currentPayment->transaction_status === 'pending') {
					
					$data['result'] = 'approved';
					$data['url'] = config('app.url').'/'.config('app.locale');
					if($currentPayment->payment_method_id == 5){
						$data['message'] = t("offline_payment_selected"); 
						flash(t("offline_payment_selected"))->success();
					}
					else if($currentPayment->gateway == 'sepa'){
						$data['message'] = t("sign_contract_link");
						flash(t("your payment request is under processing"))->success();
					}
					echo json_encode($data);
					exit;
				}

				// DO NOT CHECK CONTRACT ACTIVE HERE
				// if(!empty($user->contract_expire_on) && $user->contract_expire_on != null){

				// 	$curdate = strtotime(date("Y-m-d"));
				// 	$contract_expire_on = strtotime($user->contract_expire_on);

				// 	if($contract_expire_on > $curdate)
				// 	{
				// 		$data['result'] = 'successed';
				// 		$data['message'] = t("sign_contract_link");
				// 		$data['url'] = '/'. config('app.locale') . '/';
				// 		echo json_encode($data);
				// 		exit;
				// 		// flash(t("sign_contract_link"))->success();
				// 		// return redirect(config('app.locale') . '/');
				// 	}
				// }
			}

			// Check if Payment is required
			$package = Package::find($request->input('package'));
			$paymentMethods = PaymentMethod::find($request->input('payment_method'));

			Session::put('offlinepaymentmsg', 'no');
			
			// if(isset($paymentMethods->name) && !empty($paymentMethods->name)){
			// 	if($paymentMethods->name == 'offlinepayment'){
			// 		Session::put('offlinepaymentmsg', 'yes');
			// 	}
			// }

			if (!empty($package) && $package->price > 0 && $request->filled('payment_method') && !$alreadyPaidPackage) {

				if ($subid == '_access' || $subid == '_access_both') {

					$this->uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['previousUrl']);
					$this->uri['nextUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['nextUrl']);
					$this->uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['paymentCancelUrl']);
					$this->uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['paymentReturnUrl']);
					$this->uri['paymentCheckUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['paymentCheckUrl']);

					// Get Pack infos
					$package = Package::find($request->input('package'));

					// Don't make a payment if 'price' = 0 or null
					if (empty($package) || $package->price <= 0) {
						$data['result'] = 'error';
						$data['url'] = $this->uri['previousUrl'] . '?error=package';
						echo json_encode($data);
						// return redirect($this->uri['previousUrl'] . '?error=package')->withInput();
					}
					$price = !empty($package->price) ? $package->price : 0;
					// $tax = !empty($package->tax) ? $package->tax : 0;
					// $tax_amount = ($price * $tax)/100;
					$tax_amount = isset($request->tax) ? $request->tax : 0;
					$totalReminderFees = isset($request->totalReminderFees) ? $request->totalReminderFees : 0;
					// $transaction_amount = round(($price + $tax_amount + $totalReminderFees));
					// $transaction_amount = 110;
					$transaction_amount = $couponDiscountArray->transaction_amount;
					$additional_charges = isset($request->additional_charges) ? $request->additional_charges : [];
					$paymentMethodSub = $request->input('payment_sub_method');
					Stripe::setApiKey(config('app.stripe_secret'));
					$paymentMethods = array();
			
					// to accept SOFORT payments from customers in the following countries:
					// Austria, Belgium, Germany, Italy, Netherlands, Spain
					if ($paymentMethodSub == 'sofort' && !in_array(strtoupper($user->country_code), ['AT', 'BE', 'DE', 'ES', 'IT', 'NL']) ) {
						$data['result'] = 'error';
						$data['message'] = t('country_not_support_sofort');
						echo json_encode($data);
						exit;
					}

					Session::put('delayedpaymentmsg', 'no');
			
					if(isset($paymentMethodSub) && $paymentMethodSub == 'sepa'){
						Session::put('delayedpaymentmsg', 'yes');
					}

					if (in_array($paymentMethodSub, ['ideal', 'sofort', 'giropay', 'eps', 'applepay', 'sepa'])) {
						if (strtolower($package->currency_code) != 'eur') {
							$convertedAmount = $this->currencyConverter(strtolower($package->currency_code), 'eur', $transaction_amount);
						} else {
							$convertedAmount = $transaction_amount;
						}
					}

					// Log payment entry
					try{
						$data = $request->all();
						PaymentHelper::logResponse($request->input('email'), $post->id, $request->input('payment_method'), $request->input('payment_sub_method'), $data, 'pay');
					}catch(\Exception $e){
						Log::error("Error in store payment request : ". $e->getMessage());
					}

					switch ($paymentMethodSub) {

						case 'card':
							// $paymentMethods[] = 'card';
							// $amount = $convertedAmount;

							$customer_id = $this->createStripeCustomer($user);

							$intent = \Stripe\PaymentIntent::create([
								'amount' => $transaction_amount * 100,
								'currency' => strtolower($package->currency_code),
								'description' => $request->input('email') . ' - ' . $request->input('userId') . ' (' . $package->name . ')',
								'confirm' => true,
						      	'customer' => $customer_id,
						      	'setup_future_usage' => 'off_session',
						      	'payment_method' => $request->input('stripePaymentMethodId'),
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
							$intent = $this->generateResponse($intent);
							break;

						case 'ideal':
							$paymentMethods[] = 'ideal';
							$amount = $convertedAmount;

							$intent = PaymentIntent::create([
								'amount' => $convertedAmount * 100,
								'currency' => 'eur',
								'payment_method_types' => $paymentMethods,
								'description' => $request->input('email') . ' - ' . $request->input('userId') . ' (' . $package->name . ')',
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
		
							break;
						case 'eps':
							$epsSource = Source::create([
								'type' => 'eps',
								'currency' => 'eur',
								'amount' => $convertedAmount * 100,
								// 'description' => $request->input('email') . ' - ' . $request->input('userId') . '(' . $package->name . ')',
								'owner' => [
									'name' => $request->input('firstName') . ' ' . $request->input('lastName'),
									'email' => $request->input('email'),
								],
								'redirect' => [
									'return_url' => $this->uri['paymentCheckUrl']
								],
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
							break;
						case 'giropay':
							$giropaySource = Source::create([
								'type' => 'giropay',
								'currency' => 'eur',
								'amount' => $convertedAmount * 100,
								// 'description' => $request->input('email') . ' - ' . $request->input('userId') . '(' . $package->name . ')',
								'owner' => [
									'name' => $request->input('firstName') . ' ' . $request->input('lastName'),
									'email' => $request->input('email'),
								],
								'redirect' => [
									'return_url' => $this->uri['paymentCheckUrl']
								],
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
							break;
						case 'sofort':
							$sofortSource = Source::create([
								'type' => 'sofort',
								'currency' => 'eur',
								'amount' => $convertedAmount * 100,
								// 'description' => $request->input('email') . ' - ' . $request->input('userId') . '(' . $package->name . ')',
								'owner' => [
									'name' => $request->input('firstName') . ' ' . $request->input('lastName'),
									'email' => $request->input('email'),
								],
								'sofort' => [
									'country' => $user->country_code,
								],
								'redirect' => [
									'return_url' => $this->uri['paymentCheckUrl']
								],
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
							break;
						case 'applepay':
							$applepayIntent = PaymentIntent::create([
								'amount' => $transaction_amount * 100,
								'currency' => strtolower($package->currency_code),
								'description' => $request->input('email') . ' - ' . $request->input('userId') . ' (' . $package->name . ')',
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'payment_sub_method' => $request->input('payment_sub_method'),
								],
							]);
							break;
						case 'sepa':
							// $sepaCustomer = Customer::create();
							$customer_id = $this->createStripeCustomer($user);
							$sepaIntent = PaymentIntent::create([
								'currency' => 'eur',
								'amount' => $convertedAmount * 100,
								'description' => $request->input('email') . ' - ' . $request->input('userId') . ' (' . $package->name . ')',
								'setup_future_usage' => 'off_session',
								'customer' => $customer_id,
								'payment_method_types' => ['sepa_debit'],
								'setup_future_usage' => 'off_session',
								'metadata' => [
									'first_name' => $request->input('firstName'),
									'last_name' => $request->input('lastName'),
									'user_id' 	=> $request->input('userId'),
									'email' => $request->input('email'),
									'id' 	=> $request->input('id'),
									'code' 	=> $request->input('code'),
									'original_currency' => $package->currency_code,
									'original_amount' => $transaction_amount,
									'post_id' => $post->id,
									'post_tmp_token' => $post->tmp_token,
									'package_name' => $package->name,
									'payment_method' => $request->input('payment_method'),
									'is_renew' => $request->input('is_renew'),
									'accept_method' => $paymentMethodSub,
								],
							]);
							break;
						default:
							break;
					}

					$tax = !empty($package->tax) ? $package->tax : 0;
					$tax_price = ($package->price * $tax)/100;
					
					// Local Parameters
					$localParams = [
						'payment_method' => $request->get('payment_method'),
						'payment_method_sub' => $request->get('payment_sub_method'),
						'accept_method' => $paymentMethodSub,
						'cancelUrl' => $this->uri['paymentCancelUrl'],
						'returnUrl' => $this->uri['paymentReturnUrl'],
						'userCode' => $request->get('userId'),
						'userId' => $user->id,
						'name' => $request->get('email').' ('.$request->get('userId').') ',
						'post_id' => $post->id,
						'package_id' => $package->id,
						'transaction_amount' => $transaction_amount,
						'packege_price' => $package->price,
						'tax_price' => $tax_price,
						'additional_charges' => $request->input('additional_charges'),
						'is_renew' 	=> $request->input('is_renew'),
						// 'tax' => $request->tax,
						// 'is_coupon_applied' => $request->is_coupon_applied,
						'is_coupon_applied' => isset($couponDiscountArray->is_coupon_applied) ? $couponDiscountArray->is_coupon_applied : 0,
						'is_payment_method_coupon_applied' => isset($paymentMethodDiscountArray->is_payment_coupon_applied) ? $paymentMethodDiscountArray->is_payment_coupon_applied : 0,
						'is_webhook_call' => 0
					];

					$coupon_data = array();
					if($localParams['is_coupon_applied'] == 1){

						$coupon_amount = 	isset($couponDiscountArray->discount_coupon_amount) ? $couponDiscountArray->discount_coupon_amount : 0;
						$coupon_tax = 		isset($couponDiscountArray->discount_coupon_tax) ? $couponDiscountArray->discount_coupon_tax : 0;
						$coupon_name = 		isset($couponDiscountArray->coupon_name) ? $couponDiscountArray->coupon_name : '';
						$coupon_id_coupon = isset($couponDiscountArray->crm_coupon_id_coupon) ? $couponDiscountArray->crm_coupon_id_coupon : '';
						$coupon_code = 		isset($couponDiscountArray->crm_coupon) ? $couponDiscountArray->crm_coupon : '';
						$coupon_type = isset($couponDiscountArray->coupon_type) ? $couponDiscountArray->coupon_type : '';

						$coupon_data[0] = array ( 
										'coupon_amount'     => $coupon_amount,
				                        'coupon_tax'        => $coupon_tax,
				                        'coupon_name'       => $coupon_name,
				                        'coupon_id_coupon'  => $coupon_id_coupon,
				                        'coupon_code' 		=> $coupon_code,
				                        'coupon_type'		=> $coupon_type,
				                        );
						
						$localParams['coupon_code'] = $coupon_code;
						$localParams['coupon_id'] = $coupon_id_coupon;
						$localParams['coupon_name'] = $coupon_name;
						$localParams['coupon_discount'] = isset($couponDiscountArray->crm_discount) ? $couponDiscountArray->crm_discount : 0;
						$localParams['total_discounted_amount_with_payment_method'] = isset($couponDiscountArray->total_discounted_amount_with_payment_method_coupon) ? $couponDiscountArray->total_discounted_amount_with_payment_method_coupon : 0;
						$localParams['discount_coupon_amount'] = isset($couponDiscountArray->discount_coupon_amount) ? $couponDiscountArray->discount_coupon_amount : 0;
						$localParams['discount_type'] = isset($couponDiscountArray->crm_discount_type) ? $couponDiscountArray->crm_discount_type : 0;
						$localParams['coupon_type'] = $coupon_type;
						$localParams['coupon_tax'] = $coupon_tax;
					}

					if($localParams['is_payment_method_coupon_applied'] == 1){

						$payment_method_coupon_type = isset($paymentMethodDiscountArray->payment_method_coupon_type) ? $paymentMethodDiscountArray->payment_method_coupon_type : '';

						$coupon_data[1] = array ( 
										'coupon_amount'     => isset($paymentMethodDiscountArray->payment_method_discount_amount) ? $paymentMethodDiscountArray->payment_method_discount_amount : '',
				                        'coupon_tax'        => isset($paymentMethodDiscountArray->payment_method_discount_tax) ? $paymentMethodDiscountArray->payment_method_discount_tax : '',
				                        'coupon_name'       => isset($paymentMethodDiscountArray->payment_method_discount_name) ? $paymentMethodDiscountArray->payment_method_discount_name : '',
				                        'coupon_id_coupon'  => isset($paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon) ? $paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon : '',
				                        'coupon_code' 		=> isset($paymentMethodDiscountArray->payment_method_discount_coupon_code) ? $paymentMethodDiscountArray->payment_method_discount_coupon_code : '',
				                        'coupon_type'		=> $payment_method_coupon_type,
				                        );

						$localParams['payment_method_discount_id'] = isset($paymentMethodDiscountArray->payment_method_discount_id) ? $paymentMethodDiscountArray->payment_method_discount_id : 0;

						$localParams['payment_method_discount_coupon_id_coupon'] = isset($paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon) ? $paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon : 0;

						$localParams['payment_method_discount_name'] = isset($paymentMethodDiscountArray->payment_method_discount_name) ? $paymentMethodDiscountArray->payment_method_discount_name : '';

						$localParams['payment_method_discount'] = isset($paymentMethodDiscountArray->payment_method_discount) ? $paymentMethodDiscountArray->payment_method_discount : 0;

						$localParams['payment_method_discount_type'] = isset($paymentMethodDiscountArray->payment_method_discount_type) ? $paymentMethodDiscountArray->payment_method_discount_type : '';

						$localParams['payment_method_discount_coupon_code'] = isset($paymentMethodDiscountArray->payment_method_discount_coupon_code) ? $paymentMethodDiscountArray->payment_method_discount_coupon_code : '';
						
						$localParams['payment_method_discount_amount'] = isset($paymentMethodDiscountArray->payment_method_discount_amount) ? $paymentMethodDiscountArray->payment_method_discount_amount : 0;
						$localParams['payment_method_coupon_type'] = $payment_method_coupon_type;
						$localParams['payment_method_discount_tax'] = isset($paymentMethodDiscountArray->payment_method_discount_tax) ? $paymentMethodDiscountArray->payment_method_discount_tax : '';
					}	
					$localParams['coupon_data'] = $coupon_data;


					// Save the Transaction ID at the Provider
					if (isset($intent['client_secret'])) {
						$localParams['transaction_id'] = $intent['client_secret'];
					} else if (isset($epsSource['client_secret'])) {
						$localParams['transaction_id'] = $epsSource['client_secret'];
					} else if (isset($giropaySource['client_secret'])) {
						$localParams['transaction_id'] = $giropaySource['client_secret'];
					} else if (isset($sofortSource['client_secret'])) {
						$localParams['transaction_id'] = $sofortSource['client_secret'];
					} else if (isset($applepayIntent['client_secret'])) {
						$localParams['transaction_id'] = $applepayIntent['client_secret'];
					} else if (isset($sepaIntent['client_secret'])) {
						$localParams['transaction_id'] = $sepaIntent['client_secret'];
					}
					
					// API Parameters
					$providerParams = [
						'amount' => $transaction_amount,
						'currency' => $package->currency_code,
						'client_secret' => $localParams['transaction_id'],
						'email' => $request->get('email'),
						'description' => $request->get('email').' - '.$request->get('userId').' ('. $package->name .')'
					];

					$localParams = array_merge($localParams, $providerParams);
					// Save local parameters into session
					Session::put('params', $localParams);
					Session::put('delayedParams', $localParams);
					Session::save();
					
					$data['result'] = 'progress';
					$data['url'] = $this->uri;
					$data['finish_page_url'] = lurl('/contract/'.$postIdOrToken.'/'.$post->id.'/finish');
					$data['client_secret'] = $localParams['transaction_id'];
					$data['eps_redirect_url'] = isset($epsSource)  ? $epsSource->redirect->url : null;
					$data['giropay_redirect_url'] = isset($giropaySource) ? $giropaySource->redirect->url : null;
					$data['sofort_redirect_url'] = isset($sofortSource) ? $sofortSource->redirect->url : null;
					$data['user_country_code'] = config('app.stripe_country');
					$data['currency'] = strtolower($package->currency_code);
					$data['amount'] = $transaction_amount * 100;

					$data['description'] = 'Go-models@  ' . $request->get('email').' - '.$request->get('userId').' ('. $package->name .')';
					
					if (isset($intent['error'])) {  $data['error'] = $intent['error']; } 
					echo json_encode($data);
					exit;
					// $this->sendPaymentAjax($request, $post);
				}
				
			} else {

				if ($subid == '_access_free' || $subid == '_access_both') {
					$req_arr = array(
						'action' => 'generate_pw', //required
						'wpusername' => $user->username, // required
						'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
					);
					$response = CommonHelper::go_call_request($req_arr);
					Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

					$json = json_decode($response->getBody());
					Log::info('Response Array', ['Response Array generate_pw' => $json]);

					if ($response->getStatusCode() == 200) {
						$body = (string) $response->getBody();
						Log::info('Response Array password', ['Response password' => $body]);

				
						if(!in_array($user->provider, ['google','facebook'])){
							$user->password = bcrypt($body);
						}

						$req_arr = array(
							'action' => 'activate', //required
							'wpusername' => $user->username, // required
						);
						$res = CommonHelper::go_call_request($req_arr);
						Log::info('Request Array activate', ['Request Array' => $req_arr]);
						$json = json_decode($response->getBody());
						Log::info('Response Array', ['Response Array activate' => $json]);
						if ($res->getStatusCode() == 200) {
							$user->active = 1;
							$user->is_register_complated = 1;
							// $user->profile->status = 'ACTIVE';
							// $user->profile->save();
						}

						$user->save();

						// $post->ismade = 1;
						// $post->save();

						$data['result'] = 'finish';
						$data['url'] = config('app.locale') . '/contract/' . $postIdOrToken.'/'.$post->id.'/finish';
						exit;
						// return redirect(config('app.locale') . '/contract/' . $postIdOrToken . '/finish');
					}
				}
			}
		}

		if (!Session::has('tmpPostId')) {
			flash(t("The session has expired after a longtime, Please try again"))->error();
		}else{
			flash(t("Something went wrong Please try again"))->error();
		}

		$data['result'] = 'error';
		$data['url'] = config('app.locale') . '/';
		// Get the next URL
		// $nextStepUrl = config('app.locale') . '/';
		exit;

		// Redirect
		// return redirect($nextStepUrl);
	}

	/*
	* on successfull payment
	*/
	public function finish($tmpToken, $post_id) {

		// check is renew payment
		// $is_renew = false;
		// $is_update_user_data = false;

		// if (session()->has('is_renew')) {
			
		// 	if(session('is_renew') == 1){
		// 		$is_update_user_data = true;
		// 		$is_renew = true;
		// 	}
		// }


		// Get Post
		if (isset($post_id) && !empty($post_id) && !empty($tmpToken)) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', $post_id)->where('tmp_token', $tmpToken)->first();
		}


		$username = '';
		$data['show_payment_link'] = true;
		$data['first_name'] = isset($post->user->profile->first_name) ? $post->user->profile->first_name : '';



		if(isset($post) && !empty($post)){
			
			if(isset($post->user) && !empty($post->user->username)){
				$username = $post->user->username;
			}
			
			if(isset($post->user->user_register_type) && $post->user->user_register_type == 'free'){
				$data['username'] = $username;
				$data['first_name'] = ($post->user->profile->first_name)? $post->user->profile->first_name : '';
				$data['uriPath'] = 'finish';
				$data['siteCountryInfo'] = NULL;
				$data['is_free_country_contract'] = true;
				$data['show_payment_link'] = false;
				return view('contract.finish', $data);
			}
			
			session()->keep(['message']);
			if (!session()->has('message')) {
				return redirect(config('app.locale') . '/');
			}

			// Apply finish actions
			// $post->tmp_token = null;
			// $post->save();

			if (Session::has('tmpPostId')) {
				session()->forget('tmpPostId');
			}

			// unset session is_old_contratc_link
			if (Session::has('is_old_Contract_link')) {
				Session::forget('is_old_Contract_link');
			}

			$data['username'] = $username;
			$data['uriPath'] = 'finish';
			$data['siteCountryInfo'] = NULL;
			$data['is_free_country_contract'] = false;

			// Meta Tags
			MetaTag::set('title', session('message'));
			MetaTag::set('description', session('message'));


			// if (Session::has('delayedParams')) {

			// 	$params = Session::get('delayedParams');
			// 	// Save the payment
			// 	$paymentInfo = [
			// 		'post_id' => $post->id,
			// 		'package_id' => $params['package_id'],
			// 		'payment_method_id' => $params['payment_method'],
			// 		'transaction_id' => (isset($params['transaction_id'])) ? $params['transaction_id'] : null,
			// 		'active' => 0,
			// 		'packege_price' => $params['packege_price'],
			// 		'tax_price' => $params['tax_price'],
			// 		'additional_charges' => $params['additional_charges'],
			// 	];
			// 	$payment = new Payment($paymentInfo);
			// 	$payment->save();

			// 	// Get all admin users
			// 	$admins = User::where('is_admin', 1)->get();

			// 	// Send Payment Email Notifications
			// 	if (config('settings.mail.payment_email_notification') == 1) {
					
			// 		// payment notification comment by ajay 13-09-2019

			// 		// Send Confirmation Email
			// 		// try {
			// 		// 	$post->notify(new PaymentSent($payment, $post));
			// 		// } catch (\Exception $e) {
			// 		// 	flash($e->getMessage())->error();
			// 		// }

			// 		// Send to Admin the Payment Notification Email
			// 		try {
			// 			if ($admins->count() > 0) {
			// 				foreach ($admins as $admin) {
			// 					Mail::send(new PaymentNotification($payment, $post, $admin));
			// 				}
			// 			}
			// 		} catch (\Exception $e) {
			// 			flash($e->getMessage())->error();
			// 		}
			// 	}

				// $user = User::find($params['userId']);
				// var_dump($user);
				// if ($params['payment_method'] == 7) {
				// 	$req_arr = array(
				// 		'action' => 'pay', //required
				// 		'wpusername' => ($user->username) ? $user->username : '', // required
				// 		'transactionid' => $params['transaction_id'],
				// 		'gateway' => $params['payment_method_sub'],
				// 		'type' => 'stripecard',
				// 		'currency' => $params['currency'],
				// 		'description' => $params['description'],
				// 		'amount' => $params['amount'],
				// 	);
				// 	$response = CommonHelper::go_call_request($req_arr);
				// // 	Log::info('Request Array pay finish', ['Request Array' => $req_arr]);
				// }
				// var_dump($params);
			// } 

			return view('contract.finish', $data);
		
		}else{
			flash(t("Something went wrong Please try again"))->error();
			return redirect(config('app.locale') . '/');
		}

		// if (session()->has('params')) {
		// 	$params = session('params');

		// 	$paymentMethods = PaymentMethod::find($params['payment_method']);
		// 	$user = User::find(session('user_id'));

		// 	$username = ($user->username) ? $user->username : '';

		// 	/*if ($params['payment_method'] == 5) {
		// 		$req_arr = array(
		// 			'action' => 'pay', //required
		// 			'wpusername' => ($user->username) ? $user->username : '', // required
		// 			'currency' => $params['currency'],
		// 			'description' => $params['description'],
		// 			'amount' => $params['amount'],
		// 		);
		// 	} else {
		// 		$req_arr = array(
		// 			'action' => 'pay', //required
		// 			'wpusername' => ($user->username) ? $user->username : '', // required
		// 			'transactionid' => $params['transaction_id'],
		// 			'gateway' => $paymentMethods->name,
		// 			'type' => $params['accept_method'],
		// 			'currency' => $params['currency'],
		// 			'description' => $params['description'],
		// 			'amount' => $params['amount'],
		// 		);
		// 	}*/

		// 	//check if payment method is not offline payment then call active user api in CRM
		// 	if ($params['payment_method'] != 5) {
			
		// 		$req_arr = array(
		// 			'action' => 'pay', //required
		// 			'wpusername' => ($user->username) ? $user->username : '', // required
		// 			'transactionid' => $params['transaction_id'],
		// 			'gateway' => $paymentMethods->name,
		// 			'type' => $params['accept_method'],
		// 			'currency' => $params['currency'],
		// 			'description' => $params['description'],
		// 			'amount' => $params['amount'],
		// 		);
				

		// 		$response = CommonHelper::go_call_request($req_arr);
		// 		Log::info('Request Array pay finish', ['Request Array' => $req_arr]);

		// 		$json = json_decode($response->getBody());
		// 		Log::info('Response Array pay finish', ['Response Array' => $json]);
		// 		Log::info('Response Array staus code finish', ['Response Array staus code' => $response->getStatusCode()]);
				
		// 		Log::info('is renew', ['Request Array' => $is_renew]);

		// 		if ($response->getStatusCode() == 200) {

		// 			if($is_renew == false){

		// 				$req_arr = array(
		// 					'action' => 'generate_pw', //required
		// 					'wpusername' => $user->username, // required
		// 					'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
		// 				);

		// 				$response = CommonHelper::go_call_request($req_arr);
		// 				Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

		// 				$json = json_decode($response->getBody());
		// 				Log::info('Response Array generate_pw', ['Response Array' => $json]);

		// 				if ($response->getStatusCode() == 200) {

		// 					$body = (string) $response->getBody();
		// 					Log::info('Response Array password', ['Response password' => $body]);


		// 					if(!in_array($user->provider, ['google','facebook'])){
		// 						$user->password = bcrypt($body);
		// 					}

		// 					$req_arr_one = array(
		// 						'action' => 'activate', //required
		// 						'wpusername' => ($user->username) ? $user->username : '', // required
		// 					);

		// 					$res = CommonHelper::go_call_request($req_arr_one);
		// 					Log::info('Request Array activate finish', ['Request Array' => $req_arr_one]);

		// 					$json = json_decode($response->getBody());
		// 					Log::info('Response Array activate finish', ['Response Array' => $json]);

		// 					if ($res->getStatusCode() == 200) {

		// 						$is_update_user_data = true;
		// 					}
		// 				}
		// 			}

		// 			if($is_update_user_data == true){

		// 				$user->active = 1;
		// 				$user->subscribed_payment = 'complete';
		// 				$user->subscription_type = 'paid';
		// 				$user->is_register_complated = 1;
		// 				$user->profile->status = 'ACTIVE';
		// 				$user->profile->save();
		// 				$user->save();
		// 				$post->ismade = 1;
		// 				$post->save();
		// 			}

		// 			// $req_arr = array(
		// 			// 	'action' => 'generate_pw', //required
		// 			// 	'wpusername' => $user->username, // required
		// 			// 	'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
		// 			// );

		// 			// $response = CommonHelper::go_call_request($req_arr);
		// 			// Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

		// 			// $json = json_decode($response->getBody());
		// 			// Log::info('Response Array generate_pw', ['Response Array' => $json]);

		// 			// if ($response->getStatusCode() == 200) {
		// 			// 	$body = (string) $response->getBody();
		// 			// 	Log::info('Response Array password', ['Response password' => $body]);


		// 			// 	if(!in_array($user->provider, ['google','facebook'])){
		// 			// 		$user->password = bcrypt($body);
		// 			// 	}

		// 			// 	//check if payment method is not offline payment then call active user api in CRM
		// 			// 	if( $params['payment_method'] != 5 ){

		// 			// 		$req_arr_one = array(
		// 			// 			'action' => 'activate', //required
		// 			// 			'wpusername' => ($user->username) ? $user->username : '', // required
		// 			// 		);

		// 			// 		$res = CommonHelper::go_call_request($req_arr_one);
		// 			// 		Log::info('Request Array activate finish', ['Request Array' => $req_arr_one]);

		// 			// 		$json = json_decode($response->getBody());
		// 			// 		Log::info('Response Array activate finish', ['Response Array' => $json]);

		// 			// 		if ($res->getStatusCode() == 200) {
		// 			// 			$user->active = 1;
		// 			// 			$user->subscribed_payment = 'complete';
		// 			// 			$user->subscription_type = 'paid';
		// 			// 			$user->is_register_complated = 1;

		// 			// 			$user->profile->status = 'ACTIVE';
		// 			// 			$user->profile->save();
		// 			// 		}

		// 			// 		$user->save();

		// 			// 		$post->ismade = 1;
		// 			// 		$post->save();
		// 			// 	}
		// 			// }
		// 		} else {
		// 			if (session()->has('is_renew')) {
		// 				Session::forget('is_renew');
		// 			}
		// 			return redirect(config('app.locale') . '/');
		// 		}

		// 		if (Session::has('params')) {
		// 			Session::forget('params');
		// 		}
		// 	}
			
		// 	if (session()->has('is_renew')) {
		// 		Session::forget('is_renew');
		// 	}
		// } else {
		// 	return redirect(config('app.locale') . '/');
		// }

		// Keep Success Message for the page refreshing
		// session()->keep(['message']);
		// if (!session()->has('message')) {
		// 	return redirect(config('app.locale') . '/');
		// }

		// Clear the steps wizard
		// if (session()->has('tmpPostId')) {
		// 	// Get the Post
		// 	$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $tmpToken)->first();
		// 	if (empty($post)) {
		// 		abort(404);
		// 	}

		// 	// Apply finish actions
		// 	$post->tmp_token = null;
		// 	$post->save();
		// 	session()->forget('tmpPostId');
		// }

		// // unset session is_old_contratc_link
		// if (Session::has('is_old_Contract_link')) {
		// 	Session::forget('is_old_Contract_link');
		// }

		// $data['username'] = $username;
		// $data['uriPath'] = 'finish';
		// $data['siteCountryInfo'] = NULL;

		// // Meta Tags
		// MetaTag::set('title', session('message'));
		// MetaTag::set('description', session('message'));

		return view('contract.finish', $data);
	}

	/*
	* show user's detail in profile popup on contract page
	*/
	public function updateProflePopup($userId){

		$user = User::find($userId);

		if( isset($user) && !empty($user) ){
			$data = [];
			$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
			$data['user'] = $user;
			$data['uriPath'] = 'yourContract';
			$data['genders'] = Gender::trans()->get();

			$returnHTML = view('contract.inc.profile-form-popup' , $data)->render();

			return ['status' => true,'html' => $returnHTML ]; exit();
		}else{
			return ['status' => false,'html' => '']; exit();
		}
	}

	/*
	* update profile submit action from contract page
	*/
	public function profileUpdate(Request $request) {

		$req = $request->all();
	 	$rules = [
	 		'email' => 'required|email',
	 		'first_name' => 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/',
			'last_name' => 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/',
			'cs_birthday_birthDay' => 'required|before:tomorrow',
		];

		$msg['zip.required'] = t('postcode_required');

		$age = 0;
		if(isset($req) && isset($req['cs_birthday_birthDay']) && !empty($req['cs_birthday_birthDay'])){
			$age = date("Y") - date("Y", strtotime($request->input('cs_birthday_birthDay')));
		}

		if($age < 18){

			$rules['fname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
			$rules['lname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
		}

		$rules['street'] = 'required|street_validate';
		$rules['country'] = 'required';
		$rules['city'] = 'required';
		$rules['zip'] = 'required|regex:/^[A-Za-z0-9_ ]+$/';
		$rules['gender'] = 'required';

		 
		$validator = Validator::make($request->all(), $rules, $msg);

		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),

			));
			exit();
		}

		$user = User::find($request->input('user_id'));

		// lang and latitude 
		$countryname = $request->input('country_name');
		// commented city code
		// $cityname=$request->input('city_name');
		// $cityname = $request->input('city');

		$cityname 		= isset($req['city'])? $req['city'] : '';
		$fullCityName 	= isset($req['city'])? $req['city'] : '';

		if(isset($cityname) && !empty($cityname)){
			$cityname = explode(',', $cityname);
			$cityname = ( count($cityname) > 0 && isset($cityname[0]) )? $cityname[0] : $req['city'];
		}


		$geo_lat  		= $user->latitude;
		$geo_long 		= $user->longitude;
		$geo_city   	=  $user->profile->city;
        $geo_country 	= $countryname;
        $geo_full 		= $user->profile->street.", ".$user->profile->zip.', '.$user->profile->city;
        $is_geo_update 	= false;
        $dbTimeZoneId 	= $user->profile->timezone;
		$timeZoneName 	= '';

		$geo_state = $user->profile->geo_state;
		if(!empty($request->input('geo_state'))){
			$geo_state = $request->input('geo_state');
		}
		
		$is_call_timeZone_api = false;

		// get default timeZone in country table  
		$getCountryTimeZone = Country::select('time_zone_id')->where('code', $request->input('country'))->where('time_zone_id', '>', 0)->first();

		if(!empty($getCountryTimeZone)){
			$dbTimeZoneId = isset($getCountryTimeZone->timeZone->id)? $getCountryTimeZone->timeZone->id : '';
			$timeZoneName = isset($getCountryTimeZone->timeZone->time_zone_id)? $getCountryTimeZone->timeZone->time_zone_id : '';
		}

		
		if($user->profile->street != $request->input('street') || $user->country_code != $request->input('country') || $user->profile->city != $fullCityName || $user->profile->zip != $request->input('zip'))
		{	
			$is_geo_update 	= true;
			$street 		= $request->input('street');
			$zip 			= $request->input('zip');
			$city_name 		= $cityname;
			$country_name 	= $request->input('country_name');
			$address    	= $street.", ".$zip.', '.$city_name.', '.$geo_state.', '.$country_name;
			$longlat 		= array();
			$address 		= urlencode ($address);
	 		$googleurl 		= config('app.g_latlong_url');
			
			$google_api_key_maps 		= config('app.latlong_api');
			$google_timezone_api_url 	= config('app.google_timezone_api_url');

			$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$user->country_code.'&key='.$google_api_key_maps;

			// call get latitude longitude 
			$longlat = CommonHelper::getLatLong($url);
			// if invalid street and zip code, get latlong full city name
			if(empty($longlat)){

				$url = $googleurl.urlencode($fullCityName).'&sensor=false&language=en&components=country:'.$user->country_code.'&key='.$google_api_key_maps;
				// call get latlong
				$longlat = CommonHelper::getLatLong($url); 

			}

			$geo_lat    =  isset($longlat['latitude'])? strval($longlat['latitude']) : '';
	        $geo_long   =  isset($longlat['longitude'])? strval($longlat['longitude']) : '';
	        $geo_city   =  isset($longlat['geo_city'])? $longlat['geo_city'] : $city_name;
	        $geo_state  =  isset($longlat['geo_state'])? $longlat['geo_state'] : $geo_state;
	        $geo_country = isset($longlat['geo_country'])? $longlat['geo_country'] : $country_name;
	        $geo_full = $street.", ".$zip.', '.$geo_city;
			// current timestamps
			$current_timestamp = strtotime("now");

			// check default time zone exist or not
		    if(empty($getCountryTimeZone)){
				$is_call_timeZone_api = true;

				if(isset($geo_state) && !empty($geo_state)){
				
					// if default time zone empty, get state wise timeZone in state table 
			    	$stateTimeZone = States::where('country_code', $request->input('country'))->where('state_name', $geo_state)->first();

			    	if(!empty($stateTimeZone)){
						
						$dbTimeZoneId = $stateTimeZone->timeZone->id;
						$timeZoneName = $stateTimeZone->timeZone->time_zone_id;
						$is_call_timeZone_api = false;
			    	}
			    }
			}


			if($is_call_timeZone_api == true && !empty($geo_lat) && $geo_lat != '' && !empty($geo_long) && $geo_lat != '' && config('app.is_log_timezone') == true){

				// Get Google TimeZone Api call url 
				$timeZoneUrl = $google_timezone_api_url.$geo_lat.','.$geo_long.'&timestamp='.$current_timestamp.'&key='.$google_api_key_maps;
				Log::info('google_timezone_api_url url', ['google_timezone_api_url url' => $timeZoneUrl]);
				// call google maps api, Get TimeZone
				$getTimeZoneApiCall = file_get_contents($timeZoneUrl);
				$getTimeZone = json_decode($getTimeZoneApiCall); 
				\Log::info('TimeZone api Call', ['Response Array' => $getTimeZone]);
				$is_timezone_api_success = false;
				if(!empty($getTimeZone)){
					
					if(isset($getTimeZone->status)){
						
						if($getTimeZone->status == 'OK'){ 
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
			
			// commented city code
			// $address=$request->input('street').','.$request->input('city_name').','.$request->input('zip').','.$request->input('country_name');
			// $address = $request->input('street').','.$request->input('city').','.$request->input('zip').','.$request->input('country_name');
			
			// $googleurl=config('app.g_latlong_url');
			// $apikey=config('app.latlong_api');
			// $formattedAddr = str_replace(' ','+',$address);
			//Send request and receive json data by address
			//$url = file_get_contents($googleurl.urlencode($address).'&key='.$apikey); 
			//$google_map = json_decode($url);
			// Log::info('latlong api response', ['Response Array' => $google_map]);
			  
			/*if ($google_map->status == 'OK')
			{
			    $latitude = str_replace(",", ".", $google_map->results[0]->geometry->location->lat);
			    $longitude = str_replace(",", ".", $google_map->results[0]->geometry->location->lng);
			} 
			else
			{
			    $latitude = '';
			    $longitude = '';
			}*/

					// $url = $googleurl . $formattedAddr . '&key=' . $apikey.'&sensor=true';
					// $ch = curl_init();
			  //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			  //       curl_setopt($ch, CURLOPT_URL, $url);
			  //       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			  //       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			  //       $data = curl_exec($ch);
			  //       curl_close($ch);
			  //       $output= json_decode($data);
			  //       if(count($output->results) != 0) {
			  //           $latitude  = str_replace(",", ".", $output->results[0]->geometry->location->lat);
			  //           $longitude = str_replace(",", ".", $output->results[0]->geometry->location->lng);
			  //           if(empty($geo_state)) {
			  //           	$geo_state = str_replace(",", ".", $output->results[0]->address_components[2]->long_name);
			  //           }
			  //       }else{
			  //       	$latitude = '';
					// 	$longitude = '';
					// 	if(empty($geo_state)) {
					// 		$geo_state = '';
					// 	}
			  //       }
	        // Log::info('latlong api response', ['Response Array' => $output]);
	    }    
		// lang and latitude 
		
		$gender_id = config('constant.crm_female');

		if( isset($req) && !empty($req['gender']) ){
			if($req['gender'] == config('constant.gender_male')){
				$gender_id = config('constant.crm_male');
			}
		}

		$req_arr = array(
			'action' => 'update', //required
			'wpusername' => $user->username, // required api
			'name' => $request->input('first_name'),
			'lname' => $request->input('last_name'),
			'email' => $user->email,
			'tel' => $user->phone,
			'birthday' => ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '',
			'gender' => $gender_id,
			'vp_name' => ($age < 18) ? $request->input('fname_parent') : '',
			'vp_name_last' => ($age < 18) ? $request->input('lname_parent') : '',
			'type' => ($request->input('type') == '2') ? 4 : 1,
		);

		// if change city or street or zip, update CRM data
		if($is_geo_update == true){
			
			$req_arr['street'] = addslashes($request->input('street'));
			$req_arr['zip'] = $request->input('zip');
			$req_arr['city'] = $cityname;
			$req_arr['country'] = $request->input('country');
			$req_arr['latitude'] = $geo_lat;
			$req_arr['longitude'] = $geo_long;
			$req_arr['geo_lat'] = $geo_lat;
			$req_arr['geo_long'] = $geo_long;
			$req_arr['geo_city'] = $geo_city;
			$req_arr['geo_state'] = $geo_state;
			$req_arr['geo_country'] = $geo_country;
			$req_arr['geo_full'] = $geo_full;
			$req_arr['timeZoneId'] = $dbTimeZoneId;
			$req_arr['timeZoneName'] = $timeZoneName;
		}
		
		$response = CommonHelper::go_call_request($req_arr);
		Log::info('Request Array update', ['Request Array' => $req_arr]);
		$json = json_decode($response->getBody());
		Log::info('Response Array', ['Response Array update' => $json]);


		if ($response->getStatusCode() == 200) {
			$body = (string) $response->getBody();
			if ($body)
			{
				$user->gender_id = $request->input('gender');
				$user->profile->birth_day = ($request->input('cs_birthday_birthDay')) ? date("Y-m-d", strtotime($request->input('cs_birthday_birthDay')))  : '';
				$user->profile->first_name = $request->input('first_name');
				$user->profile->last_name = $request->input('last_name');
				$user->profile->fname_parent = ($age < 18) ? $request->input('fname_parent') : '';
				$user->profile->lname_parent = ($age < 18) ? $request->input('lname_parent') : '';
				$user->profile->street = addslashes($request->input('street'));
				$user->profile->city = $request->input('city');
				$user->country_code = $request->input('country');
				$user->profile->geo_state = $geo_state;
				// $user->country_code = $request->input('country');
				$user->profile->zip = $request->input('zip');
				// Save
				$user->latitude = $geo_lat;
				$user->longitude = $geo_long;
				$user->profile->timezone = $dbTimeZoneId;
				$user->save();
				$user->profile->save();
				// flash(t("Your account profile has updated successfully"))->success();

				return Response::json(array(
					'success' => true,
					'message' => t("Your account profile has updated successfully"),
				)); exit();
			}
		}

		return Response::json(array(
			'success' => true,
			'message' => t("Your account profile has updated successfully"),
		)); exit();
		// return redirect()->back();
	}

	/*
	* old function not in used
	*/
	public function payPackages($postIdOrToken, PackageRequest $request) {
		Log::info('payPackages Package id', ['Package id' => $request->input('package')]);
		Log::info('payPackages Payment Method', ['Payment Method' => $request->input('payment_method')]);

		if (Session::has('tmpPostId')) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		}

		// MAKE A PAYMENT (IF NEEDED)

		// Check if the selected Package has been already paid for this Post
		if (!empty($post)) {
			$alreadyPaidPackage = false;
			$currentPayment = Payment::where('post_id', $post->id)->orderBy('created_at', 'DESC')->first();

			if (!empty($currentPayment)) {
				if ($currentPayment->package_id == $request->input('package')) {
					$alreadyPaidPackage = true;
				}
			}

			// Check if Payment is required
			$package = Package::find($request->input('package'));
			if (!empty($package) && $package->price > 0 && !$alreadyPaidPackage) {
				// Send the Payment
				return $this->sendPayment($request, $post);
				// echo $package->price;
			}
		}

		// IF NO PAYMENT IS MADE (CONTINUE)

		// Get the next URL
		$nextStepUrl = config('app.locale') . '/contract/' . $postIdOrToken.'/'.$post->id. '/finish';

		// Redirect
		return redirect($nextStepUrl);
	}

	/*
	* strip new payment functions
	*/
	public function createPaymentIntent(Request $request) {
		Stripe::setApiKey(config('app.stripe_secret'));

		/*
		// 2. charge saved sepa debit in future
		$customer_id = "cus_HNBZLFwySrqdPm";

		// List the Customer's PaymentMethods to pick one to pay with
		$payment_methods = \Stripe\PaymentMethod::all([
	        'customer' => $customer_id,
	        'type' => 'sepa_debit'
	    ]);
	    //charge saved sepa debit
	    $payment_intent = \Stripe\PaymentIntent::create([
	        'payment_method_types' => ['sepa_debit'],
	        'amount' => 500000,
	        'currency' => 'EUR',
	        'payment_method' => $payment_methods->data[0]->id,
	        'customer' => $customer_id,
	        'confirm' => true,
	        'off_session' => true
	    ]);


		// 2. charge saved card debit in future
		  $payment_methods = \Stripe\PaymentMethod::all([
		    'customer' => 'cus_HNAOvsEHLjy9av',
		    'type' => 'card'
		  ]);
		  $payment_intent = \Stripe\PaymentIntent::create([
		    'amount' => 500000,
		    'currency' => 'eur',
		    'payment_method' => $payment_methods->data[0]->id,
		    'customer' => 'cus_HNAOvsEHLjy9av',
		    'confirm' => true,
		    'off_session' => true
		  ]);
		  $output2 = $this->generateResponse($payment_intent);

		  echo "<pre>"; print_r ($output2); echo "</pre>"; exit();

	  	*/

		$paymentMethods = array();

		switch ($request->method) {
			case 'card':
				$paymentMethods[] = 'card';
				break;
			case 'ideal':
				$paymentMethods[] = 'ideal';
				break;
			default:
				break;
		}


		$intent = PaymentIntent::create([
			'amount' => $request->amount,
			'currency' => $request->currency,
			'payment_method_types' => $paymentMethods,
			'metadata' => ['username' => $request->username],
		]);

		return json_encode(array('client_secret' => $intent['client_secret']));
		// var_dump($intent['client_secret']);
	}

	/*
	* strip new payment functions
	*/
	public function webhook() {
        Stripe::setApiKey(config('app.stripe_secret'));
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a StripePaymentIntent
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a StripePaymentMethod
                $this->handlePaymentMethodAttached($paymentMethod);
                break;
            case 'source.canceled':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->handleSourceCanceled($source);
                break;
            case 'source.chargeable':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->handleSourceChargeable($source);
                break;
            case 'source.failed':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->handleSourceFailed($source);
                break;
            case 'charge.succeeded':
                $charge = $event->data->object; // contains a StripePaymentIntent
                $this->handleChargeSucceeded($charge);
                break;
            case 'charge.failed':
                $charge = $event->data->object; // contains a StripePaymentIntent
                $this->handleChargeFailed($charge);
                break;
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }
        http_response_code(200);
	}
	
	/*
	* strip new payment functions
	*/
	private function handlePaymentMethodAttached(PaymentMethod $paymentMethod)
    {
        // $payment = new Payment();
        // $payment->objectstring = $paymentMethod->__toString();
        // $payment->save();
    }

    /*
	* strip new payment functions
	*/
    private function handlePaymentIntentSucceeded(PaymentIntent $paymentIntent)
    {
        // $payment = Payment::where('client_secret', $paymentIntent->client_secret)->first();
        // $payment->status = $paymentIntent->status;
        // $payment->livemode = $paymentIntent->livemode;
        // $payment->objectstring = $paymentIntent->__toString();
        // $payment->save();
    }

    /*
	* strip new payment functions
	*/
    private function handleSourceChargeable(Source $sourceObj)
    {
        // $payment = Payment::where('client_secret', $sourceObj->client_secret)->first();
        // $payment->status = $sourceObj->status;
        // $payment->save();
        
        // $source = Source::where('source_id', $sourceObj->id)->first();
        // $source->status = "chargeable";
        // $source->save();

        Stripe::setApiKey(config('app.stripe_sk'));
        $charge = Charge::create([
            'amount' => $sourceObj->amount,
            'currency' => $sourceObj->currency,
            'source' => $sourceObj->id,
        ]);
    }
    
    /*
	* strip new payment functions
	*/
    private function handleSourceCanceled(Source $sourceObj)
    {

    }

    /*
	* strip new payment functions
	*/
    private function handleSourceFailed(Source $sourceObj)
    {

    }

    /*
	* strip new payment functions
	*/
    private function handleChargeSucceeded(Charge $chargeObj)
    {
        switch ($chargeObj->payment_method_details->type) {
            case 'card':
                break;
            case 'eps':
            case 'giropay':
            case 'sofort':
                // $payment = Payment::where('client_secret', $chargeObj->source->client_secret)->first();
                // $payment->status = $chargeObj->status;
                // $payment->save();

                // $source = Source::where('source_id', $chargeObj->source->id)->first();
                // $source->status = $chargeObj->source->status;
                // $source->save();
                break;
            default:
                # code...
                break;
        }
    }

    /*
	* strip new payment functions
	*/
    private function handleChargeFailed(Charge $chargeObj)
    {
        switch ($chargeObj->payment_method_details->type) {
            case 'card':
                break;
            case 'eps':
            case 'giropay':
            case 'sofort':
                // $payment = Payment::where('client_secret', $chargeObj->source->client_secret)->first();
                // $payment->status = $chargeObj->status;
                // $payment->save();

                // $source = Source::where('source_id', $chargeObj->source->id)->first();
                // $source->status = $chargeObj->source->status;
                // $source->save();
                break;
            default:
                # code...
                break;
        }

    }

    /*
	* strip new payment functions
	*/
	function currencyConverter($currency_from,$currency_to,$currency_input){

		// Fetching JSON
		$req_url = 'https://api.exchangerate-api.com/v4/latest/' . strtoupper($currency_from);
		$response_json = file_get_contents($req_url);

		// Continuing if we got a result
		if(false !== $response_json) {

			// Try/catch for json_decode operation
			try {

			// Decoding
			$response_object = json_decode($response_json);
			$currency_to = strtoupper($currency_to);
			$currency_output = round(($currency_input * $response_object->rates->$currency_to), 2);

			}
			catch(Exception $e) {
				// Handle JSON parse error...
			}
		}
		return $currency_output;
	}



	/*
	* Validate the coupon on crm and return the coupon details object
	*/
	public function postValidateCoupon(Request $request){
		$req = $request->all();
		if(isset($req) && isset($req['coupon_code']) && !empty($req['coupon_code']) ){

			$go_code = "";
			$is_renew = (isset($req['is_renew']))? $req['is_renew'] : 0;
			$user_id = (isset($req['user_id']))? $req['user_id'] : 0;
			$user_model_cat_slug = "";
			$post_id = (isset($req['post_id']))? $req['post_id'] : '';
			$coupon_code = (isset($req['coupon_code']))? $req['coupon_code'] : '';
			

			// $user = 53494;
			if($user_id > 0 ){
				$user = User::find($user_id);
			}
			
			if(isset($user) && !empty($user)){

				if(isset($user->profile) && isset($user->profile->modelcategory->slug) && !empty($user->profile->modelcategory->slug)){
					$user_model_cat_slug = $user->profile->modelcategory->slug;
				}
			}

			if( isset($req['go_code']) && !empty($req['go_code']) ){
				$go_code = intval(preg_replace("/[^0-9]/", "", $req['go_code']));
			}

			$req_arr = [
				'action' => 'coupon_validate',
				'wpusername' => $user->username,
				'coupon_code' => $req['coupon_code'],
				'go-code' => intval(preg_replace("/[^0-9]/", "", $req['go_code']))
			];

			// $data = $this->dummyArray();
			
			$response = CommonHelper::go_call_request($req_arr);
			$data = json_decode($response->getBody());
			// check return response is not empty and coupon is active
			if(isset($data) && isset($data->active) && $data->active === '1' ){
				
				$alreadyCouponApplied = '';
				if(!empty($post_id)){
					
					$alreadyCouponApplied = Post::withoutGlobalScopes()
			        	->join("payments",function($join) use ($user_id) {
			            	$join->on("payments.post_id", "=", "posts.id")
			                	->where('posts.user_id', '=', $user_id);
			        		})
			        	->join("payment_coupons",function($join) use ($coupon_code) {
			            	$join->on("payment_coupons.payment_id", "=", "payments.id")
			                	->where('payment_coupons.coupon_code', '=', $coupon_code);
			        		})
			        	->where('payments.transaction_status', 'approved')
			        	->first(); 
					
					if(!empty($alreadyCouponApplied)){
						
						return response()->json(['status' => false, 'coupon' => null, 'message' => t('Your coupon code already used!')]);
					}
				}
				
				// check discount greater than 0
				if(isset($data->discount) && abs($data->discount) <= 0){ 
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('Invalid coupon code!')]);
				}
				
				$currentDate = date("Y-m-d"); 
				$expiredDate = $data->expiry_date;
				
				// check expiry hours
				if(!empty($data->expiry_hours) && $data->expiry_hours > 0){

					$expiry_hours = '+'.$data->expiry_hours.' hour';
					$date_contract = date('Y-m-d H:i:s', $data->date_contract);
					$current_date_time = strtotime(date('Y-m-d H:i:s'));

					//add hour to datetime
					$add_hours_contract_date = date('Y-m-d H:i:s', strtotime(strval($expiry_hours), strtotime($date_contract))); 
					
					if($current_date_time > strtotime($add_hours_contract_date)){
						return response()->json(['status' => false, 'coupon' => null, 'message' => t('This coupon code is expired!')]);
					} 
				}
				
				// check coupon is not expired
				if(strtotime($currentDate) > strtotime($expiredDate)) {
					
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('This coupon code is expired!')]);		
				}
				// $go_code = 272011;
				// return if coupon_type is user and go_code does not match with user go_code then return with invalid coupon
				if($data->coupon_type == 'user' && $data->gocode != $go_code){  
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('This coupon code not available for your go code!')]);
				}

				// check coupon code already used for user gocode
				// if($data->coupon_type == 'standard'){
					
				// 	$is_coupon_used = false; 
				// 	if(isset($data->applied) && count($data->applied) > 0){ 
				// 		foreach ($data->applied as $key => $value) {
							
				// 			if(intval($value->gocode) == intval($go_code)){ 
				// 				$is_coupon_used = true;
				// 				break;
				// 			}
				// 		}
				// 	}
				// 	if($is_coupon_used == true){
				// 		return response()->json(['status' => false, 'coupon' => null, 'message' => t('Your coupon code already used!')]);
				// 	}
				// }
				
				// check if newly register user then check transaction_types=access or user contract link is renew then check transaction_types=renew
				$transaction_type_status = true;
				$transaction_type_arr = array();
				if(!empty($data->transaction_types)){
					$transaction_type_arr = explode(',', $data->transaction_types);
				}
				if(in_array('access', $transaction_type_arr) && in_array('renew', $transaction_type_arr)){
					$transaction_type_status = true;
				}else if (in_array('access', $transaction_type_arr) && $is_renew == 1) {
					$transaction_type_status = false;
				}else if (in_array('renew', $transaction_type_arr) && $is_renew == 0) {
					$transaction_type_status = false;
				}
				if($transaction_type_status == false){
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('Invalid coupon code!')]);
				}
				
				// check the user model category match with platform_types
				if( (isset($data->platform_types)) && !empty($user_model_cat_slug) && !in_array($user_model_cat_slug, explode(',', $data->platform_types))){
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('This coupon code not available for your model category!')]);
				}

				// check coupon available country with user country : countries
				if(isset($data->countries) && isset($user->country_code) && !in_array($user->country_code, explode(',', $data->countries)) ){
					return response()->json(['status' => false, 'coupon' => null, 'message' => t('Your entered coupon code not available for your countries!')]);
				}

				// success 
				return response()->json(['status' => true, 'coupon' => null, 'message' => t('success'), 'data' => $data]); exit();
			}else{
				// inactive coupon code
				return response()->json(['status' => false, 'coupon' => null, 'message' => t('Inactive coupon code!')]);
			}
		}else{
			// required coupon code
			return response()->json(['status' => false, 'coupon' => null, 'message' => t('Coupon code is required!')]);
		}
	}

	/*
	* 	Check customer already exist in db 
	*  	Create a new customer in stripe
	*/
	public function createStripeCustomer($user){
		
		// get Customer 
		$GetStripeUserDetails = StripeUserDetails::where('user_id', $user->id)->orderBy('id', 'desc')->first();
		$GetCustomerOnStripe = '';
		$customer_id = '';
		
		if(!empty($GetStripeUserDetails)){
			
			try{
				// get stripe customer
            	$GetCustomerOnStripe = \Stripe\Customer::retrieve($GetStripeUserDetails->customer_id);
            }catch(\Exception $e){

            	//$e->getMessage();
            }
		}

		if(empty($GetCustomerOnStripe)){
			
			//create customer
		    $customer = \Stripe\Customer::create(array(
		      	'email' => $user->email,
	  			'name' => $user->profile->first_name.' '.$user->profile->last_name
		    ));

			if(isset($customer->id) && !empty($customer->id)){
				$StripeUserDetails = new StripeUserDetails();
				$StripeUserDetails->user_id = $user->id;
				$StripeUserDetails->customer_id = $customer->id;
				$StripeUserDetails->save();
			}
			$customer_id = $customer->id;
		}else{
			$customer_id = $GetCustomerOnStripe->id;
		}
		return $customer_id;
	}

	public function generateResponse($intent){
	  	switch($intent->status) {
		    case "requires_action":
		    case "requires_source_action":
		      // Card requires authentication
		      return [
		        'requiresAction'=> true,
		        'paymentIntentId'=> $intent->id,
		        'client_secret'=> $intent->client_secret
		      ];
		    case "requires_payment_method":
		    case "requires_source":
		      // Card was not properly authenticated, suggest a new payment method
		      return [ 'error' => "Your card was denied, please provide a new payment method"];
		    case "succeeded":
		      // Payment is complete, authentication not required
		      // To cancel the payment after capture you will need to issue a Refund (https://stripe.com/docs/api/refunds)
		      return ['client_secret' => $intent->client_secret];
	  	}
	}

	public function couponPaymentListDummyArray(){
	 	$json = '[{"id":"1","active":"1","name_int":"Online Payment","coupon_code":"RTF-L24","coupon_type":"payment-method","length":"7","description":"Speed up Payment","transaction_types":"access","payment_types":"cc","platform_types":"baby-model,kid-model,model,50plus-model,fitness-model,plus-size-model","countries":"UK,IE,DE,CH,LI,AT,US","type":"cent","discount":"1","expiry_date":"2099-03-18","expiry_hours":"0","cc_coupon":"","id_coupon_coupon":"5","type_symbol":"%"},{"id":"7","active":"1","name_int":"Online Payment","coupon_code":"39U-TG3","coupon_type":"payment-method","length":"7","description":"Speed up Payment","transaction_types":"access","payment_types":"direct-debit","platform_types":"baby-model,kid-model,model,50plus-model,fitness-model,plus-size-model","countries":"UK,IE,DE,CH,LI,AT,US","type":"cent","discount":"3","expiry_date":"2099-03-18","expiry_hours":"0","cc_coupon":"","id_coupon_coupon":"2709","type_symbol":"%"},{"id":"9","active":"1","name_int":"Online Payment Cash Discount","coupon_code":"39U-TH4","coupon_type":"payment-method","length":"7","description":"Speed up Payment","transaction_types":"access","payment_types":"eps","platform_types":"baby-model,kid-model,model,50plus-model,fitness-model,plus-size-model","countries":"UK,DE,AT,US","type":"cash","discount":"60","expiry_date":"2020-04-30","expiry_hours":"0","cc_coupon":"","id_coupon_coupon":"2710","type_symbol":"%"}]';

	 	return $data = json_decode($json);
	}

	public function dummyArray(){
		// $req_arr = [
		// 	'action' => 'coupon_validate',
		// 	'wpusername' => 'Lora51135',
		// 	'coupon_code' => '7XY-98U',
		// 	'go-code' => intval(preg_replace("/[^0-9]/", "", 272011))
		// ];
		  $json = '{"coupon_name":{"english":"Online Payment Benefit","german":"Online Payment Vorteil"},"coupon_id":"1","coupon_id_coupon":"6","coupon":"7XY-98U","date_applied":null,"gocode":"272011","active":"1","name_int":"Online Payment","coupon_code":"RTF-L24","coupon_type":"standard","description":"Speed up Payment","transaction_types":"access","payment_types":"paypal,cc,sofort,eps,direct-debit,applepay","platform_types":"baby-model,kid-model,model,50plus-model,fitness-model,plus-size-model","countries":"US,UK,IE,DE,CH,LI,AT","type":"cash","discount":"20","expiry_date":"2099-03-18","expiry_hours":"1","cc_coupon":"dashboard","date_contract":"1585200110","applied":[{"date_applied":null,"gocode":"272011"}]}';
			return $data = json_decode($json);

		// array (
		//   'coupon_name' => 
		//   array (
		//     'english' => 'Online Payment Benefit',
		//     'german' => 'Online Payment Vorteil',
		//   ),
		//   'coupon_id' => '1',
		//   'coupon_id_coupon' => '6',
		//   'coupon' => '7XY-98U',
		//   'date_applied' => NULL,
		//   'gocode' => '272017',
		//   'active' => '1',
		//   'name_int' => 'Online Payment',
		//   'coupon_code' => 'RTF-L24',
		//   'coupon_type' => 'user',
		//   'text' => 'Speed up Payment',
		//   'transaction_types' => 'access',
		//   'payment_types' => 'paypal,cc,sofort,eps,direct-debit,applepay',
		//   'platform_types' => 'baby-model,kid-model,model,50plus-model,fitness-model,plus-size-model',
		//   'countries' => 'US,UK,IE,DE,CH,LI,AT',
		//   'type' => 'cent',
		//   'discount' => '20',
		//   'expiry_date' => '2099-03-18',
		//   'expiry_hours' => '1',
		//   'cc_coupon' => 'dashboard',
		//   'applied' => 
		//   array (
		//     0 => 
		//     array (
		//       'date_applied' => NULL,
		//       'gocode' => '272017',
		//     ),
		//   ),
		// );
	}
	/*
	* call CRM to update contract date
	* when user clicks on Order for free button from contract page
	*/
	public function makeContractForFreeModel(Request $request){
		
		$user = User::find($request->userId);
		$response_status = false;
		$message = 'success';
		
		if(empty($user)){
			return ['status' => $response_status , 'message' => t('some error occurred')];
		}
		
		// CRM api failed send email details
		$crmApiFailedArr = [
			'gocode' => isset($user->profile->go_code) ? $user->profile->go_code : '',
            'username' => isset($user->username) ? $user->username : '',
            'email' => isset($user->email) ? $user->email: '',
            'subject' => t('Free Model Contract Mail Error Subject'),
            'message' => t('Free Model Contract Mail Error Message'),
        ];
        // Get free model package
		$package = Package::where('price', 0.00)->where('user_type_id', config('constant.model_type_id'))->where('country_code', $user->country->code)->applyCurrency()->with('currency')->orderBy('lft')->first();
		
		if(isset($package) && !empty($package)){

			$postInfo = [
				'country_code' => config('country.code'),
				'user_id' => $user->id,
				'category_id' => 0,
				'title' => '',
				'description' => '',
				'contact_name' => '',
				'city_id' => 0,
				'email' => $user->email,
				'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
				'code_token' => md5($user->hash_code),
				'verified_email' => 1,
				'verified_phone' => 1,
				'username' => $user->username,
				'package' => $package->id,
				'subid' => $package->package_uid,
				'code_without_md5' => $user->hash_code,
				'currency_code' => isset($package->currency_code) ? $package->currency_code : '',
			];

			$post = new Post($postInfo);
			$post->save();

			if($post->id){

				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
					'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
				);
				Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);
				
				try{
	                $response = CommonHelper::go_call_request($req_arr);
	            }catch(\Exception $e){
	                \Log::error("============ Error failed generate_pw CRM api call ===================");
	                $crmApiFailedArr['messageDetails'] = $e->getMessage();
	                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
	            }
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array generate_pw' => $response->getBody()]);
				
				if ($response->getStatusCode() == 200) {
					
					$body = (string) $response->getBody();
					$user->password = bcrypt($body);

					$req_arr = array(
						'action' => 'activate', //required
						'wpusername' => $user->username, // required
					);
					Log::info('Request Array activate', ['Request Array' => $req_arr]);
					
					try{
						$res = CommonHelper::go_call_request($req_arr);
		            }catch(\Exception $e){
		                \Log::error("============ Error failed activate CRM api call ===================");
		                $crmApiFailedArr['messageDetails'] = $e->getMessage();
		                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
		                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
		            }
					
					$json = json_decode($response->getBody());
					Log::info('Response Array', ['Response Array activate' => $json]);
					
					if ($res->getStatusCode() == 200) {
						$user->active = 1;
						$user->is_register_complated = 1;
						$user->subscribed_payment = 'complete';
						$user->subscription_type = 'free';
						$user->user_register_type = 'free';
						// $user->profile->status = 'ACTIVE';
						$user->profile->save();
					}
					$user->save();
				}

				$id_address = \Request::getClientIp(true);
				$req_arr = array(
					'action' => 'create_sub', //required
					'wpusername' => $user->username,
					'transactionid' => $post->id,
					'gateway' => '',
					'type' => '',
					'currency' => isset($package->currency_code) ? $package->currency_code : '',
					'description' => isset($package->name) ? $package->name : '',
					'uid' => '_access_free',
					'rescission' => '',
					'ip' => $id_address,
					'agent' => ($request->header('User-Agent')) ? $request->header('User-Agent') : '',
				);
				Log::info('Request Array create_sub', ['Request Array' => $req_arr]);
				try{
					$response = CommonHelper::go_call_request($req_arr);
	            }catch(\Exception $e){
	                \Log::error("============ Error failed create_sub CRM api call ===================");
	                $crmApiFailedArr['messageDetails'] = $e->getMessage();
	                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
	            }
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array create_sub' => $json]);

				if ($response->getStatusCode() == 200) {
					// check user is model and have free access then check the payment is completed
					$json = json_decode($response->getBody());
					$crm_transaction_id = intval($json);
					$post->crm_transaction_id = $crm_transaction_id;
					$post->save();
					$response_status = true;
					flash(t("You already made signed this contract"))->success();
				}
			}
		}
		if($response_status == false){
			$message = t('some error occurred');
		}
		
		$redirect_url = config('app.url');
		if($response_status == true && $request->is_free_country == true){
		 	$redirect_url = config('app.url').'/'.config('app.locale').'/contract/'.$post->tmp_token.'/'.$post->id.'/finish';
		} 
		
		return ['status' => $response_status , 'message' => $message, 'redirect_url' => $redirect_url];
	}	
	/*
	* Free country model and partner free country subscription
	* Call crm api create_sub, generate_pw, activate
	*/
	public static function callFreeCountryCrmApi($user, $contractLinkArr, $request){
		
	 	$usertype = 'client';
		$is_api_call_true = true;
		if($user->user_type_id == config('constant.model_type_id')){
			$usertype = 'model';
			$is_api_call_true = false;
		}
			
		// CRM api failed send email details
		$crmApiFailedArr = [
			'gocode' => isset($user->profile->go_code) ? $user->profile->go_code : '',
            'username' => isset($user->username) ? $user->username : '',
            'email' => isset($user->email) ? $user->email: '',
            'subject' => t('Payment process error'),
            'message' => t('Some error occurred while processing payment please find below details'),
        ];

		$package = Package::where('price', 0.00)->where('user_type_id', $user->user_type_id)->where('country_code', $user->country->code)->applyCurrency()->with('currency')->orderBy('lft')->first();
			
		if($user->user_type_id == config('constant.model_type_id') && !empty($package)){
			
			$postInfo = [
				'country_code' => config('country.code'),
				'user_id' => $user->id,
				'category_id' => 0,
				'title' => '',
				'description' => '',
				'contact_name' => '',
				'city_id' => 0,
				'email' => $user->email,
				'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
				'code_token' => md5($contractLinkArr['slug']),
				'verified_email' => 1,
				'verified_phone' => 1,
				'username' => $user->username,
				'package' => $package->id,
				// 'subid' => $contractLinkArr['subid'],
				'subid' => $package->package_uid,
				'code_without_md5' => $contractLinkArr['slug'],
				'currency_code' => '',
				'subscription_type' => 'free',
			];

			$post = new Post($postInfo);
			$post->save();
			if($post->id){
				$is_api_call_true = true;
			}
		}
		
		$is_contract_success = false;

		
		if ($is_api_call_true == true){

			$user_post_id = '';
			$user_currency_code = 'free for partner';
			$description = 'free for partner';
			$user_sub_id = '_access_partner';
			
			if($user->user_type_id == config('constant.model_type_id')){
				$user_post_id = $post->id;
				$user_currency_code = isset($package->currency_code) ? $package->currency_code : '';
				$description = isset($package->name) ? $package->name : '';
				$user_sub_id = ( isset($package->package_uid) && !empty($package->package_uid))? $package->package_uid : $contractLinkArr['subid'];
			}

			// get user client ip
			$id_address = \Request::getClientIp(true);
			// Start call api for create subscription
			$req_arr = array(
				'action' => 'create_sub', //required
				'wpusername' => $user->username,
				'transactionid' => $user_post_id,
				'gateway' => ($user->user_type_id == config('constant.model_type_id')) ? '' : 'free for partner',
				'type' => '',
				'currency' => $user_currency_code,
				'description' => $description,
				'uid' => $user_sub_id,
				'rescission' => '',
				'ip' => $id_address,
				'agent' => ($request->header('User-Agent')) ? $request->header('User-Agent') : '',
			);
			Log::info('Request Array create_sub', ['Request Array' => $req_arr]);
			
			try{
				$response = CommonHelper::go_call_request($req_arr);
            }catch(\Exception $e){
                \Log::error("============ Error failed create_sub CRM api call ===================");
                $crmApiFailedArr['messageDetails'] = $e->getMessage();
                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
            }
			
			$json = json_decode($response->getBody());
			Log::info('Response Array', ['Response Array create_sub' => $json]);
			// End call create subscription api

			if ($response->getStatusCode() == 200) {
				
				// check user is model and have free access then check the payment is completed
				if ( $user->user_type_id == config('constant.model_type_id')) {
					$json = json_decode($response->getBody());
					$crm_transaction_id = intval($json);
					$post->crm_transaction_id = $crm_transaction_id;
					$post->save();
				}

				// Start generate Password api call in crm
				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
					'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
				);
				Log::info('Request Array generate_pw '.$usertype, ['Request Array' => $req_arr]);
				try{
	                $response = CommonHelper::go_call_request($req_arr);
	            }catch(\Exception $e){
	                \Log::error("============ Error failed generate_pw CRM api call ===================");
	                $crmApiFailedArr['messageDetails'] = $e->getMessage();
	                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
	            }

				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array generate_pw '.$usertype => $response->getBody()]);
				// End code generate password api

				if ($response->getStatusCode() == 200) {
					
					$body = (string) $response->getBody();
					$user->password = bcrypt($body);

					// Start code activate user api call in crm
					$req_arr = array(
						'action' => 'activate', //required
						'wpusername' => $user->username, // required
					);
					Log::info('Request Array activate '.$usertype, ['Request Array' => $req_arr]);
					try{
						$res = CommonHelper::go_call_request($req_arr);
		            }catch(\Exception $e){
		                \Log::error("============ Error failed activate CRM api call ===================");
		                $crmApiFailedArr['messageDetails'] = $e->getMessage();
		                $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
		                $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
		            }
					
					$json = json_decode($response->getBody());
					Log::info('Response Array', ['Response Array activate '.$usertype => $json]);
					if ($res->getStatusCode() == 200) {
						
						$user->active = 1;
						$user->is_register_complated = 1;
						$user->subscribed_payment = 'complete';
						$user->subscription_type = 'free';
						// $user->profile->status = 'ACTIVE';
						$user->profile->save();
						$is_contract_success = true;
					}
					$user->save();
				}
				// End code activate user api call in crm
			}	
		}
		return $is_contract_success;
	}

	//premium package show
	public function getPremiumPackages(Request $request){

		//logout the user before send to the contract page
		if(\Auth::check()){
			\Auth::logout();
		}

		$fullUrl = $request->fullUrl();
		$query_str = parse_url($fullUrl, PHP_URL_QUERY);

		// $url_res = CommonHelper::dec_enc('encrypt', $query_str);
		 // echo "<pre>"; print_r($url_res); echo "</pre>"; exit(); 

		// call decrypt url functions
		$url_res = CommonHelper::dec_enc('decrypt', $query_str);

		if(empty($url_res)){ 
			flash(t("Unknown error, Please try again in a few minutes"))->error(); 
			return redirect(config('app.locale')); 
		}
		// url string to Array convert
		parse_str($url_res, $query_params); 
		if(empty($query_params)){ 
			flash(t("Unknown error, Please try again in a few minutes"))->error(); 
			return redirect(config('app.locale')); 
		} 
		
		
		$code =	isset($query_params['code'])? $query_params['code'] : '';
		$username =	isset($query_params['id'])? $query_params['id'] : '';

		$user = User::withoutGlobalScopes()->where('hash_code', $code)->where('username', $username)->first();
		
		if( isset($user) && !empty($user) ){

			$checkPost = Post::withoutGlobalScopes()->where('user_id', $user->id)->orderBy('id', 'desc')->first();

			if (isset($checkPost->subscription_type) && $checkPost->subscription_type == 'paid') {

				// get payment
				if(!empty($checkPost) && isset($checkPost->id)){
					$checkPayment = \DB::table('payments')->where('post_id', $checkPost->id)->orderBy('id', 'desc')->first();
				}

				//check if payment method is sepa then redirect to home page
				if (!empty($checkPayment) && ($checkPayment->payment_method_id == 5 || $checkPayment->gateway == 'sepa') && $checkPayment->transaction_status === 'pending') {
					
					if ($checkPayment->payment_method_id == 5) {
						flash(t("You have selected offline payment"))->success();
					}else if($checkPayment->gateway == 'sepa'){
						flash(t("your payment request is under processing"))->success();
					}
					return redirect(config('app.locale') . '/');
				}
				//check user type is model the check the contract subscription status paid and payment completed
				else if ($user->subscribed_payment == 'complete' && $user->subscription_type == 'paid') {
					$nextUrl = config('app.locale') . '/';
					flash(t("sign_contract_link"))->success();
					return redirect($nextUrl);
				}
				
				// url string
				$string = 'code='.$code.'&d='.$user->country_code.'&id='.$checkPost->username.'&subid='.$checkPost->subid.'&package='.$checkPost->package.'&pid='.$checkPost->id;

				// call encrypt url functions
				$url_res = CommonHelper::dec_enc('encrypt', $string);
				return redirect(config('app.locale').'/contract/'.$checkPost->tmp_token.'/packages/?'.$url_res);
			}

			$is_disable_premium_button = false;
	        $is_disable_basic_button = false;
	        $premium_button_label = t('Premium Contract');
		        
	        // check premium country premium user contract status
	        if($user->country->country_type == config('constant.country_premium') && $user->user_register_type == config('constant.country_premium')){

	        	$checkPost = Post::withoutGlobalScopes()->where('user_id', $user->id)->orderBy('id', 'desc')->first();

	        	if( isset($checkPost) && !empty($checkPost) ){
	        		
	        		$checkPayment = \DB::table('payments')->where('post_id', $checkPost->id)->orderBy('id', 'desc')->first();

	        		if(isset($checkPayment) && !empty($checkPayment) && $checkPayment->transaction_status == 'approved'){
	        			$is_disable_premium_button = true;
	        		}else if(isset($checkPayment) && !empty($checkPayment) && $checkPayment->transaction_status == 'cancelled' ){
	        			$premium_button_label = t('process payment');
	        			$is_disable_basic_button = true;
	        		}

	        		$is_disable_basic_button = true;
	        		$premium_button_label = t('process payment');
	        	}

	        // check premium country free user contract status
	        }else if($user->country->country_type == config('constant.country_premium') && $user->user_register_type == config('constant.user_type_free')){
	        	
	        	if( $user->subscribed_payment == 'complete' && $user->subscription_type == 'free'){
	        		$is_disable_basic_button = true;
	        	}

	        // check free country free user contract status
	        }else if($user->country->country_type == config('constant.country_free') && $user->user_register_type == config('constant.user_type_free')){
	        	
	        	if( $user->subscribed_payment == 'complete' && $user->subscription_type == 'free'){
	        		$is_disable_basic_button = true;
	        	}
	        }

	        $data['is_disable_premium_button'] = $is_disable_premium_button;
	        $data['is_disable_basic_button'] = $is_disable_basic_button;
	        $data['premium_button_label'] = $premium_button_label;
	        $data['user'] = $user;

			return view('contract.upgrade_contract', $data);

		}else{
			flash( t('Invalid Request Found') )->error();
			return redirect(config('app.locale'));
		}

	}

		/*
	* on successfull payment
	*/
	public function freeContractFinishPage() {
		return view('contract.free_finish');
	}
}