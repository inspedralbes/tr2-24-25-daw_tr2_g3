<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getProfile()
    {
        return response()->json(['data' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return response()->json(['data' => $user]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['error' => 'Contraseña actual incorrecta'], 400);
        }

        if ($request->newPassword !== $request->confirmPassword) {
            return response()->json(['error' => 'La confirmación de la contraseña no coincide'], 400);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['data' => 'Contraseña actualizada correctamente']);
    }
}