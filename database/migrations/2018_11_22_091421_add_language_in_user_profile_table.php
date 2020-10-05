<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddLanguageInUserProfileTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		Schema::table('user_profile', function ($table) {
			$table->string('language')->after('address_line1')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
		Schema::table('user_profile', function ($table) {
			$table->dropColumn('language');
		});
	}
}
