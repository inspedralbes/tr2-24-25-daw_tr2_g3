<?php

namespace App\Services;

use app\Helpers\GeneralHelper;
use App\Models\Form;
use App\Models\QuestionForm;
use App\Models\Questions;

class CESCWizardDefaultService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function creatFormCESC($group_id)
    {
//        'socPlus', 'socMinus', 'ar', 'af', 'av', 'pro', 'vf', 'vv', 'vr'
        $questions = [
            [
                "question" => "Me cae bien",
                "category" => "socPlus"
            ],
            [
                "question" => "No me cae bien",
                "category" => "socMinus"
            ],
            [
                "question" => "Difunde rumores",
                "category" => "ar"
            ],
            [
                "question" => "Ayuda a los demas",
                "category" => "pro"
            ],
            [
                "question" => "Da empujones",
                "category" => "af"
            ],
            [
                "question" => "No deja participar",
                "category" => "ar"
            ],
            [
                "question" => "Anima a los demás",
                "category" => "por"
            ],
            [
                "question" => "Insulta",
                "category" => "av"
            ],
            [
                "question" => "¿A quién dan empujones?",
                "category" => "vf"
            ],
            [
                "question" => "¿A quién insultan o ridiculizan?",
                "category" => "vv"
            ],
            [
                "question" => "¿A quién no dejan participar?",
                "category" => "vr"
            ],
            [
                "question" => "Mis amigos / amigas",
                "category" => "am"
            ]
        ];
        $newForm = new Form();
        $newForm->group_id = $group_id;
        $newForm->name = "CESC Form ESO";
        $newForm->slug = GeneralHelper::generateSlug("CESC Form ESO");
        $newForm->description = "Aquest es el formulari que dona el CESC";
        $newForm->save();

        $newForm->code = GeneralHelper::generateCode("FOR" ,$group_id);
        $newForm->save();

        // Recorrer el array de preguntas y añadirlas al formulario
        foreach ($questions as $item) {
            $question = new Questions();
            $question->group_id = $group_id;
            $question->question = $item['question']; // Acceder a 'question'
            $question->category = $item['category']; // Acceder a 'category'
            $question->save();

            // Asociar la pregunta al formulario (QuestionForm es una tabla intermedia, asumiendo relaciones)
            $questionsForm = new QuestionForm();
            $questionsForm->id_form = $newForm->id; // ID del formulario creado
            $questionsForm->id_question = $question->id; // ID de la pregunta creada
            $questionsForm->save();
        }

    }

}
