<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDressSizeUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dress_size_options', function (Blueprint $table) {
            $table->increments('id');
            $table->char('standard_unit', 10);
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
        Schema::dropIfExists('user_dress_size_options');
    }
}
