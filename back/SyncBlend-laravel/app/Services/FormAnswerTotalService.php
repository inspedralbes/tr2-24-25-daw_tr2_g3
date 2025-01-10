<?php

namespace App\Services;

use App\Models\FormAnswerTotal;
use App\Models\FormResult;
use App\Models\Questions;
use Illuminate\Support\Facades\Log;

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

    public function calculateFormResults($form_id, $group_id = null)
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
        $Z_Tot_V = [];
        $Prefer = [];
        $Impac = [];

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
            $Z_Tot_V[] = $data->vf+$data->vv+$data->vr;
            $Prefer [] = $data->socPlus-$data->socMinus;
            $Impac[] = $data->socPlus+$data->socMinus;
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

        $media_TotA = $this->media($TotA);
        $desv_estandar_TotA = $this->des_estandar($TotA);

        $media_Z_Tot_V = $this->media($Z_Tot_V);
        $desv_estandar_Z_Tot_V = $this->des_estandar($Z_Tot_V);

        $media_Prefer = $this->media($Prefer);
        $desv_estandar_Prefer = $this->des_estandar($Prefer);

        $media_Impac = $this->media($Impac);
        $desv_estandar_Impac = $this->des_estandar($Impac);

        // Log de los resultados de las medias
        \Log::info('Medias calculadas:', [
            'SocPlus_media' => $SocPlus_media,
            'SocMinus_media' => $SocMinus_media,
            'ar_media' => $ar_media,
            'pros_media' => $pros_media,
            'af_media' => $af_media,
            'av_media' => $av_media,
            'vf_media' => $vf_media,
            'vv_media' => $vv_media,
            'vr_media' => $vr_media,
            'am_media' => $am_media,
            'media_Prefer' => $media_Prefer,
            'media_Impac' => $media_Impac,
        ]);

        // Log de los resultados de las desviaciones estándar
        \Log::info('Desviaciones estándar calculadas:', [
            'SocPlus_desv_estandar' => $SocPlus_desv_estandar,
            'SocMinus_desv_estandar' => $SocMinus_desv_estandar,
            'ar_desv_estandar' => $ar_desv_estandar,
            'pros_desv_estandar' => $pros_desv_estandar,
            'af_desv_estandar' => $af_desv_estandar,
            'av_desv_estandar' => $av_desv_estandar,
            'vf_desv_estandar' => $vf_desv_estandar,
            'vv_desv_estandar' => $vv_desv_estandar,
            'vr_desv_estandar' => $vr_desv_estandar,
            'am_desv_estandar' => $am_desv_estandar,
            'media_TotA' => $media_TotA,
            'media_Prefer' => $media_Prefer,
            'media_Impac' => $media_Impac,
        ]);

