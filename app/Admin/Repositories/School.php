<?php

namespace App\Admin\Repositories;

use App\Models\School as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class School extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
