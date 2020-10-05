<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class 20190318102746AlterMigrationColumnPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function ($table) {            
            $table->integer('wp_package_id', 11)->unsigned()->after('parent_id')->nullable()->default(0);
            $table->char('wp_package_country', 4)->after('country_code')->nullable()->default(NULL);
            $table->decimal('price_dummy', 10,2)->unsigned()->after('price')->nullable()->default(NULL);
            $table->char('duration_period', 191)->after('duration')->nullable()->default(NULL);
            $table->char('package_uid', 191)->after('features')->nullable()->default(NULL);
            $table->char('package_type', 191)->after('package_uid')->nullable()->default(NULL);
            $table->integer('package_listings', 11)->unsigned()->after('package_type')->nullable()->default(NULL);
            $table->char('package_cvs', 191)->after('package_listings')->nullable()->default(NULL);
            $table->integer('package_submission_limit', 11)->unsigned()->after('package_cvs')->nullable()->default(NULL);
            $table->char('cs_list_dur', 191)->after('package_submission_limit')->nullable()->default(NULL);
            $table->char('package_feature', 191)->after('cs_list_dur')->nullable()->default(NULL);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('packages', function ($table) {
            $table->dropColumn('wp_package_id');
            $table->dropColumn('wp_package_country');
            $table->dropColumn('price_dummy');
            $table->dropColumn('duration_period');
            $table->dropColumn('package_uid');
            $table->dropColumn('package_type');
            $table->dropColumn('package_listings');
            $table->dropColumn('package_cvs');
            $table->dropColumn('package_submission_limit');
            $table->dropColumn('cs_list_dur');
            $table->dropColumn('package_feature');
        });
    }
}
