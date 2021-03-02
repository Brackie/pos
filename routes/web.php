<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','App\Http\Controllers\PagesController@index')->name('index');

Route::get('/invoices','App\Http\Controllers\PagesController@invoices')->name('invoices');

Route::get('/cart','App\Http\Controllers\PagesController@cart')->name('cart');

Route::get('/create/product','App\Http\Controllers\PagesController@create_product')->name('create_product');

Route::post('/store/product','App\Http\Controllers\PagesController@store_product')->name('store_product');

Route::post('/allproducts','App\Http\Controllers\PagesController@get_all_products')->name('all_products');

Route::post('/allinvoices','App\Http\Controllers\PagesController@get_all_invoices')->name('all_invoices');

Route::post('/filterproducts','App\Http\Controllers\PagesController@search')->name('filter_products');

Route::post('/store/sale','App\Http\Controllers\PagesController@store_sale')->name('store_sale');

Route::post('/pay/invoice','App\Http\Controllers\PagesController@pay_invoice')->name('pay_invoice');
