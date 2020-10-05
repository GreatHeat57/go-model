<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewColumnFaqTextInModelCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_categories', function (Blueprint $table) {
           $table->longText('faq_text')->after('footer_text')->nullable()->default(NULL);
           $table->longText('faq_script')->after('faq_text')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('model_categories', function (Blueprint $table) {
            $table->dropColumn('faq_text');
            $table->dropColumn('faq_script');
        });
    }
}
