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
Route::prefix('seller')->group(function() {
	Route::get('/login', function () {
		return view('auth.seller.login');
	})->name('loginIndexSeller');

	Route::post('/login/process', 'seller\AuthController@login')->name('loginSeller');
	Route::get('/verify/{id}/{name}', 'seller\AuthController@verify');

	Route::get('/category', 'seller\CategoryController@index')->name('categoryIndex');
	Route::get('/category/add', function () {
		return view('seller.category.add-category');
	});

	Route::group(['middleware' => 'sellerMiddleware'], function () {


		Route::post('/category/store', 'seller\CategoryController@store')->name('storeCategory');
		Route::get('/category/edit/{id}', 'seller\CategoryController@edit');
		Route::get('/category/delete/{id}', 'seller\CategoryController@delete');
		Route::post('/category/update', 'seller\CategoryController@update')->name('updateCategory');

		Route::get('/product', 'seller\ProductController@index')->name('indexProduct');
		Route::get('/product/add', 'seller\ProductController@add');
		Route::post('/product/store', 'seller\ProductController@store')->name('storeProduct');
		Route::get('/product/active/{id}', 'seller\ProductController@active');
		Route::get('/product/deactive/{id}', 'seller\ProductController@deactive');
		Route::get('/product/edit/{id}', 'seller\ProductController@edit');
		Route::get('/product/delete/{id}', 'seller\ProductController@delete');
		Route::post('/product/update', 'seller\ProductController@update')->name('updateProduct');

		Route::get('/bank', 'seller\BankController@index')->name('indexBank');
		Route::get('/bank/add', function () {
			return view('seller.bank.add-bank');
		});
		Route::post('/bank/store', 'seller\BankController@store')->name('storeBank');
		Route::get('/bank/edit/{id}', 'seller\BankController@edit');
		Route::get('/bank/delete/{id}', 'seller\BankController@delete');
		Route::post('/bank/update', 'seller\BankController@update')->name('updateBank');

		Route::get('/staff', 'seller\StaffController@index')->name('indexStaff');
		Route::get('/staff/add', function () {
			return view('seller.staff.add-staff');
		});
		Route::post('/staff/register', 'seller\StaffController@register')->name('registerStaff');
		Route::get('/staff/edit/{id}', 'seller\StaffController@edit');
		Route::get('/staff/delete/{id}', 'seller\StaffController@delete');
		Route::post('/staff/update', 'seller\StaffController@update')->name('updateStaff');

		Route::get('/order', 'seller\OrderController@index')->name('indexOrderSeller');
		Route::get('/order/shipped/active/{id}', 'seller\OrderController@isShippedActive');
		Route::get('/order/shipped/deactive/{id}', 'seller\OrderController@isShippedDeactive');
		Route::get('/order/paymentreceive/active/{id}', 'seller\OrderController@isPaymentReceiveActive');
		Route::get('/order/paymentreceive/deactive/{id}', 'seller\OrderController@isPaymentReceiveDeactive');
		Route::get('/order/cancel/active/{id}', 'seller\OrderController@isCancelSellerActive');
		Route::get('/order/cancel/deactive/{id}', 'seller\OrderController@isCancelSellerDeactive');
	});
});

Route::prefix('buyer')->group(function() {
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
	});
});
Auth::routes();

