<?php

namespace App\Admin\Repositories;

use App\Models\TaskLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class TaskLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
