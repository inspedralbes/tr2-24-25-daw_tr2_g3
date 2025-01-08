<?php

namespace App\Services;

use App\Models\FormAnswerTotal;
use App\Models\Questions;

class FormAnswerTotalService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createFormAnswerTotal($form_id, $usersIds)
    {
        try{

            foreach ($usersIds as $userId)
            {
                $formAnswerTotal = new FormAnswerTotal();
                $formAnswerTotal->user_id = $userId;
                $formAnswerTotal->form_id = $form_id;
                $formAnswerTotal->result = json_encode([
                    [
                        "socPlus" => 0,
                        "socMinus" => 0,
                        "ar" => 0,
                        "pro" => 0,
                        "af" => 0,
                        "av" => 0,
                        "vf" => 0,
                        "vv" => 0,
                        "vr" => 0,
                        "am" => 0
                    ]
                ]);
                $formAnswerTotal->save();
            }

            return $formAnswerTotal;
        }catch (\Exception $exception){
            return response()->json([
                'status'=> 'error',
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * @param int $form_id
     * @param $answers
     * @return array
     *
     */
    public function updateAnswer($form_id, $answers)
    {
        foreach ($answers as $answer){
            $formAnswerTotal = FormAnswerTotal::where("form_id", $form_id)->where("user_id", $answer->student_id)->first();
            $question = Questions::findOrFail($answer->question_id);

            $result = $formAnswerTotal->result;
            
        }
    }

    private function getFormAnswerTotal($form_id, $user_id)
    {
        return FormAnswerTotal::where('form_id', $form_id)->where('user_id', $user_id)->first();
    }


}
