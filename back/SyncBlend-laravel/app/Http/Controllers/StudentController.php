<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\GroupMemeber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //
    public function getStudentsByTeacher($idTeacher)
    {
        try {
            $groupIds = GroupMemeber::where('user_id', $idTeacher)
                ->pluck('group_id')
                ->toArray();

            $usersIds = GroupMemeber::whereIn('group_id', $groupIds)
                ->where('role', 'student')
                ->pluck('user_id')
                ->toArray();

            $students = User::whereIn('id', $usersIds)
                ->orderBy('lastname', 'DESC')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Lista de alumnos',
                'data' => $students
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getStudentById($idStudent)
    {
        //ARRAYS DE IDS DE LOS GRUPOS
        $groupIds = GroupMemeber::where('user_id', $idStudent)
            ->where('role', 'student')
            ->pluck('group_id')->toArray();

        //dd($groupIds);
        //INFROMACION DEL GRUPO
        $groups = Group::with('tutor')->whereIn('id', $groupIds)->get();

        //INFROMACION DEL ESTUDIANTE
        $student = User::findorFail($idStudent);

        return response()->json(['status' => 'success', 'student' => $student, 'groups' => $groups]);
    }

    public function importStudentsFromExcel(Request $request)
    {
        try {
            $group = Group::findOrFail(2);
            $studentsImport = new StudentsImport($group);
            Excel::import($studentsImport, $request->file('file'));

            if (count($studentsImport->getErrors()) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $studentsImport->getErrors()
                ]);
            }

            $studentsImport->processImport();
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
        try {
            Excel::download(new StudentsExport, 'alumnos.xlsx');
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

    public function calculateCesc()
    {

    }
}
