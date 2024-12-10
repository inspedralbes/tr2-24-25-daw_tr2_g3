<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTransactions;
use Illuminate\Support\Facades\DB;

class MakeExport extends Command
{
    protected $signature = 'make:export {name}';
    protected $description = 'Crea una clase de exportación genérica de Excel con encabezados y transacciones';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $exportsPath = app_path('Exports');

        // Verifica si el directorio Exports existe y si no, lo crea
        if (!is_dir($exportsPath)) {
            mkdir($exportsPath, 0755, true);
        }

        $path = $exportsPath . '/' . $name . '.php';

        if ($this->files->exists($path)) {
            $this->error('La clase de exportación ya existe.');
            return;
        }

        $stub = $this->getStub($name);

        $this->files->put($path, $stub);

        $this->info("La clase de exportación $name ha sido creada en $path.");
    }

    protected function getStub($name)
    {
        return "<?php

namespace app\Exports;

use Maatwebsite\\Excel\\Concerns\\FromCollection;
use Maatwebsite\\Excel\\Concerns\\WithHeadings;
use Maatwebsite\\Excel\\Concerns\\WithTransactions;
use App\\Models\\Student; // O el modelo que estés utilizando
use Illuminate\\Support\\Facades\\DB;

class $name implements FromCollection, WithHeadings, WithTransactions
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
";
    }
}
