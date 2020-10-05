<?php
namespace App\Models;
use App\Observer\BlogEntryObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\TranslatedTrait;
use App\Models\Scopes\ActiveScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;

class BlogEntry extends BaseModel
{
    use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait, SoftDeletes;
    protected $guarded = ['id'];
    public $translatable = ['name','short_text','long_text','slug'];
    protected $fillable = ['name','category_id','picture','short_text','long_text','slug','active','featured','start_date','tags','translation_lang','translation_of','country_code','meta_title','meta_description','meta_keywords','post_author'];
    
    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        BlogEntry::observe(BlogEntryObserver::class);
        static::addGlobalScope(new ActiveScope());

        // save new tag(s) for all language (if not exists)
        self::saved(function($model){ 
            $model->saveTagToEntry($model);
        });

        // update tag(s) for edited language
        self::updated(function($model){
            $model->saveTagToEntry($model);
        });
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

    public function saveTagToEntry($model)
    {   
        
        $tags = array();
        if(!empty($model->tags)){
            $tags = explode(',',$model->tags);
        }
        if(count($tags) > 0)
        {
            $languages = Language::where('default','<>',1)->get();
            BlogTagsToEntry::where('entry_id',$model->id)->delete();
            foreach($tags as $t)
            {
                $tag = BlogTag::where('tag',$t)->where('translation_lang',$model->translation_lang)->first();
                if(!$tag) {
                    $tag = new BlogTag();
                    $tag->tag = $t;
                    $tag->save();

                    $tag->translation_of = $tag->id;
                    $tag->save();

                    foreach($languages as $language)
                    {
                        $tag_trans = new BlogTag();
                        $tag_trans->tag = $t;
                        $tag_trans->translation_lang = $language->id;
                        $tag_trans->translation_of = $tag->id;
                        $tag_trans->save();
                    }
                }
                $blog_tag_to_entry = new BlogTagsToEntry();
                $blog_tag_to_entry->entry_id = $model->id;
                $blog_tag_to_entry->tag_id = $tag->id;
                $blog_tag_to_entry->save();
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\BlogCategory','id','category_id');
    }

    /**
     * Tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\BlogTag', 'blog_tags_to_entries', 'entry_id', 'tag_id');
    }

    /**
     * Tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTags()
    {
        return $this->belongsToMany('App\Models\BlogTag', 'blog_tags_to_entries', 'entry_id', 'tag_id');
    }

    /**
     * BlogEntry
     * @return translated record
     */
    public function langTranslation()
    {
        return $this->hasMany('App\Models\BlogEntry','translation_of','id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'post_author');
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

    // public function getTagsAttribute()
    // {
    //     $tags = $this->tags()->pluck('tag')->toArray();
    //     return count($tags) > 0 ? implode(',',$tags) : '';
    // }

    /**
     * Filter to tags
     * @param $query
     * @param $tags
     */
    public function scopeWithTags($query, $tags)
    {
        $tags = array_map('str_slug',(array)$tags);
        $blogTags = BlogTag::whereIn('slug',$tags)->get();
        $ids = [];
        foreach ($blogTags as $tag) {
            $blogIds = $tag->blogs()->lists('id');
            foreach ($blogIds as $id) {
                $ids[] = $id;
            }
        }
        $query->whereIn('id',$ids);
    }

    public function getPictureAttribute()
    {
        if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
            return null;
        }
        $value = $this->attributes['picture'];
        if (!Storage::exists($value)) {
            $value = null;
        }
        return $value;
    }

    // public function getStartDateAttribute()
    // {
    //     return date('Y-m-d H:i');
    // }

    public function getCreatedAtAttribute()
    {
        $value = $this->attributes['updated_at'];
        return date('M d, Y',strtotime($value));
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPictureAttribute($value)
    {
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

            $picture_details= pathinfo(public_path('uploads').'/'.$this->picture);
            Storage::delete($destination_path.'/'.$picture_details['filename'].'-'.config('app.blog_top_image').'.'.$picture_details['extension']);
            Storage::delete($destination_path.'/'.$picture_details['filename'].'-'.config('app.blog_bottom_image').'.'.$picture_details['extension']);
            Storage::delete($destination_path.'/'.$picture_details['filename'].'-'.config('app.blog_right_image').'.'.$picture_details['extension']);

            // new images
            Storage::delete($destination_path.'/'.$picture_details['filename'].'-'.config('app.blog_top_image_new').'.'.$picture_details['extension']);
            Storage::delete($destination_path.'/'.$picture_details['filename'].'-'.config('app.blog_bottom_image_new').'.'.$picture_details['extension']);
            
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
                \Alert::error($e->getMessage())->flash();
                $this->attributes[$attribute_name] = null;

                return false;
            }

            // Generate a filename.
            $newFileName = ($filename)? $filename : md5($value . time());
            $filename = $newFileName . '.jpg';

            // Store the image on disk.
            Storage::put($destination_path . '/' . $filename, $image->stream());

            // crop thumbnail image
            $blog_top_image=explode('x', config('app.blog_top_image'));
            if (exifExtIsEnabled()) {
                $top_image = Image::make($value)->orientate()->resize($blog_top_image[0], $blog_top_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $top_image = Image::make($value)->resize($blog_top_image[0], $blog_top_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $blog_top_image = $newFileName.'-'.config('app.blog_top_image') . '.jpg';
            // Store the image on disk.
            Storage::put($destination_path . '/' . $blog_top_image, $top_image->stream());



            /* CROP TEMP NEW IMAGES */

                // crop thumbnail image
                $blog_top_image_new=explode('x', config('app.blog_top_image_new'));
                if (exifExtIsEnabled()) {
                    $top_image_new = Image::make($value)->orientate()->resize($blog_top_image_new[0], $blog_top_image_new[1], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $top_image_new = Image::make($value)->resize($blog_top_image_new[0], $blog_top_image_new[1], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $blog_top_image_new = $newFileName.'-'.config('app.blog_top_image_new') . '.jpg';
                // Store the image on disk.
                Storage::put($destination_path . '/' . $blog_top_image_new, $top_image_new->stream());


                $blog_bottom_image_new =explode('x', config('app.blog_bottom_image_new'));
                if (exifExtIsEnabled()) {
                    $bottom_image_new = Image::make($value)->orientate()->resize($blog_bottom_image_new[0], $blog_bottom_image_new[1], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $bottom_image_new = Image::make($value)->resize($blog_bottom_image_new[0], $blog_bottom_image_new[1], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $blog_bottom_image_new = $newFileName.'-'.config('app.blog_bottom_image_new') . '.jpg';

                // Store the image on disk.
                Storage::put($destination_path . '/' . $blog_bottom_image_new, $bottom_image_new->stream());


            /* CROP TEMP NEW IMAGES END */


            $blog_bottom_image=explode('x', config('app.blog_bottom_image'));
            if (exifExtIsEnabled()) {
                $bottom_image = Image::make($value)->orientate()->resize($blog_bottom_image[0], $blog_bottom_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $bottom_image = Image::make($value)->resize($blog_bottom_image[0], $blog_bottom_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $blog_bottom_image = $newFileName.'-'.config('app.blog_bottom_image') . '.jpg';

            // Store the image on disk.
            Storage::put($destination_path . '/' . $blog_bottom_image, $bottom_image->stream());

            $blog_right_image=explode('x', config('app.blog_right_image'));
            if (exifExtIsEnabled()) {
                $right_image = Image::make($value)->orientate()->resize($blog_right_image[0], $blog_right_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $right_image = Image::make($value)->resize($blog_right_image[0], $blog_right_image[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $blog_right_image = $newFileName.'-'.config('app.blog_right_image') . '.jpg';

            // Store the image on disk.
            Storage::put($destination_path . '/' . $blog_right_image, $right_image->stream());


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

    public function getParentIdAttribute()
    {   
        if($this->attributes['translation_of'] > 0){
            return $this->attributes['parent_id'] = $this->attributes['translation_of'];
        }else{
            return $this->attributes['parent_id'] = $this->attributes['id'];
        }
    }

    // function to call from admin to remove <br> tags after image upload from simditor.
    public function removeBRTagFromImage($key, $value, $field_name){
        
        $content = $value;
        //find and remove </br> tag after image tag in long_text content
        if($key === $field_name){

            if( isset($content) && !empty($content) ){

                //find all image tag contain <br> tag
                preg_match_all('/<img[^>]+><br>/i', $content, $result);

                if(isset($result) && count($result) > 0 ){
                    foreach ($result[0] as $k => $match) {
                        //split image string with br tag and replace with it
                        $splitstr = explode('<br>', $match);
                        
                        if(isset($splitstr) && count($splitstr) > 0 ){
                            $content = str_replace($match, $splitstr[0], $content);
                        }
                        
                    }
                }
            }

            //find all image tag contain height and width property
            if( isset($content) && !empty($content) ){

                //find all image tag contain height and width property
                preg_match_all('/<img[^>]+>/i', $content, $result);

                if(isset($result) && count($result) > 0 ){

                    foreach ($result[0] as $k => $match) {

                        //remove 
                        $splitstr = preg_replace('/\\<(.*?)(width="(.*?)")(.*?)(height="(.*?)")(.*?)\\>/i', '<$1$4$7>', $match);

                        
                        if(isset($splitstr) && !empty($splitstr)){
                            $content = str_replace($match, $splitstr, $content);
                        }

                        /* find alt tag from images and remove file extensions from the images - start */
                        preg_match_all('/(alt)=("[^"]*")/i',$match, $altMatchArr);

                        $altMatch = '';
                        // if alt tag is found from the image then store old stl tag
                        if(isset($altMatchArr) && count($altMatchArr) > 0 && isset($altMatchArr[0])){
                            $altMatch = isset($altMatchArr[0][0])? $altMatchArr[0][0] : '';
                        }

                        if(isset($altMatch) && !empty($altMatch)){
                            // find the file extensions and replace with old alt tag value
                           $newMatch =  preg_replace('(\.jpg|\.jpeg|\.png|\.gif)', '', $altMatch);
                            $content = str_replace($altMatch, $newMatch, $content);
                        }
                        /* find alt tag from images and remove file extensions from the images - end */

                    }
                }
            }
        }

        return $content;
    }

}