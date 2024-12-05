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

    public function index()
    {
        $forms = Form::with('questions')->get();
        return view('forms.index', compact('forms'));
    }
}
