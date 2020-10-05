<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumeToPost extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('posts', function ($table) {
			$table->string('username')->after('partner')->nullable(); // for package select  purpos
			$table->string('package')->nullable(); // for package select  purpos
			$table->string('subid')->nullable(); // for package select  purpos
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('posts', function ($table) {
			$table->dropColumn('username');
			$table->dropColumn('package');
			$table->dropColumn('subid');
		});
	}
}
