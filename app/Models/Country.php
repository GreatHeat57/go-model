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
use App\Observer\CountryObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;
use DB;

class Country extends BaseModel
{
	use Crud;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $appends = ['icode'];

    protected $visible = ['code', 'name', 'asciiname', 'icode', 'currency_code', 'phone', 'languages', 'currency', 'background_image', 'admin_type', 'admin_field_active','height_units','dress_size_unit','shoe_units','weight_units','terms_conditions_model', 'terms_conditions_client', 'facebook_link', 'instagram_link', 'twitter_link', 'pinterest_link','time_format','time_zone_id','feature_fallback_countries','country_type','terms_conditions_free_model'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    // public $timestamps = false;
    
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
        'code',
        'name',
        'asciiname',
        'capital',
        'continent_code',
        'tld',
        'currency_code',
        'phone',
        'languages',
		'background_image',
        'admin_type',
        'admin_field_active',
        'active',
        'terms_conditions_model',
        'terms_conditions_client',
        'height_units',
        'dress_size_unit',
        'shoe_units',
        'weight_units',
        'waist_units',
        'chest_units',
        'hips_units',
        'time_format',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'pinterest_link',
        'time_zone_id',
        'feature_fallback_countries',
        'country_type',
        'terms_conditions_free_model',
    ];
    
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
    protected $dates = ['created_at', 'created_at'];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Country::observe(CountryObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }
    
    public function getNameHtml()
    {
        $out = '';
        
        $editUrl = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/edit');
        $admin1Url = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/loc_admin1');
        $cityUrl = url(config('larapen.admin.route_prefix', 'admin') . '/country/' . $this->id . '/city');
        
        $out .= '<a href="' . $editUrl . '" style="float:left;">' . $this->asciiname . '</a>';
        $out .= ' ';
        $out .= '<span style="float:right;">';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $admin1Url . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('admin divisions 1')) . '</a>';
        $out .= ' ';
        $out .= '<a class="btn btn-xs btn-primary" href="' . $cityUrl . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('cities')) . '</a>';
        $out .= '</span>';
        
        return $out;
    }

	public function getActiveHtml()
	{
		if (!isset($this->active)) return false;

        return installAjaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'active', $this->active);
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }
    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_code', 'code');
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_id', 'id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        if (Request::segment(1) == config('larapen.admin.route_prefix', 'admin')) {
			if (Str::contains(Route::currentRouteAction(), 'Admin\CountryController')) {
				return $query;
			}
        }
        
        return $query->where('active', 1);
    }
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getIcodeAttribute()
    {
        return strtolower($this->attributes['code']);
    }
    
    public function getIdAttribute($value)
    {
        return $this->attributes['code'];
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	public function setBackgroundImageAttribute($value)
	{
		$attribute_name = 'background_image';
		$destination_path = 'app/logo';
		
		// If the image was erased
		if (empty($value)) {
			// delete the image from disk
			if (!Str::contains($this->{$attribute_name}, config('larapen.core.picture.default'))) {
				Storage::delete($this->{$attribute_name});
			}
			
			// set null in the database column
			$this->attributes[$attribute_name] = null;
			
			return false;
		}
		
		// If a base64 was sent, store it in the db
		if (starts_with($value, 'data:image')) {
			try {
				// Get file extension
				$extension = (is_png($value)) ? 'png' : 'jpg';
				
				// Make the image (Size: 2000x1000)
				if (exifExtIsEnabled()) {
					$image = Image::make($value)->orientate()->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				} else {
					$image = Image::make($value)->resize(2000, 1000, function ($constraint) {
						$constraint->aspectRatio();
					})->encode($extension, 100);
				}
			} catch (\Exception $e) {
				Alert::error($e->getMessage())->flash();
				$this->attributes[$attribute_name] = null;
				
				return false;
			}
			
			// Save the file on server
			$filename = uniqid('header-') . '.' . $extension;
			Storage::put($destination_path . '/' . $filename, $image->stream());
			
			// Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . '/' . $filename;
		} else {
			// Get, Transform and Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . last(explode($destination_path, $value));
		}
	}

    public static function getAllActiveCountryCity(){
        
        $query = Country::withoutGlobalScopes()->select('cities.country_code', 'cities.name', 'cities.id', 'cities.active','countries.id as cid', 'countries.code')
           ->join('cities', 'countries.code', '=', 'cities.country_code')
           ->where('cities.active', 1)
           ->where('countries.active', 1)
           ->get();
           return $query;
    }

    public static function getCountryCodeByName($name){
        $countycode = Country::withoutGlobalScopes()
                    ->where(DB::raw('lower(name)' ), strtolower($name))
                    ->orWhere(DB::raw('lower(asciiname) '), strtolower($name))
                    ->first();

        if( isset($countycode) && !empty($countycode) ){
            return $countycode->code;
        }

        return;
    }

    /* set comma separated value for the feature fallback country field */
    public function setFeatureFallbackCountriesAttribute($value) {
        // check value is set and is array
        if(isset($value) && is_array($value)){

            // remove the current country code from the selected country
            if (isset($this->attributes['code']) && ($key = array_search($this->attributes['code'], $value)) !== false) {
                unset($value[$key]);
            }
            // convert array into comma separated value
            $fallback_countries = implode(',', $value); 

            // store new value in feature_fallback_countries fields
            if(!empty($fallback_countries)){
                $this->attributes['feature_fallback_countries'] = $fallback_countries;
            }
        }
    }

    /* convert comma separted value into array*/
    public function getFeatureFallbackCountriesAttribute($value) {
        // check value is not empty and also explode value is array then return the array value
        if(isset($value) && !empty($value) && is_array(explode(',', $value))){
            return explode(',', $value);
        }
        return null;
    }

}
