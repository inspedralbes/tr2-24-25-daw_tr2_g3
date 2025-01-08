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
        try {

            foreach ($usersIds as $userId) {
                $formAnswerTotal = new FormAnswerTotal();
                $formAnswerTotal->user_id = $userId;
                $formAnswerTotal->form_id = $form_id;
                $formAnswerTotal->result = json_encode(
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
                );
                $formAnswerTotal->save();
            }

            return $formAnswerTotal;
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
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
        foreach ($answers as $answer) {
            foreach ($answer['students_id'] as $studentId) {
                $formAnswerTotal = FormAnswerTotal::where("form_id", $form_id)->where("user_id", $studentId)->first();
                $question = Questions::findOrFail($answer['question_id']);

                $result = json_decode($formAnswerTotal->result);

                switch ($question->category) {
                    case "socPlus":
                        $result->socPlus++;
                        break;
                    case "socMinus":
                        $result->socMinus++;
                        break;
                    case "ar":
                        $result->ar++;
                        break;
                    case "pro":
                        $result->pro++;
                        break;
                    case "af":
                        $result->af++;
                        break;
                    case "av":
                        $result->av++;
                        break;
                    case "vf":
                        $result->vf++;
                        break;
                    case "vv":
                        $result->vv++;
                        break;
                    case "vr":
                        $result->vr++;
                        break;
                    case "am":
                        $result->am++;
                        break;
                    default:
                        break;
                }

                $formAnswerTotal->result = json_encode($result);
                $formAnswerTotal->save();
            }
        }
    }

    public function calculateFormResults($form_id)
    {
        //calculate AGRESSIVITAT

    }

    private function normalizacion()
    {
        
    }

    private function getFormAnswerTotal($form_id, $user_id)
    {
        return FormAnswerTotal::where('form_id', $form_id)->where('user_id', $user_id)->first();
    }


}
