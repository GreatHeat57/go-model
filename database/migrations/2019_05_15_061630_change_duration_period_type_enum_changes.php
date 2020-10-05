<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class ChangeDurationPeriodTypeEnumChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ENUM Data type not supproted " It doesn't matter if you're trying to change another column, if the table contains a enum anywhere it won't work. It's a Doctrine DBAL issue. "

        //https://stackoverflow.com/questions/33140860/laravel-5-1-unknown-database-type-enum-requested
         
        DB::statement("ALTER TABLE `packages` CHANGE `duration_period` `duration_period` ENUM('days','months','years') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
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
