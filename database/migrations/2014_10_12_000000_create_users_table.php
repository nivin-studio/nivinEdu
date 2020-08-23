<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id', 10)->default(0)->comment('学校');
            $table->string('xh', 20)->default('')->comment('学号');
            $table->string('mm', 50)->default('')->comment('密码');
            $table->string('xm', 10)->default('')->comment('姓名');
            $table->string('sf', 20)->default('')->comment('身份证');
            $table->unsignedTinyInteger('xb')->default(0)->comment('性别 0:未知,1:男生,2:女生');
            $table->date('sr')->default('1979-01-01')->comment('出生日期');
            $table->string('mz', 30)->default('')->comment('民族');
            $table->string('xl', 10)->default('')->comment('学历');
            $table->string('xy', 60)->default('')->comment('学院');
            $table->string('zy', 60)->default('')->comment('专业');
            $table->string('bj', 60)->default('')->comment('班级');
            $table->string('xz', 10)->default('')->comment('学制');
            $table->string('nj', 10)->default('')->comment('年级');
            $table->rememberToken();
            $table->timestamps();
            // 添加索引
            $table->index('xh');
            $table->index('xm');
            $table->index('sf');
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
        Schema::dropIfExists('users');
    }
}
