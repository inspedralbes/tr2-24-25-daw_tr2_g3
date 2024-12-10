<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Maatwebsite\Excel\Concerns\ToEach;
use Illuminate\Support\Facades\DB;

class MakeImport extends Command
{
    protected $signature = 'make:import {name}';
    protected $description = 'Crea una clase de importación genérica de Excel con transacciones para procesar cada fila';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $importsPath = app_path('Imports');

        // Verifica si el directorio Imports existe y si no, lo crea
        if (!is_dir($importsPath)) {
            mkdir($importsPath, 0755, true);
        }

        $path = $importsPath . '/' . $name . '.php';

        if ($this->files->exists($path)) {
            $this->error('La clase de importación ya existe.');
            return;
        }

        $stub = $this->getStub($name);

        $this->files->put($path, $stub);

        $this->info("La clase de importación $name ha sido creada en $path.");
    }

    protected function getStub($name)
    {
        return "<?php

namespace app\Imports;

use Maatwebsite\\Excel\\Concerns\\ToEach;
use Illuminate\\Support\\Facades\\DB;
use App\\Models\\Student; // O el modelo que estés utilizando

class $name implements ToEach
{
    public function each(\$row)
    {
        // Envolvemos todo el procesamiento de cada fila en una transacción
        DB::transaction(function() use (\$row) {
            try {
                // Lógica para procesar la fila y guardar los datos en la base de datos

                // Puedes agregar más operaciones aquí, todo dentro de la transacción
            } catch (\Exception \$e) {
                // Si ocurre un error, la transacción será revertida automáticamente
                // Maneja el error, por ejemplo, registrando el error
                \Log::error('Error al procesar la fila: ', ['error' => \$e->getMessage(), 'row' => \$row]);
            }
        });
    }
}";
    }
}
