<?php

use Illuminate\Database\Migrations\Migration;

class AddAdressInUserProfileTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('user_profile', function ($table) {
			$table->string('address_line1')->after('website_url')->nullable();
			$table->string('address_line2')->after('website_url')->nullable();
			$table->string('bank_account_no')->after('website_url')->nullable();
		});
	}

	// /**
	//  * Reverse the migrations.
	//  *
	//  * @return void
	//  */
	public function down() {
		Schema::table('user_profile', function ($table) {
			$table->dropColumn('address_line1');
			$table->dropColumn('address_line2');
		});
	}
}
