<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CahngeTranslationOfToBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function ($table) { 
            $table->integer('wp_translation_of', 11)->nullable()->default('0')->change();
            $table->integer('translation_of', 11)->unsigned()->nullable()->default('0')->change();
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
            $table->dropColumn('wp_translation_of');
            $table->dropColumn('translation_of');
        });
    }
}
