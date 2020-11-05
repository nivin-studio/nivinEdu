<?php

namespace App\Events;

use App\Models\Task;
use App\Notifications\TaskCompleted;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskExecuted implements ShouldBroadcast
{
    use SerializesModels, Dispatchable, InteractsWithSockets;

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
        $duration = microtime(true) - $started;

        if (file_exists(storage_path($task->getMutexName()))) {
            $output = file_get_contents(storage_path($task->getMutexName()));

            $task->logs()->create([
                'duration' => round($duration * 1000, 2),
                'content'  => !empty($output) ? $output : 'ok',
            ]);

            unlink(storage_path($task->getMutexName()));

            $task->notify(new TaskCompleted($output));
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
