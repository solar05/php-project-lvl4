<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/locale/{lang}', 'LanguageController@switchLang')->name('locale.switch');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/{id}', 'Auth\ShowUserController@show')->name('user.show');

Route::patch('/user', 'Auth\UpdateUserController@update')->name('user.update');

Route::delete('/user', 'Auth\DeleteUserController@delete')->name('user.delete');

Route::get('/tasks', 'TaskController@index')->name('task.index');

Route::get('/task/{id}', 'TaskController@show')->name('task.show');

Route::delete('/tasks/{id}', 'TaskController@destroy')->name('tasks.destroy');

Route::post('/tasks', 'TaskController@store')->name('tasks.store');

Route::patch('/task/{id}/proceed', 'TaskController@proceed')->name('task.proceed');
