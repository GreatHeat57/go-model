<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class ChangeDatatypeAgeInPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        DB::statement("ALTER TABLE `posts` CHANGE `age_from` `age_from` FLOAT(10) UNSIGNED NOT NULL DEFAULT '0';");

        DB::statement("ALTER TABLE `posts` CHANGE `age_to` `age_to` FLOAT(10) UNSIGNED NOT NULL DEFAULT '0';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
