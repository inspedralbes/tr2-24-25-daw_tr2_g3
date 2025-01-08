<?php

namespace App\Http\Controllers;

use App\Models\FormAnswerUser;
use App\Services\FormAnswerTotalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormAnswerUserController extends Controller
{
    //
    public function submitForm(Request $request)
    {
        try{
            $data = $request->validate([
                'form_id' => 'required',
                'answers' => 'required'
            ],
            [
                'form_id.required' => 'El campo id es obligatorio',
                'answers.required' => 'El campo es obligatorio'
            ]);

//            $user = Auth::user();
//
            $formAnswerUser = new FormAnswerUser();
            $formAnswerUser->form_id = $data['form_id'];
            $formAnswerUser->user_id = $request->input('user_id');
            $formAnswerUser->answer = json_encode($data['answers']);
            $formAnswerUser->save();

            $formAnswerTotalService = new FormAnswerTotalService();
            $formAnswerTotalService->updateAnswer($data['form_id'], $data['answers']);

            return response()->json([
                'status' => 'success',
                'message' => 'Formulario enviado correctamente'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