//        //TOTAL AGRESIVITAT FISICA
//
//        //Z TOT A si es > 1 es una X en total agressivitat
//
//        $Z_Tot_A = [];
//
//        foreach ($TotA as $value) {
//            $Z_Tot_A[] = $this->normalizacion($value, $media_TotA, $desv_estandar_TotA);
//        }
//
//        //columna Z5 recorrer esta columna(array) si es > 1 es una X en agressivitat fisica
//        $Z5 = [];
//        foreach($af_array as $value){
//            $Z5[] = $this->normalizacion($value, $af_media, $af_desv_estandar);
//        }
//
//        //columna Z8 reccorer esta columna(array) si > 1 es una X en agressivitat verbal
//        $Z8 = [];
//        foreach($av_array as $value){
//            $Z8[] = $this->normalizacion($value, $av_media, $av_desv_estandar);
//        }
//
//        //columna ZAR reccorer esta columna(array) si > 1 es una X en agressivitat relacional
//        $Z_AR = [];
//        foreach($ar_array as $value){
//            $Z_AR[] = $this->normalizacion($value, $ar_media, $ar_desv_estandar);
//        }
//
//        //columna Z PROS reccorer esta columna(array) si > 1 es una X en Prosocialitat
//        $Z_Pros = [];
//        foreach ($pros_array as $value){
//            $Z_Pros[] = $this->normalizacion($value, $pros_media, $pros_desv_estandar);
//        }


        foreach ($formAnswersTotal as $index => $formAnswerTotal) {
            // Normalización de las respuestas agresivitat
            $normalizacionTotalAgresivitat = $this->normalizacion($TotA[$index], $media_TotA, $desv_estandar_TotA);
            $normalizacionAf = $this->normalizacion($af_array[$index], $af_media, $af_desv_estandar);
            $normalizacionAv = $this->normalizacion($av_array[$index], $av_media, $av_desv_estandar);
            $normalizacionAr = $this->normalizacion($ar_array[$index], $ar_media, $ar_desv_estandar);
            $normalizacionProsocialitat = $this->normalizacion($pros_array[$index], $pros_media, $pros_desv_estandar);

            // Normalización de las respuestas victimizacion
            $normalizacionTotalVictimizacio = $this->normalizacion($Z_Tot_V[$index], $media_Z_Tot_V, $desv_estandar_Z_Tot_V);
            $normalizacionVf = $this->normalizacion($vf_array[$index], $vf_media, $vf_desv_estandar);
            $normalizacionVv = $this->normalizacion($vv_array[$index], $vv_media, $vv_desv_estandar);
            $normalizacionVr = $this->normalizacion($vr_array[$index], $vr_media, $vr_desv_estandar);

            // Normalizacion para revisar el pop
            $Z_Prefer = $this->normalizacion($Prefer[$index], $media_Prefer, $desv_estandar_Prefer);
            $pop_Z_Prefer = $Z_Prefer>1 ? 1:0;

            $Z_Soc_Plus = $this->normalizacion($SocPlus_array[$index], $SocPlus_media, $SocPlus_desv_estandar);
            $pop_Z_Soc_Plus = $Z_Soc_Plus > 0 ? 1:0;

            $Z_Soc_Minus = $this->normalizacion($SocMinus_array[$index], $SocMinus_media, $SocMinus_desv_estandar);
            $pop_Z_Soc_Minus = $Z_Soc_Minus < 0 ? 1:0;

            //calcular rebutjat
            $reb_Z_Prefer = $Z_Prefer < -1 ? 1:0;
            $reb_Z_Soc_Minus = $Z_Soc_Minus > 0 ? 1:0;
            $reb_Z_Soc_Plus = $Z_Soc_Plus < 0 ? 1:0;

            //calcular ignorat
            $Z_Impac = $this->normalizacion($Impac[$index], $media_Impac, $desv_estandar_Impac);
            $ign_Z_Impac = $Z_Impac<-1 ? 1:0;
            $ign_Z_Soc_Plus = $Z_Soc_Plus < 0 ? 1:0;
            $ign_Z_Soc_Minus = $Z_Soc_Minus < 0 ? 1:0;

            //calcular controvertit
            $con_Z_Impac = $Z_Impac > 1 ? 1:0;
            $con_Z_Soc_Minus = $Z_Soc_Minus > 0 ? 1:0;
            $con_Z_Soc_Plus = $Z_Soc_Plus > 0 ? 1:0;

            //calcular normatiu
            $nor_Z_Soc_Plus = $Z_Soc_Plus < -0.5 ? 1:0;
            $nor_Z_Soc_Plus_2 = $Z_Soc_Plus > 0.5 ? 1:0;
            $nor_Z_Soc_Minus = $Z_Soc_Minus < -0.5 ? 1:0;
            $nor_Z_Soc_Minus_2 = $Z_Soc_Minus > 0.5 ? 1:0;

            // Registrar las respuestas de la normalización
            Log::info("Respuesta de normalización para el índice $index:", [
                'TotA' => $normalizacionTotalAgresivitat,
                'af_array' => $normalizacionAf,
                'av_array' => $normalizacionAv,
                'ar_array' => $normalizacionAr,
                'pros_array' => $normalizacionProsocialitat,
                'Z_Soc_Plus' => $Z_Soc_Plus,
                'Z_Soc_Minus' => $Z_Soc_Minus,
                'media_Z_socPlus' => $media_Impac,
            ]);

            // Guardar los resultados
            $formResult = new FormResult();
            $formResult->form_id = $formAnswerTotal->form_id;
            $formResult->user_id = $formAnswerTotal->user_id;
            $formResult->group_id = $formAnswerTotal->form->group_id;
            $formResult->total_agresivitat_counter = ($ar_array[$index]/2)+$af_array[$index]+$av_array[$index];
            $formResult->agresivitat_fisica_counter = $af_array[$index];
            $formResult->agresivitat_verbal_counter = $av_array[$index];
            $formResult->agresivitat_relacional_counter = $ar_array[$index]/2;

            $formResult->total_agresivitat = $normalizacionTotalAgresivitat > 1 ? true : false;
            $formResult->agresivitat_fisica = $normalizacionAf > 1 ? true : false;
            $formResult->agresivitat_verbal = $normalizacionAv > 1 ? true : false;
            $formResult->agresivitat_relacional = $normalizacionAr > 1 ? true : false;
            $formResult->prosocialitat_counter = $pros_array[$index]/2;
            $formResult->prosocialitat = $normalizacionProsocialitat > 1 ? true : false;

            $formResult->total_victimizacio_counter = $vf_array[$index]+$vv_array[$index]+$vr_array[$index];
            $formResult->victimizacio_fisica_counter = $vf_array[$index];
            $formResult->victimizacio_verbal_counter = $vv_array[$index];
            $formResult->victimizacio_relacional_counter = $vr_array[$index];

            $formResult->total_victimizacion = $normalizacionTotalVictimizacio > 1 ? true : false;
            $formResult->victimizacion_fisica = $normalizacionVf > 1 ? true:false;
            $formResult->victimizacion_verbal = $normalizacionVv > 1 ? true:false;
            $formResult->victimizacion_relacional = $normalizacionVr > 1 ? true:false;

            $formResult->popular = $this->validateAndCalculate(
                [$pop_Z_Prefer, $pop_Z_Soc_Minus, $pop_Z_Soc_Plus],
                3
            );
            $formResult->rebutjat = $this->validateAndCalculate(
                [$reb_Z_Prefer, $reb_Z_Soc_Minus, $reb_Z_Soc_Plus],
                3
            );
            $formResult->ignorat = $this->validateAndCalculate(
                [$ign_Z_Impac, $ign_Z_Soc_Plus, $ign_Z_Soc_Minus],
                3
            );
            $formResult->controvertit = $this->validateAndCalculate(
                [$con_Z_Impac, $con_Z_Soc_Minus, $con_Z_Soc_Plus],
                3
            );
            $formResult->normatiu = $this->validateAndCalculate(
                [$nor_Z_Soc_Minus, $nor_Z_Soc_Minus_2, $nor_Z_Soc_Plus, $nor_Z_Soc_Plus_2],
                0
            );
            Log::info("normativo:", [
                'nor_Z_Soc_Minus' => $nor_Z_Soc_Minus,
                'nor_Z_Soc_Plus' => $nor_Z_Soc_Plus,
                'nor_Z_Soc_Minus_2' => $nor_Z_Soc_Minus_2,
                'nor_Z_Soc_Plus_2' => $nor_Z_Soc_Plus_2,
            ]);

            $formResult->tries_positives = $SocPlus_array[$index];
            $formResult->tries_negatives = $SocMinus_array[$index];

            $formResult->save();
        }
    }

    private function normalizacion($num_normalizar, $media, $desv_estandar)
    {
        if ($desv_estandar == 0) {
            return null;
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

    private function validateAndCalculate(array $values, int $expectedSum)
    {
        // Verifica si algún valor es null
        if (in_array(null, $values, true)) {
            return null;
        }

        // Realiza la comparación si todos los valores son válidos
        return array_sum($values) === $expectedSum;
    }

    private function getFormAnswerTotal($form_id, $user_id)
    {
        return FormAnswerTotal::where('form_id', $form_id)->where('user_id', $user_id)->first();
    }


}
