<?php 
Route::get('/login', function () {
	return view('auth.buyer.login');
})->name('loginIndexBuyer');
Route::post('/login/process', 'buyer\AuthController@login')->name('loginBuyer');
Route::get('/register', function () {
	return view('auth.buyer.register');
});
Route::post('/register', 'buyer\AuthController@register')->name('registerBuyer');

Route::group(['middleware', 'buyerMiddleware'], function () {
	Route::post('/storecart', 'ShopController@storeCart')->name('storeCartBuyer');
	Route::get('/cart', 'ShopController@indexCart')->name('indexCart');
	Route::get('/cart/editcapacity/{id}', 'ShopController@editCapacityCart');
	Route::get('/cart/deletecapacity/{id}', 'ShopController@deleteCapacityCart');
	Route::post('/cart/editquantity', 'ShopController@editQuantity')->name('editQuantity');
	Route::post('/cart/updatecapacity/', 'ShopController@updateQuantityCart')->name('updateQuantityCart');
	Route::post('/cart/order/store', 'ShopController@storeOrderCart')->name('storeOrderCart');

	Route::get('/profile', 'buyer\ProfileController@index')->name('indexProfile');
	Route::post('/profile/update', 'buyer\ProfileController@update')->name('updateProfile');

	Route::get('/order', 'buyer\OrderController@index')->name('indexOrderBuyer');
	Route::post('/order/imagepayment/store', 'buyer\OrderController@storeImagePayment')->name('storeImagePayment');
	Route::get('/order/isreceive/{id}', 'buyer\OrderController@isReceiveActive');
	Route::get('/order/isnotreceive/{id}', 'buyer\OrderController@isReceiveDeactive');
	Route::get('/order/iscancel/{id}', 'buyer\OrderController@isCancel');
	Route::get('/order/iscancel/{id}/return', 'buyer\OrderController@isCancelReturn');
	Route::get('/order/detail/{id}', 'buyer\OrderController@detailOrder')->name('detailOrder');
});