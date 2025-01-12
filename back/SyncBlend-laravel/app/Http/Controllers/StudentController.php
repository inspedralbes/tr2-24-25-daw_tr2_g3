<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\GroupMemeber;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use function Laravel\Prompts\select;

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

            $students = User::with(['groups' => function ($query) {
                $query->select('course', 'letter');
            }
            ])->whereIn('id', $usersIds)
                ->select('id', 'name', 'lastname', 'email', 'type_document', 'id_document')
                ->orderBy('lastname', 'ASC')
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

    public function exportStudentsToPDF(Request $request)
    {

        $students = $request->input('students');
        $groups = $request->input('groups');

        if (!$students || !$groups) {
            return response()->json(['error' => 'Datos incompletos'], 400);  // Devuelve un error si falta información
        }

        // Obtener la imagen y convertirla a base64
        $imageUrl = $students[0]['photo_pic'];
        $imageContent = file_get_contents($imageUrl);
        $base64Image = base64_encode($imageContent);
        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;


        $pdf = PDF::loadView('students.student', compact('students', 'groups','imageSrc'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Estudiantes.pdf"');

    }

    public function calculateCesc()
    {

    }
}
