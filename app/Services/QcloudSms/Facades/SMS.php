<?php

namespace App\Services\QcloudSms\Facades;

use App\Services\QcloudSms\SmsService;
use Illuminate\Support\Facades\Facade;

class SMS extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return new SmsService;
    }
}
