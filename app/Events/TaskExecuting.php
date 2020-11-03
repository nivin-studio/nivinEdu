<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class TaskExecuting extends Event
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
    public function __construct(Task $task)
    {
        $this->task = $task;
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
