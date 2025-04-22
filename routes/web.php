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

Route::get('/', 'Products\ProductController@index')->name('welcome');
Route::get('/create-product', 'Products\ProductController@create')->name('product-create');
Route::post('/save-product', 'Products\ProductController@store')->name('product-store');
