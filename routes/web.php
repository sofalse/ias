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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/password/{id}', 'HomeController@password')->name('changePassword');
Route::resource('gpx', 'GPXController')->except('show'); // TODO: GPX Show
Route::resource('lyric', 'LyricsController'); // TODO" Lyrics Show