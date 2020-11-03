<?php

namespace App\Admin\Repositories;

use App\Models\Task as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Task extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

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
        return $this->model->all();
    }
}
