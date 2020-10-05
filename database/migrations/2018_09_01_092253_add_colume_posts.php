<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumePosts extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('posts', function ($table) {
			$table->string('code_without_md5')->after('subid')->nullable(); // for package select  purpos
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('posts', function ($table) {
			$table->dropColumn('code_without_md5');
		});
	}
}
