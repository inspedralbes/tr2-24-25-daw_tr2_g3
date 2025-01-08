<?php

namespace Database\Seeders;

use App\Models\Response;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/responses.json';
        $json = file_get_contents($file_json);
        $responses = json_decode($json, true);
        foreach ($responses as $reponse) {
            Response::create([
                'id_user' => $reponse['id_user'],
                'id_question' => $reponse['id_question'],
                'answers' => json_encode($reponse['answers']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
