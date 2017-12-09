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

Route::get('/','HomeController@index')->name('home');

Route::get('/automata','AutomataController@index')->name('automata_index');
Route::get('/automata/create','AutomataController@create')->name('automata_create');
Route::post('/automata/create','AutomataController@store')->name('automata_store');
Route::get('/automata/get','AutomataController@getList')->name('automata_get');

Route::get('/term','TermController@index')->name('term');
Route::get('handle','TermController@handle')->name('term_handle');
