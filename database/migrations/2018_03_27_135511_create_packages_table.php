<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('translation_lang', 10)->nullable();
			$table->integer('translation_of')->unsigned()->nullable();
			$table->string('name', 100)->nullable()->comment('In country language');
			$table->string('short_name', 100)->nullable()->comment('In country language');
			$table->integer('user_type_id')->unsigned()->nullable()->index('user_type_id');
			$table->string('country_code', 100)->nullable();
			$table->enum('ribbon', array('red','orange','green'))->nullable();
			$table->boolean('has_badge')->nullable()->default(0);
			$table->decimal('price', 10)->unsigned()->nullable();
			$table->string('currency_code', 3)->nullable();
			$table->decimal('tax', 10)->unsigned()->nullable();
			$table->integer('duration')->unsigned()->nullable()->default(30)->comment('In days');
			$table->string('description')->nullable()->comment('In country language');
			$table->text('features', 65535)->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->boolean('active')->nullable()->default(0)->index('active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('packages');
	}

}
