<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_address', function (Blueprint $table) {
			$table->increments('id');
			$table->string('first_name')->nullable();
			$table->string('email', 100)->nullable();
			$table->string('phone', 60)->nullable();
			$table->string('address_line1', 255)->nullable();
			$table->string('address_line2', 255)->nullable();
			$table->string('post_code', 255)->nullable();
			$table->string('city', 255)->nullable();
			$table->string('country', 255)->nullable();
			$table->tinyInteger('address_type')->nullable()->comment('1 for personal,2 for company');
			$table->integer('user_id')->unsigned()->nullable()->default(0);
			$table->timestamps();
		});
	}

	// /**
	//  * Reverse the migrations.
	//  *
	//  * @return void
	//  */
	public function down() {
		Schema::dropIfExists('user_address');
	}
}
