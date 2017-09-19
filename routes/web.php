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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('serverCRUD','DNSServerController');

Route::get('/server', 'DNSServerController@index')->name('server');

Route::resource('zoneCRUD','DNSZoneController');

Route::get('/zone', 'DNSZoneController@index')->name('server');

