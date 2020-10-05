<?php

namespace App\Models;

use App\Observer\ProfileObserver;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;
use Larapen\Admin\app\Models\Crud;

class UserProfile extends BaseUser {
	use Crud;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'user_profile';

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

	protected $appends = ['created_at_ta', 'full_name', 'full_name_parent'];

	public $preventAttrSet = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'go_code',
		'contract_link',
		'package',
		'first_name',
		'last_name',
		'fname_parent',
		'lname_parent',
		'birth_day',
		'company_name',
		'category_id',
		'ip_address',
		'street',
		'zip',
		'city',
		'piercing',
		'tattoo',
		'description',
		'status',
		'height_id',
		'weight_id',
		'clothing_size_id',
		'eye_color_id',
		'hair_color_id',
		'size_id',
		'shoes_size_id',
		'skin_color_id',
		'facebook',
		'twitter',
		'google_plus',
		'linkedin',
		'pinterest',
		'website_url',
		'parent_category',
		'address_line1',
		'address_line2',
		'language',
		'newsletter',
		'timezone',
		'geo_state',
		'preferred_language',
	];

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

		UserProfile::observe(ProfileObserver::class);
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
	public function cities()
    {
        return $this->belongsTo(City::class, 'city');
    }
    
    public function modelcategory() {
		return $this->belongsTo(ModelCategory::class, 'category_id', 'id');
	}

	public function partnercategory() {
		return $this->belongsTo(Branch::class, 'category_id', 'id');
	}

	public function getHeight() {
		return $this->belongsTo(UserHeightUnitOptions::class, 'height_id', 'id');
	}

	public function getWeight() {
		return $this->belongsTo(UserWeightUnitsOptions::class, 'weight_id', 'id');
	}

	public function getWaist() {
		return $this->belongsTo(UserWaistUnitOptions::class, 'waist_id', 'id');
	}

	public function getChest() {
		return $this->belongsTo(UserChestUnitOptions::class, 'chest_id', 'id');
	}

	public function getHips() {
		return $this->belongsTo(UserHipsUnitOptions::class, 'hips_id', 'id');
	}

	public function getTimeZone() {
		
		return $this->belongsTo(TimeZone::class, 'timezone', 'id');
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
			$value = last(explode('/', $this->attributes['logo']));
		}

		return $value;
	}

	public function getLogoAttribute() {
		if (!isset($this->attributes) || !isset($this->attributes['logo'])) {
			return null;
		}

		$value = $this->attributes['logo'];

		
		if($value && $value !== ""){
			// Fix path
			// $value = str_replace('uploads/profile/logo/', '', $value);
			// $value = str_replace('profile/logo/', '', $value);
			// $value = 'profile/logo/' . $value;
		}
		// echo "<pre>";
		// print_r ($value);
		// exit();
		if (!Storage::exists($value) || $value == 'profile/logo/') {
			return null;
		}

		// $value = 'uploads/' . $value;

		return $value;
	}

	public static function getLogoThumb($user_id, $image_path, $size) {

		$thumb = config('constant.THUMB');

		if( isset($image_path) && isset($size) && !empty($image_path) ){

			$thumb_image = str_replace($user_id.'/', $user_id.DIRECTORY_SEPARATOR.$thumb.DIRECTORY_SEPARATOR.$size.'_', $image_path);

			if(Storage::exists($thumb_image)){
				return $thumb_image;
			}
		}

		return $image_path;
	}

	/*
		    |--------------------------------------------------------------------------
		    | MUTATORS
		    |--------------------------------------------------------------------------
	*/
    /*
	public function setLogoAttribute($value) {

		if (!$this->preventAttrSet) {
			$field_name = 'profile.logo';
			$attribute_name = 'logo';
			$disk = config('filesystems.default');

			// Set the right field name
			$request = \Request::instance();
			if (!$request->hasFile($field_name)) {
				$field_name = $attribute_name;
			}

			// if (!isset($this->country_code) || !isset($this->user_id)) {
			//     $this->attributes[$attribute_name] = null;
			//     return false;
			// }

			// Path
			$destination_path = 'profile'.DIRECTORY_SEPARATOR.'logo'.DIRECTORY_SEPARATOR.$this->user_id;

			// Upload
			$this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path, $this->user_id, true, config('constant.PROFILE_THUMB'));
		} else {
			$this->attributes['logo']  = $value;
		}
	}
	*/

	public function getCoverAttribute() {
		
		

			if (!isset($this->attributes) || !isset($this->attributes['cover'])) {
				return null;
			}

			$value = $this->attributes['cover'];

			// Fix path
			// $value = str_replace('uploads/profile/cover/', '', $value);
			// $value = str_replace('profile/cover/', '', $value);
			// $value = 'profile/cover/' . $value;

			// if (!Storage::exists($value)) {
			// 	return null;
			// }

			if (!Storage::exists($value) || $value == 'profile/cover/') {
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
	public function setCoverAttribute($value) {

		if (!$this->preventAttrSet) {
			$field_name = 'profile.cover';
			$attribute_name = 'cover';
			$disk = config('filesystems.default');

			// Set the right field name
			$request = \Request::instance();
			if (!$request->hasFile($field_name)) {
				$field_name = $attribute_name;
			}

			// if (!isset($this->country_code) || !isset($this->user_id)) {
			//     $this->attributes[$attribute_name] = null;
			//     return false;
			// }

			// Path
			$destination_path = 'profile/cover/'. $this->user_id;

			// Upload
			$this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path);
		} else {
			$this->attributes['cover']  = $value;
		}
	}

	public function getCreatedAtAttribute($value) {
		$value = Date::parse($value);
		if (config('timezone.id')) {
			$value->timezone(config('timezone.id'));
		}
		//echo $value->format('l d F Y H:i:s').'<hr>'; exit();
		//echo $value->formatLocalized('%A %d %B %Y %H:%M').'<hr>'; exit(); // Multi-language

		return $value;
	}

	public function getCreatedAtTaAttribute($value) {
		if (!isset($this->attributes['created_at']) and is_null($this->attributes['created_at'])) {
			return null;
		}

		Date::setLocale(app()->getLocale());
		$value = Date::parse($this->attributes['created_at']);
		if (config('timezone.id')) {
			$value->timezone(config('timezone.id'));
		}
		$value = $value->ago();

		return $value;
	}

	// public function getBirthDayAttribute() {

	// 	if (!isset($this->attributes) || !isset($this->attributes['birth_day'])) {
	// 		return null;
	// 	}

	// 	$value = $this->attributes['birth_day'];

	//  	if(!empty($value)){
	//  		$value = date("m/d/Y", strtotime($value));
	//  	}else{
	//  		$value = date("m/d/Y");
	//  	}
		
	// 	return $value;
	// }

	public function getFullNameAttribute() {
		$value = null;
		
		$first_name = $last_name = "";

		if (isset($this->attributes) && isset($this->attributes['first_name'])) {
			$first_name = ucfirst($this->attributes['first_name']);
		}

		if (isset($this->attributes) && isset($this->attributes['last_name'])) {
			$last_name = ucfirst($this->attributes['last_name']);
		}

		//return $first_name.' '.$last_name;
		return $first_name;
	}

	public function getFullNameParentAttribute() {
		$value = null;
		
		$first_name = $last_name = "";

		if (isset($this->attributes) && isset($this->attributes['fname_parent'])) {
			$first_name = ucfirst($this->attributes['fname_parent']);
		}

		if (isset($this->attributes) && isset($this->attributes['lname_parent'])) {
			$last_name = ucfirst($this->attributes['lname_parent']);
		}

		return $first_name;
	}

	// save user profile picture create user in admin side
 	public static function saveLogo($value, $userId) {

	 	$imageName = '';
		if(!empty($value) && !empty($userId)){
			
			$base64header = 'data:image/jpeg;base64,';
            $base64Img = base64_encode(file_get_contents($value)); 

            if(!empty($base64Img)){
                
                $value = $base64header.$base64Img;
            }

	 		// create folder path
	 		$destination_path = 'profile/logo/'.$userId;

		 	// check image path is exist
		 	if(!Storage::exists($destination_path)){
				
				// create image directory
				Storage::makeDirectory($destination_path , 0775, true);
			}

			$image_array_1 = explode(";", $value);

	 	 	$extentionString = $image_array_1[0];

	 	 	$extentionArr = explode("/", $extentionString);

	 	 	$imageType = "jpg";
	 	 	
	 	 	// get extention Array
	 	 	if(isset($extentionArr[1])){

	 	 		$imageType = $extentionArr[1];
	 	 	}
	 	 	
	 	 	$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);

			// set image name
			$imageName = $destination_path.'/'.md5(microtime() . mt_rand()). '.'.$imageType;

			// save image in folder 
			$return = file_put_contents('uploads/'.$imageName, $data);
	 	}
	 	
		return $imageName; 
	}
}
