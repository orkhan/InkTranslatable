<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('posts', function($t){
            $t->increments('id')->unsigned();
            $t->timestamps();
        });
        Schema::create('posts_translations', function($t){
            $t->integer('post_id')->unsigned();
            $t->string('title');
            $t->string('lang');

            $t->index('post_id');
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
        Schema::drop('posts_translations');
	}

}