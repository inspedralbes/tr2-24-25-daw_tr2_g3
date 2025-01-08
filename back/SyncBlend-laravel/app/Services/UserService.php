<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createUser($newUser)
    {
        $user = new User();
        $user->name = $newUser['name'];
        $user->lastname= $newUser['last_name'];
        $user->email = $newUser['email'];
        $user->birthdate = $newUser['birthdate'];
        $user->type_document = $newUser['type_document'];
        $user->id_document = $newUser['id_document'];
        $user->password = $newUser['password'];
        $user->nationality = $newUser['nationality'];
        $user->postal_code = $newUser['postal_code'];
        $user->city = $newUser['city'];
        $user->province = $newUser['province'];
        $user->save();

        return $user;
    }

    public function checkIfUserExists($userData)
    {
        return User::where('email', '=', $userData['email'])->where('id_document', '=', $userData['id_document'])->first();
    }
}
