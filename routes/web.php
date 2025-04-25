<?php

use App\Http\Controllers\Products\ProductController;
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

/*
Route::get('/', function () {
    return view('welcome');
}); */

// PRODUCTS
Route::get('/', 'Products\ProductController@index')->name('welcome');
Route::get('/create-product', 'Products\ProductController@create')->name('product-create');
Route::post('/save-product', 'Products\ProductController@store')->name('product-store');
Route::get('/edit-product/{product}', 'Products\ProductController@edit')->name('product-edit');
Route::put('/update-product/{product}', 'Products\ProductController@update')->name('product-update');
Route::delete('/delete-product/{product}', 'Products\ProductController@destroy')->name('product-delete');

// CATEGORIES
//Route::get('/', 'Categories\CategoryController@index')->name('welcome');
Route::get('/create-category', 'Categories\CategoryController@create')->name('category-create');
Route::post('/save-category', 'Categories\CategoryController@store')->name('category-store');
Route::get('/edit-category/{category}', 'Categories\CategoryController@edit')->name('category-edit');
Route::put('/update-category/{category}', 'Categories\CategoryController@update')->name('category-update');
Route::delete('/delete-category/{category}', 'Categories\CategoryController@destroy')->name('category-delete');

// PRODUCT AND CATEGORIES RELATIONS
Route::get('/products-associates-in-category/{category}', 'ProductAndCategories\ProductAndCategoriesController@index')->name('products-associates');
Route::get('/view-product-category/{product}', 'ProductAndCategories\ProductAndCategoriesController@index_product')->name('view-product');
Route::get('/associate-category-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@associate')->name('category-associate-to-product');
Route::post('/save-category-associated-to-product/{product}', 'ProductAndCategories\ProductAndCategoriesController@saveRelationCategoryAndPost')->name('relation-category-post');
