<?php

require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendHTMLMail(
    $toEmail,
    $toName,
    $subject,
    $templateFile,
    $templateData = [],
) {
    $mail = new PHPMailer(true);

    try {
        $smtpHost= 'smtp.gmail.com';
        $smtpPort= 587;
        $smtpUsername= 'pranjal.gogoi983@gmail.com';
        $smtpPassword= 'your smtp password';
        $fromEmail= 'pranjal.gogoi983@gmail.com';
        $fromName= 'IITG Alumni Registration Portal';
        $smtpSecure = 'tls';
        $html = file_get_contents( __DIR__ .'/'. $templateFile);
        foreach ($templateData as $key => $value) {
            $html = str_replace('{{'.$key.'}}', $value, $html);
        }

        // SMTP Config
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUsername;
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = $smtpSecure;
        $mail->Port       = $smtpPort;

        // Mail Info
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $html;
        $mail->AltBody = strip_tags($html);

        $mail->send();

        return [
            'status' => true,
            'message' => 'Mail Sent Successfully'
        ];

    } catch (Exception $e) {
        return [
            'status' => false,
            'message' => $mail->ErrorInfo
        ];
    }
}
?>

