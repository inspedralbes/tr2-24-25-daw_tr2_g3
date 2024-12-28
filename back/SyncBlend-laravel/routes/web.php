<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

// Route::middleware('auth')->group(function () {
//     // Mostrar el formulario
//     Route::get('/form/{formId}', [FormController::class, 'showForm'])->name('showForm');

//     // Enviar respuestas del formulario
//     Route::post('/form/{formId}', [FormController::class, 'submitForm'])->name('submitForm');
// });



// Route::get('/screen', [QuestionsController::class,'create'])->name('create');
// Route::get('forms/create', [QuestionsController::class, 'create'])->name('forms.create');
// Route::post('forms/store', [QuestionsController::class, 'store'])->name('forms.store');

Route::get('/', function () {
    return view('welcome');
});


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

