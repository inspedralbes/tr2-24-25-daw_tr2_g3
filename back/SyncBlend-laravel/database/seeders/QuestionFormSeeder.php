<?php

namespace Database\Seeders;

use App\Models\QuestionForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/questionsForms.json';
        $json = file_get_contents($file_json);
        $questionsForm = json_decode($json, true);
        foreach ($questionsForm as $question) {
            QuestionForm::create([
                'id_question' => $question['id_question'],
                'id_form' => $question['id_form'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
