<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShoeUnitsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shoe_units_options', function (Blueprint $table) {
            $table->increments('id');
            $table->char('us_baby', 10)->nullable()->default(NULL);
            $table->char('uk_baby', 10)->nullable()->default(NULL);
            $table->char('at_baby', 10)->nullable()->default(NULL);
            $table->char('us_kid', 10)->nullable()->default(NULL);
            $table->char('uk_kid', 10)->nullable()->default(NULL);
            $table->char('at_kid', 10)->nullable()->default(NULL);
            $table->char('us_men', 10)->nullable()->default(NULL);
            $table->char('uk_men', 10)->nullable()->default(NULL);
            $table->char('at_men', 10)->nullable()->default(NULL);
            $table->char('us_women', 10)->nullable()->default(NULL);
            $table->char('uk_women', 10)->nullable()->default(NULL);
            $table->char('at_women', 10)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_shoe_units_options');
    }
}
