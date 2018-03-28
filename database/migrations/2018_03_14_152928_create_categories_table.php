<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类类别名称');
//            $table->integer('parentId')->default(0)->comment('父母分类Id');
            $table->string('iconImage')->nullable()->comment('图标');
            $table->integer('priority')->default(0)->comment('	优先级，越大，同级显示的时候越靠前');
            $table->tinyInteger('status')->default(0)->comment('状态：0禁用，1启用');
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
        Schema::dropIfExists('categories');
    }
}
