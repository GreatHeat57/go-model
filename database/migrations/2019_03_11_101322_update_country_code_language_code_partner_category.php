<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCountryCodeLanguageCodePartnerCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function ($table) {            
           
            $table->integer('wp_category_id', 11)->unsigned()->after('translation_of')->nullable()->default(NULL);

            $table->integer('wp_translation_of', 11)->unsigned()->after('wp_category_id')->nullable()->default(NULL);

            $table->integer('wp_parent_id', 11)->unsigned()->after('wp_translation_of')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function ($table) {
            $table->dropColumn('wp_category_id');
            $table->dropColumn('wp_translation_of');
            $table->dropColumn('wp_parent_id');
        });
    }
}
