<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            
            $table->integer('wp_cs_count_views_new')->after('wp_user_id')->nullable()->default(0);

            $table->string('wp_cs_job_detail_url', 255)->after('wp_cs_count_views_new')->nullable()->default(NULL);

            $table->string('wp_cs_company_name', 255)->after('wp_cs_job_detail_url')->nullable()->default(NULL);

            $table->string('wp_cs_org_name', 255)->after('wp_cs_company_name')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('wp_cs_count_views_new');
            $table->dropColumn('wp_cs_job_detail_url');
            $table->dropColumn('wp_cs_company_name');
            $table->dropColumn('wp_cs_org_name');
        });
    }
}
