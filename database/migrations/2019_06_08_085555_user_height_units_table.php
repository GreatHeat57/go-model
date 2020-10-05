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
        Schema::create('user_height_units_options', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->char('us_unit', 15);
            $table->char('uk_unit', 15);
            $table->char('at_unit', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_height_units');
    }
}
