<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


Auth::routes();


