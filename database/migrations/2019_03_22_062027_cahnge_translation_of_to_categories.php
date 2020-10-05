<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CahngeTranslationOfToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function ($table) { 
            $table->integer('translation_of', 11)->unsigned()->nullable()->default('0')->change();
            $table->integer('wp_translation_of', 11)->nullable()->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function ($table) {
            $table->dropColumn('translation_of');
            $table->dropColumn('wp_translation_of');
        });
    }
}
