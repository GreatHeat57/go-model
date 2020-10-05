<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModelCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_categories', function ($table) {            
            $table->tinyInteger('ordering')->after('type')->nullable()->default(NULL);
            $table->char('age_range', 6)->after('type')->nullable()->default(NULL);
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
            $table->dropColumn('ordering');
            $table->dropColumn('age_range');
        });
    }
}
