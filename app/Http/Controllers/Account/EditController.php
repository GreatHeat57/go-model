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

use Illuminate\Support\Facades\Event;
use App\Events\UserWasVisited;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\ModelSearch;
use App\Helpers\Search;
use App\Helpers\UnitMeasurement;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Requests\UserRequest;
use App\Models\Albem;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Favorite;
use App\Models\Gender;
use App\Models\Language;
use App\Models\Message;
use App\Models\ModelBook;
use App\Models\ModelCategory;
use App\Models\Post;
use App\Models\Resume;
use App\Models\SavedPost;
use App\Models\Scopes\VerifiedScope;
use App\Models\Sedcard;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserType;
use App\Models\ValidValue;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\PartnerSearch;
use App\Models\UserLanguages;
use App\Models\UserEducations;
use App\Models\UserExperiences;
use App\Models\UserReferences;
use App\Models\UserTalents;
use App\Models\UserWorkSetting;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactPartner;
use Response;

use App\Models\UserDressSizeOptions;
use App\Models\UserShoesUnitsOptions;
use Illuminate\Support\Facades\Storage;
use App\Models\TimeZone;
use App\Models\Country;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;


class EditController extends AccountBaseController {
	use VerificationTrait;

	private $perPage = 12;

	public function dashboard() {

		if (Auth::User() && Auth::User()->user_type_id != config('constant.model_type_id')) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$perpage = (config('constant.dashboard_limit'))? config('constant.dashboard_limit') : '6';
		$invtObj = Message::with('post')
			->wherehas('post', function($query){
                $query->where('archived', 0);
            })
			->where('to_user_id', auth::user()->id)
			->where('parent_id', '0')
			->where('invitation_status', '0')
			->where('message_type', 'Invitation');
			
		
		$data['invitations_count'] = 0;
		$data['invitations'] = array();

		if (Gate::allows('list_invitations', auth()->user())) {
			$data['invitations_count'] = $invtObj->count();
			$data['invitations'] = $invtObj->limit($perpage)->get();
        }


		$favourite_posts = array();
		$favourite_posts = SavedPost::getFavouritePostsById(auth()->user()->id, $perpage);
		$data['favourite_posts'] = $favourite_posts;
		// Search
		$user_type = auth()->user()->user_type_id;


	 	$messages_page = Page::where('slug', 'messages')->trans()->first();
	 	$inviation_page = Page::where('slug', 'inviation')->trans()->first();
	    
	    $data['messages_page'] = $messages_page;
	    $data['inviation_page'] = $inviation_page;   
	 	/*
		$preSearch = [
			//'city' => (isset($city) && !empty($city)) ? $city : null,
			'admin' => (isset($admin) && !empty($admin)) ? $admin : null,
			'user_type' => (isset($user_type) && !empty($user_type)) ? $user_type : null,
			'search_content' => (isset($req['search_content']) && !empty($req['search_content'])) ? $req['search_content'] : null,
		];

		if ($user_type == 3) {
			$preSearch['height_id'] = (auth()->user()->profile->height_id) ? auth()->user()->profile->height_id : '';
			$preSearch['weight_id'] = (auth()->user()->profile->weight_id) ? auth()->user()->profile->weight_id : '';
			$preSearch['size_id'] = (auth()->user()->profile->size_id) ? auth()->user()->profile->size_id : '';

			$preSearch['chest_id'] = (auth()->user()->profile->chest_id) ? auth()->user()->profile->chest_id : '';
			$preSearch['waist_id'] = (auth()->user()->profile->waist_id) ? auth()->user()->profile->waist_id : '';
			$preSearch['hips_id'] = (auth()->user()->profile->hips_id) ? auth()->user()->profile->hips_id : '';

			$preSearch['shoes_size_id'] = (auth()->user()->profile->shoes_size_id) ? auth()->user()->profile->shoes_size_id : '';
			$preSearch['eye_color_id'] = (auth()->user()->profile->eye_color_id) ? auth()->user()->profile->eye_color_id : '';
			$preSearch['hair_color_id'] = (auth()->user()->profile->hair_color_id) ? auth()->user()->profile->hair_color_id : '';
			$preSearch['skin_color_id'] = (auth()->user()->profile->skin_color_id) ? auth()->user()->profile->skin_color_id : '';

			//$preSearch['piercing'] = (auth()->user()->profile->piercing)? auth()->user()->profile->piercing : '';
			//$preSearch['tattoo'] = (auth()->user()->profile->tattoo)? auth()->user()->profile->tattoo : '';

			$preSearch['model_category_id'] = (auth()->user()->profile->category_id) ? auth()->user()->profile->category_id : '';
			$preSearch['category_id'] = (auth()->user()->profile->parent_category) ? auth()->user()->profile->parent_category : '';

			if (auth()->user()->profile->birth_day && !empty(auth()->user()->profile->birth_day)) {
				$now = time();

				$dob = strtotime(auth()->user()->profile->birth_day);

				$difference = $now - $dob;

				$age = floor($difference / 31556926);

				if ($age && $age > 0) {
					$preSearch['age'] = $age;
				}
			}
		}

		// if (isset($req['category_id']) && !empty($req['category_id'])) {
		// 	$preSearch['category_id'] = $req['category_id'];
		// }
		*/
		$data['latest_jobs'] = array();
		// if user is not from free country then show the jobs list

		if (Gate::allows('list_jobs', auth()->user())) {
			$preSearch = app('App\Http\Controllers\Search\SearchController')->preSearchData();
		 	$preSearch['perpage'] = $perpage;

			$search = new Search($preSearch);
			$data['latest_jobs'] = $search->fechAll();
		}

		// echo "<pre>"; print_r ($data['latest_jobs']['paginator']); echo "</pre>"; exit();
		// $data['conversations'] = Message::getConversations(auth()->user()->id, 3, null);
		/*
		 	@param getMessages 
		 	$search = null, $to_user = false, $start = 0, $limit = 0, $allConversation = true
		*/
		$data['conversations'] = array();
		
		if (Gate::allows('list_messages', auth()->user())) {
			$result = Message::getMessages(null, true, 0, $perpage, false);
			if(isset($result['data'])){
				$data['conversations'] = $result['data'];
			}
		}
		
		$metaArr = [
			'title' => 'go-models dashboard - go-models'
		];
		// get metatag
		CommonHelper::goModelMeta(auth()->user(), $metaArr);

		return view('model.model-dashboard', $data);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$user = auth()->user();
		$data = [];


		$data['user'] = $user;
		
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		if(isset($user) && isset($user->country->country_type) && $user->country->country_type == config('constant.country_premium')){
			$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getPremiumCountries(), config('lang.locale'));
		}
		
		$data['genders'] = Gender::trans()->get();
		$data['userTypes'] = UserType::orderBy('id', 'DESC')->get();
		$data['gravatar'] = (!empty(Auth::user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(Auth::user()->email) : null;

		$property = [];
		$validValues = ValidValue::all();

		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = (!empty($translate)) ? $translate->value : '';
		}

		//$unitArr = UnitMeasurement::getUnitMeasurement();
		//$property = array_merge($property, $unitArr);

		$unitArr = new UnitMeasurement();
		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);

		$data['properties'] = $property;

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


		$birth_day = '';
		
		if (!empty($user->profile->birth_day)) {
			
			$birth_day = \App\Helpers\CommonHelper::getShowDate($user->profile->birth_day);
		}

		$data['birth_day'] = $birth_day;

		// get timezone by google time zone id
		// $data['timezone_name_selected']  = ($user->profile->timezone) ? $user->profile->timezone : ''; 
		$data['timezone'] = TimeZone::pluck('time_zone_id', 'id')->toArray(); 

		// Mini Stats
		// $data['countPostsVisits'] = DB::table('posts')
		// 	->select('user_id', DB::raw('SUM(visits) as total_visits'))
		// 	->where('country_code', config('country.code'))
		// 	->where('user_id', Auth::user()->id)
		// 	->groupBy('user_id')
		// 	->first();
		// $data['countPosts'] = Post::currentCountry()
		// 	->where('user_id', Auth::user()->id)
		// 	->count();
		// $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
		// 	$query->currentCountry();
		// })->where('user_id', Auth::user()->id)
		// 	->count();

		// $data['countPostsVisits'] = $user->posts->sum('visits');
		// $data['countPosts'] = $user->userposts->count();
		// $data['countFavoritePosts'] = $user->savedPosts->count();


