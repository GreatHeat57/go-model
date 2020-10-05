<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedNewFieldsPaymentCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_coupons', function ($table) {
            $table->string('coupon_type', 64)->nullable()->after('discount_type');
            $table->float('coupon_tax', 10, 0)->nullable()->after('coupon_type');
            $table->string('payment_coupon_type', 64)->nullable()->after('payment_discount_type');
            $table->float('payment_coupon_tax', 10, 0)->nullable()->after('payment_coupon_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_coupons', function (Blueprint $table) {
            $table->dropColumn('coupon_type');
            $table->dropColumn('coupon_tax');
            $table->dropColumn('payment_coupon_type');
            $table->dropColumn('payment_coupon_tax');
        });
    }
}
