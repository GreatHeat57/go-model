<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobDistanceTypeTableUserWorkSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_work_settings', function (Blueprint $table) {
            $table->enum('job_distance_type',['km_radius','whole_country','international'])->after('hourly_rate');
            $table->index('job_distance_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_work_settings', function (Blueprint $table) {
            $table->dropColumn('job_distance_type');
        });
    }
}
