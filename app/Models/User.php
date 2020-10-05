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

namespace App\Models;

use App\Models\Scopes\VerifiedScope;
use App\Models\Traits\CountryTrait;
use App\Notifications\ResetPasswordNotification;
use App\Observer\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Date\Date;
use Larapen\Admin\app\Models\Crud;
use Auth;
use App\Models\JobApplication;
use App\Helpers\Localization\Helpers\Country as CountryHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

// base trait
// extension trait

class User extends BaseUser {
	use Crud, CountryTrait, Notifiable, SoftDeletes;
	// use CountryTrait, Notifiable;
	// use Eloquence, Metable;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $casts = [
			     'id' => 'int',
			     'work_settings' => 'array'
			];
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	protected $appends = ['created_at_ta'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'country_code',
		'user_type_id',
		'gender_id',
		'name',
		'about',
		'phone',
		'phone_hidden',
		'email',
		'username',
		'password',
		'remember_token',
		'is_admin',
		'lang_locale',
		'can_be_impersonate',
		'disable_comments',
		'receive_newsletter',
		'receive_advice',
		'ip_addr',
		'provider',
		'provider_id',
		'email_token',
		'phone_token',
		'verified_email',
		'verified_phone',
		'blocked',
		'closed',
		'system_settings',
		'work_settings',
		'featured',
		'latitude',
		'longitude',
		'hash_code',
		'active',
		'is_profile_completed',
		'is_profile_pic_approve',
		'is_operator',
		'phone_code',
		'rating',
		'is_editor_pic',
		'rating_count',
	];

	/**
	 * The attributes that should be hidden for arrays
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at', 'last_login_at', 'deleted_at'];

	// prevent set attribute
	public $preventAttrSet = false;

	/*
		    |--------------------------------------------------------------------------
		    | FUNCTIONS
		    |--------------------------------------------------------------------------
	*/
	protected static function boot() {
		parent::boot();

		User::observe(UserObserver::class);

		// Don't apply the ActiveScope when:
		// - User forgot its Password
		// - User changes its Email or Phone
		if (
			!Str::contains(Route::currentRouteAction(), 'Auth\ForgotPasswordController') &&
			!Str::contains(Route::currentRouteAction(), 'Auth\ResetPasswordController') &&
			!session()->has('emailOrPhoneChanged') &&
			!Str::contains(Route::currentRouteAction(), 'Impersonate\Controllers\ImpersonateController')
		) {
			static::addGlobalScope(new VerifiedScope());
		}
	}

	public function routeNotificationForMail() {
		return $this->email;
	}

	public function routeNotificationForNexmo() {
		$phone = phoneFormatInt($this->phone, $this->country_code);
		$phone = setPhoneSign($phone, 'nexmo');

		return $phone;
	}

	public function routeNotificationForTwilio() {
		$phone = phoneFormatInt($this->phone, $this->country_code);
		$phone = setPhoneSign($phone, 'twilio');

		return $phone;
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token) {
		if (Request::filled('email') || Request::filled('phone')) {
			if (Request::filled('email')) {
				$field = 'email';
			} else {
				$field = 'phone';
			}
		} else {
			if (!empty($this->email)) {
				$field = 'email';
			} else {
				$field = 'phone';
			}
		}

		try {
			$this->notify(new ResetPasswordNotification($this, $token, $field));
		} catch (\Exception $e) {
			flash()->error($e->getMessage());
		}
	}

	/**
	 * @return bool
	 */
	public function canImpersonate() {
		// Cannot impersonate from Demo website,
		// Non admin users cannot impersonate
		if (isDemo() || $this->is_admin != 1) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function canBeImpersonated() {
		// Cannot be impersonated from Demo website,
		// Admin users cannot be impersonated,
		// Users with the 'can_be_impersonated' attribute != 1 cannot be impersonated
		if (isDemo() || $this->is_admin == 1 || $this->can_be_impersonated != 1) {
			return false;
		}

		return true;
	}

	public function getNameHtml() {
		// Get all the User's attributes
		$user = self::findOrFail($this->getKey());

		$out = '';
		$out .= '<span style="float:left;">' . $user->name . '</span>';
		$out .= ' ';
		$out .= '<span style="float:right;">';
		if ($user->getKey() == auth()->user()->getAuthIdentifier()) {
			$tooltip = '" data-toggle="tooltip" title="' . t('Cannot impersonate yourself') . '"';
			$out .= '<a class="btn btn-xs btn-danger" ' . $tooltip . '><i class="fa fa-btn fa-lock"></i></a>';
		} else if ($user->is_admin == 1) {
			$tooltip = '" data-toggle="tooltip" title="' . t('Cannot impersonate admin users') . '"';
			$out .= '<a class="btn btn-xs btn-danger" ' . $tooltip . '><i class="fa fa-btn fa-lock"></i></a>';
		} else if (!isVerifiedUser($user)) {
			$tooltip = '" data-toggle="tooltip" title="' . t('Cannot impersonate unactivated users') . '"';
			$out .= '<a class="btn btn-xs btn-danger" ' . $tooltip . '><i class="fa fa-btn fa-lock"></i></a>';
		} else {
			$tooltip = '" data-toggle="tooltip" title="' . t('Impersonate this user') . '"';
			$impersonateUrl = route('impersonate', $this->getKey());
			$out .= '<a class="btn btn-xs btn-default" href="' . $impersonateUrl . '" ' . $tooltip . '><i class="fa fa-btn fa-sign-in"></i></a>';
		}
		$out .= '</span>';

		return $out;
	}

	public function getCountryHtml() {
		$iconPath = 'images/flags/16/' . strtolower($this->country_code) . '.png';
		if (file_exists(public_path($iconPath))) {
			$out = '';
			$out .= '<a href="' . url('/') . '?d=' . $this->country_code . '" target="_blank">';
			$out .= '<img src="' . url($iconPath) . getPictureVersion() . '" data-toggle="tooltip" title="' . $this->country_code . '" alt="' . strtolower($this->country_code) . '.png">';
			$out .= '</a>';
			return $out;
		} else {
			return $this->country_code;
		}
	}

	// get Go-code in admin user listing 
	public function getGocodeHtml() {
		
		$go_code = '';
		if (isset($this->profile->go_code)) {
			
			$go_code = $this->profile->go_code;
		} 
		return $go_code;
	}

	public function getStatus() {

		if($this->active == 1){
			return '<small class="label label-success">Active</small>';
		}else{
			return '<small class="label label-danger">Inactive</small>';
		}
	}

	/*
		    |--------------------------------------------------------------------------
		    | RELATIONS
		    |--------------------------------------------------------------------------
	*/
	public function posts() {
		return $this->hasMany(Post::class, 'user_id');
	}

	public function profile() {
		return $this->hasone(UserProfile::class, 'user_id');
	}

	public function address() {
		return $this->hasone(UserAddress::class, 'user_id');
	}

	public function company() {
		return $this->hasone(Company::class, 'user_id');
	}

	public function gender() {
		return $this->belongsTo(Gender::class, 'gender_id');
	}

	public function messages() {
		return $this->hasManyThrough(Message::class, Post::class, 'user_id', 'post_id');
	}

	public function savedPosts() {
		return $this->belongsToMany(Post::class, 'saved_posts', 'user_id', 'post_id');
	}

	public function savedSearch() {
		return $this->hasMany(SavedSearch::class, 'user_id');
	}

	public function userType() {
		return $this->belongsTo(UserType::class, 'user_type_id');
	}

	public function userMessages() {
		return $this->hasMany(Message::class, 'to_user_id');
	}

	public function totalInviations() {
		if( Auth::User()->user_type_id == 2 ){
			return $this->hasMany(Message::class, 'from_user_id')->where('message_type', 'Invitation');
		} else {
			return $this->hasMany(Message::class, 'to_user_id')->where('message_type', 'Invitation');
		}
	}

	public function unread_userMessages() {
		return $this->hasMany(Message::class, 'to_user_id')->where('is_read','=', 0);
	}

	public function totalConversation() {
		if( Auth::User()->user_type_id == 2 ){
			return $this->hasMany(Message::class, 'from_user_id')->where('parent_id', 0);
		} else {
			return $this->hasMany(Message::class, 'to_user_id')->where('parent_id', 0);
		}
	}

	//check user conversation also check post is active or not
	public function userPostConversation() {
		return $this->totalConversation()->wherehas('post', function($q){
			$q->where('archived', 0)->whereNull('deleted_at');
		})->wherehas('from_user', function($q){
			$q->whereNull('deleted_at');
		})->wherehas('to_user', function($q){
			$q->whereNull('deleted_at');
		});
	}

	public function totalUnreadMsg() {
		return $this->userMessages()->with('post')->wherehas('post', function($q){
			$q->where('archived', 0)->whereNull('deleted_at');
		})->wherehas('from_user', function($q){
			$q->whereNull('deleted_at');
		})->where('from_user_id','!=', Auth::User()->id)->where('parent_id','!=','0')->where('is_read','=', 0);
	}

	public function totalDirectUnreadMsg() {
		return $this->userMessages()->wherehas('from_user', function($q){
			$q->whereNull('deleted_at');
		})->where('post_id', 0)->where('parent_id','!=','0')->where('is_read','=', 0);
	}

	public function userLanguages() {
		return $this->hasMany(UserLanguages::class, 'user_id');
	}

	public function userEducations() {
		return $this->hasMany(UserEducations::class, 'user_id');
	}

	public function userExperiences() {
		return $this->hasMany(UserExperiences::class, 'user_id');
	}

	public function userReferences() {
		return $this->hasMany(UserReferences::class, 'user_id');
	}

	public function userTalentes() {
		return $this->hasMany(UserTalents::class, 'user_id');
	}

	public function userWorkSettings() {
		return $this->hasone(UserWorkSetting::class, 'user_id');
	}

	
	public function country()
    {
        return $this->belongsTo(Country::class, 'country_code');
    }

    public function userposts(){
    	return $this->posts()->where('archived', 0);
    }

    public function totalUnreadConversation() {
		return $this->userMessages()->with('post')->wherehas('post', function($q){
			$q->where('archived', 0);
		})->where('from_user_id','!=', Auth::User()->id)->where('parent_id','!=','0')->where('is_read','=', 0)->groupby('parent_id');
	}

	public function appliedJobs() {
		return $this->jobApplication()->with('post')->wherehas('post', function($q){
			$q->where('archived', 0);
		});
	}

	// get visit count of particular user
	public function userVisits()
    {
       return $this->hasMany(UserView::class, 'user_id');
    }
    public function modelbook() {
		return $this->hasMany(ModelBook::class, 'user_id');
	}

	public function resume() {
		return $this->hasOne(Resume::class, 'user_id');
	}

	public function jobApplication() {
		return $this->hasMany(JobApplication::class, 'user_id');
	}

	public function favoriteUser() {
		return $this->hasMany(Favorite::class, 'user_id');
	}

	public function favoritePost() {
		return $this->hasMany(SavedPost::class, 'user_id');
	}

	public function userSedcard() {
		return $this->hasMany(Sedcard::class, 'user_id')->orderBy('image_type');
	}

	/*
		    |--------------------------------------------------------------------------
		    | SCOPES
		    |--------------------------------------------------------------------------
	*/
	public function scopeVerified($builder) {
		$builder->where(function ($query) {
			$query->where('verified_email', 1)->where('verified_phone', 1);
		});

		return $builder;
	}

	public function scopeUnverified($builder) {
		$builder->where(function ($query) {
			$query->where('verified_email', 0)->orWhere('verified_phone', 0);
		});

		return $builder;
	}

	/*
		    |--------------------------------------------------------------------------
		    | ACCESORS
		    |--------------------------------------------------------------------------
	*/
	public function getCreatedAtAttribute($value) {

		if (!$this->preventAttrSet) {
			$value = Date::parse($value);
			if (config('timezone.id')) {
				$value->timezone(config('timezone.id'));
			}
		}
		//echo $value->format('l d F Y H:i:s').'<hr>'; exit();
		//echo $value->formatLocalized('%A %d %B %Y %H:%M').'<hr>'; exit(); // Multi-language

		return $value;
	}

	public function getUpdatedAtAttribute($value) {
		
		if (!$this->preventAttrSet) {
			$value = Date::parse($value);
			if (config('timezone.id')) {
				$value->timezone(config('timezone.id'));
			}
		}

		return $value;
	}

	public function getLastLoginAtAttribute($value) {
		$value = Date::parse($value);
		if (config('timezone.id')) {
			$value->timezone(config('timezone.id'));
		}

		return $value;
	}

	public function getDeletedAtAttribute($value) {
		$value = Date::parse($value);
		if (config('timezone.id')) {
			$value->timezone(config('timezone.id'));
		}

		return $value;
	}

	public function getCreatedAtTaAttribute($value) {

		// if (!isset($this->attributes['created_at']) and is_null($this->attributes['created_at'])) {
		// 	return null;
		// }

		if(isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])){
			Date::setLocale(app()->getLocale());
			$value = Date::parse($this->attributes['created_at']);
			if (config('timezone.id')) {
				$value->timezone(config('timezone.id'));
			}
			$value = $value->ago();
			return $value;
		}

		return null;

	}

	public function getEmailAttribute($value) {
		if (
			isDemo() &&
			Request::segment(2) != 'password'
		) {
			if (auth()->check()) {
				if (auth()->user()->id != 1) {
					$value = hideEmail($value);
				}
			}

			return $value;
		} else {
			return $value;
		}
	}

	public function getPhoneAttribute($value) {
		// $countryCode = config('country.code');
		// if (isset($this->country_code) && !empty($this->country_code)) {
		// 	$countryCode = $this->country_code;
		// }

		// $value = phoneFormatInt($value, $countryCode);

		return $value;
	}

	public static function getUserBySlug($slug){
		return User::withoutGlobalScopes()->with('profile')->where('hash_code', $slug)->first();
	}

	public function getCountryNameAttribute($value)
    {
        $country = new CountryHelper();
        if ($name = $country->get($this->country_code, config('app.locale'))) {
            return $name;
        } else {
            return '';
        }
    }

    //return all inactive profile images for crm approval
    public static function getPendingProfileImages($offset, $limit, $go_code=null, $status, $timestamp=null, $user_type=null, $stage=null, $categories=array(), $regions=array()){
		
		$preventAttrSet = true;

		if( isset($timestamp) & !empty($timestamp) ){
			$datetime = date('Y-m-d H:i:s', $timestamp);
			//$datetime = date('Y-m-d H:i:s', strtotime($datetime));
		}

		if( isset($go_code) && $go_code != null ){

			$profile = User::withoutGlobalScopes()->select('users.id as user_id','users.username as wpusername','up1.logo as image_url','up1.go_code','users.user_type_id as user_type', 'users.is_profile_pic_approve as profile_image_status','up1.logo_updated_at')
			    ->join('user_profile as up1', 'users.id', '=', 'up1.user_id')
			    ->where('up1.go_code','=', $go_code);


			$count = $profile->count();
			$data = $profile->get()->toArray();
			
			if($count == 0){
				return array(
					'status' => false, 'message' => 'Users date not found','count' =>0,'from' => 0,'to'  => 0, 'data' => 0
				); exit();
			}
		
		}else{

			$profile = User::withoutGlobalScopes()->select('users.id as user_id','users.username as wpusername','up1.logo as image_url','up1.go_code','users.user_type_id as user_type','users.is_profile_pic_approve as profile_image_status','up1.logo_updated_at', 'countries.country_type')
			    ->join('user_profile as up1', 'users.id', '=', 'up1.user_id')
			    ->join('countries', 'users.country_code', '=', 'countries.code')
			    ->leftjoin('posts as po', 'po.user_id', '=', 'up1.user_id')
			    ->leftjoin('payments as pt', 'pt.post_id', '=', 'po.id');
			    
			    // check categories not empty and join with model category table
				if(!empty($categories) && count($categories) > 0){
				 	$profile->join('model_categories as c', 'c.id', '=', 'up1.category_id');
					$categoriesArr = array_map('trim', $categories);
					$profile->whereIn('c.slug', $categoriesArr);
				}

				// check country code not empty
				if(!empty($regions) && count($regions) > 0){
					$regionsArr = array_map('trim', $regions);
					$profile->whereIn('users.country_code', $regionsArr);
				}

				if($status == 0){
					$profile->where('users.is_profile_pic_approve','!=', 1);
				}else{
					$profile->where('users.is_profile_pic_approve', $status);
				}

				// $profile->where('users.is_profile_pic_approve', $status);

			    // default condition not consider deleted users
	            if( isset($stage) && !empty($stage) ){
	            	
	            	// stage -> lead return only register users who is active =0, is_registered =1, subscribed_payment =pending, subscription_type =free,

	            	if($stage == 'lead'){

	            		$profile->where('users.active', 0)
	            		->where('users.is_register_complated', 0);

	            		if($user_type == config('constant.model_type_id')){
	            			$profile->where('users.subscribed_payment', 'pending')
	            			->where('users.subscription_type', 'free');
	            		}
	            	}

	            	// stage -> contract return only register users who is active =1, is_registered =1, subscribed_payment =pending, subscription_type =free,
	            	
	            	if($stage == 'contract'){

	            		$profile->where('users.active', 1)
	            		->where('users.is_register_complated', 1);
	            		
	            		if($user_type == config('constant.model_type_id')){
	            			
	            			$profile->where('users.subscribed_payment', 'pending')
	            			->where('users.subscription_type', 'free');
		            	}
					}

	            	// stage -> paid return only register users who is active =1, is_registered =1,  subscribed_payment =complete, subscription_type =paid,

	            	if($stage == 'paid'){

	            		$profile->where('users.active', 1)
	            		->where('users.is_register_complated', 1);

	            		if($user_type == config('constant.model_type_id')){
	            			$profile->where('users.subscribed_payment', 'complete')
	            			->where('users.subscription_type', 'paid');
	            		}
	            	}

	            	// stage -> active return only register users who is active =1 only,
	            	if($stage == 'active'){
	            		$profile->where('users.active', 1);
	            	}
	            }
			    
			    //For particluar date
			    if(isset($datetime) && $datetime!=''){
			    	$profile->where('up1.logo_updated_at', '<=', $datetime);
			    }

			    //For user type date
			    if(isset($user_type) && $user_type!=''){
			    	$profile->where('users.user_type_id', $user_type);
			    }else{
			    	$profile->where(function ($query) {
		                $query->where('users.user_type_id', config('constant.model_type_id'))
		                      ->orWhere('users.user_type_id', config('constant.partner_type_id'));
		            });
			    }
			    $profile->whereNull('users.deleted_at');
			    $count = $profile->count();
			    $data = $profile->orderby('up1.logo_updated_at', 'desc')->skip($offset)->take($limit)->get()->toArray();
		}
		$number_of_record =  $offset+1;
		if(count($data) > 0 ){
			
			foreach ($data as $key => $value) {

				if( isset($value['image_url']) && !empty($value['image_url']) ){
					$data[$key]['image_url'] = \Storage::url($value['image_url']);
				}
				
				if($value['profile_image_status'] == 1){
					$status_str = "Approved";
				}else if($value['profile_image_status'] == 2){
					$status_str = "Rejected";
				}else{
					$status_str = "Pending";
				}

				$user_type = "";

				if($value['user_type'] == config('constant.model_type_id')){
					$user_type = config('constant.crm_model');
				}

				if($value['user_type'] == config('constant.partner_type_id')){
					$user_type = config('constant.crm_partner');
				}


				$data[$key]['user_type'] = $user_type;
				$data[$key]['profile_image_status'] = $status_str;
				$data[$key]['user_status'] = $stage;
				$data[$key]['country_type'] = $value['country_type'];
				$data[$key]['status'] = $value['profile_image_status'];
				$data[$key]['number_of_record'] = $number_of_record .' / '. $count;
				
				// unset append for created
				unset($data[$key]['created_at_ta']);
				$number_of_record++;

			}

			return array('status' => true,'message' => 'records fetch successfully','count' => $count,'from' => $offset,
				'to'  => $limit, 'data' => $data);

		}else{
			return array(
				'status' => false, 'message' => 'Users date not found','count' =>0,'from' => 0,'to'  => 0, 'data' => 0
			);
		}
	}

	/*
		    |--------------------------------------------------------------------------
		    | MUTATORS
		    |--------------------------------------------------------------------------
	*/
}
