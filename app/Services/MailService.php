<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService {

    public function notify($data)
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = '';
            $mail->SMTPAuth = true;
            $mail->Username = '';
            $mail->Password = '';
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to
//            $mail->SMTPDebug  = 1;

            // Recipients
            $mail->setFrom('', 'starter');
            $mail->addAddress('', 'starter');

            // Content
            $mail->isHTML();
            $mail->Subject = $data['subject'];

            $mail->Body = view('email-templates.default', $data)->render();

            $mail->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}