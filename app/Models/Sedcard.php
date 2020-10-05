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

use App\Models\Scopes\ActiveScope;
use App\Observer\SedcardObserver;
use Illuminate\Support\Facades\Storage;
use Larapen\Admin\app\Models\Crud;
use Illuminate\Support\Facades\DB;

class Sedcard extends BaseModel {
	use Crud;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sedcard';

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';

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
	protected $fillable = ['country_code', 'user_id', 'name', 'image_type', 'filename', 'active'];

	/**
	 * The attributes that should be hidden for arrays
	 *
	 * @var array
	 */
	// protected $hidden = [];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at'];

	/*
		    |--------------------------------------------------------------------------
		    | FUNCTIONS
		    |--------------------------------------------------------------------------
	*/
	protected static function boot() {
		parent::boot();

		Sedcard::observe(SedcardObserver::class);

		// static::addGlobalScope(new ActiveScope());
	}

	/*
		    |--------------------------------------------------------------------------
		    | RELATIONS
		    |--------------------------------------------------------------------------
	*/
	public function post() {
		return $this->hasMany(Post::class);
	}
	public function user() {
		return $this->belongsToMany(User::class, 'user_id', 'id');
	}

	/*
		    |--------------------------------------------------------------------------
		    | SCOPES
		    |--------------------------------------------------------------------------
	*/

	/*
		    |--------------------------------------------------------------------------
		    | ACCESORS
		    |--------------------------------------------------------------------------
	*/
	public function getNameAttribute() {
		$value = null;

		if (isset($this->attributes) && isset($this->attributes['name'])) {
			$value = $this->attributes['name'];
		}

		if (empty($value)) {
			$value = last(explode('/', $this->attributes['filename']));
		}

		return $value;
	}

	public function getFilenameAttribute() {
		if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
			return null;
		}

		$value = $this->attributes['filename'];
		// Fix path
		// $value = str_replace('uploads/sedcard/', '', $value);
		// $value = str_replace('sedcard/', '', $value);
		// $value = 'sedcard/' . $value;

		if (!Storage::exists($value)) {
			return null;
		}

		// $value = 'uploads/' . $value;

