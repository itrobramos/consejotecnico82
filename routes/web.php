<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

//School
Route::get('schools','App\Http\Controllers\SchoolController@index')->name('schools.index');
Route::get('/schools/create','App\Http\Controllers\SchoolController@create')->name('schools.add');
Route::post('/schools/create','App\Http\Controllers\SchoolController@store')->name('schools.store');
Route::get('/schools/edit/{id}','App\Http\Controllers\SchoolController@edit')->name('schools.edit');
Route::post('/schools/edit/{id}','App\Http\Controllers\SchoolController@update')->name('schools.update');
Route::delete('/schools/destroy/{id}','App\Http\Controllers\SchoolController@destroy')->name('schools.destroy');

Auth::routes();


