<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFeaturedFieldInUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//

		Schema::table('users', function ($table) {
			$table->boolean('featured')->nullable()->default(0);
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
			$table->dropColumn('featured');
		});
	}
}
