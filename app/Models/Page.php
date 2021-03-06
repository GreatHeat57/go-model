<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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
use App\Observer\PageObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel {
	use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait, SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

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
		'parent_id',
		'type',
		'name',
		'slug',
		'picture',
		'title',
		'content',
		'external_link',
		'name_color',
		'title_color',
		'target_blank',
		'excluded_from_footer',
		'active',
		'lft',
		'rgt',
		'depth',
		'translation_lang',
		'translation_of',
		'page_layout'
	];
	public $translatable = ['name', 'slug', 'title', 'content'];

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
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/*
		    |--------------------------------------------------------------------------
		    | FUNCTIONS
		    |--------------------------------------------------------------------------
	*/
	protected static function boot() {
		parent::boot();

		Page::observe(PageObserver::class);

		static::addGlobalScope(new ActiveScope());
	}

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable() {
		return [
			'slug' => [
				'source' => 'slug_or_name',
			],
		];
	}

	public function getNameHtml() {
		// Pre URL (locale)
		$preUri = '';
		if (!(config('laravellocalization.hideDefaultLocaleInURL') == true && config('app.locale') == config('appLang.abbr'))) {
			$preUri = config('app.locale') . '/';
		}

		return '<a href="' . url($preUri . trans('routes.v-page', ['slug' => $this->slug])) . '" target="_blank">' . $this->name . '</a>';
		// return '<a href="' . url($preUri . trans('routes.v-page', ['slug' => $this->type])) . '" target="_blank">' . $this->name . '</a>';
	}

	/*
		    |--------------------------------------------------------------------------
		    | RELATIONS
		    |--------------------------------------------------------------------------
	*/
	public function parent() {
		return $this->belongsTo(Page::class, 'parent_id');
	}

	/*
		    |--------------------------------------------------------------------------
		    | SCOPES
		    |--------------------------------------------------------------------------
	*/
	public function scopeType($builder, $type) {
		return $builder->where('type', $type)->orderBy('id', 'DESC');
	}

	/*
		    |--------------------------------------------------------------------------
		    | ACCESORS
		    |--------------------------------------------------------------------------
	*/
	// The slug is created automatically from the "name" field if no slug exists.
	public function getSlugOrNameAttribute() {
		if ($this->slug != '') {
			return $this->slug;
		}
		return $this->name;
	}

	public function getPictureAttribute() {
		if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
			return null;
		}

		$value = $this->attributes['picture'];

		if (!Storage::exists($value)) {
			$value = null;
		}

		return $value;
	}

	/*
		    |--------------------------------------------------------------------------
		    | MUTATORS
		    |--------------------------------------------------------------------------
	*/
	public function setTitleAttribute($value) {
		if (empty($value)) {
			$this->attributes['title'] = $this->name;
		} else {
			$this->attributes['title'] = $value;
		}
	}

	public function setPictureAttribute($value) {
		$attribute_name = 'picture';
		$destination_path = 'app/page';

		if(!empty($value) && $value !== ""){
            
            $request = \Request::instance();

            $base64header = 'data:image/jpeg;base64,';
            $base64Img = base64_encode(file_get_contents($value));
            
            if(!empty($base64Img)){
                $value = $base64header.$base64Img;
            }

            $req = $request->all();
            
            $filename = $newFileName = "";

            if ($request->hasFile('picture')) {
                $originalfilename = $req['picture']->getClientOriginalName();
                $filename = pathinfo($originalfilename, PATHINFO_FILENAME);
            }
        }

		// If the image was erased
		if (empty($value)) {
			// delete the image from disk
			Storage::delete($this->picture);

			// set null in the database column
			$this->attributes[$attribute_name] = null;

			return false;
		}

		// Check the image file
		if ($value == url('/')) {
			$this->attributes[$attribute_name] = null;

			return false;
		}

		// If laravel request->file('filename') resource OR base64 was sent, store it in the db
		if (starts_with($value, 'data:image')) {
			try {
				// Make the image
				if (exifExtIsEnabled()) {
					$image = Image::make($value)->orientate()->resize(1280, 1280, function ($constraint) {
						$constraint->aspectRatio();
					});
				} else {
					$image = Image::make($value)->resize(1280, 1280, function ($constraint) {
						$constraint->aspectRatio();
					});
				}
			} catch (\Exception $e) {
				Alert::error($e->getMessage())->flash();
				$this->attributes[$attribute_name] = null;

				return false;
			}

			// Generate a filename.
			//$filename = md5($value . time()) . '.jpg';
			$newFileName = ($filename)? $filename : md5($value . time());
            $filename = $newFileName . '.jpg';

			// Store the image on disk.
			Storage::put($destination_path . '/' . $filename, $image->stream());

			// Save the path to the database
			$this->attributes[$attribute_name] = $destination_path . '/' . $filename;
		}else{

			$request = \Request::instance();
            $response = CommonHelper::pageImageUploads($request, $attribute_name, $destination_path);

            if($response['status'] && !empty($response['path'])){
                $this->attributes[$attribute_name] = $response['path'];
            }
		}
	}
}
