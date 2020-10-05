<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LtmTranslations extends Model
{
    protected $table = 'ltm_translations';

    protected $fillable = ['status','locale','group','key','value','created_at','updated_at'];
}
