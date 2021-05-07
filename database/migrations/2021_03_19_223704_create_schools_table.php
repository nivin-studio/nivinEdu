<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->default(0)->comment('管理员用户');
            $table->string('name', 50)->default('')->comment('学校名称');
            $table->string('icon', 255)->default('')->comment('学校图标');
            $table->unsignedTinyInteger('type')->default(1)->comment('教务平台');
            $table->string('edu_url', 255)->default('')->comment('教务地址');
            $table->string('edu_xh', 50)->default('')->comment('测试学号');
            $table->string('edu_mm', 50)->default('')->comment('测试密码');
            $table->unsignedTinyInteger('state')->default(1)->comment('状态');
            $table->timestamps();
            // 添加索引
            $table->index('name');
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
