<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetaAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meta_attributes', function(Blueprint $table)
		{
			$table->increments('meta_id');
			$table->string('meta_key', 191)->index();
			$table->text('meta_value');
			$table->string('meta_type', 191)->default('string');
			$table->string('meta_group', 191)->nullable();
			$table->integer('metable_id')->unsigned();
			$table->string('metable_type', 191);
			$table->index(['metable_id','metable_type']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meta_attributes');
	}

}
