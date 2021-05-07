<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->default(0)->comment('管理员用户');
            $table->unsignedInteger('school_id')->default(0)->comment('学校');
            $table->string('api_no', 255)->default('')->comment('API账号');
            $table->string('api_key', 255)->default('')->comment('API密钥');
            $table->unsignedTinyInteger('state')->default(1)->comment('状态');
            $table->timestamps();
            // 添加索引
            $table->index('admin_id');
            $table->index('school_id');
            $table->index('api_no');
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
        Schema::dropIfExists('applications');
    }
}
