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

Route::resource('users', 'UserController')
    ->only([
        'show',
        'update',
        'destroy'
    ]);

Route::resources([
    'tasks' => 'TaskController',
    'statuses' => 'TaskStatusController'
]);

Route::patch('/task/{id}/proceed', 'TaskController@proceed')->name('tasks.proceed');
