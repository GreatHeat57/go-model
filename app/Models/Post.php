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

use App\Models\Scopes\FromActivatedCategoryScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Traits\CountryTrait;
use App\Observer\PostObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;
use Larapen\Admin\app\Models\Crud;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use App\Models\ModelCategory;
use App\Models\Branch;
use App\Models\SavedPost;
use App\Helpers\Localization\Helpers\Country as CountryHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Search;
use Illuminate\Support\Str;

class Post extends BaseModel implements Feedable
{
    use Crud, CountryTrait, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $appends = ['uri', 'created_at_ta', 'model_cat', 'branch_cat', 'country_name', 'title', 'description'];
    public $translatable = ['title', 'description'];

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
        'country_code',
        'user_id',
		'company_id',
        'company_name',
        'logo',
        'company_description',
        'ismodel',
        'category_id',
        'post_type_id',
        // 'title',
        // 'description',
		'tags',
        'salary_min',
        'salary_max',
        'salary_type_id',
        'negotiable',
        'start_date',
        'end_date',            
        'model_category_id',   
        'partner_category_id', 
        'experience_type_id',  
        'gender_type_id',      
        'tfp',      			  
        'height_from',      	  
        'height_to',      	  
        'weight_from',
        'weight_to',
        'age_from',      	   
        'age_to',      	   
        'dressSize_from',
        'dressSize_to',
        'chest_from',         
        'chest_to',         
        'waist_from',       	
        'waist_to',       	
        'hips_from',      	
        'hips_to',      	
        'shoeSize_from',  
        'shoeSize_to',  
        'eyeColor',   
        'hairColor',  
        'skinColor',        	  
        'application_url',
        'end_application',
        'contact_name',
        'email',
        'phone_code',
        'phone',
        'phone_hidden',
        'city',
        'lat',
        'lon',
        'address',
        'ip_addr',
        'visits',
		'tmp_token',
		'code_token',
		'email_token',
		'phone_token',
		'verified_email',
        'verified_phone',
        // 'ismade',
        'reviewed',
        'featured',
        'archived',
        'partner',
        'created_at',
        'username',
        'package',
        'subid',
        'code_without_md5',
        'currency_code',
        'dress_size_baby',
        'dress_size_men',
        'dress_size_women',
        'shoe_size_baby',
        'shoe_size_men',
        'shoe_size_women',
        'is_baby_model',
        'is_date_announce',
        'crm_transaction_id',
        'is_home_job',
        'subscription_type',
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $preventAttrSet = false;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Post::observe(PostObserver::class);

        static::addGlobalScope(new FromActivatedCategoryScope());
        static::addGlobalScope(new VerifiedScope());
        static::addGlobalScope(new ReviewedScope());
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function routeNotificationForNexmo()
    {
		$phone = phoneFormatInt($this->phone, $this->country_code);
		$phone = setPhoneSign($phone, 'nexmo');
		
		return $phone;
    }

    public function routeNotificationForTwilio()
    {
        $phone = phoneFormatInt($this->phone, $this->country_code);
		$phone = setPhoneSign($phone, 'twilio');
        
        return $phone;
    }
	
	public static function getFeedItems()
	{
		$postsPerPage = (int)config('settings.listing.items_per_page', 50);
		
		if (request()->has('d')) {
			$posts = Post::where('country_code', request()->input('d'))
						 ->take($postsPerPage)
						 ->orderByDesc('id')
						 ->get();
		} else {
			$posts = Post::take($postsPerPage)->orderByDesc('id')->get();
		}
		
		return $posts;
	}
	
	public function toFeedItem()
	{
		$title = $this->title;
		$title .= (isset($this->city->name) && !empty($this->city->name)) ? ' - ' . $this->city->name : '';
		$title .= (isset($this->country->name) && !empty($this->country->name)) ? ', ' . $this->country->name : '';
		// $summary = str_limit(str_strip(strip_tags($this->description)), 5000);
		$summary = transformDescription($this->description);
		$link = config('app.locale') . '/' . $this->uri;
		
		return FeedItem::create()
					   ->id($link)
					   ->title($title)
					   ->summary($summary)
					   ->updated($this->updated_at)
					   ->link($link)
					   ->author($this->contact_name);
	}

    public function getTitleHtml()
    {
        $post = self::find($this->id);

        return getPostUrl($post);
    }

