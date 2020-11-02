<?php

namespace App\Providers;

use App\Admin\Repositories\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->resolving(Schedule::class, function ($schedule) {
            $this->schedule($schedule);
        });
    }

    /**
     * 注册定时任务
     * @param  Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        $taskModel = new Task();

        $tasks = $taskModel->findAllActive();

    }
}
