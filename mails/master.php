<?php

require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

require_once __DIR__ . '/../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendHTMLMail(
    $toEmail,
    $toName,
    $subject,
    $templateFile,
    $templateData = []
) {
    global $pdo;

    $mail = new PHPMailer(true);

    try {
        $stmt = $pdo->prepare("SELECT * FROM smtp_details LIMIT 1");
        $stmt->execute();
        $smtp = $stmt->fetch();

        if (!$smtp) {
            throw new \RuntimeException('SMTP details not found');
        }

        $smtpHost = $smtp['host'];
        $smtpPort = (int) $smtp['port'];
        $smtpUsername = $smtp['email'];
        $smtpPassword = $smtp['password'];
        $fromEmail = $smtp['from'];
        $fromName = $smtp['mail_name'];
        $smtpSecure = $smtp['smtp_secure'];

        $templatePath = __DIR__ . '/' . ltrim($templateFile, '/');
        if (!is_file($templatePath)) {
            throw new \RuntimeException('Mail template not found: ' . $templateFile);
        }

        $html = file_get_contents($templatePath);
        if ($html === false) {
            throw new \RuntimeException('Unable to read mail template: ' . $templateFile);
        }

        foreach ($templateData as $key => $value) {
            $html = str_replace('{{' . $key . '}}', (string) $value, $html);
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

    } catch (\Throwable $e) {
        return [
            'status' => false,
            'message' => $mail->ErrorInfo ?: $e->getMessage()
        ];
    }
}