    public function getLogoHtml()
    {
        $style = ' style="width:auto; max-height:90px;"';

        // Get logo
        $out = '<img src="' . resize($this->logo, 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';

        // Add link to the Ad
        $url = url(config('app.locale') . '/' . $this->uri);
        $out = '<a href="' . $url . '" target="_blank">' . $out . '</a>';

        return $out;
    }

    public function getPictureHtml()
    {
        $style = ' style="width:auto; max-height:90px;"';
        // Get first picture
        if ($this->pictures->count() > 0) {
            foreach ($this->pictures as $picture) {
                $out = '<img src="' . resize($picture->filename, 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';
                break;
            }
        } else {
            // Default picture
            $out = '<img src="' . resize(config('larapen.core.picture.default'), 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';
        }

        // Add link to the Ad
        $url = url(config('app.locale') . '/' . $this->uri);
        $out = '<a href="' . $url . '" target="_blank">' . $out . '</a>';

        return $out;
    }

    public function getCountryHtml()
    {
        $iconPath = 'images/flags/16/' . strtolower($this->country_code) . '.png';
        if (file_exists(public_path($iconPath))) {
            $out = '';
            $out .= '<a href="' . url('/') . '?d=' . $this->country_code . '" target="_blank">';
            $out .= '<img src="' . url($iconPath) . getPictureVersion() . '" data-toggle="tooltip" title="' . $this->country_code . '" alt="'.strtolower($this->country_code) . '.png">';
            $out .= '</a>';

            return $out;
        } else {
            return $this->country_code;
        }
    }

    public function getCityHtml()
    {
        if (isset($this->city) and !empty($this->city)) {
            // Pre URL (locale)
            $preUri = '';
            if (!(config('laravellocalization.hideDefaultLocaleInURL') == true && config('app.locale') == config('appLang.abbr'))) {
                $preUri = config('app.locale') . '/';
            }
            // Get URL
            if (config('larapen.core.multiCountriesWebsite')) {
                $url = url($preUri . trans('routes.v-search-city', [
                        'countryCode' => strtolower($this->city->country_code),
                        'city'        => slugify($this->city->name),
                        'id'          => $this->city->id,
                    ]));
            } else {

                $url = url($preUri . trans('routes.v-search-city', [
                        'city'        => slugify($this->city),
                        'id'          => $this->city_id,
                    ]));
            }

            // return '<a href="' . $url . '" target="_blank">' . $this->city . '</a>';
            return $this->city;
        } else {
            return $this->city_id;
        }
    }

    public function getReviewedHtml()
    {
        return ajaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'reviewed', $this->reviewed);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function postType()
    {
        return $this->belongsTo(PostType::class, 'post_type_id')->trans();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'post_id');
    }

    public function onePayment()
    {
        return $this->hasOne(Payment::class, 'post_id');
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'post_id')->orderBy('position')->orderBy('id');
    }

    public function savedByUsers()
    {
        return $this->hasMany(SavedPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
	
	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id');
	}

    public function postConversation()
    {
       return $this->messages()->where('parent_id','=','0');
    }

    public function postInviations()
    {
       return $this->messages()->where('parent_id','=','0')->where('message_type','Invitation');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function dressSizeOption_from()
    {
        return $this->belongsTo(UserDressSizeOptions::class, 'dressSize_from', 'id');
    }

    public function dressSizeOption_to()
    {
        return $this->belongsTo(UserDressSizeOptions::class, 'dressSize_to', 'id');
    }

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_code');
    // }

    public function userConversation()
    {
        return $this->hasMany(Message::class, 'post_id')->where(function($q){
                    $q->where('to_user_id', Auth::User()->id)
                        ->orWhere('from_user_id', Auth::User()->id);
                    })
                    ->whereRaw('message_type = "Conversation"');
    }

    public function userUnreadConversation()
    {
        // return $this->userConversation()->where('is_read', 0)->where('to_user_id', Auth::User()->id);
        return $this->hasMany(Message::class, 'post_id')->where('is_read', 0)->where('to_user_id', Auth::User()->id)->whereRaw('message_type = "Conversation"');
    }

    public function latestMessage()
    {
      return $this->hasOne(Message::class)->latest();
    }

    public function applications()
    {
        return $this->messages()->where('to_user_id', auth()->user()->id);
    }

    public function jobApplications() {
        return $this->hasMany(JobApplication::class, 'post_id');
    }

    public function jobApplicationsCount() {
        return $this->jobApplications()->whereHas('user');
    }

    public function jobVisits()
    {
       return $this->hasMany(JobView::class, 'job_id');
    }

    public function jobsTranslation()
    {   
        $locale = config('app.locale');

        if (\Request::is('admin/*')) {

            if(collect(request()->segments())->last() == 'edit'){

                if(config('app.post_locale') && !empty(config('app.post_locale'))){ 

                    $locale = config('app.post_locale');
                }
            }
        }
        return $this->hasOne(JobsTranslation::class, 'job_id')->where('translation_lang', $locale);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeVerified($builder)
    {
        $builder->where(function($query) {
            $query->where('verified_email', 1)->where('verified_phone', 1);
        });
        
        if (config('settings.single.posts_review_activation')) {
            $builder->where('reviewed', 1);
        }
        
        return $builder;
    }
    
    public function scopeUnverified($builder)
    {
        $builder->where(function($query) {
            $query->where('verified_email', 0)->orWhere('verified_phone', 0);
        });
        
        if (config('settings.single.posts_review_activation')) {
            $builder->orWhere('reviewed', 0);
        }
        
        return $builder;
    }
    
    public function scopeArchived($builder)
    {
        return $builder->where('archived', 1);
    }
    
    public function scopeUnarchived($builder)
    {
        return $builder->where('archived', 0);
    }
    
    public function scopeReviewed($builder)
    {
        if (config('settings.single.posts_review_activation')) {
            return $builder->where('reviewed', 1);
        } else {
            return $builder;
        }
    }
    
    public function scopeUnreviewed($builder)
    {
        if (config('settings.single.posts_review_activation')) {
            return $builder->where('reviewed', 0);
        } else {
            return $builder;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getCreatedAtAttribute($value)
    {
        $value = Date::parse($value);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }
        //echo $value->format('l d F Y H:i:s').'<hr>'; exit();
        //echo $value->formatLocalized('%A %d %B %Y %H:%M').'<hr>'; exit(); // Multi-language

        return $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        $value = Date::parse($value);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }

        return $value;
    }

    public function getDeletedAtAttribute($value)
    {   
        if(!$this->preventAttrSet){
            $value = Date::parse($value);
            if (config('timezone.id')) {
                $value->timezone(config('timezone.id'));
            }
        }

        return $value;
    }

    public function getCreatedAtTaAttribute($value)
    {
		Date::setLocale(app()->getLocale());
        $value = Date::parse($this->attributes['created_at']);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }
        $value = $value->ago();

        return $value;
    }
    
    public function getEmailAttribute($value)
    {
        if (
			isDemo() &&
            Request::segment(2) != 'password'
        ) {
            if (auth()->check()) {
                if (auth()->user()->id != 1) {
                    $value = hideEmail($value);
                }
            }
            
            return $value;
        } else {
            return $value;
        }
    }
    
    public function getPhoneAttribute($value)
    {
        $countryCode = config('country.code');
        if (isset($this->country_code) && !empty($this->country_code)) {
            $countryCode = $this->country_code;
        }
        
        $value = phoneFormatInt($value, $countryCode);
        
        return $value;
    }
	
	public function getUriAttribute($value)
	{  
        if(isset($this->jobsTranslation->title)){
            
            $title =  $this->jobsTranslation->title; 
        }else{

            // $title = $this->attributes['title'];
            $title = '';
        }

        $value = trans('routes.v-post', [
            'slug' => slugify($title),
            'id'   => $this->attributes['id'],
        ]);
        
        return $value;
         
		// $value = trans('routes.v-post', [
		// 	'slug' => slugify($this->attributes['title']),
		// 	'id'   => $this->attributes['id'],
		// ]);
		
		// return $value;
	}

    public function getCountryNameAttribute($value)
    {
        $country = new CountryHelper();
        if ($name = $country->get($this->country_code, config('app.locale'))) {
            return $name;
        } else {
            return '';
        }
    }    

    public function getLogoFromOldPath()
    {
        if (!isset($this->attributes) || !isset($this->attributes['logo'])) {
            return null;
        }

        $value = $this->attributes['logo'];

        // Fix path
        $value = str_replace('uploads/pictures/', '', $value);
        $value = str_replace('pictures/', '', $value);
        $value = 'pictures/' . $value;

        if (!Storage::exists($value)) {
            $value = null;
        }

        return $value;
    }

    public function getLogoAttribute()
    {
        // OLD PATH
        $value = $this->getLogoFromOldPath();
        if (!empty($value)) {
            return $value;
        }

        // NEW PATH
        if (!isset($this->attributes) || !isset($this->attributes['logo'])) {
            $value = config('larapen.core.picture.default');
            return $value;
        }

        $value = $this->attributes['logo'];

        if (!Storage::exists($value)) {
            $value = config('larapen.core.picture.default');
        }

        return $value;
    }

    public static function getLogo($value)
    {
        // OLD PATH
        $value = str_replace('uploads/pictures/', '', $value);
        $value = str_replace('pictures/', '', $value);
        $value = 'pictures/' . $value;
        if (Storage::exists($value) && substr($value, -1) != '/') {
            return $value;
        }

        // NEW PATH
        $value = str_replace('pictures/', '', $value);
        if (!Storage::exists($value) && substr($value, -1) != '/') {
            $value = config('larapen.core.picture.default');
        }

        return $value;
    }

    public function getModelCatAttribute()
    {
        $modelCat = $category = '';
        
        if (isset($this->attributes['model_category_id']) || !empty($this->attributes['model_category_id'])) {
            $modelCat = explode(',', $this->attributes['model_category_id']);
        }

        if( !empty($modelCat) && count($modelCat) > 0 ){
            
            // $category = ModelCategory::whereIn('id', $modelCat)->pluck('name')->toArray();

            $category = ModelCategory::trans()
                ->where(function($q) use ($modelCat) {
                    $q->whereIn('id', $modelCat)
                    ->orWhereIn('translation_of', $modelCat);
                })
                ->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang')
                ->get();
                // ->pluck('name' , 'id')->toArray();
            return $category;
        }
        
        return $category;

    }

    public function getJobCatAttribute()
    {
        $jobCat = $category = '';
        
        if (isset($this->attributes['category_id']) || !empty($this->attributes['category_id'])) {
            $jobCat = explode(',', $this->attributes['category_id']);
        }

        if( !empty($jobCat) && count($jobCat) > 0 ){

            $category = Category::trans()
                ->where(function($q) use ($jobCat) {
                    $q->whereIn('id', $jobCat)
                    ->orWhereIn('translation_of', $jobCat);
                })
                ->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang')
                ->get();
            return $category;
        }
        
        return $category;

    }
    public function getPostTypeAttribute()
    {
        $jobType = $postTypes = '';
        
        if (isset($this->attributes['post_type_id']) || !empty($this->attributes['post_type_id'])) {
            $jobType = $this->attributes['post_type_id'];
        }
        if( !empty($jobType)){
            $postTypes = PostType::trans()
                ->where(function($q) use ($jobType) {
                    $q->where('id', $jobType)
                    ->orWhere('translation_of', $jobType);
                })
                ->select('id', 'name', 'translation_of', 'translation_lang')
                ->first();
            return $postTypes;
        }
        return $postTypes;

    }

    public function getBranchCatAttribute()
    {
        $branch = $category = '';
        
        if (isset($this->attributes['partner_category_id']) || !empty($this->attributes['partner_category_id'])) {
            $branch = explode(',', $this->attributes['partner_category_id']);
        }

        if( !empty($branch) && count($branch) > 0 ){
            // $category = Branch::whereIn('id', $branch)->pluck('name')->toArray();

            $category = Branch::trans()
                ->where(function($q) use ($branch) {
                    $q->whereIn('id', $branch)
                    ->orWhereIn('translation_of', $branch);
                })
                ->select('id', 'parent_id', 'name', 'translation_of', 'translation_lang')
                ->get();
                
            return $category;
        }
        
        return $category;

    }
    

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setLogoAttribute($value)
    {
        $attribute_name = 'logo';
	
		// Don't make an upload for Post->logo for logged users
		if (!Str::contains(Route::currentRouteAction(), 'Admin\PostController')) {
			if (Auth::check()) {
				$this->attributes[$attribute_name] = $value;
				
				return $this->attributes[$attribute_name];
			}
		}

        if (!isset($this->country_code) || !isset($this->id)) {
            $this->attributes[$attribute_name] = null;
            return false;
        }

        // Path
        $destination_path = 'files/' . strtolower($this->country_code) . '/' . $this->id;

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
    
        // Check the image file
        if ($value == url('/')) {
            $this->attributes[$attribute_name] = null;
        
            return false;
        }

        // If laravel request->file('filename') resource OR base64 was sent, store it in the db
        try {
            // Make the image (Size: 454x454)
            $image = Image::make($value)->resize(454, 454, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
            $this->attributes[$attribute_name] = null;

            return false;
        }

        // Generate a filename.
        $filename = md5($value . time()) . '.jpg';

        // Store the image on disk.
        Storage::put($destination_path . '/' . $filename, $image->stream());

        // Save the path to the database
        $this->attributes[$attribute_name] = $destination_path . '/' . $filename;
        
        return $this->attributes[$attribute_name];
    }
	
	public function setTagsAttribute($value)
	{
		$this->attributes['tags'] = (!empty($value)) ? mb_strtolower($value) : $value;
	}
	
	public function setApplicationUrlAttribute($value)
	{
		$this->attributes['application_url'] = (!empty($value)) ? strtolower($value) : $value;
	}

    public static function getUserPostById($user_id, $report_type, $perpage = null, $user = null){

        $query = Post::select('posts.*', 'jobs_translation.job_id', 'jobs_translation.title', 'jobs_translation.description', 'jobs_translation.translation_lang')->where('user_id', $user_id);

        $query->leftJoin('jobs_translation', function ($join){
            $join->on('jobs_translation.job_id', '=' , 'posts.id');
            $join->where('jobs_translation.translation_lang','=', config('app.locale'));
        }); 

        $data = array();

        if($report_type === 'my-posts'){
            $query->where('posts.archived', 0);
        }

        if($report_type === 'archived'){
            $query->where('posts.archived', 1);
        }

        if($report_type === 'model_post'){
            $ismodel = 1;
            
            if( isset($user) && !empty($user) ){
                
                if($user->user_type_id == config('constant.partner_type_id')){
                    $ismodel = 0;
                }

                $gender_type_id = config('constant.gender_male');

                if($user->gender_id == config('constant.gender_female')){
                    $gender_type_id = $user->gender_id;
                }

                $query->where('posts.archived', 0)->whereNull('posts.deleted_at')->where('posts.ismodel', $ismodel);
                $query->where(function ($query) use ($gender_type_id) {
                    $query->orWhere('posts.gender_type_id', $gender_type_id);
                    $query->orWhere('posts.gender_type_id', 0);
                });
               
            }else{
                $query->where('posts.archived', 0)->whereNull('posts.deleted_at')->where('posts.ismodel', 1);
            }

        }

        $data['count'] = $query->count();
        if($perpage != null){
            $data['paginator'] = $query->orderby('posts.id', 'desc')->paginate($perpage);
        } else if($user) {
            $data['posts'] = $query->orderby('jobs_translation.title', 'asc')->get();
        }else {
            $data['posts'] = $query->orderby('posts.id', 'desc')->get();
        }        
        return $data;
    }

    public static function myPosts($user_id, $perpage = null, $count = null){
        $posts = Post::where('user_id', $user_id)
             ->verified()
             ->unarchived()
             ->reviewed()
             ->with('city')
             ->orderByDesc('id');

        if($count){
            return $posts->count();
        }

        if($perpage){
            return $posts->paginate($perpage);
        } else {
            return $posts->get();
        }
           
    }


    public static function myPendingPosts($user_id, $perpage = null, $count = null){
        $posts = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
                ->currentCountry()
                ->where('user_id', $user_id)
                ->unverified()
                ->with('city')
                ->orderByDesc('id');

        if($count){
            return $posts->count();
        }

        if($perpage){
            return $posts->paginate($perpage);
        } else {
            return $posts->get();
        }
           
    }

    public static function myPostsByCompanyId($comapny_id, $perpage = null, $count = null){
        $posts = Post::withoutGlobalScopes()->where('company_id', $comapny_id)
             ->orderByDesc('id');

        if($count){
            return $posts->count();
        }

        if($perpage){
            return $posts->paginate($perpage);
        } else {
            return $posts->get();
        }
           
    }


    /* Return User Applied Jobs List*/
    public static function getAppliedJobs($perpage, $search= null, $count){
        $jobs = array();

        if(Auth::check()){
            $jobs = Post::SELECT('posts.*')
                ->leftjoin('job_applications', 'job_applications.post_id','posts.id')
                ->where('job_applications.user_id', Auth::User()->id)
                ->where('posts.archived',0)
                ->whereNull('posts.deleted_at')
                ->orderByDesc('job_applications.created_at');
        }

        if($count){
            return $jobs->count();
        }

        return $jobs->paginate($perpage);
    }    
    // get description in job translation table 
    public function getDescriptionAttribute($value) {
         
        $is_allow = true;
        if (\Request::is('admin/*')) {

            // not is edit page, added Attribute
            if(collect(request()->segments())->last() != 'edit'){

                $is_allow = false;
            }
        }
        
        if ($is_allow) { 
            
            $description = '';
            if(isset($this->jobsTranslation->description)){

                $description =  $this->jobsTranslation->description; 
            }
            return $description;
        }
        return $value;
    }

    // get title in job translation table
    public function getTitleAttribute($value) {

        $is_allow = true;
        
        if (\Request::is('admin/*')) {

            // not is edit page, added Attribute
            if(collect(request()->segments())->last() != 'edit'){

                $is_allow = false;
            }
        }
        
        if ($is_allow) { 

            $title = '';
            
            if(isset($this->jobsTranslation->title)){

                $title =  $this->jobsTranslation->title; 
            }
            return $title;
        }
        
        return $value;
    }
    
    /* Return User Jobs details list*/
    public static function getJobDetails($jobType=null,$timeStamp=null,$offset, $limit){
        if( isset($timeStamp) & !empty($timeStamp) ){
            $dateTime = date('Y-m-d H:i:s', $timeStamp);
        }

        $data = array();
        $jobs = Post::withoutGlobalScopes()->select('posts.*')
                            ->leftjoin('users', 'users.id', '=', 'posts.user_id')
                            ->where('posts.archived',0)
                            ->whereNull('posts.deleted_at')
                            ->where('users.active', 1)
                            ->whereNull('users.deleted_at');
                        
                            $jobs->where(function ($query) {
                                $query->whereNotNull('posts.title')
                                      ->Where('posts.title',"!=", '');
                            });
                            if(isset($dateTime) && $dateTime!=''){

                                $jobs->where('posts.updated_at', '<=', $dateTime);
                            }
                            if(isset($jobType) && $jobType!=''){

                                $jobs=$jobs->where('ismodel','=', $jobType);
                            }
        
        $count = $jobs->get()->count();

        $jobData = $jobs->orderby('posts.id', 'desc')->skip($offset)->take($limit)->get()->toArray();
        if(isset($jobData) && $jobData!='' && count($jobData) > 0){
            foreach ($jobData as $jobDataKey => $jobDataValue) {

                $data[$jobDataKey]['title'] = $jobDataValue['title'];

                if( isset($jobDataValue['uri']) && !empty($jobDataValue['uri'])){
                    $data[$jobDataKey]['url'] = url($jobDataValue['uri']);
                }

                if(isset($jobDataValue['ismodel']) && $jobDataValue['ismodel']!='' && $jobDataValue['ismodel']=="0"){
                    $data[$jobDataKey]['job_type'] = 'Partner';
                }else if(isset($jobDataValue['ismodel']) && $jobDataValue['ismodel']!='' && $jobDataValue['ismodel']=="1"){
                    $data[$jobDataKey]['job_type'] = 'Model'; 
                }
                
                // $data[$jobDataKey]['applications_close_on'] = $jobDataValue['end_application'];
                $data[$jobDataKey]['application_close_on'] = date('Y-m-d', strtotime($jobDataValue['end_application']));

                $data[$jobDataKey]['created_at'] = ($jobDataValue['created_at']->format('Y-m-d'))? $jobDataValue['created_at']->format('Y-m-d') : '';
            }
            return array('status' => true,'message' => 'records fetch successfully','count' => $count,'from' => $offset,
                'to'  => $limit, 'data' => $data);
        }
        else{
            return array(
                'status' => false, 'message' => 'Users date not found','count' =>0,'from' => 0,'to'  => 0, 'data' => 0
            );
        }
    }

}
