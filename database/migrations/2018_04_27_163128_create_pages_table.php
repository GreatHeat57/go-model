<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('translation_lang', 10)->nullable()->index('translation_lang');
			$table->integer('translation_of')->unsigned()->nullable()->index('translation_of');
			$table->integer('parent_id')->unsigned()->nullable()->index('parent_id');
			$table->enum('type', array('standard','terms','termsclient','privacy','tips'));
			$table->string('name', 100)->nullable();
			$table->string('slug', 100)->nullable();
			$table->string('title', 200)->nullable();
			$table->string('picture', 191)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('external_link', 191)->nullable();
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->string('name_color', 10)->nullable();
			$table->string('title_color', 10)->nullable();
			$table->boolean('target_blank')->nullable()->default(0);
			$table->boolean('excluded_from_footer')->nullable()->default(0);
			$table->boolean('active')->nullable()->default(1)->index('active');
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
		Schema::drop('pages');
	}

}
