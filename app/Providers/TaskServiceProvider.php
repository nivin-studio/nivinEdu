<?php

namespace App\Providers;

use App\Events\TaskExecuted;
use App\Events\TaskExecuting;
use App\Models\Task;
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
                ->name($task->description)
                ->before(function () use ($task, $event) {
                    $event->start = microtime(true);
                    TaskExecuting::dispatch($task);
                })
                ->after(function () use ($event, $task) {
                    TaskExecuted::dispatch($task, $event->start);
                })
                ->sendOutputTo(storage_path($task->getMutexName()));

            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }
        });
    }
}
