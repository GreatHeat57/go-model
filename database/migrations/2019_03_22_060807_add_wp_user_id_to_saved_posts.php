<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWpUserIdToSavedPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_posts', function ($table) { 
            $table->integer('`wp_user_id')->after('post_id')->nullable()->default(NULL);
            $table->integer('wp_post_id')->after('wp_user_id')->nullable()->default(NULL);
            $table->index(['wp_post_id', 'wp_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_posts', function ($table) {
            $table->dropColumn('wp_user_id');
            $table->dropColumn('wp_post_id');
        });
    }
}
