<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->string('wp_cs_port_list', 500)->nullable()->default(NULL);
            $table->integer('wp_cs_transaction_id')->nullable()->default(NULL);
            $table->char('wp_terms_condition_check', 10)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('user_profile', function($table) {
            $table->dropColumn('wp_cs_port_list');
            $table->dropColumn('wp_cs_transaction_id');
            $table->dropColumn('wp_terms_condition_check');
        });
    }
}
