<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/forms.json';
        $json = file_get_contents($file_json);
        $forms = json_decode($json, true);
        foreach ($forms as $form) {
            Form::create([
                'group_id' => $form['group_id'],
                'name' => $form['name'],
                'slug' => $form['slug'],
                'code' => $form['code'],
                'description' => $form['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
