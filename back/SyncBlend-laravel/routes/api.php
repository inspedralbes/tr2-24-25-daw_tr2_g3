<?php

use App\Http\Controllers\AuthenticatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticatorController::class, 'register']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::get('/logout', [AuthenticatorController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

});
