<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('translation_lang', 10)->nullable()->index('translation_lang');
			$table->integer('translation_of')->unsigned()->nullable()->index('translation_of');
			$table->integer('parent_id')->unsigned()->nullable()->default(0)->index('parent_id');
			$table->string('name', 150)->default('');
			$table->string('slug', 150)->nullable()->index('slug');
			$table->string('description', 191)->nullable();
			$table->string('picture', 100)->nullable();
			$table->string('css_class', 100)->nullable();
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->enum('type', array('classified','job-offer','job-search','service'))->nullable()->default('classified')->comment('Only select this for parent branches');
			$table->boolean('active')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('branches');
	}

}
