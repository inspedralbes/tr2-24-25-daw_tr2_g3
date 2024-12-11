<?php

namespace App\Http\Controllers;

use app\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use app\Imports\StudentsImport;
use App\Models\GroupMemeber;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //
    public function getStudentsByTeacher(Request $request,$idTeacher){
        try{
            $usersIds = GroupMemeber::where('user_id', $idTeacher)
                ->where('role', 'student')
                ->pluck('user_id')->toArray();

            $students = User::whereIn('id', $usersIds)->orderBy('name')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Lista de alumnos',
                'data' => $students
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function importStudentsFromExcel(Request $request)
    {
        try {


            return response()->json([
                'status' => 'success',
                'message' => 'Lista de alumnos'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function exportStudentsToExcel()
    {
        try{
            return response()->json([
                'status' => 'success',
                'message' => 'Lista de alumnos'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function calculateCesc()
    {

    }
}
