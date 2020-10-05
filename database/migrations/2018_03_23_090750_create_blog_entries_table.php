<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_entries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('translation_lang',2);
            $table->integer('translation_of');
            $table->string('name');
            $table->integer('category_id')->default(0);
            $table->text('short_text')->nullable();
            $table->longText('long_text')->nullable();
            $table->string('slug');
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->dateTime('start_date');
            $table->string('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_entries');
    }
}
