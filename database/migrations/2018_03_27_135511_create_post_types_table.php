<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('translation_lang', 10)->nullable()->index('translation_lang');
			$table->integer('translation_of')->unsigned()->nullable()->index('translation_of');
			$table->string('name', 100)->default('');
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->boolean('active')->nullable()->default(1)->index('active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_types');
	}

}
