<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class TaskExecuted extends Event
{
    use Dispatchable, SerializesModels, Dispatchable, InteractsWithSockets;

    /**
     * @var Task
     */
    public $task;

    /**
     * Constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task, $started)
    {
        $time_elapsed_secs = microtime(true) - $started;

        if (file_exists(storage_path($task->getMutexName()))) {
            $output = file_get_contents(storage_path($task->getMutexName()));

            $task->results()->create([
                'duration' => $time_elapsed_secs * 1000,
                'result'   => $output,
            ]);

            unlink(storage_path($task->getMutexName()));
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.events');
    }

    /**
     * Toggles event broadcasting on/off based on config value.
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return true;
    }
}
