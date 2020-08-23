<?php

Route::get('/', 'IndexController@index')->name('h5.index');
Route::get('/school', 'IndexController@school')->name('h5.school');
Route::post('/login', 'IndexController@login')->name('h5.login');
Route::get('/show', 'IndexController@show')->name('h5.show');
