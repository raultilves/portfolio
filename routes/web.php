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

Route::get('/', 'IndexController@getIndex');

Auth::routes(['register' => false]);

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard/proyectos/create', 'DashboardController@getCreateProyecto');
Route::post('/dashboard/proyectos/create', 'DashboardController@postCreateProyecto');
Route::get('/dashboard/proyectos/edit/{id}', 'DashboardController@getEditProyecto');
Route::put('/dashboard/proyectos/edit/{id}', 'DashboardController@putEditProyecto');
Route::delete('/dashboard/proyectos/delete/{id}', 'DashboardController@deleteProyecto');
