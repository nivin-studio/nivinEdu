<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id')->default(0)->comment('学校');
            $table->string('xh', 20)->default('')->comment('学号');
            $table->string('xn', 30)->default('')->comment('学年');
            $table->unsignedTinyInteger('xq')->default(0)->comment('学期');
            $table->string('kh', 30)->default('')->comment('课号');
            $table->string('km', 60)->default('')->comment('课名');
            $table->string('kx', 60)->default('')->comment('课型');
            $table->string('cj', 10)->default('')->comment('成绩');
            $table->string('xf', 10)->default('')->comment('学分');
            $table->string('jd', 10)->default('')->comment('绩点');
            $table->timestamps();
            $table->softDeletes();
            // 添加索引
            $table->index('school_id');
            $table->index('xh');
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
        Schema::dropIfExists('grades');
    }
}
