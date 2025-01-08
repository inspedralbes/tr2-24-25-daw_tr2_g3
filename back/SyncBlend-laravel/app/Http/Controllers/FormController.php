<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAnswerTotal;
use App\Models\Group;
use App\Models\GroupMemeber;
use App\Models\QuestionForm;
use App\Models\Questions;
use App\Models\User;
use App\Services\FormAnswerTotalService;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Symfony\Component\Console\Question\Question;
use App\Helpers\GeneralHelper;


class FormController extends Controller
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
                'name' => 'required',
                'description' => 'required',
            ],
                [
                    'group_id.required' => 'El campo grupo es obligatorio',
                    'name.required' => 'El campo nombre es obligatorio',
                    'description.required' => 'El campo descripcion es obligatorio',
                ]);

            $form = new Form();
            $form->group_id = $data['group_id'];
            $form->name = $data['name'];
            $form->slug = GeneralHelper::generateSlug($data['name']);
            $form->description = $data['description'];
            $form->save();

            $form->code = GeneralHelper::generateCode("FOR", $form->id);
            $form->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Formulario creado correctamente',
                'form' => $form
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @param $idForm
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(Request $request, $idForm)
    {
        try {
            $form = Form::findOrFail($idForm);

            if ($request->has('name')) {
                $form->name = $request->get('name');
            }

            if ($request->has('description')) {
                $form->description = $request->get('description');
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idForm
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idForm)
    {
        try {
            $questionsForm = QuestionForm::where('id_form', $idForm)->get();
            foreach ($questionsForm as $question) {
                $question->delete();
            }

            $form = Form::findOrFail($idForm);
            $form->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Formulario eliminado correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idForm
     * @return \Illuminate\Http\JsonResponse
     */
    public function getForm($idForm)
    {
        try {
            $form = Form::with('questions.getQuestion')->findOrFail($idForm);

            return response()->json([
                'status' => 'success',
                'message' => 'Formulario encontrado',
                'form' => $form
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function initForm(Request $request)
    {
        try {
            $group = Group::with(['members', 'members.user' => function ($query) {
                $query->select('id');
            }
            ])->findOrFail($request->input('group_id'));
            $form = Form::findOrFail($request->input('form_id'));

            $usersIds = $group->members->pluck('user_id');

            $formAnswerTotalService = new FormAnswerTotalService();
            $formAnswerTotalService->createFormAnswerTotal($form->id, $usersIds);

            return response()->json([
                'status' => 'success',
                'message' => 'Formulario iniciado correctamente',
                'data' =>$formAnswerTotalService
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function calculateDataCesc(Request $request)
    {
        try{
            $form_id = $request->input('form_id') ?? null;
            $formAnswerTotalService = new FormAnswerTotalService();
            $formAnswerTotalService->calculateFormResults($form_id);
        }catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
