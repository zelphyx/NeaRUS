<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('login','login');
    Route::post('registeruser','register');
    Route::post('logout','logout');
    Route::post('user/{userId}/add-personal-data','addPersonalData');
});
Route::controller(\App\Http\Controllers\API\User\AuthOwnerController::class)->group(function (){
    Route::post('register','register');
});

Route::get('/user',[\App\Http\Controllers\API\User\AuthUserController::class,'index']);

Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::post('addproduct','create');
    Route::get('product','index');
    Route::get('product/{id}/edit', 'edit');
    Route::put('product/{id}', 'update');
    Route::delete('product/{id}','destroy');

});
Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    // Routes that require verified email
    Route::get('/', function () {
        return view('welcome');
    });

});
Route::get('/email/verify', 'VerificationController@verify')->middleware('verified');

