<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = '水电费定时任务抓取';

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

    }
}
