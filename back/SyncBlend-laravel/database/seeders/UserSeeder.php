<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_json = './resources/json/users.json';
            $json = file_get_contents($file_json);
            $users = json_decode($json, true);
            foreach ($users as $user) {
                User::create([
                    'name' => $user['name'],
                    'lastname' => $user['lastname'],
                    'photo_pic' => $user['photo_pic'],
                    'type_document' => $user['type_document'],
                    'id_document' => $user['id_document'],
                    'birthdate' => $user['birthdate'],
                    'email' => $user['email'],
                    'email_verified_at' => $user['email_verified_at'],
                    'password' => $user['password'],
                    'remember_token' => $user['rememberToken'],
                    'phone' => $user['phone'],
                    'address' => $user['address'],
                    'city' => $user['city'],
                    'province' => $user['province'],
                    'gender' => $user['gender'],
                    'postal_code' => $user['postal_code'],
                    'social_security_number' => $user['social_security_number'],
                    'nationality' => $user['nationality'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

    }
}
