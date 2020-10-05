<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentMethodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_methods', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100)->nullable();
			$table->string('display_name', 100)->nullable();
			$table->text('description', 65535)->nullable();
			$table->boolean('has_ccbox')->nullable()->default(0)->index('has_ccbox');
			$table->text('countries', 65535)->nullable()->comment('Countries codes separated by comma.');
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->integer('parent_id')->unsigned()->nullable()->default(0);
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
		Schema::drop('payment_methods');
	}

}
