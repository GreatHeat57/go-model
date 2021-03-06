<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSavedSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('saved_search', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('country_code', 2)->nullable()->index('country_code');
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->string('keyword', 200)->nullable()->comment('To show');
			$table->string('query')->nullable();
			$table->integer('count')->unsigned()->nullable()->default(0);
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
		Schema::drop('saved_search');
	}

}
