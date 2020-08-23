<?php

namespace App\Admin\Repositories;

use App\Models\Grade as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Grade extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
