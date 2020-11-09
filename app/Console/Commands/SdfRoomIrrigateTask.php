<?php

namespace App\Console\Commands;

use App\Common\RedisKey;
use App\Models\Sdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SdfRoomIrrigateTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SdfRoomIrrigateTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '水电费房间号灌溉定时任务';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roomList = Sdf::where('state', 0)->groupBy('room_num')->get(['room_num']);
        foreach ($roomList as $room) {
            Redis::lpush(RedisKey::EDU_ROOM_LIST, $room['room_num']);
        }
    }
}
