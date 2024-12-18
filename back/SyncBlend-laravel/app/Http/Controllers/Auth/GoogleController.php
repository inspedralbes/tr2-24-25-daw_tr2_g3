<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Manejar el callback de Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
    
            // Aquí puedes guardar los datos del usuario en la base de datos o generar un token
            $userData = [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
                'token' => $user->token,
            ];
            
    
            // Redirigir al frontend con los datos del usuario y el token
            return redirect()->to('http://localhost:5173/login/callback?user=' . urlencode(json_encode($userData)));
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando la autenticación con Google.'], 500);
        }
    }
}
