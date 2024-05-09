<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'], '/botman',[\App\Http\Controllers\BotController::class,'handle']);
Route::get('/products/{id}', [\App\Http\Controllers\API\ProductController::class,'show'])->name('products.show');
Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    // Routes that require verified email
    Route::get('/', function () {
        return view('welcome');
    });

});
Route::get('reset-password',function (){
    return view('resetpass');
});
Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('reset-password','reset');
});
Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::post('addproduct','create');
    Route::get('product','index');
    Route::get('product/{id}/edit', 'edit');
    Route::put('product/{product}', 'update');
    Route::put('product/{id}', 'update');
});
Route::get('/test', function () {
    return view('formtest');
});
Route::get('/email/verify', 'VerificationController@verify')->middleware('verified');
