<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidValueTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valid_value_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valid_value_id')->unsigned();
            $table->string('locale')->index();
            $table->string('value');
            $table->unique(['valid_value_id','locale']);
            $table->foreign('valid_value_id')->references('id')->on('valid_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valid_value_translations');
    }
}
