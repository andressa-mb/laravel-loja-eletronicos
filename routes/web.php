<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
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

//PÁGINA DO ADM
Route::get('/idx-admin', 'HomeController@indexAdm')->name('index-adm');
Route::get('/orders', 'Orders\OrderController@orders')->name('orders');

//RELATÓRIOS -> ESTOQUE
Route::get('/pdf-list/{tableName}', 'Reports\ReportController@downloadPdf')->name('pdf-list');
Route::get('/stock-list', 'Reports\ReportController@showStock')->name('stock-list');
Route::get('/client-list', 'Reports\ReportController@showClients')->name('client-list');
Route::get('/sales-list', 'Reports\ReportController@showSales')->name('sales-list');

//USUÁRIOS
Route::get('/users-list', 'Users\UserController@usersList')->name('users-list');
Route::get('/user/{user}', 'Users\UserController@editUser')->name('edit-user');
Route::put('/update-user/{user}', 'Users\UserController@updateUser')->name('update-user');
Route::delete('/delete-user/{user}', 'Users\UserController@destroy')->name('delete-user');

//ASSOCIAÇÃO DE PRODUTOS COM CATEGORIAS - APENAS ADMS FAZEM
Route::get('/associate-category-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@associate')->name('category-associate-to-product');
Route::post('/save-category-associated-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@saveRelationCategoryAndPost')->name('relation-category-post');

//PÁGINA DO COMPRADOR E PROFILE
Route::get('/', 'HomeController@indexBuyer')->name('index-buyer');
Route::get('/profile/{user}', 'HomeController@indexProfile')->name('my-profile');
Route::get('/purchases', 'Orders\OrderController@purchases')->name('my-purchases');

//IDIOMA
Route::get('/language/{lang}', 'LangController@setLang')->name('language');

//ORDERS
Route::get('/selling-product/{product}', 'Orders\OrderController@selling_product')->name('selling-product-info-client');
Route::get('/products-in-cart', 'Orders\OrderController@cart_list')->name('cart_list');
Route::get('/selling-products-in-cart', 'Orders\OrderController@selling_itens_cart_list')->name('selling-itens-cart-list');
Route::post('/user-data-to-send-product', 'Orders\OrderController@send_userdata')->name('user-data-to-send-product');
Route::delete('/cancel-order/{order}', 'Orders\OrderController@destroy')->name('cancel-order');

//TRACKS
Route::get('track-order/{order_id}', 'Tracks\TrackController@show')->name('track-order');

//PÁGINA DA LISTA DE DESEJOS
Route::get('/wish-list', 'Wish\WishController@wishes')->name('my-wish');
Route::get('/add-product-to-list/{product}', 'Wish\WishController@addToWish')->name('add-wish');
Route::get('/remove-wish/{wish}', 'Wish\WishController@removeWish')->name('remove-wish');

//NOTIFICAÇÕES
Route::get('/notifications', 'Notifications\WishProductNotificationsController@index')->name('notifications.index');
Route::post('/notifications/mark-as-read', 'Notifications\WishProductNotificationsController@markAsRead')->name('notifications.markAsRead');
Route::post('/notification/mark-one-as-readed/{notify}', 'Notifications\WishProductNotificationsController@markOneReaded')->name('notification.markOneReaded');

//DISCOUNTS
Route::get('/discount-create', "Discounts\DiscountController@create")->name('discount-create');
Route::post('/discount-store', "Discounts\DiscountController@store")->name('discount-store');
Route::get('/discounts-list', "Discounts\DiscountController@show")->name('discount-show');
Route::get('/edit-discount/{discount}', "Discounts\DiscountController@edit")->name('discount-edit');
Route::put('/update-discount/{discount}', "Discounts\DiscountController@update")->name('discount-update');
Route::delete('/delete-discount/{discount}', "Discounts\DiscountController@destroy")->name('discount-delete');
Route::get('/discount-products', "Discounts\DiscountController@showPromotions")->name('discount-products');

// PRODUCTS
Route::get('/create-product', 'Products\ProductController@create')->name('product-create');
Route::post('/save-product', 'Products\ProductController@store')->name('product-store');
Route::get('/edit-product/{product}', 'Products\ProductController@edit')->name('product-edit');
Route::put('/update-product/{product}', 'Products\ProductController@update')->name('product-update');
Route::get('/show-products', 'Products\ProductController@show')->name('product-show');
Route::delete('/delete-product/{product}', 'Products\ProductController@destroy')->name('product-delete');
Route::get('/popular-products', "Products\ProductController@showPopular")->name('popular-products');
Route::get('/liquidation-products', "Products\ProductController@showLiquidation")->name('liquidation-products');

// CATEGORIES
Route::get('/create-category', 'Categories\CategoryController@create')->name('category-create');
Route::post('/save-category', 'Categories\CategoryController@store')->name('category-store');
Route::get('/edit-category/{category}', 'Categories\CategoryController@edit')->name('category-edit');
Route::put('/update-category/{category}', 'Categories\CategoryController@update')->name('category-update');
Route::get('/show-categories', 'Categories\CategoryController@show')->name('category-show');
Route::delete('/delete-category/{category}', 'Categories\CategoryController@destroy')->name('category-delete');

// PRODUCT AND CATEGORIES RELATIONS - CART E SELLINGS
Route::get('/view-product-category/{product}', 'ProductAndCategories\ProductAndCategoriesController@index_product')->name('view-product');
Route::get('/products-associates-in-category', 'ProductAndCategories\ProductAndCategoriesController@index_category')->name('products-associates');

Auth::routes();
Broadcast::routes(['middleware' => ['auth']]);
