<?php

namespace app\Imports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToEach;
use Illuminate\Support\Facades\DB;
use App\Models\Student; // O el modelo que estés utilizando

class StudentsImport implements ToEach
{
    public function each($row)
    {
        // Envolvemos todo el procesamiento de cada fila en una transacción
        DB::transaction(function() use ($row) {
            try {
                // Lógica para procesar la fila y guardar los datos en la base de datos
                Log::info('Procesando fila', ['row' => $row]);
                // Puedes agregar más operaciones aquí, todo dentro de la transacción
            } catch (\Exception $e) {
                // Si ocurre un error, la transacción será revertida automáticamente
                // Maneja el error, por ejemplo, registrando el error
                Log::error('Error al procesar la fila: ', ['error' => $e->getMessage(), 'row' => $row]);
            }
        });
    }
}
