<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnModelCategoryForPageSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_categories', function ($table) {
            $table->string('page_slug', 255)->after('description')->nullable()->default(NULL);
            $table->index('page_slug');
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
            $table->dropColumn('page_slug');
        });
    }
}
