<?php

use App\Http\Controllers\AuthenticatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GroupController;

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
Route::prefix('forms')->group(function () {
    Route::get('/index', [FormController::class, 'index']);
    Route::post('/store', [FormController::class, 'store']);
    Route::get('/edit/{id}', [FormController::class, 'edit']);
    Route::put('/update/{id}', [FormController::class, 'update']);
    Route::delete('/destroy/{id}', [FormController::class, 'destroy']);
});

Route::prefix('questions')->group(function () {
    Route::get('/index', [QuestionController::class, 'index']);
    Route::post('/store', [QuestionController::class, 'store']);
    Route::get('/edit/{id}', [QuestionController::class, 'edit']);
    Route::put('/update/{id}', [QuestionController::class, 'update']);
    Route::delete('/destroy/{id}', [QuestionController::class, 'destroy']);
});

Route::prefix('groups')->group(function () {
    Route::get('/index', [GroupController::class, 'index']);
    Route::post('/store', [GroupController::class, 'store']);
    Route::get('/edit/{id}', [GroupController::class, 'edit']);
    Route::put('/update/{id}', [GroupController::class, 'update']);
    Route::delete('/destroy/{id}', [GroupController::class, 'destroy']);

    // Rutas para gestionar miembros
    Route::get('/{id}/members', [GroupController::class, 'manageMembers']);
    Route::post('/{id}/members', [GroupController::class, 'addMember']);
    Route::delete('/{groupId}/members/{memberId}', [GroupController::class, 'removeMember']);
});
