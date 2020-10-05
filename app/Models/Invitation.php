<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
   protected $fillable = ['partner_id', 'model_id','job_id','message','status','token'];
}
