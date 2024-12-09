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
        'group_id' => 'required|exists:groups,id',
        'name' => 'required|string|max:255',
        'slug' => 'required|string|unique:forms,slug|max:255',
        'code' => 'required|string|unique:forms,code|max:255',
        'description' => 'nullable|string',
        'questions' => 'array',
        'questions.*.question' => 'required|string|max:255',
        'questions.*.answers' => 'required|array',
        'questions.*.answers.*' => 'required|string',
    ]);
    dd($request->group_id);
    $form = Form::create([
        'group_id' => $request->group_id,
        'name' => $request->name,
        'slug' => $request->slug,
        'code' => $request->code,
        'description' => $request->description,
    ]);

    foreach ($request->questions as $questionData) {
        $question = Questions::create([
            'group_id' => $request->group_id,
            'question' => $questionData['question'],
            'answers' => $questionData['answers'],
        ]);
        $form->questions()->attach($question->id);
    }
    return response()->json([
        'success' => true,
        'message' => 'Formulario creado exitosamente.',
        'form' => $form,
    ]);
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
            'group_id' => 'required|exists:groups,id',
            'name' => 'required|string|max:255',
            'slug' => "required|string|unique:forms,slug,$id|max:255",
            'code' => "required|string|unique:forms,code,$id|max:255",
            'description' => 'nullable|string',
            'questions' => 'array',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*' => 'required|string',
        ]);

        // Actualizar el formulario
        $form->update([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        // Procesar las preguntas
        $existingQuestionIds = $form->questions->pluck('id')->toArray();
        $updatedQuestionIds = [];

        foreach ($request->questions as $questionData) {
            if (!empty($questionData['id'])) {
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
                    'group_id' => $request->group_id,
                    'question' => $questionData['question'],
                    'answers' => $questionData['answers'],
                ]);
                $form->questions()->attach($newQuestion->id);
                $updatedQuestionIds[] = $newQuestion->id;
            }
        }

        // Eliminar preguntas que ya no están en el formulario
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
