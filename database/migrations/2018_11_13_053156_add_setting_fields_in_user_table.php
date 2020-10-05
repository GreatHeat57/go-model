<?php

use Illuminate\Database\Migrations\Migration;

class AddSettingFieldsInUserTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		Schema::table('users', function ($table) {
			$table->string('system_settings')->after('closed')->nullable(); // for system settings
			$table->string('work_settings')->after('closed')->nullable(); // for work settings
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
		Schema::table('users', function ($table) {
			$table->dropColumn('system_settings');
			$table->dropColumn('work_settings');
		});
	}
}
