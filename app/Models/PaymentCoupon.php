<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCoupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_coupons';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'payment_id', 'coupon_code', 'coupon_id', 'coupon_name', 'coupon_discount', 'discounted_amount', 'discount_type', 'payment_coupon_code', 'payment_coupon_id', 'payment_coupon_name', 'payment_coupon_discount', 'payment_discounted_amount', 'payment_discount_type','coupon_type', 'coupon_tax', 'payment_coupon_type', 'payment_coupon_tax'];
}
