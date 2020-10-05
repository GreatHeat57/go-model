<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionExpireDateToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function ($table) {
            $table->date('transaction_expiry_date')->after('transaction_status')->nullable();
            $table->integer('transaction_listings')->after('transaction_expiry_date')->nullable();
            $table->integer('transaction_listing_expiry')->after('transaction_listings')->nullable();
            $table->char('transaction_listing_period',10)->after('transaction_listing_expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('transaction_expiry_date');
            $table->dropColumn('transaction_listings');
            $table->dropColumn('transaction_listing_expiry');
            $table->dropColumn('transaction_listing_period');
        });
    }
}
