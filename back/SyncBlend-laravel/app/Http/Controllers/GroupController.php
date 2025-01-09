<?php

namespace App\Http\Controllers;

use app\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMemeber;
use App\Services\CESCWizardDefaultService;
use Illuminate\Http\Request;
use App\Models\User;

class       GroupController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'course' => 'required',
                'letter' => 'required',
                'user_id' => 'required'
            ],
                [
                    'course.required' => "El campo course es requerido",
                    'letter.required' => "El campo letter es requerido",
                    'user_id.required' => 'El campo user_id es requerido'
                ]);

            $group = new Group();
            if ($request->has('id_parent')) {
                $group->id_parent = $request->input('id_parent');
            } else {
                $group->id_parent = 0;
            }
            $group->course = $data['course'];
            $group->letter = $data['letter'];
            $group->save();

            $group->code = GeneralHelper::generateCode('GR', $group->id);
            $group->save();

            $group = Group::with('members')->findOrFail($group->id);

            $group_members = new GroupMemeber();
            $group_members->group_id = $group->id;
            $group_members->user_id = $data['user_id'];
            $group_members->role = 'teacher';
            $group_members->save();

            $cescDefaultWizard = new CESCWizardDefaultService();
            $cescDefaultWizard->creatFormCESC($group->id);

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $group
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
     * @param $idGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $idGroup)
    {
        try {
            $group = Group::findOrFail($idGroup);

            if ($request->has('id_parent')) {
                $group->id_parent = $request->input('id_parent');
            }

            if ($request->has('course')) {
                $group->course = $request->input('course');
            }

            $group->save();

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $group
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idGroup)
    {
        try{
            $groupMembers = GroupMemeber::where('group_id', $idGroup)->get();

            foreach ($groupMembers as $groupMember) {
                $groupMember->delete();
            }

            $group = Group::findOrFail($idGroup);
            $group->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se elimino correctamente'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $idGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroup($idGroup)
    {
        $group = Group::with(['members', 'members.user'=> function ($query) {
            $query->select('id', 'name', 'email', 'type_document', 'id_document');
        }])->findOrFail($idGroup);
        return response()->json([
            'status' => 'success',
            'data' => $group
        ]);
    }

    public function getLetters()
    {
        $letters = Group::getLetters('groups', 'letter');
        return response()->json(['status' => 'success', 'data' => $letters]);
    }

    /**
     * @param $idTeacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyGroupsByTeacher($idTeacher)
    {
        try {
            $groupsIds = GroupMemeber::where('user_id', $idTeacher)
                ->where('role', 'teacher')
                ->pluck('group_id')->toArray();

            $groups = Group::with(['members', 'members.user'=> function ($query) {
                $query->select('id', 'name', 'email', 'type_document', 'id_document');
                     }
                ])->whereIn('id', $groupsIds)->get();

            return response()->json([
                'status' => 'success',
                'data' => $groups
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
