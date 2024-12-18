<?php

namespace App\Services;

use App\Models\FormAnswerTotal;

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
     * Answers has to be like: [{category: '(socPlus, socMinus, ar, etc)', answer: [1,5,3](user_ids)}]
     */
    public function updateAnswer($form_id, $answers)
    {
        // Lista de categorías relevantes
        $categories = [
            'socPlus', 'socMinus', 'ar', 'af', 'av', 'pro', 'vf', 'vv', 'vr'
        ];

        $results = [];

        $groupedAnswers = $answers->groupBy(function ($answer) {
            return $answer->category;
        });

        foreach ($categories as $category) {
            $answersForCategory = $groupedAnswers->get($category, collect());

            foreach ($answersForCategory as $answer) {
                $user_ids = $answer->answer; // IDs de los usuarios dentro de esta respuesta

                foreach ($user_ids as $user_id) {
                    // Obtener el formAnswerTotal correspondiente
                    $formAnswerTotal = $this->getFormAnswerTotal($form_id, $user_id);

                    if ($formAnswerTotal) {
                        $parsedData = json_decode($formAnswerTotal->result, true);

                        if (isset($parsedData[$category])) {
                            $parsedData[$category] += 1;
                            $formAnswerTotal->result = json_encode($parsedData);
                            $formAnswerTotal->save();
                        }
                    }
                }
            }
        }

        return $results;
    }

    private function getFormAnswerTotal($form_id, $user_id)
    {
        return FormAnswerTotal::where('form_id', $form_id)->where('user_id', $user_id)->first();
    }


}
