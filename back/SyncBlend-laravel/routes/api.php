<?php

use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\FormAnswerUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticatorController::class, 'register']);
    Route::post('/login', [AuthenticatorController::class, 'authenticate']);
    Route::get('/logout', [AuthenticatorController::class, 'logout']);
});

//Route::post('/auth/login', [AuthenticatorController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserController::class, 'changePassword']);

    Route::post('/import/students', [StudentController::class, 'importStudentsFromExcel']);

    Route::prefix('/students')->group(function () {
        Route::get('/getStudentsByTeacher/{idTeacher}', [StudentController::class, 'getStudentsByTeacher']);
        Route::get('/getStudentsById/{idStudent}', [StudentController::class, 'getStudentById'])->name('get-students-by-id');
    });

    Route::prefix('/groups')->group(function () {
        Route::post('/create', [GroupController::class, 'store'])->name('groups.create');
        Route::get('/getGroup/{idGroup}', [GroupController::class, 'getGroup'])->name('get-group');
        Route::get('/getLetters', [GroupController::class, 'getLetters'])->name('get-letters');
        Route::get('/getMyGroupsByTeacher/{idTeacher}', [GroupController::class, 'getMyGroupsByTeacher'])->name('get-group-teacher');
    });

    Route::post('/sendEmail',[MailController::class, 'sendEmail']);

    Route::get('/view', function () {
        return view('email.notification', ['message' => 'Este es un mensaje dinámico']);
    });

//ROUTES FOR FORMS
    Route::prefix('/form')->group(function () {
        Route::post('/initForm', [FormController::class, 'initForm']);
        Route::post('/getFormResults', [FormController::class, 'getFormResults']);
        Route::post('/calculateDataCesc', [FormController::class, 'calculateDataCesc']);
    });

    Route::get('/login', function () {
        return response()->json(['error' => 'Not authenticated']);
    })->name('login');

    Route::get('/test', [TestController::class, 'test']);
});

Route::prefix('/pdf')->group(function () {
   Route::post('/student', [StudentController::class, 'exportStudentsToPDF'])->name('pdf-student');
});


Route::get('/test', [TestController::class, 'test']);
Route::get('form/getForm/{idForm}', [FormController::class, 'getForm']);
Route::post('form/checkUserInGroup', [FormController::class, 'checkUserInGroup']);
Route::post('form/submitForm', [FormAnswerUserController::class, 'submitForm']);
