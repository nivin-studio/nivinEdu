<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id')->default(0)->comment('学校');
            $table->string('student_no', 20)->default('')->comment('学号');
            $table->string('annual', 30)->default('')->comment('学年');
            $table->string('term', 10)->default('')->comment('学期');
            $table->string('course_no', 30)->default('')->comment('课号');
            $table->string('course_name', 60)->default('')->comment('课名');
            $table->string('course_type', 60)->default('')->comment('课型');
            $table->string('score', 10)->default('')->comment('成绩');
            $table->string('credit', 10)->default('')->comment('学分');
            $table->string('gpa', 10)->default('')->comment('绩点');
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
        Schema::dropIfExists('scores');
    }
}
