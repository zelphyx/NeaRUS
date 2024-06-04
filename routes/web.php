<?php

use App\Http\Controllers\Api\User\AuthOwnerController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login form submission
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::middleware(['auth:sanctum','adminmiddleware'])->group(function (){
    Route::get('/owner-requests', [AuthOwnerController::class, 'showOwnerRequests'])->name('owner.requests');
    Route::get('/owners', [AuthOwnerController::class, 'showOwners'])->name('owners.index');
});

Route::patch('/owner-requests/approve/{id}', [AuthOwnerController::class, 'approveOwner'])->name('owner.approve');
Route::delete('/owner-requests/delete/{id}', [AuthOwnerController::class, 'deleteOwner'])->name('owner.delete');

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'], '/botman',[\App\Http\Controllers\BotController::class,'handle']);
Route::get('/products/{id}', [\App\Http\Controllers\API\ProductController::class,'show'])->name('products.show');
Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    // Routes that require verified email


});
Route::get('/', function () {
    return view('welcome');
});
Route::get('reset-password/{token}', function ($token) {
    return view('resetpass', ['token' => $token]);
})->name('password.reset');
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

Route::get('/test', function () {
    return view('test');
});

