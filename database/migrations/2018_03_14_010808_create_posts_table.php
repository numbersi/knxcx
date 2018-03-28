<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cate_id');
            $table->string('title')->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('status')->default(1)->comment('文章状态 0 未知／1 通过／ -1 删除');;  //
            $table->Integer('gold')->default(0);
            $table->string('links')->default(0);
            $table->integer('user_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
