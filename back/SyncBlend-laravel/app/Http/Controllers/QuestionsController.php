<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Group;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Listar preguntas opcionalmente filtradas por grupo
        $groupId = $request->get('group_id');
        $questions = Questions::when($groupId, function ($query) use ($groupId) {
            return $query->where('group_id', $groupId);
        })->get();

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        // Obtener todos los grupos para asignar la pregunta a uno
        $groups = Group::all();
        return view('questions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'question' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:255',
        ]);

        // Crear la pregunta
        Questions::create([
            'group_id' => $request->group_id,
            'question' => $request->question,
            'answers' => $request->answers,
        ]);

        return redirect()->route('questions.index')->with('success', 'Pregunta creada exitosamente.');
    }

    public function edit($id)
    {
        // Obtener la pregunta y los grupos disponibles
        $question = Questions::findOrFail($id);
        $groups = Group::all();

        return view('questions.edit', compact('question', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $question = Questions::findOrFail($id);

        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'question' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:255',
        ]);

        // Actualizar la pregunta
        $question->update([
            'group_id' => $request->group_id,
            'question' => $request->question,
            'answers' => $request->answers,
        ]);

        return redirect()->route('questions.index')->with('success', 'Pregunta actualizada exitosamente.');
    }

    public function destroy($id)
    {
        // Eliminar la pregunta y sus relaciones
        $question = Questions::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Pregunta eliminada exitosamente.');
    }
}
