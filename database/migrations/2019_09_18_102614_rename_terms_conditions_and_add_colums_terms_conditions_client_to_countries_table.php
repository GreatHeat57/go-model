<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class RenameTermsConditionsAndAddColumsTermsConditionsClientToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `countries` CHANGE `terms_conditions` `terms_conditions_model` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");

        Schema::table('countries', function (Blueprint $table) {
            $table->longText('terms_conditions_client')->after('terms_conditions_model')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->longText('terms_conditions_client')->after('terms_conditions_model')->nullable()->default(NULL);
        });
    }
}
