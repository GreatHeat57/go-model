<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedNewColumnFacebookInstagramTwitterInCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function ($table) {
            $table->string('facebook_link', 255)->after('terms_conditions_client')->nullable()->default(NULL);
            $table->string('instagram_link', 255)->after('facebook_link')->nullable()->default(NULL);
            $table->string('twitter_link', 255)->after('instagram_link')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
