<?php

use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\FormAnswerUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticatorController::class, 'register']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::get('/logout', [AuthenticatorController::class, 'logout']);
});

Route::post('/auth/login', [AuthenticatorController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserController::class, 'changePassword']);
    Route::get('/user/search/{name}', [UserController::class, 'searchUsersByName']);
    Route::post('/user/generateToken', [UserController::class, 'generateToken']);
});

Route::post('/import/students', [StudentController::class, 'importStudentsFromExcel']);

Route::prefix('/students')->group(function () {
   Route::get('/getStudentsByTeacher/{idTeacher}', [StudentController::class, 'getStudentsByTeacher']);
   Route::get('/getStudentsById/{idStudent}', [StudentController::class, 'getStudentById'])->name('get-students-by-id');
});

Route::prefix('/groups')->group(function () {
    Route::post('/create', [GroupController::class, 'store'])->name('groups.create');
    Route::get('/getGroup/{idGroup}', [GroupController::class, 'getMyGroupsByTeacher'])->name('get-group');
    Route::get('/getLetters', [GroupController::class, 'getLetters'])->name('get-letters');
    Route::get('/getMyGroupsByTeacher/{idTeacher}', [GroupController::class, 'getMyGroupsByTeacher'])->name('get-group-teacher');
});

//ROUTES FOR FORMS
Route::prefix('/form')->group(function () {
    Route::get('/getForm/{idForm}', [FormController::class, 'getForm']);
    Route::post('/initForm', [FormController::class, 'initForm']);
    Route::post('/submitForm', [FormAnswerUserController::class, 'submitForm']);
});

//ROUTES FOR CHATS
Route::middleware('auth:sanctum')->prefix('/chats')->group(function () {
    Route::post('/search-or-create', [ChatsController::class, 'searchOrCreate']);
    Route::get('/getChats', [ChatsController::class, 'getChats']);
    Route::get('/{chatId}/messages', [ChatsController::class, 'getMessages']);
    Route::post('/setStatusOnline', [ChatsController::class, 'setStatusOnline']);
    Route::post('/setStatusOffline', [ChatsController::class, 'setStatusOffline']);
    Route::get('/getStatus', [ChatsController::class, 'getStatus']);
    Route::post('/storeMessage', [ChatsController::class, 'storeMessage']);
});
    
Route::get('/login', function () {
    return response()->json(['error' => 'Not authenticated']);
})->name('login');

Route::get('/test', [TestController::class, 'test']);

