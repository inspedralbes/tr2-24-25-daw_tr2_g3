<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $queryFilters;

    /**
     * Recibe filtros para la consulta en el constructor.
     *
     * @param array $queryFilters
     */
    public function __construct(array $queryFilters = [])
    {
        $this->queryFilters = $queryFilters;
    }

    /**
     * Devuelve la colección de datos que deseas exportar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::query();

//        // Aplica los filtros dinámicos según los parámetros recibidos
//        if (isset($this->queryFilters['name'])) {
//            $query->where('name', 'like', '%' . $this->queryFilters['name'] . '%');
//        }
//
//        if (isset($this->queryFilters['email'])) {
//            $query->where('email', 'like', '%' . $this->queryFilters['email'] . '%');
//        }
//
//        if (isset($this->queryFilters['age_min'])) {
//            $query->where('age', '>=', $this->queryFilters['age_min']);
//        }
//
//        if (isset($this->queryFilters['age_max'])) {
//            $query->where('age', '<=', $this->queryFilters['age_max']);
//        }

        // Retorna solo las columnas necesarias
        return $query->select('name', 'email', 'age')->get();
    }

    /**
     * Define los encabezados de las columnas.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nombre',
            'Correo Electrónico',
            'Edad',
        ];
    }
}
