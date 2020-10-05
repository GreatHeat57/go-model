<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\TranslatedTrait;
use App\Models\Scopes\ActiveScope;
use App\Observer\BlogCategoryObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Larapen\Admin\app\Models\Crud;

class BlogCategory extends BaseModel
{
    use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait, SoftDeletes;
    protected $guarded = ['id'];
    public $translatable = ['name','slug'];
    protected $fillable = ['name','slug','active','translation_lang','translation_of','country_code','meta_title','meta_description','meta_keywords'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        BlogCategory::observe(BlogCategoryObserver::class);
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function entries()
    {
        return $this->hasMany(BlogEntry::class,'category_id');
    }

    public function transaltionof(){
        return $this->hasOne(BlogEntry::class,'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        return $this->name;
    }

    public static function getParentNode($tran_id){
        $parent = array();

        if($tran_id){
            $parent = BlogCategory::where('wp_term_id', $tran_id)->first();

            if( $parent && !empty($parent) ){
                return $parent;
            }

            return $parent;
        }
    }

    public static function updateTranslationOf($parent_id, $term_id, $type = ''){

        if( $type != '' && $type === 'translation_of' ){

            if( isset($term_id) && !empty($term_id) && isset($parent_id) && !empty($parent_id) ){
                $termObj = BlogCategory::where('wp_term_id', $term_id)->first();

                if( $termObj && !empty($termObj) ){
                    
                    if($parent_id != $termObj->translation_of){

                        try{
                            $termObj->translation_of = $parent_id;
                            $termObj->save();

                        }catch(Exception $e){
                            return [
                                'status' =>false,
                                'message' => $e->getMessage()
                            ];
                        }


                    } else {
                        return [
                            'status' => true,
                            'message' => ''
                        ];
                    }
                }   
            }
        }

        if( $type != '' && $type === 'parent' ){
            if( isset($term_id) && !empty($term_id) && isset($parent_id) && !empty($parent_id) ){
                $termObj = BlogCategory::where('wp_term_id', $term_id)->first();

                if( $termObj && !empty($termObj) ){
                    
                    if($parent_id != $termObj->parent_id){

                        try{
                            $termObj->parent_id = $parent_id;
                            $termObj->save();

                        }catch(Exception $e){
                            return [
                                'status' =>false,
                                'message' => $e->getMessage()
                            ];
                        }


                    } else {
                        return [
                            'status' => true,
                            'message' => ''
                        ];
                    }
                }   
            }
        }

        return [
            'status' => true,
            'message' => ''
        ];
    }

    public function getParentIdAttribute()
    {   
        if($this->attributes['translation_of'] > 0){
            return $this->attributes['parent_id'] = $this->attributes['translation_of'];
        }else{
            return $this->attributes['parent_id'] = $this->attributes['id'];
        }
    }
}