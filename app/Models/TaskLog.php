<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskLog extends Model
{
    protected $table = 'task_logs';

    /**
     * 任务关系
     *
     * @return BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
