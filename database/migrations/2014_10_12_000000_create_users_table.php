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
            $table->unsignedInteger('school_id')->default(0)->comment('学校');
            $table->string('student_no', 20)->default('')->comment('学号');
            $table->string('student_password', 50)->default('')->comment('密码');
            $table->string('student_name', 10)->default('')->comment('姓名');
            $table->string('identity_no', 20)->default('')->comment('身份证');
            $table->string('birth_date')->default('1979-01-01')->comment('出生日期');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别 0:未知,1:男生,2:女生');
            $table->string('nation', 30)->default('')->comment('民族');
            $table->string('education', 10)->default('')->comment('学历');
            $table->string('college', 60)->default('')->comment('学院');
            $table->string('major', 60)->default('')->comment('专业');
            $table->string('class', 60)->default('')->comment('班级');
            $table->string('period', 10)->default('')->comment('学制');
            $table->string('grade', 10)->default('')->comment('年级');
            $table->unsignedTinyInteger('state')->default(1)->comment('状态');
            $table->rememberToken();
            $table->timestamps();
            // 添加索引
            $table->index('school_id');
            $table->index('student_no');
            $table->index('student_name');
            $table->index('identity_no');
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
