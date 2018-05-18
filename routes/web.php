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

Route::get('/', "HomeController@nsfw")->middleware('ageId')->name('home');
Route::get('/sfw', "Auth\AgeIdController@authenticate");
Route::get('/redir', "Auth\AgeIdController@redirect");
Route::post('/ageIdCallback', "Auth\AgeIdController@modalCallback");
Route::get('/ageIdRedirectCallback', "Auth\AgeIdController@callbackRedirect")->name('ageid.redirect.callback');
Route::get('/redirect/ageid/handshake', "Auth\AgeIdController@redirect")->name('redirect.ageid.handshake');
Route::get('/redirect/ageid', "Auth\AgeIdController@noScriptUnauthorized")->name('redirect.ageid');
