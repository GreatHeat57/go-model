<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id')->unsigned()->nullable()->index('post_id');
			$table->integer('package_id')->unsigned()->nullable()->index('package_id');
			$table->integer('payment_method_id')->unsigned()->nullable()->default(0)->index('payment_method_id');
			$table->string('transaction_id')->nullable()->index('transaction_id')->comment('Transaction\'s ID at the Provider');
			$table->boolean('active')->default(1)->index('active');
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
		Schema::drop('payments');
	}

}
