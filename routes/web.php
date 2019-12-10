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

Route::get('/', 'HomeController@index')->name('indexShop');
Route::get('/detail/{nameslug}', 'HomeController@detailProduct');
Route::get('/seller/logout', 'HomeController@logoutSeller')->name('sellerLogout');
Route::get('/buyer/logout', 'HomeController@logoutBuyer')->name('buyerLogout');
Route::get('/search/product', 'HomeController@searchProduct');
Route::get('/category/{name}', 'HomeController@getCategory');
Auth::routes();

