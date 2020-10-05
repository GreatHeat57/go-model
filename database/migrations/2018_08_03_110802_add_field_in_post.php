<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function($table) {
            $table->enum('invitation_status',['0','1','2','3'])->default('0')->comment('0 for default display for all and for accepted, 0 for requested for invitation 1 for deleted 3 for personal chat 2 for accepted extra for future use');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('messages', function($table) {
            $table->dropColumn('invitation_status');
        });
    }
}
