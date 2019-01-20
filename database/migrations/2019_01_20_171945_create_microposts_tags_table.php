<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicropostsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microposts_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('micropost_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();
            $table->timestamps();

            //外部キー設定
            $table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            //重複登録の禁止
            $table->unique(['micropost_id', 'tag_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microposts_tags');
    }
}
