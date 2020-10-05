<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBlogEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_entries', function (Blueprint $table) {
            $table->integer('wp_post_author')->after('wp_post_id')->nullable();
            $table->integer('post_author')->after('wp_post_author')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_entries', function (Blueprint $table) {
            $table->dropColumn('wp_post_author');
            $table->dropColumn('post_author');
        });
    }
}
