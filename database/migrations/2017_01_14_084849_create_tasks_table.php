<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');  //建表的用户
            $table->string('team');     //类型：资产、密码
            $table->string('place');    //地点
            $table->string('item');     //项目名称
            $table->string('name');     //用户名，加密
            $table->string ('password');//密码，加密
            $table->string('others');   //备注
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
        Schema::drop('tasks');
    }
}
