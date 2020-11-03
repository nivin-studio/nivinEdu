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

        $tasks->each(function ($task) use ($schedule) {
            $event = $schedule->command($task->command);

            $event->cron($task->expression)
                ->name($task->description);

            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }
        });
    }
}
