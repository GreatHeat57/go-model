<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('country_code', 2)->nullable()->index('country_code');
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->integer('company_id')->unsigned()->nullable()->default(0)->index('company_id');
			$table->integer('category_id')->unsigned()->default(0)->index('category_id');
			$table->integer('post_type_id')->unsigned()->nullable()->index('post_type_id');
			$table->string('company_name', 200)->nullable();
			$table->text('company_description', 65535)->nullable();
			$table->string('logo', 191)->nullable();
			$table->boolean('ismodel')->nullable()->default(1);
			$table->string('title', 191)->default('')->index('title');
			$table->text('description', 65535);
			$table->string('tags', 191)->nullable()->index('tags');
			$table->decimal('salary_min', 10)->unsigned()->nullable();
			$table->decimal('salary_max', 10)->unsigned()->nullable();
			$table->integer('salary_type_id')->unsigned()->nullable()->default(1);
			$table->boolean('negotiable')->nullable()->default(0);
			$table->string('start_date', 100)->nullable();
			$table->string('end_date', 100)->nullable();
			$table->integer('model_category_id')->default(0);
			$table->integer('partner_category_id')->default(0);
			$table->integer('experience_type_id')->default(0);
			$table->integer('gender_type_id')->default(0);
			$table->boolean('tfp')->default(0);
			$table->integer('height_from')->unsigned()->default(0);
			$table->integer('height_to')->unsigned()->default(0);
			$table->integer('weight_from')->unsigned()->default(0);
			$table->integer('weight_to')->unsigned()->default(0);
			$table->integer('age_from')->unsigned()->default(0);
			$table->integer('age_to')->unsigned()->default(0);
			$table->integer('dressSize_from')->unsigned()->default(0);
			$table->integer('dressSize_to')->unsigned()->default(0);
			$table->integer('chest_from')->unsigned()->default(0);
			$table->integer('chest_to')->unsigned()->default(0);
			$table->integer('waist_from')->unsigned()->default(0);
			$table->integer('waist_to')->unsigned()->default(0);
			$table->integer('hips_from')->unsigned()->default(0);
			$table->integer('hips_to')->unsigned()->default(0);
			$table->integer('shoeSize_from')->unsigned()->default(0);
			$table->integer('shoeSize_to')->unsigned()->default(0);
			$table->string('eyeColor', 50)->nullable();
			$table->string('hairColor', 50)->nullable();
			$table->string('skinColor', 50)->nullable();
			$table->string('application_url', 191)->nullable();
			$table->string('end_application', 100)->nullable();
			$table->string('contact_name', 200)->default('')->index('contact_name');
			$table->string('email', 100)->nullable();
			$table->string('phone', 50)->nullable();
			$table->boolean('phone_hidden')->nullable()->default(0);
			$table->string('address', 191)->nullable()->index('address');
			$table->integer('city_id')->unsigned()->default(0)->index('city_id');
			$table->float('lon', 10, 0)->nullable()->comment('longitude in decimal degrees (wgs84)');
			$table->float('lat', 10, 0)->nullable()->comment('latitude in decimal degrees (wgs84)');
			$table->string('ip_addr', 50)->nullable();
			$table->integer('visits')->unsigned()->nullable()->default(0);
			$table->string('email_token', 32)->nullable();
			$table->string('phone_token', 32)->nullable();
			$table->string('tmp_token', 32)->nullable();
			$table->string('code_token', 32)->nullable();
			$table->boolean('verified_email')->nullable()->default(0)->index('active');
			$table->boolean('verified_phone')->nullable()->default(1);
			$table->boolean('ismade')->nullable()->default(0);
			$table->boolean('reviewed')->nullable()->default(0)->index('reviewed');
			$table->boolean('featured')->nullable()->default(0)->index('featured');
			$table->boolean('archived')->nullable()->default(0);
			$table->string('partner', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['lon','lat'], 'lat');
			$table->index(['salary_min','salary_max'], 'salary');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
