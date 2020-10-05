<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\ModelCategory;

class FeatureModels extends Model
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feature_models';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'model_name',
        'go_code',
        'country_code',
        'model_category',
        'image_name',
        'image_url',
        'alt_tag',
        'birthday',
        'city'
    ];

    /*
        |--------------------------------------------------------------------------
        | MUTATORS
        |--------------------------------------------------------------------------
    */

    public function setBirthdayAttribute($value) {
        if(isset($value) && !empty($value)){
            $this->attributes['birthday'] = date('Y-m-d', strtotime($value));
        }else{
            $this->attributes['birthday']  = null;
        }
    }

    /* 
    * Return all feature models list from home page and category details page.
    */
    public static function getFeatureModels($country_code = null, $model_category = null, $orderby = null, $limit = null){

        $fallback_country_arr = array();
        // check if country code is set the use it or set default config country code
        $country_code = ($country_code != null)? $country_code : config('country.code');

        // set feature models object
        $models = FeatureModels::SELECT('feature_models.*');
        
        // check model categroy is set the get by model specific model
        if(isset($model_category) && !empty($model_category)){
            if(!empty($model_category)){
                $models->where('model_category', $model_category);
            }
        }

        $fallback_country_arr = config('country.feature_fallback_countries');

        // check country has fallback country and is not empty
        if(isset($fallback_country_arr) && !empty($fallback_country_arr)){

            // merge country code in fallback array and set unique values
            array_unshift($fallback_country_arr, $country_code);
            $fallback_country_arr = array_unique($fallback_country_arr);
        }

        // if fallback country os assign then get from it or get from countr_code
        if(isset($fallback_country_arr) && !empty($fallback_country_arr)){
            $models->whereIn('country_code', $fallback_country_arr);
        }else{
            $models->where('country_code', $country_code);
        }
        
        //if orderby is set then return order by
        if($orderby != null){
            $models->orderBy($orderby);
        }

        //if limit is set then return limited records
        if($limit != null){
            $models->limit($limit);
        }

        $models_arr = $models->get()->toArray();
        $filert_arr = array();
        $f_count = 0;

        foreach ($models_arr as $key => $m_arr) {
           if(isset($m_arr['country_code']) && $m_arr['country_code'] == $country_code){
                $filert_arr[$f_count] = $m_arr;
                unset($models_arr[$key]);
                $f_count++;
           }
        }

        $final_result = array_merge($filert_arr, $models_arr);
        return $final_result;
    }

    /* 
    * Home page feature model listing
    */
    public static function getFeatureModelHome($cat_per_records = 5){
        
        // get all feature models from the table
        $models = FeatureModels::getFeatureModels($country_code = null, $model_category = null, $orderby = 'go_code', $limit = null);

        if(isset($models) && !empty($models) && count($models) > 0 ){

            //get all model category
            $model_category = ModelCategory::where('translation_of', 0)->pluck('slug','id')->toArray();

            // get fallback countries array
            $fallback_country_arr = config('country.feature_fallback_countries');

            $feature_models = array();
            $country_code = config('country.code');
            $count = 1;
            $v_count = 0;

            $fallback_country_arr = (!empty($fallback_country_arr))? $fallback_country_arr : array();
            
            // current country code push in fallback country array
            array_push($fallback_country_arr, $country_code);

            // get the unique array for the country code
            $fallback_country_arr = array_unique($fallback_country_arr);

            // set the model category coount for the loops
            $model_cat_count = (!empty($model_category))? count($model_category) : 0;

            // loop the model category and get the slug
            foreach ($model_category as $key => $slug) {
                $count = 1;

                //loops the all feature models and check each models category and country
                foreach ($models as $key => $model) {

                    // if slug find in array and model country code in fallback_country_array and check per category records
                    if (in_array($slug, $model) && in_array($model['country_code'], $fallback_country_arr) && $count <= $cat_per_records) {
                       $feature_models[$v_count] = $model;
                       $v_count++; // update value count
                       $count++; // update per category count
                    }
                }
            }

            // return the result
            return $feature_models;
        }else{
            // return the empty result
            return $feature_models = [];
        }

    }

}
