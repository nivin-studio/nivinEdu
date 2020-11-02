<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('command')->default('')->comment('命令');
            $table->string('description')->default('')->comment('描述');
            $table->string('parameters')->nullable()->comment('参数');
            $table->string('expression')->nullable()->comment('时间表达式');
            $table->unsignedTinyInteger('state')->default(0)->comment('状态');
            $table->unsignedTinyInteger('dont_overlap')->default(0)->comment('避免重复执行');
            $table->unsignedTinyInteger('run_in_maintenance')->default(0)->comment('维护也需执行');
            $table->string('notification_email_address')->nullable()->comment('通知邮件地址');
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
        Schema::dropIfExists('tasks');
    }
}
