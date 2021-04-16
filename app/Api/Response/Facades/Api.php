<?php

namespace App\Api\Response\Facades;

use App\Api\Response\ApiResponse;
use Illuminate\Support\Facades\Facade;

class Api extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return new ApiResponse;
    }
}
