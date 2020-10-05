<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperienceTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('experience_types', function(Blueprint $table)
		{
			$table->boolean('id')->primary();
			$table->string('name', 100)->nullable();
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
		Schema::drop('experience_types');
	}

}
