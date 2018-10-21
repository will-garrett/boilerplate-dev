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
    return view('welcome',['page_title'=>"willgarrett.io"]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sysinfo', function(){
    return view('phpinfo');
});