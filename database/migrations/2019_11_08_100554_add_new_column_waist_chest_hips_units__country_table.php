<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnWaistChestHipsUnitsCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function ($table) {
            $table->enum('waist_units', array('us','at','uk'))->after('height_units')->nullable()->default(NULL);
            $table->index('waist_units');
            $table->enum('chest_units', array('us','at','uk'))->after('waist_units')->nullable()->default(NULL);
            $table->index('chest_units');
            $table->enum('hips_units', array('us','at','uk'))->after('chest_units')->nullable()->default(NULL);
            $table->index('hips_units');
        });
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
