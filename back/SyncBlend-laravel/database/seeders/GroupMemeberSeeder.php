<?php

namespace Database\Seeders;

use App\Models\GroupMemeber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupMemeberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/groupMemebers.json';
        $json = file_get_contents($file_json);
        $groupMemebers = json_decode($json, true);
        foreach ($groupMemebers as $groupMemeber) {
            GroupMemeber::create([
                'group_id' => $groupMemeber['group_id'],
                'user_id' => $groupMemeber['user_id'],
                'role' => $groupMemeber['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
