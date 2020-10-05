<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = ['value'];
    public $timestamps = true;

    public function job(){
    	return $this->belongsTo(Post::class, 'post_id');
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function post(){
    	return $this->hasOne(Post::class, 'id', 'post_id');
    }
}