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
use App\Http\Controllers\QuestionController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticatorController::class, 'register']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::get('/logout', [AuthenticatorController::class, 'logout']);
});

Route::post('/auth/login', [AuthenticatorController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

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
    Route::post('/create', [FormController::class, 'store']);
    Route::put('/update/{id}', [FormController::class, 'update']);
    Route::delete('/delete/{id}', [FormController::class, 'destroy']);
    Route::get('/getForm/{idForm}', [FormController::class, 'getForm']);
    Route::post('/initForm', [FormController::class, 'initForm']);
    Route::post('/submitForm', [FormAnswerUserController::class, 'submitForm']);
    Route::post('/calculateDataCesc', [FormController::class, 'calculateDataCesc']);
});

Route::prefix('questions')->group(function () {
    Route::post('/create', [QuestionController::class, 'store']);
    Route::put('/update/{id}', [QuestionController::class, 'update']);
    Route::delete('/delete/{id}', [QuestionController::class, 'destroy']);
    Route::get('/get/{id}', [QuestionController::class, 'getQuestion']);
});

Route::get('/test', [TestController::class, 'test']);
