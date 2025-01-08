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
        $formAnswersTotal = FormAnswerTotal::where('form_id', $form_id)->get();

        $SocPlus_array = [];
        $SocMinus_array = [];
        $ar_array = [];
        $pros_array = [];
        $af_array = [];
        $av_array = [];
        $vf_array = [];
        $vv_array = [];
        $vr_array = [];
        $am_array = [];

        $TotA = [];


        foreach ($formAnswersTotal as $formAnswerTotal) {
            $data = json_decode($formAnswerTotal->result);
            $SocPlus_array []= $data->socPlus;
            $SocMinus_array []= $data->socMinus;
            $ar_array []= $data->ar;
            $pros_array []= $data->pro;
            $af_array []= $data->af;
            $av_array []= $data->av;
            $vf_array []= $data->vf;
            $vv_array []= $data->vv;
            $vr_array []= $data->vr;
            $am_array []= $data->am;


            $TotA [] = ($data->ar/2) + $data->af+$data->av;

        }

        $SocPlus_media = $this->media($SocPlus_array);
        $SocMinus_media = $this->media($SocMinus_array);
        $ar_media = $this->media($ar_array);
        $pros_media = $this->media($pros_array);
        $af_media = $this->media($af_array);
        $av_media = $this->media($av_array);
        $vf_media = $this->media($vf_array);
        $vv_media = $this->media($vv_array);
        $vr_media = $this->media($vr_array);
        $am_media = $this->media($am_array);

        $SocPlus_desv_estandar = $this->des_estandar($SocPlus_array);
        $SocMinus_desv_estandar = $this->des_estandar($SocMinus_array);
        $ar_desv_estandar = $this->des_estandar($ar_array);
        $pros_desv_estandar = $this->des_estandar($pros_array);
        $af_desv_estandar = $this->des_estandar($af_array);
        $av_desv_estandar = $this->des_estandar($av_array);
        $vf_desv_estandar = $this->des_estandar($vf_array);
        $vv_desv_estandar = $this->des_estandar($vv_array);
        $vr_desv_estandar = $this->des_estandar($vr_array);
        $am_desv_estandar = $this->des_estandar($am_array);


        //TOTAL AGRESIVITAT


        //Z TOT A si es > 1 es una X en total agressivitat
        $media_TotA = $this->media($TotA);
        $desv_estandar_TotA = $this->des_estandar($TotA);

        $Z_Tot_A = [];

        foreach ($TotA as $value) {
            $Z_Tot_A[] = $this->normalizacion($value, $media_TotA, $desv_estandar_TotA);
        }

        //columna Z5 recorrer esta columna(array) si es > 1 es una X en agressivitat fisica
        $Z5 = [];
        foreach($af_array as $value){
            $Z5[] = $this->normalizacion($value, $af_media, $af_desv_estandar);
        }

        //columna Z8 reccorer esta columna(array) si > 1 es una X en agressivitat verbal
        $Z8 = [];
        foreach($av_array as $value){
            $Z8[] = $this->normalizacion($value, $av_media, $av_desv_estandar);
        }

        //columna ZAR reccorer esta columna(array) si > 1 es una X en agressivitat relacional
        $Z_AR = [];
        foreach($ar_array as $value){
            $Z_AR[] = $this->normalizacion($value, $ar_media, $ar_desv_estandar);
        }

        //columna Z PROS reccorer esta columna(array) si > 1 es una X en Prosocialitat
        $Z_Pros = [];
        foreach ($pros_array as $value){
            $Z_Pros[] = $this->normalizacion($value, $pros_media, $pros_desv_estandar);
        }
    }

    private function normalizacion($num_normalizar, $media, $desv_estandar)
    {
        if ($desv_estandar == 0) {
            throw new \InvalidArgumentException("La desviación estándar no puede ser cero.");
        }

        return ($num_normalizar - $media) / $desv_estandar;
    }

    private function media($values)
    {
        $coleccion = collect($values);

        return $coleccion->avg();
    }

    private function des_estandar(array $numeros)
    {
        $coleccion = collect($numeros);

        $promedio = $coleccion->avg();

        $sumaDiferenciasCuadrado = $coleccion->map(function ($valor) use ($promedio) {
            return pow($valor - $promedio, 2);
        })->sum();

        $desviacionEstandar = sqrt($sumaDiferenciasCuadrado / $coleccion->count());

        return $desviacionEstandar;
    }
    private function getFormAnswerTotal($form_id, $user_id)
    {
        return FormAnswerTotal::where('form_id', $form_id)->where('user_id', $user_id)->first();
    }


}
