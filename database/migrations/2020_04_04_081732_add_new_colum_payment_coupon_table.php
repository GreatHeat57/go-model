<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumPaymentCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_coupons', function ($table) {
            $table->string('payment_coupon_code')->after('discount_type')->default(0);
            $table->integer('payment_coupon_id')->after('payment_coupon_code')->default(0);
            $table->string('payment_coupon_name')->after('payment_coupon_id')->nullable();
            $table->float('payment_coupon_discount', 10, 0)->after('payment_coupon_name')->nullable();
            $table->float('payment_discounted_amount', 10, 0)->after('payment_coupon_discount')->nullable();
            $table->string('payment_discount_type')->after('payment_discounted_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->dropColumn('payment_coupon_code');
            $table->dropColumn('payment_coupon_id');
            $table->dropColumn('payment_coupon_name');
            $table->dropColumn('payment_coupon_discount');
            $table->dropColumn('payment_discounted_amount');
            $table->dropColumn('payment_discount_type');
        });
    }
}
