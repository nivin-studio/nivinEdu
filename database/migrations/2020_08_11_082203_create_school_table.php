<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id', 10)->default(0)->comment('管理员用户');
            $table->string('name', 50)->default('')->comment('学校名称');
            $table->string('icon', 255)->default('')->comment('学校图标');
            $table->unsignedTinyInteger('type')->default(0)->comment('教务平台');
            $table->string('edu_url', 255)->default('')->comment('教务地址');
            $table->string('edu_xh', 50)->default('')->comment('测试学号');
            $table->string('edu_mm', 50)->default('')->comment('测试密码');
            $table->unsignedTinyInteger('state')->default(0)->comment('状态');
            $table->timestamps();
            $table->softDeletes();
            // 添加索引
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
    }
}
