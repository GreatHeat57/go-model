<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->string('name');
			$table->string('logo')->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('country_code', 2)->index('country_code');
			$table->integer('city_id')->unsigned()->nullable()->default(0)->index('city_id');
			$table->string('address')->nullable();
			$table->string('phone', 60)->nullable();
			$table->string('fax', 60)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('website')->nullable();
			$table->string('facebook', 200)->nullable();
			$table->string('twitter', 200)->nullable();
			$table->string('linkedin', 200)->nullable();
			$table->string('googleplus', 200)->nullable();
			$table->string('pinterest', 200)->nullable();
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
		Schema::drop('companies');
	}

}
