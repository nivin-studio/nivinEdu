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
}
