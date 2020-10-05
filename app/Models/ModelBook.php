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
use App\Observer\ModelBookObserver;
use Illuminate\Support\Facades\Storage;
use Larapen\Admin\app\Models\Crud;

class ModelBook extends BaseModel
{
	use Crud;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modelbooks';
    
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
    protected $fillable = ['country_code', 'user_id', 'name', 'filename', 'active'];
    
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
    protected static function boot()
    {
        parent::boot();
	
		ModelBook::observe(ModelBookObserver::class);
        
        static::addGlobalScope(new ActiveScope());
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function user()
    {
        // return $this->belongsToMany(User::class, 'user_id', 'id');
        return $this->belongsTo(User::class, 'user_id');
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
	public function getNameAttribute()
	{
		$value = null;
		
		if (isset($this->attributes) && isset($this->attributes['name'])) {
			$value = $this->attributes['name'];
		}
		
		// if (empty($value)) {
		// 	$value = last(explode('/', $this->attributes['filename']));
		// }
		
		return $value;
	}
	
    public function getFilenameAttribute()
    {
        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];

        // Fix path
        // $value = str_replace('uploads/modelbooks/', '', $value);
        // $value = str_replace('modelbooks/', '', $value);
        // $value = 'modelbooks/' . $value;

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
    public function setFilenameAttribute($value)
    {
		$field_name = 'modelbook.filename';
		$attribute_name = 'filename';
		$disk = config('filesystems.default');
	
		// Set the right field name
		$request = \Request::instance();
		if (!$request->hasFile($field_name)) {
			$field_name = $attribute_name;
		}

        if (!isset($this->country_code) || !isset($this->user_id)) {
            $this->attributes[$attribute_name] = null;
            return false;
        }

        // Path
        $destination_path = 'modelbooks/'. $this->user_id;

        // Upload
        $this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path);
    }

    public static function getModelBook($user_id, $perpage= null, $count = false){
        $modelbooks = ModelBook::where('user_id', $user_id)->orderByDesc('id');

        if($count){
            return $modelbooks->count();
        }

        if($perpage){
            return $modelbooks->paginate($perpage);
        } else {
            return $modelbooks->get();
        }


    }
}
