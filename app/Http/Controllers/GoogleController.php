<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
    
            // Aquí puedes guardar la información del usuario en tu base de datos
            // Si el usuario ya existe, actualiza su información
            // Si no existe, crea un nuevo usuario
    
            $token = $user->token;
            $refreshToken = $user->refreshToken;
            $expiresIn = $user->expiresIn;
    
            // Aquí puedes hacer solicitudes a la API de Google en nombre del usuario autenticado
            // Por ejemplo, para obtener la información del usuario:
            $googleUser = Socialite::driver('google')->userFromToken($token);
            $googleUserId = $googleUser->getId();
            $googleUserName = $googleUser->getName();
            $googleUserEmail = $googleUser->getEmail();
            // ...
    
            // Después de manejar la respuesta de Google, redirige al usuario a la página de perfil
            return redirect('/profile');
        } catch (Exception $e) {
            // Maneja las excepciones
            return redirect('/login');
        }
    }
    
}

