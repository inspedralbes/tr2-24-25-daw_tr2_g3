<?php

use Illuminate\Support\Facades\Route;

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
