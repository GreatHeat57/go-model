<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWpPostIdToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function ($table) { 
            $table->integer('wp_post_id')->after('transaction_id')->nullable()->default(NULL);
            $table->integer('wp_package_id')->after('wp_post_id')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function ($table) {
            $table->dropColumn('wp_post_id');
            $table->dropColumn('wp_package_id');
        });
    }
}
