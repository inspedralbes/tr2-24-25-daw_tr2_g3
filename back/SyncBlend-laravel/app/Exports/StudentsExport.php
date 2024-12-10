<?php

namespace app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTransactions;
use App\Models\Student; // O el modelo que estés utilizando
use Illuminate\Support\Facades\DB;

class StudentsExport implements FromCollection, WithHeadings, WithTransactions
{
    public function collection()
    {
        // Aquí puedes retornar una colección de datos que deseas exportar
    }

    public function headings(): array
    {
        // Define los encabezados de las columnas
        return [

            // Puedes agregar más encabezados según las columnas de tu modelo
        ];
    }

    public function transaction(): bool
    {
        // Establece si la transacción debe ejecutarse. Aquí puedes usar la transacción si es necesario.
        return true; // Retorna true para envolver en una transacción
    }
}
