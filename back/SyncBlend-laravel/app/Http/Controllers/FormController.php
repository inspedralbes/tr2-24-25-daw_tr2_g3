<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAnswerTotal;
use App\Models\FormResult;
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
            $form = Form::with('questions')->findOrFail($idForm);
            $idQuestions = $form->questions->pluck('id')->toArray();
            $group = Group::with('members')->where('id', $form->group_id)->first();

            $questions = Questions::whereIn('id',$idQuestions)->get();
            $students = User::whereIn('id', $group->members->pluck('id'))->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Formulario encontrado',
                'questions' => $questions,
                'students' => $students
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
            $form = Form::findOrFail($request->input('form_id'));
            if(!$form->active){
                $group = Group::with(['members', 'members.user' => function ($query) {
                    $query->select('id');
                }
                ])->findOrFail($request->input('group_id'));

                $usersIds = $group->members->pluck('user_id');

                $formAnswerTotalService = new FormAnswerTotalService();
                $formAnswerTotalService->createFormAnswerTotal($form->id, $usersIds);

                $form->active = true;
                $form->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Formulario iniciado correctamente',
                    'data' =>$formAnswerTotalService
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'El formulario ya esta iniciado',
                ]);
            }


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
            $form = Form::with('questions')->findOrFail($form_id);

            $formAnswerTotalService = new FormAnswerTotalService();
            $formAnswerTotalService->calculateFormResults($form_id);

            $formResults = FormResult::with('user')
                ->where('form_id', $form_id)
                ->where('group_id', $form->group_id)
                ->get();

            if($formResults->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Formulario no encontrado'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Formulario calculado correctamente',
                    'formResults' => $formResults
                ]);
            }
        }catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function checkUserInGroup(Request $request)
    {
        try {
            // Obtener el grupo y sus miembros
            $group = Group::with(['members', 'members.user' => function ($query) {
                $query->select('id', 'email');
            }])->where('code', $request->get('group_code'))->first();

            if (!$group) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Group not found'
                ]);
            }

            $idsMembers = $group->members->pluck('id')->toArray();
            $users = User::whereIn('id', $idsMembers)->get();

            // Buscar si el usuario con el email existe en el grupo
            $userFound = $users->firstWhere('email', $request->input('email'));

            if ($userFound) {
                return response()->json([
                    'status' => 'success',
                    'exists' => true,
                    'user_id' => $userFound->id // Retorna el id del usuario
                ]);
            }

            return response()->json([
                'status' => 'success',
                'exists' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getFormResults(Request $request)
    {
        try{
            $formResults = FormResult::with('user')
                ->where('form_id', $request->input('form_id'))
                ->where('group_id', $request->input('group_id'))
                ->get();

            if($formResults->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Formulario no encontrado'
                ]);
            }else{
                return response()->json([
                    'status' => 'success',
                    'message' => 'Formulario encontrado',
                    'formResults' => $formResults
                ]);
            }

        }catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

}
