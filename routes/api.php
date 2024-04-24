<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('login','login');
    Route::post('registeruser','register');
    Route::post('logout','logout');
});
Route::controller(\App\Http\Controllers\API\User\AuthOwnerController::class)->group(function (){
    Route::post('register','register');
});

Route::get('/user',[\App\Http\Controllers\API\User\AuthUserController::class,'index']);