		return $value;
	}

	/*
		    |--------------------------------------------------------------------------
		    | MUTATORS
		    |--------------------------------------------------------------------------
	*/
	// public function setFilenameAttribute($value) {
	// 	// print_r($this->attributes);exit;
	// 	$field_name = 'sedcard.filename' . $this->attributes['image_type'];
	// 	// echo $field_name;exit;
	// 	$attribute_name = 'filename';
	// 	$disk = config('filesystems.default');

	// 	// Set the right field name
	// 	$request = \Request::instance();
	// 	if (!$request->hasFile($field_name)) {
	// 		$field_name = $attribute_name;
	// 		$this->attributes['name'] = last(explode('/', $this->attributes['filename']));
	// 	}

	// 	if (!isset($this->country_code) || !isset($this->user_id)) {
	// 		$this->attributes[$attribute_name] = null;
	// 		return false;
	// 	}

	// 	// Path
	// 	$destination_path = 'sedcard/'.$this->user_id;

	// 	// Upload
	// 	$this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path);
	// }


	public static function getPendingSedcardRecords($image_type, $offset, $limit, $user_type=null, $application_date=null, $payment_date=null, $current_date=null, $go_code=array(), $status, $categories=array(), $regions=array(), $stage=null){
			
			$sedcard = User::withoutGlobalScopes()->with('userSedcard')->select('users.*', 'countries.country_type')
				->leftjoin('sedcard', 'users.id', '=', 'sedcard.user_id')
				->join('countries', 'users.country_code', '=', 'countries.code')
			    ->join('user_profile as up1', 'users.id', '=', 'up1.user_id');
			
			// check categories not empty and join with model category table 
			if(!empty($categories) && count($categories) > 0){
			 	$sedcard->join('model_categories as c', 'c.id', '=', 'up1.category_id');
			}

			// check payment date not empty and join with post, payment table
			if(isset($payment_date) && $payment_date != ""){
				$sedcard->join('posts', 'posts.user_id', '=', 'up1.user_id')
				->join('payments', 'payments.post_id', '=', 'posts.id');
			}
			
			// get record user paid/unpaid
			if(isset($user_type) && $user_type != ""){
				if($user_type == 'paid'){
					$sedcard->where('users.subscribed_payment', 'complete');
				}else if($user_type == 'unpaid'){
					$sedcard->where('users.subscribed_payment', 'pending');
				}
			}

			// get record application date wise
			if(isset($application_date) && $application_date != ""){
				$sedcard->whereBetween('users.created_at', [$application_date, $current_date]);
			}

			// get record payment date wise
			if(isset($payment_date) && $payment_date != ""){
				$sedcard->where('transaction_status', 'approved')->whereBetween('payments.created_at', [$payment_date, $current_date]);
			}

			// check status is !empty
			if($status != 'nok'){
			 	// add condition user profile status approve or not
				$sedcard->where( function($query) use($status){
					return $query->where('users.is_profile_pic_approve', $status)->orwhere('sedcard.active', $status); 
				});
			}

			if($stage != 'chat'){
				$sedcard->where('users.active', 1);
			}

			// category where in query
			if(!empty($categories) && count($categories) > 0){
				$categoriesArr = array_map('trim', $categories);
				$sedcard->whereIn('c.slug', $categoriesArr);
			}

			// check country code not empty
			if(!empty($regions) && count($regions) > 0){
				$regionsArr = array_map('trim', $regions);
				$sedcard->whereIn('users.country_code', $regionsArr);
			}

			// go code where in
			if(isset($go_code) && !empty($go_code)){
				$sedcard->whereIn('up1.go_code', $go_code);
			}

			// if(isset($payment_date) && $payment_date != ""){
			// 	$sedcard->groupby('users.id');
			// }
			$sedcard->distinct('users.id');
			$sedcard = $sedcard->orderby('users.id', 'desc')->orderby('sedcard.updated_at', 'desc');
			$count = $sedcard->count();

			if(isset($go_code) && !empty($go_code)){
				$userObj = $sedcard->get();
			}else{
				$userObj = $sedcard->skip($offset)->take($limit)->get();
			}
			
			$userArr = array();
			$number_of_record =  $offset+1;
			if(isset($userObj) && !empty($userObj)){
				foreach ($userObj as $key => $user) {
					$sedcardArr = array();
					$profile_image = "";
					
					if(isset($user->profile->logo) && !empty($user->profile->logo)){
						$profile_image = \Storage::url($user->profile->logo);
					}

					if(isset($user->userSedcard) && $user->userSedcard->count() > 0){
							
						$userSedcard = $user->userSedcard;
						if( $image_type != ""  ){
							$userSedcard = $user->userSedcard->where('image_type', $image_type);
						}
						$i = 0;

						foreach ($userSedcard as $key => $sedcard) {

							$sedcardArr[$i]['user_id'] = $sedcard->user_id;
							$sedcardArr[$i]['image_id'] = $sedcard->id;

							if( isset($sedcard->filename) && !empty($sedcard->filename) ){
								$sedcardArr[$i]['image_url'] = \Storage::url($sedcard->filename);
							}

				            $sedcardArr[$i]['image_name'] = $sedcard->name;
				            $sedcardArr[$i]['image_type'] = $sedcard->image_type;
				            $sedcardArr[$i]['status'] = $sedcard->active;
				            $sedcardArr[$i]['country_type'] = $user->country_type;
				            $sedcardArr[$i]['number_of_record'] = $number_of_record .' / '. $count;

				            $i++;
						}
					}
					
					$sedcardArr[count($sedcardArr)] = ['user_id' => $user->id, 'profile_image' => $profile_image, 'image_type' => 0, 'status' => $user->is_profile_pic_approve, 'country_type' => $user->country_type, 'number_of_record' => $number_of_record .' / '. $count, ];
					$userArr[$user->profile->go_code] = $sedcardArr;
					$number_of_record++;
				}
			}
			return array(
				'status' => true,
				'message' => 'records fetch successfully',
				'count' => $count,
				'from' => $offset,
				'to'  => $limit,
				'data' => $userArr
			);
	}

	/*
	public static function getPendingSedcardRecordsById($go_code, $sedcardtype=null, $user_type=null, $application_date=null, $payment_date=null, $current_date=null){

		if( isset($go_code) && !empty($go_code) ){

			$users = User::withoutGlobalScopes()->SELECT('users.*','up.*')->with('userSedcard')
				->JOIN('user_profile as up', 'users.id', '=', 'up.user_id');

			if(isset($payment_date) && $payment_date != ""){
				$users->join('posts', 'posts.user_id', '=', 'up1.user_id')
				->join('payments', 'payments.post_id', '=', 'posts.id');
			}

			if( isset($user_type) && $user_type != ""){
				if($user_type == 'paid'){
					$users->where('users.subscribed_payment', 'complete')->whereIn('users.subscription_type', array('free','paid'));
				}else if($user_type == 'unpaid'){
					$users->where('users.subscribed_payment', 'pending')->where('users.subscription_type', '=' ,'free');
				}
			}

			if(isset($application_date) && $application_date != ""){
				$users->whereBetween('users.created_at', [$application_date, $current_date]);
			}

			if(isset($payment_date) && $payment_date != ""){
				$users->where('payments.transaction_status', 'approved')->whereBetween('payments.created_at', [$payment_date, $current_date]);
			}

			$users = $users->where('users.active', 1)
				->where('users.user_type_id', 3)
				->where('users.verified_email', 1)
				->where('users.verified_phone', 1)
				->whereNull('users.deleted_at')
				->whereIn('up.go_code', $go_code)
				->get();


			$valid_users = array();
			$invalid_users = array();

			if( isset($users) && !empty($users) ){
				$i = $v = 0;

				foreach ($users as $key => $user) {
					if( isset($user->go_code) && in_array($user->go_code, $go_code) ){
						$valid_users[$i] = $user->user_id; $i++;
					}else{
						$invalid_users[$v] = $user->user_id; $v++;
					}
				}
			}

			$userArr = array();

			if(isset($users) && !empty($users) && $users->count() > 0 ){

				foreach ($users as $key => $user) {

					if(isset($user->profile->go_code) && in_array($user->profile->go_code, $go_code)){

						if (($key = array_search($user->profile->go_code, $go_code)) !== false) {
						    unset($go_code[$key]);
						}

						$sedcardArr = array();

						$profile_image = "";
						if(isset($user->profile->logo) && !empty($user->profile->logo)){
							$profile_image = \Storage::url($user->profile->logo);
						}


						if(isset($user->userSedcard) && $user->userSedcard->count() > 0){
							
							$userSedcard = $user->userSedcard;
							if(isset($user) && isset($user->userSedcard) && $sedcardtype != ""){
								$userSedcard = $user->userSedcard->where('image_type', $sedcardtype);
							}

							$i = 0;

							foreach ($userSedcard as $key => $sedcard) {

								$sedcardArr[$i]['image_id'] = $sedcard->id;
								//$sedcardArr[$i]['profile_image'] = $profile_image;

								if( isset($sedcard->filename) && !empty($sedcard->filename) ){
									$sedcardArr[$i]['image_url'] = \Storage::url($sedcard->filename);
								}

					            // $sedcardArr[$i]['go_code'] = $user->profile->go_code;
					            $sedcardArr[$i]['image_name'] = $sedcard->name;
					            $sedcardArr[$i]['image_type'] = $sedcard->image_type;
					            $sedcardArr[$i]['status'] = $sedcard->active;

					            $i++;
							}
						}

						$sedcardArr[count($sedcardArr)] = ['profile_image' => $profile_image, 'image_type' => 0, 'status' => ($user->profile->is_profile_pic_approve == 1)? 1 : 0 ];
						$userArr[$user->profile->go_code] = $sedcardArr;
					}
				}
			}


			$emptySedcard = array();
			if(isset($go_code) && !empty($go_code)){
				foreach ($go_code as $key => $code) {
					$emptySedcard[$code] = array();
				}
			}

			$usersedcards = array_merge($userArr, $emptySedcard);

			return array(
				'status' => true,
				'message' => 'records fetch successfully',
				'data' => $usersedcards
			);

			// if( !empty($valid_users) ){
				
			// 	$sedcards = Sedcard::select('sedcard.id as image_id','up.logo as profile_image','up.go_code','sedcard.name as image_name', 'sedcard.filename as image_url',  'sedcard.image_type','sedcard.active as status')
			// 	->JOIN('user_profile as up', 'sedcard.user_id', '=', 'up.user_id')
			// 	->whereIn('sedcard.user_id', $valid_users)->get()->toArray();

			// 	 echo "<pre>"; print_r($sedcards); echo "</pre>"; exit(); 

			// 	$userObject = array();


			// 	if(isset($sedcards) && !empty($sedcards)){

			// 		$i = 0;
			// 		foreach ($sedcards as $key => $sedcard) {

			// 			if(isset($sedcard['go_code']) && in_array($sedcard['go_code'], $go_code)){

			// 				$userObject[$i]['image_id'] = $sedcard['image_id'];

			// 				if( isset($sedcard['profile_image']) && !empty($sedcard['profile_image']) ){
			// 					$userObject[$i]['profile_image'] = \Storage::url($sedcard['profile_image']);
			// 				}

			// 				if( isset($sedcard['image_url']) && !empty($sedcard['image_url']) ){
			// 					$userObject[$i]['image_url'] = \Storage::url($sedcard['image_url']);
			// 				}

			// 	            $userObject[$i]['go_code'] = $sedcard['go_code'];
			// 	            $userObject[$i]['image_name'] = $sedcard['image_name'];
			// 	            $userObject[$i]['image_type'] = $sedcard['image_type'];
			// 	            $userObject[$i]['status'] = $sedcard['status'];
			// 			}
			// 		}
			// 	}

			// 	$userObject['go_code'] = $go_code;

			// 	if( count($sedcard) > 0 ) {

			// 		foreach ($sedcard as $key => $value) {
			// 			if( isset($value['image_url']) && !empty($value['image_url']) ){
			// 				$sedcard[$key]['image_url'] = \Storage::url($value['image_url']);
			// 			}
			// 		}

			// 		$userObject['sedcard_images'] = $sedcard;

			// 		return array(
			// 			'status' => true,
			// 			'message' => 'records fetch successfully',
			// 			'data' => $userObject
			// 		);
					
			// 	} else {
			// 		return array(
			// 			'status' => false,
			// 			'message' => 'images not found',
			// 			'data' => []
			// 		);

			// 	}


			// } else {

			// 	return array(
			// 		'status' => false,
			// 		'message' => 'Invalid user go-code',
			// 		'data' => []
			// 	);
			// }

		} else {

			return array(
				'status' => false,
				'message' => 'Go-code is required',
				'data' => []
			);
		}
	}*/

	public static function getSedcardGoCode($status, $offset, $limit){
		
		$sedcard = Sedcard::select('up1.go_code')
				->join('users as u1', 'u1.id', '=', 'sedcard.user_id')
			    ->join('user_profile as up1', 'u1.id', '=', 'up1.user_id')
			    ->where('sedcard.active', $status)
			    ->where('u1.active', 1)
			    ->groupby('up1.go_code');


			$count = $sedcard->get()->count();
			$data = $sedcard->orderby('sedcard.updated_at', 'desc')->skip($offset)->take($limit)->get()->toArray();
			
			return array(
				'status' => true,
				'message' => 'records fetch successfully',
				'count' => $count,
				'from' => $offset,
				'to'  => $limit,
				'data' => $data
			);
	}
}
