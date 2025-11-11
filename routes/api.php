<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/logoutall',[AuthController::class,'logoutall']);

    Route::get('/services',[ServiceController::class,'index']);
    Route::get('/services/{id}',[ServiceController::class,'show']);
    Route::post('/services',[ServiceController::class,'store']);
    Route::put('/services/{id}',[ServiceController::class,'update']);
    Route::delete('/services/{id}',[ServiceController::class,'destroy']);

    // Route::apiResource('services',ServiceController::class);

    Route::get('/orders',[OrderController::class,'index']);
    Route::get('/orders/{id}',[OrderController::class,'show']);
    Route::post('/orders',[OrderController::class,'store']);
    Route::put('/orders/{id}',[OrderController::class,'update']);
    Route::delete('/orders/{id}',[OrderController::class,'destroy']);

    // Route::apiResource('orders',OrderController::class);

    Route::get('/chats',[ChatController::class,'index']);
    Route::get('/chats/{id}',[ChatController::class,'show']);
    Route::post('/chats/{id}',[ChatController::class,'store']);

});
