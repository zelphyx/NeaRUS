<?php

use App\Http\Controllers\SearchController;
use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Chatify\Facades\ChatifyMessenger;



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
Route::post('/bot',[\App\Http\Controllers\BotController::class,'handlechat']);

//Profile
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\API\User\ProfileController::class)->group(function () {
        Route::post('profile/update', 'updateProfile');
        Route::get('profile', 'currentprofile');
        Route::post('profile/reset-password','profileresetpass');
        Route::post('profile/add-personal-data','addPersonalData');
        Route::post('profile/upload-photo','updatepp');
    });
});

//Payment
Route::post('checkout',[\App\Http\Controllers\OrderStatusController::class,'beforecheckout']);
Route::post('midtrans-callback',[\App\Http\Controllers\OrderStatusController::class,'callback']);
Route::middleware('auth:sanctum')->get('/orders/paid', [\App\Http\Controllers\OrderStatusController::class, 'getpaidbuyer']);
Route::middleware('auth:sanctum')->get('/orders/count', [\App\Http\Controllers\OrderStatusController::class, 'getPaidBuyerCount']);
Route::middleware('auth:sanctum')->get('/orders/user', [\App\Http\Controllers\OrderStatusController::class, 'passingbuyer']);
Route::middleware('auth:sanctum')->get('/orders/owner', [\App\Http\Controllers\OrderStatusController::class, 'passingowner']);
Route::middleware('auth:sanctum')->get('/orders/balance', [\App\Http\Controllers\OrderStatusController::class, 'getbalance']);
Route::get('/orders/detail/{id}', [\App\Http\Controllers\OrderStatusController::class, 'geteachid']);
Route::get('/owner/{id}', [\App\Http\Controllers\OrderStatusController::class, 'getownereachid']);
Route::get('/orders/extend/{orderId}', [\App\Http\Controllers\OrderStatusController::class, 'extendsewa']);


//Product
Route::middleware(['auth:sanctum'])->group(function (){
    Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
        Route::post('addproduct','create');
        Route::get('product/{id}/edit', 'edit');
        Route::put('product/put/{id}', 'update');
        Route::delete('product/delete/{id}','destroy');
    });
});





//rooms and get product
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\API\RoomController::class)->group(function () {
        Route::post('rooms/create','create');

    });
});
Route::controller(\App\Http\Controllers\API\RoomController::class)->group(function (){
    Route::get('rooms/get','index');
    Route::get('rooms/{ownerId}','showbyid');
    Route::get('rooms/availability/{ownerId}','availability');
    Route::middleware('auth:sanctum')->get('rooms/{id}/edit', 'edit');
    Route::middleware('auth:sanctum')->put('rooms/put/{id}', 'update');
    Route::middleware('auth:sanctum')->delete('rooms/delete/{id}', 'update');
});
Route::controller(\App\Http\Controllers\API\ProductController::class)->group(function (){
    Route::get('product','index');
    Route::get('product/get/{id}','findbyeachid');
});
Route::controller(\App\Http\Controllers\SearchController::class)->group(function (){
    Route::get('search','search');
});

//verification
Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    // Routes that require verified email
    Route::get('/', function () {
        return view('welcome');
    });
});
Route::get('/email/verify', 'VerificationController@verify')->middleware('verified');


//chat
Route::middleware(['auth:sanctum'])->group(function (){
    Route::controller(\App\Http\Controllers\ChatController::class)->group(function (){
        Route::post('messages','index');
        Route::get('messages', 'store');
        Route::get('chat-list', 'chatList');

    });
});


