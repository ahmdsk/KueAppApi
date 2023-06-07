<?php

use App\Http\Controllers\CakeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VoucherController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/logout', LogoutController::class);

// Categories
Route::get('/categories', [CategoriesController::class, 'index']);
Route::post('/categories/create', [CategoriesController::class, 'create']);
Route::post('/categories/update/{id}', [CategoriesController::class, 'update']);
Route::delete('/categories/delete/{id}', [CategoriesController::class, 'delete']);

// Cake Detail
Route::get('/cake', [CakeController::class, 'index']);
Route::get('/cake/show/{id}', [CakeController::class, 'show']);
Route::post('/cake/create', [CakeController::class, 'create']);
Route::post('/cake/update/{id}', [CakeController::class, 'update']);
Route::delete('/cake/delete/{id}', [CakeController::class, 'delete']);

// Voucher
Route::get('/voucher', [VoucherController::class, 'index']);
Route::get('/voucher/show/{id}', [VoucherController::class, 'show']);
Route::post('/voucher/create', [VoucherController::class, 'create']);
Route::post('/voucher/update/{id}', [VoucherController::class, 'update']);
Route::delete('/voucher/delete/{id}', [VoucherController::class, 'delete']);