<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetaTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meta_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('translation_lang', 10)->index('translation_lang');
			$table->integer('translation_of')->unsigned()->index('translation_of');
			$table->string('page', 50)->nullable();
			$table->string('title', 200)->nullable()->default('');
			$table->string('description')->nullable()->default('');
			$table->string('keywords')->nullable()->default('');
			$table->boolean('active')->default(1)->index('active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meta_tags');
	}

}
