<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'fav_user_id'];

    public static function getFavouriteUsersById($user_id){

        $favourites = Favorite::SELECT('fav_user_id')->where('user_id',$user_id)->pluck('fav_user_id')->toArray();

        if(count($favourites)){
            $favourites = array_filter($favourites, function($value) { return $value != ''; });
        }
        return $favourites;
    }
}
