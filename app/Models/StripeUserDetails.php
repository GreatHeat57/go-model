<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeUserDetails extends Model
{   
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stripe_user_details';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'customer_id'];
}
