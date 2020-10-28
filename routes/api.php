<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->any('/user', 'v1\TestController@index');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'cors', 'middleware' => 'auth:api', 'prefix' => 'v1'], function() {
// Route::group(['middleware' => 'cors', 'prefix' => 'v1'], function() {
	Route::any('test', 'v1\TestController@index');
	Route::get('tokens', 'v1\AccessController@index');
	Route::post('tokens/create', 'v1\AccessController@create');

	Route::get('staffs/', 'v1\StaffController@index');
	Route::post('staffs/create', 'v1\StaffController@create');
	Route::post('staffs/search/', 'v1\StaffController@search');
	Route::get('staffs/{id}', 'v1\StaffController@show');
	Route::post('staffs/{id}', 'v1\StaffController@update');
	Route::post('staffs/delete/{id}', 'v1\StaffController@delete');

	Route::post('admin/update/{id}', 'v1\StaffController@change_admin_password');

	Route::get('products', 'v1\ProductController@index');
	Route::get('products/list', 'v1\ProductController@list');
	Route::post('products/create', 'v1\ProductController@create');
	Route::post('products/search/', 'v1\ProductController@search');
	Route::get('products/{id}', 'v1\ProductController@show');
	Route::post('products/{id}', 'v1\ProductController@update');
	Route::post('products/delete/{id}', 'v1\ProductController@delete');
	Route::post('products/upload/{id}', 'v1\ProductController@upload');

	Route::get('product_category', 'v1\ProductCategoryController@index');
	Route::get('product_category/list', 'v1\ProductCategoryController@list');
	Route::post('product_category/create', 'v1\ProductCategoryController@create');
	Route::get('product_category/{id}', 'v1\ProductCategoryController@show');
	Route::post('product_category/{id}', 'v1\ProductCategoryController@update');
	Route::post('product_category/delete/{id}', 'v1\ProductCategoryController@delete');

	Route::get('sales', 'v1\SaleController@index');
	Route::get('sales/all', 'v1\SaleController@all');
	Route::post('sales/create', 'v1\SaleController@create');
	Route::get('sales/{id}', 'v1\SaleController@show');
	Route::get('sales/staff/{staff_id}', 'v1\SaleController@show_per_staff');
	Route::post('sales/delete/{id}', 'v1\SaleController@delete');

	Route::post('login', 'v1\LoginController@login');
	Route::post('login/validate', 'v1\LoginController@check');
	Route::post('login/staff', 'v1\LoginController@staff');
	Route::post('login/staff/validate', 'v1\LoginController@check_staff');

	Route::get('stats', 'v1\StatsController@index');
	Route::get('stats/total_staff', 'v1\StatsController@total_staff');
	Route::get('stats/total_sales', 'v1\StatsController@total_sales');
	Route::get('stats/total_sales_amount', 'v1\StatsController@total_sales_amount');
	Route::get('stats/total_products', 'v1\StatsController@total_products');
});

Route::any('test', 'v1\TestController@index');
Route::any('failed', 'v1\TestController@auth_failed')->name("failed");