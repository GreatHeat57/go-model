<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertMigrationColumnPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table) {

            $table->integer('wp_post_id', 11)->unsigned()->after('deleted_at')->nullable()->default(0);
            $table->char('wp_post_url', 191)->after('wp_post_id')->nullable();
            $table->char('wp_comment_status', 191)->after('wp_post_url')->nullable();
            $table->char('wp_ping_status', 191)->after('wp_comment_status')->nullable();
            $table->char('wp_post_password', 191)->unsigned()->after('wp_ping_status')->nullable();
            $table->char('wp_post_name', 191)->after('wp_post_password')->nullable();
            $table->integer('wp_post_parent', 11)->unsigned()->after('wp_post_name')->nullable()->default(0);

            $table->integer('wp_cs_post_loc_zoom', 11)->unsigned()->after('wp_post_parent')->nullable()->default(0);
            $table->integer('wp_jh_email_notification', 11)->unsigned()->after('wp_cs_post_loc_zoom')->nullable()->default(0);
            $table->integer('wp_cs_job_id', 11)->unsigned()->after('wp_jh_email_notification')->nullable()->default(0);

            // $table->integer('cs_job_username', 11)->unsigned()->after('wp_jh_email_notification')->nullable()->default(0);
            $table->integer('wp_user_id', 11)->unsigned()->after('wp_post_id')->nullable()->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table) {
            $table->dropColumn('wp_post_id');
            $table->dropColumn('wp_post_url');
            $table->dropColumn('wp_comment_status');
            $table->dropColumn('wp_ping_status');
            $table->dropColumn('wp_post_password');
            $table->dropColumn('wp_post_name');
            $table->dropColumn('wp_post_parent');
            $table->dropColumn('wp_cs_post_loc_zoom');
            $table->dropColumn('wp_jh_email_notification');
            $table->dropColumn('wp_cs_job_id');
            // $table->dropColumn('cs_job_username');
            $table->dropColumn('wp_user_id');
        });
    }
}
