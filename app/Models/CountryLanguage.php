<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  CountryLanguage extends Model
{	
	protected $table = 'country_language';
    protected $fillable = ['value'];
    public $timestamps = false;
}