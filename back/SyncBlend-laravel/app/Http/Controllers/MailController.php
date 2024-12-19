<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'to' => 'required|array',
            'to.*' => 'required|email', // Cada elemento del array debe ser un email válido
        ]);

        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = env("MAIL_HOST");
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME");
            $mail->Password = env("MAIL_PASSWORD");
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Opciones para evitar problemas de certificado (en entornos de desarrollo)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            // Remitente
            $mail->setFrom('info@syncblend.daw.inspedralbes.cat', 'SyncBlend App');

            // Agregar el destinatario principal (puedes dejarlo vacío si no hay uno principal)
            $mail->addAddress('info@syncblend.daw.inspedralbes.cat'); // Este puede ser tu dirección de control

            // Añadir cada destinatario como BCC (copia oculta)
            foreach ($validatedData['to'] as $recipient) {
                $mail->addBCC($recipient);
            }

            // Renderizar la vista del correo
            $htmlContent = View::make('email.notification', [
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'],
            ])->render();

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $validatedData['subject'];
            $mail->Body = $htmlContent;

            // Enviar el correo
            $mail->send();

            return response()->json([
                'message' => 'Email enviado correctamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => "Error al enviar el correo: {$mail->ErrorInfo}"
            ], 500);
        }
    }
}
