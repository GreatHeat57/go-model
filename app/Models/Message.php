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

use App\Observer\MessageObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Larapen\Admin\app\Models\Crud;

class Message extends BaseModel
{
	use Crud, Notifiable;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';
    
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
		'post_id',
		'parent_id',
		'from_user_id',
		'from_name',
		'from_email',
        'from_phone_code',
		'from_phone',
		'to_user_id',
		'to_name',
		'to_email',
        'to_phone_code',
		'to_phone',
		'subject',
		'message',
		'filename',
		'is_read',
        'invitation_status',
        'message_type',
        'is_email_send'
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
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		Message::observe(MessageObserver::class);
    }
	
	public function routeNotificationForMail()
	{
		return $this->to_email;
	}
	
	public function routeNotificationForNexmo()
	{
		$phone = phoneFormatInt($this->to_phone, config('country.code'));
		$phone = setPhoneSign($phone, 'nexmo');
		
		return $phone;
	}
	
	public function routeNotificationForTwilio()
	{
        $phone = phoneFormatInt($this->to_phone, config('country.code'));
		$phone = setPhoneSign($phone, 'twilio');
        
        return $phone;
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
	
	public function latestReply()
	{
		// Get the Conversation's latest Message
		$latestReply = self::where('parent_id', $this->id)->orderByDesc('id')->first();
		
		return $latestReply;
	}
    public function latestPartnerReply()
    {
        // Get the partner's latest Message
        $latestPartnerReply = self::where('parent_id', $this->id)->where('to_user_id',$this->to_user_id)->orderByDesc('id')->first();
        
        return $latestPartnerReply;
    }

    public function convparent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function convmessages()
    {
        return $this->hasMany(Message::class, 'parent_id')->latest();
    }

    public function convunreadmessages()
    {
       return $this->convmessages()->where('from_user_id','!=', Auth::User()->id)->where('parent_id','!=','0')->where('is_read','=', 0);
    }

    public function from_user() {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function to_user() {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function totalmessages()
    {
       return $this->convmessages()->where('from_user_id','!=', Auth::User()->id)->where('parent_id','!=','0');
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
    public function getFilenameFromOldPath()
    {
        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];

        // Fix path
        $value = str_replace('uploads/resumes/', '', $value);
        $value = str_replace('resumes/', '', $value);
        $value = 'resumes/' . $value;

        if (!Storage::exists($value)) {
            return null;
        }

        // $value = 'uploads/' . $value;

        return $value;
    }

    public function getFilenameAttribute()
    {
        $value = $this->getFilenameFromOldPath();
        if (!empty($value)) {
            return $value;
        }

        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];
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
		$field_name = 'resume.filename';
        $attribute_name = 'filename';
        $disk = config('filesystems.default');
	
        // Set the right field name
		$request = \Request::instance();
		if (!$request->hasFile($field_name)) {
			$field_name = $attribute_name;
		}
	
		// Don't make an upload for Message->filename for logged users
		if (Auth::check()) {
			$this->attributes[$attribute_name] = $value;
		
			return $this->attributes[$attribute_name];
		}

        // Get ad details
        $post = Post::find($this->post_id);
        if (empty($post)) {
            $this->attributes[$attribute_name] = null;
            return false;
        }

        // Path
        $destination_path = 'files/' . strtolower($post->country_code) . '/' . $post->id . '/applications';

        // Upload
        $this->uploadFileToDiskCustom($value, $field_name, $attribute_name, $disk, $destination_path);
    }

    public static function getConversations($user_id, $perpage= null, $count = false, $search = null){

        //@todo:need to convert this query laravel style
        // $conversations = Message::with('post')
        // ->whereHas('post', function ($query) {
        //         $query->WhereNull('posts.deleted_at');
        //     })
        //     ->where(function ($query) use ($user_id) {
        //         $query->where('messages.to_user_id', $user_id)->orWhere('messages.from_user_id', $user_id);
        //     })
        //     ->where(function ($query) use ($user_id) {
        //         $query->where('messages.deleted_by', '!=', $user_id)->orWhereNull('messages.deleted_by');
        //     })
        //     ->where('messages.parent_id', 0)
        //     ->where('messages.archived', 0)
        //     ->where('messages.invitation_status', '1')
        //     ->orderByDesc('messages.id');

        $conversations = Message::with(array('post'=>function($query){
                                    $query->select('id','title');
                                }))
                        ->wherehas('post', function($query){
                            $query->where('archived', 0);
                        })
                        ->select('messages.*','posts.title','up1.logo as to_user_profile','up2.logo as from_user_profile','up1.first_name as to_user_name','up2.first_name as from_user_name','posts.contact_name')->with('convunreadmessages')
                        ->where(function ($query) use ($user_id) {
                            $query->where('messages.to_user_id', $user_id)->orWhere('messages.from_user_id', $user_id);
                        })
                        ->join('posts', 'posts.id','messages.post_id')
                        ->join('user_profile as up1', 'up1.user_id','messages.to_user_id')
                        ->join('user_profile as up2', 'up2.user_id','messages.from_user_id')
                        ->where('messages.parent_id', 0)
                        ->where('messages.invitation_status', '1')
                        ->WhereNull('posts.deleted_at')
                        ->where(function ($query) use ($user_id) {
                            $query->where('messages.deleted_by', '!=', $user_id)->orWhereNull('messages.deleted_by');
                        })        
                        ->orderByDesc('messages.id');

        if(!empty($search)){
            $conversations->where('posts.title','LIKE', '%'.$search.'%');
        }
        if($count){
            return $conversations->count();
        }

        if($perpage){
            return $conversations->paginate($perpage);
        } else {
            return $conversations->get();
        }
    }

    public static function getMessages($search = null, $to_user = false, $start = 0, $limit = 0, $allConversation = true){

        $result = array();

        $user_id = auth()->user()->id;

        // if($allConversation == true){  

            
        //     // model only get All conversations
        //     // $conversations = Post::withoutGlobalScopes()
        //     //                 ->whereHas('userConversation')
        //     //                 ->with('latestMessage')
        //     //                 ->where('archived', 0)
        //     //                 ->where('deleted_at', NULL);

        //     $conversations = Message::with('convunreadmessages')->with('totalmessages')->whereHas('convmessages')->where(function($query) use($user_id) {
        //                         $query->where('from_user_id', $user_id)->orwhere('to_user_id', $user_id);
        //                     })->where( function($query){
        //                         $query->where('message_type','Invitation')->orwhere('message_type','Job application');
        //                     })->whereHas('post', function($query){
        //                         $query->where('archived',0)->where('deleted_at',NULL);
        //                     });
        // }else{


        //     // model only get unread conversations
        //     // $conversations = Post::withoutGlobalScopes()
        //     //                 ->whereHas('userUnreadConversation')
        //     //                 ->with('latestMessage')
        //     //                 ->where('archived', 0)
        //     //                 ->where('deleted_at', NULL);

        //     $conversations = Message::with('convmessages')->with('totalmessages')->whereHas('convunreadmessages')->where(function($query) use($user_id) {
        //                         $query->where('is_read', 0)->where('from_user_id', $user_id)->orwhere('to_user_id', $user_id);
        //                     })->where( function($query){
        //                         $query->where('message_type','Invitation')->orwhere('message_type','Job application');
        //                     })->whereHas('post', function($query){
        //                         $query->where('archived',0)->where('deleted_at',NULL);
        //                     });
        // }

        // if(!empty($search) && $search !== null){
        //     $conversations->whereHas('post', function ($query) use ($search) {
        //         $query->where('message', 'like', '%'.$search.'%')
        //             ->orWhere('posts.title', 'like', '%'.$search.'%');
        //     });
        // }


        $limit = " LIMIT ".$start.", ".$limit;
        $order = "  order by user_is_read ASC, `created_at` DESC ";

        // $query = " SELECT * FROM (
        //             SELECT ( SELECT count(*) FROM `messages` as ms 
        //             LEFT JOIN `posts` as p ON `ms`.`post_id` = `p`.`id` where ms.`to_user_id` = $user_id and `ms`.`parent_id` != '0' AND `ms`.`is_read` = 0
        //             AND `ms`.`message_type` = 'Conversation' 
        //             AND `p`.`archived` = 0 
        //             AND `p`.`deleted_at` IS NULL AND `ms`.`parent_id` = `m`.`parent_id` AND `ms`.`is_read` = 0  GROUP BY `m`.`parent_id` ) as msgcount, `m`.`id`, `m`.`parent_id`, `m`.`created_at`, `m`.`is_read`, `p`.`title`, `m`.`message`, `u`.`username`, `up`.`first_name`, `up`.`last_name`, `up`.`logo`, CONCAT(`up`.`first_name`,' ',`up`.`last_name`) as full_name,
        //             `m`.`from_user_id`, `m`.`to_user_id`

        //          FROM `messages` as m 

        //          LEFT JOIN `posts` as p ON `m`.`post_id` = `p`.`id`
        //          JOIN `users` as u ON `u`.`id` = `m`.`from_user_id`
        //          JOIN `user_profile` as up ON `up`.`user_id` = `u`.`id`
        //          LEFT JOIN messages m2  ON (`m`.`parent_id` = `m2`.`parent_id` AND `m`.`id` < `m2`.`id`)
        //          where `m`.`to_user_id` = '".$user_id."' 
        //          AND `m`.`message_type` = 'Conversation' 
        //          AND `p`.`archived` = 0 
        //          AND `p`.`deleted_at` IS NULL 
        //          ORDER BY `m`.`is_read` , `m`.`id` ASC

        //         ) as tbl  ";

        $query = " SELECT * FROM (
                      SELECT IF(`m`.`to_user_id` = :user_id, IF(`m`.`is_read` = 0, 0, 1), 1) as user_is_read,
                      ( SELECT count(*) FROM `messages` as ms 
                    LEFT JOIN `posts` as p ON `ms`.`post_id` = `p`.`id` where ms.`to_user_id` = :user_id and `ms`.`parent_id` != '0' AND `ms`.`is_read` = 0
                    AND `ms`.`message_type` = 'Conversation' 
                    AND `p`.`archived` = 0 
                    AND `p`.`deleted_at` IS NULL 
                    AND `ms`.`parent_id` = `m`.`parent_id` 
                    AND `ms`.`is_read` = 0  
                    GROUP BY `m`.`parent_id` ) as msgcount, 
                    `m`.`id`, `m`.`parent_id`, `m`.`created_at`, `m`.`is_read`, `j`.`title`, `m`.`message`, `u`.`username`, `up`.`first_name`, `up`.`last_name`, `up`.`logo`, `up`.`first_name` as full_name,`m`.`from_user_id`, `m`.`to_user_id`

                 FROM `messages` as m 

                 LEFT JOIN `posts` as p ON `m`.`post_id` = `p`.`id`
                 LEFT JOIN `jobs_translation` as j ON `j`.`job_id` = `p`.`id` AND `j`.`translation_lang` = :locale

                 JOIN `users` as u ON `u`.`id` = IF(`m`.`from_user_id` = :user_id, `m`.`to_user_id`, `m`.`from_user_id`) 
                 JOIN `user_profile` as up ON `up`.`user_id` = `u`.`id`
                 LEFT JOIN messages m2  ON (`m`.`parent_id` = `m2`.`parent_id` AND `m`.`id` < `m2`.`id`)
                 where ( `m`.`to_user_id` = :user_id OR `m`.`from_user_id` = :user_id )
                 AND `m`.`message_type` = 'Conversation' 
                 AND `p`.`archived` = 0 
                 AND `p`.`deleted_at` IS NULL
                 AND `u`.`deleted_at` IS NULL";

            // break the query to search from selected results
            if(!empty($search) && $search !== null){
                $query .= " AND ( m.`message` LIKE '%".$search."%' OR j.`title` LIKE '%".$search."%' ) ";
            }

            $query .= " 
                    UNION 
                    SELECT IF(`m`.`to_user_id` = :user_id, IF(`m`.`is_read` = 0, 0, 1), 1) as user_is_read,
                      ( SELECT count(*) FROM `messages` as ms 
                    LEFT JOIN `posts` as p ON `ms`.`post_id` = `p`.`id` where ms.`to_user_id` = :user_id and `ms`.`parent_id` != '0' AND `ms`.`is_read` = 0
                    AND `ms`.`message_type` = 'Conversation' 
                    AND `ms`.`post_id` = 0
                    AND `ms`.`parent_id` = `m`.`parent_id` 
                    AND `ms`.`is_read` = 0  
                    GROUP BY `m`.`parent_id` ) as msgcount, 
                    `m`.`id`, `m`.`parent_id`, `m`.`created_at`, `m`.`is_read`, `j`.`title`, `m`.`message`, `u`.`username`, `up`.`first_name`, `up`.`last_name`, `up`.`logo`, `up`.`first_name` as full_name,`m`.`from_user_id`, `m`.`to_user_id`

                 FROM `messages` as m 

                 LEFT JOIN `posts` as p ON `m`.`post_id` = `p`.`id`
                 LEFT JOIN `jobs_translation` as j ON `j`.`job_id` = `p`.`id` AND `j`.`translation_lang` = :locale

                 JOIN `users` as u ON `u`.`id` = IF(`m`.`from_user_id` = :user_id, `m`.`to_user_id`, `m`.`from_user_id`) 
                 JOIN `user_profile` as up ON `up`.`user_id` = `u`.`id`
                 LEFT JOIN messages m2  ON (`m`.`parent_id` = `m2`.`parent_id` AND `m`.`id` < `m2`.`id`)
                 where ( `m`.`to_user_id` = :user_id OR `m`.`from_user_id` = :user_id )
                 AND `m`.`message_type` = 'Conversation' 
                 AND `m`.`post_id` = 0 AND `u`.`deleted_at` IS NULL";


            // $query .= " ORDER BY user_is_read ASC, `m`.`id` DESC  ) as tbl ";

            // if(!empty($search) && $search !== null){
            //     $query .= " GROUP BY parent_id ORDER BY user_is_read ASC,id DESC ";
            // }else{
            //     $query .= "WHERE id IN ( SELECT MAX(id) FROM messages where ( `to_user_id` = :user_id OR `from_user_id` = :user_id ) GROUP BY parent_id ORDER BY id DESC ) ";
            // }

             // break the query to search from selected results
            if(!empty($search) && $search !== null){
                $query .= " AND ( m.`message` LIKE '%".$search."%' OR j.`title` LIKE '%".$search."%' ) ";
            }
            
            $query .= " ) as tbl ";

            if(!empty($search) && $search !== null){
                $query .= " GROUP BY parent_id ORDER BY user_is_read ASC,id DESC ";
            }else{
                $query .= "WHERE id IN ( SELECT MAX(id) FROM messages where ( `to_user_id` = :user_id OR `from_user_id` = :user_id ) GROUP BY parent_id ORDER BY id DESC ) ";
            }


        if( !empty($query) ){

            if(empty($search) && $search == ""){
                $query = $query.$order;
            }

            // echo "<pre>"; print_r ($query.$limit); echo "</pre>"; exit();
            
            // $records = \DB::select( \DB::raw($query) );
            $records = \DB::select(\DB::raw($query), [":user_id" => $user_id, ':locale' => config('app.locale')]);
            $result['count'] = count($records);
            $result['data'] = \DB::select( \DB::raw($query.$limit),  [":user_id" => $user_id, ':locale' => config('app.locale')]);
        }

        // echo "<pre>"; print_r ($query.$limit); echo "</pre>"; exit();
        // $result['count'] = $conversations->count();


        // if($limit > 0){
        //     $result['data'] = $conversations->offset($start)->limit($limit)->orderby('id', 'desc')->get()->sortBy('convunreadmessages.id');
        // }
        // else{
        //     $result['data'] = $conversations->get()->orderby('id', 'desc')->sortBy('convunreadmessages.id');
        // }

        return $result;
    }

    public static function IsUserAccept($partner_id, $model_id){
        return  Message::where('from_user_id', $partner_id)
                                ->where('to_user_id', $partner_id)
                                ->WhereNull('deleted_by')
                                ->where('invitation_status', 1)
                                ->count();
    }
}
