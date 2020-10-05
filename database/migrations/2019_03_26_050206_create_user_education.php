<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 255)->nullable()->default(NULL);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->tinyInteger('up_to_date')->unsigned()->nullable()->default(0);
            $table->string('institute', 255)->nullable()->default(NULL);
            $table->text('description')->nullable();
            $table->integer('wp_edcuation_id');
            $table->timestamps();
            $table->index('user_id');
            $table->index('wp_edcuation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_education');
    }
}
