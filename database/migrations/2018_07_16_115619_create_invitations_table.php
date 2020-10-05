<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partner_id');
            $table->foreign('partner_id')->references('id')->on('users');
            $table->integer('model_id');
            $table->foreign('model_id')->references('id')->on('users');
            $table->integer('job_id');
            $table->foreign('job_id')->references('id')->on('posts');
            $table->text('message')->nullable();
            $table->enum('status',array('0','1','2','3'))->default('0')->comment('0 for unread, 1 for read, 2 for approved, 3 for rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
