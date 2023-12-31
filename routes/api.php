<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/reserve', '\App\Http\Controllers\ReserveItemsController');

Route::group(['middleware' => ['auth:api', 'can:admin']], function() {
    Route::get('/products', '\App\Http\Controllers\GetProductsController');
    Route::post('/products', '\App\Http\Controllers\UpdateInventoryController');
});
