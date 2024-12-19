<?php

use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MailController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticatorController::class, 'register']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::get('/logout', [AuthenticatorController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

});

Route::post('/import/students', [StudentController::class, 'importStudentsFromExcel']);

Route::prefix('/students')->group(function () {
   Route::get('/getStudentsByTeacher/{idTeacher}', [StudentController::class, 'getStudentsByTeacher']);
});

Route::prefix('/groups')->group(function () {
    Route::post('/create', [GroupController::class, 'store'])->name('groups.create');
    Route::get('/getGroup/{idGroup}', [GroupController::class, 'getGroup'])->name('get-group');
    Route::get('/getLetters', [GroupController::class, 'getLetters'])->name('get-letters');
    Route::get('/getMyGroupsByTeacher/{idTeacher}', [GroupController::class, 'getMyGroupsByTeacher'])->name('get-group-teacher');
});

Route::post('/sendEmail',[MailController::class, 'sendEmail']);


