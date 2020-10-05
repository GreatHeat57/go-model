<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class CreateNewEnumValueDirectMessageInMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE messages MODIFY COLUMN message_type ENUM('Invitation', 'Job application', 'Conversation', 'Direct Message') NOT NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE messages MODIFY message_type ENUM('Invitation', 'Job application', 'Conversation') NOT NULL");
    }
}
