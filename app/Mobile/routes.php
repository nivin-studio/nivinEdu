<?php

Route::get('/', 'IndexController@index')->name('mobile.index');
Route::get('/school', 'IndexController@school')->name('mobile.school');
Route::post('/login', 'IndexController@login')->name('mobile.login');
Route::get('/show', 'IndexController@show')->name('mobile.show');
