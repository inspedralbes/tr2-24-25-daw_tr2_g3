<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatorController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['status' => 'success', 'message' => 'Credentials validated', 'token' => $token, 'user' => $user]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => 'success', 'message' => 'Logged out']);
    }

    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'username' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'type_document' => 'required',
                'id_document' => 'required', 
                'birthdate' => 'required',
            ],
            [
                'username.required' => 'El campo nombre es obligatorio',
                'lastname.required' => 'El campo apellido es obligatorio',
                'email.required' => 'El campo email es obligatorio',
                'email.email' => 'El campo email debe ser una dirección válida',
                'password.required' => 'El campo password es obligatorio',
                'type_document.required' => 'El campo tipo de documento es obligatorio',
                'id_document.required' => 'El campo documento de identidad es obligatorio',
                'birthdate.required' => 'El campo fecha de nacimiento es obligatorio'
            ]
        );

        try {
            $user = new User();
            $user->name = $data['username'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']); 
            $user->type_document = $data['type_document']; 
            $user->id_document = $data['id_document']; 
            $user->birthdate = $data['birthdate'];
            $user->photo_pic = 'https://cdn-icons-png.flaticon.com/512/4792/4792929.png';
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user);

            return response()->json(['status' => 'success', 'message' => 'User created', 'token' => $token, 'user' => $user]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
    }
}
