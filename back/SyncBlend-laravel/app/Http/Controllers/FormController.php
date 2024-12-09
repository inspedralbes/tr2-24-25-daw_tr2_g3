<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Questions;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'questions' => 'array',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*' => 'required|string',
        ]);

        // Crear el formulario
        $form = Form::create(['name' => $request->name]);

        // Crear las preguntas asociadas
        foreach ($request->questions as $questionData) {
            $question = Questions::create([
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
            ]);

            // Asociar la pregunta al formulario
            $form->questions()->attach($question->id);
        }

        return redirect()->route('forms.index')->with('success', 'Formulario creado exitosamente.');
    }

    public function edit($id)
{
    $form = Form::with('questions')->findOrFail($id);
    return view('forms.edit', compact('form'));
}

public function update(Request $request, $id)
{
    $form = Form::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'questions' => 'array',
        'questions.*.question' => 'required|string|max:255',
        'questions.*.answers' => 'required|array',
        'questions.*.answers.*' => 'required|string',
    ]);

    // Actualizar el formulario
    $form->update(['name' => $request->name]);

    // Procesar las preguntas
    $existingQuestionIds = $form->questions->pluck('id')->toArray();
    $updatedQuestionIds = [];

    foreach ($request->questions as $questionData) {
        if (isset($questionData['id'])) {
            // Actualizar pregunta existente
            $question = Questions::findOrFail($questionData['id']);
            $question->update([
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
            ]);
            $updatedQuestionIds[] = $question->id;
        } else {
            // Crear nueva pregunta
            $newQuestion = Questions::create([
                'question' => $questionData['question'],
                'answers' => $questionData['answers'],
            ]);
            $form->questions()->attach($newQuestion->id);
            $updatedQuestionIds[] = $newQuestion->id;
        }
    }

    // Eliminar preguntas eliminadas en el formulario
    $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
    if (!empty($questionsToDelete)) {
        Questions::whereIn('id', $questionsToDelete)->delete();
    }

    return redirect()->route('forms.index')->with('success', 'Formulario actualizado exitosamente.');
}


    public function index()
    {
        $forms = Form::with('questions')->get();
        return view('forms.index', compact('forms'));
    }
}
