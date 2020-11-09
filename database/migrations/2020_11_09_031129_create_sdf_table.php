<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_num')->default('')->comment('房间号');
            $table->unsignedInteger('people_num')->default(0)->comment('人数');
            $table->string('year')->default('')->comment('年');
            $table->string('month')->default('')->comment('月');

            $table->unsignedInteger('cold_water_this_num')->default(0)->comment('水费本月电表数');
            $table->unsignedInteger('cold_water_last_num')->default(0)->comment('水费上月电表数');
            $table->unsignedInteger('cold_water_policy')->default(0)->comment('水费政策');
            $table->unsignedInteger('cold_water_meter')->default(0)->comment('水费计量');
            $table->unsignedDecimal('cold_water_cost', 8, 2)->default(0)->comment('水费金额');

            $table->unsignedInteger('hot_water_this_num')->default(0)->comment('热水费本月电表数');
            $table->unsignedInteger('hot_water_last_num')->default(0)->comment('热水费上月电表数');
            $table->unsignedInteger('hot_water_policy')->default(0)->comment('热水费政策');
            $table->unsignedInteger('hot_water_meter')->default(0)->comment('热水费计量');
            $table->unsignedDecimal('hot_water_cost', 8, 2)->default(0)->comment('热水费金额');

            $table->unsignedInteger('power_this_num')->default(0)->comment('电费本月电表数');
            $table->unsignedInteger('power_last_num')->default(0)->comment('电费上月电表数');
            $table->unsignedInteger('power_policy')->default(0)->comment('电费政策');
            $table->unsignedInteger('power_meter')->default(0)->comment('电费计量');
            $table->unsignedDecimal('power_cost', 8, 2)->default(0)->comment('电费金额');

            $table->unsignedInteger('aircn_this_num')->default(0)->comment('空调电费本月电表数');
            $table->unsignedInteger('aircn_last_num')->default(0)->comment('空调电费上月电表数');
            $table->unsignedInteger('aircn_policy')->default(0)->comment('空调电费政策');
            $table->unsignedInteger('aircn_meter')->default(0)->comment('空调电费计量');
            $table->unsignedDecimal('aircn_cost', 8, 2)->default(0)->comment('空调电费金额');

            $table->unsignedDecimal('total_cost', 8, 2)->default(0)->comment('合计');

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
        Schema::dropIfExists('sdf');
    }
}
