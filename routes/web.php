<?php
use Illuminate\Support\Facades\Auth;
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
//PÁGINA DO COMPRADOR E PROFILE
Route::get('/', 'HomeController@indexBuyer')->name('index-buyer');
Route::get('/profile/{user}', 'HomeController@indexProfile')->name('my-profile');

//PÁGINA DO ADM
Route::get('/idx-admin', 'HomeController@indexAdm')->name('index-adm');

//ADMS
//ASSOCIAÇÃO DE PRODUTOS COM CATEGORIAS - APENAS ADMS FAZEM
Route::get('/associate-category-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@associate')->name('category-associate-to-product');
Route::post('/save-category-associated-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@saveRelationCategoryAndPost')->name('relation-category-post');

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

// PRODUCT AND CATEGORIES RELATIONS - VIEWS E SELLINGS
Route::get('/view-product-category/{product}', 'ProductAndCategories\ProductAndCategoriesController@index_product')->name('view-product');
Route::get('/products-associates-in-category', 'ProductAndCategories\ProductAndCategoriesController@index_category')->name('products-associates');
Route::get('/selling-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@selling_product')->name('selling-product-info-client');
Route::post('/user-data-to-send-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@send_userdata')->name('user-data-to-send-product');

Auth::routes();
