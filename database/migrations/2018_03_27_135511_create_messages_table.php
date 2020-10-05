<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id')->unsigned()->nullable()->default(0)->index('post_id');
			$table->integer('parent_id')->unsigned()->nullable()->default(0)->index('parent_id');
			$table->integer('from_user_id')->unsigned()->nullable()->default(0)->index('from_user_id');
			$table->string('from_name', 200)->nullable();
			$table->string('from_email', 200)->nullable();
			$table->string('from_phone', 100)->nullable();
			$table->integer('to_user_id')->unsigned()->nullable()->default(0)->index('to_user_id');
			$table->string('to_name', 200)->nullable();
			$table->string('to_email', 100)->nullable();
			$table->string('to_phone', 50)->nullable();
			$table->text('subject', 65535)->nullable();
			$table->text('message', 65535)->nullable();
			$table->string('filename', 200)->nullable();
			$table->boolean('is_read')->nullable()->default(0);
			$table->integer('deleted_by')->unsigned()->nullable()->index('deleted_by');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}
