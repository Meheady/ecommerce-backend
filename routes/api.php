<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\order\OrderController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\auth\UserAuthenticationController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\ProductCartController;

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

Route::post('/login',[UserAuthenticationController::class,'login']);

Route::post('/token-refresh',[UserAuthenticationController::class,'refreshToken'])->middleware('token.refresh:api');

Route::post('/logout',[UserAuthenticationController::class,'logout'])->middleware('api.auth:api');



Route::middleware(['api.auth:api','role:admin'])->prefix('admin')->group(function (){
    Route::prefix('product')->controller(ProductController::class)->group(function (){
        Route::get('/index','index');
        Route::get('/index/{id}','show');
        Route::post('/store','store');
        Route::post('/update','update');
        Route::get('/delete/{id}','destroy');
    });

});


Route::middleware(['api.auth:api','role:customer'])->prefix('customer')->group(function (){
    Route::prefix('cart')->controller(ProductController::class)->group(function (){
        Route::get('/index','customerCartList');
        Route::post('/store','storeCart');
        Route::post('/update','updateCart');
        Route::get('/delete/{id}','destroy');
    });

});

Route::controller(FrontendController::class)->group(function (){
    Route::get('/get-all-product','getAllProduct');
    Route::get('/single-product/{id}','singleProduct');
});


