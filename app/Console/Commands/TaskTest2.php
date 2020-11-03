<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TaskTest2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskTest2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'taskTest2';

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
        File::append(storage_path('/logs/taskTest2.log'), 'taskTest2:ok' . PHP_EOL);
    }
}
