<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('login','login');
    Route::post('register','register');
});

Route::get('/all',[\App\Http\Controllers\API\User\AuthUserController::class,'index']);
