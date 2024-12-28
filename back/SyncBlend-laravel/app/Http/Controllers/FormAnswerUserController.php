<?php

namespace App\Http\Controllers;

use App\Models\FormAnswerUser;
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
                'answer' => 'required'
            ],
            [
                'form_id.required' => 'El campo id es obligatorio',
                'answer.required' => 'El campo es obligatorio'
            ]);

//            $user = Auth::user();

//            $formAnswerUser = new FormAnswerUser();
//            $formAnswerUser->form_id = $data['form_id'];
//            $formAnswerUser->user_id = $request->input('user_id');
//            $formAnswerUser->answer = $data['answer'];
            return $request;
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
