<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function create(Request $request)
    {
        $user = User::findOrFail(1);// Usuario autenticado
        //dd(vars: $user);
        $groupId = $user->idGroup; // Grupo del usuario autenticado

        // Obtener estudiantes del mismo grupo excluyendo al respondiente
        $students = User::where('idGroup', $groupId)
                        ->where('id', '!=', $user->id)
                        ->get();

        return view('create', compact('students', 'groupId'));
    }

    public function store(Request $request)
    {

        //dd($request);
        $request->validate([
            'responses' => 'required|array',
        ]);

        //$user = Auth::user();
        $user = User::findOrFail(1);// Usuario autenticado


        foreach ($request->responses as $questionId => $response) {
        Questions::create([
            'id' => $questionId,         // ID de la pregunta
            'idUser' => $user->id,       // ID del usuario que responde
            'idGroup' => $user->idGroup, // Grupo del usuario
            //'question' =>
            'answers' => $response,      // Respuesta específica
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Formulario enviado con éxito.');
    }
}
