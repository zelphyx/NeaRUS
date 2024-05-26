<?php

use App\Http\Controllers\SearchController;
use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\API\User\AuthUserController::class)->group(function (){
    Route::post('masuk','loginuserowner');
    Route::post('daftaruser','register');
    Route::post('logoutt','logoutuserowner');
    Route::post('user/{ownerId}/add-personal-data','addPersonalData');
    Route::post('reset-password','sendResetPasswordEmail');
    Route::get('/verify-email/{token}','verifyEmail')->name('verify.email');
    Route::get('verify/verify-email/{token}','apiVerifyEmail')->name('api.verify.email');
    Route::post('resend-verification','resendVerification');
});


Route::controller(\App\Http\Controllers\API\User\AuthOwnerController::class)->group(function (){
    Route::post('daftar','register');
});


Route::get('/user',[\App\Http\Controllers\API\User\AuthUserController::class,'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\API\User\ProfileController::class)->group(function () {
        Route::post('profile/update', 'updateprofilebackup');
        Route::post('profile/reset-password','profileresetpass');
    });
});



Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::post('addproduct','create');
    Route::get('product/{id}/edit', 'edit');
    Route::put('product/{id}', 'update');
    Route::delete('product/{id}','destroy');
})->middleware(['websiterole','auth:sanctum']);



Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::get('product','index');
})->middleware(['auth:sanctum']);


Auth::routes(['verify' => true]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('search', [SearchController::class, 'search']);
});

Route::middleware('verified')->group(function () {
    // Routes that require verified email
    Route::get('/', function () {
        return view('welcome');
    });
});


Route::get('/email/verify', 'VerificationController@verify')->middleware('verified');

