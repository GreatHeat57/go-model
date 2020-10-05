<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguages extends Model
{
    protected $table = 'user_languages';

    public $timestamps = true;

    public static function getLanugageByUserId($user_id){
    	return UserLanguages::where('user_id', $user_id)->get();
    }

    public static function getLanugageById($id){
    	return UserLanguages::where('id', $id)->first();
    }
}
