<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Models\Questions;
use App\Http\Controllers\FormController;

// Route::middleware('auth')->group(function () {
//     // Mostrar el formulario
//     Route::get('/form/{formId}', [FormController::class, 'showForm'])->name('showForm');

//     // Enviar respuestas del formulario
//     Route::post('/form/{formId}', [FormController::class, 'submitForm'])->name('submitForm');
// });

Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
Route::post('/forms', [FormController::class, 'store'])->name('forms.store');
Route::get('/forms/{id}/edit', [FormController::class, 'edit'])->name('forms.edit');
Route::put('/forms/{id}', [FormController::class, 'update'])->name('forms.update');


// Route::get('/screen', [QuestionsController::class,'create'])->name('create');
// Route::get('forms/create', [QuestionsController::class, 'create'])->name('forms.create');
// Route::post('forms/store', [QuestionsController::class, 'store'])->name('forms.store');

Route::get('/', function () {
    return view('welcome');
});
