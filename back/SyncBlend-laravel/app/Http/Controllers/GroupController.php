<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //
    public function index()
    {
        $groups = Group::where('id_user', Auth::user()->id)->get();
        return response()->json($groups);
    }

    public function store(Request $request){
        try {
            $data = $request->validate([
                'id_parent' => 'required',
                'code' => 'required',
                'course' => 'required',
            ],
                [
                    'id_parent.required' => 'El id parento es requerido',
                    'name.required' => 'El nombre es requerido',
                    'course.required' => 'El course es requerido',
                ]);

            $group = new Group();
            $group->id_parent = $data['id_parent'];
            $group->code = $data['code'];
            $group->course = $data['course'];
            $group->save();

            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $group
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update($id, Request $request){
        try {
            $group = Group::findOrFail($id);

            if($request->has('course')){
                $group->course = $request->input('course');
            }

            $group->save();
            return response()->json([
                'status' => 'success',
                'message' => 'El registro se guardo correctamente',
                'data' => $group
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id){
        try {
            $group = Group::findOrFail($id);
            $group->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'El registro se elimino correctamente',
            ]);
        }catch( \Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
