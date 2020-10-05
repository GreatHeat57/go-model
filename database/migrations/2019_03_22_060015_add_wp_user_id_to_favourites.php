<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWpUserIdToFavourites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favorites', function ($table) { 
            $table->integer('wp_user_id')->after('fav_user_id')->nullable();
            $table->integer('wp_fav_id')->after('wp_user_id')->nullable();
            $table->index(['wp_fav_id', 'wp_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorites', function ($table) {
            $table->dropColumn('wp_user_id');
            $table->dropColumn('wp_fav_id');
        });
    }
}
