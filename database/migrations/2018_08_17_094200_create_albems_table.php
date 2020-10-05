<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 2)->default('')->index('country_code');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('name', 200)->nullable();
            $table->string('filename', 191)->nullable();
            $table->string('cropped_image', 191)->nullable();
            $table->boolean('active')->nullable()->default(0)->index('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albems');
    }
}
