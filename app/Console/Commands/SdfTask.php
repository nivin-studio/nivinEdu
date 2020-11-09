<?php

namespace App\Console\Commands;

use App\Common\RedisKey;
use App\Models\Sdf;
use App\Sdf\Hlu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SdfTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdfTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '水电费抓取定时任务';

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
        $llen = Redis::llen(RedisKey::EDU_ROOM_LIST);
        if (!$llen) {
            return;
        }

        $hlu = new Hlu();

        for ($i = 0; $i < $llen && $i < 5; $i++) {
            $room  = Redis::lpop(RedisKey::EDU_ROOM_LIST);
            $infos = $hlu->getSdfInfo($room);
            foreach ($infos as $info) {
                $date = $info['date'];
                $date = explode('~', $date);
                unset($info['date']);

                $info['year']  = $date[0];
                $info['month'] = $date[1];

                Sdf::create($info);
            }
        }
    }
}