		// Meta Tags
		MetaTag::set('title', t('My account on :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();
		// return view('account.edit', $data);
		return view('account.my-data', $data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function showProfileLogo($type) {
		// return redirect(config('app.locale') . '/account/model-book/' . $id . '/edit');
		$userprofile = UserProfile::where('user_id', Auth::user()->id)->firstOrFail();
		$data['userprofile'] = $userprofile;
		$data['type'] = $type;
		return view('childs.img-zoom-popup', $data);
	}

	/**
	 * Delete profile logo.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function deleteProfileLogo() {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$user->profile->logo = null;
		$user->profile->save();
		$user->save();

		return redirect(config('app.locale') . '/' . trans('routes.profile-edit'));
	}

	/**
	 * Delete profile cover.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function deleteProfileCover() {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$user->profile->cover = null;
		$user->profile->save();
		$user->save();

		return redirect(config('app.locale') . '/' . trans('routes.profile-edit'));
	}

	/**
	 * @param UserRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */

	public function updateDetails(Request $request) {

		$req = $request->all();
		$validateArr = [ 
			'first_name' => 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/',
			'last_name' => 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/',
			'street' => 'required|street_validate',
			'zip' => 'required|regex:/^[A-Za-z0-9_ ]+$/',
			//'phone_code' => 'required',
			'phone' => 'required|mb_between:5,20',
			//'country' => 'required',
			'city' => 'required',
			'geburtstag' => 'required|before:tomorrow',
			'timezone' => 'required',
			'preferred_language' => 'required',
		];

		$fname_parent  = '';
		$lname_parent = '';
		
		if(isset($req['age']) && $req['age'] < 18){
			
			$validateArr['fname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
			$validateArr['lname_parent'] = 'required|mb_between:2,200|regex:/^[A-Za-z\s]+$/';
			$fname_parent  = $request->input('fname_parent');
			$lname_parent  = $request->input('lname_parent');
		}

		if(Auth::check() && (Gate::allows('premium_country_free_user', auth()->user()) || Gate::allows('premium_country_paid_user', auth()->user()))  ) {
            $validateArr['phone_code'] = 'required';
            $validateArr['country'] = 'required';
        }

		$age = date("Y") - date("Y", strtotime($request->input('geburtstag')));

		$this->validate($request, $validateArr);

		// Get User
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$is_free_model = false;
		// if(\App\Helpers\CommonHelper::checkUserType(config('constant.country_free'))){
		if(!Gate::allows('update_profile', auth()->user())) {
            $is_free_model = true;
        }

		if(empty($user)){
			flash(t("user details not found"))->error();
			return redirect()->back();
		}
		
		// lang and latitude
		$countryname = $request->input('country_name');
		// commented city code
		// $cityname = $request->input('city_name');
		// $address = $request->input('address_1') . '+' . $request->input('city_name') . '+' . $request->input('postcode') . '+' . $request->input('country_name');
		$cityname = $request->input('city');
		$fullCityName =  $request->input('city');

		if(isset($cityname) && !empty($cityname)){
			$cityname = explode(',', $cityname);
			$cityname = ( count($cityname) > 0 && isset($cityname[0]) )? $cityname[0] : $request->input('city');
		}

		$geo_lat = $user->latitude;
		$geo_long = $user->longitude;
		$geo_state = $user->profile->geo_state;
		if(!empty($request->input('geo_state'))){
			$geo_state = $request->input('geo_state');
		}
		 
		$geo_city   =  $user->profile->city;
        $geo_country = $countryname;
        $geo_full = $user->profile->street.", ".$user->profile->zip.', '.$user->profile->city;
		$is_geo_update = false;
		
		if(!$is_free_model){
			if($user->profile->street != $request->input('street') || $user->country_code != $request->input('country') || $user->profile->city != $request->input('city') || $user->profile->zip != $request->input('zip'))
			{
				$is_geo_update = true;
				$street = $request->input('street');
				$zip = $request->input('zip');
				$city_name = $cityname;
				$country_name = $request->input('country_name');

				$address    = $street.", ".$zip.', '.$city_name.', '.$geo_state.', '.$country_name;
				$longlat = array();
				$address = urlencode ($address);
		 		
		 		$googleurl = config('app.g_latlong_url');
				$google_api_key_maps = config('app.latlong_api');

				// $url = $googleurl.$address.'&sensor=false&key='.$google_api_key_maps;
				$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$request->input('country').'&key='.$google_api_key_maps;

				// call get latitude longitude 
				$longlat = CommonHelper::getLatLong($url);
				// if invalid street and zip code, get latlong full city name
				if(empty($longlat)){

					$url = $googleurl.urlencode($fullCityName).'&sensor=false&language=en&components=country:'.$request->input('country').'&key='.$google_api_key_maps;
					// call get latlong
					$longlat = CommonHelper::getLatLong($url); 
				}
			    
				$geo_lat    =  isset($longlat['latitude'])? strval($longlat['latitude']) : '';
		        $geo_long   =  isset($longlat['longitude'])? strval($longlat['longitude']) : '';
		        $geo_city   =  isset($longlat['geo_city'])? $longlat['geo_city'] : $city_name;
		        $geo_state  =  isset($longlat['geo_state'])? $longlat['geo_state'] : $geo_state;
		        $geo_country = isset($longlat['geo_country'])? $longlat['geo_country'] : $country_name;
		        $geo_full = $street.", ".$zip.', '.$geo_city;
			}
		}

		//check gender
		$gender_id = config('constant.crm_female');

		if($user->gender_id){
			if($user->gender_id == config('constant.gender_male')){
				$gender_id = config('constant.crm_male');
			}
		}
		
		// Update user in CRM
		$req_arr = array(
			'action' => 'update', //required
			'wpusername' => $user->username, // required api
			'name' => $request->input('first_name'),
			'lname' => $request->input('last_name'),
			'email' => $user->email,
			'vp_name' => ($fname_parent) ? $fname_parent  : '',
			'vp_name_last' => ($lname_parent) ? $lname_parent  : '',
			'gender' => $gender_id,
			'tel_prefix' => (!$is_free_model)? $request->input('phone_code') : $user->phone_code,
			'tel' => $request->input('phone'),
			'birthday' => ($request->input('geburtstag')) ? date("Y-m-d", strtotime($request->input('geburtstag')))  : '',
			'type' => ($user->user_type_id == '2') ? 4 : 1,
			'timeZoneId' => $req['timezone'],
			'timeZoneName' => $req['timezone_name'],
		);
		
		if(!empty($request->input('preferred_language'))){
			$req_arr['locale'] = $request->input('preferred_language');
		}

		// if change city or street or zip, update CRM data
		if(!$is_free_model && $is_geo_update == true){
			
			$req_arr['street'] = addslashes($request->input('street'));
			$req_arr['zip'] = $request->input('zip');
			$req_arr['city'] = $city_name;
			$req_arr['country'] = (!$is_free_model)? $request->input('country') : $user->country_code;
			$req_arr['latitude'] = $geo_lat;
			$req_arr['longitude'] = $geo_long;
			$req_arr['geo_lat'] = $geo_lat;
			$req_arr['geo_long'] = $geo_long;
			$req_arr['geo_city'] = $city_name;
			$req_arr['geo_state'] = $geo_state;
			$req_arr['geo_country'] = $geo_country;
			$req_arr['geo_full'] = $geo_full;
		}

		$response = CommonHelper::go_call_request($req_arr);
		\Log::info('Request Array update', ['Request Array' => $req_arr]);
		
		$json = json_decode($response->getBody());
		\Log::info('Response Array', ['Response Array update' => $json]);

		if ($response->getStatusCode() == 200) {
			
			$body = (string) $response->getBody();
			if($body){	
				$user->phone = $request->input('phone');
				$user->profile->first_name = $request->input('first_name');
				$user->profile->last_name = $request->input('last_name');
				$user->profile->street = addslashes($request->input('street'));
				$user->profile->zip = $request->input('zip');
				$user->profile->city = $request->input('city');
				$user->profile->geo_state = $geo_state;
				$user->profile->birth_day = ($request->input('geburtstag')) ? date("Y-m-d", strtotime($request->input('geburtstag')))  : '';

				// if model is not from free country registrations then update the address
				if(!$is_free_model){
					$user->phone = $request->input('phone');
					$user->country_code = (!$is_free_model)? $request->input('country') : $user->country_code; 
					$user->profile->street = addslashes($request->input('street'));
					$user->phone_code = $request->input('phone_code');
					$user->profile->zip = $request->input('zip');
					$user->profile->city = $request->input('city');
				}
				
				$user->profile->preferred_language = $request->input('preferred_language');
				if($age < 18){
					$user->profile->fname_parent = $request->input('fname_parent');
					$user->profile->lname_parent = $request->input('lname_parent');	
				}else{
					$user->profile->fname_parent = "";
					$user->profile->lname_parent = "";
				}

				$user->latitude = $geo_lat;
				$user->longitude = $geo_long;
				$user->profile->timezone = $req['timezone'];
				
				$availability_time = '';
				$saveDataArr = array();

				// Start Available Time Code
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
					}
					
					// Send 'Available time' action to CRM
					$available_phone_arr = array(
						'action' => 'set_available_phone',
						'wpusername' => $user->username,
						'availPhone' => $availability_time,
					);
					
					$response = CommonHelper::go_call_request($available_phone_arr);
					\Log::info('Request Array', ['Request Array set_available_phone' => $available_phone_arr]);
					$json = json_decode($response->getBody());
					\Log::info('Response Array', ['Request Array set_available_phone' => $json]);

					// save available time
				    $user->profile->availability_time = $availability_time;
				}
				// save 
				$user->profile->save();
				$user->save();

				flash(t("Your details account has updated successfully"))->success();
				return redirect()->back();
			}
			else{
				
				flash(t("Something went wrong Please try again"))->error();
				return redirect()->back();
			}
		}else{
			flash(t("Something went wrong Please try again"))->error();
			return redirect()->back();
		}

		flash(t("Your details account has updated successfully"))->success();
		return redirect()->back();
		
		// $req_arr = array(
		// 	'action' => 'update', //required
		// 	'wpusername' => $user->username, // required api
		// 	'name' => $user->profile->first_name,
		// 	'lname' => $user->profile->last_name,
		// 	'email' => $user->email,
		// 	'street' => $user->profile->street,
		// 	'zip' => $request->input('postcode'),
		// 	'tel' => $user->phone,
		// 	'tel_prefix' => $user->phone_code,
		// 	'city' => $cityname,
		// 	'country' => $request->input('country'),
		// 	'latitude'=>$latitude,
		// 	'longitude'=>$longitude,
		// 	'type' => ($user->user_type_id == '2') ? 4 : 1,
		// 	'gender' => $gender_id,
		// 	'birthday' => ($request->input('geburtstag')) ? date("Y-m-d", strtotime($request->input('geburtstag')))  : '',
		// );

		// if($user->user_type_id == '2'){
		// 	$req_arr['url'] = $user->profile->website_url;
		// }
		
		// $response = CommonHelper::go_call_request($req_arr);
		// \Log::info('Request Array update', ['Request Array' => $req_arr]);
		// $json = json_decode($response->getBody());
		// \Log::info('Response Array', ['Response Array update' => $json]);

		// if ($response->getStatusCode() == 200) {
		// 	$body = (string) $response->getBody();
		// 	if ($body)
		// 	{
		// 		flash(t("Your details account has updated successfully"))->success();
		// 		return redirect()->back();
		// 	}
		// }else{
		// 	flash(t("Something went wrong Please try again"))->error();
		// 	return redirect()->back();
		// }
		// echo $request->input('ad_firstname');exit;
		// $user_address = UserAddress::where('user_id', Auth::user()->id)->first();
		// if (empty($user_address)) {
		// 	$user_address = new UserAddress();
		// }
		// $user_address->address_type = ($request->input('address_type')) ? $request->input('address_type') : 1;
		// $user_address->first_name = $request->input('ad_firstname');
		// $user_address->email = $request->input('ad_email');
		// $user_address->phone = $request->input('ad_phone');
		// $user_address->address_line1 = $request->input('ad_address_1');
		// $user_address->address_line2 = $request->input('ad_address_2');
		// $user_address->post_code = $request->input('ad_postcode');
		// $user_address->city = $request->input('ad_town');
		// $user_address->country = $request->input('ad_county');
		// $user_address->user_id = Auth::user()->id;
		// $user_address->save();

		// flash(t("Your details account has updated successfully"))->success();
		// // Redirection
		// return redirect()->back();

		// this is a old code line
		//return redirect(config('app.locale') . '/account');

		// // Check if these fields has changed

		// if (Auth::user()->user_type_id == 3) {
		// 	$parent_category = implode(',', $request->parent);
		// } else {
		// 	$parent_category = 0;
		// }

		// $emailChanged = $request->filled('email') && $request->input('email') != Auth::user()->email;
		// $phoneChanged = $request->filled('phone') && $request->input('phone') != Auth::user()->phone;
		// $usernameChanged = $request->filled('username') && $request->input('username') != Auth::user()->username;

		// // Conditions to Verify User's Email or Phone
		// $emailVerificationRequired = config('settings.mail.email_verification') == 1 && $emailChanged;
		// $phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $phoneChanged;

		// // Get User
		// $user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		// // Update User's Data
		// if (empty(Auth::user()->user_type_id) || Auth::user()->user_type_id == 0) {
		// 	$user->user_type_id = $request->input('user_type');
		// } else {
		// 	$user->gender_id = $request->input('gender');
		// 	// $user->name = $request->input('name');
		// 	// $user->country_code = $request->input('country');
		// 	if ($phoneChanged) {
		// 		$user->phone = $request->input('phone');
		// 	}
		// 	$user->phone_hidden = $request->input('phone_hidden');
		// 	if ($emailChanged) {
		// 		$user->email = $request->input('email');
		// 	}
		// 	if ($usernameChanged) {
		// 		$user->username = $request->input('username');
		// 	}
		// 	$user->receive_newsletter = $request->input('receive_newsletter');
		// 	$user->receive_advice = $request->input('receive_advice');

		// 	$user->profile->first_name = $request->input('first_name');
		// 	$user->profile->last_name = $request->input('last_name');
		// 	$user->profile->birth_day = $request->input('cs_birthday_birthDay');
		// 	$user->profile->fname_parent = $request->input('fname_parent');
		// 	$user->profile->lname_parent = $request->input('lname_parent');
		// 	$user->profile->category_id = $request->input('category') ? $request->input('category') : 0;
		// 	$user->profile->allow_search = $request->input('allow_search') ? $request->input('allow_search') : 0;
		// 	$user->profile->description = $request->input('description');

		// 	$user->profile->tfp = $request->input('tfp') ? $request->input('tfp') : 0;

		// 	$user->profile->facebook = $request->input('facebook');
		// 	$user->profile->twitter = $request->input('twitter');
		// 	$user->profile->google_plus = $request->input('google_plus');
		// 	$user->profile->linkedin = $request->input('linkedin');
		// 	$user->profile->instagram = $request->input('instagram');

		// 	$user->profile->street = $request->input('street');
		// 	$user->profile->city = $request->input('city');
		// 	$user->profile->country = $request->input('country');
		// 	$user->profile->zip = $request->input('zip');
		// 	$user->profile->website_url = $request->input('website');

		// 	$user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
		// 	$user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
		// 	$user->profile->chest_id = $request->input('chest') ? $request->input('chest') : 0;
		// 	$user->profile->waist_id = $request->input('waist') ? $request->input('waist') : 0;
		// 	$user->profile->hips_id = $request->input('hips') ? $request->input('hips') : 0;
		// 	$user->profile->size_id = $request->input('dressSize') ? $request->input('dressSize') : 0;
		// 	$user->profile->hair_color_id = $request->input('hairColor') ? $request->input('hairColor') : 0;
		// 	$user->profile->skin_color_id = $request->input('skinColor') ? $request->input('skinColor') : 0;
		// 	$user->profile->eye_color_id = $request->input('eyeColor') ? $request->input('eyeColor') : 0;
		// 	$user->profile->shoes_size_id = $request->input('shoeSize') ? $request->input('shoeSize') : 0;
		// 	$user->profile->piercing = $request->input('piercing') ? $request->input('piercing') : 0;
		// 	$user->profile->tattoo = $request->input('tattoo') ? $request->input('tattoo') : 0;
		// 	$user->profile->parent_category = $parent_category ? $parent_category : 0;

		// 	if ($request->hasFile('profile.logo')) {
		// 		$user->profile->logo = $request->file('profile.logo');
		// 	}

		// 	if ($request->hasFile('profile.cover')) {
		// 		$user->profile->cover = $request->file('profile.cover');
		// 	}

		// }

		// // Email verification key generation
		// if ($emailVerificationRequired) {
		// 	$user->email_token = md5(microtime() . mt_rand());
		// 	$user->verified_email = 0;
		// }

		// // Phone verification key generation
		// if ($phoneVerificationRequired) {
		// 	$user->phone_token = mt_rand(100000, 999999);
		// 	$user->verified_phone = 0;
		// }

		// // Don't logout the User (See User model)
		// if ($emailVerificationRequired || $phoneVerificationRequired) {
		// 	session(['emailOrPhoneChanged' => true]);
		// }

		// // Save User
		// $user->save();
		// $user->profile->save();

		// // Message Notification & Redirection
		// flash(t("Your details account has updated successfully"))->success();
		// $nextUrl = config('app.locale') . '/account';

		// // Send Email Verification message
		// if ($emailVerificationRequired) {
		// 	$this->sendVerificationEmail($user);
		// 	$this->showReSendVerificationEmailLink($user, 'user');
		// }

		// // Send Phone Verification message
		// if ($phoneVerificationRequired) {
		// 	// Save the Next URL before verification
		// 	session(['itemNextUrl' => $nextUrl]);

		// 	$this->sendVerificationSms($user);
		// 	$this->showReSendVerificationSmsLink($user, 'user');

		// 	// Go to Phone Number verification
		// 	$nextUrl = config('app.locale') . '/verify/user/phone/';
		// }

		// // Redirection
		// return redirect($nextUrl);
	}

	public function updateProfile(Request $request) {
		
		$req = $request->all();

		$validateArr = [
			// 'first_name' => 'required|mb_between:2,200|alpha',
			// 'last_name' => 'required|mb_between:2,200|alpha',
			// 'street' => 'required',
			// 'zip' => 'required',
			// 'phone' => 'required',
			// 'phone_code' => 'required',
			// 'geburtstag' => 'required|before:tomorrow',
			'description' => 'required',
			'height' => 'required',
			'weight' => 'required',
			'cloth_size' => 'required',
			'model_categories' => 'required',
			'shoe_size' => 'required',
			'eye_color' => 'required',
			'hair_color' => 'required',
			'skin_color' => 'required',
			// 'country' => 'required',
			// 'city' => 'required',
			'gender' => 'required',
			// 'categories' => 'required',
			'breast' => 'required',
			// 'waist' => 'required',
			// 'hip' => 'required',
			'piercing' => 'required',
			'tattoo' => 'required',

		];

		// if(isset($req['age']) && $req['age'] < 18){
		// 	$validateArr['fname_parent'] = 'required|mb_between:2,200|alpha';
		// 	$validateArr['lname_parent'] = 'required|mb_between:2,200|alpha';
		// }
		
		if(isset($req['instagram']) && !empty($req['instagram'])){
			$validateArr['instagram'] = 'url';
		}

		if(isset($req['instagram_followers_count']) && !empty($req['instagram_followers_count'])){
			$validateArr['instagram_followers_count'] = 'integer|numeric';
		}

		if(isset($req['facebook']) && !empty($req['facebook'])){
			$validateArr['facebook'] = 'url';
		}

		if(isset($req['linkedin']) && !empty($req['linkedin'])){
			$validateArr['linkedin'] = 'url';
		}

		if(isset($req['twitter']) && !empty($req['twitter'])){
			$validateArr['twitter'] = 'url';
		}

		if(isset($req['pintrest']) && !empty($req['pintrest'])){
			$validateArr['pintrest'] = 'url';
		}

		if(isset($req['personal_website']) && !empty($req['personal_website'])){
			$validateArr['personal_website'] = 'required|web_domain_valid|whitelist_domain|max:100';
		}

		// if ($request->hasFile('profile.logo')) {
		// 	$validateArr['profile.logo'] = 'required|mimes:' . getUploadFileTypes('file') . '|max:' . (int) config('settings.upload.max_file_size', 1000);
		// }

		$this->validate($request, $validateArr,[
			'description.required' => t('The introduction field is required')
		]);
		// Get User
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		if(empty($user)){
			flash(t("user details not found"))->error();
			return redirect()->back();
		}

		// $parent_category = 0;

		// if (Auth::user()->user_type_id == 3) {
			
		// 	if(isset($request->categories) && count($request->categories) > 0){
		// 		$parent_category = implode(',', $request->categories);
		// 	}else{
		// 		flash(t('category_required'))->error();
		// 		return \Redirect::back();
		// 	}
		// }
		
		// lang and latitude
		// $countryname = $request->input('country_name');
		// commented city code
		// $cityname = $request->input('city_name');
		// $address = $request->input('street') . '+' . $request->input('city_name') . '+' . $request->input('zip') . '+' . $request->input('country_name');
		// $cityname = $request->input('city');
		// $latitude = $user->latitude;
		// $longitude = $user->longitude;

		// if($user->profile->street != $request->input('street') || $user->country_code != $request->input('country') || $user->profile->city != $cityname || $user->profile->zip != $request->input('zip') )
		// {
		// 	$address = $request->input('street') . '+' . $cityname . '+' . $request->input('zip') . '+' . $request->input('country_name');
		// 	$googleurl = config('app.g_latlong_url');
		// 	$apikey = config('app.latlong_api');
		// 	$formattedAddr = str_replace(' ', '+', $address);
		// 	//Send request and receive json data by address
		// 	// $url = file_get_contents($googleurl . $formattedAddr . '&key=' . $apikey);
		// 	// $google_map = json_decode($url);

		// 	// if ($google_map->status == 'OK') {
		// 	// 	$latitude = str_replace(",", ".", $google_map->results[0]->geometry->location->lat);
		// 	// 	$longitude = str_replace(",", ".", $google_map->results[0]->geometry->location->lng);
		// 	// } else {
		// 	// 	// echo $response->status;
		// 	// 	$latitude = '';
		// 	// 	$longitude = '';
		// 	// }
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

        // $fname_parent = $lname_parent = '';
		// if(isset($req['age']) && $req['age'] < 18){
		// 	$fname_parent = $req['fname_parent'];
		// 	$lname_parent = $req['lname_parent'];
		// }

		$category_name = $user->profile->modelcategory->slug;

		if(isset($req['model_categories']) && !empty($req['model_categories'])){
			$category_name = ModelCategory::getModelCateogryName($req['model_categories'], 'slug');
		}

		$user_gender_id = (isset($req) && !empty($req['gender']))? $req['gender'] : $user->gender_id;

		$gender_id = config('constant.crm_female');
		if($user_gender_id == config('constant.gender_male')){
			$gender_id = config('constant.crm_male');
		}



		//save profile logo
		// if ($request->hasFile('profile.logo')) {
		// 	$user->profile->logo = $request->file('profile.logo');
		// 	$user->profile->save();
		// }

		// $user->phone_code = $request->input('phone_code');
		// $user->phone = $request->input('phone');
		// update user in CRM
		// $age = date("Y") - date("Y", strtotime($request->input('geburtstag')));
		$req_arr = array(
			'action' => 'update', //required
			'wpusername' => $user->username, // required api
			'name' => $user->profile->first_name,
			'lname' => $user->profile->last_name,
			'email' => $user->email,
			'street' => $user->profile->street,
			'zip' => $user->profile->zip,
			'city' => $user->profile->city,
			'country' => $user->country_code,
			'latitude'=>	$user->latitude,
			'longitude'=>	$user->longitude,
			'vp_name' => $user->profile->fname_parent,
			'vp_name_last' => $user->profile->lname_parent,
			'platform' => $category_name,
			'gender' => $gender_id,
			'tel_prefix' => $user->phone_code,
			'tel' => $user->phone,
			'birthday' => $user->profile->birth_day,
			'imglink' => \Storage::url(trim($user->profile->logo)),
			'type' => ($user->user_type_id == '2') ? 4 : 1,
		);

		$response = CommonHelper::go_call_request($req_arr);

		\Log::info('Request Array update', ['Request Array' => $req_arr]);
		$json = json_decode($response->getBody());
		//\Log::info('Response Array', ['Response Array update' => $json]);
		\Log::info('Response Array', ['Response status code' => $response->getStatusCode()]);


		if ($response->getStatusCode() == 200) {
			$body = (string) $response->getBody();
			if ($body)
			{

				if($user->is_profile_completed == 0){

					// Send 'funnel' action to CRM
					$funnel_arr = array(
						'action' => 'funnel',
						'page' => 'reg_profile_p',
						'wpusername' => $user->username,
						'status' => true,
						'verification_link' => ''
					);

					$response = CommonHelper::go_call_request($funnel_arr);
					//\Log::info('Request Array', ['Request Array funnel reg_profile_p' => $funnel_arr]);
					$json = json_decode($response->getBody());
					//\Log::info('Response Array', ['Request Array funnel reg_profile_p' => $json]);
				}	
				
				$category = $request->input('model_categories');

				// if ($request->hasFile('profile.logo')) {
				// 	$user->profile->logo = $request->file('profile.logo');
				// }

				if ($request->hasFile('profile.cover')) {
					$user->profile->cover = $request->file('profile.cover');
				}

				// $user->profile->parent_category = $parent_category;
				$user->profile->category_id = $category ? $category : 0;

				// $user->profile->username = ($request->input('username')) ? $request->input('username') : '';
				// $user->profile->street = ($request->input('street')) ? $request->input('street') : '';
				// $user->profile->zip = ($request->input('zip')) ? $request->input('zip') : '';
				// $user->profile->first_name = ($request->input('first_name')) ? $request->input('first_name') : '';
				// $user->profile->last_name = ($request->input('last_name')) ? $request->input('last_name') : '';
				// if($age < 18){
				// 	$user->profile->fname_parent = $request->input('fname_parent');
				// 	$user->profile->lname_parent = $request->input('lname_parent');	
				// }else{
				// 	$user->profile->fname_parent = "";
				// 	$user->profile->lname_parent = "";
				// }

				// $user->country_code = ($request->input('country')) ? $request->input('country') : '';
				// $user->profile->city = ($request->input('city')) ? $request->input('city') : '';
				// $user->profile->birth_day = ($request->input('geburtstag')) ? date("Y-m-d", strtotime($request->input('geburtstag')))  : '';
				$user->gender_id = ($request->input('gender')) ? $request->input('gender') : '';
				$user->profile->description = ($request->input('description')) ? addslashes($request->input('description')) : '';


				$personal_website = ($request->input('personal_website')) ? $request->input('personal_website') : '';
				
				if(!empty($personal_website)){
					
					$personal_website = preg_replace('/^(?!https?:\/\/)/', 'http://', $personal_website);
				}

				$user->profile->website_url = $personal_website;

				$user->profile->facebook = ($request->input('facebook')) ? $request->input('facebook') : '';
				$user->profile->twitter = ($request->input('twitter')) ? $request->input('twitter') : '';
				// $user->profile->google_plus = ($request->input('googleplus')) ? $request->input('googleplus') : '';
				$user->profile->google_plus = '';
				$user->profile->linkedin = ($request->input('linkedin')) ? $request->input('linkedin') : '';
				$user->profile->instagram = ($request->input('instagram')) ? $request->input('instagram') : '';
				$user->profile->instagram_followers_count = ($request->input('instagram_followers_count')) ? $request->input('instagram_followers_count') : '';
				$user->profile->pinterest = ($request->input('pintrest')) ? $request->input('pintrest') : '';

				$user->profile->height_id = $request->input('height') ? $request->input('height') : 0;
				$user->profile->chest_id = $request->input('breast') ? $request->input('breast') : 0;
				$user->profile->waist_id = $request->input('waist') ? $request->input('waist') : 0;
				$user->profile->hips_id = $request->input('hip') ? $request->input('hip') : 0;
				// $user->profile->waist_id = $request->input('size') ? $request->input('size') : 0;
				$user->profile->size_id = $request->input('cloth_size') ? $request->input('cloth_size') : 0;
				$user->profile->shoes_size_id = $request->input('shoe_size') ? $request->input('shoe_size') : 0;
				$user->profile->weight_id = $request->input('weight') ? $request->input('weight') : 0;
				$user->profile->eye_color_id = $request->input('eye_color') ? $request->input('eye_color') : 0;
				$user->profile->hair_color_id = $request->input('hair_color') ? $request->input('hair_color') : 0;
				$user->profile->skin_color_id = $request->input('skin_color') ? $request->input('skin_color') : 0;
				$user->profile->piercing = $request->input('piercing') ? $request->input('piercing') : 0;
				$user->profile->tattoo = $request->input('tattoo') ? $request->input('tattoo') : 0;
				// $user->latitude = $latitude;
				// $user->longitude = $longitude; 
				$user->is_profile_completed = '1';
				$user->save();
				$user->profile->save();

				$resume = Resume::where('user_id', auth()->user()->id)->orderByDesc('id')->first();
				if (empty($resume)) {

					// Save the Resume's File
					if ($request->hasFile('resume.filename')) {
						$resumeInfo = [
							'country_code' => config('country.code'),
							'user_id' => Auth::user()->id,
							'name' => $request->file('resume.filename')->getClientOriginalName(),
							'active' => 1,
						];
						$resume = new Resume($resumeInfo);
						$resume->save();

						$resume->filename = $request->file('resume.filename');
						$resume->save();
					}
				} else {
					// Save the Resume's File
					if ($request->hasFile('resume.filename')) {
						$resumeInfo = [
							'country_code' => config('country.code'),
							'user_id' => Auth::user()->id,
							'name' => $request->input('resume.filename'),
							'active' => 1,
						];
						// $resume = new Resume($resumeInfo);
						$resume->save();

						$resume->filename = $request->file('resume.filename');
						$resume->name = $request->file('resume.filename')->getClientOriginalName();
						$resume->save();
					}
				}

				// echo json_encode($data);

				flash(t("Your details account has updated successfully"))->success();
				return redirect(config('app.locale') . '/' . trans('routes.profile-edit'));
			}else{
				flash(t("Something went wrong Please try again"))->error();
				return redirect()->back();
			}
		}else{
			flash(t("Something went wrong Please try again"))->error();
			return redirect()->back();
		}

	}

	public function loadChangePassword() {
		 
		MetaTag::set('title', t('meta-change-password - :app_name', ['app_name' => config('app.app_name')]));
		CommonHelper::ogMeta();

		return view('account.change-password');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function updateSettings(Request $request) {
		$this->validate($request, [
			'old_password' => 'required',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required',
		]);

		//check old passowrd
		$datavalue = array(
			'password' => bcrypt($request->password),
		);
		$oldpasswords = $request->old_password;
		$matchpassword = User::find(Auth::user()->id)->password;
		if (\Hash::check($oldpasswords, $matchpassword)) {
			$check = User::where('id', Auth::user()->id)->update($datavalue);
			flash(t("Your password has changes successfully"))->success();
			// echo "here";exit;
			// return redirect(lurl(trans('routes.change-password'))); 

			$attr = ['countryCode' => config('app.locale')];
			return redirect(lurl(trans('routes.change-password', $attr), $attr));
			// redirect(config('app.locale') . '/' . trans('routes.change-password'));
		} else {
			// old password not match error
			$message = t("Incorrect :field", ['field' => t('old_password')]);
			flash($message)->error();
			return \Redirect::back();
		}
	}

	public function loadSystemSettings() {

		$user = User::find(Auth::user()->id);

		$settings = $user->system_settings;
		$system_settings = json_decode($settings, true);
		$data['system_settings'] = $system_settings;
		// print_r($system_settings);exit;
		return view('account.system-settings', $data);
	}

	public function updateSystemSettings(Request $request) {
		// Get User
		$user = User::find(Auth::user()->id);

		$language = ($request->input('data_select')) ? $request->input('data_select') : '';
		$message = ($request->input('message_radio')) ? $request->input('message_radio') : '';
		$invite = ($request->input('invite_radio')) ? $request->input('invite_radio') : '';
		$reminder = ($request->input('reminder_radio')) ? $request->input('reminder_radio') : '';

		$system_settings_data = array();
		if ($language != '') {
			$system_settings_data = $system_settings_data + array('language' => $language);
		}
		if ($message != '') {
			$system_settings_data = $system_settings_data + array('message' => $message);
		}
		if ($invite != '') {
			$system_settings_data = $system_settings_data + array('invite' => $invite);
		}
		if ($reminder != '') {
			$system_settings_data = $system_settings_data + array('reminder' => $reminder);
		}

		if (count($system_settings_data) > 0) {
			$system_settings = json_encode($system_settings_data);

			// Update
			$user->system_settings = $system_settings;
			$user->save();

			flash(t("Your settings account has updated successfully"))->success();
		}

		return redirect(config('app.locale') . '/system-settings');
	}

	public function loadWorkSettings() {
		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$userWorkSetting = UserWorkSetting::where('user_id' , Auth::user()->id)->first(); 
		
		$timing_list = array();
		$hourly_rate = '5';
		$job_distance = '50';
		$is_time_list = false; 
		$job_distance_type = '';

		if(!empty($userWorkSetting)){
			
			if(isset($userWorkSetting->job_time)){
				$job_time_settings = json_decode($userWorkSetting->job_time, true);
			}

			if(isset($userWorkSetting->hourly_rate)){
				$hourly_rate = $userWorkSetting->hourly_rate;
			}

			if(isset($userWorkSetting->job_distance)){
				$job_distance = $userWorkSetting->job_distance;
			}
			if(isset($userWorkSetting->job_time)){

				if (!empty($userWorkSetting->job_time)) {
					
					$timing_list = json_decode($userWorkSetting->job_time, true);

					if(isset($timing_list['job_time'])){

						if(count($timing_list['job_time']) > 0){

							for ($i = 0; $i < count($timing_list['job_time']); $i++) {

								$data['fromhrs'][] = ($timing_list['job_time'][$i]['from_hrs'] != '00:00') ? $timing_list['job_time'][$i]['from_hrs'] : '';
								$data['tohrs'][] = ($timing_list['job_time'][$i]['to_hrs'] != '00:00') ? $timing_list['job_time'][$i]['to_hrs'] : '';
							}
							$is_time_list = true;
						}
					}
				}
			}

			if(isset($userWorkSetting->job_distance_type)){
				$job_distance_type = $userWorkSetting->job_distance_type;
			}
		}

		if($is_time_list == false){
			$data['fromhrs'] = array();
			$data['tohrs'] = array();
			$data['fromhrs'] = ['1', '2', '3', '4', '5', '6', '7'];
			$data['tohrs'] = ['15', '16', '17', '18', '19', '20', '21'];
		}

		$data['work_settings'] = $timing_list;
		$data['hourly_rate'] = $hourly_rate;
		//$data['job_distance'] = $job_distance;
		//$data['job_distance_type'] = $job_distance_type;

		$user = User::find(Auth::user()->id);
		$data['currency_code'] = (isset($user->country->currency_code))? $user->country->currency_code : config('currency.code');
		
		$is_allow_search = 0;
		if(isset($user->profile->allow_search)){
			$is_allow_search = $user->profile->allow_search;
		}
		
		$data['work_status'] = $is_allow_search;


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

		$metaArr = [
			'title' => t('meta-work-settings - :app_name', ['app_name' => config('app.app_name')])
		];
		// get metatag
		CommonHelper::goModelMeta(auth()->user(), $metaArr);
		CommonHelper::ogMeta();

		return view('account.work-settings', $data);
	}

	public function updateWorkSettings(Request $request) {


		$rules = [
			'work_status' => 'required',
			// 'hourly_rate' => 'required|numeric',
			//'job_distance_type' => 'required',
			'job_categories' => 'required',
			//'job_distance_type' => 'required'
		];

		/*if($request->get('job_distance_type') === 'km_radius'){
			$rules['job_distance'] = 'required|numeric|max:100';
		}*/

		// if(!CommonHelper::checkUserType(config('constant.country_free'))){
		// 	// Get User validation
		// 	$this->validate($request, $rules);
		// }

		if (Gate::allows('update_profile', auth()->user())) {
            $this->validate($request, $rules);
        }

		// get user data
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		
		$userWorkSetting = UserWorkSetting::where('user_id' , Auth::user()->id)->first();

		if(empty($userWorkSetting)){
		 	$userWorkSetting = new UserWorkSetting();
		}

		// if(!CommonHelper::checkUserType(config('constant.country_free'))){
		if (Gate::allows('update_profile', auth()->user())) {
			// work status (allw_search in user profile)
			$work_status = ($request->work_status) ? $request->work_status : '0';

			if(isset($user->profile->allow_search)){
				$user->profile->allow_search = $work_status;
			}
		}
		

		$parent_category = 0;
		
		if(isset($request->job_categories) && count($request->job_categories) > 0){
			
			$parent_category = implode(',', $request->job_categories);
		}

		$user->profile->parent_category = $parent_category;

		//check it user newsletter status is changed then update crm
		if($user->receive_newsletter != $request->newsletter ){

			$req_news = array(
				'action' => 'newsletter_subscription', //required
				'wpusername' => $user->username, // required api
				'newsletter_value' => isset($request->newsletter)? $request->newsletter : 0,
			);

			\Log::info('Update CRM API for newsletter', ['user_status' => $req_news]);

			$resp_newsletter = CommonHelper::go_call_request($req_news);

			if ($resp_newsletter->getStatusCode() == 200) {
				$json = json_decode($resp_newsletter->getBody());
				\Log::info('Update User', ['newsletter_subscription' => $json]);
			}else{
				\Log::info('Something wrong to call newsletter_subscription', ['user_status' => $req_news]);
			}

			// update bugs_bug_text_table based on  *newsletter_subscription* response
			if ($resp_newsletter->getStatusCode() == 200) {

				//update newsletter settings in crm and profile
				$req_arr = array(
					'action' => 'update',
					'wpusername' => $user->username,
					'newsletter' => isset($request->newsletter)? $request->newsletter : 0,
				);

				$response = CommonHelper::go_call_request($req_arr);
				\Log::info('Request Array update', ['Request Array' => $req_arr]);
				
				$json = json_decode($response->getBody());
				\Log::info('Response Array', ['Response Array update' => $json]);
					

				$body = (string) $response->getBody();
				if($body){	
	 				$user->receive_newsletter = isset($request->newsletter)? $request->newsletter : 0;
	 				$user->save();
				}
			}
		}

		$user->profile->save();

		$job_time_list = array();
		$from_hrs = $request->input('from_hrs');
		$to_hrs = $request->input('to_hrs');
		$day = $request->input('day');

		for ($i = 0; $i < 7; $i++) {
			$job_time = array(
				'from_hrs' => (!empty($from_hrs[$i])) ? $from_hrs[$i] : '00:00',
				'to_hrs' => (!empty($to_hrs[$i])) ? $to_hrs[$i] : '00:00',
				'day' => (!empty($day[$i])) ? $day[$i] : '00:00',
			);
			array_push($job_time_list, $job_time);
		}

		$work_settings_data = array();
		//$job_time = '';
		if (!empty($job_time)) {
			$work_settings_data = $work_settings_data + array('job_time' => $job_time_list);
		}

		if (!empty($work_settings_data)) {
			$job_time = json_encode($work_settings_data);
		}

		$userWorkSetting->user_id = auth()->user()->id;
		//$userWorkSetting->hourly_rate = ($request->hourly_rate) ? $request->hourly_rate : '';

		// if(!CommonHelper::checkUserType(config('constant.country_free'))){
		if (Gate::allows('update_profile', auth()->user())) {
			$userWorkSetting->job_distance = ($request->job_distance) ? $request->job_distance : '';
			$userWorkSetting->job_distance_type = ($request->job_distance_type) ? $request->job_distance_type : '';
			$userWorkSetting->job_time = $job_time;
		}

		$save = $userWorkSetting->save();
		if($save){
			flash(t("Your settings account has updated successfully"))->success();
		}else{
			flash(t("Your settings account has update failed"))->error();
		} 

		return redirect(lurl(trans('routes.work-settings')));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updatePreferences() {
		$data = [];

		return view('account.edit', $data);
	}

	public function profile() {

		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		
		// $education = $user->profile->education;
		// $education = json_decode($education, true);
		
		$education = $user->userEducations;
		$education = isset($education)? $education->toArray() : [];

		// $experience = $user->profile->experience;
		// $experience = json_decode($experience, true);

		$experience = $user->userExperiences;
		$experience = isset($experience)? $experience->toArray() : [];

		// $talent = $user->profile->talent;
		// $talent = json_decode($talent, true);

		$talent = $user->userTalentes;
		$talent = isset($talent)? $talent->toArray() : [];

		// $reference = $user->profile->reference;
		// $reference = json_decode($reference, true);

		$reference = $user->userReferences;
		$reference = isset($reference)? $reference->toArray() : [];

		//$language = $user->profile->language;
		//$language = json_decode($language, true);


		$language = $user->userLanguages;
		$language = isset($language)? $language->toArray() : [];
	
		// fetch all languages from config.languages config file		
		$language_list = config('languages');


		$data = [];
		// Get ModelCategories
		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] =
		$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
			'children' => function ($query) {
				$query->trans();
			},
		])->orderBy('lft')->get();
		// echo "<pre>"; print_r ($data['modelCategories']); echo "</pre>"; exit();
		// Get Categories
		// $cacheId = 'categories.parentId.0.with.children' . config('app.locale');
		// $data['categories'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
		// 	$categories = Category::trans()->where('parent_id', 0)->with([
		// 		'children' => function ($query) {
		// 			$query->trans();
		// 		},
		// 	])->orderBy('lft')->get();
		// 	return $categories;
		// });
		// getting country list
		$data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		view()->share('countries', $data['countries']);

		$data['pagePath'] = t('profile');
		$data['education'] = $education;
		$data['experience'] = $experience;
		$data['talent'] = $talent;
		$data['reference'] = $reference;
		$data['language'] = $language;
		$data['language_list'] = $language_list;

		$validValues = ValidValue::all();
		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = (!empty($translate->value)) ? $translate->value : '';
		}

		//$unitArr = UnitMeasurement::getUnitMeasurement();
		//$property = array_merge($property, $unitArr);

		$country_code = isset($user->country->code) ? $user->country->code : '';

		$gender = isset($user->gender_id) ? $user->gender_id : '';

		$units = new UnitMeasurement($country_code);

		if($data['modelCategories']->count() > 0){
			
			foreach ($data['modelCategories'] as $key => $value) {
				
				if($user->profile->category_id == $value->id){
					
					if(in_array($value->slug, config('app.baby_model_slugs'))){
						$units->is_child_unit = true;
						break;
					}
				}
			}
		}

		if( isset($gender) && !empty($gender) ){
            switch ($gender) {
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
		$property = array_merge($property, $unitoptions);

		$data['properties'] = $property;
		$data['user'] = $user;
		// echo "<pre>"; print_r($user); exit();
		$data['genders'] = Gender::trans()->get();

		$resume = Resume::where('user_id', auth()->user()->id)->first();
		$data['resume'] = (!empty($resume)) ? $resume : '';
		// echo "<pre>";
		// print_r($data['resume']);
		// echo "</pre>";

		$profile_complete_percentage = 0;

		if (!empty($user->profile->logo)) {
			$profile_complete_percentage += 5;
		}
		if (!empty($user->profile->cover)) {
			$profile_complete_percentage += 5;
		}

		if (!empty($data['resume'])) {
			$profile_complete_percentage += 35;
		}

		if (!empty($user->profile->parent_category)) {
			$profile_complete_percentage += 2;
		}
		if (!empty($user->profile->category_id)) {
			$profile_complete_percentage += 2;
		}

		if (!empty($user->profile->first_name)) {
			$profile_complete_percentage += 2;
		}

		if (!empty($user->country_code)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($user->profile->city)) {
			$profile_complete_percentage += 1;
		}
		
		$birth_day = '';
		
		if (!empty($user->profile->birth_day)) {
			
			$profile_complete_percentage += 1;
			$birth_day = \App\Helpers\CommonHelper::getShowDate($user->profile->birth_day);
		}

		if (!empty($user->profile->facebook)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($user->profile->twitter)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($user->profile->website_url)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($user->profile->linkedin)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($user->profile->pinterest)) {
			$profile_complete_percentage += 1;
		}

		if (!empty($talent)) {
			$profile_complete_percentage += 8;
		}
		// if (!empty($user->profile->language)) {
		// 	$profile_complete_percentage += 8;
		// }
		if (!empty($language)) {
			$profile_complete_percentage += 8;
		}
		if (!empty($experience)) {
			$profile_complete_percentage += 9;
		}
		if (!empty($reference)) {
			$profile_complete_percentage += 8;
		}
		if (!empty($education)) {
			$profile_complete_percentage += 8;
		}

		$data['birth_day'] = $birth_day;
		$data['profile_complete_percentage'] = $profile_complete_percentage;

		// get metatag
		CommonHelper::goModelMeta($user);

		// return view('account.profile.profile', $data);
		return view('model/model-profile-edit', $data);
	}

	public function favorite($id) {

		$favorite = Favorite::where('user_id', Auth::user()->id)->where('fav_user_id', $id)->count();
		if ($favorite) {
			$result = Favorite::where('user_id', Auth::user()->id)->where('fav_user_id', $id)->delete();

		} else {
			$coupon = new Favorite;
			$coupon->user_id = Auth::user()->id;
			$coupon->fav_user_id = $id;
			$result = $coupon->save();
		}

		return $res = ['status' => $result];
		// return redirect()->back();
	}

	public function userView($slug = '') {
		
		$user = '';
		$data = array();
		if(!empty($slug)){
		 	$user = User::withoutGlobalScopes([VerifiedScope::class])->where('username', $slug)->first();
		}else{
			$user = User::withoutGlobalScopes([VerifiedScope::class])->where('id', Auth::user()->id)->first();
		}
		
		if(empty($user)){
			return $data;
		}

		$id = "";
		
		if( isset($user) && !empty($user) ){
			$id = $user->id;
		}
		
		$posts = array();

		if (\Auth::check()) {
			$posts = Post::getUserPostById(Auth::user()->id, 'model_post', null, $user);
		}


		if(Auth::user()->user_type_id == config('constant.partner_type_id') && $user->user_type_id == config('constant.model_type_id')){

		 	$to_user = $user->id;

		 	$is_direct_message = Message::where('message_type', 'Direct Message')
					->whereNull('deleted_at')
					->where(function ($query) use( $to_user ){
                                            $query->where('messages.to_user_id', $to_user)->Where('messages.from_user_id', Auth::user()->id);
                                        })
                                        ->orwhere(function ($query) use( $to_user ){
                                            $query->where('messages.to_user_id', Auth::user()->id)->Where('messages.from_user_id', $to_user);
                                        })
					->select('*')
					->first();

			
		 }
		
		//$education = $user->profile->education;
		//$education = json_decode($education, true);
		
		//$experience = $user->profile->experience;
		//$experience = json_decode($experience, true);
		
		// $talent = $user->profile->talent;
		// $talent = json_decode($talent, true);
		
		//$reference = $user->profile->reference;
		//$reference = json_decode($reference, true);
		
		// $language = $user->profile->language;
		// $language = json_decode($language, true);

		$education = $user->userEducations;
		if( isset($education) && !empty($education) && count($education) > 0 ){
			$education = $education->toArray();
		}else{
			$education  = [];
		}

		$experience = $user->userExperiences;
		if( isset($experience) && !empty($experience) && count($experience) > 0 ){
			$experience = $experience->toArray();
		}else{
			$experience  = [];
		}


		$talent = $user->userTalentes;
		if( isset($talent) && !empty($talent) && count($talent) > 0 ){
			$talent = $talent->toArray();
		}else{
			$talent  = [];
		}

		$reference = $user->userReferences;
		if( isset($reference) && !empty($reference) && count($reference) > 0 ){
			$reference = $reference->toArray();
		}else{
			$reference  = [];
		}

		$language = $user->userLanguages;
		if( isset($language) && !empty($language) && count($language) > 0 ){
			$language = $language->toArray();
		}else{
			$language  = [];
		}

		$property = [];

		$validValues = ValidValue::all();

		// query for get all post of this perticular user
		$postlist = Post::where('user_id', Auth::user()->id)->get();

		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = !empty($translate->value) ? $translate->value : '';
		}

		//$unitArr = UnitMeasurement::getUnitMeasurement();
		//$property = array_merge($property, $unitArr);

		$is_baby_category = false;

		if(isset($user->profile->modelcategory) && $user->profile->modelcategory->is_baby_model == 1){
			$is_baby_category = true;
		}

		$unitArr = new UnitMeasurement();

		$unitArr->is_women_unit = (config('constant.gender_female') == $user->gender_id)? true : false;
		$unitArr->is_men_unit = (config('constant.gender_male') == $user->gender_id)? true : false;
		$unitArr->is_child_unit = ($is_baby_category)? true : false;

		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);


		$favorite = Favorite::where('user_id', Auth::user()->id)->where('fav_user_id', $id)->count();
		$data = [];
		$albums = array(); 
		if($user->user_type_id == 2){
			$albums = Albem::where('user_id', $user->id)->where('active', '1')->select('filename')->get();
		}

		$dress_size = 0;
		$shoe_size = 0;
		$modelCat = '';
		$is_baby_model = 0;

		// get dress size and shoe size
		// if($user->user_type_id == 3){

		// 	$dress_size_unit_alias = config('app.units_alias');
		// 	$dress_size_unit_cat_alias = "";

		// 	$shoe_size_unit_alias = config('app.units_alias');
		// 	$shoe_size_unit_cat_alias = "";

		// 	// get model category name by category id
		// 	if(!empty($user->profile->category_id)){
				
		// 		$modelCat = ModelCategory::withoutGlobalScopes([ActiveScope::class])->select('name','is_baby_model')->where('id', $user->profile->category_id)->first();
		// 	}

		// 	if(!empty($modelCat) && isset($modelCat->is_baby_model)){
	 		
	 // 			$is_baby_model = $modelCat->is_baby_model;
	 // 		}

	 // 		if($is_baby_model == 1){
							
		// 		$dress_size_unit_cat_alias = config('app.kid_alias');
		// 		$shoe_size_unit_cat_alias = config('app.kid_alias');
	 // 		}

	 // 		if($is_baby_model != 1 && $user->gender_id == config('constant.gender_male')){
				 			
	 // 			$dress_size_unit_cat_alias = config('app.women_alias');
	 // 			$shoe_size_unit_cat_alias = config('app.women_alias');
	 // 		}

	 // 		if($is_baby_model != 1 && $user->gender_id == config('constant.gender_female')){
				 			
	 // 			$dress_size_unit_cat_alias = config('app.women_alias');
	 // 			$shoe_size_unit_cat_alias = config('app.women_alias');
	 // 		}

	 // 		if(isset($user->country->dress_size_unit) && !empty($user->country->dress_size_unit) && $user->country->dress_size_unit != null ){

	 // 			$dress_size_unit_code = $user->country->dress_size_unit;
		// 	}else{

		// 		$dress_size_unit_code = config('default_units_country');
		// 		$dress_size_unit_cat_alias = "";
		// 	}

		// 	$dress_column = $dress_size_unit_code.$dress_size_unit_alias.$dress_size_unit_cat_alias;

		// 	if(!empty($user->profile->size_id)){

		// 		$dressSizeunits = UserDressSizeOptions::select($dress_column)->where('id' , $user->profile->size_id)->first();

		// 		if(isset($dressSizeunits->$dress_column)){
		// 			$dress_size = $dressSizeunits->$dress_column;
		// 		}
		// 	}

		// 	if(isset($user->country->shoe_units) && !empty($user->country->shoe_units) && $user->country->shoe_units != null ){

	 // 			$shoe_size_unit_code = $user->country->shoe_units;
		// 	}else{

		// 		$shoe_size_unit_code = config('default_units_country');
		// 		$shoe_size_unit_cat_alias = "";
		// 	}

		// 	$shoe_column = $shoe_size_unit_code.$shoe_size_unit_alias.$shoe_size_unit_cat_alias;

		// 	if(!empty($user->profile->shoes_size_id)){

		// 		$shoeSizeunits = UserShoesUnitsOptions::select($shoe_column)->where('id' , $user->profile->shoes_size_id)->first();

		// 		if(isset($shoeSizeunits->$shoe_column)){
		// 			$shoe_size = $shoeSizeunits->$shoe_column;
		// 		}
		// 	}
		// }

		// commented city code
		// $city_name = City::select('name')->where('id', $user->profile->city)->first();
		$data['language_list'] = config('languages');
		$data['language'] = $language;
		$data['album'] = $albums;
		$data['user_id'] = $id; // model id
		$data['postlist'] = $postlist;
		$data['favorite'] = $favorite; // check if model is favourite return 1 if not return 0
		$data['model_id'] = $id;
		$data['birth_day'] = $user->profile->birth_day;

		// $from = new \DateTime($user->profile->birth_day);
		// $to = new \DateTime('today');
		// //$data['age'] = $from->diff($to)->y;

		// if($from->diff($to)->y > 0 ){
		// 	$y = $from->diff($to)->y;
		// 	$data['age'] =  ($y)? ($y > 0 )? $y.' '.t('years') : $y.' '.t('year')  : '';
		// }elseif($from->diff($to)->m > 0){
		// 	$m = $from->diff($to)->m;
		// 	$data['age'] =  ($m)? ($m > 0 )? $m.' '.t('months') : $m.' '.t('month') : '';
		// }else{
		// 	$d = $from->diff($to)->d;
		// 	$data['age'] =  ($d)? ($d > 0 )? $d.' '.t('days') : $m.' '.t('day') : '' ;
		// }


		$data['height'] = $user->profile->height_id > 0 ? (isset($property['height'][$user->profile->height_id])? $property['height'][$user->profile->height_id] : '' ) : '';

		$data['weight'] = $user->profile->weight_id > 0 ? (isset($property['weight'][$user->profile->weight_id])? $property['weight'][$user->profile->weight_id] : '' ) : '';

		$data['chest'] = $user->profile->chest_id > 0 ? (isset($property['chest'][$user->profile->chest_id])? $property['chest'][$user->profile->chest_id] : '' ) : '';
		//$data['chest'] = $user->profile->chest_id > 0 ? $user->profile->chest_id : '';

		$data['eye_color'] = $user->profile->eye_color_id > 0 ? (isset($property['eye_color'][$user->profile->eye_color_id])? $property['eye_color'][$user->profile->eye_color_id] : '' ) : '';

		$data['waist'] = $user->profile->waist_id > 0 ? (isset($property['waist'][$user->profile->waist_id])? $property['waist'][$user->profile->waist_id] : '' ) : '';
		// $data['waist'] = $user->profile->waist_id > 0 ? $user->profile->waist_id : '';

		$data['hair_color'] = $user->profile->hair_color_id > 0 ? (isset($property['hair_color'][$user->profile->hair_color_id])? $property['hair_color'][$user->profile->hair_color_id] : '' ) : '';

		$data['hip'] = $user->profile->hips_id > 0 ? (isset($property['hips'][$user->profile->hips_id])? $property['hips'][$user->profile->hips_id] : '' ) : '';
		// $data['hip'] = $user->profile->hips_id > 0 ? $user->profile->hips_id : '';
		
		$data['piercing'] = $user->profile->piercing > 0 ? $user->profile->piercing : '';
		
		$data['dress_size'] = $user->profile->size_id > 0 ? (isset($property['dress_size'][$user->profile->size_id])? $property['dress_size'][$user->profile->size_id] : '' ) : '';

		//$data['dress_size'] = $dress_size;
		
		$data['tattoo'] = $user->profile->tattoo > 0 ? $user->profile->tattoo : '';
		
		$data['skin_color'] = $user->profile->skin_color_id > 0 ? (isset($property['skin_color'][$user->profile->skin_color_id])? $property['skin_color'][$user->profile->skin_color_id] : '' ) : '';

		$data['shoe_size'] = $user->profile->shoes_size_id > 0 ? (isset($property['shoe_size'][$user->profile->shoes_size_id])? $property['shoe_size'][$user->profile->shoes_size_id] : '' ) : '';

		//$data['shoe_size'] = $shoe_size;

		$data['education'] = $education;
		$data['experience'] = $experience;
		$data['talent'] = $talent;
		$data['awards'] = $reference;
		$modelbooks = ModelBook::where('user_id', $user->id)->get();
		$data['modelbooks'] = $modelbooks;
		$sedcards = Sedcard::where('user_id', $user->id)->get();
		$data['sedcards'] = $sedcards;
		$data['profile'] = $user->profile;
		$data['user_type_id'] = $user->user_type_id;
		$data['active'] = $user->active;
		$data['parent'] = explode(',', $user->profile->parent_category);
		$data['category'] = $user->profile->category_id;
		$data['logo'] = $user->profile->logo;
		// $data['country'] = $user->profile->country;

		$data['country'] = ($user->country_name) ? $user->country_name : '';
		// ($user->country_code) ? CountryLocalization::getCountryNameByCode($user->country_code) : '';
		// commented city code
		// $data['city'] = ($city_name) ? $city_name->name : "";
		$city_name = '';
		if(isset($user->profile->city) && !empty($user->profile->city)){
			$city_name = explode(',', $user->profile->city);
			$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
		}

		$data['city'] = $city_name;
		$data['facebook'] = $user->profile->facebook;
		$data['twitter'] = $user->profile->twitter;
		$data['google_plus'] = $user->profile->google_plus;
		$data['linkedin'] = $user->profile->linkedin;
		$data['instagram'] = $user->profile->instagram;
		$data['pinterest'] = $user->profile->pinterest;
		$data['website_url'] = $user->profile->website_url;
		
		
		$userWorkSetting = '';
		$timing_list = array();

		if($user->user_type_id != 2){
			$userWorkSetting = UserWorkSetting::where('user_id' , $user->id)->first();
			if(!empty($userWorkSetting)){
				if(isset($userWorkSetting->job_time) && !empty($userWorkSetting->job_time)){
					$timing_list = json_decode($userWorkSetting->job_time, true);
				}
			}
		}
		
		$data['work_settings'] = $userWorkSetting;
		$data['fromhrs'] = array();
		$data['tohrs'] = array();
		$is_time_list = false;

		// $currency_symbol = (isset($user->country->currency->html_entity)? $user->country->currency->html_entity : isset($user->country->currency->font_arial) ) ? $user->country->currency->font_arial : config('currency.symbol');

		$currency_symbol = "";

		if(isset($user->country->currency->html_entity)){
			$currency_symbol = $user->country->currency->html_entity;
		}else if(isset($user->country->currency->font_arial)){
			$currency_symbol = $user->country->currency->font_ariall;
		}else{
			$currency_symbol = config('currency.symbol');
		}

		
		$data['currency_symbol'] = !empty($currency_symbol)? $currency_symbol : '';
		$data['in_left'] = isset($user->country->currency->in_left) ? $user->country->currency->in_left : '';
		
		if(isset($timing_list['job_time'])){

			if(count($timing_list['job_time']) > 0){

				for ($i = 0; $i < count($timing_list['job_time']); $i++) {

					$data['fromhrs'][] = ($timing_list['job_time'][$i]['from_hrs'] != '00:00') ? $timing_list['job_time'][$i]['from_hrs'] : '';
					$data['tohrs'][] = ($timing_list['job_time'][$i]['to_hrs'] != '00:00') ? $timing_list['job_time'][$i]['to_hrs'] : '';
				}
				$is_time_list = true;
			}
		}

		if($is_time_list == false){ 
			$data['fromhrs'] = ['1', '2', '3', '4', '5', '6', '7'];
			$data['tohrs'] = ['15', '16', '17', '18', '19', '20', '21'];
		}
		
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

		$data['categories_list'] = array();
		if(isset($data['categories']) && !empty($data['categories']) && $data['categories']->count() > 0 ){
			$data['categories_list'] = $data['categories']->pluck('name', 'id');
		}

		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] =
		$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
			'children' => function ($query) {
				$query->trans();
			},
		])->orderBy('lft')->get();
		// echo "<pre>"; print_r ($data['modelCategories']); echo "</pre>"; exit();
		if ($user->user_type_id == 2) {
			$data['partner'] = $user;
		}

		$resume = Resume::where('user_id', $id)->where('active', '1')->orderByDesc('id')->first();

		$data['resume'] = '';
		if (!empty($resume) && !empty($resume->filename)) {
			// $resume = $this->resumes->paginate(1);
			$data['resume'] = $resume->filename;
		}
		//dd($resume->filename);

		$data['user_name'] = $user->username;
		$data['first_name'] = $user->profile->first_name;
		$data['parent_name'] = $user->profile->fname_parent;

		$data['posts'] = isset($posts['posts']) ? $posts['posts'] : [];

		if (Auth::user()->user_type_id == 2) {
			$data['is_accept'] = Message::IsUserAccept(Auth::user()->id, $data['model_id']);
		}
		// Increment User visits counter
		Event::dispatch(new UserWasVisited($user));
		$data['user'] = $user;
		
		// get metatag
		CommonHelper::goModelMeta($user);
		return $data;
		// return view('account.userView', $data);
		// return view('model.public-profile', $data);
	}

	public function portfolio($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);
		$modelbooks = ModelBook::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate($this->perPage);

		$is_load_more_modelbook = false;
		if(!empty($modelbooks) && $modelbooks->count() > 0){

		   if($modelbooks->total() && $modelbooks->total() > $this->perPage){
		   		$is_load_more_modelbook = true;
		   }
		}
		
		$property = [];
		$validValues = ValidValue::all();
 		
 		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			if (!empty($translate)) {
				$property[$val->type][$val->id] = $translate->value;
			}
		}

		// $unitArr = UnitMeasurement::getUnitMeasurement();
		
		// query for get all post of this perticular user
		// $postlist = Post::where('user_id', Auth::user()->id)->get();

		$favorite = Favorite::where('user_id', Auth::user()->id)->where('fav_user_id', $id)->count();
		$data = [];

		$data['is_load_more_modelbook'] = $is_load_more_modelbook;

		// $albums = Albem::where('user_id', $user->id)->where('active', '1')->select('filename')->get();

		// commented city code
		// $city_name = City::select('name')->where('id', $user->profile->city)->first();

		// $data['album'] = $albums;
		$data['user_id'] = $id; // model id
		$data['user'] = $user;
		// $data['postlist'] = $postlist;
		$data['favorite'] = $favorite; // check if model is favourite return 1 if not return 0
		$data['model_id'] = $id;
		$data['birth_day'] = $user->profile->birth_day;

		// $from = new \DateTime($user->profile->birth_day);
		// $to = new \DateTime('today');
		// //$data['age'] = $from->diff($to)->y;
		
		// if($from->diff($to)->y > 0 ){
		// 	$y = $from->diff($to)->y;
		// 	$data['age'] =  ($y)? ($y > 0 )? $y.' '.t('years') : $y.' '.t('year')  : '';
		// }elseif($from->diff($to)->m > 0){
		// 	$m = $from->diff($to)->m;
		// 	$data['age'] =  ($m)? ($m > 0 )? $m.' '.t('months') : $m.' '.t('month') : '';
		// }else{
		// 	$d = $from->diff($to)->d;
		// 	$data['age'] =  ($d)? ($d > 0 )? $d.' '.t('days') : $m.' '.t('day') : '' ;
		// }

		$data['category'] = $user->profile->category_id;

		$data['modelbooks'] = $modelbooks;
		// print_r($modelbooks);exit;
		$data['profile'] = $user->profile;
		$data['user_type_id'] = $user->user_type_id;
		$data['active'] = $user->active;
		$data['parent'] = explode(',', $user->profile->parent_category);
		$data['logo'] = $user->profile->logo;

		$data['country'] = ($user->country_name) ? $user->country_name : '';
		$city_name = '';
		if(isset($user->profile->city) && !empty($user->profile->city)){
			$city_name = explode(',', $user->profile->city);
			$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
		}
		$data['city'] = $city_name;

		// $data['country'] = $user->profile->country;
		// $data['country'] = ($user->profile->country) ? CountryLocalization::getCountryNameByCode($user->profile->country) : '';
		// // $data['city'] = ($city_name) ? $city_name->name : "";
		// $data['city'] = ($user->profile->city) ? $user->profile->city : "";

		// if (is_array($user->work_settings)) {
		// 	$data['work_settings'] = !empty($user->work_settings) ? $user->work_settings : '';
		// } else {
		// 	$data['work_settings'] = !empty($user->work_settings) ? json_decode($user->work_settings, TRUE) : '';
		// }

		$userWorkSetting = '';
		$timing_list = array();

		if($user->user_type_id != 2){
			$userWorkSetting = UserWorkSetting::where('user_id' , $user->id)->first();
			if(!empty($userWorkSetting)){
				if(isset($userWorkSetting->job_time) && !empty($userWorkSetting->job_time)){
					$timing_list = json_decode($userWorkSetting->job_time, true);
				}
			}
		}
		
		$data['work_settings'] = $userWorkSetting;

		// $currency_symbol = ( isset($user->country->currency->html_entity) ? $user->country->currency->html_entity : isset($user->country->currency->font_arial)) ? $user->country->currency->font_arial : config('currency.symbol');

		$currency_symbol = "";

		if(isset($user->country->currency->html_entity)){
			$currency_symbol = $user->country->currency->html_entity;
		}else if(isset($user->country->currency->font_arial)){
			$currency_symbol = $user->country->currency->font_ariall;
		}else{
			$currency_symbol = config('currency.symbol');
		}

		
		$data['currency_symbol'] = !empty($currency_symbol)? $currency_symbol : '';
		$data['in_left'] = $user->country->currency->in_left;

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

		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] =
		$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
			'children' => function ($query) {
				$query->trans();
			},
		])->orderBy('lft')->get();

		if (Auth::User()->user_type_id == 2) {
			$data['partner'] = Auth::User();
		}

		$posts = array();
		if (\Auth::check() && Auth::User()->user_type_id == 2) {
			$posts = Post::getUserPostById(Auth::user()->id, 'model_post', null, $user);
		}

		$data['posts'] = isset($posts['posts']) ? $posts['posts'] : [];
		$data['user_name'] = $user->username;
		$data['first_name'] = $user->profile->first_name;
		$data['parent_name'] = $user->profile->fname_parent;

		// get metatag
		CommonHelper::goModelMeta($user);

		return view('model/public-profile-portfolio', $data);
	}

	public function sedcard($id) {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);
		$modelbooks = ModelBook::where('user_id', $user->id)->get();

		$sedcards = Sedcard::where('user_id', $user->id)->get();
		$property = [];
		$validValues = ValidValue::all();

		// query for get all post of this perticular user
		$postlist = Post::where('user_id', Auth::user()->id)->get();

		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			if (!empty($translate)) {
				$property[$val->type][$val->id] = $translate->value;
			}

		}

		

		// $unitArr = UnitMeasurement::getUnitMeasurement();
		// $property = array_merge($property, $unitArr);

		$unitArr = new UnitMeasurement();
		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);

		$favorite = Favorite::where('user_id', Auth::user()->id)->where('fav_user_id', $id)->count();
		$data = [];

		// $albums = Albem::where('user_id', $user->id)->where('active', '1')->select('filename')->get();
		// commented city code
		// $city_name = City::select('name')->where('id', $user->profile->city)->first();

		// $data['album'] = $albums;
		$data['user'] = $user;
		$data['user_id'] = $id; // model id
		$data['postlist'] = $postlist;
		$data['favorite'] = $favorite; // check if model is favourite return 1 if not return 0
		$data['model_id'] = $id;
		$data['birth_day'] = $user->profile->birth_day;
		
		// $from = new \DateTime($user->profile->birth_day);
		// $to = new \DateTime('today');
		// //$data['age'] = $from->diff($to)->y;
		// if($from->diff($to)->y > 0 ){
		// 	$y = $from->diff($to)->y;
		// 	$data['age'] =  ($y)? ($y > 0 )? $y.' '.t('years') : $y.' '.t('year')  : '';
		// }elseif($from->diff($to)->m > 0){
		// 	$m = $from->diff($to)->m;
		// 	$data['age'] =  ($m)? ($m > 0 )? $m.' '.t('months') : $m.' '.t('month') : '';
		// }else{
		// 	$d = $from->diff($to)->d;
		// 	$data['age'] =  ($d)? ($d > 0 )? $d.' '.t('days') : $m.' '.t('day') : '' ;
		// }
		
		$data['category'] = $user->profile->category_id;

		$data['modelbooks'] = $modelbooks;
		$data['sedcards'] = $sedcards;
		// print_r($modelbooks);exit;
		$data['profile'] = $user->profile;
		$data['user_type_id'] = $user->user_type_id;
		$data['active'] = $user->active;
		$data['parent'] = explode(',', $user->profile->parent_category);
		$data['logo'] = $user->profile->logo;

		$data['country'] = ($user->country_name) ? $user->country_name : '';

		$city_name = '';
		if(isset($user->profile->city) && !empty($user->profile->city)){
			$city_name = explode(',', $user->profile->city);
			$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
		}

		$data['city'] = $city_name;

		// $data['country'] = $user->profile->country;
		// $data['country'] = ($user->profile->country) ? CountryLocalization::getCountryNameByCode($user->profile->country) : '';
		// // commented city code
		// // $data['city'] = ($city_name) ? $city_name->name : "";
		// $data['city'] = ($user->profile->city) ? $user->profile->city : "";


		// if (is_array($user->work_settings)) {
		// 	$data['work_settings'] = !empty($user->work_settings) ? $user->work_settings : '';
		// } else {
		// 	$data['work_settings'] = !empty($user->work_settings) ? json_decode($user->work_settings, TRUE) : '';
		// }

		$userWorkSetting = '';
		$timing_list = array();

		if($user->user_type_id != 2){
			$userWorkSetting = UserWorkSetting::where('user_id' , $user->id)->first();
			if(!empty($userWorkSetting)){
				if(isset($userWorkSetting->job_time) && !empty($userWorkSetting->job_time)){
					$timing_list = json_decode($userWorkSetting->job_time, true);
				}
			}
		}
		
		$data['work_settings'] = $userWorkSetting;

		// $currency_symbol = ( isset($user->country->currency->html_entity) ? $user->country->currency->html_entity : isset($user->country->currency->font_arial)) ? $user->country->currency->font_arial : config('currency.symbol');

		$currency_symbol = "";

		if(isset($user->country->currency->html_entity)){
			$currency_symbol = $user->country->currency->html_entity;
		}else if(isset($user->country->currency->font_arial)){
			$currency_symbol = $user->country->currency->font_ariall;
		}else{
			$currency_symbol = config('currency.symbol');
		}

		
		
		$data['currency_symbol'] = !empty($currency_symbol)? $currency_symbol : '';
		$data['in_left'] = $user->country->currency->in_left;

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

		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] =
		$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
			'children' => function ($query) {
				$query->trans();
			},
		])->orderBy('lft')->get();

		if ($user->user_type_id == 2) {
			$data['partner'] = $user;
		}

		$posts = array();

		if (\Auth::check() && Auth::User()->user_type_id == 2) {
			$posts = Post::getUserPostById(Auth::user()->id, 'model_post', null, $user);
		}

		$data['posts'] = isset($posts['posts']) ? $posts['posts'] : [];
		$data['user_name'] = $user->username;
		$data['first_name'] = $user->profile->first_name;
		$data['parent_name'] = $user->profile->fname_parent;

		$model_category_slug = "";
		if(isset($user->profile) && isset($user->profile->modelcategory)){
			$model_category_slug = $user->profile->modelcategory->slug;
		}
		 
		$data['sedcard_title_1'] = (trans('global.'.$model_category_slug.'-sedcard-title-1') !== 'global.'.$model_category_slug.'-sedcard-title-1')? trans('global.'.$model_category_slug.'-sedcard-title-1') : trans('global.Portrait photo');

		$data['sedcard_title_2'] = (trans('global.'.$model_category_slug.'-sedcard-title-2') !== 'global.'.$model_category_slug.'-sedcard-title-2')? trans('global.'.$model_category_slug.'-sedcard-title-2') : trans('global.Full body photo');

		$data['sedcard_title_3'] = (trans('global.'.$model_category_slug.'-sedcard-title-3') !== 'global.'.$model_category_slug.'-sedcard-title-3')? trans('global.'.$model_category_slug.'-sedcard-title-3') : trans('global.Beauty Shot');

		$data['sedcard_title_4'] = (trans('global.'.$model_category_slug.'-sedcard-title-4') !== 'global.'.$model_category_slug.'-sedcard-title-4')? trans('global.'.$model_category_slug.'-sedcard-title-4') : trans('global.Outfit');

		$data['sedcard_title_5'] = (trans('global.'.$model_category_slug.'-sedcard-title-5') !== 'global.'.$model_category_slug.'-sedcard-title-5')? trans('global.'.$model_category_slug.'-sedcard-title-5') : trans('global.Free choice');

		// get metatag
		CommonHelper::goModelMeta($user);
		return view('model/public-profile-sedcard', $data);
	}

	public function portfolioGallery($id) {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);
		$modelbooks = ModelBook::where('user_id', $user->id)->get();
		$data['modelbooks'] = $modelbooks;
		return view('childs.img-zoom-popup', $data);
	}

	public function postEducation(Request $request) {

		$req = $request->all();
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		if(isset($req) && $req['action'] === 'add'){
			$userEducatation = new UserEducations();
		}else if(isset($req) && $req['action'] === 'update'){
			$userEducatation = UserEducations::find($req['id']);

			if(empty($userEducatation)){
				$response = array('error' => true, 'message' => t('There are no educations yet'), 'education' => []);
				$response = json_encode($response);
				return response()->json($response);
			}
		}

		$userEducatation->user_id = Auth::user()->id;
		$userEducatation->title = isset($req['title'])? trim($req['title']) : ''; 
		$userEducatation->from_date = isset($req['education_from_birthDay'])? trim($req['education_from_birthDay']) : ''; 
		$userEducatation->to_date  = isset($req['education_to_birthDay'])? trim($req['education_to_birthDay']) : '';
		$userEducatation->up_to_date = isset($req['up_to_date'])? trim($req['up_to_date']) : 0;
		$userEducatation->institute = isset($req['institute'])? trim($req['institute']) : '';
		$userEducatation->description = isset($req['description'])? strip_tags(trim($req['description'])) : '';

		$userEducatation->Save();

		if($userEducatation->id){

			$educations = $user->userEducations;

			if(isset($educations) && !empty($educations)){
				$educations = $educations->toArray();
			}else{
				$educations = [];
			}

			$data = [];
			$data['pagePath'] = t('profile');
			$response = array('error' => false, 'message' => t('Education added successfully'), 'education' => $educations);
			$response = json_encode($response);
			return response()->json($response);
		}

		
		// OLD CODE TO STORE USER EDUCATION IN JSON< NOW IT STORES IN "users_edcustions" TABLE

		// $user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		// $education = $user->profile->education;
		// $education = json_decode($education, true);
		// $edu = [];
		// $edu['title'] = $request->input('title');
		// $edu['from'] = $request->input('education_from_birthDay');
		// $edu['up_to_date'] = $request->input('up_to_date');
		// $edu['to'] = $request->input('education_to_birthDay');
		// $edu['institute'] = $request->input('institute');
		// $edu['description'] = !empty($request->input('description')) ? strip_tags($request->input('description')) : '';

		// if (!is_array($education)) {
		// 	$education = [];
		// }
		// if (isset($request->action) && $request->action == 'add') {
		// 	$len = sizeof($education);
		// } else {
		// 	$len = $request->input('id');
		// }

		// $education[$len] = $edu;
		// $saved_education = $education;
		// $education = json_encode($education);
		// $user->profile->education = $education;
		// $user->profile->save();

		// $data = [];
		// $data['pagePath'] = t('profile');
		// $response = array('error' => false, 'message' => t('Education added successfully'), 'education' => $saved_education);
		// $response = json_encode($response);
		// return response()->json($response);

		// return response()->json($education);
		// return redirect('account/profile');
	}

	public function createEducation() {
		$data = [];
		$data['pagePath'] = t('Add education');
		$data['id'] = false;
		$data['education'] = array();
		$data['selected_from_date'] = '';
		$data['selected_to_date'] = '';
		// return view('account.profile.education.create', $data);

		$returnHTML = view('childs.add-education-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		//return view('childs.add-education-popup', $data);
	}

	public function editEducation($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$education = UserEducations::where('user_id', Auth::user()->id)
			->where('id', $id)
			->first();

		if( isset($education) && !empty($education) ){
			$education = $education->toArray();
		}else{
			$education = [];
		}

		// $education = $user->profile->education;
		// $education = json_decode($education, true);
		
		$data = [];
		$data['pagePath'] = t('Update Education');
		$data['id'] = $id;
		$data['education'] = $education;
		$data['selected_from_date'] = '';
		$data['selected_to_date'] = '';

		if (isset($data['education']['from']) && !empty($data['education']['from'])) {
			$data['selected_from_date'] = $data['education']['from'];
		}
		if (isset($data['education']['to']) && !empty($data['education']['to'])) {
			$data['selected_to_date'] = $data['education']['to'];
		}

		// echo "<pre>"; print_r ($education); echo "</pre>"; exit();

		// if (!isset($data['education']['up_to_date']) || $data['education']['up_to_date'] == '1') {
		// 	$data['education']['to'] = date('Y-m-d');
		// 	$data['education']['up_to_date'] = '1';
		// }
		// return view('account.profile.education.edit', $data);
		$returnHTML = view('childs.add-education-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		//return view('childs.add-education-popup', $data);
	}

	public function deleteEducation($id) {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$userEducatation = UserEducations::where('user_id', Auth::user()->id)->where('id', $id)->first();

		$education = [];
		if( $education && !empty($education) ){
			$education = $education->toArray();
		}

		if(isset($userEducatation) && !empty($userEducatation)){
			if($userEducatation->delete()){
				$response = array('error' => false, 'message' => t('Education deleted successfully'), 'education' => []);
			}else{
				$response = array('error' => false, 'message' => t('There are no educations yet'), 'education' => []);
			}

			$education = $user->userEducations;

			if( $education && !empty($education) ){
				$education = $education->toArray();
			}

			$response['education'] = $education;
			$response = json_encode($response);
			return response()->json($response);
		}
		/*
		$education = $user->profile->education;
		$education = json_decode($education, true);
		if (is_array($education)) {
			array_splice($education, $id, 1);
			$saved_education = $education;
			$education = json_encode($education);
			$user->profile->education = $education;
			$user->profile->save();
		}*/

		/*if (count($saved_education) == 0) {
			$response = array('error' => false, 'message' => t('There are no educations yet'), 'education' => []);
		} else {
			$response = array('error' => false, 'message' => t('Education deleted successfully'), 'education' => $saved_education);
		}
		$response = json_encode($response);
		return response()->json($response);*/
		// return response()->json($education);
		// return redirect('account/profile');
	}

	public function postExperience(Request $request) {
			
		$req = $request->all();

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		if(isset($req) && $req['action'] === 'add'){
			$userExperience = new UserExperiences();
		}else if(isset($req) && $req['action'] === 'update'){
			$userExperience = UserExperiences::find($req['id']);

			if(empty($userExperience)){
				$response = array('error' => true, 'message' => t('There are no educations yet'), 'education' => []);
				$response = json_encode($response);
				return response()->json($response);
			}
		}

		$userExperience->user_id = Auth::user()->id;
		$userExperience->title = isset($req['title'])? trim($req['title']) : ''; 
		$userExperience->from_date = isset($req['experience_from_birthDay'])? trim($req['experience_from_birthDay']) : ''; 
		$userExperience->to_date  = isset($req['experience_to_birthDay'])? trim($req['experience_to_birthDay']) : '';
		$userExperience->up_to_date = isset($req['up_to_date'])? trim($req['up_to_date']) : 0;
		$userExperience->company = isset($req['company'])? trim($req['company']) : '';
		$userExperience->description = isset($req['description'])? strip_tags(trim($req['description'])) : '';



		$userExperience->Save();

		if($userExperience->id){

			$experience = $user->userExperiences;

			if(isset($experience) && !empty($experience)){
				$experience = $experience->toArray();
			}else{
				$experience = [];
			}

			$data = [];
			$data['pagePath'] = t('profile');
			$response = array('error' => false, 'message' => t('Experience added successfully'), 'experience' => $experience);
			$response = json_encode($response);
			return response()->json($response);
		}



		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$experience = $user->profile->experience;
		$experience = json_decode($experience, true);
		$edu = [];
		$action = $request->input('action');
		$edu['title'] = $request->input('title');
		$edu['from'] = $request->input('experience_from_birthDay');
		$edu['up_to_date'] = $request->input('up_to_date');
		$edu['to'] = $request->input('experience_to_birthDay');
		$edu['company'] = $request->input('company');
		$edu['description'] = ($request->input('description')) ? strip_tags($request->input('description')) : '';

		if (!is_array($experience)) {
			$experience = [];
		}
		if (isset($request->action) && $request->action == 'add') {
			$len = sizeof($experience);
		} else {
			$len = $request->input('id');
		}
		$experience[$len] = $edu;
		$saved_experience = $experience;
		$experience = json_encode($experience);
		$user->profile->experience = $experience;
		$user->profile->save();

		$data = [];
		$data['pagePath'] = t('profile');
		$response = array('error' => false, 'message' => t('Experience added successfully'), 'experience' => $saved_experience);
		$response = json_encode($response);
		return response()->json($response);*/
		// return redirect('account/profile');
	}

	public function createExperience() {
		$data = [];
		$data['pagePath'] = t('Add experience');
		$data['id'] = false;
		$data['selected_from_date'] = '';
		$data['selected_to_date'] = '';
		// return view('account.profile.experience.create', $data);
		
		$returnHTML = view('childs.add-experience-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		// return view('childs.add-experience-popup', $data);
	}

	public function editExperience($id) {
		
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$experience = UserExperiences::where('user_id', Auth::user()->id)
			->where('id', $id)
			->first();

		if( isset($experience) && !empty($experience) ){
			$experience = $experience->toArray();
		}else{
			$experience = [];
		}

		// $education = $user->profile->education;
		// $education = json_decode($education, true);
		
		$data = [];
		$data['pagePath'] = trans('global.Update experience');
		$data['id'] = $id;
		$data['experience'] = $experience;
		$data['selected_from_date'] = '';
		$data['selected_to_date'] = '';

		/*
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$experience = $user->profile->experience;
		$experience = json_decode($experience, true);
		$data = [];
		$data['pagePath'] = t('Update experience');
		$data['id'] = $id;
		$data['experience'] = $experience[$id];

		$data['selected_from_date'] = '';
		$data['selected_to_date'] = '';

		*/

		if (isset($data['experience']['from']) && !empty($data['experience']['from'])) {
			$data['selected_from_date'] = $data['experience']['from'];
		}
		if (isset($data['experience']['to']) && !empty($data['experience']['to'])) {
			$data['selected_to_date'] = $data['experience']['to'];
		}

		// if (!isset($data['experience']['up_to_date']) || $data['experience']['up_to_date'] == '1') {
		// 	$data['experience']['to'] = date('Y-m-d');
		// 	$data['experience']['up_to_date'] = '1';
		// }

		$returnHTML = view('childs.add-experience-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		// return view('childs.add-experience-popup', $data);
		// return view('account.profile.experience.edit', $data);
	}

	public function deleteExperience($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$userExperience = UserExperiences::where('user_id', Auth::user()->id)->where('id', $id)->first();

		$experience = [];
		if( $experience && !empty($experience) ){
			$experience = $experience->toArray();
		}

		if(isset($userExperience) && !empty($userExperience)){
			if($userExperience->delete()){
				$response = array('error' => false, 'message' => t('There are no experiences yet'), 'education' => []);
			}else{
				$response = array('error' => false, 'message' => t('Experience deleted successfully'), 'education' => []);
			}

			$experience = $user->userExperiences;

			if( $experience && !empty($experience) ){
				$experience = $experience->toArray();
			}

			$response['experience'] = $experience;
			$response = json_encode($response);
			return response()->json($response);
		}

		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$experience = $user->profile->experience;
		$experience = json_decode($experience, true);
		if (is_array($experience)) {
			array_splice($experience, $id, 1);
			$saved_experience = $experience;
			$experience = json_encode($experience);
			$user->profile->experience = $experience;
			$user->profile->save();
		}
		if (count($saved_experience) == 0) {
			$response = array('error' => false, 'message' => t('There are no experiences yet'), 'experience' => []);
		} else {
			$response = array('error' => false, 'message' => t('Experience deleted successfully'), 'experience' => $saved_experience);
		}
		$response = json_encode($response);
		return response()->json($response);*/
		// return redirect('account/profile');
	}

	public function postTalent(Request $request) {
		$talent = [];

		$req = $request->all();

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		if (isset($req) && !empty($req['title'])) {
			$userTalent = new UserTalents();
			$userTalent->user_id = Auth::user()->id;
			$userTalent->title = isset($req['title'])? $req['title'] : '';
			$userTalent->proportion = isset($req['proportion'])? $req['proportion'] : 0;
			$userTalent->save();
		}

		$talent = $user->userTalentes;

		if( isset($talent) && !empty($talent) ){
			$talent = $talent->toArray();
			$talent = json_encode($talent);
		}else{
			$talent = json_encode([]);
		}

		// if (isset($request->title) && !empty($request->title)) {
		// 	$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		// 	$talent = $user->profile->talent;
		// 	$talent = json_decode($talent, true);
		// 	$edu = [];
		// 	$edu['title'] = $request->input('title');
		// 	$edu['proportion'] = '';
		// 	// $edu['proportion'] = $request->input('proportion');
		// 	if (!is_array($talent)) {
		// 		$talent = [];
		// 	}

		// 	if (isset($request->create)) {
		// 		$len = sizeof($talent);
		// 	} else {
		// 		$len = $request->input('id');
		// 	}

		// 	$talent[$len] = $edu;
		// 	$talent = json_encode($talent);
		// 	$user->profile->talent = $talent;
		// 	$user->profile->save();
		// }

		$data = [];
		$data['pagePath'] = t('profile');
		return response()->json($talent);
		// return redirect('account/profile');
	}

	public function createTalent() {
		$data = [];
		$data['pagePath'] = t('Add talents');
		return view('account.profile.talent.create', $data);
	}

	public function editTalent($id) {
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$talent = $user->profile->talent;
		$talent = json_decode($talent, true);

		$data = [];
		$data['pagePath'] = t('Update talents');
		$data['id'] = $id;
		$data['talent'] = $talent[$id];
		return view('account.profile.talent.edit', $data);
	}

	public function deleteTalent($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		
		if(isset($id) && $id != 0){
			$talentObj = UserTalents::where('user_id', Auth::user()->id)->where('id', $id)->first();

			if( isset($talentObj) && !empty($talentObj) ){
				if($talentObj->delete()){
					$talent = $user->userTalentes;
					
					if( isset($talent) && !empty($talent) ){
						$talent = $talent->toArray();
						
						if(count($talent) > 0){
							$talent = json_encode($talent);
						}

					}else{
						$talent = [];
					}
				}
			}
		}

		// $talent = $user->profile->talent;
		// $talent = json_decode($talent, true);
		// if (is_array($talent)) {
		// 	array_splice($talent, $id, 1);
		// 	$talent = json_encode($talent);
		// 	$user->profile->talent = $talent;
		// 	$user->profile->save();
		// }
		return response()->json($talent);
		// return redirect('account/profile');
	}

	public function postReference(Request $request) {

		$req = $request->all();

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		if(isset($req) && $req['action'] === 'add'){
			$userReference = new UserReferences();
		}else if(isset($req) && $req['action'] === 'update'){
			$userReference = UserReferences::find($req['id']);

			if(empty($userReference)){
				$response = array('error' => true, 'message' => t('There are no achievements / references'), 'education' => []);
				$response = json_encode($response);
				return response()->json($response);
			}
		}

		$userReference->user_id = Auth::user()->id;
		$userReference->title = isset($req['title'])? trim($req['title']) : '';
		$userReference->date = isset($req['reference_date_birthDay'])? trim($req['reference_date_birthDay']) : '';
		$userReference->description = isset($req['description'])? strip_tags(trim($req['description'])) : '';

		$userReference->Save();


		if($userReference->id){

			$reference = $user->userReferences;

			if(isset($reference) && !empty($reference)){
				$reference = $reference->toArray();
			}else{
				$reference = [];
			}

			$data = [];
			$data['pagePath'] = t('profile');
			$response = array('error' => false, 'message' => t('Reference added successfully'), 'reference' => $reference);
			$response = json_encode($response);
			return response()->json($response);
		}


		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$reference = $user->profile->reference;
		$reference = json_decode($reference, true);
		$edu = [];
		$edu['title'] = ($request->filled('title')) ? $request->input('title') : '';
		$edu['date'] = ($request->filled('reference_date_birthDay')) ? $request->input('reference_date_birthDay') : '';
		$edu['description'] = ($request->filled('description')) ? strip_tags($request->input('description')) : '';
		if (!is_array($reference)) {
			$reference = [];
		}

		if (isset($request->action) && $request->action == 'add') {
			$len = sizeof($reference);
		} else {
			$len = $request->input('id');
		}

		$reference[$len] = $edu;
		$saved_reference = $reference;
		$reference = json_encode($reference);
		$user->profile->reference = $reference;
		$user->profile->save();

		$data = [];
		$data['pagePath'] = t('profile');
		$data['success'] = true;

		$response = array('error' => false, 'message' => t('Reference added successfully'), 'reference' => $saved_reference);
		$response = json_encode($response);
		return response()->json($response);*/

		// return response()->json($reference);
		// return redirect('account/profile');
	}

	public function createReference() {
		$data = [];
		$data['pagePath'] = t('Add Reference');
		$data['id'] = false;
		// return view('account.profile.reference.create', $data);

		$returnHTML = view('childs.add-reference-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		//return view('childs.add-reference-popup', $data);
	}

	public function editReference($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$reference = UserReferences::where('user_id', Auth::user()->id)
			->where('id', $id)
			->first();

		if( isset($reference) && !empty($reference) ){
			$reference = $reference->toArray();
		}else{
			$reference = [];
		}

		$data = [];
		$data['pagePath'] = t('Update Reference');
		$data['id'] = $id;
		$data['reference'] = $reference;
		$data['selected_date'] = '';

		
		if (isset($data['reference']['date']) && !empty($data['reference']['date'])) {
			$data['selected_date'] = $data['reference']['date'];
		}
		
		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$reference = $user->profile->reference;
		$reference = json_decode($reference, true);

		$data = [];
		$data['pagePath'] = t('Update Reference');
		$data['id'] = $id;
		$data['reference'] = $reference[$id];
		$data['selected_date'] = '';

		if (isset($data['reference']['date']) && !empty($data['reference']['date'])) {
			$data['selected_date'] = $data['reference']['date'];
		}*/
		// return view('account.profile.reference.edit', $data);
		$returnHTML = view('childs.add-reference-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		//return view('childs.add-reference-popup', $data);
	}

	public function deleteReference($id) {

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$userReference = UserReferences::where('user_id', Auth::user()->id)->where('id', $id)->first();

		$reference = [];

		if(isset($userReference) && !empty($userReference)){
			if($userReference->delete()){
				$response = array('error' => false, 'message' => t('Reference deleted successfully'), 'reference' => []);
			}else{
				$response = array('error' => true, 'message' => t('There are no achievements / references'), 'reference' => []);
			}

			$reference = $user->userReferences;

			if( $reference && !empty($reference) ){
				$reference = $reference->toArray();
			}

			$response['reference'] = $reference;
			$response = json_encode($response);
			return response()->json($response);
		}

		/*
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		$reference = $user->profile->reference;
		$reference = json_decode($reference, true);
		if (is_array($reference)) {
			array_splice($reference, $id, 1);
			$saved_reference = $reference;
			$reference = json_encode($reference);
			$user->profile->reference = $reference;
			$user->profile->save();
		}
		if (count($saved_reference) == 0) {
			$response = array('error' => false, 'message' => t('There are no achievements / references'), 'reference' => []);
		} else {
			$response = array('error' => false, 'message' => t('Experience deleted successfully'), 'reference' => $saved_reference);
		}
		$response = json_encode($response);
		return response()->json($response);*/
		// return redirect('account/profile');
	}

	public function postLanguage(Request $request) {

		if( Auth::Check() ){

			$req = $request->all();
			$user_id = Auth::user()->id;

			$is_exits = UserLanguages::where('user_id', $user_id)->where('language_name', $req['language']);

			if(isset($req) && $req['action'] === 'update'){
				$userLang = UserLanguages::find($req['id']);
				$is_exits = $is_exits->where('id', '!=', $req['id']);

			} else if(isset($req) && $req['action'] === 'add'){

				$userLang = new UserLanguages();
				$userLang->user_id = $user_id;
			}

			$is_exits = $is_exits->get();

			if(!empty($is_exits) && count($is_exits) > 0 ){
				$response = array('error' => true, 'message' => t('Language already exist'));
				return response()->json($response);
			}

			$userLang->language_name = isset($req['language'])? trim($req['language']) : '';
			$userLang->proficiency_level = isset($req['pradio'])? trim($req['pradio']) : '';
			$userLang->description = isset($req['description'])? strip_tags(trim($req['description'])) : '';
			$userLang->created_at =  \Carbon\Carbon::now();
			$userLang->save();

			$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
			$language = $user->userLanguages;


			if(isset($language) && !empty($language) ){
				$language = $language->toArray();
			}

			$languageArr = config('languages');
			$language_list = array();
			// trans language array
			if(!empty($languageArr) && count($languageArr) > 0 ){
				
				foreach ($languageArr as $key => $val) {
			 	
			 		$language_list[$key] = trans('language.'.$val);
				}
			}
			
			// $language_list = config('languages');

			if( $userLang->id ){
				$response = array('error' => false, 'message' => t('Language added successfully'), 'language' => $language, 'language_list' => $language_list);
			}
		} else {
			$response = array('error' => true, 'message' => t('some error occurred'));
		}

		return response()->json($response);

		// User languages store in json format in profile table so disable it and use new table "user_languages"

		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$language = $user->profile->language;
		$language = json_decode($language, true);

		$lang = [];
		$action = $request->input('action');
		$lang['language_name'] = $request->input('language');
		$lang['proficiency_level'] = $request->input('pradio');
		$lang['description'] = ($request->input('description')) ? strip_tags($request->input('description')) : '';
		$id = !empty($request->input('id')) ? $request->input('id') : '';

		$is_record_exist = false;
		if (!empty($language)) {
			foreach ($language as $key => $lang1) {
				if ($lang['language_name'] == $lang1['language_name'] && $key != $id) {
					$is_record_exist = true;
				}
			}

		}

		$response = [];
		if ($is_record_exist) {
			$response = array('error' => true, 'message' => t('Language already exist'));
		} else {
			if (!is_array($language)) {
				$language = [];
			}

			if (isset($action) && $action == 'add') {
				$len = sizeof($language);
			} else {
				$len = $request->input('id');
			}

			$language[$len] = $lang;
			$languages = json_encode($language);

			$user->profile->language = $languages;
			$user->profile->save();

			$data = [];
			$data['pagePath'] = t('profile');
			$data['success'] = true;

			$response = array('error' => false, 'message' => t('Language added successfully'), 'language' => $language);
		}

		$response = json_encode($response);
		return response()->json($response);
		*/

		// return redirect('account/profile');
	}

	public function createLanguage() {
		$data = [];
		$data['pagePath'] = t('Add Language');
		$data['id'] = false;
		$languageArr = config('languages');
		$newTransLangArr = array();
		// trans language array
		if(!empty($languageArr) && count($languageArr) > 0 ){
			
			foreach ($languageArr as $key => $val) {
		 	
		 		$newTransLangArr[$key] = trans('language.'.$val);
			}
		}
		
		$data['languages'] = $newTransLangArr; 
		array_unshift($data['languages'], t('Select Language'));

		$returnHTML = view('childs.add-language-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		// return view('childs.add-language-popup', $data);
	}

	public function editLanguage($id) {

		if( isset($id) && !empty($id) ){
			$lang = UserLanguages::where('id', $id)->where('user_id', Auth::user()->id)->first();

			if( isset($lang) && !empty($lang) ){
				$lang = $lang->toArray();
			}else {
				$lang = [];
			}	
			
		}

		/*$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$language = $user->profile->language;
		$language = json_decode($language, true);*/
		
		$data = [];
		$data['pagePath'] = t('Update Language');
		$data['id'] = $id;
		//$data['language'] = $language[$id];
		$data['language'] = $lang;
		// $data['languages'] = config('languages');

		$languageArr = config('languages');
		$newTransLangArr = array();
		// trans language array
		if(!empty($languageArr) && count($languageArr) > 0 ){
			
			foreach ($languageArr as $key => $val) {
		 	
		 		$newTransLangArr[$key] = trans('language.'.$val);
			}
		}
		
		$data['languages'] = $newTransLangArr; 
		$returnHTML = view('childs.add-language-popup', $data)->render();
		return ['status' => true,'html' => $returnHTML ]; exit();

		//return view('childs.add-language-popup', $data);
	}

	public function deleteLanguage($id) {

		// $user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);

		//$language = $user->profile->language;
		//$language = json_decode($language, true);
		
		// if (is_array($language)) {
		// 	array_splice($language, $id, 1);
		// 	$saved_language = $language;
		// 	$language = json_encode($language);
		// 	$user->profile->language = $language;
		// 	$user->profile->save();
		// }
		
		$userLang = UserLanguages::getLanugageById($id);


		if( isset($userLang) && !empty($userLang) ){
			$lang_deleted = $userLang->delete();
		}

		// return lanugage array
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$language = $user->userLanguages;
		if(isset($language) && !empty($language) ){
			$language = $language->toArray();
		}else{
			$language = [];
		}

		if (!$lang_deleted) {
			$response = array('error' => false, 'message' => t('There are no languages yet'));
		} else {
			$response = array('error' => false, 'message' => t('Language deleted successfully'), 'language' => $language);
		}

		$response = json_encode($response);
		return response()->json($response);
		// return response()->json($language);
		// return redirect('account/profile');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function addFavouritePartner(Request $request) {

		$fav_user_id = $request->input('partnerId');

		$status = 0;
		if (auth()->check()) {
			$user = auth()->user();

			$favUser = Favorite::where('user_id', $user->id)->where('fav_user_id', $fav_user_id);
			if ($favUser->count() > 0) {
				// Delete SavedPost
				$favUser->delete();
			} else {
				// Store SavedPost
				$favUserInfo = [
					'user_id' => $user->id,
					'fav_user_id' => $fav_user_id,
				];
				$favouriteUser = new Favorite($favUserInfo);
				$favouriteUser->save();
				$status = 1;
			}
		}

		$result = [
			'logged' => (auth()->check()) ? $user->id : 0,
			'partnerId' => $fav_user_id,
			'status' => $status,
			'loginUrl' => url(config('lang.abbr') . '/' . trans('routes.login')),
		];

		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}

	/**
	 * @return View
	 */
	public function getFavouritePartners() {
		$data = [];

		// Favourite Posts

		$data['partners'] = Favorite::where('user_id', auth()->user()->id)
			->orderByDesc('id')->paginate($this->perPage);
		$data['count'] = $this->favouritePosts->count();

		// Meta Tags
		MetaTag::set('title', t('My favourite jobs'));
		MetaTag::set('description', t('My favourite jobs on :app_name', ['app_name' => config('settings.app.name')]));

		$data['type'] = 'favourite';

		// return view('account.posts', $data);

		return view('model/my-favourite-jobs', $data);
	}

	public function userPartnerView($slug = '', $user = '') {
		// 5227
		$id = 0;
		$data = array();

		if(isset($slug) && !empty($slug) && $user == ""){
			$user = User::withoutGlobalScopes([VerifiedScope::class])->where('username', $slug)->first();
		}

		if( isset($user) && !empty($user) ){
			$id = $user->id; 
		}
		if ($slug === '') {
			$id = \Auth::user()->id;

		} else { 

			// check 
			$to_user = $user->id;
			// $is_record_exist = Message::where('message_type', 'Direct Message')
			// 	->whereNull('deleted_at')
			// 	->where(function ($query) use( $to_user ){
   //                              $query->where('messages.to_user_id', $to_user)->Where('messages.from_user_id', Auth::user()->id);
   //                              })
   //                              ->orwhere(function ($query) use( $to_user ){
   //                                  $query->where('messages.to_user_id', Auth::user()->id)->Where('messages.from_user_id', $to_user);
   //                              })
			// 	->select('*')
			// 	->count();

			// check if it is not direct message then check the inviation status		 
			// if($is_record_exist < 1 ){

				

				// check logged in user is model and gets invitation 
				if(isset($user) &&  $user->id !== Auth::user()->id  && Auth::user()->user_type_id == config('constant.model_type_id')){

					$preSearch = app('App\Http\Controllers\Partner\SearchController')->preSearchData("", "");

					// get specific id by user id   (search_user_id = user::id)
					$preSearch['search_user_id'] = $id;

					$search = new PartnerSearch($preSearch);
					$data = $search->fechAll();

					$data['matchCount'] = $this->getMatchJobByUserCount($user->id);

					if(isset($data['paginator']) && count($data['paginator']->items()) > 0 ){
						$user_key_exists = array_search($id, array_column($data['paginator']->items(), 'user_id'));

						if(!is_int($user_key_exists)){
							return $data = array();
							// return abort(404);
						}

					} else {
						//check model is invited or not in partner list
						$is_model_invited = Message::where('from_user_id', $user->id)->where('to_user_id', Auth::user()->id)->where('message_type', 'Invitation')->count();

					$status = true;
					if( $is_model_invited == 0 ){
						// return $data = array();
						$status = false;
					}

					$to_user = $user->id;
					$is_direct_message = Message::where('message_type', 'Direct Message')
					->whereNull('deleted_at')
					->where(function ($query) use( $to_user ){
                                            $query->where('messages.to_user_id', $to_user)->Where('messages.from_user_id', Auth::user()->id);
                                        })
                                        ->orwhere(function ($query) use( $to_user ){
                                            $query->where('messages.to_user_id', Auth::user()->id)->Where('messages.from_user_id', $to_user);
                                        })
					->select('*')
					->first();



					if($status == false){
						if(empty($is_direct_message)){
							return $data = array();
						}
					}

				}

				// check partner is applied for the job post or not
				if(isset($user) &&  $user->id !== Auth::user()->id  && Auth::user()->user_type_id == config('constant.partner_type_id')){

					$is_partner_applied = Message::whereIn('from_user_id', array($user->id,Auth::user()->id))
						->whereIn('to_user_id', array($user->id,Auth::user()->id))
						->where('message_type', 'Job application')->count();
						
					if( $is_partner_applied == 0 ){
						return $data = array();
					}
				}
			}		

		}

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);

		$education = "";
		if ($user->userEducations) {
			//$education = json_decode($user->profile->education, true);
			$education = isset($user->userEducations)? $user->userEducations->toArray() : [];

		}

		$experience = "";
		if ($user->userExperiences) {
			// $experience = json_decode($user->profile->experience, true);
			$experience = isset($user->userExperiences)? $user->userExperiences->toArray() : [];
		}
		// commented city code 
		// $city_name = City::where('id', $user->profile->city)->select('name')->first();
		$validValues = ValidValue::all();
		
		$data['profile'] = $user->profile;
		$data['user_type_id'] = $user->user_type_id;
		$data['active'] = $user->active;
		$data['logo'] = ($user->profile->logo) ? $user->profile->logo : '';

		$data['country'] = ($user->country_name) ? $user->country_name : '';

		// $data['country'] = ($user->profile->country) ? CountryLocalization::getCountryNameByCode($user->profile->country) : '';
		// commented city code 
		// $data['city'] = ($user->profile->city) ? $city_name->name : '';
		$city_name = '';
		if(isset($user->profile->city) && !empty($user->profile->city)){
			$city_name = explode(',', $user->profile->city);
			$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
		}
		$data['city'] = $city_name;
		$data['experience'] = $experience;
		$data['education'] = $education;
		$data['branch'] = "";
		$data['user'] = $user;
		// $data['gravatar'] = (!empty(Auth::user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(Auth::user()->email) : null;

		// Get branches
		// $cacheId = 'branches.parentId.0.with.children' . config('app.locale');
		// $data['branches'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
		// 	$branches = Branch::trans()->where('parent_id', 0)->with([
		// 		'children' => function ($query) {
		// 			$query->trans();
		// 		},
		// 	])->orderBy('lft')->get();

		// 	return $branches;
		// });

		$branch = $user->profile->category_id;

		// Get branches
		$branches = Branch::trans()
			->where(function ($q) use ($branch) {
				$q->where('id', $branch)
					->orWhere('translation_of', $branch);
			})
			->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang')
			->get();
		$data['branches'] = $branches;

		// Mini Stats
		// $data['countPostsVisits'] = DB::table('posts')
		// 	->select('user_id', DB::raw('SUM(visits) as total_visits'))
		// 	->where('country_code', config('country.code'))
		// 	->where('user_id', Auth::user()->id)
		// 	->groupBy('user_id')
		// 	->first();
		// $data['countPosts'] = Post::currentCountry()
		// 	->where('user_id', Auth::user()->id)
		// 	->count();
		// $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
		// 	$query->currentCountry();
		// })->where('user_id', Auth::user()->id)
		// 	->count();

		// Increment User visits counter
		Event::dispatch(new UserWasVisited($user));
		// $data['countPostsVisits'] = $user->posts->sum('visits');
		$data['countPosts'] = $user->userposts->count();
		$data['countFavoritePosts'] = $user->savedPosts->count();


		// get metatag
		CommonHelper::goModelMeta($user);

		$data['user_name'] = $user->username;
		
		return $data;
		// return view('partner/public-profile', $data);
	}

	public function EditPartnerProfile($id = 0) {
		if ($id == 0) {
			$id = \Auth::user()->id;
		}

		if (Auth::User() && Auth::User()->user_type_id != 2) {
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);
		
		//partner no need to education
		//$education = $user->profile->education;
		//$education = json_decode($education, true);

		//partner no need to experience
		//$experience = $user->profile->experience;
		//$experience = json_decode($experience, true);

		$experience = $education = [];

		$validValues = ValidValue::all();
		$data['profile'] = $user->profile;
		$data['user_type_id'] = $user->user_type_id;
		$data['active'] = $user->active;
		$data['logo'] = ($user->profile->logo) ? $user->profile->logo : '';
		$data['cover'] = ($user->profile->cover) ? $user->profile->cover : '';
		$data['country'] = ($user->country_code) ? CountryLocalization::getCountryNameByCode($user->country_code) : '';
		$data['city'] = ($user->profile->city) ? $user->profile->city : '';
		$data['experience'] = $experience;
		$data['education'] = $education;
		$data['branch'] = "";
		$data['user'] = $user;

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

		// get timezone by google time zone id
		// $data['timezone_name_selected']  = ($user->profile->timezone) ? $user->profile->timezone : '';
		$data['timezone'] = TimeZone::pluck('time_zone_id', 'id')->toArray(); 

		MetaTag::set('title', t('My account'));
		MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app.name')]));

		$data['user_name'] = $user->username;

		// get metatag
		CommonHelper::goModelMeta($user);
		
		return view('partner/partner-profile-edit', $data);
	}

	public function SavePartnerProfile(UserRequest $request) {
		// Get User
		$user = User::withoutGlobalScopes([VerifiedScope::class])->find(Auth::user()->id);
		$req = $request->all();
		// set newsletter param from request
		$receive_newsletter = isset($req['newsletter']) ? $req['newsletter'] : 0;
		// set old  newsletter param from user object
		$old_receive_newsletter = $user->receive_newsletter;

		$countryname = $request->input('country_name');
		// commnted city code
		// $cityname = $request->input('city_name');
		$cityname = $request->input('city');
		$fullCityName = $request->input('city');

		if(isset($cityname) && !empty($cityname)){
			$cityname = explode(',', $cityname);
			$cityname = ( count($cityname) > 0 && isset($cityname[0]) )? $cityname[0] : $request->input('city');
		}
		$geo_lat = $user->latitude;
		$geo_long = $user->longitude;
		$geo_state = $user->profile->geo_state;
		if(!empty($request->input('geo_state'))){
			$geo_state = $request->input('geo_state');
		}
		$geo_city   =  $cityname;
        $geo_country = $countryname;
        $geo_full = $user->profile->street.", ".$user->profile->zip.', '.$user->profile->city;
        $is_geo_update = false;
        $country_code = ($request->input('country')) ? $request->input('country') : $user->country_code;
        $phone_code = ($request->input('phone_code')) ? $request->input('phone_code') : $user->phone_code;
		if($user->profile->street != $request->input('street') || $user->country_code != $country_code || $user->profile->city != $fullCityName || $user->profile->zip != $request->input('zip'))
		{	
			$is_geo_update = true;
			$street = $request->input('street');
			$zip = $request->input('zip');
			$city_name = $cityname;
			$country_name = $request->input('country_name');
			$address    = $street.", ".$zip.', '.$city_name.', '.$geo_state.', '.$country_name;
			$longlat = array();
			$address = urlencode ($address);
	 		$googleurl = config('app.g_latlong_url');
			$google_api_key_maps = config('app.latlong_api');
			
			$url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$request->input('country').'&key='.$google_api_key_maps;


			// call get latitude longitude 
			$longlat = CommonHelper::getLatLong($url);
			// if invalid street and zip code, get latlong full city name
			if(empty($longlat)){

				$url = $googleurl.urlencode($fullCityName).'&sensor=false&language=en&components=country:'.$request->input('country').'&key='.$google_api_key_maps;
				// call get latlong
				$longlat = CommonHelper::getLatLong($url); 
			} 
			$geo_lat    =  isset($longlat['latitude'])? strval($longlat['latitude']) : '';
	        $geo_long   =  isset($longlat['longitude'])? strval($longlat['longitude']) : '';
	        $geo_city   =  isset($longlat['geo_city'])? $longlat['geo_city'] : $city_name;
	        $geo_state  =  isset($longlat['geo_state'])? $longlat['geo_state'] : $geo_state;
	        $geo_country = isset($longlat['geo_country'])? $longlat['geo_country'] : $country_name;
	        $geo_full = $street.", ".$zip.', '.$geo_city;  
		}

        $user->latitude = $geo_lat;
		$user->longitude = $geo_long;
		$user->phone_code = $phone_code;
		$user->phone = $request->input('phone');
		//$user->email = $request->input('email');
		$user->country_code = $country_code;

		$user->profile->tfp = $request->input('tfp') ? $request->input('tfp') : 0;
		$user->profile->allow_search = $request->input('allow_search') ? $request->input('allow_search') : 0;

		$user->profile->first_name = $request->input('first_name');
		$user->profile->last_name = $request->input('last_name');

		$user->profile->description = addslashes($request->input('description'));
		$user->profile->company_name = $request->input('company_name');
		$user->profile->category_id = $request->input('category');

		$user->profile->facebook = $request->input('facebook');
		$user->profile->twitter = $request->input('twitter');
		//$user->profile->google_plus = $request->input('google_plus');
		$user->profile->linkedin = $request->input('linkedin');
		$user->profile->instagram = $request->input('instagram');
		$user->profile->pinterest = $request->input('pinterest');

		$user->profile->street = addslashes($request->input('street'));

		$user->profile->city = $request->input('city');
		$user->profile->geo_state = $geo_state;
		$user->profile->zip = $request->input('zip');
		$user->profile->preferred_language = $request->input('preferred_language');


		$website_url = ($request->input('website_url')) ? $request->input('website_url') : '';
				
		if(!empty($website_url)){
			
			$website_url = preg_replace('/^(?!https?:\/\/)/', 'http://', $website_url);
		}
		
		$user->profile->website_url = $website_url;
		$user->profile->timezone = $request->input('timezone');

		// if ($request->hasFile('profile.logo')) {
		// 	$user->profile->logo = $request->file('profile.logo');
		// }

		if ($request->hasFile('profile.cover')) {
			$user->profile->cover = $request->file('profile.cover');
		} 
		$availability_time = '';
		$saveDataArr = array();

		// Start Available Time Code
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
			}
			
			// Send 'Available time' action to CRM
			$available_phone_arr = array(
				'action' => 'set_available_phone',
				'wpusername' => $user->username,
				'availPhone' => $availability_time,
			);
			
			$response = CommonHelper::go_call_request($available_phone_arr);
			\Log::info('Request Array', ['Request Array set_available_phone' => $available_phone_arr]);
			$json = json_decode($response->getBody());
			\Log::info('Response Array', ['Request Array set_available_phone' => $json]);
			// save available time
		    $user->profile->availability_time = $availability_time;
		}
		$user->is_profile_completed = '1';
		// Save User
		$user->save();
		$user->profile->save();

		//check gender
		$gender_id = config('constant.crm_female');

		if( isset($user->gender_id) && !empty($user->gender_id) ){
			if($user->gender_id == config('constant.gender_male')){
				$gender_id = config('constant.crm_male');
			}
		}
		
		// Update user in CRM
		$req_arr = array(
			'action' => 'update', //required
			'wpusername' => $user->username, // required api
			'name' => $user->profile->first_name,
			'lname' => $user->profile->last_name,
			'email' => $user->email,
			'tel_prefix' => $phone_code,
			'tel' => $request->input('phone'),
			'platform' => $user->profile->partnercategory->slug,
			'type' => ($user->user_type_id == '2') ? 4 : 1,
			'url' => $user->profile->website_url,
			'gender' => $gender_id,
			'timeZoneId' => $user->profile->timezone,
			'timeZoneName' => $request->input('timezone_name'),
		);

		// if change city or street or zip, update CRM data
		if($is_geo_update == true){
			
			$req_arr['street'] = addslashes($user->profile->street);
			$req_arr['zip'] = $request->input('zip');
			$req_arr['city'] = $cityname;
			$req_arr['country'] = $user->country_code;
			$req_arr['latitude'] = $geo_lat;
			$req_arr['longitude'] = $geo_long;
			$req_arr['geo_lat'] = $geo_lat;
			$req_arr['geo_long'] = $geo_long;
			$req_arr['geo_city'] = $cityname;
			$req_arr['geo_state'] = $geo_state;
			$req_arr['geo_country'] = $geo_country;
			$req_arr['geo_full'] = $geo_full;
		}
		if(!empty($request->input('preferred_language'))){
			$req_arr['locale'] = $request->input('preferred_language');
		}


		$response = CommonHelper::go_call_request($req_arr);
		\Log::info('Request Array update', ['Request Array' => $req_arr]);
		$json = json_decode($response->getBody());
		\Log::info('Response Array', ['Response Array update' => $json]);
		
		if ($response->getStatusCode() == 200) {

			//check it user newsletter status is changed then update crm
			if($old_receive_newsletter != $receive_newsletter ){

				// make crm call to update newsletter on user newsletter value is changed
				$req_news = array(
					'action' => 'newsletter_subscription', //required
					'wpusername' => $user->username, // required api
					'newsletter_value' => $receive_newsletter // required api
				);

				\Log::info('Update CRM API for newsletter', ['user_status' => $req_news]);

				$resp_newsletter = CommonHelper::go_call_request($req_news);

				if ($resp_newsletter->getStatusCode() == 200) {
					$n_json = json_decode($resp_newsletter->getBody());
					\Log::info('Update User', ['newsletter_subscription' => $n_json]);
				}else{
					\Log::info('Something wrong to call newsletter_subscription', ['user_status' => $req_news]);
				}

				if ($resp_newsletter->getStatusCode() == 200) {
					
					//update newsletter settings in crm and profile
					$req_arr = array(
						'action' => 'update',
						'wpusername' => $user->username,
						'newsletter' => $receive_newsletter
					);

					$response = CommonHelper::go_call_request($req_arr);
					\Log::info('Request Newsletter Array update', ['Request Array' => $req_arr]);
					
					$json = json_decode($response->getBody());
					\Log::info('Response Array', ['Response Array update' => $json]);	

					$body = (string) $response->getBody();
					if($body){	
		 				$user->receive_newsletter = $receive_newsletter;
		 				$user->save();
					}
					
					flash(t("Your details account has updated successfully"))->success();
					return redirect()->back();
				}
			}

			// $body = (string) $response->getBody();
			// if ($body)
			// {
			flash(t("Your details account has updated successfully"))->success();
			return redirect()->back();
			// }
		}
		flash(t('some error occurred'))->error();
		return redirect()->back();
	}

	public function partnerDashboard() {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$data = [];
		
		// $perpage = 12;
		$perpage = (config('constant.dashboard_limit'))? config('constant.dashboard_limit') : '6';

		// Set the Page Path
		$data['pagePath'] = 'partner-dashboard';

		// Get the Conversations
		// $data['conversations'] = $this->conversations->paginate(5);
		// $data['conversations'] = Message::getConversations(auth()->user()->id, 6, null);

		/*
		 	@param getMessages 
		 	$search = null, $to_user = false, $start = 0, $limit = 0, $allConversation = true
		*/

		$result = Message::getMessages(null, true, 0, $perpage, false);

		$data['conversations'] = array();
		if(isset($result['data'])){
			$data['conversations'] = $result['data'];
		}
		
		$data['posts'] = Post::myPosts(Auth::user()->id, $perpage, $count = null);

		$data['models'] = array();

		$preSearch = ['perpage' => $perpage];

		$data['models'] = array();
		if (Gate::allows('list_models', auth()->user())) {


			if(auth()->user()->user_register_type == config('constant.user_type_free')){
				$preSearch['is_premium_partner'] = false;
			}else{
				$preSearch['is_premium_partner'] = true;
			}

			$preSearch['country_code'] = auth()->user()->country_code;
			$search = new ModelSearch($preSearch);
			$models = $search->fechAll();
			$data['models'] = $models['paginator']->getCollection();
        }

        $data['modelCategories'] = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
		])->orderBy('lft')->get();

		$data['favorites_user_ids'] = \App\Models\Favorite::getFavouriteUsersById(Auth::user()->id);
		
		$metaArr = [
			'title' => t('meta-partner-dashboard - :app_name', ['app_name' => config('app.app_name')])
		];
		// get metatag
		CommonHelper::goModelMeta(auth()->user(), $metaArr);

		return view('partner/partner-dashboard', $data);
	}

	public function partnerPortfolio($id = 0) {

		if ($id == 0) {
			$id = \Auth::user()->id;
		}
		
		$perpage = (config('constant.dashboard_limit'))? config('constant.dashboard_limit') : '6';

		$user = User::withoutGlobalScopes([VerifiedScope::class])->find($id);

		if (empty($user) || (isset($user) && $user->user_type_id != 2)) {
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}

		// $city_name = City::select('name')->where('id', $user->profile->city)->first();

		if ($user && !empty($user)) {

			$data = array();

			$data['profile'] = $user->profile;
			$data['user_type_id'] = $user->user_type_id;
			$data['active'] = $user->active;
			$data['logo'] = ($user->profile->logo) ? $user->profile->logo : '';
			// $data['country'] = ($user->profile->country) ? CountryLocalization::getCountryNameByCode($user->profile->country) : '';
			$data['country'] = ($user->country_name) ? $user->country_name : '';
			$city_name = '';
			if(isset($user->profile->city) && !empty($user->profile->city)){
				$city_name = explode(',', $user->profile->city);
				$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
			}
			$data['city'] = $city_name;
			$data['branch'] = "";
			$data['user'] = $user;
			$data['gravatar'] = (!empty(Auth::user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(Auth::user()->email) : null;

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


			// Mini Stats
			// $data['countPostsVisits'] = DB::table('posts')
			// 	->select('user_id', DB::raw('SUM(visits) as total_visits'))
			// 	->where('country_code', config('country.code'))
			// 	->where('user_id', Auth::user()->id)
			// 	->groupBy('user_id')
			// 	->first();

			//$data['countPosts'] = Post::where('user_id', Auth::user()->id)->count();
			//$data['countFavoritePosts'] = SavedPost::where('user_id', Auth::user()->id)->count();

			$data['countPostsVisits'] = $user->posts->sum('visits');
			$data['countPosts'] = $user->userposts->count();
			$data['countFavoritePosts'] = $user->savedPosts->count();

			$data['matchCount'] = $this->getMatchJobByUserCount($user->id);

			// $data['album'] = Albem::where('user_id', $user->id)->orderby('id', 'desc')->get();

		 	$albums = Albem::where('user_id', $user->id)->orderby('id', 'desc')->paginate($this->perPage);
			
			$is_load_more_albums = false;
			if(!empty($albums) && $albums->count() > 0){

			   if($albums->total() && $albums->total() > $this->perPage){
			   		$is_load_more_albums = true;
			   }
			}

			$data['user_id'] = $id;
			$data['is_load_more_albums'] = $is_load_more_albums;
			$data['album'] = $albums;
		}

		// get metatag
		CommonHelper::goModelMeta($user);
		return view('partner/partner-portfolio', $data);
	}


	public function redirectUser($slug = ''){

		$is_record_exist = "";
		$direct_message_link = "";

		if( isset($slug) && $slug != ''){
			
			$user = User::withoutGlobalScopes([VerifiedScope::class])->where('username', $slug)->first();

			if(empty($user)){
				flash(t("user details not found"))->error();
				return redirect()->back();
			}
			 
			if( isset($user) && !empty($user) ){

				if( $user->id != Auth::user()->id ){
					$is_record_exist = Message::select('*')
							->where('message_type', 'Direct Message')
							->whereNull('deleted_at')
							->where(function ($query) use( $user ){
				                $query->where('messages.to_user_id', $user->id)->Where('messages.from_user_id', Auth::user()->id);
				                $query->orwhere('messages.to_user_id', Auth::user()->id)->Where('messages.from_user_id', $user->id);
				            })
							->first();
				}
				
				// if(Auth::user()->user_type_id == 3 && $user->id == Auth::user()->id){
				if(Auth::user()->user_type_id === config('constant.model_type_id') && ( $user->id == Auth::user()->id || $user->featured == 1) ){

					$data = $this->userView($slug);
					
					if(isset($data) && !empty($data)){
						return view('model.public-profile', $data);
					}else{
						flash(t("Model details not found"))->error();
						return redirect()->back();
					}

				// }else if(Auth::user()->user_type_id == 2 && $user->user_type_id == 3){
				}else if(Auth::user()->user_type_id == config('constant.partner_type_id') && $user->user_type_id == config('constant.model_type_id')){

					if(isset($is_record_exist) && !empty($is_record_exist)){
						$direct_message_link = lurl('account/conversations/'.$is_record_exist->id.'/messages');
						if($is_record_exist->parent_id != 0){
							$direct_message_link = lurl('account/conversations/'.$is_record_exist->parent_id.'/messages');
						}
					}


					$data = $this->userView($slug);
					$data['direct_message_link'] = $direct_message_link;

					// echo "<pre>"; print_r($data); echo "</pre>"; exit(); 

					// view user profile restrictions
					if (!Gate::allows('view_profile', auth()->user())) {
			            flash("You are not allow to access this page")->error();
						return redirect(config('app.locale'));
			        }


					//redirect if user is blocked
					if (isset($data) && isset($data['user']) && $data['user']->blocked == 1) {
						flash(t("This user no longer exists"))->error();
						return redirect()->back();
					}

					if(isset($data) && !empty($data)){
						return view('model.public-profile', $data);
					}else{
						flash(t("Model details not found"))->error();
						return redirect()->back();
					}

				
				}else{


					if(Auth::user()->user_type_id == config('constant.model_type_id') && Auth::user()->id !== $user->id ){
						if(Auth::user()->user_register_type == config('constant.user_type_free')){
							if (empty($is_record_exist)) {
								flash("You are not allow to access this page")->error();
								return redirect(config('app.locale'));
							}
						}

						if(isset($is_record_exist) && !empty($is_record_exist)){
							$direct_message_link = lurl('account/conversations/'.$is_record_exist->id.'/messages');
							if($is_record_exist->parent_id != 0){
								$direct_message_link = lurl('account/conversations/'.$is_record_exist->parent_id.'/messages');
							}
						}
					}

					$data = $this->userPartnerView($slug, $user);
					$data['direct_message_link'] = $direct_message_link;

					 // echo "<pre>"; print_r($data); echo "</pre>"; exit(); 

					if(isset($data) && !empty($data)){
						return view('partner/public-profile', $data);
					}else{
						flash(t("Client details not found"))->error();
						return redirect()->back();
					}

				} 
			}
		} else { 
			 
			if(Auth::user()->user_type_id == 3){
				$data = $this->userView($slug);
				return view('model.public-profile', $data);
			}else{ 
				$data = $this->userPartnerView($slug);
				return view('partner/public-profile', $data);
			}
		}

	}

	/*
	* model contact to partner from partner profile
	*/
	public function userSendMail(Request $request){

		$req = $request->all();
		
		$rules = [
			// 'name' => 'required|alpha',
			// 'phone_code' => 'required',
			// 'phone' => 'required|numeric|digits:10',
			// 'email' => 'email|required',
			'message' => 'required|min:100',
		];

		$validator = Validator::make($req, $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			return Response::json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray(),

			));
			exit();

		} else {

			if( isset($req) && !empty($req) ){
				
				$partner_id = $req['id'];

				if( isset($partner_id) ){

					$partner = User::find($partner_id);
					$model = Auth::user();

					if( isset($partner) && !empty($partner) && isset($model) && !empty($model) ){

						if( isset($partner->email) && !empty($partner->email) ){
							
							try {

								Mail::send(new ContactPartner($partner, $model, $req));

								return Response::json(array(
									'success' => true,
									'message' => t('Your message has sent successfully'),
								));
							
							} catch (\Exception $e) {

								return Response::json(array(
									'success' => false,
									'errors' => t('Something went wrong Please try again'),
								));
							}

						} else {

							return Response::json(array(
								'success' => false,
								'errors' => t(':partner email address not found! Please try later', ['partner' => isset($partner->profile->first_name)? $partner->profile->first_name : '']),
							));
						}


					} else {

						return Response::json(array(
							'success' => false,
							'errors' => t('Something went wrong Please try again'),
						));
					}
				} else {

					return Response::json(array(
						'success' => false,
						'errors' => t('Something went wrong Please try again'),
					));
				}

				
			} else {
				return Response::json(array(
					'success' => false,
					'errors' => trans('Something went wrong Please try again'),
				));
			}
		}
	}

	public function jobMatchProfile($user_id, Request $request){

		$favourite_posts = $dataArr = array();
		
		if( isset($user_id) && $user_id != "" ){

			$favourite_posts = SavedPost::getFavouritePostsById(auth()->user()->id);
				
			$dataArr['favourite_posts'] = $favourite_posts;

			$user = User::withoutGlobalScopes([VerifiedScope::class])->where('id', $user_id)->first();

			if( $user && !empty($user) ){

				$dataArr['profile'] = $user->profile;
				$dataArr['logo'] = ($user->profile->logo) ? $user->profile->logo : '';
				$dataArr['country'] = ($user->country_name) ? $user->country_name : '';
				$dataArr['countPosts'] = $user->userposts->count();
				$dataArr['user'] = $user;
				$dataArr['user_type_id'] = $user->user_type_id;

				$city_name = '';
				if(isset($user->profile->city) && !empty($user->profile->city)){
					$city_name = explode(',', $user->profile->city);
					$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user->profile->city;
				}
				$dataArr['city'] = $city_name;

				$branch = $user->profile->category_id;

				// Get branches
				$branches = Branch::trans()
					->where(function ($q) use ($branch) {
						$q->where('id', $branch)
							->orWhere('translation_of', $branch);
					})
					->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang')
					->get();

				$dataArr['branches'] = $branches;


				$dataArr['countFavoritePosts'] = $user->savedPosts->count();
				$dataArr['user_name'] = $user->username;
			}

			$preSearch = app('App\Http\Controllers\Search\SearchController')->preSearchData();
			$preSearch['partner_id'] = $user_id;

			$dataArr['matchCount'] = $this->getMatchJobByUserCount($user_id);

			$search = new Search($preSearch);

			$data = $search->fechAll();
			$dataArr['paginator'] = $data['paginator'];

			$dataArr['pageNo'] = 1;
			$lastPage = 0;
			$is_last_page = 0;


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
				
				$returnHTML = view('search.inc.posts' , $dataArr)->render();
				return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $dataArr['pageNo'], 'is_last_page' => $dataArr['is_last_page']));
			}

		}
		
		return view('model.job-matching-profile', $dataArr);
	}

	public function getMatchJobByUserCount($user_id){

		$count = 0;

		$preSearch = app('App\Http\Controllers\Search\SearchController')->preSearchData();
		$preSearch['partner_id'] = $user_id;

		$search = new Search($preSearch);

		$data = $search->fechAll();
		$dataArr['paginator'] = $data['paginator'];

		if( isset($dataArr['paginator']) && !empty($dataArr['paginator']) ){
			$count = $dataArr['paginator']->total();
		}

		return $count;
	}
	// delete resume 
	public function resume_delete($id='') 
	{	

		$status = false;
		$message = t('No deletion is done, Please try again');

		if(Auth::user()->user_type_id == config('constant.partner_type_id'))
		{
			$message = t("You don't have permission to open this page");
			$response = array('status' => $status, 'message' => $message);
			return response()->json($response); exit();
		}
		
		$userid = Auth::user()->id;
		$resume = Resume::where('user_id', Auth::user()->id)->first();
		
		if (!empty($resume) && $resume->count() > 0) 
		{
			if (isset($resume->filename) && $resume->filename != "" && Storage::exists($resume->filename)) 
			{ 
				unlink(public_path('uploads/'.$resume->filename));
				$resume->delete();
				$message = t('Your Resume has been deleted successfully');
				$status = true;	
			}
		}
		$response = array('status' => $status, 'message' => $message);
		return response()->json($response); exit();
	}

	// public function cropProfileImage(Request $request){
		
	// 	$message = t('some error occurred');

	// 	if(isset($request->image) && !empty($request->image)){

	// 		$user_id = $request->user_id;

	// 		// get user details
	// 		$user = User::where('id', $user_id)->first();
	// 		$image_array_1 = explode(";", $request->image);

	//  	 	$extentionString = $image_array_1[0];

	//  	 	$extentionArr = explode("/", $extentionString);

	//  	 	$imageType = "png";
	 	 	
	//  	 	// get extention Array
	//  	 	if(isset($extentionArr[1])){

	//  	 		$imageType = $extentionArr[1];
	//  	 	}
	 	 	
	//  	 	$image_array_2 = explode(",", $image_array_1[1]);
		 	
	// 	 	$data = base64_decode($image_array_2[1]);

	// 	 	// check image path is exist
	// 	 	if(!Storage::exists('profile/logo/' . $user_id)){
				
	// 			// create image directory
	// 			Storage::makeDirectory('profile/logo/' . $user_id , 0775, true);
	// 		}
			
	// 		// set image name
	// 		$imageName = 'profile/logo/'.$user_id.'/'.md5(microtime() . mt_rand()). '.'.$imageType;

	// 		$old_image = $user->profile->logo;
			
	// 		$user->profile->logo = $imageName;
	// 		$user->profile->save();
			
	// 		// save image in folder 
	// 		file_put_contents('uploads/'.$imageName, $data);

	// 		// check old image exist
	// 		if (isset($old_image) && $old_image !== "") {
				
	// 			// already image exist unlink
	// 			if (Storage::exists($old_image)) {
					
	// 				unlink(public_path('uploads/'.$old_image));
	// 			}
	// 		}

	// 		$req_arr = array(
	// 			'action' => 'update', //required
	// 			'wpusername' => $user->username, // required api
	// 			'imglink' => \Storage::url(trim($user->profile->logo)),
	// 		);

	// 		// call crm Api
	// 		$response = CommonHelper::go_call_request($req_arr);
	// 		\Log::info('Request Array update', ['Request Array' => $req_arr]);
			
	// 		$status = true;
	// 		$message = t('profile picture has been uploaded successfully');

	// 		$returnHTML = '<img id="output-partner-logo" src="'.Storage::url($imageName).'" alt="user" width="75%">';

	// 		return response()->json(array('success' => true, 'html'=> $returnHTML, 'message' => $message));
	// 	}else{
			
	// 		$returnHTML = '<img id="output-partner-logo" src=""'.url(config('app.cloud_url').'/images/user.jpg').'" alt="user" >';
	 		
	//  		return response()->json(array('success' => false, 'html'=> $returnHTML, 'error' => $message));
	//  	}
	// }

	public function getTimeZoneAjaxCall(Request $request){

	 	$timezone = array();

	 	if(isset($request->country_code) && !empty($request->country_code)){

	 		$getTimeZone = TimeZone::where('country_code', $request->country_code)->pluck('time_zone_id', 'id')->toArray();

	 		if(!empty($getTimeZone) && count($getTimeZone) > 0){

	 			$timezone = $getTimeZone;
	 		}

 		  	$response = array('status' => true, 'timezone' => $timezone);

	 		return response()->json($response);
	 	}

	 	$response = array('status' => false, 'timezone' => $timezone);
	 	return response()->json($response);
	}

	public function modelAcademy() {
		
		if (Auth::User() && Auth::User()->user_type_id != config('constant.model_type_id')) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}

		$dataArr = array();
		return view('model.model-academy', $dataArr);
	}

	public function partnerAcademy() {
		
		if (Auth::User() && Auth::User()->user_type_id != config('constant.partner_type_id')) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		
		$dataArr = array();
		return view('partner.partner-academy', $dataArr);
	}
}
