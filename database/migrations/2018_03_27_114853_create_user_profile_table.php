<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('go_code')->unique()->nullable();
            $table->string('contract_link')->nullable();
            $table->string('package')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('fname_parent')->nullable();
            $table->string('lname_parent')->nullable();
            $table->date('birth_day')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->longText('about_me')->nullable();
            $table->string('company_name')->nullable();
            $table->string('category_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('piercing')->default(false);
            $table->boolean('tattoo')->default(false);
            $table->boolean('tfp')->default(false);
            $table->boolean('allow_search')->default(false);
            $table->text('description')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('talent')->nullable();
            $table->text('reference')->nullable();
            $table->char('status', 10)->default('INACTIVE');
            $table->integer('height_id')->unsigned()->default(0);
            $table->integer('weight_id')->unsigned()->default(0);
            $table->integer('chest_id')->unsigned()->default(0);
            $table->integer('waist_id')->unsigned()->default(0);
            $table->integer('hips_id')->unsigned()->default(0);
            $table->integer('clothing_size_id')->unsigned()->default(0);
            $table->integer('eye_color_id')->unsigned()->default(0);
            $table->integer('hair_color_id')->unsigned()->default(0);
            $table->integer('size_id')->unsigned()->default(0);
            $table->integer('shoes_size_id')->unsigned()->default(0);
            $table->integer('skin_color_id')->unsigned()->default(0);
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('website_url')->nullable();
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
        Schema::dropIfExists('user_profile');
    }
}
