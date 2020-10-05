<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 3)->default('')->unique('code');
			$table->string('name', 50)->nullable();
			$table->string('html_entity', 30)->nullable()->comment('From Github : An array of currency symbols as HTML entities');
			$table->string('font_arial', 5)->nullable();
			$table->string('font_code2000', 5)->nullable();
			$table->string('unicode_decimal', 5)->nullable();
			$table->string('unicode_hex', 5)->nullable();
			$table->boolean('in_left')->nullable()->default(0);
			$table->integer('decimal_places')->unsigned()->nullable()->default(2)->comment('Currency Decimal Places - ISO 4217');
			$table->string('decimal_separator', 10)->nullable()->default('.');
			$table->string('thousand_separator', 10)->nullable()->default(',');
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
		Schema::drop('currencies');
	}

}
