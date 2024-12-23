<?php

use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\FormAnswerUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;

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


Route::get('/test', [TestController::class, 'test']);
