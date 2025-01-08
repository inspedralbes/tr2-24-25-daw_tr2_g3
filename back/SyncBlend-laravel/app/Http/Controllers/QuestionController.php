<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'group_id' => 'required',
                'question' => 'required',
            ],
            [
                'group_id.required' => 'El campo grupo es obligatorio',
                'question.required' => 'El campo pregunta es obligatorio',
            ]);

            $question = new Questions();
            $question->group_id = $data['group_id'];
            $question->question = $data['question'];
            if($request->has('answer')){
                $question->answers = $data['answer'];
            }

            $question->save();

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $question
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @param $idQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $idQuestion)
    {
        try{
            $question = Questions::findOrFail($idQuestion);

            if($request->has('question')){
                $question->question = $request->input('question');
            }

            if($request->has('answer')){
                $question->answers = $request->input('answer');
            }

            $question->save();
            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $question
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idQuestion)
    {
        try {
            $question = Questions::findOrFail($idQuestion);
            $question->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se elimino correctamente',
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestion($idQuestion)
    {
        try{
            $question = Questions::findOrFail($idQuestion);

            return response()->json([
                'status' => 'success',
                'message' => 'Se encontro la pregunta correctamente',
                'data' => $question
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


}
