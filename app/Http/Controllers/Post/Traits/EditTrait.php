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

namespace App\Http\Controllers\Post\Traits;

use App\Helpers\Arr;
use App\Helpers\Ip;
use App\Http\Requests\EditPostRequest;
use App\Models\Company;
use App\Models\Post;
use App\Models\City;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\User;
use App\Helpers\UnitMeasurement;
use App\Models\ValidValue;
use Google\Cloud\Translate\TranslateClient;
use App\Models\Language;
use App\Models\JobsTranslation;
use Illuminate\Support\Facades\Gate;


use App\Helpers\Localization\Country as CountryLocalization;

trait EditTrait
{	
	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getUpdateForm($postIdOrToken)
	{	
		$data = [];
		
		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', auth()->user()->id)->where('id', $postIdOrToken)->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		view()->share('post', $post);

		// Get the Post's Company
		if (!empty($post->company_id)) {
			$data['postCompany'] = Company::find($post->company_id);
			view()->share('postCompany', $data['postCompany']);
		}
		
		// Get the Post's Administrative Division
		if (config('country.admin_field_active') == 1 && in_array(config('country.admin_type'), ['1', '2'])) {
			// Get the Post's City
			$city = City::find($post->city_id);
			if (!empty($city)) {
				$adminType = config('country.admin_type');
				$adminModel = '\App\Models\SubAdmin' . $adminType;
				
				// Get the City's Administrative Division
				$admin = $adminModel::where('code', $city->{'subadmin' . $adminType . '_code'})->first();
				if (!empty($admin)) {
					view()->share('admin', $admin);
				}
			}
		}

		//to get user updated records 
		$user = User::find(Auth::user()->id);

		$currency_symbol = $user->country->currency->html_entity;

		$currency_code = $user->country->currency_code;

		// if user currency is empty the user system currency code
		if(empty($currency_symbol)){
			$currency_symbol = ($user->country->currency->font_arial)? $user->country->currency->font_arial : config('currency.html_entity');
		}
		
		if($post->ismodel == 1){
			// properties
			$property = [];
			$validValues = ValidValue::all();
			foreach($validValues as $val){
				$translate = $val->getTranslation(app()->getLocale());
				$property[$val->type][$val->id] = $translate->value;
			}

			$unitArr = new UnitMeasurement($user->country_code);
	        $unitoptions = $unitArr->getUnit(true);
	        $dress_Size = $unitArr->getDressSizeByPost();
			$shoe_Size = $unitArr->getShoeSizeByPost();
	        
	         

	        $property = array_merge($property, $unitoptions);
			
			view()->share('properties', $property);

			$men_dress = array();
			$women_dress = array();
			$baby_dress = array();

			// dress size array
			if(count($dress_Size['men_dress']) > 0){
				$men_dress = $dress_Size['men_dress'];
			}
		
			if(count($dress_Size['women_dress']) > 0){
				$women_dress = $dress_Size['women_dress'];
			}

			if(count($dress_Size['baby_dress']) > 0){
				$baby_dress = $dress_Size['baby_dress'];
			}

			$data['men_dress'] = $men_dress;
			$data['women_dress'] = $women_dress;
			$data['baby_dress'] = $baby_dress;


			$men_shoe = array();
			$women_shoe = array();
			$baby_shoe = array();

			// shoe size array
			if(count($shoe_Size['men_shoe']) > 0){
				$men_shoe = $shoe_Size['men_shoe'];
			}
		
			if(count($shoe_Size['women_shoe']) > 0){
				$women_shoe = $shoe_Size['women_shoe'];
			}

			if(count($shoe_Size['baby_shoe']) > 0){
				$baby_shoe = $shoe_Size['baby_shoe'];
			}

			$data['men_shoe'] = $men_shoe;
			$data['women_shoe'] = $women_shoe;
			$data['baby_shoe'] = $baby_shoe;
		}

		$is_home_job = 1;
        $country_code = (Auth::check()) ? Auth::user()->country_code : config('country.code');
        
        if (!Gate::allows('free_country_user', auth()->user())) {
            $is_home_job = 0;
        }

        $data['is_home_job'] = $is_home_job;

		$data['currency'] = $currency_symbol;
		$data['currency_code'] = $currency_code;
		$data['country_code'] = $user->country_code;
		$data['city'] = $user->profile->city;

		// Meta Tags
		MetaTag::set('title', t('Update My Ad'));
		MetaTag::set('description', t('Update My Ad'));
		
		return view('post.edit', $data);
	}
	
