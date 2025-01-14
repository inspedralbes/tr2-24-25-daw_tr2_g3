<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function updateInfoPerson(Request $request)
    {

        // Buscar al usuario
        $user = User::find($request->id);

        // Actualizar la información del usuario
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->type_document = $request->type_document;
        $user->id_document = $request->id_document;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nationality = $request->nationality;
        $user->gender = $request->gender;
        $user->postal_code = $request->postal_code;
        $user->city = $request->city;
        $user->province = $request->province;
        $user->social_security_number = $request->social_security_number;
        $user->address = $request->address;
        $user->email_verified_at = $request->email_verified_at;

        // Manejo de la imagen
        if ($request->hasFile('photo_pic')) {
            // Guardar la imagen y actualizar el campo correspondiente
            $path = $request->file('photo_pic')->store('photos', 'public');
            $user->photo_pic = $path;
        }

        // Guardar el usuario actualizado
        $user->save();

        // Devolver la respuesta
        return response()->json(['data' => $user, 'message' => 'Usuario actualizado correctamente']);
    }

}
