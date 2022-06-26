<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::middleware(['auth', 'verified'])->group(function () {
	// Users
Route::get('dashboard','DashboardController@show');

Route::get('admin', 'DashboardController@show');

Route::get('admin/user/list', 'AdminUserController@list');

Route::get('admin/user/add', 'AdminUserController@add');

Route::post('admin/user/store', 'AdminUserController@store');

Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user');

Route::get('admin/user/action', 'AdminUserController@action');

Route::get('admin/user/edit/{id}', 'AdminUserController@edit')->name('user.edit');

Route::post('admin/user/update/{id}', 'AdminUserController@update')->name('user.update');


//order

Route::get('admin/order/list', 'AdminOrderController@list');

Route::get('admin/order/edit/{id}', 'AdminOrderController@edit')->name('order.edit');


Route::post('admin/order/update/{id}', 'AdminOrderController@update')->name('order.update');

Route::get('admin/order/delete/{id}', 'AdminOrderController@delete')->name('delete_order');

Route::get('admin/order/action', 'AdminOrderController@action');

Route::get('admin/order/detail/{id}', 'AdminOrderController@detail')->name('order.detail');


//product

Route::get('admin/product/list', 'AdminProductController@list');

Route::get('admin/product/cat/list', 'AdminProductCatController@list');

Route::post('admin/product/cat/add', 'AdminProductCatController@add_cat')->name('product.cat.add');

Route::get('admin/product/cat/delete/{id}', 'AdminProductCatController@delete_cat')->name('product.cat.delete');
Route::get('admin/product/cat/edit/{id}', 'AdminProductCatController@edit_cat')->name('product.cat.edit');
 Route::post('admin/product/cat/update/{id}', 'AdminProductCatController@update_cat')->name('product.cat.update');

Route::get('admin/product/add', 'AdminProductController@add');

Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('delete_product');

Route::get('admin/product/action', 'AdminProductController@action')->name('product.action');

Route::get('admin/product/edit/{id}', 'AdminProductController@edit')->name('product.edit');
Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('product.update');
Route::post('admin/product/store', 'AdminProductController@store')->name('product.store');


//post

Route::get('admin/post/list', 'AdminPostController@list');

Route::get('admin/post/cat/list', 'AdminPostCatController@list');

Route::post('admin/post/cat/add', 'AdminPostCatController@add_cat')->name('post.cat.add');

Route::get('admin/post/cat/delete/{id}', 'AdminPostCatController@delete_cat')->name('post.cat.delete');
Route::get('admin/post/cat/edit/{id}', 'AdminPostCatController@edit_cat')->name('post.cat.edit');

Route::post('admin/post/cat/update/{id}', 'AdminPostCatController@update_cat')->name('post.cat.update');


//post

Route::get('admin/post/add', 'AdminPostController@add')->name('post.add');
Route::post('admin/post/store', 'AdminPostController@store')->name('post.store');
Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('delete_post');
Route::post('admin/post/action', 'AdminPostController@action')->name('post.action');

Route::get('admin/post/edit/{id}', 'AdminPostController@edit')->name('post.edit');
Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('post.update');


//page
Route::get('admin/page/list', 'AdminPageController@list')->name('page.list');
Route::get('admin/page/add', 'AdminPageController@add')->name('page.add');

Route::post('admin/page/store', 'AdminPageController@store')->name('page.store');

Route::get('admin/page/delete/{id}', 'AdminPageController@delete')->name('delete_page');

Route::post('admin/page/action', 'AdminPageController@action')->name('page.action');
Route::get('admin/page/edit/{id}', 'AdminPageController@edit')->name('page.edit');
Route::post('admin/page/update/{id}', 'AdminPageController@update')->name('page.update');








});

Route::group(['prefix' => 'laravel-filemanager'], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });
 
Route::get('/', 'HomeController@home');

Route::get('/home', 'HomeController@home');

Route::get('home/search_header', 'HomeController@search_header');


Route::get('san-pham/{id}-{slug}', 'ProductController@detail');

Route::get('san-pham', 'ProductController@show');

//Route::get('danh-muc/{cat_id}-{slug}', 'ProductController@list');

Route::get('danh-muc/{cat_name}', 'ProductController@show_cat')->name('cat');

Route::get('product/search_fillter', 'ProductController@search_fillter');

Route::get('/search','ProductController@search')->name('search');

Route::get('bai-viet', 'PostController@show');

Route::get('bai-viet/{id}-{slug}', 'PostController@detail');

Route::get('{id}-{slug}', 'PageController@detail');

Route::get('cart', 'CartController@show');

Route::get('them-gio-hang/{id}-{slug}', 'CartController@add');

Route::get('destroy', 'CartController@destroy');

Route::get('remove/{row_Id}', 'CartController@remove');

Route::post('cart/update', 'CartController@update');

Route::get('cart/update_ajax', 'CartController@update_ajax');


Route::get('checkout', 'CheckoutController@checkout');

Route::post('checkout/store', 'CheckoutController@store');

Route::get('mua-ngay/{id}-{slug}', 'CheckoutController@buy_now');

Route::post('checkout/store_buyNow/{id}', 'CheckoutController@store_buyNow');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

