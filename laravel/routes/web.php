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

Route::get('/', 'HomeController@index');

Route::get('/prize/get', 'PrizeController@prizeGeneration');
Route::get('/prize/discard', 'PrizeController@prizeDiscard');
Route::get('/prize/change', 'PrizeController@prizeChange');
Route::get('/prize/confirm', 'PrizeController@prizeConfirm');

Route::get('/user/amount', 'UserController@getAmount');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    
    Route::get('','AdminController@index');
    Route::get('dashboard','AdminController@index');
    
});
