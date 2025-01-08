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
            $googleUser = Socialite::driver('google')->stateless()->user();


            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->user['given_name'],
                    'password' => bcrypt(''),
                    'photo_pic' => $googleUser->getAvatar(),
                    'lastname' => $googleUser->user['family_name'],
                ]
            );

            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->photo_pic,
                'token' => $token,
            ];

            return redirect()->to('http://localhost:5173/login/callback?user=' . urlencode(json_encode($userData)));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando la autenticación con Google.'], 500);
        }
    }
}
