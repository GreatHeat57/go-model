<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWorkSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_work_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', 11)->index();
            $table->integer('hourly_rate', 11)->nullable()->default('0');
            $table->integer('job_distance', 11)->nullable()->default(null);
            $table->string('job_time', 500)->collate('utf8_unicode_ci')->nullable()->default(null);
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
        Schema::dropIfExists('user_work_settings');
    }
}
