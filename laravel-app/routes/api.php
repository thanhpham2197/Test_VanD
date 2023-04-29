<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserConctroller;
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

Route::post('user/register', [UserConctroller::class, 'register']);
Route::post('user/login', [UserConctroller::class, 'login']);

Route::middleware('auth:api')->group(function() {
    Route::post('user/logout', [UserConctroller::class, 'logout']);
    
    Route::group(['prefix' => 'store'], function() {
        Route::get('/' , [StoreController::class, 'list']);
        Route::post('/' , [StoreController::class, 'create']);
        Route::put('/{id}' , [StoreController::class, 'update']);
        Route::delete('/{id}' , [StoreController::class, 'delete']);
        Route::get('/{id}' , [StoreController::class, 'detail']);
    });

    Route::group(['prefix' => 'product'], function() {
        Route::get('/' , [ProductController::class, 'list']);
        Route::post('/' , [ProductController::class, 'create']);
        Route::put('/{id}' , [ProductController::class, 'update']);
        Route::delete('/{id}' , [ProductController::class, 'delete']);
        Route::get('/{id}' , [ProductController::class, 'detail']);
    });
});