	/**
	 * Update the Post
	 *
	 * @param $postIdOrToken
	 * @param PostRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postUpdateForm($postIdOrToken, EditPostRequest $request)
	{	
		
		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', auth()->user()->id)->where('id', $postIdOrToken)->first();
		}
		
		if (empty($post)) {
			abort(404);
		}
		
		$latitude = (Auth::check() && isset(Auth::user()->latitude)) ? Auth::user()->latitude : '';
		$longitude = (Auth::check() && isset(Auth::user()->longitude)) ? Auth::user()->longitude : '';
		$city = (Auth::check() && isset(Auth::user()->profile->city)) ? Auth::user()->profile->city : '';

		if (!Gate::allows('free_country_user', auth()->user())) {
		
			// Get the Post's City
			// commented city code
			// $city = City::find($request->input('city', 0));
			$city = $request->input('city');
			$country = ($request->input('country')) ? CountryLocalization::getCountryNameByCode($request->input('country')) : '';
			if (empty($city)) {
				flash(t("Posting Ads was disabled for this time, Please try later Thank you"))->error();
				
				return back()->withInput($request->except('company.logo'));
			}
			// get lat and long of city and country
			$address = $city . ',' . $country;
			$googleurl = config('app.g_latlong_url');
			$apikey = config('app.latlong_api');
			$formattedAddr = str_replace(' ', '+', $address);
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
	            $latitude  = str_replace(",", ".", $output->results[0]->geometry->location->lat);
	            $longitude = str_replace(",", ".", $output->results[0]->geometry->location->lng);
	        }else{
	        	$latitude = '';
				$longitude = '';
	        }
	    }
		
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email') && $request->input('email') != $post->email;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone') && $request->input('phone') != $post->phone;

		$emailVerificationRequired = 0;
		$phoneVerificationRequired = 0;
		
		// Get or Create Company
		if ($request->filled('company_id') && !empty($request->input('company_id'))) {
			// Get the User's Company
			$company = Company::where('id', $request->input('company_id'))->where('user_id', Auth::user()->id)->first();
		} else {
			$companyInfo = $request->input('company');
			if (!isset($companyInfo['country_code']) || empty($companyInfo['country_code'])) {
				$companyInfo += ['country_code' => config('country.code')];
			}
			
			// Logged Users
			if (!isset($companyInfo['user_id']) || empty($companyInfo['user_id'])) {
				$companyInfo += ['user_id' => Auth::user()->id];
			}
			
			// Store the User's Company
			$company = new Company($companyInfo);
			$company->save();
			
			// Save the Company's Logo
			if ($request->hasFile('company.logo')) {
				$company->logo = $request->file('company.logo');
				$company->save();
			}
		}
		
		// Return error if company is not set
		if (empty($company)) {
			flash(t("Please select a company or 'New Company' to create one."))->error();
			
			return back()->withInput($request->except('company.logo'));
		}


		//store multipal category in database category_id
		$category_ids = '';

		if (!empty($request->input('parent')) && is_array($request->input('parent'))) {
			$category_ids = array_filter($request->input('parent'), function ($a) {return ($a !== '0');});

			if (count($category_ids) > 0) {
				$category_ids = implode(',', $category_ids);
			} else {
				$category_ids = '';
			}
		}

		$is_model = $request->input('ismodel');

		//store multipal model categories in the database
		$modelCategory = '';

		if($is_model == 1){
			 
			$modelCategory = $request->input('modelCategory');
		}

		if ($is_model == 1 && !empty($modelCategory) && is_array($modelCategory)) {

			$modelCategory = array_filter($modelCategory, function ($a) {return ($a !== '0');});

			if (count($modelCategory) > 0) {
				$modelCategory = implode(',', $modelCategory);
			} else {
				$modelCategory = '';
			}
		} 

		
		// if( !empty($request->input('modelCategory')) && is_array($request->input('modelCategory') )) {
		// 	$modelCategory = array_filter($request->input('modelCategory'), function($a) { return ($a !== '0'); });
			
		// 	if( count($modelCategory) > 0 ){
		// 		$modelCategory = implode(',', $modelCategory);
		// 	} else {
		// 		$modelCategory = '';
		// 	}
		// }

		//store multipal partner categories in the database
		$branchCategory = '';

		if( !empty($request->input('branch')) && is_array($request->input('branch') )) {
			$branchCategory = array_filter($request->input('branch'), function($a) { return ($a !== '0'); });
			
			if( count($branchCategory) > 0 ){
				$branchCategory = implode(',', $branchCategory);
			} else {
				$branchCategory = '';
			}
		}

		// dress size
		$baby_dress_Size = null;
		$men_dress_Size = null;
		$women_dress_Size = null;

		// shoe size
		$baby_shoe_Size = null;
		$men_shoe_Size = null;
		$women_shoe_Size = null;

		if($is_model == 1){

			$is_model_cat = $request->input('is_model_category');

			if($request->input('is_baby') == 1){

				if($request->input('babyDressSize') && !empty($request->input('babyDressSize'))){

					if (count($request->input('babyDressSize')) > 0) {
						$baby_dress_Size = implode(',', $request->input('babyDressSize'));
					} else {
						$baby_dress_Size = '';
					}
				}

				if($request->input('babyShoeSize') && !empty($request->input('babyShoeSize'))){

					if (count($request->input('babyShoeSize')) > 0) {
						$baby_shoe_Size = implode(',', $request->input('babyShoeSize'));
					} else {
						$baby_shoe_Size = null;
					}
				}
			}
				
			if ($is_model_cat == 1 && $request->input('gender_type') == config('constant.gender_male') || $request->input('gender_type') == config('constant.gender_both')) {
			
				if($request->input('menDressSize') && !empty($request->input('menDressSize'))){

					if (count($request->input('menDressSize')) > 0) {
						$men_dress_Size = implode(',', $request->input('menDressSize'));
					} else {
						$men_dress_Size = null;
					}
				}

				if($request->input('menShoeSize') && !empty($request->input('menShoeSize'))){

					if (count($request->input('menShoeSize')) > 0) {
						$men_shoe_Size = implode(',', $request->input('menShoeSize'));
					} else {
						$men_shoe_Size = null;
					}
				}
			}


			if($is_model_cat == 1 && $request->input('gender_type') == config('constant.gender_female') || $request->input('gender_type') == config('constant.gender_both')){
				
				if($request->input('womenDressSize') && !empty($request->input('womenDressSize'))){

					if (count($request->input('womenDressSize')) > 0) {
						$women_dress_Size = implode(',', $request->input('womenDressSize'));
					} else {
						$women_dress_Size = null;
					}
				}

				if($request->input('womenShoeSize') && !empty($request->input('womenShoeSize'))){

					if (count($request->input('womenShoeSize')) > 0) {
						$women_shoe_Size = implode(',', $request->input('womenShoeSize'));
					} else {
						$women_shoe_Size = null;
					}
				}
			}
		}

		
		// Update the Post
		/*
		 * Allow admin users to approve the changes,
		 * If the ads approbation option is enable,
		 * And if important data have been changed.
		 */
		if (config('settings.single.posts_review_activation')) {
			if (
				md5($post->title) != md5($request->input('title')) ||
				md5($post->company_description) != md5((isset($company->description)) ? $company->description : null) ||
				md5($post->description) != md5($request->input('description')) ||
				md5($post->application_url) != md5($request->input('application_url'))
			) {
				$post->reviewed = 0;
			}
		}

