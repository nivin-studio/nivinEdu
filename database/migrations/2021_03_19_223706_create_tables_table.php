<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('school_id')->default(0)->comment('学校');
            $table->string('student_no', 20)->default('')->comment('学号');
            $table->string('period', 20)->default('')->comment('时段 上午-下午-晚上');
            $table->string('week', 20)->default('')->comment('星期');
            $table->string('section', 20)->default('')->comment('节次');
            $table->string('time', 20)->default('')->comment('时间');
            $table->string('course_name', 50)->default('')->comment('课名');
            $table->string('course_type', 20)->default('')->comment('课型');
            $table->string('week_period', 20)->default('')->comment('周段');
            $table->string('teacher', 20)->default('')->comment('老师');
            $table->string('location', 50)->default('')->comment('地点');
            $table->unsignedTinyInteger('state')->default(1)->comment('状态');
            $table->timestamps();
            // 添加索引
            $table->index('school_id');
            $table->index('student_no');
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
        Schema::dropIfExists('tables');
    }
}
