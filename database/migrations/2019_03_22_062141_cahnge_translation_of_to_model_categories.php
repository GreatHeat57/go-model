<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CahngeTranslationOfToModelCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_categories', function ($table) { 
            $table->integer('wp_translation_of', 11)->nullable()->default('0')->change();
            $table->integer('translation_of', 11)->nullable()->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_categories', function ($table) {
            $table->dropColumn('wp_translation_of');
            $table->dropColumn('translation_of');
        });
    }
}
