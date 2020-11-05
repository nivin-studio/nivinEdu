<?php

namespace App\Models;

use App\Events\TaskExecuted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'id',
        'command',
        'description',
        'parameters',
        'expression',
        'state',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email_address',
    ];

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
        return Cache::rememberForever('edu.tasks.active', function () {
            return $this->findAll()->filter(function ($task) {
                return $task->state;
            });
        });
    }

    /**
     * 获取所有任务
     * @return mixed
     */
    public function findAll()
    {
        return Cache::rememberForever('edu.tasks.all', function () {
            return self::all();
        });
    }

    /**
     * 执行定时任务
     *
     * @param  $id
     * @return int|Task
     */
    public function execute()
    {
        $start = microtime(true);
        try {
            Artisan::call($this->command);

            file_put_contents(storage_path($this->getMutexName()), Artisan::output());
        } catch (\Exception $e) {
            file_put_contents(storage_path($this->getMutexName()), $e->getMessage());
        }

        TaskExecuted::dispatch($this, $start);

        return $this;
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
