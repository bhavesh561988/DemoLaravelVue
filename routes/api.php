<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

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

// route for get products api
Route::get('products',[ProductController::class, 'products']);
// route for get orders api
Route::get('orders', [OrderController::class, 'orders']);
// route order placed api
Route::post('order/placed', [OrderController::class, 'orderPlaced']);
// route order status update api
Route::post('order/status/update', [OrderController::class, 'orderStatusUpdate']);



