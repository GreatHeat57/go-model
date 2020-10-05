<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserHeightUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // Drop user chest table if exists
        Schema::dropIfExists('user_chest_units_options');

        // Create user chest option table
        Schema::create('user_chest_units_options', function (Blueprint $table) {
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
        Schema::dropIfExists('user_chest_units_options');
    }
}
