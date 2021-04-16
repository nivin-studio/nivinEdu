<?php

Route::prefix('edu')->group(function () {
    // 获取token
    Route::post('/auth/token', 'EduAuthController@token');
    // 需要token验证的路由
    Route::middleware(['api.jwt:bind_school'])->group(function () {
        Route::get('/captcha', 'EduController@captcha');
        Route::get('/login', 'EduController@login');
        Route::get('/persos', 'EduController@persos');
        Route::get('/scores', 'EduController@scores');
        Route::get('/tables', 'EduController@tables');
    });
});
