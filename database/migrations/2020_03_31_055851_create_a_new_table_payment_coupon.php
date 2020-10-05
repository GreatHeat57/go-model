<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateANewTablePaymentCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_coupons', function ($table) {
            $table->increments('id');
            $table->integer('payment_id')->default(0);
            $table->string('coupon_code')->default(0);
            $table->integer('coupon_id')->default(0);
            $table->string('coupon_name')->nullable();
            $table->float('coupon_discount', 10, 0)->nullable();
            $table->float('discounted_amount', 10, 0)->nullable();
            $table->string('discount_type')->nullable();
            $table->timestamps();
            $table->index('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_coupons');
    }
}
