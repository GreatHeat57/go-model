<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatlongInuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // for latitude and longitude
        Schema::table('users', function ($table) {
            $table->string('latitude',50)->after('hash_code')->nullable();
            $table->string('longitude',50)->after('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('users', function ($table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}