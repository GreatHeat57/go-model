<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHipsUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // Drop table if exist and recreate table
        Schema::dropIfExists('user_hips_units_options');

        // Create table user hips units 
        Schema::create('user_hips_units_options', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->char('us_unit', 10);
            $table->char('uk_unit', 10);
            $table->char('at_unit', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_hips_units_options');
    }
}
