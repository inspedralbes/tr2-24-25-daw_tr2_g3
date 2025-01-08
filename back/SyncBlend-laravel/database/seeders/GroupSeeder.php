<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/groups.json';
        $json = file_get_contents($file_json);
        $groups = json_decode($json, true);
        foreach ($groups as $group) {
            Group::create([
                'id_parent' => $group['id_parent'],
                'code' => $group['code'],
                'course' => $group['course'],
                'letter' => $group['letter'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}

