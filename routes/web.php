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
Route::get('/orders', 'HomeController@orders')->name('orders');

//USUÁRIOS
Route::get('/users-list', 'User\UserController@usersList')->name('users-list');
Route::get('/user/{user}', 'User\UserController@editUser')->name('edit-user');
Route::put('/update-user/{user}', 'User\UserController@updateUser')->name('update-user');
Route::delete('/delete-user/{user}', 'User\UserController@destroy')->name('delete-user');

//ASSOCIAÇÃO DE PRODUTOS COM CATEGORIAS - APENAS ADMS FAZEM
Route::get('/associate-category-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@associate')->name('category-associate-to-product');
Route::post('/save-category-associated-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@saveRelationCategoryAndPost')->name('relation-category-post');

//PÁGINA DO COMPRADOR E PROFILE
Route::get('/', 'HomeController@indexBuyer')->name('index-buyer');
Route::get('/profile/{user}', 'HomeController@indexProfile')->name('my-profile');
Route::get('/purchases', 'HomeController@purchases')->name('my-purchases');

//IDIOMA
Route::get('/language/{lang}', 'LangController@setLang')->name('language');

//PÁGINA DA LISTA DE DESEJOS
Route::get('/wish-list', 'Wish\WishController@wish')->name('my-wish');
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
Route::get('/discount-products', "Discounts\DiscountController@showForBuyer")->name('discount-products');

// PRODUCTS
Route::get('/create-product', 'Products\ProductController@create')->name('product-create');
Route::post('/save-product', 'Products\ProductController@store')->name('product-store');
Route::get('/edit-product/{product}', 'Products\ProductController@edit')->name('product-edit');
Route::put('/update-product/{product}', 'Products\ProductController@update')->name('product-update');
Route::get('/show-products', 'Products\ProductController@show')->name('product-show');
Route::delete('/delete-product/{product}', 'Products\ProductController@destroy')->name('product-delete');

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
Route::get('/selling-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@selling_product')->name('selling-product-info-client');
Route::get('/products-in-cart', 'ProductAndCategories\ProductAndCategoriesController@cart_list')->name('cart_list');
Route::get('/selling-products-in-cart', 'ProductAndCategories\ProductAndCategoriesController@selling_itens_cart_list')->name('selling-itens-cart-list');
Route::post('/user-data-to-send-product', 'ProductAndCategories\ProductAndCategoriesController@send_userdata')->name('user-data-to-send-product');

Auth::routes();
Broadcast::routes(['middleware' => ['auth']]);
