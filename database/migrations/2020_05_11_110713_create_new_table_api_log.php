<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewTableApiLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   

        Schema::create('api_log', function ($table) {
            $table->increments('id');
            $table->integer('time')->nullable();
            $table->string('wpusername', 64)->nullable()->index('username');
            $table->string('action', 64)->nullable();
            $table->text('request')->nullable();
            $table->text('reaponse')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_log');
    }
}
