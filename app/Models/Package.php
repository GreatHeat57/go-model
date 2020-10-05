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
use App\Models\Traits\TranslatedTrait;
use App\Observer\PackageObserver;
use Larapen\Admin\app\Models\Crud;
use App\Models\Country;
use App\Models\Language;

class Package extends BaseModel
{
    use Crud, TranslatedTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    protected $appends = ['tid'];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    
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
        'name',
        'user_type_id',
        'short_name',
        'country_code',
        'ribbon',
        'has_badge',
        'price',
        'currency_code',
        'tax',
        'duration',
        'description',
        'features',
        'active',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'translation_lang',
        'translation_of',
        'duration_period',
        'package_uid'
    ];
    public $translatable = ['name', 'short_name', 'description'];
    
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
    // protected $dates = [];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Package::observe(PackageObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }
    
    public function getCountryHtml()
    {
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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
	public function scopeApplyCurrency($builder)
	{
		if (config('settings.geo_location.local_currency_packages_activation')) {
			$builder->where('currency_code', config('country.currency'));
		}
		
		return $builder;
	}
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public static function getWPackageFromId($package_id){
        return Package::withoutGlobalScopes([ActiveScope::class])->where('wp_package_id', $package_id)->first();
    }

    //create custom function to store package translations country wise from admin panel.
    public function setCountryTranslations($packageObj){

        if( isset($packageObj->id) && isset($packageObj->country_code) ){

            $active_countries = Country::withoutGlobalScopes()
                ->leftJoin('languages', 'countries.code', 'languages.abbr')
                ->where('countries.active', 1)
                ->where('countries.code', '!=', $packageObj->country_code)
                ->pluck('languages.abbr','countries.code');

        
            if( isset($active_countries) && !empty($active_countries) ){
                foreach ($active_countries as $country => $language_code) {
                    $package = new Package();
                    $package->translation_lang  = $language_code;
                    $package->translation_of    = $packageObj->id;
                    $package->name              = $packageObj->name;
                    $package->short_name        = $packageObj->short_name;
                    $package->user_type_id      = $packageObj->user_type_id;
                    $package->country_code      = $country;
                    $package->price             = $packageObj->price;
                    $package->currency_code     = $packageObj->currency_code;
                    $package->tax               = $packageObj->tax;
                    $package->duration          = $packageObj->duration;
                    $package->description       = $packageObj->description;
                    $package->features          = $packageObj->features;
                    $package->active            = $packageObj->active;
                    $package->package_uid       = $packageObj->package_uid;
                    $package->price_dummy       = $packageObj->price_dummy;
                    $package->duration_period   = $packageObj->duration_period;
                    $package->save();
                }
            }
        }

    }

    //create new country package when new country is actived
    public static function createCountryPackage($country_code = "", $country){

        //check status is country is active then start the package creation process
        if(isset($country->active) && $country->active == 1){

            // get all parent packages list
            $parentPackages = Package::select('id','translation_lang','translation_of','name','short_name','user_type_id','price','currency_code','tax','duration','description','features','active','package_uid','price_dummy','duration_period', 'country_code')->withoutGlobalScopes()->where('country_code', 'US')->get()->toArray();


            // check country code is set and package object is not empty
            if(isset($country_code) && !empty($country_code) && isset($parentPackages) && count($parentPackages) > 0 ){

                $code = strtolower($country_code);
                //check lanugage is exist or not if not then create new languages
                $existLanugage = Language::withoutGlobalScopes()->where('abbr', $code)->first();

                $lanugage = array();
                if(empty($existLanugage)){
                    $lanugage['abbr'] = $code;
                    $lanugage['name'] = $country->asciiname;
                    $lanugage['native'] = $country->asciiname;
                    $lanugage['app_name'] = strtolower($country->asciiname); 
                    $lanugage['active'] = 0;
                    $lanugage['default'] = 0;
                }

                //create new language in language table
                if( !empty($lanugage) && count($lanugage) > 0 ){
                    Language::insert($lanugage);
                }

                // find new country package in parent packages and if not exist then create new child package from parent package.
                foreach ($parentPackages as $key => $value) {

                    $is_package_found = Package::withoutGlobalScopes()
                        ->where('translation_of', $value['id'])
                        ->where('country_code', $country_code)
                        ->count();

                    if( $is_package_found == 0 ){

                        $package = new Package();
                        $package->translation_lang  = strtolower($country_code);
                        $package->translation_of    = $value['id'];
                        $package->name              = $value['name'];
                        $package->short_name        = $value['short_name'];
                        $package->user_type_id      = $value['user_type_id'];
                        $package->country_code      = $country_code;
                        $package->price             = $value['price'];
                        $package->currency_code     = $value['currency_code'];
                        $package->tax               = $value['tax'];
                        $package->duration          = $value['duration'];
                        $package->description       = $value['description'];
                        $package->features          = $value['features'];
                        $package->active            = $value['active'];
                        $package->package_uid       = $value['package_uid'];
                        $package->price_dummy       = $value['price_dummy'];
                        $package->duration_period   = $value['duration_period'];
                        $package->save();
                    }
                }
            }
        }
    }
}
