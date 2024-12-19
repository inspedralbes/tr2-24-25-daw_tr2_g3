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
        // Validate recibe data
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'to' => 'required|email',
        ]);

        // Configure php mailer to send emails
        $mail = new PHPMailer(true);

        try {
            // Configuration the SMTP server
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = env("MAIL_HOST");
            $mail->SMTPAuth = true;
            $mail->Username = env("MAIL_USERNAME"); // Email
            $mail->Password = env("MAIL_PASSWORD"); // Email password or token
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Options to avoid certificate problems (in development environments)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Sender
            $mail->setFrom('info@syncblend.daw.inspedralbes.cat', 'SyncBlend App');

            // Add a recipient for the data validates
            $mail->addAddress($validatedData['to']);

            // Render view mail
            $htmlContent = View::make('email.notification', [
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'],
            ])->render();

            // Mail content
            $mail->isHTML(true);
            $mail->Subject = $validatedData['subject'];
            $mail->Body = $htmlContent;

            $mail->send();

            return response()->json([
                'message' => 'Email send correctly'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => "Error to send email: {$mail->ErrorInfo}"
            ], 500);
        }
    }
}
