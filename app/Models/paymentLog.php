<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paymentLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_logs';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'post_id', 'email', 'payment_method', 'stage', 'data', 'payment_name'];
}
