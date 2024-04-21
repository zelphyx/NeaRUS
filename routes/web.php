<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'], '/botman',[\App\Http\Controllers\BotController::class,'handle']);
