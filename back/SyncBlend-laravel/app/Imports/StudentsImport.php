<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class StudentsImport implements OnEachRow
{

    protected $errors = [];
    protected $validatedData = [];
    private $exampleRows = [];

    private $isFirstRowEmpty = false;

    public function __construct()
    {

    }
    public function onRow(Row $row)
    {

        if ($this->isFirstRowEmpty) {
            return;
        }

        if ($row->getRowIndex() === 1) {
            $cellValue = $row->getCellIterator()->current()->getValue(); // Obtenemos el valor de la primera celda (columna A)

            // Verificamos si la celda A1 está vacía
            if (empty($cellValue) || $this->isEmptyRow($row->toArray())) {
                $this->addError($row->getRowIndex(), "El formato de excel no respeta los estandares establecidos y no se puede procesar, el Excel debe empezar el encabezado en el 1A y seguir los siguientes con los datos.");
                $this->isFirstRowEmpty = true; // Marcamos que la primera fila está vacía
                return; // Detenemos la ejecución para no procesar más filas
            }
        }
        // TODO: Implement onRow() method.
        DB::transaction(function () use ($row) {
            $rowData = $row->toArray();

            if ($row->getIndex() === 1 || $this->isEmptyRow($rowData)) {
                return;
            }

            $userData = $this->extractUserData($rowData);
            $hasErrors = $this->validateRow($rowData, $userData, $row->getIndex());

            // Guardamos los datos validados para usarlos después
            if (empty($this->errors)) {
                $this->validatedData[] = $userData;
            }
        });
    }

    /**
     * Extrae los datos del usuario desde la fila
     *
     * @param array $rowData
     * @return array
     */
    private function extractUserData(array $rowData): array
    {
        return [
            'name' => $rowData[0],
            'last_name' => $rowData[1],
            'type_document' => $rowData[2],
            'id_document' => $rowData[3],
            'birthdate' => $rowData[4],
            'email' => $rowData[5],
            'email_verified_at' => $rowData[6]
        ];
    }

    // Nuevo método para procesar la inserción
    public function processImport()
    {
        if (!empty($this->errors)) {
            return false;
        }

        DB::transaction(function () {
            foreach ($this->validatedData as $userData) {
                try {
                    //logic to insert studetns here
                } catch (\Exception $e) {
                    throw $e;
                }
            }
        });

        return true;
    }

    /**
     * Realiza las validaciones necesarias en la fila de datos
     *
     * @param array $rowData
     * @param array $userData
     * @param int $rowIndex
     * @return bool
     */
    private function validateRow(array $rowData, array $userData, int $rowIndex): bool
    {
        $hasErrors = false;

        // Validaciones básicas
        $hasErrors |= $this->validateRequiredFields($userData, $rowIndex);

        return $hasErrors;
    }

    private function validateRequiredFields($userData, $rowIndex)
    {
        $hasErrors = false;

        if (empty($userData['name'])) {
            $this->addError($rowIndex, "El nombre del alumno es requerido");
            $hasErrors = true;
        }

        if (empty($userData['last_name'])) {
            $this->addError($rowIndex, "El apellido del alumno es requerido");
            $hasErrors = true;
        }

        if (empty($userData['email'])) {
            $this->addError($rowIndex, "El mail del cliente es requerido");
            $hasErrors = true;
        }

        if (empty($userData['type_document'])) {
            $this->addError($rowIndex, "El tipo de documento es requerido");
            $hasErrors = true;
        }

        if (empty($userData['id_document'])) {
            $this->addError($rowIndex, "El documento del cliente es requerido");
            $hasErrors = true;
        }

        return $hasErrors;
    }

    /**
     * Agrega un error al array de errores
     *
     * @param int $rowIndex
     * @param string $message
     * @return void
     */
    private function addError(int $rowIndex, string $message): void
    {
        $this->errors[] = [
            'row' => $rowIndex,
            'message' => $message,
        ];
        \Log::warning("Error on row {$rowIndex}: {$message}");
    }

    /**
     * Verifica si una fila está vacía
     *
     * @param array $rowData
     * @return bool
     */
    private function isEmptyRow(array $rowData): bool
    {
        return empty(array_filter($rowData, fn($value) => !is_null($value) && $value !== ''));
    }

    /**
     * Devuelve los errores encontrados
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
