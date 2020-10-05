<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 255)->nullable()->default(NULL);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->tinyInteger('up_to_date')->nullable()->default(0);
            $table->string('company', 255)->nullable()->default(NULL);
            $table->text('description')->nullable();
            $table->integer('wp_experiance_id')->nullable()->default(0);
            $table->timestamps();
            $table->index('user_id');
            $table->index('wp_experiance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_experiences');
    }
}
