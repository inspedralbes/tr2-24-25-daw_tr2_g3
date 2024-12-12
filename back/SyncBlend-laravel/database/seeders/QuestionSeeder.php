<?php

namespace Database\Seeders;

use App\Models\Questions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/questions.json';
        $json = file_get_contents($file_json);
        $questions = json_decode($json, true);
        foreach ($questions as $question) {
            Questions::create([
                'group_id' => $question['group_id'],
                'question' => $question['question'],
                'answers' => $question['answers'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
