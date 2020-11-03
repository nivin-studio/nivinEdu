<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $table = 'tasks';

    /**
     * 日志关系
     *
     * @return HasMany
     */
    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'task_id', 'id');
    }

    /**
     * 获取所有开启的任务
     * @return mixed
     */
    public function findAllActive()
    {
        return $this->findAll()->filter(function ($task) {
            return $task->state;
        });
    }

    /**
     * 获取所有任务
     * @return mixed
     */
    public function findAll()
    {
        return self::all();
    }

    /**
     * 获取互斥名
     *
     * @return string
     */
    public function getMutexName()
    {
        return 'logs' . DIRECTORY_SEPARATOR . 'schedule-' . sha1($this->command . $this->expression . $this->parameters);
    }
}
