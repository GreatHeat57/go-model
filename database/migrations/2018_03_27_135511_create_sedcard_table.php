<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSedcardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sedcard', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('country_code', 2)->default('')->index('country_code');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->string('name', 200)->nullable();
			$table->string('filename')->nullable();
			$table->string('cropped_image')->nullable();
			$table->boolean('active')->nullable()->default(0)->index('active');
			$table->integer('image_type');
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
		Schema::drop('sedcard');
	}

}
