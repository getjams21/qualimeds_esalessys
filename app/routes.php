<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', 'PagesController@home');
Route::get('tasks', 'TasksController@index');
Route::get('tasks/{id}', 'TasksController@show');
Route::get('404', 'PagesController@soft404');
Route::get('pages/register', 'PagesController@register');
Route::post('pages/store', 'PagesController@store');