		$is_home_job = 1;
		$country_code = (Auth::check()) ? Auth::user()->country_code : config('country.code');
		
		if (!Gate::allows('free_country_user', auth()->user())) {
			$country_code = ($request->input('country')) ? $request->input('country') : config('country.code');
			$is_home_job = $request->get('is_home_job');
		}

		$post->country_code = $country_code;
		$post->category_id = $category_ids;
		$post->post_type_id = $request->input('post_type');
		$post->company_id = (isset($company->id)) ? $company->id : 0;
		$post->company_name = (isset($company->name)) ? $company->name : null;
		$post->logo = (isset($company->logo)) ? $company->logo : null;
		$post->company_description = (isset($company->description)) ? $company->description : null;
		// $post->title = $request->input('title');
		// $post->description = $request->input('description');
		$post->tags = $request->input('tags');
		$post->salary_min = $request->input('salary_min');
		$post->salary_max = $request->input('salary_max');
		$post->salary_type_id = $request->input('salary_type');
		$post->negotiable = $request->input('negotiable');
		// $post->start_date = $request->input('start_date');
		$post->end_date = null;
		// if($request->input('is_one_day') != 1){$post->end_date = $request->input('end_date');}
		$post->is_date_announce = $request->input('is_date_announce') ? $request->input('is_date_announce') : '0';

