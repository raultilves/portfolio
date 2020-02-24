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

// RUTAS PROYECTOS
Route::get('/dashboard/proyectos/create', 'DashboardController@getCreateProyecto');
Route::post('/dashboard/proyectos/create', 'DashboardController@postCreateProyecto');
Route::get('/dashboard/proyectos/edit/{id}', 'DashboardController@getEditProyecto');
Route::put('/dashboard/proyectos/edit/{id}', 'DashboardController@putEditProyecto');
Route::delete('/dashboard/proyectos/delete/{id}', 'DashboardController@deleteProyecto');

// RUTAS CATEGORIAS
Route::get('/dashboard/categorias/create', 'DashboardController@getCreateCategoria');
Route::post('/dashboard/categorias/create', 'DashboardController@postCreateCategoria');
Route::get('/dashboard/categorias/edit/{id}', 'DashboardController@getEditCategoria');
Route::put('/dashboard/categorias/edit/{id}', 'DashboardController@putEditCategoria');
Route::delete('/dashboard/categorias/delete/{id}', 'DashboardController@deleteCategoria');