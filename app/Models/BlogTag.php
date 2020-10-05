<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\TranslatedTrait;
use App\Observer\BlogTagObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Larapen\Admin\app\Models\Crud;

class BlogTag extends BaseModel
{
    use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait, SoftDeletes;
    protected $guarded = ['id'];
    public $translatable = ['tag','slug'];
    protected $fillable = ['tag','slug','translation_lang','translation_of','meta_title','meta_description','meta_keywords'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        BlogTag::observe(BlogTagObserver::class);
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
                'source' => 'slug_or_tag',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blogs()
    {
        return $this->belongsToMany('App\Models\BlogEntry', 'blog_tags_to_entries', 'tag_id', 'entry_id');
    }

    /**
     * @param $query
     * @param $tags
     */
    public function scopeTags($query, $tags)
    {
        $tags = (array)$tags;
        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = BlogTag::firstOrCreate(['tag' => $tag])->id;
        }
        $query->whereIn('id', $ids);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTagAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        return $this->tag;
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
