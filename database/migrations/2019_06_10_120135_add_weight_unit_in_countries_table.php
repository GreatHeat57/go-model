<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeightUnitInCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function ($table) {
            $table->enum('weight_units', array('us','at','uk'))->after('background_image')->nullable()->default(NULL);
            $table->index('weight_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('weight_units');
        });
    }
}
