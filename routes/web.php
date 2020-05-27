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

Route::get('/', 'controller_post@index');
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/post/{post_id}/edit ', 'controller_post@edit');
Route::resource('/post', 'controller_post',['middleware' => 'checklogin']);
Route::get('get_api', 'controller_post@get_api');
Route::get('post_sync/{sort}', 'controller_post@sync');

// Route::post('/report/{data}', 'controller_data@show_fromto')->middleware('checklogin');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
