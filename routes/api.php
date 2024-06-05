<?php

use App\Http\Controllers\SearchController;
use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


//User
Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('masuk','loginuserowner');
    Route::post('daftaruser','register');
    Route::post('logoutt','logoutuserowner');
    Route::post('reset-password','sendResetPasswordEmail');
    Route::get('/verify-email/{token}','verifyEmail')->name('verify.email');
    Route::get('verify/verify-email/{token}','apiVerifyEmail')->name('api.verify.email');
    Route::post('resend-verification','resendVerification');
});


Route::controller(\App\Http\Controllers\API\User\AuthOwnerController::class)->group(function (){
    Route::post('daftar','daftarowner');
});

Route::get('/user',[\App\Http\Controllers\API\User\AuthUserController::class,'index']);

//Profile
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\API\User\ProfileController::class)->group(function () {
        Route::put('profile/update', 'updateProfile');
        Route::post('profile/reset-password','profileresetpass');
        Route::post('profile/add-personal-data','addPersonalData');
    });
});



//Product
Route::middleware(['auth:sanctum'])->group(function (){
    Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
        Route::post('addproduct','create');
        Route::get('product/{id}/edit', 'edit');
        Route::put('product/put/{id}', 'update');
        Route::delete('product/delete/{id}','destroy');
    });
});






Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\API\RoomController::class)->group(function () {
        Route::post('rooms/create','create');

    });
});


Route::controller(\App\Http\Controllers\API\RoomController::class)->group(function (){
    Route::get('rooms/get','index');
    Route::get('rooms/{ownerId}','showbyid');
});
Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::get('product','index');
    Route::get('product/get/{id}','findbyeachid');
});
Route::controller(\App\Http\Controllers\SearchController::class)->group(function (){
    Route::get('search','search');
});


Auth::routes(['verify' => true]);


Route::middleware('verified')->group(function () {
    // Routes that require verified email
    Route::get('/', function () {
        return view('welcome');
    });
});


Route::get('/email/verify', 'VerificationController@verify')->middleware('verified');