		if($request->input('is_date_announce') != 1){

			$post->start_date = $request->input('start_date');

			// if post type not whole-day end_date save in DB
			if($request->input('is_one_day') != 1){$post->end_date = $request->input('end_date');}
		}else{
			$post->start_date = null;
			$post->end_date = null;
			// if post type not whole-day end_date save in DB
			// if($request->input('is_one_day') != 1){$post->end_date = $request->input('end_date');}
		}

		// $is_home_job = $request->get('is_home_job');

		if(!empty($modelCategory)){$post->model_category_id = $modelCategory;}
		if(!empty($branchCategory)){$post->partner_category_id = $branchCategory;}
		$post->experience_type_id = $request->input('experience_type')? $request->input('experience_type') : 0;
		$post->gender_type_id = $request->input('gender_type');
		$post->tfp = $request->input('tfp') ? $request->input('tfp') : 0;
		$post->height_from = $request->input('height_from') ? $request->input('height_from') : 0;
		$post->height_to = $request->input('height_to') ? $request->input('height_to') : 0;
		$post->weight_from = $request->input('weight_from') ? $request->input('weight_from') : 0;
		$post->weight_to = $request->input('weight_to') ? $request->input('weight_to') : 0;
		$post->age_from = $request->input('age_from') ? $request->input('age_from') : 0;
		$post->age_to = $request->input('age_to') ? $request->input('age_to') : 0;
		// $post->dressSize_from = $request->input('dressSize_from') ? $request->input('dressSize_from') : 0;
		// $post->dressSize_to = $request->input('dressSize_to') ? $request->input('dressSize_to') : 0;
		$post->chest_from = $request->input('chest_from') ? $request->input('chest_from') : 0;
		$post->chest_to = $request->input('chest_to') ? $request->input('chest_to') : 0;
		$post->waist_from = $request->input('waist_from') ? $request->input('waist_from') : 0;
		$post->waist_to = $request->input('waist_to') ? $request->input('waist_to') : 0;
		$post->hips_from = $request->input('hips_from') ? $request->input('hips_from') : 0;
		$post->hips_to = $request->input('hips_to') ? $request->input('hips_to') : 0;
		// $post->shoeSize_from = $request->input('shoeSize_from') ? $request->input('shoeSize_from') : 0;
		// $post->shoeSize_to = $request->input('shoeSize_to') ? $request->input('shoeSize_to') : 0;
		$post->eyeColor = $request->input('eyeColor');
		$post->hairColor = $request->input('hairColor');
		$post->skinColor = $request->input('skinColor');
		$post->contact_name = $request->input('contact_name');
		// $post->email = $request->input('email');
		// $post->email = Auth::user()->email;
		// $post->phone = $request->input('phone');
		// $post->phone = Auth::user()->phone;
		$post->phone_hidden = $request->input('phone_hidden');
		// commented city code
		// $post->city_id = $request->input('city');
		// $post->lat = $city->latitude;
		// $post->lon = $city->longitude;
		$post->city = $city;
		$post->lat = $latitude;
		$post->lon = $longitude;
		$post->application_url = $request->input('application_url');
		$post->end_application = $request->input('end_application');
		$post->ip_addr = Ip::get();
		$post->is_home_job = (isset($is_home_job) && $is_home_job == 1)? 1 : 0;


		// $post->is_baby_model = $request->input('is_baby');

