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
use App\Observer\ModelCategoryObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ModelCategory extends BaseModel
{
    use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait, SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_categories';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    protected $appends = ['tid','page_route'];
    
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
        'parent_id',
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'description',
        'picture',
        'css_class',
        'active',
        'lft',
        'rgt',
        'depth',
        'translation_lang',
        'translation_of',
        'is_baby_model',
        'age_range',
        'title',
        'footer_text',
        'faq_text',
        'faq_script',
    ];
    public $translatable = ['name', 'slug', 'description'];
    
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
    protected static function boot()
    {
        parent::boot();
	
		ModelCategory::observe(ModelCategoryObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    public function getNameHtml()
    {
        $out = '';
    
        $currentUrl = preg_replace('#/(search)$#', '', url()->current());
        $editUrl = $currentUrl . '/' . $this->id . '/edit';
        $subCatUrl = url(config('larapen.admin.route_prefix', 'admin') . '/category/' . $this->id . '/sub_category');
        
        $out .= '<a href="' . $editUrl . '" style="float:left;">' . $this->name . '</a>';
        $out .= ' ';
        $out .= '<span style="float:right;">';
        // $out .= '<a class="btn btn-xs btn-primary" href="' . $subCatUrl . '"><i class="fa fa-folder"></i> ' . mb_ucfirst(__t('subcategories')) . '</a>';
        $out .= '</span>';
    
        return $out;
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function posts()
    {
        return $this->hasManyThrough(Post::class, ModelCategory::class, 'parent_id', 'category_id');
    }
    
    public function children()
    {
        return $this->hasMany(ModelCategory::class, 'parent_id');
    }
    
    public function lang()
    {
        return $this->hasMany(ModelCategory::class, 'translation_of');
    }
    
    public function parent()
    {
        return $this->belongsTo(ModelCategory::class, 'parent_id');
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
    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        return $this->name;
    }

    // set category route
    public function getPageRouteAttribute()
    {
        $value = $this->slug;

        switch ($value) {
            case 'baby-model':
            case 'baby-model-de':
            case 'baby-model-uk':
            case 'baby-model-fr':
            case 'baby-model-es':
                $value = 'baby-model-page';
                break;
            case 'kid-model':
            case 'kid-model-de':
            case 'kid-model-uk':
            case 'kid-model-fr':
            case 'kid-model-es':
                $value = 'child-model-page';
                break;
            case 'model':
            case 'model-de':
            case 'model-uk':
            case 'model-fr':
            case 'model-es':
                $value = 'model-page';
                break;
            case '50plus-model':
            case '50plus-model-de':
            case '50plus-model-uk':
            case '50plus-model-fr':
            case '50plus-model-es':
                $value = 'senior-model-page';
                break;
            case 'plus-size-model':
            case 'plus-size-model-de':
            case 'plus-size-model-uk':
            case 'plus-size-model-fr':
            case 'plus-size-model-es':
                $value = 'pluszie-model-page';
                break;
            case 'fitness-model':
            case 'fitness-model-de':
            case 'fitness-model-uk':
            case 'fitness-model-fr':
            case 'fitness-model-es':
                $value = 'fitness-model-page';
                break;
            case 'tattoo-model':
            case 'tattoo-model-de':
            case 'tattoo-model-uk':
            case 'tattoo-model-fr':
            case 'tattoo-model-es':
                $value = 'tattoo-model-page';
                break;
            case 'male-model':
            case 'male-model-de':
            case 'male-model-uk':
            case 'male-model-fr':
            case 'male-model-es':
                $value = 'male-model-page';
                break;
        }

        return $value;
    }

    /**
     * ModelCategory icons pictures from original version
     * Only the file name is set in ModelCategory 'picture' field
     * Example: fa-car.png
     *
     * @return null|string
     */
    public function getPictureFromOriginPath()
    {
        if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
            return null;
        }

        $value = $this->attributes['picture'];
        if (empty($value)) {
            return null;
        }

        // Fix path
        // $value = 'app/model_categorieses/' . config('app.skin', 'skin-default') . '/' . $value;
        $value = config('app.model_category_image_path') . $value;

        if (!Storage::exists($value)) {
            $value = null;
        }

        return $value;
    }

    public function getPictureAttribute()
    {
        // OLD PATH
        $value = $this->getPictureFromOriginPath();
        if (!empty($value)) {
            return $value;
        }

        // NEW PATH
        if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
            // $value = 'app/default/model_categorieses/fa-folder-' . config('app.skin', 'skin-default') . '.png';
            $value = config('app.model_category_image_path') . $value;
            return $value;
        }

        $value = $this->attributes['picture'];

        if (!Storage::exists($value)) {
            // $value = 'app/default/model_categorieses/fa-folder-' . config('app.skin', 'skin-default') . '.png';
            $value = config('app.model_category_image_path') . $value;
        }

        return $value;
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPictureAttribute($value)
    {
        $attribute_name = 'picture';
        $destination_path = 'app/model_categorieses/custom';

        // If the image was erased
        if (empty($value)) {
            // Don't delete the default pictures
            $defaultPicture = 'app/default/model_categorieses/fa-folder-' . config('settings.style.app_skin', 'skin-default') . '.png';
            if (!Str::contains($this->picture, $defaultPicture)) {
                // delete the image from disk
                Storage::delete($this->picture);
            }

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
                $image = Image::make($value)->resize(400, 400, function($constraint) {
                    $constraint->aspectRatio();
                });
            } catch (\Exception $e) {
                Alert::error($e->getMessage())->flash();
                $this->attributes[$attribute_name] = null;

                return false;
            }

            // Generate a filename.
            $filename = md5($value . time()) . '.jpg';

            // Store the image on disk.
            Storage::put($destination_path . '/' . $filename, $image->stream());

            // Save the path to the database
            $this->attributes[$attribute_name] = $destination_path . '/' . $filename;
        }
    }

    /**
     * Activate/Deactivate model_categorieses with their children if exist
     * Activate/Deactivate translated entries with their translations if exist
     * @param $value
     */
    public function setActiveAttribute($value)
    {
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : null;

        if (!empty($entityId)) {
            // Activate the entry
            $this->attributes['active'] = $value;

            // If the entry is a parent entry, activate its children
            $parentId = (isset($this->attributes['parent_id'])) ? $this->attributes['parent_id'] : null;
            if ($parentId == 0) {
                // ... AND don't select the current parent entry to prevent infinite recursion
                $entries = $this->where('parent_id', $entityId)->get();
                if (!empty($entries)) {
                    foreach ($entries as $entry) {
                        $entry->active = $value;
                        $entry->save();
                    }
                }
            }
        } else {
            // Activate the new entries
            $this->attributes['active'] = $value;
        }
    }

    public static function getModelCateogryIdBySlug($slug){
        $modelCat = ModelCategory::withoutGlobalScopes([ActiveScope::class])->where('slug', $slug)->first();

        if(isset($modelCat) && !empty($modelCat)){
            return $modelCat->id;
        }

        return 0;
    }

    public function getParentIdAttribute()
    {   
        if($this->attributes['translation_of'] > 0){
            return $this->attributes['parent_id'] = $this->attributes['translation_of'];
        }else{
            return $this->attributes['parent_id'] = $this->attributes['id'];
        }
    }

    public static function getModelCateogryName($id, $returnfield='name'){
        $modelCat = ModelCategory::withoutGlobalScopes([ActiveScope::class])->where('id', $id)->first();

        if(isset($modelCat) && !empty($modelCat)){
            return $modelCat->$returnfield;
        }

        return '';
    }

    public static function getModelCategory($parent_id = 0, $arr_type = true){
        $res = ModelCategory::withoutGlobalScopes()->select('name','slug','id')->where('translation_of', $parent_id)->get();
        if($arr_type){
            return $res->toArray();
        }
        return $res;
    }
}
