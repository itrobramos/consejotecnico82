<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

//School
Route::get('schools','App\Http\Controllers\SchoolController@index')->name('schools.index');
Route::get('/schools/add','App\Http\Controllers\SchoolController@create')->name('schools.add');
Route::post('/schools/store','App\Http\Controllers\SchoolController@store')->name('schools.store');
Route::get('/schools/edit/{id}','App\Http\Controllers\SchoolController@edit')->name('schools.edit');
Route::patch('/schools/edit/{id}','App\Http\Controllers\SchoolController@update')->name('schools.update');
Route::delete('/schools/destroy/{id}','App\Http\Controllers\SchoolController@destroy')->name('schools.destroy');

//Formats
Route::get('formats','App\Http\Controllers\FormatController@index')->name('formats.index');
Route::get('/formats/add','App\Http\Controllers\FormatController@create')->name('formats.add');
Route::post('/formats/store','App\Http\Controllers\FormatController@store')->name('formats.store');
Route::get('/formats/edit/{id}','App\Http\Controllers\FormatController@edit')->name('formats.edit');
Route::get('/formats/configure/{id}','App\Http\Controllers\FormatController@configure')->name('formats.configure');
Route::post('/formats/configureStore/{id}','App\Http\Controllers\FormatController@configureStore')->name('formats.configureStore');

Route::patch('/formats/edit/{id}','App\Http\Controllers\FormatController@update')->name('formats.update');
Route::delete('/formats/destroy/{id}','App\Http\Controllers\FormatController@destroy')->name('formats.destroy');


Auth::routes();