		// dress size update
		$post->dress_size_baby = $baby_dress_Size;
		$post->dress_size_men = $men_dress_Size;
		$post->dress_size_women = $women_dress_Size;
		// shoe size update
		$post->shoe_size_baby = $baby_shoe_Size;
		$post->shoe_size_men = $men_shoe_Size;
		$post->shoe_size_women = $women_shoe_Size;
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$post->email_token = md5(microtime() . mt_rand());
			$post->verified_email = 0;
		}
		
		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$post->phone_token = mt_rand(100000, 999999);
			$post->verified_phone = 0;
		}
		// Save Post
		$post->save();


		// set google cloud translation api key 
		$google_cloud_translation_api_key = (config('app.google_cloud_translation_api_key')) ? config('app.google_cloud_translation_api_key') : '';

		
		// get all active languages
		$language = Language::get();
		
		$description = $request->description;
		$title = $request->title;
		
		// google translate object create
		$translate = new TranslateClient([
		    	'key' => $google_cloud_translation_api_key
			]);
		
		// Detect the language of a string.
		$detectLanguage = $translate->detectLanguage($title);

		if(!empty($language) && count($language) > 0){
  		 	
		  	foreach ($language as $key => $lang){
				
				$g_description = '';
				$g_title = '';

				$langCode = config('app.locale');
				
				if(isset($lang['locale']) && !empty($lang['locale'])){
					
					$langCode = substr($lang['locale'], 0, strpos( $lang['locale'], '_'));
				}
				
				// get Job translations
				$jobsTranslationObj = JobsTranslation::where('job_id', $post->id)->where('translation_lang', strtolower($lang->abbr))->first();
				
				// check if not exist, create a new entry for job translatios table 
				if(empty($jobsTranslationObj)){
		            
		            // create a new object jobs translation.
		            $jobsTranslationObj = new JobsTranslation();
		            
		            $jobsTranslationObj->job_id = $post->id;
		            $jobsTranslationObj->translation_lang = strtolower($lang->abbr);
		        }

		        $jobsTranslationObj->description = $description;
				$jobsTranslationObj->title = $title;

	        	// if locale code and language code is not match, translate.
	        	// Only Google Detected language not translate
	        	if($detectLanguage != $langCode){
	        	// if($langCode != config('app.locale')){
					
					try{
                  	
	                  	// description translate
	                  	$g_description = $translate->translate($description, [
					    	'target' => $langCode,
						]);

	                  	// title translate
						$g_title = $translate->translate($title, [
					    	'target' => $langCode,
						]);
						
						$jobsTranslationObj->description = $g_description['text'];
						$jobsTranslationObj->title = $g_title['text'];
					}
	                catch(\Exception $e){ }
	        	}
			 	
			 	// save jobs translations
				$jobsTranslationObj->save();
			} 
		}
		
		// Get Next URL
		$creationPath = (getSegment(2) == 'create') ? 'create/' : '';
		
		// Temp package selection code is commented Rk - 17/01/19
		/*if (
			isset($this->data['countPackages']) &&
			isset($this->data['countPaymentMethods']) &&
			$this->data['countPackages'] > 0 &&
			$this->data['countPaymentMethods'] > 0
		) {
			flash(t("Your ad has been updated"))->success();
			$nextStepUrl = config('app.locale') . '/posts/' . $creationPath . $postIdOrToken . '/packages';
		} else {
			if (getSegment(1) == 'create') {
				$request->session()->flash('message', t('Your ad has been created'));
				$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
			} else {
				flash(t("Your ad has been updated"))->success();
				$nextStepUrl = config('app.locale') . '/' . $post->uri;
			}
		}*/

		// $request->session()->flash('message', t('Your ad has been updated'));
		flash(t("Your job has been updated"))->success();
		// $nextStepUrl = config('app.locale') . '/' . $post->uri;
		$nextStepUrl = lurl($post->uri);
		
		// Send Email Verification message
		if ($emailVerificationRequired) {
			$this->sendVerificationEmail($post);
			$this->showReSendVerificationEmailLink($post, 'post');
		}
		
		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			// Save the Next URL before verification
			session(['itemNextUrl' => $nextStepUrl]);
			
			$this->sendVerificationSms($post);
			$this->showReSendVerificationSmsLink($post, 'post');
			
			// Go to Phone Number verification
			$nextStepUrl = config('app.locale') . '/verify/post/phone/';
		}
		
		// Redirection
		return redirect($nextStepUrl);
	}

	public function getPostByID($postId){
		return $post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', $postId)->first();
	}
}
