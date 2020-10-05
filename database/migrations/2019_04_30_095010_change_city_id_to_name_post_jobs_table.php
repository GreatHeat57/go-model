<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCityIdToNamePostJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function ($table) { 
            $table->renameColumn('city_id', 'city');
        });

        Schema::table('posts', function ($table) { 
            $table->string('city', 255)->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function ($table) {
            // $table->dropColumn('city_id');
            $table->renameColumn('city', 'city_id');
        });
    }
}
