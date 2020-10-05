<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableToStoreFeatureModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_name', 255)->nullable();
            $table->string('go_code', 191)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('model_category', 191)->nullable();
            $table->string('image_name', 255)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->string('alt_tag', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_models');
    }
}
