<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Valida los datos recibidos
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'to' => 'required|email',
        ]);

        // Envía el correo
        Mail::to($validatedData['to'])->send(new NotificationMail($validatedData['subject'], $validatedData['message']));

        return response()->json([
            'message' => 'Correo enviado con éxito'
        ]);
    }
}
