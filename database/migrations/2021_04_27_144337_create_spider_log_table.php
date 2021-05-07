<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpiderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spider_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('application_id')->default(0)->comment('应用ID');
            $table->unsignedInteger('school_id')->default(0)->comment('学校ID');
            $table->string('request_url', 255)->default('')->comment('请求地址');
            $table->string('request_type', 255)->default('')->comment('请求类型');
            $table->text('request_body', 255)->comment('请求参数');
            $table->longText('response_body', 255)->comment('返回结果');
            $table->unsignedTinyInteger('state')->default(1)->comment('状态');
            $table->timestamps();
            // 添加索引
            $table->index('application_id');
            $table->index('school_id');
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
        Schema::dropIfExists('spider_log');
    }
}
