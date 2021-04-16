<?php

return [
    'tencent' => [
        'endpoint'   => env('QCLOUD_SMS_ENDPOINT', ''),
        'secret_id'  => env('QCLOUD_SMS_SECRET_ID', ''),
        'secret_key' => env('QCLOUD_SMS_SECRET_KEY', ''),
        'sdk_app_id' => env('QCLOUD_SMS_SDK_APP_ID', ''),
        'sign_name'  => env('QCLOUD_SMS_SIGN_NAME', ''),
    ],
];
